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

$fileurl = url('comment');
$tplfile = 'comment.html';
$table   = table('comments');

if (empty($action)) $action = 'list';


/** list */
if ($action == 'list') {
	$pagetitle = '站点列表';
	$status = I('get.status',-1,'intval');
	$Youke->assign('status', $status);
	if($status){
		$pageurl = $fileurl.'?status='.$status;	
	}


	$where = '';
	 $sql = "SELECT a.comment_id,a.module,a.pageid, a.nick, a.email, a.content, a.ip, a.status, a.time, b.web_name, b.web_url FROM $table a LEFT JOIN ".table('website')." b ON a.pageid=b.web_id WHERE";
	
	switch ($status) {
		case 0 :
			$where .= " a.status=0";
			break;
		case 1 :
			$where .= " a.status=1";
			break;
		default :
			$where .= " a.status>-1";
			break;
	}
	$sql .= $where." ORDER BY a.comment_id DESC LIMIT $start, $pagesize";
	$query = $Db->query($sql);
	
	$comments = array();
	foreach($query as $row){
       $row['web_name'] = '<a  href="'.$row[web_url].'?mod='.$row[module].'&wid='.$row[pageid].'"    target="_blank">'.$row['web_name'].'</a>';

		$row['ip'] = long2ip($row['ip']);
		switch ($row['status']) {
			case 0 :
				$status = '<font color="#ff3300">待审核</font>';
				break;
			case 1 :
				$status = '<font color="#008800">已审核</font>';
				break;
		}
		$row['attr'] = $status;
		$row['time'] = date('Y-m-d H:i:s', $row['time']);
		$row['oper'] = '<a href="'.$fileurl.'?act=del&comment_id='.$row['comment_id'].'" onClick="return confirm(\'确认删除此内容吗？\');">删除</a>';
		$comments[] = $row;
	}
	
	
	$total = $Db->getCount($table.' a','*',$where);
	$showpage = showpage($pageurl, $total, $curpage, $pagesize);
	
	$Youke->assign('comments', $comments);
	$Youke->assign('showpage', $showpage);
}

/** del */
if ($action == 'del') {
	$id = I('get.id','','intval');
	$ids = I('post.id',$id);

	$Db->delete($table, 'comment_id IN ('.dimplode($ids).')');
	
	alert('评论删除成功！', $fileurl);
}

/** passed */
if ($action == 'passed') {
	$id = I('get.id','','intval');
	$ids = I('post.id',$id);
	
	$Db->update($table, array('status' => 1), 'comment_id IN ('.dimplode($ids).')');
	
	alert('评论审核成功！', $fileurl);
}

/** cancel */
if ($action == 'cancel') {
	$id = I('get.id','','intval');
	$ids = I('post.id',$id);
	
	$Db->update($table, array('status' => 0), 'comment_id IN ('.dimplode($ids).')');
	
	alert('评论取消审核成功！', $fileurl);
}

Youke_display($tplfile);
