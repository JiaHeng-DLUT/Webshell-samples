<?php
if (!defined('puyuetian'))
	exit('403');

$domain = $_G['SYSTEM']['DOMAIN'];
$createtime = time();
//固定60秒，不可更改，否则无效
$timeout = 60;
$sitekey2 = md5(md5($domain) . md5($_G['SET']['APP_HADSKYCLOUDSERVER_SITEKEY']) . md5($createtime) . md5($timeout));
$url = "http://www.hadsky.com/index.php?c=app&a=zhanzhang:index4&s=synccloudorder&domain={$domain}&createtime={$createtime}&timeout={$timeout}&sitekey2={$sitekey2}&rnd={$_G['RND']}";
$opts = array('http' => array('method' => 'GET', 'timeout' => 5));
$bkdata = file_get_contents($url, FALSE, stream_context_create($opts));
if (!$bkdata) {
	exit('communication failure<script>setTimeout(function(){location.href="index.php?c=app&a=hadskycloudserver:index&s=cloudpayrecord"},2000)</script>');
}
//exit($bkdata);
$bkdata = json_decode($bkdata, TRUE);
if ($bkdata['state'] != 'ok') {
	$bkdata['msg'] ? exit($bkdata['msg'] . '<script>setTimeout(function(){location.href="index.php?c=app&a=hadskycloudserver:index&s=cloudpayrecord"},2000)</script>') : exit('data is invalid<script>//setTimeout(function(){location.href="index.php?c=app&a=hadskycloudserver:index&s=cloudpayrecord"},2000)</script>');
}

$orders = $bkdata['data'];

foreach ($orders as $order) {
	//防止二次重复充值
	if ($_G['TABLE']['APP_HADSKYCLOUDSERVER_CLOUDPAY_RECORD'] -> getData(array('hs_id' => $order['hs_id']))) {
		continue;
	}
	$array = array();
	$array['hs_id'] = $order['hs_id'];
	$array['createtime'] = $order['createtime'];
	$array['uid'] = $order['uid'];
	$array['rmb'] = Cnum($order['rmb']);
	$array['finishtime'] = time();
	$array['tiandou'] = Cnum($_G['SET']['APP_HADSKYCLOUDSERVER_TIANDOUDUIHUANSHU']) * $array['rmb'];
	$_G['TABLE']['APP_HADSKYCLOUDSERVER_CLOUDPAY_RECORD'] -> newData($array);
	//充值到账
	UserDataChange(array('tiandou' => $array['tiandou']), $array['uid']);
}
exit('Sync success<script>location.href="index.php?c=app&a=hadskycloudserver:index&s=cloudpayrecord"</script>');
