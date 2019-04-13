<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'service/AlipayTradeService.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'buildermodel/AlipayTradeWapPayContentBuilder.php';


class alipay_h5 {

    //配置
    private $alipay_config = array();

    public function __construct($param = array()) {
        if (!empty($param)) {
            $this->alipay_config = array(
                //应用ID,您的APPID。
                'app_id' => $param['payment_config']['alipay_appid'],
                //商户私钥，您的原始格式RSA私钥
                'merchant_private_key' => $param['payment_config']['private_key'],
                //异步通知地址
                'notify_url' => str_replace('/index.php', '', HOME_SITE_URL) . '/payment/alipay_h5_notify.html',
                //同步跳转
                'return_url' => str_replace('/index.php', '', MOBILE_SITE_URL) . '/payment/alipay_h5_return.html',
                //编码格式
                'charset' => "UTF-8",
                //签名方式
                'sign_type' => "RSA2",
                //支付宝网关
                'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
                //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
                'alipay_public_key' => $param['payment_config']['public_key'],
            );
        }
    }

    public function get_payform($order_info) {
        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($order_info['order_type']);
        $payRequestBuilder->setSubject($order_info['subject']);
        $payRequestBuilder->setOutTradeNo($order_info['order_type'] . '-' . $order_info['pay_sn']);
        $payRequestBuilder->setTotalAmount($order_info['api_pay_amount']);
        $payRequestBuilder->setTimeExpress('1m');

        $payResponse = new AlipayTradeService($this->alipay_config);
        $result = $payResponse->wapPay($payRequestBuilder, $this->alipay_config['return_url'], $this->alipay_config['notify_url']);
        return;
    }

    /**
     * 获取return信息
     */
    public function verify_return() {
        $arr = $_GET;
        $alipaySevice = new AlipayTradeService($this->alipay_config);
        $result = $alipaySevice->check($arr);
        if ($result) {
            return true;
        }
        return false;
    }


}
