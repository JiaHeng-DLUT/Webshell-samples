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

$pagename = '新会员注册';
$pageurl = url('register');
$tplfile = 'register.html';
$table = table('users');

if ($options['is_enabled_register'] == 'no') {

	$msg = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提示信息 - $options[site_name]</title>
<style type="text/css">
body {background: #f5f5f5;}
#msgbox {background: #fff; border: solid 3px #f1f1f1; font: normal 16px/30px normal; margin: 100px auto; padding: 100px 0; text-align: center; width: 500px;}
</style>
</head>

<body>
<div id="msgbox">抱歉，目前站点禁止新用户注册！<br /><a href="javascript:history.back();">[点击这里返回上一页]</a></div>
</body>
</html>
EOT;

	exit($msg);
}



			
if (!$Youke->isCached($tplfile)) {
	$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
	$Youke->assign('site_keywords', $options['site_keywords']);
	$Youke->assign('site_description', $options['site_description']);


    if (I('post.action')  == 'register') {
        $nick_name   = I('post.nick_name','','addslashes');
		$user_pass   = I('post.pass');
		$open_id     = I('post.open_id','','addslashes');
		$user_email  = I('post.email','','addslashes');
		$user_pass1  = I('post.pass1');
		$user_qq     = I('post.qq','','addslashes');
		$check_code  = I('post.code','','addslashes');
		$post_time   = time();
		$verify_code = random(32);
		
		if (empty($user_email) || !is_valid_email($user_email)) {
			msgbox('请输入正确的电子邮箱！');
		}
		
		if (empty($user_pass)) {
			msgbox('请输入帐号密码！');
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
		
		if (empty($nick_name)) {
			msgbox('请输入昵称！');
		}
 
		if (strlen_utf8($nick_name) < $options['regname_small'] || strlen_utf8($nick_name) > $options['regname_large']) {
			msgbox('昵称长度请保持在'.$options['regname_small'].'-'.$options['regname_large'].'个字符！每个汉字算一个字符~'.strlen_utf8($nick_name));
		}

		if($options['regname_forbid']){
			$detail=explode("\r\n",$options['regname_forbid']);
			if(in_array($nick_name,$detail)){
				msgbox('受保护的帐号,不允许使用,请更换一个吧！');
			}
		}
		
		if (empty($user_qq)) {
			msgbox('请输入正确的腾讯QQ帐号！');
		} else {
			if (strlen($user_qq) < 5 || strlen($user_qq) > 11) {
				msgbox('QQ长度请保持在5-11个字符！');
 			}
		}
		
		if (empty($check_code) || $check_code != $_SESSION['code']) {
			msgbox('请输入正确的验证码！');
		}
		
		$query = $Db->query("SELECT user_id FROM $table WHERE nick_name='$nick_name'");
    	if (count($query)) {
        	msgbox('该帐号已被注册！');
    	}

		$query = $Db->query("SELECT user_id FROM $table WHERE user_email='$user_email'");
    	if (count($query)) {
        	msgbox('该邮箱已被其他用户绑定，请更换邮箱！');
    	}		

		if ($options['register_email_verify'] == 'yes') {
			$status = -1;
			$message = '马上去注册邮箱激活账号，完成最后一步!';
		} else {
			$status = 1;
			$message = '';
		}
		
		$user_data = array(
			'user_type'   => 'member',
			'user_email'  => $user_email,
			'user_pass'   => md5($user_pass),
			'nick_name'   => $nick_name,
			'user_qq'     => $user_qq,
			'verify_code' => $verify_code,
			'user_status' => $status,
			'open_id'     => $open_id,
			'join_time'   => $post_time,
		);
		$Db->insert($table, $user_data);
		$uid = $Db->insert_id();
		
		if ($options['register_email_verify'] == 'yes') {
			$active_link =url('member/activate',['uid'=>$uid,'code'=>$verify_code],$options['site_url']);
			
			//发送邮件
			if (!empty($options['smtp_host']) && !empty($options['smtp_port']) && !empty($options['smtp_auth']) && !empty($options['smtp_user'])  && !empty($options['smtp_pass'])) {		
				$Youke->assign('site_name', $options['site_name']);
				$Youke->assign('site_url', $options['site_url']);
				$Youke->assign('nick_name', $nick_name);
				$Youke->assign('user_pass', $user_pass);
				$Youke->assign('post_time', date('Y-m-d H:i:s', $post_time));
				$Youke->assign('active_link', $active_link);
				$mailbody = $Youke->fetch('register_mail.html');
				if (!sendmail($user_email, '['.$options['site_name'].'] E-mail地址验证！', $mailbody)) {
					msgbox('邮件发送失败！请检查邮件发送功能设置是否正确或邮件地址错误！');	
				}
			}
			
		}
		unset($_SESSION['code']);
		
		msgbox('恭喜！您已注册成功！<br>'.$message,url('login'));
	}
}

Youke_display($tplfile);

