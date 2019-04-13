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
// 登陆验证
$userinfo = is_login();
$pagename = '个人资料';
$pageurl = url('info');
$tplfile = 'info.html';
$table = table('users');

$where = "w.user_id=".$userinfo['user_id'];
$total = $Db->getCount($table.' w','*',$where);
$Youke->assign('myself', $userinfo);
$Youke->assign('total',$total);


if (!$Youke->isCached($tplfile)) {


	$Youke->assign('pagename', $pagename);
	$Youke->assign('site_title', $pagename.' - '.$options['site_name']);

	
	if (!empty($_POST['do']) && $_POST['do'] == 'save') {
		$old_pass  = I('post.old_pass');
		$new_pass  = I('post.new_pass');
		$new_pass1 = I('post.new_pass1');
		$nick_name = I('post.nick_name','','addslashes');
		$user_qq   = I('post.user_qq','','addslashes');
		
		if (empty($old_pass)) {
			msgbox('请输入原始密码！');
		} else {
			$user = $Db->query("SELECT user_pass FROM $table WHERE user_id = ".$userinfo['user_id'],'Row');
			if ($user['user_pass'] != md5($old_pass)) {
				unset($user);
				msgbox('您输入的原始密码不正确！');
			}
		}
		
		if (empty($new_pass)) {
			msgbox('请输入新密码！');
		}
		
		if (empty($new_pass1)) {
			msgbox('请输入确认密码！');
		}
		
		if ($new_pass != $new_pass1) {
			msgbox('两次密码输入不一致，请重新输入！');
		}
		if (strlen_utf8($nick_name) < $options['regname_small'] || strlen_utf8($nick_name) > $options['regname_large']) {
			msgbox('昵称长度请保持在'.$options['regname_small'].'-'.$options['regname_large'].'个字符！每个汉字算一个字符~');
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
		
		$data = array(
			'user_pass' => md5($new_pass),
			'nick_name' => $nick_name,
			'user_qq'   => $user_qq,
		);
		
		$user_id =  $userinfo['user_id'];
		$where= "user_id = '$user_id'";
		$Db->update($table, $data, $where);
		msgbox('个人资料修改成功！', $pageurl);
	}
}

Youke_display($tplfile);
