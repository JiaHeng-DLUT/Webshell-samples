<?php

namespace app\admin\controller;

use think\Lang;

class Vrorder extends AdminControl {

    /**
     * 每次导出订单数量
     * @var int
     */
    const EXPORT_SIZE = 1000;

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/vrorder.lang.php');
    }

    public function index() {
        $vrorder_model = model('vrorder');
        $condition = array();

        $order_sn = input('get.order_sn');
        if ($order_sn) {
            $condition['order_sn'] = $order_sn;
        }
        $store_name = input('get.store_name');
        if ($store_name) {
            $condition['store_name'] = $store_name;
        }
        $order_state = input('get.order_state');
        if (!empty($order_state)) {
            $condition['order_state'] = intval($order_state);
        }
        $payment_code = input('get.payment_code');
        if ($payment_code) {
            $condition['payment_code'] = $payment_code;
        }
        $buyer_name = input('get.buyer_name');
        if ($buyer_name) {
            $condition['buyer_name'] = $buyer_name;
        }
        $query_start_time = input('get.query_start_time');
        $query_end_time = input('get.query_end_time');
        $if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $query_start_time);
        $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $query_end_time);
        $start_unixtime = $if_start_time ? strtotime($query_start_time) : null;
        $end_unixtime = $if_end_time ? strtotime($query_end_time) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition['add_time'] = array('between', array($start_unixtime, $end_unixtime));
        }
        $order_list = $vrorder_model->getVrorderList($condition, 30);

        foreach ($order_list as $k => $order_info) {
            //显示取消订单
            $order_list[$k]['if_cancel'] = $vrorder_model->getVrorderOperateState('system_cancel', $order_info);
            //显示收到货款
            $order_list[$k]['if_system_receive_pay'] = $vrorder_model->getVrorderOperateState('system_receive_pay', $order_info);
        }

        //显示支付接口列表(搜索)
        $payment_list = model('payment')->getPaymentOpenList();
        $this->assign('payment_list', $payment_list);

        $this->assign('order_list', $order_list);
        $this->assign('show_page', $vrorder_model->page_info->render());
        
        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
        $this->setAdminCurItem('index');
        return $this->fetch('vr_order_index');
    }

    /**
     * 平台订单状态操作
     *
     */
    public function change_state() {
        $vrorder_model = model('vrorder');
        $condition = array();
        
        $condition['order_id'] = intval(input('param.order_id'));
        $order_info = $vrorder_model->getVrorderInfo($condition);
        $state_type = input('param.state_type');
        if ($state_type == 'cancel') {
            $result = $this->_order_cancel($order_info);
            if (isset($result['code'])) {
                ds_json_encode('10000', $result['msg']);
            }
        } elseif ($state_type == 'receive_pay') {
            $result = $this->_order_receive_pay($order_info, input('post.'));
            if (isset($result['code'])) {
                dsLayerOpenSuccess($result['msg']);
            }
        }
        $this->error('操作出错','index');
    }

    /**
     * 系统取消订单
     * @param unknown $order_info
     */
    private function _order_cancel($order_info) {
        $vrorder_model = model('vrorder');
        $logic_vrorder = model('vrorder','logic');
        $if_allow = $vrorder_model->getVrorderOperateState('system_cancel', $order_info);
        if (!$if_allow) {
            return ds_callback(false, '无权操作');
        }
        $this->log('关闭了虚拟订单,' . lang('order_number') . ':' . $order_info['order_sn'], 1);
        return $logic_vrorder->changeOrderStateCancel($order_info, 'store', '管理员关闭虚拟订单');
    }

    /**
     * 系统收到货款
     * @param unknown $order_info
     * @throws Exception
     */
    private function _order_receive_pay($order_info, $post) {
        $vrorder_model = model('vrorder');
        $logic_vrorder = model('vrorder','logic');
        $if_allow = $vrorder_model->getVrorderOperateState('system_receive_pay', $order_info);
        if (!$if_allow) {
            return ds_callback(false, '无权操作');
        }

        if (!request()->post()) {
            $this->assign('order_info', $order_info);
            //显示支付接口
            $payment_list = model('payment')->getPaymentOpenList();
            //去掉预存款和货到付款
            foreach ($payment_list as $key => $value) {
                if ($value['payment_code'] == 'predeposit' || $value['payment_code'] == 'offline') {
                    unset($payment_list[$key]);
                }
            }
            $this->assign('payment_list', $payment_list);
            $this->setAdminCurItem('submit');
            echo $this->fetch('receive_pay');
            exit();
        } else {
            $this->log('将虚拟订单改为已收款状态,' . lang('order_number') . ':' . $order_info['order_sn'], 1);
            return $logic_vrorder->changeOrderStatePay($order_info, 'system', $post);
        }
    }

    /**
     * 查看订单
     *
     */
    public function show_order() {
        $order_id = intval(input('param.order_id'));
        if ($order_id <= 0) {
            $this->error(lang('miss_order_number'));
        }
        $vrorder_model = model('vrorder');
        $order_info = $vrorder_model->getVrorderInfo(array('order_id' => $order_id));
        if (empty($order_info)) {
            $this->error('订单不存在');
        }

        //取兑换码列表
        $vr_code_list = $vrorder_model->getShowVrordercodeList(array('order_id' => $order_info['order_id']));
        $order_info['extend_vr_order_code'] = $vr_code_list;

        //显示取消订单
        $order_info['if_cancel'] = $vrorder_model->getVrorderOperateState('buyer_cancel', $order_info);

        //显示订单进行步骤
        $order_info['step_list'] = $vrorder_model->getVrorderStep($order_info);

        //显示系统自动取消订单日期
        if ($order_info['order_state'] == ORDER_STATE_NEW) {
            $order_info['order_cancel_day'] = $order_info['add_time'] + config('order_auto_cancel_day') * 24 * 3600;
        }
        $this->assign('order_info', $order_info);
        return $this->fetch('view');
    }

    /**
     * 导出
     *
     */
    public function export_step1() {

        $vrorder_model = model('vrorder');
        $condition = array();
        if (input('param.order_sn')) {
            $condition['order_sn'] = input('param.order_sn');
        }
        if (input('param.store_name')) {
            $condition['store_name'] = input('param.store_name');
        }
        $order_state = input('param.order_state');
        if (in_array($order_state, array('0', '10', '20', '30', '40'))) {
            $condition['order_state'] = $order_state;
        }
        if (input('param.payment_code')) {
            $condition['payment_code'] = input('param.payment_code');
        }
        if (input('param.buyer_name')) {
            $condition['buyer_name'] = input('param.buyer_name');
        }
        $if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/', input('param.query_start_time'));
        $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/', input('param.query_end_time'));
        $start_unixtime = $if_start_time ? strtotime(input('param.query_start_time')) : null;
        $end_unixtime = $if_end_time ? strtotime(input('param.query_end_time')) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition['add_time'] = array('between', array($start_unixtime, $end_unixtime));
        }

        if (!is_numeric(input('param.curpage'))) {
            $count = $vrorder_model->getVrorderCount($condition);
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
                $data = $vrorder_model->getVrorderList($condition, '', '*', 'order_id desc', self::EXPORT_SIZE);
                $this->createExcel($data);
            }
        } else { //下载
            $limit1 = (input('param.curpage') - 1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $data = $vrorder_model->getVrorderList($condition, '', '*', 'order_id desc', "{$limit1},{$limit2}");
            $this->createExcel($data);
        }
    }

    /**
     * 生成excel
     *
     * @param array $data
     */
    private function createExcel($data = array()) {
        $excel_obj = new \excel\Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id' => 's_title', 'Font' => array('FontName' => '宋体', 'Size' => '12', 'Bold' => '1')));
        //header
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_od_no'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_od_store'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_od_buyer'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_od_xtimd'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_od_count'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_od_paytype'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_od_state'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_od_storeid'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_od_buyerid'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => '接收手机');
        //data
        foreach ((array) $data as $k => $v) {
            $tmp = array();
            $tmp[] = array('data' => 'DS' . $v['order_sn']);
            $tmp[] = array('data' => $v['store_name']);
            $tmp[] = array('data' => $v['buyer_name']);
            $tmp[] = array('data' => date('Y-m-d H:i:s', $v['add_time']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['order_amount']));
            $tmp[] = array('data' => get_order_payment_name($v['payment_code']));
            $tmp[] = array('data' => $v['state_desc']);
            $tmp[] = array('data' => $v['store_id']);
            $tmp[] = array('data' => $v['buyer_id']);
            $tmp[] = array('data' => $v['buyer_phone']);
            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data, CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset(lang('exp_od_order'), CHARSET));
        $excel_obj->generateXML($excel_obj->charset(lang('exp_od_order'), CHARSET) . input('param.curpage') . '-' . date('Y-m-d-H', time()));
    }

    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index', 'text' => lang('ds_manage'), 'url' => url('Vrorder/index')
            )
        );
        if(request()->action() == 'change_state') {
            $menu_array[] = array(
                'name' => 'submit', 'text' => '确认收款', 'url' => ''
            );
        }
        if(request()->action() == 'show_order') {
            $menu_array[] = array(
                'name' => 'show_order', 'text' => '详情', 'url' => ''
            );
        }
        return $menu_array;
    }

}
