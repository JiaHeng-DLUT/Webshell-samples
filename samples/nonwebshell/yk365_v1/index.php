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
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.4.0','<='))  die('require PHP >=5.4');

 // 网站根目录 
define('ROOT_PATH', str_replace('\\', '/', dirname(__FILE__)).'/'); 
 // 应用目录
define('APP_PATH','app/');   

 // 调试模式 
define('APP_DEBUG',false);  //true 开启调试模式 false 关闭

// 防止恶意访问
define('IN_YOUKE365', true);



require(ROOT_PATH.'client/auth.php');

//* 加载初始化文件 */
require(ROOT_PATH.'youkephp/start.php');

