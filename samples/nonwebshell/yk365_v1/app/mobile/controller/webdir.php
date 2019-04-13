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
$pagename = '网址大全';

$tempfile = 'webdir.html';
$table = table('webdir');
$cate_id = I('get.cid','','addslashes');

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
			$categories = get_categories($cate['cate_id']);
		} else {
			$where .= " AND w.cate_id=$cate_id";
			$categories = get_categories($cate['root_id']);
		}
	} else {
		$categories = get_categories();
	}
	$Youke->assign('cate_name', isset($cate['cate_name']) ? $cate['cate_name'] : $pagename);
	$Youke->assign('categories', $categories);
    // $Youke->assign('website',$website);

	$Youke->assign('site_title', $options['site_title']);
	$Youke->assign('site_keywords', $options['site_keywords']);
	$Youke->assign('site_description', $options['site_description']);
// }
Youke_display($tempfile,$cate_id);
