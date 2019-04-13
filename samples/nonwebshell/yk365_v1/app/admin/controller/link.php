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

$tempfile = 'link.html';
$table    = table('links');
$fileurl  = url('link');
if(empty($action)) $action = 'list';

/** list */
if ($action == 'list') {
	$pagetitle = '链接列表';
	
	$k = !empty($_GET['keywords'])?htmlspecialchars($_GET['keywords']):'';
	$keywords = !empty($_POST['keywords'])?htmlspecialchars($_POST['keywords']):$k;
	$pageurl = url('link',['keywords'=>urlencode($keywords)]);
	
	$where = !empty($keywords) ? "link_name like '%$keywords%' OR link_url like '%$keywords%'" : 1;
	$result = get_link_list($where, 'link_id', 'DESC', $start, $pagesize);
	$links = array();
	foreach ($result as $row) {
		$row['link_url'] = '<a href="'.$row['link_url'].'" target="_blank">'.$row['link_url'].'</a>';
		$row['link_display'] = $row['link_display'] == 1 ? '<span  class="label label-success">显示</span>' : '<span class="label label-default" >隐藏</span>';
		$row['link_operate'] = '<a href="'.url('link',['act'=>'edit','link_id'=>$row['link_id']]).'">编辑</a>&nbsp;|&nbsp;

		   <a href="'.url('link',['act'=>'del','link_id'=>$row['link_id']]).'" onClick="return confirm(\'确认删除此内容吗？\');">删除</a>';
		$links[] = $row;
	}
	
	$total = $Db->getCount($table,'*',$where);	
	$showpage = showpage($pageurl, $total, $curpage, $pagesize);
	
	$Youke->assign('keywords', $keywords);
	$Youke->assign('links', $links);
	$Youke->assign('showpage', $showpage);
	unset($result, $links);
}

/** add */
if ($action == 'add') {
	$pagetitle = '添加新链接';
	
	$Youke->assign('display', 1);
	$Youke->assign('h_action', 'saveadd');
}

/** edit */
if ($action == 'edit') {
	$pagetitle = '编辑链接';
			
	$link_id = intval($_GET['link_id']);
	$link    = get_one_link($link_id);
	if (!$link) {
		msgbox('指定的内容不存在！');
	}
	
	$Youke->assign('display', $link['link_display']);
	$Youke->assign('link', $link);
	$Youke->assign('h_action', 'saveedit');
}


/** save data */
if (in_array($action, array('saveadd', 'saveedit'))) {

	$link_name = htmlspecialchars($_POST['link_name']);
	$link_url = htmlspecialchars($_POST['link_url']);
	$link_logo = htmlspecialchars($_POST['link_logo']);
	$link_display = intval($_POST['link_display']);
	$link_order = intval($_POST['link_order']);
	
	if (empty($link_name)) {
		msgbox('请输入链接名称！');
	}
	
	if (empty($link_url)) {
		msgbox('请输入链接地址！');
	} else {
		if (!is_valid_url($link_url)) {
			msgbox('请输入正确的链接地址！');
		}
	}

	$data = array(
		'link_name' => $link_name,
		'link_url' => $link_url,
		'link_logo' => $link_logo,
		'link_display' => $link_display,
		'link_order' => $link_order,
	);
	
	if ($action == 'saveadd') {
		$query = $Db->query("SELECT link_id FROM $table WHERE link_name='$link_name' AND link_url='$link_url'");
		if (count($query)) {
			msgbox('您所添加的链接已存在！');
		}
		
		$Db->insert($table, $data);
		update_cache('links');
		
		msgbox('链接添加成功！',url('link',['act'=>'add']));
	} elseif ($action == 'saveedit') {
		$link_id = intval($_POST['link_id']);
		$where = "link_id =  '$link_id'";
		
		$Db->update($table, $data, $where);
		update_cache('links');
		
		msgbox('链接修改成功！',url('link'));
	}
}

/** del */
if ($action == 'del') {
	$link_ids = (array) ($_POST['link_id'] ? $_POST['link_id'] : $_GET['link_id']);
	
	$Db->delete($table, 'link_id IN ('.dimplode($link_ids).')');
	update_cache('links');
	unset($link_ids);
	
	msgbox('链接删除成功！',url('link'));
}

Youke_display($tempfile);
