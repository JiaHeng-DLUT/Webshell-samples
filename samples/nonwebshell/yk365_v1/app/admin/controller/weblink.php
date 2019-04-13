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
$tempfile = 'weblink.html';
$table    = table('weblinks');

if (empty($action)) $action = 'list';

/** list */
if ($action == 'list') {
	$pagetitle = '友链列表';
	$k        = !empty($_GET['keywords'])?htmlspecialchars($_GET['keywords']):'';
	$keywords = !empty($_POST['keywords'])?htmlspecialchars($_POST['keywords']):$k;

	$pageurl = url('weblink',['keywords' =>urlencode($keywords)]);
	
	$where   = !empty($keywords) ? "link_name like '%$keywords%'" : 1;


	$results = get_weblink_list($where, 'id', 'DESC', $start, $pagesize);
	$weblinks = array();
	foreach ($results as $row) {
		$row['deal_type'] = $deal_types[$row['deal_type']];
		$row['link_time'] = date('Y-m-d', $row['link_time']);
		$row['link_operate'] = '<a href="'.url('weblink',['act'=>'del','link_id'=>$row['link_id']]).'" onClick="return confirm(\'确认删除此内容吗？\');">删除</a>';
		$weblinks[] = $row;
	}
	
	$total = $Db->getCount($table,'*',$where);

	$showpage = showpage($pageurl, $total, $curpage, $pagesize);
	
	$Youke->assign('keywords', $keywords);
	$Youke->assign('weblinks', $weblinks);
	$Youke->assign('showpage', $showpage);
	unset($results, $weblinks);
}

/** del */
if ($action == 'del') {
	$link_ids = (array) ($_POST['link_id'] ? $_POST['link_id'] : $_GET['link_id']);
	
	$Db->delete($table, 'link_id IN ('.dimplode($link_ids).')');
	unset($link_ids);
	
	msgbox('链接删除成功！', $fileurl);
}

Youke_display($tempfile);
