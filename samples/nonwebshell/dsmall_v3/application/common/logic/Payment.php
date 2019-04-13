<?php

namespace app\common\logic;


use think\Model;

class Payment extends Model
{
    /**
     * 取得实物订单所需支付金额等信息
     * @param int $pay_sn
     * @param int $member_id
     * @return array
     */
    public function getRealOrderInfo($pay_sn, $member_id = null)
    {

        //验证订单信息
        $order_model = model('order');
        $condition = array();
        $condition['pay_sn'] = $pay_sn;
        if (!empty($member_id)) {
            $condition['buyer_id'] = $member_id;
        }
        $order_pay_info = $order_model->getOrderpayInfo($condition);
        if (empty($order_pay_info)) {
            return ds_callback(false, '该支付单不存在');
        }

        $order_pay_info['subject'] = '实物订单_' . $order_pay_info['pay_sn'];
        $order_pay_info['order_type'] = 'real_order';

        $condition = array();
        $condition['pay_sn'] = $pay_sn;
        $order_list = $order_model->getNormalOrderList($condition);

        //计算本次需要在线支付的订单总金额
        $pay_amount = 0;
        if (!empty($order_list)) {
            foreach ($order_list as $order_info) {

                $payed_amount = floatval($order_info['rcb_amount']) + floatval($order_info['pd_amount']);
                if ($order_info['payment_code'] != 'offline' and $order_info['order_state'] > 0) {
                    if ($order_info['order_state'] == ORDER_STATE_NEW) {
                    }
                    $pay_amount += floatval($order_info['order_amount']) - $payed_amount;
                }
                else {
                }
            }
        }

        $order_pay_info['api_pay_amount'] = $pay_amount;
        $order_pay_info['order_list'] = $order_list;

        return ds_callback(true, '', $order_pay_info);
    }

    /**
     * 取得虚拟订单所需支付金额等信息
     * @param int $order_sn
     * @param int $member_id
     * @return array
     */
    public function getVrOrderInfo($order_sn, $member_id = null)
    {

        //验证订单信息
        $vrorder_model = model('vrorder');
        $condition = array();
        $condition['order_sn'] = $order_sn;
        if (!empty($member_id)) {
            $condition['buyer_id'] = $member_id;
        }
        $order_info = $vrorder_model->getVrorderInfo($condition);
        if (empty($order_info)) {
            return ds_callback(false, '该订单不存在');
        }

        $order_info['subject'] = '虚拟订单_' . $order_sn;
        $order_info['order_type'] = 'vr_order';
        $order_info['pay_sn'] = $order_sn;

       
        //修复 第三方支付时 充值卡没算在内BUG
        $pay_amount = ds_price_format(floatval($order_info['order_amount']) - floatval($order_info['pd_amount']) - floatval($order_info['rcb_amount']));

        $order_info['api_pay_amount'] = $pay_amount;

        return ds_callback(true, '', $order_info);
    }

    /**
     * 取得充值单所需支付金额等信息
     * @param int $pdr_sn
     * @param int $member_id
     * @return array
     */
    public function getPdOrderInfo($pdr_sn, $member_id = null)
    {

        $predeposit_model = model('predeposit');
        $condition = array();
        $condition['pdr_sn'] = $pdr_sn;
        if (!empty($member_id)) {
            $condition['pdr_member_id'] = $member_id;
        }

        $order_info = $predeposit_model->getPdRechargeInfo($condition);
        if (empty($order_info)) {
            return ds_callback(false, '该订单不存在');
        }

        $order_info['subject'] = '预存款充值_' . $order_info['pdr_sn'];
        $order_info['order_type'] = 'pd_order';
        $order_info['pay_sn'] = $order_info['pdr_sn'];
        $order_info['api_pay_amount'] = $order_info['pdr_amount'];
        return ds_callback(true, '', $order_info);
    }

    /**
     * 取得所使用支付方式信息
     * @param unknown $payment_code
     */
    public function getPaymentInfo($payment_code)
    {
        if (in_array($payment_code, array('offline', 'predeposit')) || empty($payment_code)) {
            return ds_callback(false, '系统不支持选定的支付方式');
        }
        $payment_model = model('payment');
        $condition = array();
        $condition['payment_code'] = $payment_code;
        $payment_info = $payment_model->getPaymentOpenInfo($condition);
        if (empty($payment_info)) {
            return ds_callback(false, '系统不支持选定的支付方式');
        }
        $inc_file = PLUGINS_PATH . DS . 'payments' . DS . $payment_info['payment_code'] . DS . $payment_info['payment_code'] . '.php';
        if (!file_exists($inc_file)) {
            return ds_callback(false, '系统不支持选定的支付方式');
        }
        require_once  $inc_file;
        $payment_info['payment_config'] = unserialize($payment_info['payment_config']);

        return ds_callback(true, '', $payment_info);
    }

