<?php
if (!defined('puyuetian'))
	exit('403');

if ($_GET['submit'] == 'yes') {
	$array = array();
	//php版本
	$array['PHP版本'] = PHP_VERSION;
	if (PHP_VERSION_ID >= 70000) {
		//php7.x
		$array['PHP版本'] .= '';
	} elseif (PHP_VERSION_ID >= 50200 && PHP_VERSION_ID <= 50699) {
		//php5.x
		$array['PHP版本'] .= '（目前该版本会影响到程序性能，建议使用PHP7）';
	} else {
		$array['PHP版本'] = FALSE;
	}

	//pdo
	$array['PDO组件'] = class_exists('pdo') ? TRUE : FALSE;

	//解压
	$array['ZIP解压'] = class_exists('ZipArchive') ? TRUE : FALSE;

	//读取文件检测
	$array['文件可读'] = is_readable($mp . 'install/mysqldata/hadsky.sql') ? TRUE : FALSE;

	//写入文件检测
	$array['文件可写'] = is_writeable($mp . 'puyuetian/mysql/config.php') ? TRUE : FALSE;

	//通讯检测
	$array['与官方通讯'] = GetPostData('http://www.hadsky.com', '', 5) ? TRUE : FALSE;

	//xml
	$array['xml文件处理'] = function_exists('simplexml_load_string') ? TRUE : FALSE;
	
	//gd
	$array['GD图片处理库'] = function_exists('gd_info') ? TRUE : FALSE;

	//json
	$array['json数据处理'] = function_exists('json_encode') ? TRUE : FALSE;

	//检测curl
	$array['启用curl功能'] = function_exists('curl_init') ? TRUE : FALSE;

	//检测scandir
	$array['启用scandir函数'] = function_exists('scandir') ? TRUE : FALSE;

	//检测fsockopen
	$array['启用fsockopen函数'] = function_exists('fsockopen') ? TRUE : FALSE;

	//检测get_magic_quotes_gpc()
	$array['禁用magic_quotes_gpc函数'] = get_magic_quotes_gpc() ? '请关闭该函数' : TRUE;

	ExitJson($array, TRUE);
}

$HTMLCODE .= template("{$tpath}checkup.hst", TRUE);
