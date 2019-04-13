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
$pagename = '文章资讯';
$tempfile = 'article.html';
$table = table('articles');

$pagesize = 10;
$curpage  = I('get.page','','intval');
if ($curpage > 1) {
	$start = ($curpage - 1) * $pagesize;
} else {
	$start = 0;
	$curpage = 1;
}
		
$cate_id = I('get.cid','','intval');
$type = I('get.type','','addslashes');  //pay快审  top顶置 best推荐

$cache_id = $cate_id.'-'.$curpage;
$pageurl = url('article',['cid'=>$cate_id]);


if (!$Youke->isCached($tempfile, $cache_id)) {
	$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
	$Youke->assign('site_keywords', $options['site_keywords']);
	$Youke->assign('site_description', $options['site_description']);


	
$where = " a.art_status=3 ";

switch($type)
{
	case 'pay':
    $where .= "and a.art_ispay=1";
	break;
	case 'top':
    $where .= " and a.art_istop=1";
	break;
	case 'recommend':
    $where .= " and a.art_isbest=1";
	break;	
}

	if ($cate_id > 0) {
		$cate = get_one_category($cate_id);
		if (!$cate) {
			unset($cate);
			redirect('/');
		}
	     	$Youke->assign('cate_id', $cate['cate_id']);

		$Youke->assign('site_title', $cate['cate_name'].' - '.$options['site_name']);
		$Youke->assign('site_keywords', !empty($cate['cate_keywords']) ? $cate['cate_keywords'] : $options['site_keywords']);
		$Youke->assign('site_description', !empty($cate['cate_description']) ? $cate['cate_description'] : $options['site_description']);
		if ($cate['cate_childcount'] > 0) {
			$where .= " AND a.cate_id IN (".$cate['cate_arrchildid'].")";
			$categories = get_categories($cate['cate_id'],'article');
		} else {
			$where .= " AND a.cate_id=$cate_id";
			$categories = get_categories_rid('article',$cate['root_id']);
		}
	} else {
		$categories = get_categories_rid('article',0);
	}
	
	$articles = get_article_list($where, 'ctime', 'DESC', $start, $pagesize);

	$total = $Db->getCount($table.' a','*',$where);
	$showpage = showpage($pageurl, $total, $curpage, $pagesize);


   
	$Youke->assign('pagename', $pagename);

	$Youke->assign('cate_name', isset($cate['cate_name']) ? $cate['cate_name'] : $pagename);
	$Youke->assign('categories', $categories);
	$Youke->assign('total', $total);
	$Youke->assign('articles', $articles);
	$Youke->assign('showpage', $showpage);
	unset($categories, $articles);
}

Youke_display($tempfile, $cache_id);
