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
$pagename = '网站目录';

$tempfile = 'webdir.html';
$table    = table('website');

$pagesize = 10;
$curpage  = I('get.page',0,'intval');
if ($curpage > 1) {
	$start = ($curpage - 1) * $pagesize;
} else {
	$start = 0;
	$curpage = 1;
}
		
$cate_id  = I('get.cid',0,'intval');
$cache_id = $cate_id.'-'.$curpage;


if (!$Youke->isCached($tempfile, $cache_id)) {
	$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
	$Youke->assign('site_keywords', $options['site_keywords']);
	$Youke->assign('site_description', $options['site_description']);


	$where = "w.web_status=3";
	if ($cate_id > 0) {
		$cate = get_one_category($cate_id);
		if (!$cate) {
			unset($cate);
			redirect(url('category'));
		}
			$Youke->assign('cate_id', $cate['cate_id']);
		$Youke->assign('site_title', $cate['cate_name'].' - '.$pagename.' - '.$options['site_name']);
		$Youke->assign('site_keywords', !empty($cate['cate_keywords']) ? $cate['cate_keywords'] : $options['site_keywords']);
		$Youke->assign('site_description', !empty($cate['cate_description']) ? $cate['cate_description'] : $options['site_description']);

		
		if ($cate['cate_childcount'] > 0) {
			$where .= " AND w.cate_id IN (".$cate['cate_arrchildid'].")";
			$categories = get_categories_catemod('webdir',$cate['cate_id']);
		} else {
			$where .= " AND w.cate_id=$cate_id";
			$categories = get_categories_catemod('webdir',$cate['root_id']);
		}
	} else {
		$categories = get_categories_catemod('webdir');
	}

	$websites = get_website_list($where, 'web_ctime', 'DESC', $start, $pagesize);

	$total = $Db->getCount($table.' w','*',$where);

	$showpage = showpage(url('webdir',['cid'=>$cate_id]), $total, $curpage, $pagesize);
	
	$Youke->assign('pagename', $pagename);

	$Youke->assign('cate_name', isset($cate['cate_name']) ? $cate['cate_name'] : $pagename);
	$Youke->assign('categories', $categories);
	$Youke->assign('total', $total);
	$Youke->assign('websites', $websites);
	$Youke->assign('showpage', $showpage);
	unset($child_category, $websites);
}
	
Youke_display($tempfile, $cache_id);
