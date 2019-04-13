<?php

namespace app\home\controller;

use think\Lang;

class Cart extends BaseMember {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/cart.lang.php');
    }
    
    
    function index()
    {
        $cart_model = model('cart');
        $logic_buy_1 = model('buy_1','logic');

        //购物车列表
        $cart_list = $cart_model->getCartList('db', array('buyer_id' => session('member_id')));

        //购物车列表 [得到最新商品属性及促销信息] 
        $cart_list = $logic_buy_1->getGoodsCartList($cart_list);

        //购物车商品以店铺ID分组显示,并计算商品小计,店铺小计与总价由JS计算得出
        $store_cart_list = array();
        foreach ($cart_list as $cart) {
            $cart['goods_total'] = ds_price_format($cart['goods_price'] * $cart['goods_num']);
            $store_cart_list[$cart['store_id']][] = $cart;
        }
        $this->assign('store_cart_list', $store_cart_list);

        //店铺信息
        $store_list = model('store')->getStoreMemberIDList(array_keys($store_cart_list));
        $this->assign('store_list', $store_list);

        //取得店铺级活动 - 可用的满即送活动
        $mansong_rule_list = $logic_buy_1->getMansongruleList(array_keys($store_cart_list));
        $this->assign('mansong_rule_list', $mansong_rule_list);

        //取得哪些店铺有满免运费活动
        $free_freight_list = $logic_buy_1->getFreeFreightActiveList(array_keys($store_cart_list));
        $this->assign('free_freight_list', $free_freight_list);

        //标识 购买流程执行第几步
        $this->assign('buy_step', 'step1');
        return $this->fetch(empty($cart_list) ? $this->template_dir .'cart_empty' : $this->template_dir .'cart');
    }


    /**
     * 异步查询购物车
     */
    public function ajax_load() {

        if(session('member_id')){
            $cart_map = array(
                'buyer_id' => session('member_id'),
            );
            $cart_mod=model('cart');
            $cart_list = $cart_mod->getCartList('db',$cart_map);
        }else{
            $cart_str = get_magic_quotes_gpc() ? stripslashes(cookie('cart')) : cookie('cart');
            $cart_str = base64_decode(ds_decrypt($cart_str));
            $cart_list = @unserialize($cart_str);
        }
        $cart_array = array();
        $cart_all_price = 0;
        $cart_goods_num = 0;
        if (!empty($cart_list)) {
            foreach ($cart_list as $k => $cart) {
                $cart_array['list'][$k]['cart_id'] = isset($cart['cart_id'])?$cart['cart_id']:$cart['goods_id'];
                $cart_array['list'][$k]['goods_id'] = $cart['goods_id'];
                $cart_array['list'][$k]['goods_name'] = $cart['goods_name'];
                $cart_array['list'][$k]['goods_price'] = $cart['goods_price'];
                $cart_array['list'][$k]['goods_image'] = goods_thumb($cart, 240);
                $cart_array['list'][$k]['goods_num'] = $cart['goods_num'];
                $cart_array['list'][$k]['goods_url'] = url('Goods/index', ['goods_id' => $cart['goods_id']]);
                $cart_all_price += $cart['goods_price'] * $cart['goods_num'];
                $cart_goods_num ++;
            }
        }
        $cart_array['cart_all_price'] = $cart_all_price;
        $cart_array['cart_goods_num'] = $cart_goods_num;
        if (input('param.type') == 'html') {
            $this->assign('cart_list',$cart_array);
            echo $this->fetch($this->template_dir.'cart_mini');
        }else{
        $json_data = json_encode($cart_array);
        exit($json_data);
        }
    }

    /**
     * 加入购物车，登录后存入购物车表
     * 存入COOKIE，由于COOKIE长度限制，最多保存5个商品
     * 未登录不能将优惠套装商品加入购物车，登录前保存的信息以goods_id为下标
     *
     */
    function add() {
        $goods_model = model('goods');
        $logic_buy_1 =  model('buy_1','logic');
        $goods_id = intval(input('param.goods_id'));
        $quantity = intval(input('param.quantity'));
        $bl_id = intval(input('param.bl_id'));
        if (is_numeric($goods_id) && $goods_id>0) {
            //商品加入购物车(默认)
            if ($goods_id <= 0)
                return;
            $goods_info = $goods_model->getGoodsOnlineInfoAndPromotionById($goods_id);

            //抢购
            $logic_buy_1->getGroupbuyInfo($goods_info, $quantity);

            //限时折扣
            $logic_buy_1->getXianshiInfo($goods_info, $quantity);
            
            //会员等级折扣
            $logic_buy_1->getMgdiscountInfo($goods_info);

            $this->_check_goods($goods_info, $quantity);
        } elseif (is_numeric($bl_id)&& $bl_id>0 ) {
            //优惠套装加入购物车(单套)
            if (!session('member_id')) {
                exit(json_encode(array('msg' => lang('please_login_first'), 'UTF-8')));
            }
            if ($bl_id <= 0)
                return;
            $pbundling_model = model('pbundling');
            $bl_info = $pbundling_model->getBundlingInfo(array('bl_id' => $bl_id));
            if (empty($bl_info) || $bl_info['bl_state'] == '0') {
                exit(json_encode(array('msg' => lang('recommendations_buy_separately'), 'UTF-8')));
            }

            //检查每个商品是否符合条件,并重新计算套装总价
            $bl_goods_list = $pbundling_model->getBundlingGoodsList(array('bl_id' => $bl_id));
            $goods_id_array = array();
            $bl_amount = 0;
            foreach ($bl_goods_list as $goods) {
                $goods_id_array[] = $goods['goods_id'];
                $bl_amount += $goods['blgoods_price'];
            }
            $goods_model = model('goods');
            $goods_list = $goods_model->getGoodsOnlineListAndPromotionByIdArray($goods_id_array);
            foreach ($goods_list as $goods) {
                $this->_check_goods($goods, 1);
            }

            //优惠套装作为一条记录插入购物车，图片取套装内的第一个商品图
            $goods_info = array();
            $goods_info['store_id'] = $bl_info['store_id'];
            $goods_info['goods_id'] = $goods_list[0]['goods_id'];
            $goods_info['goods_name'] = $bl_info['bl_name'];
            $goods_info['goods_price'] = $bl_amount;
            $goods_info['goods_num'] = 1;
            $goods_info['goods_image'] = $goods_list[0]['goods_image'];
            $goods_info['store_name'] = $bl_info['store_name'];
            $goods_info['bl_id'] = $bl_id;
            $quantity = 1;
        }

        //已登录状态，存入数据库,未登录时，存入COOKIE
        if (session('member_id')) {
            $save_type = 'db';
            $goods_info['buyer_id'] = session('member_id');
        } else {
            $save_type = 'cookie';
        }
        $cart_model = model('cart');
        $insert = $cart_model->addCart($goods_info, $save_type, $quantity);
        if ($insert) {
            $data = array('state' => 'true', 'num' => $cart_model->cart_goods_num, 'amount' => ds_price_format($cart_model->cart_all_price));
        } else {
            $data = array('state' => 'false');
        }
        exit(json_encode($data));
    }

    /**
     * 推荐组合加入购物车
     */
    public function add_comb() {
        if (!preg_match('/^[\d|]+$/', input('get.goods_ids'))) {
            exit(json_encode(array('state' => 'false')));
        }

        $logic_buy_1 =  model('buy_1','logic');

        if (!session('member_id')) {
            exit(json_encode(array('msg' => lang('please_login_first'), 'UTF-8')));
        }

        $goods_id_array = explode('|', input('get.goods_ids'));

        $goods_model = model('goods');
        $goods_list = $goods_model->getGoodsOnlineListAndPromotionByIdArray($goods_id_array);

        if(empty($goods_list)){
            exit(json_encode(array('state' => 'false')));
        }
        
        foreach ($goods_list as $goods) {
            $this->_check_goods($goods, 1);
        }

        //抢购
        $logic_buy_1->getGroupbuyCartList($goods_list);

        //限时折扣
        $logic_buy_1->getXianshiCartList($goods_list);

        $cart_model = model('cart');
        foreach ($goods_list as $goods_info) {
            $cart_info = array();
            $cart_info['store_id'] = $goods_info['store_id'];
            $cart_info['goods_id'] = $goods_info['goods_id'];
            $cart_info['goods_name'] = $goods_info['goods_name'];
            $cart_info['goods_price'] = $goods_info['goods_price'];
            $cart_info['goods_num'] = 1;
            $cart_info['goods_image'] = $goods_info['goods_image'];
            $cart_info['store_name'] = $goods_info['store_name'];
            $quantity = 1;
            //已登录状态，存入数据库,未登录时，存入COOKIE
            if (session('member_id')) {
                $save_type = 'db';
                $cart_info['buyer_id'] = session('member_id');
            } else {
                $save_type = 'cookie';
            }
            $insert = $cart_model->addCart($cart_info, $save_type, $quantity);
            if ($insert) {
                //购物车商品种数记入cookie
                cookie('cart_goods_num', $cart_model->cart_goods_num, 2 * 3600);
                $data = array('state' => 'true', 'num' => $cart_model->cart_goods_num, 'amount' => ds_price_format($cart_model->cart_all_price));
            } else {
                $data = array('state' => 'false');
                exit(json_encode($data));
            }
        }
        exit(json_encode($data));
    }

    /**
     * 检查商品是否符合加入购物车条件
     * @param unknown $goods
     * @param number $quantity
     */
    private function _check_goods($goods_info, $quantity) {
        if (empty($quantity)) {
            exit(json_encode(array('msg' => lang('wrong_argument'))));
        }
        if (empty($goods_info)) {
            exit(json_encode(array('msg' => lang('cart_add_goods_not_exists'))));
        }

        if ($goods_info['store_id'] == session('store_id')) {
            exit(json_encode(array('msg' => lang('cart_add_cannot_buy'))));
        }
        if (intval($goods_info['goods_storage']) < 1) {
            exit(json_encode(array('msg' => lang('cart_add_stock_shortage'))));
        }
        if (intval($goods_info['goods_storage']) < $quantity) {
            exit(json_encode(array('msg' => lang('cart_add_too_much'))));
        }

        if ($goods_info['is_virtual'] || $goods_info['is_goodsfcode'] || $goods_info['is_presell']) {
            exit(json_encode(array('msg' => lang('please_purchase_directly'), 'UTF-8')));
        }

    }

    /**
     * 购物车更新商品数量
     */
    public function update() {
        $cart_id = intval(abs(input('get.cart_id')));
        $quantity = intval(abs(input('get.quantity')));

        if (empty($cart_id) || empty($quantity)) {
            exit(json_encode(array('msg' => lang('cart_update_buy_fail'))));
        }

        $cart_model = model('cart');
        $goods_model = model('goods');
        $logic_buy_1 =  model('buy_1','logic');

        //存放返回信息
        $return = array();

        $cart_info = $cart_model->getCartInfo(array('cart_id' => $cart_id, 'buyer_id' => session('member_id')));
        if ($cart_info['bl_id'] == '0') {

            //普通商品
            $goods_id = intval($cart_info['goods_id']);
            $goods_info = $logic_buy_1->getGoodsOnlineInfo($goods_id, $quantity);
            if (empty($goods_info)) {
                $return['state'] = 'invalid';
                $return['msg'] = lang('merchandise_off_shelves');
                $return['subtotal'] = 0;
                \mall\queue\QueueClient::push('delCart', array('buyer_id' => session('member_id'), 'cart_ids' => array($cart_id)));
                exit(json_encode($return));
            }
            
//            //抢购
//            $logic_buy_1->getGroupbuyInfo($goods_info, $quantity);
//            //限时折扣
//            $logic_buy_1->getXianshiInfo($goods_info, $quantity);
            
            $quantity = $goods_info['goods_num'];

            if (intval($goods_info['goods_storage']) < $quantity) {
                $return['state'] = 'shortage';
                $return['msg'] = lang('cart_add_too_much');
                $return['goods_num'] = $goods_info['goods_num'];
                $return['goods_price'] = $goods_info['goods_price'];
                $return['subtotal'] = $goods_info['goods_price'] * $quantity;
                $cart_model->editCart(array('goods_num' => $goods_info['goods_storage']), array('cart_id' => $cart_id, 'buyer_id' => session('member_id')));
                exit(json_encode($return));
            }
        } else {

            //优惠套装商品
            $pbundling_model = model('pbundling');
            $bl_goods_list = $pbundling_model->getBundlingGoodsList(array('bl_id' => $cart_info['bl_id']));
            $goods_id_array = array();
            foreach ($bl_goods_list as $goods) {
                $goods_id_array[] = $goods['goods_id'];
            }
            $goods_list = $goods_model->getGoodsOnlineListAndPromotionByIdArray($goods_id_array);

            //如果其中有商品下架，删除
            if (count($goods_list) != count($goods_id_array)) {
                $return['state'] = 'invalid';
                $return['msg'] = lang('wheatsuit_no_longer_valid');
                $return['subtotal'] = 0;
                \mall\queue\QueueClient::push('delCart', array('buyer_id' => session('member_id'), 'cart_ids' => array($cart_id)));
                exit(json_encode($return));
            }

            //如果有商品库存不足，更新购买数量到目前最大库存
            foreach ($goods_list as $goods_info) {
                if ($quantity > $goods_info['goods_storage']) {
                    $return['state'] = 'shortage';
                    $return['msg'] = lang('preferential_suit_understock');
                    $return['goods_num'] = $goods_info['goods_storage'];
                    $return['goods_price'] = $cart_info['goods_price'];
                    $return['subtotal'] = $cart_info['goods_price'] * $quantity;
                    $cart_model->editCart(array('goods_num' => $goods_info['goods_storage']), array('cart_id' => $cart_id, 'buyer_id' => session('member_id')));
                    exit(json_encode($return));
                    break;
                }
            }
            $goods_info['goods_price'] = $cart_info['goods_price'];
        }

        $data = array();
        $data['goods_num'] = $quantity;
        $data['goods_price'] = $goods_info['goods_price'];
        $update = $cart_model->editCart($data, array('cart_id' => $cart_id, 'buyer_id' => session('member_id')));
        if ($update) {
            $return = array();
            $return['state'] = 'true';
            $return['subtotal'] = $goods_info['goods_price'] * $quantity;
            $return['goods_price'] = $goods_info['goods_price'];
            $return['goods_num'] = $quantity;
        } else {
            $return = array('msg' => lang('cart_update_buy_fail'));
        }
        exit(json_encode($return));
    }


    /**
     * 购物车删除单个商品，未登录前使用cart_id即为goods_id
     */
    public function del() {
        $cart_id = intval(input('get.cart_id'));
        if ($cart_id < 0)
            return;
        $cart_model = model('cart');
        $data = array();
        if (session('member_id')) {
            //登录状态下删除数据库内容
            $delete = $cart_model->delCart('db', array('cart_id' => $cart_id, 'buyer_id' => session('member_id')));
            if ($delete) {
                $data['state'] = 'true';
                $data['quantity'] = $cart_model->cart_goods_num;
                $data['amount'] = $cart_model->cart_all_price;
            } else {
                $data['msg'] = lang('cart_drop_del_fail');
            }
        } else {
            //未登录时删除cookie的购物车信息
            $delete = $cart_model->delCart('cookie', array('goods_id' => $cart_id));
            if ($delete) {
                $data['state'] = 'true';
                $data['quantity'] = $cart_model->cart_goods_num;
                $data['amount'] = $cart_model->cart_all_price;
            }
        }
        cookie('cart_goods_num', $cart_model->cart_goods_num, 2 * 3600);
        $json_data = json_encode($data);
//        if (isset($_GET['callback'])) {
//            $json_data = $_GET['callback'] == '?' ? '(' . $json_data . ')' : $_GET['callback'] . "($json_data);";
//        }
        exit($json_data);
    }

}
