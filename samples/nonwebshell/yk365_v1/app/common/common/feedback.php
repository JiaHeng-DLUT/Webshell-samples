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
/** feedback list */
function get_feedback_list($where = 1, $field = 'fb_id', $order = 'DESC', $start = 0, $pagesize = 0) 
{
	global $Db;
	
	$sql = "SELECT fb_id, fb_nick, fb_email, fb_content, fb_date FROM ".table('feedback')." WHERE $where ORDER BY $field $order LIMIT $start, $pagesize";
	$results = $Db->query($sql);
	
	return $results;
}
	
/** one feedback */
function get_one_feedback($fb_id) 
{
	global $Db;
	
	$sql = "SELECT * FROM ".table('feedback')." WHERE fb_id=$fb_id LIMIT 1";
	$row = $Db->query($sql,"Row");
	
	return $row;
}
