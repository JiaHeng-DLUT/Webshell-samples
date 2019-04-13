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
$pagename = '最近更新';

$tempfile = 'update.html';
$table = table('website');

$pagesize = 10;
$curpage = I('get.page',0,'intval');
if ($curpage > 1) {
	$start = ($curpage - 1) * $pagesize;
} else {
	$start = 0;
	$curpage = 1;
}
		
$setdays = I('get.days','','intval');
$cache_id = $setdays.'-'.$curpage;

if (!$Youke->isCached($tempfile, $cache_id)) {
	$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
	$Youke->assign('site_keywords', '最近更新，最新收录，每日最新');
	$Youke->assign('site_description', '让你及时了解最新收录内容，可按时间段（最近24小时、三天内、一星期、一个月、一年、所有时间）查询，让你及时了解网站在某一时间段内的收录情况。');

	
	$newarr = array();
	$i = 0;
	foreach ($timescope as $key => $val) {
		$newarr[$i]['time_id'] = $key;
		$newarr[$i]['time_text'] = $val;
		$newarr[$i]['time_link'] = url('update',['days'=>$key]);
		$i++;
	}
	
	$where = "w.web_status=3";
	if ($setdays > 0) {
		$Youke->assign('site_title', $timescope[$setdays].'收录详情 - '.$pagename.' - '.$options['site_name']);


		
		$now = time();
		switch ($setdays) {
			case 1 :
				$time = $now - (3600 * 24);
				break;
			case 3 :
				$time = $now - (3600 * 24 * 3);
				break;
			case 7 :
				$time = $now - (3600 * 24 * 7);
				break;
			case 30 :
				$time = $now - (3600 * 24 * 30);
				break;
			case 365 :
				$time = $now - (3600 * 24 * 365);
				break;
			default :
				$time = 0;
				break;
		}
		$where .= " AND w.web_ctime>= $time";
	}
			
	$websites = get_website_list($where, 'web_ctime', 'DESC', $start, $pagesize);

	// print_r($websites);
	$total = $Db->getCount($table.' w','*',$where);
	$showpage = showpage(url('update',['days'=>$setdays]), $total, $curpage, $pagesize);
			
	$Youke->assign('pagename', $pagename);
	$Youke->assign('timescope', $newarr);
	$Youke->assign('days', $setdays);
	$Youke->assign('total', $total);
	$Youke->assign('websites', $websites);
	$Youke->assign('showpage', $showpage);
	unset($websites);
}
	
Youke_display($tempfile, $cache_id);
