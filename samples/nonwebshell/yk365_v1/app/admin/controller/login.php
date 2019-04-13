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


$pagetitle = SYS_NAME.SYS_VERSION;
$fileurl   = url('login');
$tempfile  = 'login.html';
$table = table('users');


if (I('act') == 'login') {
	$nick_name = I('post.username','','addslashes');
	$pass = I('post.pass','','addslashes');
	$code = I('post.code','','intval');
	if(empty($code)){
      msgbox('验证码不能为空！');
	}
    //判断验证码
    if($code != $_SESSION['code']){
      msgbox('验证码错误！');
    }


	if (empty($nick_name)) {
		msgbox('用户名不能为空！');
	}
    //用户名验证码
    if(!preg_match("/[a-zA-Z0-9]{3,50}/u",$nick_name)){
        msgbox('用户名格式错误！');
    }
	if (empty($pass)) {
		msgbox('密码不能为空！');
	}
	
	$user = $Db->query("SELECT user_id, user_pass, login_count FROM $table WHERE user_type='admin' AND nick_name='$nick_name'",'Row');


	if ($user['user_id'] && $user['user_pass'] == md5($pass)) {
		$ip_address = sprintf("%u", ip2long(get_client_ip()));
		$login_count = $user['login_count'] + 1;
		$data = [
			'login_time'  => time(),
			'login_ip'    => $ip_address,
			'login_count' => $login_count,
		];
		$user_id =$user['user_id'];
		$where = "user_id  = '$user_id'";
		$Db->update($table, $data, $where);
		$user_auth = authcode("$user[user_id]@$user[user_pass]");
		setcookie('user_auth', $user_auth);
		redirect(url('index'));
	} else {
		msgbox('用户名或密码错误！');
	}
}




if (I('get.act')== 'logout') {
	setcookie('user_auth','');
	redirect(url('login',['YouKe365Code'=>$_SESSION['YouKe365Code']]));
}

$YouKe365Code = isset($_SESSION['YouKe365Code'])?$_SESSION['YouKe365Code']:'';
if(!I('get.YouKe365Code') || I('get.YouKe365Code') != $YouKe365Code){
  msgbox('非法请求','/');
}

Youke_display($tempfile);
