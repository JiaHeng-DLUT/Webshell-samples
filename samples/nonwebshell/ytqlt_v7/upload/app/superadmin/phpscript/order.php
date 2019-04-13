<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['GET']['SUBMIT']) {
	$rqurl = "http://www.hadsky.com/index.php?c=app&a=zhanzhang:index6&s=post&domain={$_G['SYSTEM']['DOMAIN']}&sitekey=" . md5($_G['SET']['APP_HADSKYCLOUDSERVER_SITEKEY']);
	$string = '';
	foreach ($_POST as $key => $value) {
		$string .= $key . '=' . urlencode($value) . '&';
	}
	if (!$string) {
		ExitJson('数据出错');
	}
	$jd = json_decode(GetPostData($rqurl, $string, 5), TRUE);
	if (!$jd) {
		ExitJson('返回数据错误');
	}
	if ($jd['state'] != 'ok') {
		ExitJson($jd['datas']['msg']);
	}
	ExitJson($jd['datas']['msg'], TRUE);
}

if ($_G['GET']['GETLIST']) {
	$rqurl = "http://www.hadsky.com/index.php?c=app&a=zhanzhang:index6&s=getpost&domain={$_G['SYSTEM']['DOMAIN']}&sitekey=" . md5($_G['SET']['APP_HADSKYCLOUDSERVER_SITEKEY']);
	$jd = json_decode(GetPostData($rqurl, '', 5), TRUE);
	if (!$jd) {
		ExitJson('返回数据错误');
	}
	if ($jd['state'] != 'ok') {
		ExitJson($jd['datas']['msg']);
	}
	ExitJson($jd['datas'], TRUE);
}

$contenthtml = template('superadmin:order-' . $_G['GET']['T'], TRUE);
