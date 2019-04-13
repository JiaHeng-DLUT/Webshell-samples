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
$pagename = 'TOP排行榜';
$pageurl  = url('top');
$tempfile = 'top.html';

if (!$Youke->isCached($tempfile)) {
	$Youke->assign('pagename', $pagename);
	$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
	$Youke->assign('site_keywords', '网站热榜，网站TOP排行榜，热门网站排行，网站风云榜');
	$Youke->assign('site_description', '提供最新热门网站排行数据，让您及时了解那些信息最受关注。');

}

Youke_display($tempfile);
