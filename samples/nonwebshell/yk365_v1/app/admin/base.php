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


$pagesize =10;

$table = table('users');

$user_auth = isset($_COOKIE['user_auth'])?$_COOKIE['user_auth']:'';
list($user_id, $user_pass) = $user_auth ? explode('@', authcode($user_auth, 'DECODE')) : array('', '', '');
$user_id = intval($user_id);
$user_pass = addslashes($user_pass);
if (!$user_id || !$user_pass) {
	$user_id = 0;	
	msgbox('您还未登录或无权限！', url('login'));
	
}

$myself = array();
$user = $Db->query("SELECT user_id, user_email, user_pass, login_time, login_ip, login_count FROM $table WHERE user_type='admin' AND user_id='$user_id'",'Row');
if (!$user) {
	$myself = array();
	setcookie('user_auth', '');
	msgbox('您还未登录或无权限！', './login.php');
} else {
	if ($user['user_pass'] == $user_pass) {
		$myself = array(
	
			'user_id' => $user['user_id'],
			'user_email' => $user['user_email'],
			'login_time' => date('Y-m-d H:i:s', $user['login_time']),
			'login_ip' => long2ip($user['login_ip']),
			'login_count' => $user['login_count'],
		);
	}
}

if (empty($myself)) {
	msgbox('您还未登录或无权限！', url('login'));
}

$Youke->assign('myself', $myself);

$page  = I('get.page',1,'intval');
$start = ($page-1)*$pagesize;

$user_types = array('member'=>'注册会员');

