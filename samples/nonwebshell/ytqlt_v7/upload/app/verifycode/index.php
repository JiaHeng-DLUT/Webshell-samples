<?php
if (!defined('puyuetian'))
	exit('Not Found puyuetian!Please contact QQ632827168');

require $_G['SYSTEM']['PATH'] . '/app/verifycode/class.php';

//滑动验证
if ($_G['SET']['APP_VERIFYCODE_OPENSLIDING'] && $_G['GET']['RANGEVERIFYCODE']) {
	if (strlen(Cnum($_SESSION['APP_VERIFYCODE_' . strtoupper($_G['GET']['TYPE'])])) != 5) {
		$_SESSION['APP_VERIFYCODE_' . strtoupper($_G['GET']['TYPE'])] = rand(10000, 99999);
	}
	$verifycode = (string)$_SESSION['APP_VERIFYCODE_' . strtoupper($_G['GET']['TYPE'])];
	$rnd = (string)CreateRandomString(8);
	$mw = md5($verifycode . $rnd);
	echo $mw . '|' . $rnd;
} else {
	//先把类包含进来，实际路径根据实际情况进行修改。
	$_vc = new ValidateCode();
	//实例化一个对象
	$_vc -> doimg();
	$_SESSION['APP_VERIFYCODE_' . strtoupper($_G['GET']['TYPE'])] = $_vc -> getCode();
	//验证码保存到SESSION中
}

exit();
