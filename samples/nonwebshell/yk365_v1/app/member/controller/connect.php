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



if ($options['is_enabled_connect'] == 'yes') {
	if (empty($options['qq_appid']) || empty($options['qq_appkey'])) {
		msgbox('QQ一键登录未正确设置，请设置后再使用！');	
	}
} else {
	msgbox('未开启QQ一键登录或注册功能！');
}


$table = table('users');

$type = I('get.type');
if (empty($type)) $type = 'init';



$config = array(
	'appid'    => $options['qq_appid'],
	'appkey'   => $options['qq_appkey'], 
	'callback' => rtrim($options['site_url'],'/').url('member/connect',['type'=>'callback'])
	);



$oauth = oauth_qq::get_instance($config);
//login
if ($type == 'init') 

	$oauth->login();

if ($type == 'callback') {

	$query = parse_url($_SERVER['REQUEST_URI']);
	parse_str($query['query'],$_REQUEST);


	$response = $oauth->callback();
	$msg = json_decode($response);
		if (isset($msg->error)) {
					// echo "<h3>error:</h3>" . $msg->error;
					// echo "<h3>message:</h3>" . $msg->error_description;
			  msgbox('token失效，请重新登陆！');
	          exit;
		}
				
    $oauth->get_openid();
	$user = $oauth->get_user_info();

     $open_id = $_SESSION['openid'];
	if (empty($open_id)) {
		msgbox('QQ一键登录授权失败，请采用普通方式注册和登录！', '/member/?mod=login');
	} else {
		$row = $Db->query("SELECT user_id, user_pass, login_time FROM $table WHERE open_id='$open_id'",'Row');
		if ($row) {
			$ip_address = sprintf("%u", ip2long(get_client_ip()));
        	$login_count = $row['login_count'] + 1;
					
			$data = array(
				'login_time' => time(),
				'login_ip' => $ip_address,
				'login_count' => $login_count,
			);
			$user_id =$row['user_id'];
			$where = "user_id = '$user_id'";
			$Db->update($table, $data, $where);
			
			$auth_cookie = authcode("$row[user_id]|$row[user_pass]|$login_count");
		
		    session('auth_cookie',$auth_cookie);
				
			redirect(url('member/home'));
		} else {

		
			$auth_cookie = session('auth_cookie');
			$myself = check_user_login($auth_cookie);
			if (!empty($myself)) {
				$Db->update($table, array('open_id' => $open_id), array('user_id' => $myself['user_id']));
			} else {
				$tplfile = 'connect.html';
				
				$Youke->assign('nick_name', $user['nickname']);
				$Youke->assign('open_id', $open_id);
				Youke_display($tplfile);
			}
		}
	}
}