    /**
     * 支付成功后修改实物订单状态
     */
    public function updateRealOrder($out_trade_no, $payment_code, $order_list, $trade_no)
    {
        $post['payment_code'] = $payment_code;
        $post['trade_no'] = $trade_no;
        return model('order','logic')->changeOrderReceivePay($order_list, 'system', '系统', $post);
    }

    /**
     * 支付成功后修改虚拟订单状态
     */
    public function updateVrOrder($out_trade_no, $payment_code, $order_info, $trade_no)
    {
        $post['payment_code'] = $payment_code;
        $post['trade_no'] = $trade_no;
        $post['payment_time'] = TIMESTAMP;
        return model('vrorder','logic')->changeOrderStatePay($order_info, 'system', $post);
    }

    /**
     * 支付成功后修改充值订单状态
     * @param unknown $out_trade_no
     * @param unknown $trade_no
     * @param unknown $payment_code
     * @throws Exception
     * @return multitype:unknown
     */
    public function updatePdOrder($out_trade_no, $payment_code, $recharge_info, $trade_no)
    {

        $condition = array();
        $condition['pdr_sn'] = $recharge_info['pdr_sn'];
        $condition['pdr_payment_state'] = 0;
        $update = array();
        $update['pdr_payment_state'] = 1;
        $update['pdr_paymenttime'] = TIMESTAMP;
        $update['pdr_payment_code'] = $payment_code;
        $update['pdr_trade_sn'] = $trade_no;

        $predeposit_model = model('predeposit');
        try {
            $predeposit_model->startTrans();
            $pdnum = $predeposit_model->getPdRechargeCount(array(
                                                       'pdr_sn' => $recharge_info['pdr_sn'], 'pdr_payment_state' => 1
                                                   ));
            if (intval($pdnum) > 0) {
                exception('订单已经处理');
            }
            //更改充值状态
            $state = $predeposit_model->editPdRecharge($update, $condition);
            if (!$state) {
                exception('更新充值状态失败');
            }
            //变更会员预存款
            $data = array();
            $data['member_id'] = $recharge_info['pdr_member_id'];
            $data['member_name'] = $recharge_info['pdr_member_name'];
            $data['amount'] = $recharge_info['pdr_amount'];
            $data['pdr_sn'] = $recharge_info['pdr_sn'];
            $predeposit_model->changePd('recharge', $data);
            $predeposit_model->commit();
            return ds_callback(true);

        } catch (Exception $e) {
            $predeposit_model->rollback();
            return ds_callback(false, $e->getMessage());
        }
    }
    
    
    /**
     * 
     * @param type $out_trade_no  #商城内部订单号
     * @param type $trade_no  #支付交易流水号
     * @param type $order_type  #订单ID
     * @param type $payment_code  #支付方式代号
     */
    public function updateOrder($out_trade_no,$trade_no,$order_type,$payment_code){
        $out_trade_no = current(explode('_', $out_trade_no));
        if ($order_type == 'real_order') {
            $order = $this->getRealOrderInfo($out_trade_no);
            if (intval($order['data']['api_paystate'])) {
                //订单已支付
                return true;
            }
            $order_list = $order['data']['order_list'];
            $result = $this->updateRealOrder($out_trade_no, $payment_code, $order_list, $trade_no);
        }elseif($order_type == 'vr_order') {
            $order = $this->getVrOrderInfo($out_trade_no);
            if ($order['data']['order_state'] != ORDER_STATE_NEW) {
                //订单已支付
                return true;
            }
            $result = $this->updateVrOrder($out_trade_no, $payment_code, $order['data'], $trade_no);
        }elseif($order_type == 'pd_order') {
            $order = $this->getPdOrderInfo($out_trade_no);
            if ($order['data']['pdr_payment_state'] == 1) {
                //订单已支付
                return true;
            }
            $result = $this->updatePdOrder($out_trade_no, $payment_code, $order['data'], $trade_no);
        }
        return $result['code'] ? TRUE : FALSE;
    }
    
    
}