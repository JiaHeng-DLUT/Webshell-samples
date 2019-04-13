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

$pagename = '会员中心';
$pageurl = url('home');
$tplfile = 'home.html';
//判断是否登陆
$userinfo = is_login();


if (!$Youke->isCached($tplfile)) {
$table = table('website');
$where = "w.user_id=".$userinfo['user_id'];
$total = $Db->getCount($table.' w','*',$where);
$Youke->assign('userinfo', $userinfo);
$Youke->assign('total',$total);


	$Youke->assign('pagename', $pagename);
	$Youke->assign('site_title', $pagename.' - '.$options['site_name']);

}

Youke_display($tplfile);
