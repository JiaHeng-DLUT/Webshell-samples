<?php

class allinpay_h5
{
    const DEBUG = 0;

    protected $config;

    public function __construct($payment_info = array())
    {
        require_once PLUGINS_PATH . '/payments/allinpay/lib/AppUtil.php';
        $this->config=$payment_info['payment_config'];
    }
    /*mweb_url*/
    public function get_payform($order_info){
        $params = array();
        $paytype=$this->config['sub_payment_code'];
        if($paytype=='W06'){
            $acct=input('param.openid');
            $params["sub_appid"] = $this->config['allinpay_sub_appid2'];
        }else{
            require_once PLUGINS_PATH . '/payments/wxpay_native/WxPay.JsApiPay.php';
            define('WXN_APPID', $this->config['allinpay_sub_appid1']);
            define('WXN_APPSECRET', $this->config['allinpay_sub_appsecret1']);
            //获取用户openid
            $tools = new JsApiPay();
            $acct = $tools->GetOpenid();
            $params["sub_appid"] = $this->config['allinpay_sub_appid1'];
        }
		
		$params["cusid"] = $this->config['allinpay_mch_id'];
	    $params["appid"] = $this->config['allinpay_appid'];
	    $params["version"] = '11';
	    $params["trxamt"] = bcmul($order_info['api_pay_amount'] , 100);
	    $params["reqsn"] = $order_info['pay_sn'].'_'.$order_info['order_type'];//订单号,自行生成
	    $params["paytype"] = $paytype;
	    $params["randomstr"] = TIMESTAMP.rand(1000,9999);//
	    $params["body"] = config('site_name') . $order_info['pay_sn'] . '订单';
	    $params["acct"] = $acct;
        $params["notify_url"] = str_replace('/index.php', '', HOME_SITE_URL) . '/payment/allinpay_notify.html';
	    $params["sign"] = \AppUtil::SignArray($params,$this->config['allinpay_key']);//签名
	    
	    $paramsStr = \AppUtil::ToUrlParams($params);
            //测试地址：https://test.allinpaygd.com/apiweb/unitorder/pay
            //测试商户号：990581007426001
            //测试appid：00000051
            //测试key：allinpay888
	    $url = "https://vsp.allinpay.com/apiweb/unitorder/pay";
	    $rsp = http_request($url,'POST', $paramsStr);
            
            $rspArray = json_decode($rsp, true); 
            if($rspArray && $rspArray['retcode']=='SUCCESS' && isset($rspArray['payinfo'])){
                $jsApiParameters=$rspArray['payinfo'];
                if($paytype=='W06'){
                    $data = array();
                    $data['code'] = '10000';
                    $data['result'] = $jsApiParameters;
                    header('Content-Type:application/json');
                    echo json_encode($data);
                    die;
                }else{
        //不同订单支付成功对应的跳转界面
        if($order_info['order_type'] == 'real_order'){
            $url = WAP_SITE_URL.'/member/order_list.html';
        }elseif ($order_info['order_type'] == 'vr_order') {
            $url = WAP_SITE_URL.'/member/order_list.html';
        } elseif ($order_info['order_type'] == 'pd_order') {
            $url = WAP_SITE_URL.'/member/pdrecharge_list.html';
        }
        $str = <<<EOT
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
<title>微信安全支付</title>
</head>
<body>
正在加载…
<script type="text/javascript">
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			$jsApiParameters,
			function(res){
                            if (res.err_msg == 'get_brand_wcpay_request:ok') {
                                //alert(lang.WeChat_pays_off);
                                self.location = "$url";
                            }else if (res.err_msg == 'get_brand_wcpay_request:cancel') {
                                //alert(lang.cancel_WeChat_payment);
                                self.location = "$url";
                            } else {
                                 //alert(lang.WeChat_payments_fail);
                                 self.location = "$url";
                            }
                            //WeixinJSBridge.log(res.err_msg);
                            //alert(res.err_code+res.err_desc+res.err_msg);
			}
		);
	}
        window.onload = function() {
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
        }
</script>
</body>
</html> 
EOT;
        echo $str;
exit;
                }
            }else{
                halt($rspArray);
            }

    }


}