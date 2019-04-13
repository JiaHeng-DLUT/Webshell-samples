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

$pagename = '找回密码';
$tplfile = 'getpwd.html';
$table = table('users');

if (!$Youke->isCached($tplfile)) {
	$Youke->assign('pagename', $pagename);
	$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
	$Youke->assign('site_keywords', $options['site_keywords']);
	$Youke->assign('site_description', $options['site_description']);

    if (I('post.action') == 'send') {
		$user_email =  I('post.email','','addslashes');
		$check_code =  I('post.code','','strtolower');
		$post_time  =  time();
		$verify_code = random(32);
		
		if (empty($user_email) || !is_valid_email($user_email)) {
			msgbox('请输入有效的电子邮箱！');
		}
		
		if (empty($check_code) || $check_code != $_SESSION['code']) {
			unset($_SESSION['code']);
			msgbox('请输入正确的验证码！');	
		}
		
		$user = $Db->query("SELECT user_id, user_email, user_pass FROM $table WHERE user_email='$user_email'",'Row');
		if (!$user) {
			msgbox('您还不是本站的会员！');
		} else {
			$user_id =$user['user_id'];
			$Db->update($table, array('verify_code' => $verify_code), "user_id ='$user_id'");
			
			$reset_link = url('member/reset',['uid'=>$user['user_id'],'code'=>$verify_code],$options['site_url']);
			
			//发送邮件
			if (!empty($options['smtp_host']) && !empty($options['smtp_port']) && !empty($options['smtp_auth']) && !empty($options['smtp_user'])  && !empty($options['smtp_pass'])) {
				
				$Youke->assign('site_name', $options['site_name']);
				$Youke->assign('site_url', $options['site_url']);
				$Youke->assign('user_email', $user['user_email']);
				$Youke->assign('post_time', date('Y-m-d H:i:s', $post_time));
				$Youke->assign('reset_link', $reset_link);
				$mailbody = $Youke->fetch('reset_mail.html');
				if (!sendmail($user_email, '['.$options['site_name'].'] 重置密码！', $mailbody)) {
					
					msgbox('邮件发送失败！请检查邮件发送功能设置是否正确或邮件地址错误！');
				}
			}
			unset($_SESSION['code']);
			
			msgbox('您好！已经将密码重置邮件发至<font color="#ff6600">'.$user['user_email'].'</font>邮箱中。');
		}
	}
}

Youke_display($tplfile);
