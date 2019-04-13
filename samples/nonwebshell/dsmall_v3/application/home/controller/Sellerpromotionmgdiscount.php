<?php

namespace app\home\controller;

use think\Lang;
use think\Db;
class Sellerpromotionmgdiscount extends BaseSeller
{

    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellerpromotionmgdiscount.lang.php');
        if (intval(config('mgdiscount_allow')) !== 1) {
            $this->error(lang('mgdiscount_unavailable'), 'seller/index');
        }
    }

    /**
     * 店铺的基本设置
     */
    public function mgdiscount_store()
    {


        $mgdiscountquota_model = model('pmgdiscountquota');
        //当前的和系统设置的会员等级进行比对
        if (!request()->isPost()) {
            if (check_platform_store()) {
                $this->assign('isPlatformStore', true);
            } else {
                $current_mgdiscount_quota = $mgdiscountquota_model->getMgdiscountquotaCurrent(session('store_id'));
                $this->assign('current_mgdiscount_quota', $current_mgdiscount_quota);
            }
            //当前店铺设置的会员等级对应的折扣
            $store = db('store')->where('store_id', session('store_id'))->find();
            $this->assign('mgdiscount_store_arr', $this->_get_mgdiscount_arr($store['store_mgdiscount']));
            $this->assign('store', $store);

            $this->setSellerCurMenu('Sellermgdiscount');
            $this->setSellerCurItem('mgdiscount_store');
            return $this->fetch($this->template_dir . 'mgdiscount_store');
        } else {

            $member_model = model('member');
            //系统等级设置
            $membergrade_arr = $member_model->getMemberGradeArr();

            
            $result_1 = array();
            $pre_level_discount = 0;
            foreach ($membergrade_arr as $key => $value) {
                $current_level_discount = intval($_POST['mgdiscount_store'][$key]['level_discount'] * 10);
                
                //限制会员等级高的会员享受更低折扣
                if($pre_level_discount==0){
                    $pre_level_discount = $current_level_discount;
                }
                if($current_level_discount>$pre_level_discount){
                    ds_json_encode(10001,$value['level_name'].'的折扣应小于或等于'.($pre_level_discount/10).'折');
                }
                $pre_level_discount = $current_level_discount;
                    
                if ($current_level_discount < 1 || $current_level_discount > 100) {
                    ds_json_encode(10001,'输入的折扣不正确');
                }
                
                $result_1[$key]['level_discount'] = $current_level_discount / 10;
                $result_1[$key]['level_name'] = $value['level_name'];
            }
            
            $data = array(
                'store_mgdiscount'=>serialize($result_1),
                'store_mgdiscount_state'=> intval(input('post.store_mgdiscount_state'))
            );
            $result = db('store')->where('store_id', session('store_id'))->update($data);
            if ($result){
                ds_json_encode(10001,'店铺会员折扣设置成功');
            }
        }
    }

    //显示不同商品享受的会员等级折扣
    public function mgdiscount_goods()
    {

        $goods_model = model('goods');
        $condition['goods_mgdiscount'] = array('neq', '');
		$condition['store_id'] = session('store_id');
        $goods_list = $goods_model->getGoodsCommonOnlineList($condition);

        foreach ($goods_list as $key => $goods) {
            $goods_list[$key]['goods_mgdiscount_arr'] = $this->_get_mgdiscount_arr($goods['goods_mgdiscount']);
        }


        $this->assign('show_page', $goods_model->page_info->render());
        $this->assign('goods_list', $goods_list);

        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('Sellermgdiscount');
        $this->setSellerCurItem('mgdiscount_goods');
        return $this->fetch($this->template_dir . 'mgdiscount_goods');
    }

    /**
     * 通过系统会员等级和现有数据比对得出数值
     * @param type $mgdiscount_arr_temp
     * @return type
     */
    private function _get_mgdiscount_arr($mgdiscount_arr_temp)
    {
        $mgdiscount_arr_temp = @unserialize($mgdiscount_arr_temp);

        $member_model = model('member');
        //系统等级设置
        $membergrade_arr = $member_model->getMemberGradeArr();

        $mgdiscount_arr = array();
        foreach ($membergrade_arr as $key => $value) {
            $mgdiscount_arr[$key] = $value;
            $mgdiscount_arr[$key]['level_discount'] = isset($mgdiscount_arr_temp[$key]['level_discount'])?$mgdiscount_arr_temp[$key]['level_discount']:10;
        }
        return $mgdiscount_arr;
    }

    //新增现有商品的折扣
    public function mgdiscount_goods_add()
    {
        $member_model = model('member');
        //系统等级设置
        $membergrade_arr = $member_model->getMemberGradeArr();
        if (!request()->isPost()) {
            $this->assign('mgdiscount_goods_arr', $membergrade_arr);

            $this->setSellerCurMenu('Sellermgdiscount');
            $this->setSellerCurItem('mgdiscount_goods_add');
            return $this->fetch($this->template_dir . 'mgdiscount_goods_add');
        } else {


            if (!check_platform_store()) {
                //获取当前套餐
                $mgdiscountquota_model = model('pmgdiscountquota');
                $current_mgdiscount_quota = $mgdiscountquota_model->getMgdiscountquotaCurrent(session('store_id'));
                if (empty($current_mgdiscount_quota)) {
                    ds_json_encode(10001,'没有可用会员等级折扣套餐,请先购买套餐');
                }
                $quota_start_time = intval($current_mgdiscount_quota['mgdiscountquota_starttime']);
                $quota_end_time = intval($current_mgdiscount_quota['mgdiscountquota_endtime']);
                if (TIMESTAMP < $quota_start_time) {
                    ds_json_encode(10001,sprintf(lang('mgdiscount_add_start_time_explain'), date('Y-m-d', $current_mgdiscount_quota['mgdiscountquota_starttime'])));
                }
                if (TIMESTAMP > $quota_end_time) {
                    ds_json_encode(10001,sprintf(lang('mgdiscount_add_end_time_explain'), date('Y-m-d', $current_mgdiscount_quota['mgdiscountquota_endtime'])));
                }
            }

            //获取提交的数据
            $goods_id = intval(input('post.mgdiscount_goods_id'));
            if (empty($goods_id)) {
                ds_json_encode(10001,lang('param_error'));
            }
            $goods_model = model('goods');
            $goods_info = $goods_model->getGoodsInfoByID($goods_id);
            if (empty($goods_info) || $goods_info['store_id'] != session('store_id')) {
                ds_json_encode(10001,lang('param_error'));
            }


            $data = array();
            $pre_level_discount = 0;
            foreach ($membergrade_arr as $key => $value) {
                $current_level_discount = intval($_POST['mgdiscount_goods'][$key]['level_discount'] * 10);
                
                //限制会员等级高的会员享受更低折扣
                if($pre_level_discount==0){
                    $pre_level_discount = $current_level_discount;
                }
                if($current_level_discount>$pre_level_discount){
                    ds_json_encode(10001,$value['level_name'].'的折扣应小于或等于'.($pre_level_discount/10).'折');
                }
                $pre_level_discount = $current_level_discount;
                
                if ($current_level_discount < 1 || $current_level_discount > 100) {
                    ds_json_encode(10001,'输入的折扣不正确');
                }
                $data[$key]['level_discount'] = $current_level_discount / 10;
                $data[$key]['level_name'] = $value['level_name'];
            }

            $condition = array();
            $condition['goods_commonid'] = $goods_info['goods_commonid'];
            $result = $goods_model->editGoodscommon(array('goods_mgdiscount' => serialize($data)), $condition);
            $result1 = $goods_model->editGoods(array('goods_mgdiscount' => serialize($data)), $condition);
            

            if ($result&&$result1) {
                $this->recordSellerlog('添加会员等级折扣，公共商品ID：' . $goods_info['goods_commonid']);
                ds_json_encode(10000,lang('mgdiscount_add_success'));
            } else {
                ds_json_encode(10001,lang('mgdiscount_add_fail'));
            }
        }
    }

    function mgdiscount_goods_edit()
    {
        //获取提交的数据
        $goods_commonid = intval(input('param.goods_commonid'));
        if (empty($goods_commonid)) {
            ds_json_encode(10001,lang('param_error'));
        }

        $goods_model = model('goods');
        $goodscommon_info = $goods_model->getGoodeCommonInfoByID($goods_commonid);
        if (empty($goodscommon_info) || $goodscommon_info['store_id'] != session('store_id')) {
            ds_json_encode(10001,'您的商品不存在，或商品已被锁定，请联系管理员删除抢购解除锁定');
        }

        if (!request()->isPost()) {
            $this->assign('goodscommon_info', $goodscommon_info);
            $this->assign('mgdiscount_goods_arr', $this->_get_mgdiscount_arr($goodscommon_info['goods_mgdiscount']));

            $this->setSellerCurMenu('Sellermgdiscount');
            $this->setSellerCurItem('mgdiscount_goods_add');
            return $this->fetch($this->template_dir . 'mgdiscount_goods_add');
        } else {

            if (!check_platform_store()) {
                //获取当前套餐
                $mgdiscountquota_model = model('pmgdiscountquota');
                $current_mgdiscount_quota = $mgdiscountquota_model->getMgdiscountquotaCurrent(session('store_id'));
                if (empty($current_mgdiscount_quota)) {
                    ds_json_encode(10001,'没有可用会员等级折扣套餐,请先购买套餐');
                }
                $quota_start_time = intval($current_mgdiscount_quota['mgdiscountquota_starttime']);
                $quota_end_time = intval($current_mgdiscount_quota['mgdiscountquota_endtime']);
                if ($quota_start_time < $quota_start_time) {
                    ds_json_encode(10001,sprintf(lang('mgdiscount_add_start_time_explain'), date('Y-m-d', $current_mgdiscount_quota['mgdiscountquota_starttime'])));
                }
                if ($quota_start_time > $quota_end_time) {
                    ds_json_encode(10001,sprintf(lang('mgdiscount_add_end_time_explain'), date('Y-m-d', $current_mgdiscount_quota['mgdiscountquota_endtime'])));
                }
            }

            $member_model = model('member');
            //系统等级设置
            $membergrade_arr = $member_model->getMemberGradeArr();

            $data = array();
            
            $pre_level_discount = 0;
            foreach ($membergrade_arr as $key => $value) {
                $current_level_discount = intval($_POST['mgdiscount_goods'][$key]['level_discount'] * 10);
                
                //限制会员等级高的会员享受更低折扣
                if($pre_level_discount==0){
                    $pre_level_discount = $current_level_discount;
                }
                if($current_level_discount>$pre_level_discount){
                    ds_json_encode(10001,$value['level_name'].'的折扣应小于或等于'.($pre_level_discount/10).'折');
                }
                $pre_level_discount = $current_level_discount;
                
                if ($current_level_discount < 1 || $current_level_discount > 100) {
                    ds_json_encode(10001,'输入的折扣不正确');
                }
                $data[$key]['level_discount'] = $current_level_discount / 10;
                $data[$key]['level_name'] = $value['level_name'];
            }

            $condition = array();
            $condition['goods_commonid'] = $goods_commonid;
            $result = $goods_model->editGoodscommon(array('goods_mgdiscount' => serialize($data)), $condition);
            $result1 = $goods_model->editGoods(array('goods_mgdiscount' => serialize($data)), $condition);

            if ($result && $result1) {
                $this->recordSellerlog('添加会员等级折扣，公共商品ID：' . $goods_commonid);
                ds_json_encode(10000,lang('mgdiscount_add_success'));
            } else {
                ds_json_encode(10001,lang('mgdiscount_add_fail'));
            }
        }
    }

    /**
     * 删除
     */
    public function mgdiscount_del()
    {
        $goods_commonid = intval(input('param.goods_commonid'));

        if (empty($goods_commonid)) {
            ds_json_encode(10001,lang('param_error'));
        }

        $condition = array();
        $condition['goods_commonid'] = $goods_commonid;

        $goods_model = model('goods');
        $result = $goods_model->editGoodscommon(array('goods_mgdiscount' => ''), $condition);
        $result1 = $goods_model->editGoods(array('goods_mgdiscount' => ''), $condition);

        if ($result && $result1) {
            ds_json_encode(10000,lang('ds_common_op_succ'));
        } else {
            ds_json_encode(10001,lang('ds_common_op_fail'));
        }
    }

    /**
     * 会员等级折扣套餐购买
     * */
    public function mgdiscount_quota_add()
    {
        //输出导航
        $this->setSellerCurMenu('Sellermgdiscount');
        $this->setSellerCurItem('mgdiscount_quota_add');
        return $this->fetch($this->template_dir . 'mgdiscount_quota_add');
    }

    /**
     * 会员等级折扣套餐购买保存
     * */
    public function mgdiscount_quota_add_save()
    {
        $mgdiscount_quota_quantity = intval(input('post.mgdiscount_quota_quantity'));
        if ($mgdiscount_quota_quantity <= 0 || $mgdiscount_quota_quantity > 12) {
            ds_json_encode(10001,lang('mgdiscount_quota_quantity_error'));
        }
        //获取当前价格
        $current_price = intval(config('mgdiscount_price'));
        //获取该用户已有套餐
        $mgdiscountquota_model = model('pmgdiscountquota');
        $current_mgdiscount_quota = $mgdiscountquota_model->getMgdiscountquotaCurrent(session('store_id'));
        $mgdiscount_add_time = 86400 * 30 * $mgdiscount_quota_quantity;
        if (empty($current_mgdiscount_quota)) {
            //生成套餐
            $param = array();
            $param['member_id'] = session('member_id');
            $param['member_name'] = session('member_name');
            $param['store_id'] = session('store_id');
            $param['store_name'] = session('store_name');
            $param['mgdiscountquota_starttime'] = TIMESTAMP;
            $param['mgdiscountquota_endtime'] = TIMESTAMP + $mgdiscount_add_time;
            $mgdiscountquota_model->addMgdiscountquota($param);
        } else {
            $param = array();
            $param['mgdiscountquota_endtime'] = Db::raw('mgdiscountquota_endtime+'.$mgdiscount_add_time);
            $mgdiscountquota_model->editMgdiscountquota($param, array('mgdiscountquota_id' => $current_mgdiscount_quota['mgdiscountquota_id']));
        }

        //记录店铺费用
        $this->recordStorecost($current_price * $mgdiscount_quota_quantity, '购买会员等级折扣');
        $this->recordSellerlog('购买' . $mgdiscount_quota_quantity . '份会员等级折扣套餐，单价' . $current_price . lang('ds_yuan'));
        ds_json_encode(10000,lang('mgdiscount_quota_add_success'));
    }
    
    /**
     * 选择活动商品
     * */
    public function search_goods() {
        $goods_model = model('goods');
        $condition = array();
        $condition['store_id'] = session('store_id');
        $condition['goods_name'] = array('like', '%' . input('param.goods_name') . '%');
        $goods_list = $goods_model->getGoodsCommonListForPromotion($condition, '*', 8, 'groupbuy');
        $this->assign('goods_list', $goods_list);
        $this->assign('show_page', $goods_model->page_info->render());
        echo $this->fetch($this->template_dir . 'search_goods');
        exit;
    }

    public function mgdiscount_goods_info() {
        $goods_commonid = intval(input('param.goods_commonid'));

        $data = array();
        $data['result'] = true;

        //判断此商品是否已经参加会员等级折扣，
        $result = $this->_check_allow_mgdiscount($goods_commonid);
        if($result['result'] != TRUE){
            echo json_encode($result);
            die;
        }
        
        //获取商品具体信息用于显示
        $goods_model = model('goods');
        $condition = array();
        $condition['goods_commonid'] = $goods_commonid;
        $goods_list = $goods_model->getGoodsOnlineList($condition);

        if (empty($goods_list)) {
            $data['result'] = false;
            $data['message'] = lang('param_error');
            echo json_encode($data);
            die;
        }


        $goods_info = $goods_list[0];
        $data['goods_id'] = $goods_info['goods_id'];
        $data['goods_name'] = $goods_info['goods_name'];
        $data['goods_price'] = $goods_info['goods_price'];
        $data['goods_image'] = goods_thumb($goods_info, 240);
        $data['goods_href'] = url('Goods/index', array('goods_id' => $goods_info['goods_id']));

        echo json_encode($data);
        die;
    }

    /*
     * 判断此商品是否已经参加拼团
     */
    private function _check_allow_mgdiscount($goods_commonid) {
        $condition = array();
        $goodscommon_info = model('goods')->getGoodeCommonInfoByID($goods_commonid);
        $result['result'] = TRUE;
        if ($goodscommon_info['goods_mgdiscount'] != '') {
            $result['result'] = FALSE;
            $result['message'] = lang('此商品已经设置了会员等级折扣');
        }
        return $result;
    }



    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $name 当前导航的name
     * @param array $array 附加菜单
     * @return
     */
    protected function getSellerItemList()
    {
        $menu_array = array(
            array(
                'name' => 'mgdiscount_store',
                'text' => lang('mgdiscount_store'),
                'url' => url('Sellerpromotionmgdiscount/mgdiscount_store')
            ),
            array(
                'name' => 'mgdiscount_goods',
                'text' => lang('mgdiscount_goods'),
                'url' => url('Sellerpromotionmgdiscount/mgdiscount_goods')
            ),
        );
        return $menu_array;
    }

}
