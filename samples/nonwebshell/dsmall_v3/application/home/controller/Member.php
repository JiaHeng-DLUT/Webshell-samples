<?php

namespace app\home\controller;

use think\Lang;

class Member extends BaseMember {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/member.lang.php');
    }

    public function index() {
        //获取用户账号信息
        $member_info = $this->member_info;
        $member_info['security_level'] = model('member')->getMemberSecurityLevel($member_info);

        //代金券数量
        $member_info['voucher_count'] = model('voucher')->getCurrentAvailableVoucherCount(session('member_id'));
        $this->assign('home_member_info', $member_info);
        //获取订单信息
        $order_list=array();
        $order_model = model('order');
        $refundreturn_model = model('refundreturn');
        $order_list['order_nopay_count'] = $order_model->getOrderCountByID('buyer', session('member_id'), 'NewCount');
        $order_list['order_noreceipt_count'] = $order_model->getOrderCountByID('buyer', session('member_id'), 'SendCount');
        $order_list['order_noeval_count'] = $order_model->getOrderCountByID('buyer', session('member_id'), 'EvalCount');
        $order_list['order_noship_count'] = $order_model->getOrderCountByID('buyer', session('member_id'), 'PayCount');
        $order_list['order_refund_count'] = $refundreturn_model->getRefundreturnCount(array('buyer_id'=>session('member_id'),'refund_state'=>array('<>',3)));
        
        $this->assign('home_order_info', $order_list);
        
        
        
        
        /* 设置买家当前菜单 */
        $this->setMemberCurMenu('selleralbum');
        /* 设置买家当前栏目 */
        $this->setMemberCurItem('my_album');
        return $this->fetch($this->template_dir . 'index');
    }


    public function ajax_load_order_info() {
        //取出购物车信息
        $cart_model = model('cart');
        $cart_list = $cart_model->getCartList('db', array('buyer_id' => session('member_id')), 3);
        $this->assign('cart_list', $cart_list);
        return $this->fetch($this->template_dir . 'order_info');
    }
    public function ajax_load_point_info(){
                //开启代金券功能后查询推荐的热门代金券列表
        if (config('voucher_allow') == 1){
            $recommend_voucher = model('voucher')->getRecommendTemplate(2);
            $this->assign('recommend_voucher',$recommend_voucher);
        }
        //开启积分兑换功能后查询推荐的热门兑换商品列表
        if (config('pointprod_isuse') == 1){
            //热门积分兑换商品
            $recommend_pointsprod = model('pointprod')->getRecommendPointProd(2);
            $this->assign('recommend_pointsprod',$recommend_pointsprod);
        }
        return $this->fetch($this->template_dir . 'point_info');
    }
    public function ajax_load_goods_info() {
        //商品收藏
        $favorites_model = model('favorites');
        $favorites_list = $favorites_model->getGoodsFavoritesList(array('member_id' => session('member_id')), '*', 7);
        if (!empty($favorites_list) && is_array($favorites_list)) {
            $favorites_id = array(); //收藏的商品编号
            foreach ($favorites_list as $key => $favorites) {
                $fav_id = $favorites['fav_id'];
                $favorites_id[] = $favorites['fav_id'];
                $favorites_key[$fav_id] = $key;
            }
            $goods_model = model('goods');
            $field = 'goods.goods_id,goods.goods_name,goods.store_id,goods.goods_image,goods.goods_price,goods.evaluation_count,goods.goods_salenum,goods.goods_collect,store.store_name,store.member_id,store.member_name,store.store_qq,store.store_ww';
            $goods_list = $goods_model->getGoodsStoreList(array('goods_id' => array('in', $favorites_id)), $field);
            $store_array = array(); //店铺编号
            if (!empty($goods_list) && is_array($goods_list)) {
                $store_goods_list = array(); //店铺为分组的商品
                foreach ($goods_list as $key => $fav) {
                    $fav_id = $fav['goods_id'];
                    $fav['goods_member_id'] = $fav['member_id'];
                    $key = $favorites_key[$fav_id];
                    $favorites_list[$key]['goods'] = $fav;
                }
            }
        }
        $this->assign('favorites_list', $favorites_list);

        //店铺收藏
        $favorites_list = $favorites_model->getStoreFavoritesList(array('member_id' => session('member_id')), '*', 6);
        if (!empty($favorites_list) && is_array($favorites_list)) {
            $favorites_id = array(); //收藏的店铺编号
            foreach ($favorites_list as $key => $favorites) {
                $fav_id = $favorites['fav_id'];
                $favorites_id[] = $favorites['fav_id'];
                $favorites_key[$fav_id] = $key;
            }
            $store_model = model('store');
            $store_list = $store_model->getStoreList(array('store_id' => array('in', $favorites_id)));
            if (!empty($store_list) && is_array($store_list)) {
                foreach ($store_list as $key => $fav) {
                    $fav_id = $fav['store_id'];
                    $key = $favorites_key[$fav_id];
                    $favorites_list[$key]['store'] = $fav;
                }
            }
        }
        $this->assign('favorites_store_list', $favorites_list);
        $goods_count_new = array();
        if (!empty($favorites_id)) {
            foreach ($favorites_id as $v) {
                $count = model('goods')->getGoodsCommonOnlineCount(array('store_id' => $v));
                $goods_count_new[$v] = $count;
            }
        }
        $this->assign('goods_count', $goods_count_new);
        return $this->fetch($this->template_dir . 'goods_info');
    }

    public function ajax_load_sns_info() {
        //我的足迹
        $goods_list = model('goodsbrowse')->getViewedGoodsList(session('member_id'), 20);
        $viewed_goods = array();
        if (is_array($goods_list) && !empty($goods_list)) {
            foreach ($goods_list as $key => $val) {
                $goods_id = $val['goods_id'];
                $val['url'] = url('Goods/index',['goods_id'=>$goods_id]);
                $val['goods_image'] = goods_thumb($val, 240);
                $viewed_goods[$goods_id] = $val;
            }
        }
        $this->assign('viewed_goods', $viewed_goods);
        return $this->fetch($this->template_dir . 'sns_info');
    }
}

?>
