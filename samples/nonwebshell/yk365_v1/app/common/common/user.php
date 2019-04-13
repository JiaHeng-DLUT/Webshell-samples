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
/** check login */
function check_user_login($data)
{
	global $Db, $user_types;
	
	list($user_id, $user_pass, $login_count) = $data ? explode('|', authcode($data, 'DECODE')) : array('', '', '');
	$user_id = intval($user_id);
	$user_pass = addslashes($user_pass);
	$userinfo = array();
	if ($user_id && $user_pass) {
		$sql ="SELECT user_id, user_type, user_email, user_pass, nick_name, user_qq, user_status, join_time, login_time, login_ip, login_count FROM ".table('users')." WHERE user_id=$user_id";
		$row = $Db->query($sql,'Row');
		if ($row['user_pass'] == $user_pass && $row['login_count'] == $login_count) {
			$userinfo = array(
				'user_id' => $row['user_id'],
				'user_type' => $user_types[$row['user_type']],
				'user_email' => $row['user_email'],
				'nick_name' => $row['nick_name'],
				'user_qq' => $row['user_qq'],
				'user_status' => $row['user_status'],
				'join_time' => date('Y-m-d H:i:s', $row['join_time']),
				'login_time' => date('Y-m-d H:i:s', $row['login_time']),
				'login_ip' => long2ip($row['login_ip']),
				'login_count' => $row['login_count'],
			);
		}
	}
	
	return $userinfo;
}

/** user list */
function get_user_list($where = 1, $field = 'join_time', $order = 'DESC', $start = 0, $pagesize = 0)
{
	global $Db;
	
	$sql = "SELECT user_id, user_type, user_email, nick_name, user_qq, join_time, user_status FROM ".table('users')." WHERE $where ORDER BY $field $order LIMIT $start, $pagesize";
	$query = $Db->query($sql);
	$results = array();
	foreach($query as $row){
		$results[] = $row;
	}
	unset($row);
	
		
	return $results;
}
	
/** one user */
function get_one_user($user_id)
{
	global $Db;
	$sql ="SELECT user_id, user_type, user_email,nick_name, user_qq, join_time, user_status FROM ".table('users')." WHERE user_id=$user_id LIMIT 1";
	$row = $Db->query($sql,'Row');
	
	return $row;
}

/** user option */
function get_usertype_option($type = 'member')
{
	global $user_types;
	 $data='';
	foreach ($user_types as $key => $val) {
		$data .= '<option value="'.$key.'"';
		if ($type == $key) $data .= ' selected';
		$data .= '>'.$val.'</option>';
	}
	
	return $data;
}
