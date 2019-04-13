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
$fileurl = url('page');
$tempfile = 'page.html';
$table = table('pages');

if (empty($action)) $action = 'list';

/** list */
if ($action == 'list') {
	$pagetitle = '页面列表';
	$get_keywords = !empty($_GET['keywords'])?htmlspecialchars($_GET['keywords']):'';
	$keywords     = !empty($_POST['keywords'])?htmlspecialchars($_POST['keywords']):$get_keywords;
	$keyurl       = !empty($keywords) ? '?keywords='.urlencode($keywords) : '';
	$pageurl      = $fileurl.$keyurl;
	
	$where = !empty($keywords) ? $where = "page_name like '%$keywords%'" : 1;
	$result = get_page_list($where, 'page_id', 'DESC', $start, $pagesize);
	$pages = array();
	foreach ($result as $row) {
		$pages[] = $row;
	}
	
	$total = $Db->getCount($table, '*',$where);
	$showpage = showpage($pageurl, $total, $curpage, $pagesize);
	
	$Youke->assign('keywords', $keywords);
	$Youke->assign('pages', $pages);
	$Youke->assign('showpage', $showpage);
	unset($result, $pages);
}

/** add */
if ($action == 'add') {
	$pagetitle = '添加新页面';
			
	$Youke->assign('h_action', 'saveadd');
}

/** edit */
if ($action == 'edit') {
	$pagetitle = '编辑页面';
	
	$page_id = intval($_GET['page_id']);
	$page    = get_one_page($page_id);
	if (!$page) {
		msgbox('指定的内容不存在！');
	}
	
	$Youke->assign('page', $page);
	$Youke->assign('h_action', 'saveedit');
}

/** save data */
if (in_array($action, array('saveadd', 'saveedit'))) {
	$page_name    =  htmlspecialchars($_POST['page_name']);
	$page_intro   =  htmlspecialchars($_POST['page_intro']);
	$page_content =  htmlspecialchars($_POST['page_content']);
	
	if (empty($page_name)) {
		msgbox('请输入自定义页面名称！');
	}
	
	if (empty($page_content)) {
		msgbox('请输入自定义页面内容！');
	}
	
	$data = array(
		'page_name'    => $page_name,
		'page_intro'   => $page_intro,
		'page_content' => $page_content,
	);
	
	if ($action == 'saveadd') {
    	$query = $Db->query("SELECT page_id FROM $table WHERE page_name='$page_name'");
    	if (count($query)) {
        	msgbox('您所添加的页面已存在！');
    	}
		
		$Db->insert($table, $data);
		
		msgbox('自定义页面添加成功！', url('page',['act'=>'add']));
	} elseif ($action == 'saveedit') {
		$page_id = intval($_POST['page_id']);
		$where   ="page_id ='$page_id'";
		
		$Db->update($table, $data, $where);
		
		msgbox('自定义页面修改成功！', $fileurl);
	}
}

/** del */
if ($action == 'del') {
	$page = I('post.page_id');
	if(is_array($page)){
        $page_ids =  $_POST['page_id'];
	}else{
		$page_ids = intval($_GET['page_id']);
	}

	
	$Db->delete($table, 'page_id IN ('.dimplode($page_ids).')');
	unset($page_ids);
	
	msgbox('自定义页面删除成功！', url('page'));
}

Youke_display($tempfile);
