<?php
if (!defined('puyuetian'))
	exit('403');

//定义全局编码，防止个别exit输出乱码
header('Content-Type: text/html; charset=utf-8');
//防止跨站攻击
header('X-Frame-Options: SAMEORIGIN');

//设置备份，用于后台
$_G['SET']['EMBED_HEADMARKS_OLD'] = $_G['SET']['EMBED_HEADMARKS'];
$_G['SET']['EMBED_HEAD_OLD'] = $_G['SET']['EMBED_HEAD'];
$_G['SET']['EMBED_FOOT_OLD'] = $_G['SET']['EMBED_FOOT'];

//手机域名？
$_G['SYSTEM']['DOMAIN_S'] = explode('.', $_G['SYSTEM']['DOMAIN']);
if (InArray($_G['SET']['PHONEDOMAINS'], $_G['SYSTEM']['DOMAIN_S'][0]) || ($_G['SET']['IFPCCOMEPHONEGO'] && isphonecome())) {
	if ($_G['SET']['IFPCCOMEPHONEGO'] == 2 && !InArray($_G['SET']['PHONEDOMAINS'], $_G['SYSTEM']['DOMAIN_S'][0]) && $_GET['_PHONENOGO'] != '1') {
		if (count($_G['SYSTEM']['DOMAIN_S']) > 2) {
			$mpurl = 'http://' . current(explode(',', $_G['SET']['PHONEDOMAINS'])) . '.' . substr($_G['SYSTEM']['DOMAIN'], strlen($_G['SYSTEM']['DOMAIN_S'][0]) + 1);
		} else {
			$mpurl = 'http://' . current(explode(',', $_G['SET']['PHONEDOMAINS'])) . '.' . $_G['SYSTEM']['DOMAIN'];
		}
		header("Location:$mpurl{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}");
		exit($mpurl);
	}
	$_G['SET']['TEMPLATENAME'] = $_G['SET']['PHONETEMPLATENAME'];
	$_G['SET']['DEFAULTTEMPLATES'] = $_G['SET']['PHONEDEFAULTTEMPLATES'];
	$_G['SET']['DEFAULTPAGE'] = $_G['SET']['PHONEDEFAULTPAGE'];
}
$_G['TEMPLATE']['MAIN'] = 'main';
$_G['TEMPLATE']['HEAD'] = 'head';
$_G['TEMPLATE']['BODY'] = 'body';
$_G['TEMPLATE']['FOOT'] = 'foot';
