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
$pagename = '数据归档';
$pageurl  = url('archives');
$tempfile = 'archives.html';
$table = table('website');

$pagesize = 10;
$curpage = I('get.page','','intval');
$setdate = I('get.date','','intval');
if ($curpage > 1) {
	$start = ($curpage - 1) * $pagesize;
} else {
	$start = 0;
	$curpage = 1;
}
		

$cache_id = ($setdate && strlen($setdate) == 6 ? $setdate.'-' : '').$curpage;

if (!$Youke->isCached($tempfile, $cache_id)) {
	$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
	$Youke->assign('site_keywords', '网站存档，目录存档，数据归档');
	$Youke->assign('site_description', '可根据年份、月份来查询，让你及时了解某一时间段内网站的收录情况。');	
	$where = "w.web_status=3";
	if ($setdate && strlen($setdate) == 6) {
		$year = substr($setdate, 0, 4);
		if ($year >= 2038 || $year <= 1970) {
			$year = gmdate('Y');
			$month = gmdate('m');
		} else {
			$month = substr($setdate, -2);
			$start_timestamp = strtotime($year.'-'.$month.'-1');
			if ($month == 12) {
				$end_year = $year + 1;
				$end_month = 1;
			} else {
				$end_year  = $year;
				$end_month = $month + 1;
			}
			$end_timestamp = strtotime($end_year.'-'.$end_month.'-1');
		}
		$where .= " AND w.web_ctime>='".$start_timestamp."' AND w.web_ctime<'".$end_timestamp."'";
		
		$timetext = $year.'年'.$month.'月';
		
		$Youke->assign('site_title', $timetext.' - 网站数据归档 - '.$options['site_name']);
		$Youke->assign('site_description', $timetext.'网站数据归档列表。');
		$Youke->assign('timetext', $timetext);
				
		$pageurl .= '&date='.$setdate;
	}
	
	$websites = get_website_list($where, 'web_ctime', 'DESC', $start, $pagesize);
	$total = $Db->getCount($table.' w','*',$where);
	$showpage = showpage($pageurl, $total, $curpage, $pagesize);
			
	$Youke->assign('pagename', $pagename);
	$Youke->assign('archives', get_archives());
	$Youke->assign('total', $total);
	$Youke->assign('websites', $websites);
	$Youke->assign('showpage', $showpage);
	unset($websites);
}

Youke_display($tempfile, $cache_id);
