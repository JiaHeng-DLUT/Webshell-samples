<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['USER']['ID']) {
	header("Location:index.php?c=user");
}
$_G['SET']['WEBNAME'] = "忘记密码 - " . $_G['SET']['WEBNAME'];
$mailverifycode = Cstr($_POST['mailverifycode']);
$password = Cstr($_POST['password'], false, false, 5, 16);
preg_match('/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u', $_POST['username']) ? $username = $_POST['username'] : $username = FALSE;
$verifycode = $_POST['verifycode'];
$mail = filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL);
if ($mailverifycode && $password) {
	if ($verifycode == $_SESSION['APP_VERIFYCODE_FORGOTPASSWORD'] && $verifycode) {
		$_SESSION['APP_VERIFYCODE_FORGOTPASSWORD'] = '';
		$uid = Cnum($_POST['uid']);
		if ($mailverifycode == $_SESSION['PLUG_puyuetian_mail_mailverifycode'] && $_SESSION['PLUG_puyuetian_mail_uid'] == $uid) {
			$array['id'] = $uid;
			$array['password'] = md5($password);
			$_G['TABLE']['USER'] -> newData($array);
			$_G['HTMLCODE']['TIPJS'] = "location.href='index.php?c=login'";
			$_G['HTMLCODE']['TIP'] = "密码找回成功，请登录！";
			$_SESSION['PLUG_puyuetian_mail_mailverifycode'] = $_SESSION['PLUG_puyuetian_mail_uid'] = '';
			$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
		} else {
			$_G['HTMLCODE']['TIP'] = "邮箱校验码错误！";
			$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
		}
	} else {
		$_SESSION['APP_VERIFYCODE_FORGOTPASSWORD'] = '';
		$_G['HTMLCODE']['TIP'] = "验证码错误！";
		$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
	}
} elseif ($username && $mail) {
	if ($verifycode == $_SESSION['APP_VERIFYCODE_FORGOTPASSWORD'] && $verifycode) {
		$_SESSION['APP_VERIFYCODE_FORGOTPASSWORD'] = '';
		$uid = $_G['TABLE']['USER'] -> getId(array("username" => $username, "email" => $mail));
		if ($uid) {
			if ($uid == 1) {
				$_G['HTMLCODE']['TIP'] = "创始人不可使用此功能！";
				$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
			} else {
				$mailverifycode = CreateRandomString(8);
				$_SESSION['PLUG_puyuetian_mail_mailverifycode'] = $mailverifycode;
				$_SESSION['PLUG_puyuetian_mail_uid'] = $uid;
				$mailcontent = template("systememail:sendforgotpasswordmail", TRUE);
				$mailtitle = '用户找回密码';
				sendmail($mail, $mailtitle, $mailcontent);
				header("Location:index.php?c=app&a=systememail:forgotpassword&type=verify&uid={$uid}");
			}
		} else {
			$_G['HTMLCODE']['TIP'] = "不存在的用户或邮箱！";
			$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
		}
	} else {
		$_SESSION['APP_VERIFYCODE_FORGOTPASSWORD'] = '';
		$_G['HTMLCODE']['TIP'] = "验证码错误！";
		$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
	}
} else {
	if ($_POST['password'] || $_POST['mailverifycode']) {
		header("Location:index.php?c=app&a=systememail:forgotpassword&type=verify&uid={$uid}");
	}
	$_G['HTMLCODE']['OUTPUT'] .= template("systememail:forgotpassword", TRUE);
}
