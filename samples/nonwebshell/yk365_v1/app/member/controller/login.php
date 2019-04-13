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

$pagename = '登录账户';
$pageurl = url('login');
$tplfile = 'login.html';
$table = table('users');

if (!$Youke->isCached($tplfile)) {
	$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
	$Youke->assign('site_keywords', $options['site_keywords']);
	$Youke->assign('site_description', $options['site_description']);

    
    if (I('post.action') == 'login') {
		$nick_name =   I('post.nick_name','','addslashes');
		$user_pass =   I('post.pass');
		$open_id   =   I('post.open_id',0,'addslashes');
		
		if (empty($nick_name)) {
			msgbox('用户名为空或者错误！');
		}
        
		if (empty($user_pass)) {
			msgbox('请输入登陆密码！');
		}
		
		$newpass = md5($user_pass);
		$user = $Db->query("SELECT user_id, user_pass, login_time, login_count FROM $table WHERE nick_name='$nick_name'",'Row');
		if (!$user) {
			msgbox('用户名或密码错误，请重试！');
		} else {
            if ($newpass != $user['user_pass']) {
            	msgbox('用户名或密码错误，请重试！');
            } else {
				//积分
				if (datediff('h', $user['login_time']) == 24) {
					$Db->query("UPDATE $table SET user_score=user_score+1 WHERE user_id=".$user['user_id']." LIMIT 1");
				}
				
				$ip_address = sprintf("%u", ip2long(get_client_ip()));
            	$login_count = $user['login_count'] + 1;
				
				$data = array(
					'login_time'  => time(),
					'login_ip'    => $ip_address,
					'login_count' => $login_count,
					'open_id'     => $open_id,
				);
				$user_id = $user['user_id'];
				$where = "user_id = '$user_id'";
				$Db->update($table, $data, $where);
				
				$auth_cookie = authcode("$user[user_id]|$newpass|$login_count");
				session('auth_cookie',$auth_cookie);


				redirect(url('member/home'));
			}
		}
	}
}

Youke_display($tplfile);
