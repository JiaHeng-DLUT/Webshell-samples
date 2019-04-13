<?php
/****************优客365网址导航系统 开源版********************/
/*                                                            */
/*  Youke365.site (C)2017 Youke365 Inc.                       */
/*  This is NOT a freeware, use is subject to license terms   */
/*  优客365网址导航开源版 个人用户可免费使用  请保留底部版权  */
/*  2018.4                                                    */
/*  官方网址：http://www.youke365.site                        */
/*  官方论坛：http://bbs.youke365.site                        */                           
/**************************************************************/


if (!defined('IN_YOUKE365')) exit('Access Denied');
include APP_PATH.__MODULE__.'/base.php';

$pagetitle = '管理首页';
$tempfile = 'main.html';

$server = array();
$server['datetime'] = date('Y-m-d　H:i:s');
$server['software'] = $_SERVER['SERVER_SOFTWARE'];
$server['php_version'] = PHP_VERSION;
$version =$Db->query('select VERSION() as version','Row');
$server['mysql_version'] = $version['version'];
$server['Youke_version'] = Smarty::SMARTY_VERSION;
$server['soft_version'] = SYS_VERSION.' Build '.SYS_RELEASE;

$server['globals'] = get_phpcfg('register_globals');
$server['safemode'] = get_phpcfg('safe_mode');
$server['rewrite'] = apache_mod_enabled('mod_rewrite') ? '<font color="#008800">√</font>' : '<font color="#FF0000">×</font>';


if (function_exists('memory_get_usage')) {
	$server['memory_info'] = get_real_size(memory_get_usage());
}


// //授权检测，请勿删除
// $auth_status = file_get_contents(YOUKE365_UPDATE_URL.'?a=client_check&u='.$site_url);


// //检测新版

// $get_news_version = file_get_contents(YOUKE365_UPDATE_URL.'?a=check&u='.$site_url.'&v='.SYS_VERSION);

// if(SYS_VERSION < $get_news_version && $get_news_version!= 'error'){
//   $news_version = '<span style="color:red">发现新版 v'.$get_news_version.'</span>';
// }





function get_phpcfg($varname) {
	switch ($result = get_cfg_var($varname)) {
		case 0 :
			return '<font color="#FF0000">×</font>';
			break;
		case 1 :
			return '<font color="#008800">√</font>';
			break;
		default :
			return $result;
			break;
	}
}

// $Youke->assign('news_version',$news_version);
// $Youke->assign('auth_status',$auth_status);
$Youke->assign('login_user', $myself['user_email']);
$Youke->assign('login_time',  $myself['login_time']);
$Youke->assign('login_ip',  $myself['login_ip']);
$Youke->assign('login_count', $myself['login_count']);
$Youke->assign('server',  $server);
$Youke->assign('stat', get_stats());
unset($server);

Youke_display($tempfile);

