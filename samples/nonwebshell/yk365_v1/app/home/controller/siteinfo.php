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
$pagename = '站点详细';
$tempfile = 'siteinfo.html';
$table    = table('webdata');

$web_id = I('get.wid','','intval');
$cache_id = $web_id;

$pagesize = 10;
$curpage = I('get.page','','intval');

if ($curpage > 1) {
	$start = ($curpage - 1) * $pagesize;
} else {
	$start = 0;
	$curpage = 1;
}

if (!$Youke->isCached($tempfile, $cache_id)) {
	$where = "a.web_status=3 AND a.web_id=$web_id";
	$web = get_one_website($where);
	if (!$web) {
		unset($web);
		redirect('/');
	}
	
	$Db->query("UPDATE $table SET web_views = web_views+1 WHERE web_id=".$web['web_id']." LIMIT 1");
	
	$cate = get_one_category($web['cate_id']);

	$user = get_one_user($web['user_id']);
	
	$Youke->assign('site_title', $web['web_name'].' - '.$cate['cate_name'].' - '.$options['site_name']);
	$Youke->assign('site_keywords', !empty($web['web_tags']) ? $web['web_tags'] : $options['site_keywords']);
	$Youke->assign('site_description', !empty($web['web_intro']) ? $web['web_intro'] : $options['site_description']);

	$Youke->assign('cate_id', $cate['cate_id']);
	$Youke->assign('cate_name', $cate['cate_name']);


	$web['web_furl'] = $web['web_url'];
    $web['web_pic']  = get_webthumb($web['web_url']);
	$web['web_ip']    = long2ip($web['web_ip']);
	$web['web_ctime'] = date('Y-m-d', $web['web_ctime']);
	$web['web_utime'] = date('Y-m-d', $web['web_utime']);
	

	/** tags */
	$web_tags = get_format_tags($web['web_tags']);
	$Youke->assign('web_tags', $web_tags);
    $Youke->assign('web', $web);
	$Youke->assign('user', $user);
	$Youke->assign('related_website', get_websites($web['cate_id'], 10, false, 'ctime'));
}
		
Youke_display($tempfile, $cache_id);
