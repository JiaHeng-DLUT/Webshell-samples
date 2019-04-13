<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2011-0501 koyshe <koyshe@gmail.com>
 */
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('PRC');
header('Content-Type: text/html; charset=utf-8');
ini_set("session.cookie_httponly", 1);

//#################=====关闭register_globals=====#################//
if (@ini_get('register_globals')) {
	foreach ($_REQUEST as $name => $value) unset($$name);
}

//#################=====引入基本类库=====#################//
include(dirname(__FILE__).'/config.php');
include(dirname(__FILE__).'/hook/ini.hook.php');
include(dirname(__FILE__).'/include/class/db.class.php');
include(dirname(__FILE__).'/include/class/cache.class.php');
include(dirname(__FILE__).'/include/class/page.class.php');
include(dirname(__FILE__).'/include/function/global.func.php');
include(dirname(__FILE__).'/include/function/license.func.php');
include(dirname(__FILE__).'/hook/notice.hook.php');

//#################=====检测手机模式=====#################//
$pe['mobile'] = pe_mobile();
if ($pe['mobile'] && in_array($module, array('index', 'user'))) $module = "mobile_{$module}";

//#################=====定义模板路径=====#################//
$cache_setting = cache::get('setting');
$module_tpl = is_dir("{$pe['path_root']}template/{$cache_setting['web_tpl']}/{$module}/") ? $cache_setting['web_tpl'] : 'default';
$pe['host_tpl'] = "{$pe['host_root']}template/{$module_tpl}/{$module}/";
$pe['path_tpl'] = "{$pe['path_root']}template/{$module_tpl}/{$module}/";

//#################=====定义GPC变量=====#################//
if (get_magic_quotes_gpc()) {
	!empty($_GET) && extract(pe_trim(pe_stripslashes($_GET)), EXTR_PREFIX_ALL, '_g');
	!empty($_POST) && extract(pe_trim(pe_stripslashes($_POST)), EXTR_PREFIX_ALL, '_p');
}
else {
	!empty($_GET) && extract(pe_trim($_GET),EXTR_PREFIX_ALL,'_g');
	!empty($_POST) && extract(pe_trim($_POST),EXTR_PREFIX_ALL,'_p');
}
session_start();
//pe_setcookie(session_name(), session_id(), 86400);
!empty($_SESSION) && extract(pe_trim($_SESSION),EXTR_PREFIX_ALL,'_s');
!empty($_COOKIE) && extract(pe_trim(pe_stripslashes($_COOKIE)),EXTR_PREFIX_ALL,'_c');
$pe_token = $_s_pe_token;
//分享记录推广用户id
if ($_g_u) pe_setcookie('tguser_id', intval($_g_u));

//#################=====连接数据库开始吧=====#################//
if (stripos($_SERVER['SCRIPT_NAME'], 'install/index.php') === false) {
	$db = new db($pe['db_host'], $pe['db_user'], $pe['db_pw'], $pe['db_name'], $pe['db_coding']);
}
?>