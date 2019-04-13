<?php
if (!defined('puyuetian'))
	exit('403');

if (!$_G['USER']['ID']) {
	ExitGourl('index.php?c=login&from=sms_reg');
}

if ($_G['GET']['SUBMIT'] == 'yes') {
	$phone = Cstr($_POST['phone'], FALSE, $_G['STRING']['NUMERICAL'], 11, 11);
	if (substr($phone, 0, 1) != 1 || !$phone) {
		exit(json_encode(array('state' => 'no', 'msg' => '手机号不正确')));
	}
	if ($_G['TABLE']['USER'] -> getId('phone', $phone)) {
		exit(json_encode(array('state' => 'no', 'msg' => '手机号已存在')));
	}
	if ($_SESSION['APP_PUYUETIAN_SMS_PHONE'] != $phone) {
		exit(json_encode(array('state' => 'no', 'msg' => '接收短信手机号与提交的手机号不一致')));
	}
	if ($_SESSION['APP_PUYUETIAN_SMS_CODE'] != $_POST['code'] || !$_POST['code']) {
		exit(json_encode(array('state' => 'no', 'msg' => '短信验证码错误')));
	}
	if ($_G['TABLE']['USER'] -> newData(array('id' => $_G['USER']['ID'], 'phone' => $phone))) {
		//$_SESSION['APP_PUYUETIAN_SMS_PHONE'] = $_SESSION['APP_PUYUETIAN_SMS_CODE'] = '';
		exit(json_encode(array('state' => 'ok', 'msg' => '修改成功')));
	} else {
		exit(json_encode(array('state' => 'no', 'msg' => '修改失败')));
	}
}
$_G['SET']['WEBTITLE'] = '换绑手机号';
$_G['TEMPLATE']['BODY'] = 'hadskycloudserver:sms_changephone';
