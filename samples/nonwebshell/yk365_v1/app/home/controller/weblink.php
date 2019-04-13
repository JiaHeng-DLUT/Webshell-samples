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
$pageurl  = url('weblink');
$tempfile = 'weblink.html';
$table  = table('weblinks');

$pagesize = 10;
$curpage = I('get.page',1,'intval');
if ($curpage > 1) {
	$start = ($curpage - 1) * $pagesize;
} else {
	$start = 0;
	$curpage = 1;
}
		
$deal_type = I('get.type','','intval');
$cache_id = $deal_type.'-'.$curpage;

if (!$Youke->isCached($tempfile, $cache_id)) {
	$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
	$Youke->assign('site_keywords', $options['site_keywords']);
	$Youke->assign('site_description', $options['site_description']);



	$where = "l.link_hide=0";
	if ($deal_type > 0) {
		$pageurl .= '&type='.$deal_type;
		if ($deal_type > 0) $where .= " AND l.deal_type=$deal_type";
	}
			
	$results = get_weblink_list($where, 'time', 'DESC', $start, $pagesize);

	$weblinks = array();
	
	foreach($results as $row) {
		$user = get_one_user($row['user_id']);
		$row['user_qq'] = $user['user_qq'];
		$row['deal_type'] = $deal_types[$row['deal_type']];
		$row['link_price'] = ($row['link_price'] > 0 ? $row['link_price'] : '商谈');
		$row['link_time'] = date('Y-m-d', $row['link_time']);
		$weblinks[] = $row;
	}
	
	
	$total = $Db->getCount($table.' l',"*", $where);
	$showpage = showpage($pageurl, $total, $curpage, $pagesize);
			
	$Youke->assign('pagename', $pagename);
	$Youke->assign('total', $total);
	$Youke->assign('weblinks', $weblinks);
	$Youke->assign('showpage', $showpage);
	unset($weblinks);
}

Youke_display($tempfile, $cache_id);
