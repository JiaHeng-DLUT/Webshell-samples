<?php

require_once dirname(__FILE__) . '/service/AlipayTradeService.php';
require_once dirname(__FILE__) . '/buildermodel/AlipayTradePagePayContentBuilder.php';
require_once dirname(__FILE__) . '/buildermodel/AlipayTradeQueryContentBuilder.php';

class alipay {

    private $config;

    public function __construct($payment_info = array(), $order_info = array()) {
        if (!empty($payment_info)) {
            $this->config = array(
                //应用ID,您的APPID。
                'app_id' => $payment_info['payment_config']['alipay_appid'],
                //商户私钥
                'merchant_private_key' => $payment_info['payment_config']['private_key'],
                //异步通知地址
                'notify_url' => str_replace('/index.php', '', HOME_SITE_URL) . '/payment/alipay_notify.html', //通知URL,
                //同步跳转
                'return_url' => str_replace('/index.php', '', HOME_SITE_URL) . "/payment/alipay_return.html", //返回URL,
                //编码格式
                'charset' => "UTF-8",
                //签名方式
                'sign_type' => "RSA2",
                //支付宝网关
                'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
                //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
                'alipay_public_key' => $payment_info['payment_config']['public_key'],
            );
        }
    }

    /**
     * 获取支付接口的请求地址
     *
     * @return string
     */
    public function get_payform($order_info) {
        //构造参数
        $payRequestBuilder = new AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($order_info['order_type']);
        $payRequestBuilder->setSubject($order_info['subject']);
        $payRequestBuilder->setTotalAmount($order_info['api_pay_amount']);
        $payRequestBuilder->setOutTradeNo($order_info['order_type'] . '-' . $order_info['pay_sn']);

        $aop = new AlipayTradeService($this->config);

        /**
         * pagePay 电脑网站支付请求
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @param $return_url 同步跳转地址，公网可以访问
         * @param $notify_url 异步通知地址，公网可以访问
         * @return $response 支付宝返回的信息
         */
        $response = $aop->pagePay($payRequestBuilder, $this->config['return_url'], $this->config['notify_url']);
        exit;
    }

    public function return_verify() {
        $arr = $_GET;
        $return_result = array(
                'trade_status' => '0',
            );
        
        $temp = explode('-', input('param.out_trade_no'));
        $out_trade_no = $temp['1'];  //返回的支付单号
        $order_type = $temp['0'];
        
        $alipaySevice = new AlipayTradeService($this->config);
        $alipaySevice->writeLog(var_export($arr, true));
        $result = $alipaySevice->check($arr);
        if ($result) {
            $return_result = array(
                    'out_trade_no' => $out_trade_no, #商户订单号
                    'trade_no' => input('param.trade_no'), #交易凭据单号
                    'total_fee' => input('param.total_amount'), #涉及金额
                    'order_type' => $order_type,
                    'trade_status' => '1',
                );
        }
        
        return $return_result;
    }

    public function verify_notify() {
        $arr = $_POST;
        $notify_result = array(
                'trade_status' => '0',
            );
        $alipaySevice = new AlipayTradeService($this->config);
        $alipaySevice->writeLog('verify_notify' . var_export($arr, true));
        $result = $alipaySevice->check($arr);
        if ($result) {
            if ($arr['trade_status'] == 'TRADE_SUCCESS') {
                $out_trade_no = explode('-', input('param.out_trade_no'));
                $out_trade_no = $out_trade_no['1'];
                $notify_result = array(
                    'out_trade_no' => $out_trade_no, #商户订单号
                    'trade_no' => input('param.trade_no'), #交易凭据单号
                    'total_fee' => input('param.total_amount'), #涉及金额
                    'order_type' => input('param.body'),
                    'trade_status' => '1',
                );
            }
        } 
        return $notify_result;
    }

    /**
     *
     * 取得订单支付状态，成功或失败
     * @param array $param
     * @return array
     */
    public function getPayResult($param) {
        if (isset($param['trade_status'])) {
            return $param['trade_status'] == 'TRADE_SUCCESS';
        } else {
            $result = explode('-', $param['out_trade_no']);
            $out_trade_no = $result['1'];  //返回的支付单号
            $RequestBuilder = new AlipayTradeQueryContentBuilder();
            $RequestBuilder->setTradeNo($param['trade_no']);
            $RequestBuilder->setOutTradeNo($out_trade_no);

            $Response = new AlipayTradeService($this->config);
            $result = $Response->Query($RequestBuilder);
            return $result->trade_status == 'TRADE_SUCCESS';
        }
    }

}
