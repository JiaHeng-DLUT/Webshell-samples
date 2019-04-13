<?php

class alipay_app {

    private $config;

    public function __construct($payment_info = array(), $order_info = array()) {
        if (!empty($payment_info)) {
            $this->config = array(
                //应用ID,您的APPID。
                'app_id' => $payment_info['payment_config']['alipay_appid'],
                //商户私钥
                'merchant_private_key' => $payment_info['payment_config']['private_key'],
                //异步通知地址
                'notify_url' => str_replace('/index.php', '', HOME_SITE_URL) . '/payment/alipay_app_notify.html', //通知URL,
                //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
                'alipay_public_key' => $payment_info['payment_config']['public_key'],
            );
        }
    }
    function get_payform($param) {

        require_once PLUGINS_PATH . '/payments/alipay_app/AopClient.php';
        $aop = new \AopClient();
        $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
        $aop->appId = $this->config['app_id'];
        $aop->rsaPrivateKey = $this->config['merchant_private_key'];
        $aop->format = "json";
        $aop->charset = "UTF-8";
        $aop->signType = "RSA2";
        $aop->alipayrsaPublicKey = $this->config['alipay_public_key'];
//实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay

        require_once PLUGINS_PATH . '/payments/alipay_app/request/AlipayTradeAppPayRequest.php';
        $request = new \AlipayTradeAppPayRequest();
        $bizcontent = "{\"body\":\"{$param['order_type']}\","
                . "\"subject\":\"{$param['subject']}\","
                . "\"out_trade_no\":\"{$param['order_type']}-{$param['pay_sn']}\","
                . "\"total_amount\":\"{$param['api_pay_amount']}\","
                . "\"product_code\":\"QUICK_MSECURITY_PAY\""
                . "}";
        
        $request->setNotifyUrl($this->config['notify_url']);
        $request->setBizContent($bizcontent);
//这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);

//htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
//        echo htmlspecialchars($response); //就是orderString 可以直接给客户端请求，无需再做处理。

        ds_json_encode(10000,'',array('content'=>$response));
    }

    function verify_notify() {
        require_once PLUGINS_PATH . '/payments/alipay_app/AopClient.php';
        $aop = new \AopClient;
        
        $aop->alipayrsaPublicKey = $this->config['alipay_public_key'];
        $flag = $aop->rsaCheckV1($_POST, NULL, "RSA2");
        if ($flag) {
            $notify_result = array(
                'out_trade_no' => $_POST["out_trade_no"], #商户订单号
                'trade_no' => $_POST['trade_no'], #交易凭据单号
                'total_fee' => $_POST["total_amount"], #涉及金额
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

?>
