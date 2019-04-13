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
$pagename = '文章详细';
$pageurl  = url('artinfo');
$tempfile = 'artinfo.html';
$table    = table('articles');

$id       = I('get.aid','','intval');
$cache_id = $id;
		
if (!$Youke->isCached($tempfile, $cache_id)) {
	$where = "a.art_status=3 AND a.art_id=$id";
	$art = get_one_article($where);
	if (!$art) {
		unset($art);
		redirect(url('/'));
	}
	
	$Db->query("UPDATE $table SET art_views=art_views+1 WHERE art_id=".$art['art_id']." LIMIT 1");
	
	$cate = get_one_category($art['cate_id']);
	$user = get_one_user($art['user_id']);
	
	$Youke->assign('site_title', $art['art_title'].' - '.$cate['cate_name'].' - '.$options['site_name']);
	$Youke->assign('site_keywords', !empty($art['art_tags']) ? $art['art_tags'] : $options['site_keywords']);
	$Youke->assign('site_description', !empty($art['art_intro']) ? $art['art_intro'] : $options['site_description']);

	
	$Youke->assign('cate_id', $cate['cate_id']);
	$Youke->assign('cate_name', $cate['cate_name']);
	$Youke->assign('cate_keywords', $cate['cate_keywords']);
	$Youke->assign('cate_description', $cate['cate_description']);
	
	$art['art_content'] = str_replace('[upload_dir]', $options['site_root'].$options['upload_dir'].'/', $art['art_content']);
	$art['art_ctime'] = date('Y-m-d H:i:s', $art['art_ctime']);
	
	$Youke->assign('art', $art);
	$Youke->assign('user', $user);
	$Youke->assign('prev', get_prev_article($art['art_id']));
	$Youke->assign('next', get_next_article($art['art_id']));
	$Youke->assign('related_article', get_articles($art['cate_id'], 8, false, 'ctime'));
}
		
Youke_display($tempfile, $cache_id);
