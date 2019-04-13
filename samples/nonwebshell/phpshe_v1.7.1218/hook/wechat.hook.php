<?php
//微信绑定服务器
function wechat_bind() {
	$wechat_config = wechat_config();
	$timestamp = $_GET["timestamp"];
	$nonce = $_GET["nonce"];
	$signature = $_GET["signature"];
	if ($timestamp && $nonce && $signature) {
		$tmpArr = array($wechat_config['wechat_token'], $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = sha1(implode( $tmpArr ));
		if ($tmpStr == $signature) {
			echo $_GET["echostr"];
		}
		die();
	}
}

//微信xml格式数据
function wechat_xml($arr) {
	$xml = "<xml>";
	foreach ($arr as $k => $v) {
		if (is_numeric($v)) {
			$xml .= "<{$k}>{$v}</{$k}>";
		}
		else{
			$xml .= "<{$k}><![CDATA[{$v}]]></{$k}>";
		}
    }
    $xml .= "</xml>";
	return $xml;
}

//接收微信xml数据
function wechat_getxml() {
	return pe_getxml();
}

//发送微信xml数据
function wechat_sendxml($url, $arr, $cert = false) {
	global $pe;
	$xml = wechat_xml($arr);
	if ($cert) {
		$cert_arr['ssl_cert'] = "{$pe['path_root']}include/plugin/payment/wechat/cert/apiclient_cert.pem";
		$cert_arr['ssl_key'] = "{$pe['path_root']}include/plugin/payment/wechat/cert/apiclient_key.pem";		
	}
    return pe_curl_post($url, $xml, 'str', $cert_arr);
	//return json_decode(json_encode(simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
}

//发送微信post数据
function wechat_curlpost($url, $arr, $type = 'arr') {
	$result = pe_curl_post($url, $arr, $type);
	return json_decode($result, true);
}

//发送微信get数据
function wechat_curlget($url) {
	return pe_curl_get($url);
}

//生成微信参数签名
function wechat_sign($arr, $key) {
	if (!is_array($arr)) return '';
	//签名步骤一：按字典序排序参数
	ksort($arr);
	$sign = "";
	foreach ($arr as $k => $v) {
		if ($k != "sign" && $v != "" && !is_array($v)){
			$sign .= "{$k}={$v}&";
		}
	}
	$sign = trim($sign, "&");
	//签名步骤二：在string后加入KEY
	$sign = "{$sign}&key={$key}";
	//签名步骤三：MD5加密
	$sign = md5($sign);
	//签名步骤四：所有字符转为大写
	$result = strtoupper($sign);
	return $result;
}

//获取微信基础配置信息
function wechat_config($update = null) {
	global $db, $pe, $cache_setting;
	if (is_file("{$pe['path_root']}data/cache/wechat_config.cache.php")) {
		$wechat_config = cache::get("wechat_config");	
	}
	if ($wechat_config['time'] <= time() - 3600 * 1.5 || $wechat_config['wechat_access_token'] == '' || $update) {
		//$wechat_config['wechat_name'] = $cache_setting['wechat_name'];
		$wechat_config['wechat_appid'] = $cache_setting['wechat_appid'];
		$wechat_config['wechat_appsecret'] = $cache_setting['wechat_appsecret'];
		$wechat_config['wechat_token'] = $cache_setting['wechat_token'];
		//获取基础access_token
		$json = wechat_curlget("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$wechat_config['wechat_appid']}&secret={$wechat_config['wechat_appsecret']}");
		$json = json_decode($json, true);
		$wechat_config['wechat_access_token'] = $json['access_token'];
		//获取jsapi_ticket
		$json = wechat_curlget("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$wechat_config['wechat_access_token']}&type=jsapi");
		$json = json_decode($json, true);
		$wechat_config['wechat_jsapi_ticket'] = $json['ticket'];
		//获取微信支付信息
		$cache_payment = cache::get('payment');
		$payment = $cache_payment['wechat']['payment_config'];
		$wechat_config['wechat_pay_appid'] = $payment['wechat_appid'];
		$wechat_config['wechat_mchid'] = $payment['wechat_mchid'];
		$wechat_config['wechat_key'] = $payment['wechat_key'];
		$wechat_config['notify_url'] = "{$pe['host_root']}include/plugin/payment/wechat/notify_url.php";
		$wechat_config['refund_url'] = "{$pe['host_root']}include/plugin/payment/wechat/refund_url.php";
		$wechat_config['time'] = time();
		cache::write("wechat_config", $wechat_config);
	}
	return $wechat_config;
}

//设置微信自定义菜单
function wechat_setmenu($json = '') {
	global $db;
	$wechat_config = wechat_config();
	if ($json) {
		//$json = preg_replace_callback("|(http://[^(\"\|')]+)|", "wechat_menuurl", $json);
		wechat_curlpost("https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$wechat_config['wechat_access_token']}", $json);	
	}
}

//自定义菜单拼接url
/*function wechat_menuurl($match) {
	global $pe, $wechat_config;
	//$wechat_config = wechat_config();
	if (stripos($match[1], trim($pe['host_root'], '/')) === false) {
		return $match[1];
	}
	else {
		return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$wechat_config['wechat_appid']}&redirect_uri=".urlencode($match[1])."&response_type=code&scope=snsapi_userinfo&state=phpshe_wechat#wechat_redirect";
	}
}*/

//获取微信用户昵称
function wechat_username($user_name) {
	/*global $db;
	if ($user_name) {
		preg_match_all("/./u", $user_name, $arr);
		$user_name = $arr[0];
		$user_name = array_map('wechat_username_callback', $user_name);
		$user_name = implode('', $user_name);
	}
	if (!$user_name or $db->pe_num('user', array('user_name'=>pe_dbhold($user_name)))) {
		$user_name = 'wx_'.time().rand(0,9);
	}*/
	$user_name = trim($user_name);
	if (!function_exists('wechat_username_nn')) {
		function wechat_username_nn($match) { 
			return strlen($match[0]) >= 4 ? "" : $match[0];	
		}
	}
	$user_name = preg_replace_callback('/./u', "wechat_username_nn", $user_name);
	/*if (version_compare(PHP_VERSION, '5.3', '<')) {
    	$user_name = preg_replace_callback('/./u', create_function('$match','return strlen($match[0]) >= 4 ? "" : $match[0];'), $user_name);	
	}
	else {
    	$user_name = preg_replace_callback('/./u', function($match) {
    		return strlen($match[0]) >= 4 ? "" : $match[0];
    	}, $user_name);
	}*/
	$user_name = $user_name ? $user_name : 'wx'.time().rand(0,9);
	return $user_name;
}


//微信支付（pc扫码）
function wechat_webpay($order_id) {
	global $db, $pe;
	$wechat_config = wechat_config();
	$order = $db->pe_select(order_table($order_id), array('order_id'=>pe_dbhold($order_id)));
	if ($order['order_state'] != 'wpay') {
		return array('result'=>false, 'show'=>'请勿重复支付');		
	}
	//统一下单接口
	$xml_arr['appid'] = $wechat_config['wechat_pay_appid'];
	$xml_arr['mch_id'] = $wechat_config['wechat_mchid'];
	$xml_arr['device_info'] = 'WEB';
	$xml_arr['nonce_str'] = md5(microtime(true).pe_ip().'koyshe+andrea');
	$xml_arr['body'] = pe_cut($order['order_name'], 13, '...');
	$xml_arr['out_trade_no'] = "{$order['order_id']}_".rand(100,999);
	$xml_arr['total_fee'] = $order['order_money']*100;
	$xml_arr['spbill_create_ip'] = pe_ip();
	$xml_arr['notify_url'] = $wechat_config['notify_url'];
	$xml_arr['trade_type'] = 'NATIVE';
	$xml_arr['sign'] = wechat_sign($xml_arr, $wechat_config['wechat_key']);
	//发送xml下单请求
	$json = wechat_sendxml('https://api.mch.weixin.qq.com/pay/unifiedorder', $xml_arr);
	if ($json['return_code'] == 'SUCCESS' && $json['result_code'] == 'SUCCESS') {
		pe_lead('include/class/phpqrcode.class.php');
		QRcode::png($json['code_url'], "{$pe['path_root']}data/wechat_qrcode/{$order_id}.png", 'QR_ECLEVEL_L', 9);	
		return array('result'=>true, 'qrcode'=>"{$pe['host_root']}data/wechat_qrcode/{$order_id}.png");
	}
	else {
		return array('result'=>false, 'show'=>"{$json['return_msg']}");
	}
}

//微信支付（公众号）
function wechat_jspay($order_id) {
	global $db, $pe;
	$wechat_config = wechat_config();
	$order = $db->pe_select(order_table($order_id), array('order_id'=>pe_dbhold($order_id)));
	$user = $db->pe_select('user', array('user_id'=>$order['user_id']), 'user_wx_openid');
	if ($order['order_state'] != 'wpay') {
		return array('result'=>false, 'show'=>'请勿重复支付');		
	}
	//统一下单接口
	$xml_arr['appid'] = $wechat_config['wechat_pay_appid'];
	$xml_arr['mch_id'] = $wechat_config['wechat_mchid'];
	$xml_arr['device_info'] = 'WEB';
	$xml_arr['nonce_str'] = md5(microtime(true).pe_ip().'koyshe+andrea');
	$xml_arr['body'] = pe_cut($order['order_name'], 13, '...');
	$xml_arr['out_trade_no'] = "{$order['order_id']}_".rand(100,999);
	$xml_arr['total_fee'] = $order['order_money']*100;
	$xml_arr['spbill_create_ip'] = pe_ip();
	$xml_arr['notify_url'] = $wechat_config['notify_url'];
	$xml_arr['trade_type'] = 'JSAPI';
	$xml_arr['openid'] = $user['user_wx_openid'];
	$xml_arr['sign'] = wechat_sign($xml_arr, $wechat_config['wechat_key']);
	//发送xml下单请求
	$json = wechat_sendxml('https://api.mch.weixin.qq.com/pay/unifiedorder', $xml_arr);
	if ($json['return_code'] == 'SUCCESS' && $json['result_code'] == 'SUCCESS') {
		$info_arr['appId'] = $wechat_config['wechat_pay_appid'];
		$info_arr['timeStamp'] = strval(time());
		$info_arr['nonceStr'] = md5(microtime(true).pe_ip().'koyshe+andrea');
		$info_arr['package'] = "prepay_id={$json['prepay_id']}";
		$info_arr['signType'] = 'MD5';
		$info_arr['paySign'] = wechat_sign($info_arr, $wechat_config['wechat_key']);
		$url_arr = order_pay_goto($order_id, 0);
		$url = $url_arr['url'];
		return array('result'=>true, 'info'=>$info_arr, 'url'=>$url);
	}
	else {
		return array('result'=>false, 'show'=>"{$json['return_msg']}");
	}
}

//微信支付（h5支付）
function wechat_h5pay($order_id) {
	global $db, $pe;
	$wechat_config = wechat_config();
	$order = $db->pe_select(order_table($order_id), array('order_id'=>pe_dbhold($order_id)));
	$user = $db->pe_select('user', array('user_id'=>$order['user_id']), 'user_wx_openid');
	if ($order['order_state'] != 'wpay') {
		return array('result'=>false, 'show'=>'请勿重复支付');		
	}
	//统一下单接口
	$xml_arr['appid'] = $wechat_config['wechat_pay_appid'];
	$xml_arr['mch_id'] = $wechat_config['wechat_mchid'];
	$xml_arr['device_info'] = 'WEB';
	$xml_arr['nonce_str'] = md5(microtime(true).pe_ip().'koyshe+andrea');
	$xml_arr['body'] = pe_cut($order['order_name'], 13, '...');
	$xml_arr['out_trade_no'] = "{$order['order_id']}_".rand(100,999);
	$xml_arr['total_fee'] = $order['order_money']*100;
	$xml_arr['spbill_create_ip'] = pe_ip();
	$xml_arr['notify_url'] = $wechat_config['notify_url'];
	$xml_arr['trade_type'] = 'MWEB';
	$xml_arr['scene_info'] = '{"h5_info": {"type":"Wap","wap_url": "'.$pe['host_root'].'","wap_name": "微信-支付"}}';
	$xml_arr['openid'] = $user['user_wx_openid'];
	$xml_arr['sign'] = wechat_sign($xml_arr, $wechat_config['wechat_key']);
	//发送xml下单请求
	$json = wechat_sendxml('https://api.mch.weixin.qq.com/pay/unifiedorder', $xml_arr);
	if ($json['return_code'] == 'SUCCESS' && $json['result_code'] == 'SUCCESS') {
		return array('result'=>true, 'url'=>$json['mweb_url']);
	}
	else {
		return array('result'=>false, 'show'=>"{$json['return_msg']}");
	}
}

//微信支付退款
function wechat_refund($refund_id) {
	global $db, $pe;
	$wechat_config = wechat_config();
	$info = $db->pe_select('refund', array('refund_id'=>$refund_id));
	$order = $db->pe_select(order_table($info['order_id']), array('order_id'=>$info['order_id']));
	//退款接口
	$xml_arr['appid'] = $wechat_config['wechat_pay_appid'];
	$xml_arr['mch_id'] = $wechat_config['wechat_mchid'];
	$xml_arr['nonce_str'] = md5(microtime(true).pe_ip().'koyshe+andrea');
	$xml_arr['sign_type'] = 'MD5';
	$xml_arr['transaction_id'] = $order['order_outid'];
	$xml_arr['out_refund_no'] = $info['refund_id'];
	$xml_arr['total_fee'] = $order['order_money']*100;
	$xml_arr['refund_fee'] = $info['refund_money']*100;
	$xml_arr['refund_desc'] = $info['refund_text'];
	$xml_arr['notify_url'] = $wechat_config['refund_url'];
	$xml_arr['sign'] = wechat_sign($xml_arr, $wechat_config['wechat_key']);
	//发送xml下单请求
	$json = wechat_sendxml('https://api.mch.weixin.qq.com/secapi/pay/refund', $xml_arr, true);
	if ($json['return_code'] == 'SUCCESS' && $json['result_code'] == 'SUCCESS') {
		$result = 'success';
		//$show = '';
		//return array('result'=>true);
	}
	else {
		$result = $json['return_msg'];
		//$result = false;
		//$show = $json['return_msg'];
		//return array('result'=>false, 'show'=>"{$json['return_msg']}");
	}
	$sql_set['refund_outid'] = $json['refund_id'];
	$sql_set['refund_presult'] = $result;
	$db->pe_update('refund', array('refund_id'=>$refund_id), pe_dbhold($sql_set));
	return array('result'=>$result, 'show'=>$show);
}

//添加微信模板
function wechat_notice_addtpl($tpl_id) {
	$wechat_config = wechat_config();
	$json = wechat_curlpost("https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token={$wechat_config['wechat_access_token']}", array('template_id_short'=>$tpl_id), 'json');
	if ($json['errcode'] == 0) {
		return array('result'=>true, 'id'=>$json['template_id']);
	}
	else {
		return array('result'=>false, 'show'=>$json['errmsg']);
	}
}

//删除微信模板
function wechat_notice_deltpl($tpl_id) {
	$wechat_config = wechat_config();
	$json = wechat_curlpost("https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token={$wechat_config['wechat_access_token']}", array('template_id'=>$tpl_id), 'json');
	if ($json['errcode'] == 0) {
		return array('result'=>true);
	}
	else {
		return array('result'=>false, 'show'=>$json['errmsg']);
	}
}

//发送微信模板通知
function wechat_notice($info) {
	global $db;
	$wechat_config = wechat_config();
	if ($info['user_wx_openid']) {
		$json_arr['touser'] = $info['user_wx_openid'];
		$json_arr['template_id'] = $info['noticelog_tplid'];
		$json_arr['url'] = $info['noticelog_url'];
		$json_arr['data'] = unserialize($info['noticelog_data']);
		//$json_arr['template_id'] = $wechat_tpl['template_id'];
		$json = wechat_curlpost("https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$wechat_config['wechat_access_token']}", $json_arr, 'json');
		if ($json['errcode'] == 0) {
			$sql_set['noticelog_state'] = 'success';
		}
		else {
			$sql_set['noticelog_state'] = 'fail';	
			$sql_set['noticelog_error'] = $json['errmsg'];
		}
	}
	else {
		$sql_set['noticelog_state'] = 'fail';	
		$sql_set['noticelog_error'] = 'user_wx_openid为空';	
	}
	$sql_set['noticelog_stime'] = time();
	$db->pe_update('wechat_noticelog', array('noticelog_id'=>$info['noticelog_id']), $sql_set);
}

//生成微信参数签名(js-sdk)
function wechat_jsapi_config($api_list, $debug = false) {
	$wechat_config = wechat_config();
	$arr['noncestr'] = md5(microtime(true).pe_ip().'koyshe+andrea');
	$arr['jsapi_ticket'] = $wechat_config['wechat_jsapi_ticket'];
	$arr['timestamp'] = time();		
	$arr['url'] = pe_nowurl();
	ksort($arr);	
	$sign = "";
	foreach ($arr as $k => $v) {
		if ($k != "sign" && $v != "" && !is_array($v)){
			$sign .= "{$k}={$v}&";
		}
	}
	$sign = trim($sign, "&");
	$sign = sha1($sign);
	$config_arr['debug'] = $debug;
	$config_arr['appId'] = $wechat_config['wechat_appid'];
	$config_arr['timestamp'] = $arr['timestamp'];
	$config_arr['nonceStr'] = $arr['noncestr'];
	$config_arr['signature'] = $sign;
	$config_arr['jsApiList'] = explode('|', $api_list);
	return "wx.config(".json_encode($config_arr).")";
};

//检测是否关注公众号
function wechat_check_follow($user = array()) {
	global $db;
	$wechat_config = wechat_config();
	$json = wechat_curlget("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$wechat_config['wechat_access_token']}&openid={$user['user_wx_openid']}&lang=zh_CN");
	$json = json_decode($json, true);
	if ($json['errcode']) return false;
	pe_lead('hook/user.hook.php');
	if ($json['subscribe']) {
		user_follow_callback($user, 1);
	}
	else {
		user_follow_callback($user, 0);
	}
}
?>