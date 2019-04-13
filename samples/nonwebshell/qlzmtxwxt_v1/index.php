<?php
// +----------------------------------------------------------------------
// | 奇乐自媒体内容管理系统 商业版 2019
// +----------------------------------------------------------------------
// | 官方网址：http://www.qilecms.com
// +----------------------------------------------------------------------
// | 官方论坛：http://bbs.qilecms.com
// +----------------------------------------------------------------------
// | Author:奇乐网络
// +----------------------------------------------------------------------
// | 版权说明：本产品为商业版，请授权后使用,否则将追究法律责任 
// +----------------------------------------------------------------------


namespace think;

// 检测PHP环境
if(version_compare(PHP_VERSION,'7.0','<'))  die('require PHP > 7.0.0 !');

if(version_compare(PHP_VERSION,'7.1','>'))  die('require PHP < 7.1 !');


// 只允许本站调用iframe
header('X-Frame-Options:SAMEORIGIN');
// 定义根目录
define('QL_ROOT',str_replace('\\','/',dirname(__FILE__)).'/');

// 定义应用目录
define('APP_PATH', __DIR__.'/qilecms/');

//定义插件目录
define('ADDONS_path', __DIR__.'/addons/'); 
// extend 
define('EXTEND_PATH', __DIR__.'/extend/'); 


// 加载框架引导文件
require __DIR__.'/thinkphp/base.php';

// 检查是否安装
if(!is_file(QL_ROOT.'data/install.lock')) {
     Container::get('app')->path(APP_PATH)->bind('install/index')->run()->send();  
}else{
	 Container::get('app')->path(APP_PATH)->run()->send();
}


