<?php
/****************优客365网址导航系统 开源版********************/
/*                                                            */
/*  Youke365.site (C)2018 Youke365 Inc.                       */
/*  This is NOT a freeware, use is subject to license terms   */
/*  优客365网址导航开源版 个人用户可免费使用  请保留底部版权  */
/*  2018.4                                                    */
/*  官方网址：http://www.youke365.site                        */
/*  官方论坛：http://bbs.youke365.site                        */                           
/**************************************************************/
if (!defined('IN_YOUKE365')) exit('Access Denied');

/** 设置默认编码 */
header('Content-type: text/html; charset=utf-8');
// header('X-Frame-Options: SAMEORIGIN'); //只可以本站调用iframe
// set_time_limit(30);
/** 设置时区 */
if (function_exists('date_default_timezone_set')) {
	date_default_timezone_set('PRC');
}


defined('APP_PATH')      or define('APP_PATH',ROOT_PATH.'app/');

defined('YOUKE365_PATH') or define('YOUKE365_PATH',ROOT_PATH.'youkephp/');

defined('EXTEND_PATH')   or define('EXTEND_PATH',ROOT_PATH.'extend/');

defined('APP_DEBUG')     or define('APP_DEBUG',false);
/** 调试模式状态 */
if(APP_DEBUG == true){
   error_reporting(E_ALL);
   ini_set('display_errors','On');
}else{
	error_reporting(0);
	ini_set('display_errors','Off');
}

/** PHP错误日志 */
ini_set('error_log', ROOT_PATH.'runtime/log/'.date("Ymd").'.log');
ini_set('log_errors', '1');


/** SESSION */
@session_cache_limiter('private, must-revalidate');
@session_start();

/** 是否安装 */
if (!is_file(ROOT_PATH.'data/install.lock')) {
	header("Location: ../install/index.php\n");
	exit;
}


// 防止一些低级的XSS
if($_SERVER['REQUEST_URI']) {
	$temp = urldecode($_SERVER['REQUEST_URI']);
	if(strpos($temp, '<') !== false || strpos($temp, '>') !== false || strpos($temp, '(') !== false || strpos($temp, '"') !== false) {
		exit('Request Bad url');
	}
}
/** 对传入的变量进行转义 */
if(version_compare(PHP_VERSION,'5.4.0','<')) {
    ini_set('magic_quotes_runtime',0);
    define('MAGIC_QUOTES_GPC',get_magic_quotes_gpc()?True:False);
}else{
    define('MAGIC_QUOTES_GPC',false);
}


/** 默认模块 */
define('DEFAULE_MODULE', 'home'); 
/** 默认控制器 */
define('DEFAULE_CONTROLLER', 'index'); 
/** 默认操作 */
define('DEFAULE_ACTION', 'index'); 


/** 路径分隔符 */
define('PATHINFO_DEPR', '/');  //支持  "/","-", "_",  三种分隔符
// URL伪静态后缀
define('URL_HTML_SUFFIX', 'html'); 


require(YOUKE365_PATH.'library/Router.php');
/* 路由 */
$config =[
  'VAR_MODULE' => DEFAULE_MODULE,
  'VAR_CONTROLLER' =>DEFAULE_CONTROLLER

];


Router::init($config); //传入参数进行初始化
$param = Router::url(); //url方法执行，完成参数打包



$_module    = !empty($param['module'])?addslashes($param['module']):'home'; //模块  //全局
$_controller= !empty($param['controller'])?addslashes($param['controller']):'index'; //控制器 //全局
define('__MODULE__',$_module);
define('__CONTROLLER__',$_controller);

$_GET  = $Request = $param;

//禁止访问的模块列表
$mod_list = array('common');

if (in_array(__MODULE__,$mod_list)) {

    // exit('非法访问');
    header("location:/");
    exit;
}



/** 加载类 **/
require(ROOT_PATH.'vendor/autoload.php');

require(YOUKE365_PATH.'library/Mysql.php');
require(YOUKE365_PATH.'library/Db.php');
require(YOUKE365_PATH.'library/Databak.php');
require(YOUKE365_PATH.'library/FileUpload.php');
require(YOUKE365_PATH.'library/ValidationCode.php');
require(YOUKE365_PATH.'Youke.php');

/** 加载配置文件 */
if (is_file(ROOT_PATH.'config.php')) {
	require(ROOT_PATH.'config.php');
} else {
	exit('config.php file is missing!');
}

$Db = new Db();
require(YOUKE365_PATH.'common/common.php');

if(is_file(APP_PATH.'common.php')){
//包含应用公共函数文件
require(APP_PATH.'common.php');	
}

//公共控制器下的函数
if(is_dir(APP_PATH.'common/common/')){
	//自动加载公共函数资源
	$common_list = glob(APP_PATH.'common/common/*.php');
	foreach($common_list as $k=>$v){
	  if(strstr($v,'.php')){
	     require_once $v;
	  }
	}
}




require(EXTEND_PATH.'connect/oauth_qq.php');


/** 加载模板引擎 */
require(YOUKE365_PATH.'include/youke.inc.php');

if(is_file(APP_PATH.__MODULE__.'/config.php')){
//包含应用公共配置文件
require(APP_PATH.__MODULE__.'/config.php');	
}


/** 加载函数 **/

require(YOUKE365_PATH.'version.php');
require(YOUKE365_PATH.'config/auth.php');

/** 加载系统设置 */
$options = get_options();
$options = array_change_key_case($options, CASE_LOWER);
if (substr($options['site_root'], -1) != '/') {
	$options['site_root'] .= '/';
}

/** 初始化变量 */

$php_self  = htmlspecialchars($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
$base_name = basename($php_self);

$site_root = substr($php_self, 0, -strlen($base_name));


$site_url  = htmlspecialchars('http://'.$_SERVER['HTTP_HOST'].substr($php_self, 0, strrpos($php_self, '/')).'/');

$timescope  = array('0' => '所有时间内', '1' => '24小时内', '3' => '三天内', '7' => '一周内', '30' => '一月内', '365' => '一年内');

$deal_types = array('1'=>'出售','2'=>'交换'); $link_types = array('1'=>'文字','2'=>'图片');
$link_pos   = array('1'=>'首页','2'=>'内页','3'=>'全站'); 


// 自定义常量
define('SITE_ROOT',$site_root);
define('SITE_URL', $site_url);
define('SITE_NAME',$options['site_name']);
define('__PUBLIC__',ROOT_PATH."public/");


define('__ROOTSTARP_CSS__','/public/bootstrap/css/');
define('__ROOTSTARP_JS__','/public/bootstrap/js/');


//包含模块下的公共函数文件
$fuc_path = APP_PATH.__MODULE__.'/common.php';

if(is_file($fuc_path)){
   require (APP_PATH.__MODULE__.'/common.php');
}

$controller_path = ROOT_PATH.APP_PATH.__MODULE__.'/controller/'.__CONTROLLER__.'.php';

if (is_file($controller_path)) {
	require($controller_path);
}
else{
	header('location:/');
}

