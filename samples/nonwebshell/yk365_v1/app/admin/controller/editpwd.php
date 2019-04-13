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

$pagetitle = '修改密码';
$fileurl = url('editpwd');
$tempfile = 'editpwd.html';
$table = table('users');

if ($action == 'saveedit') {
	$user_id    = I('post.user_id','','intval');
	$user_email = I('post.user_email');
	$user_pass  = I('post.user_pass');
	$new_pass   = I('post.new_pass');
	$new_pass1  = I('post.new_pass1');
	
	if (empty($user_email) || !is_valid_email($user_email)) {
		msgbox('请输入正确的电子邮箱！');
	}
	
	if (empty($user_pass)) {
		msgbox('请输入原始密码！');
	}
	
	if (empty($new_pass)) {
		msgbox('请输入新密码！');
	}
	
	if (empty($new_pass1)) {
		msgbox('请输入确认密码！');
	}
	
	if ($new_pass != $new_pass1) {
		msgbox('您两次输入的密码不一致！');
	}
	
	$user_pass = md5($user_pass);
	$new_pass  = md5($new_pass);
	
	$user = $Db->query("SELECT user_id, user_pass FROM $table WHERE user_id='$user_id'",'Row');
	if (!$user) {
		msgbox('不存在此用户！');
	} else {
		if ($user_pass != $user['user_pass']) {
			msgbox('您输入的原始密码不正确！');
		}
		$user_id =$user['user_id'];
		$Db->update($table, array('user_email' => $user_email, 'user_pass' => $new_pass), "user_id = '$user_id'");
	}
	
	msgbox('帐号密码修改成功！', $fileurl);
}

Youke_display($tempfile);
