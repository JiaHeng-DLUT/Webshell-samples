<?php

class wxpay_app {
    public function __construct($payment_info = array())
    {
        define('WXN_APPID', $payment_info['payment_config']['wx_appid']);
        define('WXN_APPSECRET', $payment_info['payment_config']['wx_appsecret']);
        define('WXN_MCHID', $payment_info['payment_config']['wx_mch_id']);
        define('WXN_KEY', $payment_info['payment_config']['wx_key']);
    }
    function get_payform($param=array()) {

        define("APPID", WXN_APPID);
        define("MCHID", WXN_MCHID);
        define("KEY", WXN_KEY);


        require_once PLUGINS_PATH . '/payments/wxpay_native/lib/WxPay.Api.php';
        //统一下单  nonce_str、sign、spbill_create_ip  在接口调用统一设置
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($param['subject']);
        $input->SetAttach($param['order_type']);
        $input->SetOut_trade_no($param['order_type'].'-'.$param['pay_sn']);
        $input->SetTotal_fee(bcmul($param['api_pay_amount'] , 100));
        $input->SetNotify_url(str_replace('/index.php', '', HOME_SITE_URL) . '/payment/wxpay_app_notify.html');
        $input->SetTrade_type('APP');

        $wxpay = new \WxPayApi();
        $order = $wxpay->unifiedOrder($input);

        if ($order['return_code'] == 'SUCCESS') {
            if ($order['result_code'] == 'SUCCESS') {
                $order['timestamp'] = time();
                $order['sign'] = $this->sign_again($order);
                ds_json_encode(10000,'',$order);
            } else {
                ds_json_encode(10001,$order['err_code_des']);
            }
        } else {
            ds_json_encode(10001,$order['return_msg']);
        }
    }

    function sign_again($order) {
        $values['appid'] = WXN_APPID;
        $values['partnerid'] = WXN_MCHID;
        $values['prepayid'] = $order['prepay_id'];
        $values['package'] = 'Sign=WXpay';
        $values['noncestr'] = $order['nonce_str'];
        $values['timestamp'] = $order['timestamp'];
        
        ksort($values);
        $buff = "";
        foreach ($values as $key => $value) {
            $buff .= $key . "=" . $value . "&";
        }

        $string = trim($buff, "&");
        $string = $string . "&key=" . KEY;
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

}
