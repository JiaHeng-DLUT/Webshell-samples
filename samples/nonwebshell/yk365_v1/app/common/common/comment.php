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
/** comment list */
function get_comment_list($where = '', $start = 0, $pagesize = 0) 
{
	global $Db;
	
	if(!empty($where)){
       $where = "where $where";
	}
	$sql = "SELECT comment_id, pageid,status, root_id, nick, email, content, ip,time FROM ".table('comments')." $where ORDER BY comment_id DESC LIMIT $start, $pagesize";
	$query = $Db->query($sql);
	$comments = array();
	foreach($query as $row){
		switch ($row['status']) {
			case 1 :
				$status = '待审核';
				break;
			case 2 :
				$status = '已审核';
				break;
		}
		$count = get_comment_count($row['comment_id'], $row['pageid']);
		if ($count > 0) {
			$row['reply_comments'] = get_comments($row['comment_id'], $row['pageid']);
		}
		$row['ip'] = long2ip($row['ip']);
		$row['time'] = date("y-m-d H:i:s",($row['time']));
		$comments[] = $row;
	}
	
	
	return $comments;
}

/** comments list */
function get_comments($mod="",$root_id = 0, $pageid = 0, $top_num = 10) 
{
	global $Db;
	
	echo $sql = "SELECT comment_id, pageid, root_id, nick, email, content, ip, time FROM ".table('comments')." WHERE module='$mod' and  status=2 ";

	if ($root_id > 0) $sql .= " AND root_id = '$root_id'";
	if ($pageid > 0) $sql .= " AND pageid = '$pageid'";
	$sql .= " ORDER BY comment_id DESC";
	if ($top_num > 0) $sql .= " LIMIT $top_num";
	$query = $Db->query($sql);
	$comments = array();
	foreach($query as $row){
		$count = get_comment_count($mod,$row['comment_id'],$row['pageid']);

		if ($count > 0) {
	      $row['reply_comments'] = get_comments($mod,'9',$row['pageid'],0);
		}

		$row['ip'] = $row['ip'];
		$row['time'] =date("Y-m-d H:i:s",$row['time']);
		$comments[] = $row;

	}

	
	
	return $comments;
}

/** comments count */
function get_comment_count($mod,$root_id = 0, $pageid = 0) 
{
	global $Db;
	 $where = "root_id='$root_id' and module = '$mod' AND pageid='$pageid'";
	 $count = $Db->getCount(table('comments'),'*',$where);
	 return $count;
}
