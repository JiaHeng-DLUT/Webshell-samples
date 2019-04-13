<?php
/****************优客365网址导航系统 开源版********************/
/*                                                            */
/*  Youke365.site (C)2018 Youke365 Inc.                       */
/*  This is NOT a freeware, use is subject to license terms   */
/*  优客365网址导航开源版 个人用户可免费使用  请保留底部版权  */
/*  2018.4                                                    */
/*  官方网址：http://www.youke365.site                        */
/*  官方论坛：http://bbs.youke365.site                        */                           
/**************************************************************/
if (!defined('IN_YOUKE365')) exit('Access Denied');

$pagename = '密码重置';
$pageurl  = url('reset');
$tplfile  = 'reset.html';
$table    = table('users');

if (!$Youke->isCached($tplfile)) {
	$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
	$Youke->assign('site_keywords', $options['site_keywords']);
	$Youke->assign('site_description', $options['site_description']);

	
	$user_id     = I('get.uid','','intval');
	$verify_code = I('get.code');
	if (empty($verify_code)) {
		msgbox('校验代码错误！');
	}
	$Youke->assign('code', $verify_code);
	
	$user = $Db->query("SELECT user_id FROM $table WHERE user_id='$user_id'",'Row');
    if (!$user) {
       	msgbox('您还不是本站会员！', '?mod=register');
	}
	
	if (I('post.action') == 'save') {
		$user_email   = I('post.email','','addslashes');
		$verify_code  = I('post.code');
		$user_pass    = I('post.pass');
		$user_pass1   = I('post.pass1');
		
		if (empty($user_email) || !is_valid_email($user_email)) {
			msgbox('请输入有效的电子邮箱！');
		}
		
		if (empty($verify_code)) {
			msgbox('请输入校验码！');
		}
		
		if (empty($user_pass)) {
			msgbox('请输入新密码！');
		} else {
			if (strlen($user_pass) < 6 || strlen($user_pass) > 20) {
				msgbox('密码长度请保持在6-20个字符！');
			}
		}
				
		if (empty($user_pass1)) {
			msgbox('请输入确认密码！');
		}
		
		if ($user_pass != $user_pass1) {
			msgbox('两次密码输入不一致，请重新输入！');
		}
		
		$user = $Db->query("SELECT user_id, verify_code FROM $table WHERE user_email='$user_email'",'Row');
    	if (!$user) {
        	msgbox('您还不是本站会员！', url('register'));
    	} else {
			if ($verify_code != $user['verify_code']) {
				msgbox('校验代码错误或已失效！');
			}
			$user_id =$user['user_id'];
			$Db->update($table, array('user_pass' => md5($user_pass)),"user_id = '$user_id'");
			
			msgbox('恭喜！您的密码已重置成功！', url('login'));	
		}
	}
}

Youke_display($tplfile);
