<?php

/**
 * 微信扫码支付
 */
class wxpay_native {

    /**
     * 支付信息初始化
     * @param array $payment_info
     */
    public function __construct($payment_info = array()) {
        define('WXN_APPID', $payment_info['payment_config']['wx_appid']);
        define('WXN_MCHID', $payment_info['payment_config']['wx_mch_id']);
        define('WXN_KEY', $payment_info['payment_config']['wx_key']);
    }

    /**
     * 组装包含支付信息的url(模式1)  失效
     */
    public function get_payforms() {
        require_once PLUGINS_PATH . '/payments/wxpay_native/lib/WxPay.Api.php';
        require_once PLUGINS_PATH . '/payments/wxpay_native/WxPay.NativePay.php';
        require_once PLUGINS_PATH . '/payments/wxpay_native/log.php';
        $notify = new NativePay();
        return $notify->GetPrePayUrl($order_info['pay_sn']);
    }

    /**
     * 组装包含支付信息的url(模式2)
     */
    public function get_payform($order_info) {
        require_once PLUGINS_PATH . '/payments/wxpay_native/lib/WxPay.Api.php';
        require_once PLUGINS_PATH . '/payments/wxpay_native/WxPay.NativePay.php';
        require_once PLUGINS_PATH . '/payments/wxpay_native/log.php';

        //统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody(config('site_name') . $order_info['pay_sn'] . '订单');
        $input->SetAttach($order_info['order_type']);
        $input->SetOut_trade_no($order_info['pay_sn'].'_'.TIMESTAMP);//31个字符,微信限制为32字符以内  TIMESTAMP 用来防止做随机数,用户支付订单后取消,已产生的订单不能重复支付
        $input->SetTotal_fee($order_info['api_pay_amount'] * 100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 3600));
        $input->SetGoods_tag('');
        $input->SetNotify_url(str_replace('/index.php', '', HOME_SITE_URL) . '/payment/wxpay_native_notify.html');
        $input->SetTrade_type("NATIVE");
        //$input->SetOpenid($openId);
        $input->SetProduct_id($order_info['pay_sn']);
        $result = WxPayApi::unifiedOrder($input);

        if(isset($result["code_url"])){
            return $result["code_url"];
        }else{
            halt($result);
        }
    }

    /**
     * 异步验证
     */
    public function verify_notify() {
        require_once PLUGINS_PATH . '/payments/wxpay_native/lib/WxPay.Api.php';
        require_once PLUGINS_PATH . '/payments/wxpay_native/lib/WxPay.Notify.php';

        $notify = new \WxPayNotify();
        $notify->Handle(true);
        $xml = file_get_contents('php://input');
        $data = $notify->FromXml($xml);
        
        if (!array_key_exists("transaction_id", $data)) {
            $verify_notify = false;
        } else {
            $transaction_id = $data['transaction_id'];
            $input = new \WxPayOrderQuery();
            $input->SetTransaction_id($transaction_id);
            $wxpay = new \WxPayApi();
            $result = $wxpay->orderQuery($input);
            if (array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {
                $verify_notify = TRUE;
            } else {
                $verify_notify = false;
            }
        }
        if ($verify_notify) {
            $notify_result = array(
                'out_trade_no' => $data["out_trade_no"], #商户订单号
                'trade_no' => $data['transaction_id'], #交易凭据单号
                'total_fee' => $data["total_fee"] / 100, #涉及金额
                'order_type'=>$data["attach"],
                'trade_status' => '1',
            );
        } else {
            $notify_result = array(
                'trade_status' => '0',
            );
        }
        return $notify_result;
    }

}
