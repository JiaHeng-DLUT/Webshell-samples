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

require(YOUKE365_PATH.'extend/connect/oauth_qq.php');

$table = table('website');


require(APP_PATH.'common.php');

/** navitem */
$navitem = array('home' => '会员中心', 'website' => '网站管理', 'addurl' => '网站提交', 'claim' => '网站认领', 'article' => '文章管理', 'profile' => '个人资料', 'editpwd' => '修改密码', 'logout' => '安全退出');
$Youke->assign('navitem', $navitem);


	

		if (in_array($module, $verify)) {
			if ($myself['user_status'] == -1) {
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
<div id="msgbox">你还未通过E-mail验证！<br /><a href="?mod=verify">[点击发送验证邮件]</a></div>
</body>
</html>
EOT;
				exit($msg);
			}

}

