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
function get_game($cate_id = 0, $top_num = 10, $is_best = false, $field = 'ctime', $order = 'desc') 
{
	global $Db;
	
	$where = "a.status=3 AND c.cate_mod='game'";
	if (!in_array($field, array('views', 'ctime'))) $field = 'ctime';
	if ($cate_id > 0) {
		$cate = get_one_category($cate_id);
		if (!empty($cate)) $where .= " AND a.cate_id IN ('".$cate['cate_arrchildid']."')";
	}
	if ($is_best == true) $where .= " AND a.isbest=1";
	switch ($field) {
		case 'views' :
			$sortby = "a.views";
			break;
		case 'ctime' :
			$sortby = "a.ctime";
			break;
		default :
			$sortby = "a.ctime";
			break;
	}
	$order = strtoupper($order);
	
	$sql = "SELECT a.id, a.title,a.cover,a.ishot,a.isbest,a.url,a.status, a.ctime,a.utime, c.cate_id, c.cate_mod, c.cate_name, c.cate_dir FROM ".table('games')." a LEFT JOIN ".table('categories')." c ON a.cate_id=c.cate_id WHERE $where ORDER BY $sortby $order LIMIT $top_num";
	$query = $Db->query($sql);
	$results = array();
	foreach($query as $row){
		$row['ctime'] = date('Y-m-d', $row['ctime']);
		$row['utime'] = date('Y-m-d', $row['utime']);
		$row['cate_link'] = url($row['cate_mod'],['cid'=>$row['cate_id']]);
		$results[] = $row;
	}
	unset($row);
	
	
	return $results;
}

/** game list */
function get_game_list($where = '', $field = 'ctime', $order = 'DESC', $start = 0, $pagesize = 10) 
{
	global $Db;
	
	if(!empty($where)){
       $where =" WHERE $where";
	}
	if (!in_array($field, array('views', 'ctime'))) $field = 'ctime';
	switch ($field) {
		case 'views' :
			$sortby = "a.views";
			break;
		case 'ctime' :
			$sortby = "a.ctime";
			break;
		default :
			$sortby = "a.ctime";
			break;
	}
	$order = strtoupper($order);
	$sql = "SELECT a.id, a.title,a.cover,a.ishot,a.isbest,a.url,a.status, a.ctime, c.cate_id, c.cate_name FROM ".table('games')." a LEFT JOIN ".table('categories')." c ON a.cate_id=c.cate_id  $where ORDER BY a.istop DESC, $sortby $order LIMIT $start, $pagesize";
	$query = $Db->query($sql);
	$results = array();
	foreach($query as $row){
		switch ($row['status']) {
			case 1 :
				$status = '<font color="#333333">草稿</font>';
				break;
			case 2 :
				$status = '<font color="#ff3300">待审核</font>';
				break;
			case 3 :
				$status = '<font color="#008800">已审核</font>';
				break;
		}
		$row['attr'] = $status;
		$row['ctime'] =date('Y-m-d',$row['ctime']);
		$row['utime'] = isset($row['utime'])?date('Y-m-d', $row['utime']):'';
		$results[] = $row;
	}
	unset($row);
	
		
	return $results;
}

/** one article */
function get_one_game($where = 1) 
{
	global $Db;
	
	$row = $Db->query("SELECT  a.id, a.title,a.cover,a.ishot,a.isbest,a.url,a.status, a.ctime, c.cate_id, c.cate_name FROM ".table('games')." a LEFT JOIN ".table('categories')." c ON a.cate_id=c.cate_id WHERE $where LIMIT 1",'Row');
	
	return $row;
}