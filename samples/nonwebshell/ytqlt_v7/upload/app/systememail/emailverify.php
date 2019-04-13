<?php
if (!defined('puyuetian'))
	exit('403');

if (!$_G['SET']['APP_SYSTEMEMAIL_EMAILVERIFY']) {
	ExitJson('未开启邮箱验证功能');
}

if (!$_G['USER']['ID']) {
	ExitJson('请您先完成注册');
}

$svf = $_POST['safeverifycode'];
$vf = $_POST['verifycode'];

$emailverify = JsonData($_G['USER']['DATA'], 'systememail_emailverify');

if (!$emailverify) {
	ExitJson('系统未成功发送验证码');
}

if ($svf != md5($_G['SET']['KEY'] . $emailverify)) {
	ExitJson('安全验证失败');
}

if ($vf != $emailverify) {
	ExitJson('邮箱验证码不正确');
}

if (!$_G['TABLE']['USER'] -> newData(array('id' => $_G['USER']['ID'], 'data' => JsonData($_G['USER']['DATA'], 'systememail_emailverify', FALSE)))) {
	ExitJson('数据写入失败');
}

ExitJson('验证成功', TRUE);
