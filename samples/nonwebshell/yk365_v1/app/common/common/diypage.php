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
/** page list */
function get_page_list($where = 1, $field = 'page_id', $order = 'DESC', $start = 0, $pagesize = 0) 
{
	global $Db;
	
	$sql = "SELECT page_id, page_name, page_intro, page_content FROM ".table('pages')." WHERE $where ORDER BY $field $order LIMIT $start, $pagesize";
	$results = $Db->query($sql);
	
	return $results;
}
	
/** one page */
function get_one_page($page_id) 
{
	global $Db;
	
	 $sql = "SELECT * FROM ".table('pages')." WHERE page_id=$page_id LIMIT 1";
	$row = $Db->query($sql,"Row");
	
	return $row;
}

/** pages */
function get_pages() 
{
	global $Db;
	
	$sql = "SELECT page_id, page_name FROM ".table('pages')." ORDER BY page_id ASC";
	$query = $Db->query($sql);
	$results = array();
	foreach($query as $row){
		$row['page_link'] = url('diypage',['pid'=>$row['page_id']]);
		$results[] = $row;
	}
	unset($row);
	
	
	return $results;
}
