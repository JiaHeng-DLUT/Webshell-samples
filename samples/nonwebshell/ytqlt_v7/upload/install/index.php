<?php
/*
 * HadSky - 安装程序
 * 作者：蒲乐天
 * QQ：632827168
 */
//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'Off');
error_reporting(0);
if (file_exists(dirname(__FILE__) . '/install.locked')) {
	exit("install locked!");
}
date_default_timezone_set('PRC');
header('Content-Type: text/html;charset=utf-8');

define('puyuetian', 'hadsky.com');
//基础框架加载
$mp = dirname(__FILE__) . '/../';
require "{$mp}puyuetian/vars.php";
require "{$mp}puyuetian/function.php";
$_G['SET']['RUNERRORDISPLAY'] = 1;
//模板路径所在
$tpath = dirname(__FILE__) . '/template/';

$step = Cnum($_GET['step'], 0);

switch ($step) {
	case 0 :
		require dirname(__FILE__) . '/phpscript/checkup.php';
		break;
	case 1 :
		$HTMLCODE .= template("{$tpath}useragreement.hst", TRUE);
		break;
	case 2 :
		require dirname(__FILE__) . '/phpscript/environment.php';
		break;
	case 3 :
		require dirname(__FILE__) . '/phpscript/install.php';
		break;
	case 4 :
		if ($_GET['chkcode'] != 'HadSkyInstallComplete') {
			exit('no chkcode');
		}
		require dirname(__FILE__) . '/phpscript/complete.php';
		break;
	default :
		$error = "无效的参数！";
		template("{$tpath}htmltip.hst");
		exit();
		break;
}

template("{$tpath}frame.hst");
