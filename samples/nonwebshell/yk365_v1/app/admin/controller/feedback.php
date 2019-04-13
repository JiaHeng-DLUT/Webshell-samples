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
$tempfile = 'feedback.html';
$table = table('feedback');

if (empty($action)) $action = 'list';

/** list */
if ($action == 'list') {
	$pagetitle = '意见反馈列表';
	$getkeywords = !empty($_GET['keywords'])?htmlspecialchars($_GET['keywords']):'';
	$keywords    = !empty($_POST['keywords'])? htmlspecialchars($_POST['keywords']):$getkeywords;
	$keyurl      = $keywords ? '?keywords='.urlencode($keywords) : '';
	$pageurl     = url('feedback',['keywords'=>urlencode($keywords)]);
	
	$where = !empty($keywords) ? "fb_nick like '%$keywords%' OR fb_email like '%$keywords%'" : 1;
	$result = get_feedback_list($where, 'fb_id', 'DESC', $start, $pagesize);
	$feedback = array();
	foreach ($result as $row) {
		$row['fb_date'] = date('Y-m-d H:i:s', $row['fb_date']);
		$feedback[] = $row;
	}
	
	$total = $Db->getCount($table,'*',$where);
	$showpage = showpage($pageurl, $total, $curpage, $pagesize);
	
	$Youke->assign('keywords', $keywords);
	$Youke->assign('feedback', $feedback);
	$Youke->assign('showpage', $showpage);
	unset($result, $feedback);
}

/** view */
if ($action == 'view') {
	$pagetitle = '查看意见信息';
	
	$fb_id = intval($_GET['fb_id']);
	$fb    = get_one_feedback($fb_id);
	if (!$fb) {
		msgbox('指定的内容不存在！');
	}
			
	$fb['fb_date'] = date('Y-m-d H:i:s', $fb['fb_date']);
	$Youke->assign('fb', $fb);
}

/** del */
if ($action == 'del') {
	$fb_ids = (array) ($_POST['fb_id'] ? $_POST['fb_id'] : $_GET['fb_id']);
	
	$Db->delete($table, 'fb_id IN ('.dimplode($fb_ids).')');
	unset($fb_ids);
	
	msgbox('信息删除成功！', $fileurl);
}

Youke_display($tempfile);
