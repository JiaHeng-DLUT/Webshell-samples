<?php
if (!defined('puyuetian'))
	exit('403');

$id = Cnum($_POST['id'], 0, TRUE, 0);
$nickname = Cstr(htmlspecialchars(trim(strip_tags($_POST['nickname'])), ENT_QUOTES), FALSE, FALSE, 1, 25);
$sex = Cstr($_POST['sex'], FALSE, 'gbs', 1, 1);
$sign = Cstr(htmlspecialchars(trim(strip_tags($_POST['sign']), ''), ENT_QUOTES), FALSE, FALSE, 1, 255);
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$qq = Cstr($_POST['qq'], FALSE, $_G['STRING']['NUMERICAL'], 5, 10);
$phone = Cstr($_POST['phone'], FALSE, $_G['STRING']['NUMERICAL'], 11, 11);
$data_privacysettings = Cnum($_POST['data-privacysettings']);
$password = Cstr($_POST['password'], FALSE, FALSE, 5, 16);
$birthday = Cnum($_POST['birthday'], date('Ymd'), TRUE, 10000000, 99999999);
$userhead = substr($_POST['userhead'], 22);
if (strlen($userhead) > Cnum($_G['SET']['UPLOADHEADSIZE'], 512, TRUE, 0) * 1000) {
	$userhead = FALSE;
}

$r = FALSE;
for ($rf = 0; $rf < 1; $rf++) {
	if (!$id) {
		$r = '修改资料的目标UID错误';
		break;
	}
	if (!$nickname) {
		$r = '昵称：不能为空且最多8个汉字';
		break;
	}
	if (!$sex) {
		$r = '性别数据不合法';
		break;
	}
	if ($_G['USER']['ID'] != $id && $_G['USER']['ID'] != 1 && !InArray(getUserQX(), 'superman')) {
		$r = '无权操作';
		break;
	}
	if (md5($_POST['userpassword']) != $_G['USER']['PASSWORD'] && $_G['SET']['CHANGEUSERINFOVERIFY']) {
		$r = '当前用户密码验证错误';
		break;
	}
	//检测用户信息是否包含违禁词
	$wjcs = $_G['SET']['BANREGWORDS'];
	if ($wjcs) {
		$wjcs = explode(',', $wjcs);
		foreach ($wjcs as $w) {
			if ($w) {
				if (strpos(str_replace(array("\n", "\r", "\r\n", "\t", " "), '', $sign), $w) !== FALSE || strpos(str_replace(array("\n", "\r", "\r\n", "\t", " "), '', $nickname), $w) !== FALSE) {
					$r = '昵称或签名包含违禁词，请修改后再保存';
					break 2;
				}
			}
		}
	}
	$userdata = $_G['TABLE']['USER'] -> getData($id);
	$userarray['id'] = $id;
	$userarray['nickname'] = $nickname;
	$userarray['sex'] = $sex;
	$userarray['sign'] = $sign;
	$userarray['qq'] = $qq;
	$userarray['phone'] = $phone;
	$userarray['birthday'] = $birthday;
	$userarray['adress'] = Cstr(htmlspecialchars(strip_tags($_POST['adress']), ENT_QUOTES), '', FALSE, 1, 999);
	if ($userhead && InArray(getUserQX($id), 'uploadhead')) {
		file_put_contents("{$_G['SYSTEM']['PATH']}/userhead/{$id}.png", base64_decode($userhead));
	}
	if ($password) {
		$userarray['password'] = md5($password);
	}
	$userarray['data'] = JsonData($userdata['data'], 'privacysettings', $data_privacysettings);
	if ($_G['TABLE']['USER'] -> newData($userarray)) {
		if ($_G['GET']['RETURN'] == 'json') {
			exit(json_encode(array('state' => 'ok', 'msg' => '资料更新成功')));
		} else {
			PkPopup('{
				content:"资料更新成功",
				icon:2,
				hideclose:true,
				shade:true,
				submit:function(){
					location.href="index.php?c=center";
				}
			}');
		}
	} else {
		$r = '出错：' . mysql_error();
		break;
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
} else {
	if ($_G['GET']['RETURN'] == 'json') {
		exit(json_encode(array('state' => 'ok', 'msg' => '保存成功')));
	}
}
