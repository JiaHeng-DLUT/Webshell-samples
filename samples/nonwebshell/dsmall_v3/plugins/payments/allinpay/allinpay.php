<?php

class allinpay
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
        $paytype=input('param.paytype');
        $acct=input('param.acct');
		$params = array();
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
                return $rspArray['payinfo'];
            }else{
                halt($rspArray);
            }

    }

    public function verify_notify() {
        $notify_result = array(
                'trade_status' => '0',
            );
	$params = array();
	foreach($_POST as $key=>$val) {//动态遍历获取所有收到的参数,此步非常关键,因为收银宝以后可能会加字段,动态获取可以兼容由于收银宝加字段而引起的签名异常
		$params[$key] = $val;
	}
	if(count($params)>0){//如果参数为空,则不进行处理
            if(\AppUtil::ValidSign($params, $this->config['allinpay_key'])){//验签成功
//            trace('allinpay:'.var_export($params,true),'error');
                    //此处进行业务逻辑处理
                $temp=explode('_',$params['cusorderid']);
                $notify_result = array(
                    'out_trade_no' => $temp[0], #商户订单号
                    'trade_no' => $params['trxid'], #交易凭据单号
                    'total_fee' => $params['trxid'] / 100, #涉及金额
                    'order_type' => str_replace($temp[0].'_','',$params['cusorderid']),
                    'trade_status' => '1',
                );
            }
	}

        return $notify_result;
    }
}