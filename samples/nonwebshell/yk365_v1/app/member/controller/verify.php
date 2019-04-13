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

$userinfo = is_login();

$user_email = $userinfo['user_email'];

$verify_code = random(32);

$active_link = "$options[site_url]".trim(url('member/activate'),'/')."?uid=$userinfo[user_id]&code=$verify_code";

//发送邮件
if (!empty($options['smtp_host']) && !empty($options['smtp_port']) && !empty($options['smtp_auth']) && !empty($options['smtp_user'])  && !empty($options['smtp_pass'])) {		
	$Youke->assign('site_name', $options['site_name']);
	$Youke->assign('site_url', $options['site_url']);
	$Youke->assign('user_email', $user_email);
	$Youke->assign('active_link', $active_link);
	$mailbody = $Youke->fetch('verify_mail.html');
	


	if (sendmail($user_email, '['.$options['site_name'].'] E-mail地址验证！', $mailbody)) {
		$user_id  = trim($userinfo['user_id']);
		$Db->update(table('users'),array('verify_code' => $verify_code, 'join_time' => time()),"user_id = '$user_id'",false);

		msgbox('验证邮件发送成功！', url('home'));
	} else {
		msgbox('验证邮件发送失败！请稍后再试..',  url('home'));
	}
}else{
	msgbox('系统未开通邮件功能');
}

