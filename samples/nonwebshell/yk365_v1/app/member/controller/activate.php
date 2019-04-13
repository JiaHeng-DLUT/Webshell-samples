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

$pagename = '会员激活';
$pageurl  = url('activate');
$tplfile  = 'activate.html';
$table    = table('users');

if (!$Youke->isCached($tplfile)) {
	$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
	$Youke->assign('site_keywords', $options['site_keywords']);
	$Youke->assign('site_description', $options['site_description']);
	// 接收请求数据
	$user_id     = I('get.uid','','intval');
	$verify_code = I('get.code','','addslashes');
	
	$user = $Db->query("SELECT user_id, verify_code, join_time FROM $table WHERE user_id=$user_id LIMIT 1",'Row');
	if (!$user) {
		msgbox('您还不是本站的会员！', '?mod=register');
	}


	$twodays = $user['join_time'] + (2 * 24 * 3600);
	if ($twodays >= time()) {
		if ($verify_code == $user['verify_code']) {
            $user_id  = $user["user_id"];
			$Db->update($table, array('user_status' => 1), "user_id = '$user_id'");

			$message = '帐号激活成功！<br /><br /><a href="'.url('login').'">立即登录账户>></a>';
		} else {
			$message = '帐号激活失败！';
		}
	} else {
		$message = '可能是因为超过48小时没有完成验证，该链接地址已经失效！';
	}
	
	$Youke->assign('message', $message);
}

Youke_display($tplfile);
