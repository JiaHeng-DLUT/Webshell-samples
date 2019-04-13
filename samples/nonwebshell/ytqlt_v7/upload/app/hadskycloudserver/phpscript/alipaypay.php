<?php
if (!defined('puyuetian'))
	exit('403');

//5.2.0及以前版本的校验机制，存在漏洞已废弃
//$sitekey2 = md5(md5($_G['SYSTEM']['DOMAIN']) . md5($_G['SET']['APP_HADSKYCLOUDSERVER_SITEKEY']) . md5($_GET['createtime']) . md5($_GET['timeout']));
//5.2.1版本后的新安全机制
$sitekey3 = md5(md5($_G['SYSTEM']['DOMAIN']) . md5($_G['SET']['APP_HADSKYCLOUDSERVER_SITEKEY']) . md5($_GET['createtime']) . md5($_GET['timeout']) . md5($_G['GET']['S']) . md5($_GET['safernd']));
if (Cnum($_GET['createtime']) + Cnum($_GET['timeout']) > time() && $_GET['sitekey3'] == $sitekey3) {
	$data = json_decode($_GET['data'], TRUE);
	//防止二次重复充值
	if ($_G['TABLE']['APP_HADSKYCLOUDSERVER_CLOUDPAY_RECORD'] -> getData(array('hs_id' => $data['hs_id']))) {
		exit('ok');
	}
	$array = array();
	$array['hs_id'] = $data['hs_id'];
	$array['createtime'] = Cnum($data['createtime']);
	$array['uid'] = Cnum($data['uid']);
	$array['rmb'] = Cnum($data['rmb'] * 100) / 100;
	$array['finishtime'] = time();
	$array['tiandou'] = Cnum($_G['SET']['APP_HADSKYCLOUDSERVER_TIANDOUDUIHUANSHU']) * $array['rmb'];
	$_G['TABLE']['APP_HADSKYCLOUDSERVER_CLOUDPAY_RECORD'] -> newData($array);
	//充值到账
	UserDataChange(array('tiandou' => $array['tiandou']), $array['uid']);
	exit('ok');
} else {
	exit('no');
}
