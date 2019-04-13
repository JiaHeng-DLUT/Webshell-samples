<?php
//调试模式TRUE，运营模式FALSE
define('DEBUG', FALSE);

//程序版本，升级必备
define('HADSKY_VERSION', '7.0.0');
if (DEBUG) {
	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);
} else {
	ini_set('display_errors', 'Off');
	error_reporting(0);
}

//安装信息检测
if (!file_exists(dirname(__FILE__) . '/install/install.locked') && file_exists(dirname(__FILE__) . '/install/')) {
	header('Location:install/index.php');
	exit('<script>location.href="install/index.php"</script>');
}

//全局框架加载
require 'puyuetian.php';

//程序升级驱动，确保程序具有写入权限，不然无法升级
require 'update.php';

//输出HTML到浏览器
finallyOutput($_G['HTML']);
