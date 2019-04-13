<?php
if (!defined('puyuetian'))
	exit('403');

$username = $_POST['username'];
$password = $_POST['password'];

if (!$username || !$password) {
	ExitJson('用户名和密码不能为空');
}

$userdata = $_G['TABLE']['USER'] -> getData(array('username' => $username, 'password' => md5($password)));

if (!$userdata) {
	ExitJson('用户名或密码错误');
}

ExitJson($userdata, TRUE);
