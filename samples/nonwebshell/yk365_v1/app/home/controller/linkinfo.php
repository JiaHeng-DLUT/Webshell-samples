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

$pagename = '链接详细';
$pageurl  = url('linkinfo');
$tempfile = 'linkinfo.html';
$table    = table('weblinks');

$link_id = I('get.lid','','intval');
if(empty($link_id)){  redirect('/');}
$cache_id = $link_id;

if (!$Youke->isCached($tempfile, $cache_id)) {
	$where1 = "w.web_status=2 AND l.link_id = $link_id";
	$link1 = get_one_weblink($where1);

	if(!empty($link1)){
      msgbox('网站审核中');
	}


    $where2 = "w.web_status=1 AND l.link_id = $link_id";
	$link2 = get_one_weblink($where2);
	if(!empty($link1)){
       msgbox('网站已拉黑');
	}
    $where = "w.web_status=3 AND l.link_id = $link_id";
	$link = get_one_weblink($where);

	$Db->query("UPDATE $table SET link_views=link_views+1 WHERE link_id=".$link['link_id']." LIMIT 1");
	
	$cate = get_one_category($link['cate_id']);
	$user = get_one_user($link['user_id']);
	
	$Youke->assign('site_title', $link['link_name'].' - '.$options['site_name']);
	$Youke->assign('site_keywords', '友情链接交换，友情链接交易，友情链接出售');
	$Youke->assign('site_description', !empty($link['link_intro']) ? $link['link_intro'] : $options['site_description']);

	
	$Youke->assign('cate_id', $cate['cate_id']);
	$Youke->assign('cate_name', $cate['cate_name']);

	$link['web_furl']   = $link['web_url'];
	$link['web_pic']    = get_webthumb($link['web_url']);
	$link['deal_type']  = $deal_types[$link['deal_type']];
	$link['link_type']  = $link_types[$link['link_type']];
	$link['link_pos']   = $link_pos[$link['link_pos']];
	$link['link_price'] = $link['link_price'] > 0 ? $link['link_price'].'元 / 月' : '商谈';
	$link['link_time']  = date('Y-m-d', $link['link_time']);
	
    $Youke->assign('link', $link);
	$Youke->assign('user', $user);
}
		
Youke_display($tempfile, $cache_id);
