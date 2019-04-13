<?php

namespace app\home\controller;

use think\Lang;

class Sellerbill extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellerbill.lang.php');
    }

    /**
     * 结算列表
     *
     */
    public function index() {
        $bill_model = model('bill');
        $condition = array();
        $condition['ob_store_id'] = session('store_id');

        $ob_no = input('param.ob_no');
        if (preg_match('/^20\d{5,12}$/', $ob_no)) {
            $condition['ob_no'] = $ob_no;
        }
        $bill_state = intval(input('bill_state'));
        if ($bill_state) {
            $condition['ob_state'] = $bill_state;
        }

        
        $bill_list = $bill_model->getOrderbillList($condition, '*', 12, 'ob_state asc,ob_no asc');
        $this->assign('bill_list', $bill_list);
        $this->assign('show_page', $bill_model->page_info->render());

        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('Sellerbill');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('seller_slide');
        return $this->fetch($this->template_dir.'index');
    }

    /**
     * 查看结算单详细
     *
     */
    public function show_bill() {
        $ob_no = input('param.ob_no');
        if (!$ob_no) {
            $this->error('参数错误');
        }
        
        $bill_model = model('bill');
        $bill_info = $bill_model->getOrderbillInfo(array('ob_no' => $ob_no,'ob_store_id'=>session('store_id')));
        if (!$bill_info) {
            $this->error('参数错误');
        }
        
        $order_condition = array();
        $order_condition['ob_no'] = $ob_no;
        $order_condition['order_state'] = ORDER_STATE_SUCCESS;
        $order_condition['store_id'] = $bill_info['ob_store_id'];

        $query_start_date = input('get.query_start_date');
        $query_end_date = input('get.query_end_date');
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $query_start_date);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $query_end_date);
        $start_unixtime = $if_start_date ? strtotime($query_start_date) : null;
        $end_unixtime = $if_end_date ? strtotime($query_end_date) : null;
        if ($if_start_date || $if_end_date) {
            $order_condition['finnshed_time'] = array('between', array($start_unixtime, $end_unixtime));
        }
        $query_order_no = input('get.query_order_no');
        $type = input('param.type');
        if ($type == 'vrorder') {
            if (preg_match('/^\d{8,20}$/', $query_order_no)) {
                $order_condition['order_sn'] = $query_order_no;
            }
            $vrorder_model = model('vrorder');
            $order_list = $vrorder_model->getVrorderList($order_condition, 20,'SUM(ROUND(order_amount*commis_rate/100,2)) AS commis_amount,SUM(ROUND(refund_amount*commis_rate/100,2)) AS return_commis_amount,order_amount,refund_amount,order_sn,buyer_name,add_time,finnshed_time,order_id');
            foreach($order_list as $key => $val){
                if(!$val['order_id']){
                    $order_list=array();
                    break;
                }
                //分销佣金
                $inviter_info=db('orderinviter')->where(array('orderinviter_order_id' => $key, 'orderinviter_valid' => 1, 'orderinviter_order_type' => 1))->field('SUM(orderinviter_money) AS ob_inviter_totals')->find();
                $order_list[$key]['inviter_amount']= ds_price_format($inviter_info['ob_inviter_totals']);
            }
            $this->assign('order_list', $order_list);
            $this->assign('show_page', $vrorder_model->page_info->render());

            $sub_tpl_name = 'show_vrorder_list';
            /* 设置卖家当前菜单 */
            $this->setSellerCurMenu('Sellerbill');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem('seller_slide');
        } elseif ($type == 'cost') {
            //店铺费用
            $storecost_model = model('storecost');
            $cost_condition = array();
            $cost_condition['storecost_store_id'] = $bill_info['ob_store_id'];
            $cost_condition['storecost_time'] = array('between',[$bill_info['ob_startdate'],$bill_info['ob_enddate']]);

            $store_cost_list = $storecost_model->getStorecostList($cost_condition, 20);

            //取得店铺名字
            $store_info = model('store')->getStoreInfoByID($bill_info['ob_store_id']);
            $this->assign('cost_list', $store_cost_list);
            $this->assign('store_info', $store_info);
            $this->assign('show_page', $storecost_model->page_info->render());
            
            $sub_tpl_name = 'show_cost_list';
            /* 设置卖家当前菜单 */
            $this->setSellerCurMenu('Sellerbill');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem('seller_slide');
        } else {

            if (preg_match('/^\d{8,20}$/', $query_order_no)) {
                $order_condition['order_sn'] = $query_order_no;
            }
            //订单列表
            $order_model = model('order');
            $order_list = $order_model->getOrderList($order_condition, 20);

            //然后取订单商品佣金
            $order_id_array = array();
            if (is_array($order_list)) {
                foreach ($order_list as $order_info) {
                    $order_id_array[] = $order_info['order_id'];
                }
            }
            $order_goods_condition = array();
            $order_goods_condition['order_id'] = array('in', $order_id_array);
            $field = 'SUM(ROUND(goods_pay_price*commis_rate/100,2)) as commis_amount,order_id';

            $commis_list = $order_model->getOrdergoodsList($order_goods_condition, $field, null, null, '', 'order_id', 'order_id');
            foreach($commis_list as $key => $val){
                $return_commis_amount=0;
                $refund_info=db('refundreturn')->alias('refundreturn')->join('__ORDERGOODS__ ordergoods', 'refundreturn.order_goods_id = ordergoods.rec_id')->where(array('refundreturn.order_id' => $key, 'refundreturn.refund_state' => 3, 'refundreturn.order_goods_id' => array('>', 0)))->field('SUM(ROUND(refundreturn.refund_amount*ordergoods.commis_rate/100,2)) AS ob_commis_return_totals')->find();
                $return_commis_amount=$refund_info['ob_commis_return_totals'];
                $commis_list[$key]['return_commis_amount']=$return_commis_amount;
                //分销佣金
                $inviter_info=db('orderinviter')->where(array('orderinviter_order_id' => $key, 'orderinviter_valid' => 1, 'orderinviter_order_type' => 0))->field('SUM(orderinviter_money) AS ob_inviter_totals')->find();
                $commis_list[$key]['inviter_amount']=$inviter_info['ob_inviter_totals'];
            }
            $this->assign('commis_list', $commis_list);
            $this->assign('order_list', $order_list);

            $order_list_page = db('order')->where($order_condition)->paginate(20,false,['query' => request()->param()]);
            $this->assign('show_page', $order_list_page->render());
            $sub_tpl_name = 'show_order_list';
            /* 设置卖家当前菜单 */
            $this->setSellerCurMenu('Sellerbill');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem('seller_slide');
        }
        $this->assign('bill_info', $bill_info);

        return $this->fetch($this->template_dir.$sub_tpl_name);
    }

    
    /**
     * 打印结算单
     *
     */
    public function bill_print() {
        $ob_no = input('param.ob_no');
        if (!$ob_no) {
            $this->error('参数错误');
        }

        $bill_model = model('bill');
        $condition = array();
        $condition['ob_no'] = $ob_no;
        $condition['ob_store_id'] = session('store_id');
        $condition['ob_state'] = BILL_STATE_SUCCESS;
        $bill_info = $bill_model->getOrderbillInfo($condition);
        if (!$bill_info) {
            $this->error('参数错误');
        }

        $this->assign('bill_info', $bill_info);
        return $this->fetch($this->template_dir.'bill_print');
    }

    /**
     * 店铺确认出账单
     *
     */
    public function confirm_bill() {
            $ob_no = input('param.ob_no');
            if (!$ob_no) {
                ds_json_encode(10001,lang('param_error'));
            }
            $bill_model = model('bill');
            $condition = array();
            $condition['ob_no'] = $ob_no;
            $condition['ob_store_id'] = session('store_id');
            $condition['ob_state'] = BILL_STATE_CREATE;
            $bill_info=$bill_model->getOrderbillInfo($condition);
            if(!$bill_info){
                ds_json_encode(10001,lang('bill_is_not_exist'));
            }
        if(request()->isPost()){
            $update = $bill_model->editOrderbill(array('ob_state' => BILL_STATE_STORE_COFIRM,'ob_seller_content'=>input('post.ob_seller_content')), $condition);
            if ($update) {
                ds_json_encode(10000,lang('ds_common_op_succ'));
            } else {
                ds_json_encode(10001,lang('ds_common_op_fail'));
            }
        }else{
            
            return $this->fetch($this->template_dir.'bill_confirm');
        }
    }



    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $menu_key 当前导航的menu_key
     * @return
     */
    function getSellerItemList() {
        $ob_no = input('param.ob_no');
        if (request()->action()=='index') {
            $menu_array = array(
                array(
                    'name' => 'list',
                    'text' => lang('physical_settlement'),
                    'url' => url('Sellerbill/index')
                ),
            );
        }else if(request()->action()=='show_bill'){
            $menu_array = array(
                array(
                    'name' => 'order_list',
                    'text' => '订单列表',
                    'url' => url('Sellerbill/show_bill', ['ob_no' => $ob_no])
                ),
                array(
                    'name' => 'vrorder_list',
                    'text' => '虚拟订单列表',
                    'url' => url('Sellerbill/show_bill', ['type'=>'vrorder','ob_no' => $ob_no])
                ),
                array(
                    'name' => 'cost_list',
                    'text' => '促销费用',
                    'url' => url('Sellerbill/show_bill', ['type'=>'cost','ob_no' => $ob_no])
                ),
                
            );
        }
        return $menu_array;
    }

}

?>
