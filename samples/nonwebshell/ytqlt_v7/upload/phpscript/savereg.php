<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['SET']['USERNAMEEVERYCHARS']) {
	preg_match('/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u', $_POST['username']) ? $username = $_POST['username'] : $username = FALSE;
	if (strlen($username) > 24 || strlen($username) < 3) {
		$username = FALSE;
	}
} else {
	$username = Cstr($_POST['username'], FALSE, TRUE, 3, 24);
}
if (Cnum($username)) {
	$username = FALSE;
}
$password = Cstr($_POST['password'], FALSE, FALSE, 5, 16);
$verifycode = Cstr($_POST['verifycode'], FALSE, TRUE, 1, 255);
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$nickname = Cstr(htmlspecialchars(trim(strip_tags($_POST['nickname']))), FALSE, FALSE, 1, 24);
if (!$nickname) {
	$nickname = $username;
}
$sex = Cstr($_POST['sex'], 's', 'gbs', 1, 1);
$userhead = substr($_POST['userhead'], 22);
if (strlen($userhead) > Cnum($_G['SET']['UPLOADHEADSIZE'], 512, TRUE, 0) * 1000) {
	$userhead = FALSE;
}

if (!$_G['SET']['OPENREG']) {
	exit('Register Close!');
}

$r = FALSE;
for ($rf = 0; $rf < 1; $rf++) {
	if (!$username) {
		if ($_G['SET']['USERNAMEEVERYCHARS']) {
			$r = '用户名：可由汉字、字母、数字及下划线组成，不能为纯数字且最多8个汉字';
		} else {
			$r = '用户名：仅由字母、数字及下划线组成，不能为纯数字且3-24位';
		}
		break;
	}
	if (!$password) {
		$r = '密码：5-16位';
		break;
	}
	if (!$sex) {
		$r = '性别数据错误';
		break;
	}
	if (!$email) {
		$r = '请填写正确的Email地址';
		break;
	}
	if (!$nickname) {
		$r = '昵称：不能为空且最多8个汉字';
		break;
	}
	if (!chkVerifycode($verifycode, 'reg')) {
		$_SESSION['APP_VERIFYCODE_REG'] = '';
		$r = '验证码错误';
		break;
	}
	$_SESSION['APP_VERIFYCODE_REG'] = '';
	if ($_G['TABLE']['USER'] -> getId('username', $username)) {
		$r = '该用户名已经存在！';
		break;
	}
	if ($_G['TABLE']['USER'] -> getId('email', $email)) {
		$r = '该邮箱已经存在！';
		break;
	}
	//检测用户信息是否包含违禁词
	$wjcs = $_G['SET']['BANREGWORDS'];
	if ($wjcs) {
		$wjcs = explode(',', $wjcs);
		foreach ($wjcs as $w) {
			if ($w) {
				if (strpos($username, $w) !== FALSE || strpos(str_replace(array("\n", "\r", "\r\n", "\t", " "), '', $nickname), $w) !== FALSE) {
					$r = '用户名或昵称包含违禁词，请修改后再注册';
					break 2;
				}
			}
		}
	}
	$regarray['username'] = $username;
	$regarray['password'] = md5($password);
	$regarray['email'] = $email;
	$regarray['nickname'] = $nickname;
	$regarray['sex'] = $sex;
	$regarray['regip'] = getClientInfos('ip');
	$regarray['regtime'] = time();
	$regarray['groupid'] = Cnum($_G['SET']['REGUSERGROUPID'], 0, TRUE, 0);
	$regarray['readlevel'] = Cnum($_G['SET']['REGREADLEVEL'], 10, TRUE);
	$regarray['quanxian'] = $_G['SET']['REGUSERQUANXIAN'];
	$regarray['jifen'] = Cnum($_G['SET']['REGJIFEN']);
	$regarray['tiandou'] = Cnum($_G['SET']['REGTIANDOU']);
	$regarray['friends'] = $_G['SET']['REGFRIENDS'];
	if (!$_G['TABLE']['USER'] -> newData($regarray)) {
		$r = '注册失败：' . mysql_error();
		break;
	}
	$userdata = UserLogin(array('username' => $username));
	if ($userhead) {
		file_put_contents("{$_G['SYSTEM']['PATH']}/userhead/{$userdata['id']}.png", base64_decode($userhead));
	}
	//发送欢迎信息
	if ($_G['SET']['REGMESSAGE']) {
		NewMessage($userdata['id'], template('', TRUE, $_G['SET']['REGMESSAGE']), 0, 2);
	}
	//发送邮件
	if (function_exists('sendmail') && $_G['SET']['APP_SYSTEMEMAIL_REGSENDEMAIL'] && $_G['SET']['REGMESSAGE']) {
		sendmail($email, $_G['SET']['LOGOTEXT'] . ' - 恭喜您注册成为会员', template('', TRUE, $_G['SET']['REGMESSAGE']));
	}
	$_SESSION['APP_PUYUETIAN_QQLOGIN_OPENID'] = $_SESSION['APP_PUYUETIAN_QQLOGIN_NICKNAME'] = '';
	if ($_G['GET']['RETURN'] == 'json') {
		exit(json_encode(array('state' => 'ok', 'msg' => '注册成功')));
	} else {
		PkPopup('{
			content:"注册成功",
			icon:2,
			hideclose:true,
			shade:true,
			submit:function(){
				location.href="index.php?c=center";
			}
		}');
	}
}

if ($r) {
	if ($_G['GET']['RETURN'] == 'json') {
		exit(json_encode(array('state' => 'no', 'msg' => $r)));
	} else {
		PkPopup('{
			content:"' . $r . '",
			icon:2,
			hideclose:true,
			shade:true
		}');
	}
}
