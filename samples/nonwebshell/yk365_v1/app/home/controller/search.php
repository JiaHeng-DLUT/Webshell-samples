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
$pagename = '搜索结果';

$tempfile = 'search.html';
$table    = table('website');


//搜索页不缓存
$Youke->caching = false;


$pagesize = 10;
$curpage = I('get.page','','intval');
$strtype = I('get.type','','strtolower');
$keyword = urldecode(I('get.query','','addslashes'));
if ($curpage > 1) {
	$start = ($curpage - 1) * $pagesize;
} else {
	$start = 0;
	$curpage = 1;
}
		

if (!$Youke->isCached($tempfile)) {
	$where = "a.web_status=3";
	if ($keyword) {
		   $pageurl = url('search',['type'=>$strtype,'query'=>$keyword]);
				
		$Youke->assign('site_title', $keyword.' - '.$pagename.' - '.$options['site_name']);
		$Youke->assign('site_keywords', $keyword.'，搜索结果，查询结果');
		$Youke->assign('site_description', '以下是与关键字(词)“'.$keyword.'”相关的结果。');
				
		switch ($strtype) {
			case 'name' :
				$where = "w.web_name like '%$keyword%'";
				break;
			case 'url' :
			    $keyword = $keyword;
				$where = "w.web_url like '%$keyword%'";
				break;
			case 'tags' :
				$where = "w.web_tags like '%$keyword%'";
				break;
			case 'intro' :
				$where = "w.web_intro like '%$keyword%'";
			default :
				$where = "w.web_name like '%$keyword%'";
				break;
			}
		}
	
		$websites = get_website_list($where, 'ctime', 'DESC', $start, $pagesize);

      
		$total = $Db->getCount($table.' w','*', $where);
		$showpage = showpage($pageurl, $total, $curpage, $pagesize);
		
		
		$Youke->assign('pagename', $pagename);
		$Youke->assign('category_list', get_categories());
		$Youke->assign('archives', get_archives());
		$Youke->assign('keyword', $keyword);
		$Youke->assign('total', $total);
		$Youke->assign('websites', $websites);
		$Youke->assign('showpage', $showpage);
		unset($websites);
}

    Youke_display($tempfile);
