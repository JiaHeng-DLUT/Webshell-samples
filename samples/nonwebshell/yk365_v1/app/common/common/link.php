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
/** link list */
function get_link_list($where = '', $field = 'link_id', $order = 'DESC', $start = 0, $pagesize = 0)
{
	global $Db;
	if(!empty($where)){
       $where =" WHERE $where";
	}
	$sql = "SELECT link_id, link_name, link_url, link_logo, link_display, link_order FROM ".table('links')." $where ORDER BY $field $order LIMIT $start, $pagesize";
	$results = $Db->query($sql);
	
	return $results;
}
	
/** one link */
function get_one_link($link_id)
{
	global $Db;
	
	$sql = "SELECT * FROM ".table('links')." WHERE link_id=$link_id LIMIT 1";
	$row = $Db->query($sql,"Row");
	
	return $row;
}

/** links */
function get_links()
{
	global $Db;
	
	$links = load_cache('links') ? load_cache('links') : $Db->query("SELECT link_id, link_name, link_url, link_logo FROM ".table('links')." WHERE link_display=1 ORDER BY link_order DESC, link_id ASC");
	
	return $links;
}
