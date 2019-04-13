<?php
if (!defined('puyuetian'))
	exit('403');

//提取用户名
if (Cnum($_POST['username'], FALSE, TRUE, 1)) {
	//手机号或uid
	if (strlen($_POST['username']) == 11) {
		$__ud = $_G['TABLE']['USER'] -> getData(array('phone' => $_POST['username']));
	} else {
		$__ud = $_G['TABLE']['USER'] -> getData($_POST['username']);
	}
	$username = $__ud['username'];
} elseif (strpos($_POST['username'], '@')) {
	//邮箱
	$__ud = $_G['TABLE']['USER'] -> getData(array('email' => $_POST['username']));
	$username = $__ud['username'];
} else {
	//用户名
	preg_match('/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u', $_POST['username']) ? $username = $_POST['username'] : $username = FALSE;
	if (strlen($username) > 24 || strlen($username) < 3) {
		$username = FALSE;
	}
}
unset($__ud);
$verifycode = Cstr($_POST['verifycode'], FALSE, TRUE, 1, 255);
$enpw = Cnum($_POST['enpw'], FALSE, TRUE, 0, 1);
if ($enpw) {
	$password = Cstr($_POST['password'], FALSE, TRUE, 32, 32);
} else {
	$password = Cstr($_POST['password'], FALSE, FALSE, 5, 16);
}
$code = Cstr($_POST['code'], FALSE, TRUE, 32, 32);
$ip = getClientInfos('ip');

$chkr = FALSE;
for ($rf = 0; $rf < 1; $rf++) {
	if (!$username || !$password) {
		$chkr = '请填入正确的登录信息';
		break;
	}

	if (!chkVerifycode($verifycode, 'login')) {
		$chkr = '验证码错误';
		break;
	}

	//=========================清除验证码信息和检测用户登录=============================
	$_SESSION['APP_VERIFYCODE_LOGIN'] = '';

	$trylogindata = $_G['TABLE']['USER'] -> getData(array('username' => $username));
	if (!$trylogindata) {
		$chkr = '用户名或密码错误';
		break;
	}
	//登录次数判断
	$array = array();
	$array['id'] = $trylogindata['id'];
	if (JsonData($trylogindata['data'], 'logindate') == date('Ymd', time())) {
		$loginfaildata = json_decode(JsonData($trylogindata['data'], 'trylogindata'), TRUE);
		if (Cnum($loginfaildata[$ip]) >= Cnum($_G['SET']['TRYLOGINCOUNT'], 10)) {
			$chkr = '该ip今日尝试登录次数已用尽，请明日再来';
			break;
		}
	} else {
		$trylogindata['data'] = JsonData($trylogindata['data'], 'trylogindata', '');
	}

	$sql = array('username' => $username, 'password' => md5($password));
	if ($enpw) {
		if (md5($trylogindata['password'] . $code) == $password) {
			unset($sql['password']);
		}
	}
	$userdata = UserLogin($sql);
	if (!$userdata) {
		//记录此次登录失败
		$chkr = $_G['USERLOGINFAILEDINFO'];
		$loginfaildata = json_decode(JsonData($trylogindata['data'], 'trylogindata'), TRUE);
		if ($loginfaildata[$ip]) {
			$loginfaildata[$ip]++;
		} else {
			$loginfaildata[$ip] = 1;
		}
		$array['data'] = JsonData($trylogindata['data'], 'logindate', date('Ymd', time()));
		$array['data'] = JsonData($array['data'], 'trylogindata', array(json_encode($loginfaildata)));
		$_G['TABLE']['USER'] -> newData($array);
		break;
	}
	//登录成功，记录当日登录记录
	$userdata['data'] = $trylogindata['data'];
	$array['data'] = JsonData($userdata['data'], 'logindate', date('Ymd', time()));
	$loginfaildata = json_decode(JsonData($userdata['data'], 'trylogindata'), TRUE);
	if (!$loginfaildata[$ip]) {
		$loginfaildata[$ip] = 0;
	}
	$loginfaildata = json_encode($loginfaildata);
	$array['data'] = JsonData($array['data'], 'trylogindata', array($loginfaildata));
	$_G['TABLE']['USER'] -> newData($array);
	if ($_GET['referer']) {
		//防止无法添加端口号和跳转到其他网站
		if (substr($_GET['referer'], 0, 7) == 'http://' || substr($_GET['referer'], 0, 8) == 'https://') {
			$url = explode('//', $_GET['referer']);
			$referer = $url[1];
			$referer = explode('/', $referer);
			if ($_G['SYSTEM']['DOMAIN'] != $referer[0]) {
				$_GET['referer'] = 'index.php';
			}
		}
	} else {
		$_GET['referer'] = 'index.php?c=center';
	}
	if ($_G['GET']['RETURN'] == 'json') {
		echo json_encode(array('state' => 'ok', 'msg' => '登录成功', 'referer' => $_GET['referer']));
	} else {
		ExitGourl($_GET['referer']);
	}
	exit();
}
if ($_G['GET']['RETURN'] == 'json') {
	exit(json_encode(array('state' => 'no', 'msg' => $chkr, 'referer' => $_GET['referer'])));
} else {
	PkPopup('{
		content:"' . $chkr . '",
		icon:2,
		hideclose:true,
		shade:true,
		submit:function(){
			location.href="index.php?c=login"
		}
	}');
}
