<?php
require('config.php'); 
/** 设置时区 */
if (function_exists('date_default_timezone_set')) {
	date_default_timezone_set('PRC');
}

define('ROOT_PATH', str_replace("\\", '/', substr(__FILE__, 0, strrpos(dirname(__FILE__), DIRECTORY_SEPARATOR))).'/');

$php_self = htmlspecialchars($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
$site_url = htmlspecialchars('http://'.$_SERVER['HTTP_HOST'].substr($php_self, 0, strrpos($php_self, '/')).'/');

require('function.php');
require(ROOT_PATH.'youkephp/library/Db.php');

//判断是否已经安装过
if (file_exists(ROOT_PATH.'data/install.lock')) {
	failure('你已经安装过本系统！<br />如果还继续安装，请先删除data/install.lock，再继续');
}

// 挡掉可能的跨站请求
if (!empty($_GET) || !empty($_POST)) {
    if (empty($_SERVER['HTTP_REFERER'])) {
        exit;
    }

    $parts = parse_url($_SERVER['HTTP_REFERER']);
	if (!empty($parts['port']) && $parts['port'] != 80) {
        $parts['host'] = "{$parts['host']}:{$parts['port']}";
    }

    if (empty($parts['host']) || $_SERVER['HTTP_HOST'] != $parts['host']) {
        exit;
    }
}

//数据库
$Db_TYPE = isset($_POST['DB_TYPE'])?$_POST['DB_TYPE']:"mysql";;
$Db_HOST = addslashes($_POST['DB_HOST']);
$Db_PORT = addslashes($_POST['DB_PORT']);
$Db_NAME = addslashes($_POST['DB_NAME']);
$Db_USER = addslashes($_POST['DB_USER']);
$Db_PASS = addslashes($_POST['DB_PASS']);
$TABLE_PREFIX = addslashes($_POST['TABLE_PREFIX']);

//帐号
$nick_name = addslashes($_POST['username']);
$email     = addslashes($_POST['email']);

$pass      = addslashes($_POST['pass']);


if (empty($Db_PORT)) $Db_PORT = 3306;
if (empty($TABLE_PREFIX)) $TABLE_PREFIX = 'dir_';
if (empty($Db_HOST)) failure('请填写数据库地址！');
if (empty($Db_NAME)) failure('请填写数据库名称！');
if (empty($Db_USER)) failure('请填写数据库账号！');
if (empty($nick_name)) failure('请填写管理员账号！');
if (empty($email) || !is_valid_email($email)) failure('请填写有效的电子邮箱！');
if (empty($pass)) failure('请填写登录密码！');
   //用户名验证码
    if(!preg_match("/[a-zA-Z0-9]{3,50}/u",$nick_name)){
       failure('用户名格式错误！');
    }
$config = array(
	'DB_HOST' => $Db_HOST,
	'DB_NAME' => $Db_NAME,
	'DB_USER' => $Db_USER,
	'DB_PASS' => $Db_PASS,
	'TABLE_PREFIX' => $TABLE_PREFIX,
);

$dbconfig = array(
	'db_user' => $Db_USER,
	'db_pass' => $Db_PASS,
	'dsn' => $Db_TYPE.":host=".$Db_HOST.";dbname=".$Db_NAME.";post=".$Db_PORT	
);

try{
	  $Db = new Db($dbconfig);
}catch(Exception $e){
	  	failure('数据库不存在 '.$Db_NAME.'，请先创建数据库！<br>错误代码：'.$e->getMessage());
} 


// 修改数据库连接字符集为 utf8

$Db->query("SET NAMES utf8");

$res = $Db->query("select version() as version");

//如果指定数据库不存在，则尝试创建
if ($res[0]['version'] > '4.1') {
	 $Db->query("CREATE DATABASE IF NOT EXISTS `".$Db_NAME."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;");
} else {
	 $Db->query("CREATE DATABASE IF NOT EXISTS `".$Db_NAME."`");
}
	
// //选择数据库
try{
   $Db->query("use `$Db_NAME`");
 }catch(Exception $e){
   failure('无法选择数据库，数据库可能不存在！<br>错误代码：'.$e->getMessage());
 }

//替换表前缀
$sql_array = replace_sql(ROOT_PATH.'data/sql/db.sql', 'yk365_', $TABLE_PREFIX);
	
//执行数据库操作
foreach ($sql_array as $sql) {
	try{
      $query = $Db->execsql($sql); //安装数据
	 }catch(Exception $e){
	   failure('数据库执行错误！<br>错误代码：'.$e->getMessage());
	 }
}



//添加账号和密码
$a = $Db->query("INSERT INTO `".$TABLE_PREFIX."users` (
	`user_type`,`nick_name`, `user_email`, `user_pass`, `user_status`, `join_time`
	) VALUES 
('admin','$nick_name','$email','".md5($pass)."',0,'".time()."');");
if(!$a){


}
//修改配置文件
$config_file = ROOT_PATH.'config.php';
if (!set_config($config, $config_file)) {
	failure('配置文件写入失败！');
}

//安装成功，创建锁定文件
$data_dir = ROOT_PATH.'data/';
if (!is_dir($data_dir)) @mkdir($data_dir);
@fopen($data_dir.'install.lock', 'w');



//安装成功，跳转到首页
success('<strong>网站安装成功！</strong><br><br>您设置的管理员帐号和密码为：<br>帐号：'.$nick_name.'<br>密码：'.$pass.'<br>');
?>