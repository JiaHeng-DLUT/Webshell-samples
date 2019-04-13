<?php
if (!defined('puyuetian'))
	exit('403');

$sitekey2 = md5(md5($_G['SYSTEM']['DOMAIN']) . md5($_G['SET']['APP_HADSKYCLOUDSERVER_SITEKEY']) . md5($_GET['createtime']) . md5($_GET['timeout']));
//5.2.1版本后的新安全机制
$sitekey3 = md5(md5($_G['SYSTEM']['DOMAIN']) . md5($_G['SET']['APP_HADSKYCLOUDSERVER_SITEKEY']) . md5($_GET['createtime']) . md5($_GET['timeout']) . md5($_G['GET']['S']) . md5($_GET['safernd']));
if (Cnum($_GET['createtime']) + Cnum($_GET['timeout']) > time() && $_GET['sitekey3'] == $sitekey3) {
	$qq_openid = $_GET['qq_openid'];
	$qq_userinfo = json_decode($_GET['qq_userinfo'], TRUE);
	if (!$_G['USER']['ID']) {
		//用户登录或注册
		$userdata = UserLogin(array('qqopenid' => $qq_openid), FALSE);
		if ($userdata) {
			//存入登录信息
			header('Location:../../index.php');
			exit();
		} else {
			//用户注册
			$_SESSION['APP_HADSKYCLOUDSERVER_QQLOGIN_OPENID'] = $qq_openid;
			$_SESSION['APP_HADSKYCLOUDSERVER_QQLOGIN_NICKNAME'] = $qq_userinfo['nickname'];
			header('Location:../../index.php?c=reg');
			exit();
		}
	} else {
		//用户绑定
		$array['id'] = $_G['USER']['ID'];
		$array['qqopenid'] = $qq_openid;
		$_G['TABLE']['USER'] -> newData($array);
		if ($_G['USER']['QQOPENID']) {
			$ht = '恭喜，更换QQ号绑定成功！';
		} else {
			$ht = '恭喜，绑定QQ号成功！';
		}
		$_G['HTMLCODE']['TIPJS'] = 'location.href="index.php"';
		$_G['HTMLCODE']['TIP'] = $ht;
		$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
	}
} else {
	$_G['HTMLCODE']['TIPJS'] = 'location.href="index.php?c=login"';
	$_G['HTMLCODE']['TIP'] = '登录校验码超时或错误';
	$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
}
