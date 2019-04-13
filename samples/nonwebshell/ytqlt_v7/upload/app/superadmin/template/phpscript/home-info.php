<?php
if (!defined('puyuetian'))
	exit('403');

$_G['TEMP']['TOTAL_USER'] = $_G['TABLE']['USER'] -> getCount();
$_G['TEMP']['TOTAL_READ'] = $_G['TABLE']['READ'] -> getCount(array('del' => 0));
$_G['TEMP']['TOTAL_REPLY'] = $_G['TABLE']['REPLY'] -> getCount(array('del' => 0));
$_G['TEMP']['SH_READ'] = $_G['TABLE']['READ'] -> getCount(array('del' => 2));
$_G['TEMP']['SH_REPLY'] = $_G['TABLE']['REPLY'] -> getCount(array('del' => 2));

$_G['TEMP']['PHP_VERSION'] = PHP_VERSION;
//PHP版本检测
if (PHP_VERSION_ID >= 70000) {
	//true
	$_G['TEMP']['PHP_VERSION'] = PHP_VERSION;
} else {
	//false
	$_G['TEMP']['PHP_VERSION'] = PHP_VERSION . "<span class='pk-text-warning fa fa-fw fa-exclamation-circle pk-cursor-pointer' title='HS7系列产品基于php7.0开发且不再保证对php5.x版本完全兼容，建议您升级php至7.0或着更高。'></span>";
}
//magic_quotes_gpc()函数关闭
if (get_magic_quotes_gpc()) {
	//true
	$_G['TEMP']['MAGIC_QUOTES_GPC'] .= "magic_quotes_gpc()函数未关闭<span class='pk-text-danger fa fa-fw fa-close pk-cursor-pointer' title='HS建议关闭该函数，否则部分功能或插件将无法正常运行'></span><a target='_blank' class='pk-hover-underline pk-text-primary' href='http://www.hadsky.com/read-1320-1.html'>magic_quotes_gpc()函数关闭方法</a>";
} else {
	//false
	$_G['TEMP']['MAGIC_QUOTES_GPC'] .= "<span class='pk-text-success fa fa-fw fa-check-circle-o'></span>正常";
}
