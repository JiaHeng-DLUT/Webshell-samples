<?php
if (!defined('puyuetian'))
	exit('Not Found puyuetian!Please contact QQ632827168');

$_G['STRING']['UPPERCASE'] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$_G['STRING']['LOWERCASE'] = 'abcdefghijklmnopqrstuvwxyz';
$_G['STRING']['NUMERICAL'] = '1234567890';
$_G['STRING']['SAFECHARS'] = $_G['STRING']['UPPERCASE'] . $_G['STRING']['LOWERCASE'] . $_G['STRING']['NUMERICAL'] . '_';
$_G['STRING']['BBCODEMARKS'] = '<b><i><u><strong><font><pre><code><p><span><table><tbody><tr><td><th><a><div><em><h1><h2><h3><h4><h5><h6><img><label><ul><ol><li><br>';
$_G['STRING']['BBCODEATTRS'] = 'class,style,href,target,src,width,height,title,alt,border,align';
$_G['DATETIME']['DATE'] = date('Y-m-d', time());
$_G['DATETIME']['TIME'] = date('H:i:s', time());
$_G['RND'] = rand(1000, 9999);
//网站域名
$_G['SYSTEM']['DOMAINS'] = explode(':', $_SERVER['HTTP_HOST']);
$_G['SYSTEM']['DOMAIN'] = strtolower($_G['SYSTEM']['DOMAINS'][0]);
$_G['SYSTEM']['PORT'] = $_G['SYSTEM']['DOMAINS'][1] ? $_G['SYSTEM']['DOMAINS'][1] : '';
//获取真实ip
if (isset($_SERVER)) {
	if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		$IPaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
		$IPaddress = $_SERVER["HTTP_CLIENT_IP"];
	} else {
		$IPaddress = $_SERVER["REMOTE_ADDR"];
	}
} else {
	if (getenv("HTTP_X_FORWARDED_FOR")) {
		$IPaddress = getenv("HTTP_X_FORWARDED_FOR");
	} else if (getenv("HTTP_CLIENT_IP")) {
		$IPaddress = getenv("HTTP_CLIENT_IP");
	} else {
		$IPaddress = getenv("REMOTE_ADDR");
	}
}
if (strpos($IPaddress, ',') !== FALSE) {
	$IPaddress = explode(',', $IPaddress);
	$IPaddress = $IPaddress[0];
}
$_G['SYSTEM']['CLIENTIP'] = $IPaddress;
unset($IPaddress);
$_G['SYSTEM']['SERVERIP'] = $_SERVER['SERVER_ADDR'];
$_G['SYSTEM']['LOCATION'] = 'http' . ($_SERVER['HTTPS'] == 'on' ? 's' : '') . "://{$_G['SYSTEM']['DOMAIN']}" . ($_G['SYSTEM']['PORT'] ? ':' . $_G['SYSTEM']['PORT'] : '') . "{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}";
$_G['SYSTEM']['REFERER'] = $_SERVER['HTTP_REFERER'];