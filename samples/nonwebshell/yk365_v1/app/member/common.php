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
function Youke_display($template, $cache_id = NULL, $compile_id = NULL) {
	global $Youke, $options;
	
    
	template_exists($template);
	
	$options = stripslashes_deep($options);
	
	$Youke->assign('site_root', $options['site_root']);
	$Youke->assign('site_name', $options['site_name']);
	$Youke->assign('site_url', $options['site_url']);
	$Youke->assign('site_copyright', $options['site_copyright']);
	$Youke->assign('cfg', $options); #options
	
	$content = $Youke->fetch($template, $cache_id, $compile_id);

	echo $content;
	#gzip
	$buffer = ob_get_contents();
	ob_end_clean();
	$options['is_enabled_gzip'] == 'yes' ? ob_start('ob_gzhandler') : ob_start();
	
	echo $buffer;
}



function is_login(){
	global $Db,$Youke,$cfg;
		  $auth_cookie = session('auth_cookie');
		if (empty($auth_cookie)) {
			msgbox('您还未登录或无权限！',url('login'));
			return;
		}		
		$userinfo = check_user_login($auth_cookie);
		if (empty($userinfo)) {
			msgbox('您还未登录或无权限！',url('login'));
			return;
		}

    return $userinfo;			
		
			


	

}

function is_email_verify(){
	global $cfg;
	 $auth_cookie = session('auth_cookie');
	$userinfo = check_user_login($auth_cookie);
	if ($userinfo['user_status']  == 0  && $cfg['register_email_verify'] != 'no') {
	$url =url('member/verify');
	$site_name = $cfg['site_name'];
	$msg = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提示信息 - '.$site_name.'</title>
<style type="text/css">
body {background: #f5f5f5;}
#msgbox {background: #fff; border: solid 3px #f1f1f1; font: normal 16px/30px normal; margin: 100px auto; padding: 100px 0; text-align: center; width: 500px;}
</style>
</head>

<body>
<div id="msgbox">你还未通过E-mail验证！<br /><a href="'.$url.'">[点击发送验证邮件]</a></div>
</body>
</html>';
  exit($msg);
}
}


