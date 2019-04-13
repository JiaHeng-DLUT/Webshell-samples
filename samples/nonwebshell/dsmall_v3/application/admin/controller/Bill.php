<?php

namespace app\admin\controller;

use think\Lang;
use app\common\model\Storemoneylog;
class Bill extends AdminControl
{
    const EXPORT_SIZE = 1000;
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/bill.lang.php');
    }

    /**
     * 所有月份销量账单
     *
     */
    public function index()
    {
        //检查是否需要生成上月及更早结算单的程序不再执行，执行量较大，放到任务计划中触发
        $condition = array();
        $query_year = input('get.query_year');
        if (preg_match('/^\d{4}$/', $query_year, $match)) {
            $condition['os_month'] = array('like',$query_year.'%');
        }
        $bill_model = model('bill');
        $bill_list = $bill_model->getOrderstatisList($condition, '*', 12, 'os_month desc');
        $this->assign('bill_list', $bill_list);
        $this->assign('show_page', $bill_model->page_info->render());

        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件

        $this->setAdminCurItem('index');
        return $this->fetch('index');
    }

    /**
     * 某月所有店铺销量账单
     *
     */
    public function show_statis()
    {

        $bill_model = model('bill');
        $condition = array();

        $bill_state = input('get.bill_state');
        if (is_numeric($bill_state)) {
            $condition['ob_state'] = intval($bill_state);
        }
        $query_store = input('get.query_store');
        if (preg_match('/^\d{1,8}$/', $query_store)) {
            $condition['ob_store_id'] = $query_store;
        } elseif ($query_store != '') {
            $condition['ob_store_name'] = $query_store;
        }
        $os_month = input('get.os_month');
        if($os_month){
            $condition['ob_startdate']=array('>=',strtotime($os_month.'01 0:0:0'));
            $condition['ob_enddate']=array('<',strtotime($os_month.'01 23:59:59 +1 month -1 day'));
        }
        $bill_list = $bill_model->getOrderbillList($condition, '*', 30, 'ob_no desc');
        $this->assign('bill_list', $bill_list);
        $this->assign('show_page', $bill_model->page_info->render());

        $this->setAdminCurItem('show_statis');
        return $this->fetch('show_statis');
    }

    /**
     * 某店铺某月订单列表
     *
     */
    public function show_bill()
    {
        $ob_no = input('param.ob_no');
        if (!$ob_no) {
            $this->error(lang('param_error'));
        }
        $bill_model = model('bill');
        $bill_info = $bill_model->getOrderbillInfo(array('ob_no' => $ob_no));
        if (!$bill_info) {
            $this->error(lang('param_error'));
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

        $end_unixtime = $if_end_date ? $end_unixtime + 86400 - 1 : null;
        if ($if_start_date || $if_end_date) {
            $order_condition['finnshed_time'] = array('between', "{$start_unixtime},{$end_unixtime}");
        }

        $query_type = input('param.query_type');
        if ($query_type == 'cost') {

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
        }elseif ($query_type == 'vrorder') {

            //店铺费用
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
        } else {

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
            $this->assign('show_page', $order_model->page_info->render());
            $sub_tpl_name = 'show_order_list';
        }
        $this->assign('bill_info', $bill_info);
        return $this->fetch($sub_tpl_name);
    }

    public function bill_check() {
        $ob_no = input('param.ob_no');
        if (!$ob_no) {
            $this->error(lang('param_error'));
        }
        $bill_model = model('bill');
        $condition = array();
        $condition['ob_no'] = $ob_no;
        $condition['ob_state'] = BILL_STATE_STORE_COFIRM;
        $bill_info = $bill_model->getOrderbillInfo($condition);
        if (!$bill_info) {
            $this->error(lang('bill_is_not_exist'));
        }
        if (request()->isPost()) {
            
            $bill_model->startTrans();
            try {
                if($bill_info['ob_result_totals']!=0){
                    $storemoneylog_model=model('storemoneylog');
                    $data=array(
                        'seller_id'=>$bill_info['ob_store_id'],
                        'storemoneylog_type'=>Storemoneylog::TYPE_BILL,
                        'storemoneylog_state'=>Storemoneylog::STATE_VALID,
                        'storemoneylog_add_time'=>TIMESTAMP,
                        'store_avaliable_money'=>$bill_info['ob_result_totals'],//如果是欠账则从店铺余额里扣除，否则增加
                        'storemoneylog_desc'=>$ob_no.lang('bill_phase_numbers').lang('bill_state_success'),
                    );

                    $storemoneylog_model->changeStoremoney($data);
                }
                $update = $bill_model->editOrderbill(array('ob_state' => BILL_STATE_SUCCESS,'ob_admin_content'=>input('post.ob_admin_content')), $condition);
                if (!$update) {
                    exception(lang('bill_audit_fail'));
                }
            } catch (\Exception $e) {
                $bill_model->rollback();
                $this->log(lang('bill_audit_bill') . $ob_no, 0);
                $this->error($e->getMessage());
            }
            $bill_model->commit();
            $this->log(lang('bill_audit_bill') . $ob_no, 1);
            $this->success(lang('bill_audit_succ'),url('Bill/show_bill',['ob_no'=>$ob_no]));
        } else {
            return $this->fetch('bill_check');
        }
    }

    /**
     * 账单付款
     *
     */
    public function bill_pay()
    {
        $ob_no = input('param.ob_no');
        if (!preg_match('/^20\d{5,12}$/', $ob_no)) {
            $this->error(lang('param_error'));
        }
        $bill_model = model('bill');
        $condition = array();
        $condition['ob_no'] = $ob_no;
        $condition['ob_state'] = BILL_STATE_SYSTEM_CHECK;
        $bill_info = $bill_model->getOrderbillInfo($condition);
        if (!$bill_info) {
            $this->error(lang('param_error'));
        }
        if (request()->isPost()) {
            if (!preg_match('/^20\d{2}-\d{2}-\d{2}$/', input('param.pay_date'))) {
                $this->error(lang('param_error'));
            }
            $input = array();
            $input['ob_pay_content'] = input('pay_content');
            $input['ob_paydate'] = strtotime(input('param.pay_date'));
            $input['ob_state'] = BILL_STATE_SUCCESS;
            $update = $bill_model->editOrderbill($input, $condition);
            if ($update) {
                $storecost_model = model('storecost');
                $cost_condition = array();
                $cost_condition['storecost_store_id'] = $bill_info['ob_store_id'];
                $cost_condition['storecost_state'] = 0;
                $cost_condition['storecost_time'] = array('between', "{$bill_info['ob_startdate']},{$bill_info['ob_enddate']}");
                $storecost_model->editStorecost(array('storecost_state' => 1), $cost_condition);

                // 发送店铺消息
                $param = array();
                $param['code'] = 'store_bill_gathering';
                $param['store_id'] = $bill_info['ob_store_id'];
                $param['param'] = array(
                    'bill_no' => $bill_info['ob_no']
                );
                \mall\queue\QueueClient::push('sendStoremsg', $param);

                $this->log(lang('bill_payment_audit_fail') . $ob_no, 1);
                $this->success(lang('ds_common_save_succ'), 'bill/show_statis?os_month=' . $bill_info['os_month']);
            } else {
                $this->log(lang('bill_payment_audit_fail') . $ob_no, 1);
                $this->error(lang('ds_common_save_fail'));
            }
        } else {
            $this->setAdminCurItem('bill_pay');
            return $this->fetch('bill_pay');
        }
    }

    /**
     * 打印结算单
     *
     */
    public function bill_print()
    {
        $ob_no = input('param.ob_no');
        if (!$ob_no) {
            $this->error(lang('param_error'));
        }
        $bill_model = model('bill');
        $condition = array();
        $condition['ob_no'] = $ob_no;
        $condition['ob_state'] = BILL_STATE_SUCCESS;
        $bill_info = $bill_model->getOrderbillInfo($condition);
        if (!$bill_info) {
            $this->error(lang('param_error'));
        }

        $this->assign('bill_info', $bill_info);

        return $this->fetch('bill_print');
    }

    /**
     * 导出 结算管理
     *
     */
    public function export_js_step1() {
        $bill_model = model('bill');
        $condition = array();
        $query_year = input('get.query_year');
        if (preg_match('/^\d{4}$/', $query_year, $match)) {
            $condition['os_month'] = array('like',$query_year.'%');
        }
        if (!is_numeric(input('param.curpage'))) {
            $count = $bill_model->getOrderstatisCount($condition);
            $export_list = array();
            if ($count > self::EXPORT_SIZE) { //显示下载链接
                $page = ceil($count / self::EXPORT_SIZE);
                for ($i = 1; $i <= $page; $i++) {
                    $limit1 = ($i - 1) * self::EXPORT_SIZE + 1;
                    $limit2 = $i * self::EXPORT_SIZE > $count ? $count : $i * self::EXPORT_SIZE;
                    $export_list[$i] = $limit1 . ' ~ ' . $limit2;
                }
                $this->assign('export_list', $export_list);
                return $this->fetch('/public/excel');
            } else { //如果数量小，直接下载
                $data = $bill_model->getOrderstatisList($condition, '*', '', '', self::EXPORT_SIZE);
                $this->createJsExcel($data);
            }
        } else { //下载
            $limit1 = (input('param.curpage') - 1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $data = $bill_model->getOrderstatisList($condition, '*', '', '', "{$limit1},{$limit2}");
            $this->createJsExcel($data);
        }
    }

    /**
     * 结算管理 生成excel
     *
     * @param array $data
     */
    private function createJsExcel($data = array()) {
        Lang::load(APP_PATH .'admin/lang/'.config('default_lang').'/export.lang.php');
        $excel_obj = new \excel\Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id' => 's_title', 'Font' => array('FontName' => '宋体', 'Size' => '12', 'Bold' => '1')));
        //header
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_js_order_number_bill'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_js_order_price_from'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_js_order_total_transport'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_js_os_commis_totals'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_js_os_order_returntotals'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_js_os_commis_returntotals'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_js_os_store_costtotals'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_js_ob_inviter_totals'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_js_os_result_totals'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_js_os_createdate'));
        //data
        foreach ((array) $data as $k => $v) {
            $tmp = array();
            $tmp[] = array('data' => substr($v['os_month'],0,4).'-'.substr($v['os_month'],4));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['os_order_totals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['os_shipping_totals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['os_commis_totals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['os_order_returntotals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['os_commis_returntotals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['os_store_costtotals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['os_inviter_totals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['os_result_totals']));
            $tmp[] = array('data' => date('Y-m-d H:i:s', $v['os_createdate']));

            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data, CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset(lang('exp_js_list'), CHARSET));
        $excel_obj->generateXML($excel_obj->charset(lang('exp_js_list'), CHARSET) . input('param.curpage') . '-' . date('Y-m-d-H', time()));
    }

    /**
     * 商家账单列表 管理
     *
     */
    public function export_zd_step1() {

        $bill_model = model('bill');
        $condition = array();

        $bill_state = input('get.bill_state');
        if (is_numeric($bill_state)) {
            $condition['ob_state'] = intval($bill_state);
        }
        $query_store = input('get.query_store');
        if (preg_match('/^\d{1,8}$/', $query_store)) {
            $condition['ob_store_id'] = $query_store;
        } elseif ($query_store != '') {
            $condition['ob_store_name'] = $query_store;
        }
        $os_month = input('get.os_month');
        if($os_month){
            $condition['ob_startdate']=array('>=',strtotime($os_month.'01 0:0:0'));
            $condition['ob_enddate']=array('<',strtotime($os_month.'01 23:59:59 +1 month -1 day'));
        }
        if (!is_numeric(input('param.curpage'))) {
            $count = $bill_model->getOrderbillCount($condition);
            $export_list = array();
            if ($count > self::EXPORT_SIZE) { //显示下载链接
                $page = ceil($count / self::EXPORT_SIZE);
                for ($i = 1; $i <= $page; $i++) {
                    $limit1 = ($i - 1) * self::EXPORT_SIZE + 1;
                    $limit2 = $i * self::EXPORT_SIZE > $count ? $count : $i * self::EXPORT_SIZE;
                    $export_list[$i] = $limit1 . ' ~ ' . $limit2;
                }
                $this->assign('export_list', $export_list);
                return $this->fetch('/public/excel');
            } else { //如果数量小，直接下载
                $data = $bill_model->getOrderbillList($condition, '*', '', '', self::EXPORT_SIZE);
                $this->createZdExcel($data);
            }
        } else { //下载
            $limit1 = (input('param.curpage') - 1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $data = $bill_model->getOrderbillList($condition, '*', '', '', "{$limit1},{$limit2}");
            $this->createZdExcel($data);
        }
    }

    /**
     * 商家账单列表 生成excel
     *
     * @param array $data
     */
    private function createZdExcel($data = array()) {
        Lang::load(APP_PATH .'admin/lang/'.config('default_lang').'/export.lang.php');
        $excel_obj = new \excel\Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id' => 's_title', 'Font' => array('FontName' => '宋体', 'Size' => '12', 'Bold' => '1')));
        //header
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_bill_ob_no'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_bill_os_startdate'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_bill_os_enddate'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_order_price_from'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_order_total_transport'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_bill_print_commision'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_bill_ob_order_return_totals'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_bill_os_commis_returntotals'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_ob_inviter_totals'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_bill_ob_vr_order_totals'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_bill_ob_vr_order_return_totals'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_bill_ob_vr_commis_totals'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_bill_ob_vr_commis_return_totals'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_bill_ob_vr_inviter_totals'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_bill_os_store_costtotals'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_bill_os_result_totals'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_bill_out_date'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_bill_state'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_zd_store_name'));
        //data
        foreach ((array) $data as $k => $v) {
            $tmp = array();
            $tmp[] = array('data' => $v['ob_no']);
            $tmp[] = array('data' => date('Y-m-d H:i:s', $v['ob_startdate']));
            $tmp[] = array('data' => date('Y-m-d H:i:s', $v['ob_enddate']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['ob_order_totals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['ob_shipping_totals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['ob_commis_totals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['ob_order_return_totals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['ob_commis_return_totals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['ob_inviter_totals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['ob_vr_order_totals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['ob_vr_order_return_totals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['ob_vr_commis_totals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['ob_vr_commis_return_totals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['ob_vr_inviter_totals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['ob_store_cost_totals']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['ob_result_totals']));
            $tmp[] = array('data' => date('Y-m-d H:i:s', $v['ob_createdate']));
            $tmp[] = array('data' => get_bill_state($v['ob_state']));
            $tmp[] = array('data' => $v['ob_store_name']);
            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data, CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset(lang('exp_zd_list'), CHARSET));
        $excel_obj->generateXML($excel_obj->charset(lang('exp_zd_list'), CHARSET) . input('param.curpage') . '-' . date('Y-m-d-H', time()));
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList()
    {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => lang('ds_bill'),
                'url' => url('Bill/index')
            ),
        );
            $title = !empty(input('param.os_month')) ? input('param.os_month') . lang('bill_period') : '';
            $menu_array[] = array(
                'name' => 'show_statis',
                'text' => $title . lang('bill_billing_list'),
                'url' => !empty($title) ? url('Bill/show_statis', ['os_month' => input('param.os_month')]) : url('Bill/show_statis'),
            );
        return $menu_array;
    }
}

?>
