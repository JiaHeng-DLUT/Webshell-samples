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
$pagename = '';
$pageurl  = url('diypage');
$tempfile = 'diypage.html';
$table    = table('pages');

$page_id  = I('get.pid','','intval');
$cache_id = $page_id;
		
if (!$Youke->isCached($tempfile, $cache_id)) {
	$page = get_one_page($page_id);
	if (!$page) {
		unset($page);
		redirect('/');
	}
	
	$Youke->assign('site_title', $page['page_name'].' - '.$options['site_title']);
	$Youke->assign('site_keywords', $options['site_keywords']);
	$Youke->assign('site_description', $options['site_description']);
    $Youke->assign('page_id', $page_id);
	$Youke->assign('page', $page);
}
		
Youke_display($tempfile, $cache_id);
