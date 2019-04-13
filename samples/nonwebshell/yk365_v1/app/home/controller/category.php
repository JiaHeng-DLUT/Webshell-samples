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
$pagename = '分类浏览';
$pageurl  = url('category');
$tempfile = 'category.html';
$table    = table('categories');
if (!$Youke->isCached($tempfile)) {
	$categories = get_categories();
	$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
	$Youke->assign('site_keywords', '开放分类，网址分类，目录分类，行业分类');
	$Youke->assign('site_description', '对网站进行很详细的分类，这样有助于帮你找到感兴趣的内容。');

	$Youke->assign('pagename', $pagename);
	$Youke->assign('total', count($categories));
	$Youke->assign('categories', $categories);
	unset($categories);
}
Youke_display($tempfile);
