<?php
/*
 * puyuetianPHP轻框架 调用入口
 * 作者：蒲乐天（puyuetian）
 * QQ：632827168
 * 官网：http://www.puyuetian.com
 *
 * 作者允许您转载和使用，但必须注明来自puyuetianPHP轻框架。
 */
/********************************************
 puyuetianPHP框架启动的初始设置
 *******************************************/
define('puyuetian', 'www.puyuetian.com');
//全局通用数组
$_G = array();
//时区设置
date_default_timezone_set('PRC');
//程序启动时间记录
$_G['SYSTEM']['STARTTIME'] = microtime(TRUE);
//开启session会话
ini_set('session.cookie_httponly', TRUE);
session_start();
//全局编码定义
//header('Content-Type: text/html; charset=utf-8');
//框架运行的目录路径
$_G['SYSTEM']['PATH'] = dirname(__FILE__) . '/';
//获取当前主脚本文件名无后缀
$_G['SYSTEM']['CURRENT_PHP_SCRIPT_NAME'] = strtolower(basename(end(explode('/', $_SERVER['SCRIPT_NAME'])), '.php'));
if ($_G['SYSTEM']['CURRENT_PHP_SCRIPT_NAME'] == 'puyuetian') {
	exit('Not allowed');
}
/********************************************
 puyuetianPHP框架公用变量
 *******************************************/
require $_G['SYSTEM']['PATH'] . 'puyuetian/vars.php';
/********************************************
 puyuetianPHP框架系统函数
 *******************************************/
require $_G['SYSTEM']['PATH'] . 'puyuetian/function.php';
/********************************************
 路径检测
 *******************************************/
if ($_G['SYSTEM']['CURRENT_PHP_SCRIPT_NAME'] == 'index') {
	$_a = strtolower($_SERVER['REQUEST_URI']);
	$_b = strpos($_a, 'index.php') + 9;
	$_c = substr($_a, $_b, 1);
	if ($_c == '/') {
		exit('Path not allowed');
	}
	unset($_a, $_b, $_c);
}
/********************************************
 GET安全
 *******************************************/
foreach ($_GET as $key => $value) {
	$_G['GET'][strtoupper($key)] = Cstr($value, FALSE, TRUE, 1, 255);
}
$_G['GET']['C'] = strtolower($_G['GET']['C']);
unset($key, $value);
/********************************************
 puyuetianPHPIP管理机制
 *******************************************/
require $_G['SYSTEM']['PATH'] . 'puyuetian/ips/ips.php';
/********************************************
 puyuetianPHP访问控制机制
 *******************************************/
require $_G['SYSTEM']['PATH'] . 'puyuetian/access.php';
/********************************************
 puyuetianPHP缓存机制
 *******************************************/
require $_G['SYSTEM']['PATH'] . 'puyuetian/cache/config.php';
require $_G['SYSTEM']['PATH'] . 'puyuetian/cache/cache.php';
/********************************************
 mysql数据库的连接与初步设置
 *******************************************/
require $_G['SYSTEM']['PATH'] . 'puyuetian/mysql/config.php';
require $_G['SYSTEM']['PATH'] . 'puyuetian/mysql/class.php';
require $_G['SYSTEM']['PATH'] . 'puyuetian/mysql/install.php';
/********************************************
 puyuetianPHP框架扩展部分
 *******************************************/
require $_G['SYSTEM']['PATH'] . 'puyuetian/ext.php';
/********************************************
 框架加载完成，展示用户访问页
 *******************************************/
require $_G['SYSTEM']['PATH'] . 'puyuetian/load.php';
/********************************************
 获取框架加载的时间
 *******************************************/
$_G['SYSTEM']['COMPLETETIME'] = microtime(TRUE);
//框架加载完成所需要的总时间（秒）
$_G['SYSTEM']['LOADTIMES'] = (int)(($_G['SYSTEM']['COMPLETETIME'] * 100000) - ($_G['SYSTEM']['STARTTIME'] * 100000)) / 100000;
/********************************************
 整理待输出的HTML
 *******************************************/
require $_G['SYSTEM']['PATH'] . 'puyuetian/output.php';
