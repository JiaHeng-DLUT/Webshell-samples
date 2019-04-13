<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['USER']['ID']) {
	ExitGourl('index.php?from=sms_reg');
}

if ($_G['GET']['SUBMIT'] == 'yes') {
	if ($_SESSION['APP_PUYUETIAN_SMS_PHONE'] != $_POST['phone'] || !$_POST['phone']) {
		exit(json_encode(array('state' => 'no', 'msg' => '接收短信手机号与提交的手机号不一致')));
	}
	if ($_SESSION['APP_PUYUETIAN_SMS_CODE'] != $_POST['code'] || !$_POST['code']) {
		exit(json_encode(array('state' => 'no', 'msg' => '短信验证码错误')));
	}
	if (!$_POST['username']) {
		exit(json_encode(array('state' => 'no', 'msg' => '请输入用户名')));
	}
	if (!$_POST['phone']) {
		exit(json_encode(array('state' => 'no', 'msg' => '请输入手机号')));
	}
	if (!Cstr($_POST['password'], FALSE, FALSE, 5, 16)) {
		exit(json_encode(array('state' => 'no', 'msg' => '请输新密码，且5-16位')));
	}
	$userdata = $_G['TABLE']['USER'] -> getData(array('username' => $_POST['username'], 'phone' => $_POST['phone']));
	if (!$userdata) {
		exit(json_encode(array('state' => 'no', 'msg' => '用户名与手机号不对应')));
	}
	if ($userdata['id'] == 1) {
		exit(json_encode(array('state' => 'no', 'msg' => '创始人无法使用该功能，请前往官方下载创始人密码初始化工具进行找回')));
	}
	if ($_G['TABLE']['USER'] -> newData(array('id' => $userdata['id'], 'password' => md5($_POST['password'])))) {
		//$_SESSION['APP_PUYUETIAN_SMS_PHONE'] = $_SESSION['APP_PUYUETIAN_SMS_CODE'] = '';
		exit(json_encode(array('state' => 'ok', 'msg' => '找回成功')));
	} else {
		exit(json_encode(array('state' => 'no', 'msg' => '密码找回失败')));
	}
}
$_G['SET']['WEBTITLE'] = '用手机号找回密码';
$_G['TEMPLATE']['BODY'] = 'hadskycloudserver:sms_forgetpassword';
