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
$pagename = '友情链接';
$pageurl  = '?mod=link';
$tempfile = 'link.html';
$table    = table('links');

$pagesize = 10;
$curpage = I('get.page','','intval');
if ($curpage > 1) {
	$start = ($curpage - 1) * $pagesize;
} else {
	$start = 0;
	$curpage = 1;
}

if (!$Youke->isCached($tempfile)) {
	$Youke->assign('pagename', $pagename);
	$Youke->assign('site_title', $pagename.' - '.$options['site_title']);
	$Youke->assign('site_keywords', $options['site_keywords']);
	$Youke->assign('site_description', $options['site_description']);

	
	$linklist = get_link_list('link_display = 1', 'link_id', 'DESC', $start, $pagesize);
	$total = $Db->getCount($table, '*',$where);
	$showpage = showpage($pageurl, $total, $curpage, $pagesize);
	
	$Youke->assign('total', $total);
	$Youke->assign('linklist', $linklist);
	$Youke->assign('showpage', $showpage);
	unset($linklist);
}

Youke_display($tempfile);
