<?php
if (!defined('puyuetian'))
	exit('403');

//云服务js嵌入
$_G['SET']['EMBED_FOOT'] .= template('hadskycloudserver:cloudserver', TRUE);

//用qq号登录
if (!$_G['USER']['ID'] && $_SESSION['APP_HADSKYCLOUDSERVER_QQLOGIN_OPENID']) {
	if ($_G['SET']['APP_HADSKYCLOUDSERVER_QQLOGIN_OPENREG']) {
		$_G['SET']['OPENREG'] = 1;
	}
	$regarray['qqopenid'] = $_SESSION['APP_HADSKYCLOUDSERVER_QQLOGIN_OPENID'];
	$_G['TEMP']['REGNICKNAME'] = $_SESSION['APP_HADSKYCLOUDSERVER_QQLOGIN_NICKNAME'];
	if (InArray('reg,savereg', $_G['GET']['C']) && $_G['TABLE']['USER'] -> getData(array('qqopenid' => $regarray['qqopenid']))) {
		$_SESSION['APP_HADSKYCLOUDSERVER_QQLOGIN_OPENID'] = '';
		ExitGourl('index.php?c=reg');
	}

}

//用微博号登录
if (!$_G['USER']['ID'] && $_SESSION['APP_HADSKYCLOUDSERVER_WEIBOLOGIN_UID']) {
	if ($_G['SET']['APP_HADSKYCLOUDSERVER_WEIBOLOGIN_OPENREG']) {
		$_G['SET']['OPENREG'] = 1;
	}
	$regarray['weibo_uid'] = $_SESSION['APP_HADSKYCLOUDSERVER_WEIBOLOGIN_UID'];
	$_G['TEMP']['REGNICKNAME'] = 'weibo_' . $regarray['weibo_uid'];
	if (InArray('reg,savereg', $_G['GET']['C']) && $_G['TABLE']['USER'] -> getData(array('weibo_uid' => $regarray['weibo_uid']))) {
		$_SESSION['APP_HADSKYCLOUDSERVER_WEIBOLOGIN_UID'] = '';
		ExitGourl('index.php?c=reg');
	}
}

//用百度号登录
if (!$_G['USER']['ID'] && $_SESSION['APP_HADSKYCLOUDSERVER_BAIDULOGIN_USERID']) {
	if ($_G['SET']['APP_HADSKYCLOUDSERVER_BAIDULOGIN_OPENREG']) {
		$_G['SET']['OPENREG'] = 1;
	}
	$regarray['baidu_userid'] = $_SESSION['APP_HADSKYCLOUDSERVER_BAIDULOGIN_USERID'];
	$_G['TEMP']['REGNICKNAME'] = 'baidu_' . $regarray['baidu_userid'];
	if (InArray('reg,savereg', $_G['GET']['C']) && $_G['TABLE']['USER'] -> getData(array('baidu_userid' => $regarray['baidu_userid']))) {
		$_SESSION['APP_HADSKYCLOUDSERVER_BAIDULOGIN_USERID'] = '';
		ExitGourl('index.php?c=reg');
	}
}

//用微信号登录
if (!$_G['USER']['ID'] && $_SESSION['APP_HADSKYCLOUDSERVER_WEIXIN_OPENID']) {
	if ($_G['SET']['APP_HADSKYCLOUDSERVER_WEIXINLOGIN_OPENREG']) {
		$_G['SET']['OPENREG'] = 1;
	}
	$regarray['weixin_openids'] = "[{$_SESSION['APP_HADSKYCLOUDSERVER_WEIXIN_OPENID']}]";
	$_G['TEMP']['REGNICKNAME'] = 'wx_' . CreateRandomString(7);
	if (InArray('reg,savereg', $_G['GET']['C']) && $_G['TABLE']['USER'] -> getData(array('weixin_openids' => $regarray['weixin_openids']))) {
		$_SESSION['APP_HADSKYCLOUDSERVER_WEIXIN_OPENID'] = '';
		ExitGourl('index.php?c=reg');
	}
}

//天豆兑换数量前端化
$_G['SET']['EMBED_HEADMARKS'] .= "
<script>
var HADSKY_VERSION='" . HADSKY_VERSION . "';
var \$app_hadskycloudserver_tiandouduihuanshu=parseInt('{$_G['SET']['APP_HADSKYCLOUDSERVER_TIANDOUDUIHUANSHU']}')||0;
var \$app_hadskycloudserver_tiandouname='{$_G['SET']['TIANDOUNAME']}';
</script>
";

//云短信嵌入
//添加修改手机按钮
if ($_G['SET']['APP_HADSKYCLOUDSERVER_SMS_OPEN']) {
	if ($_G['GET']['C'] == 'user' && $_G['USER']['ID'] && ($_G['USER']['ID'] == $_G['GET']['ID'] || !$_G['GET']['ID']) && $_G['USER']['PHONE']) {
		$_G['SET']['EMBED_FOOT'] .= '<script>$("form[name=form_user] input[name=phone]").parent().addClass("pk-padding-top-5 pk-padding-bottom-5").html(\'' . $_G['USER']['PHONE'] . '&nbsp;<a target="_blank" class="pk-text-primary pk-hover-underline" href="index.php?c=app&a=hadskycloudserver:index&s=sms_changephone">修改</a>\')</script>';
	}

	//添加登陆注册及找回密码按钮
	if ($_G['GET']['C'] == 'login') {
		$_G['SET']['EMBED_FOOT'] .= '<script>$(function(){$("form[name=form_login]").append(\'<div class="pk-row pk-padding-15 pk-text-center"><div class="pk-row pk-padding-15 pk-text-center"><div class="pk-padding-bottom-5"><a class="pk-btn pk-btn-secondary" href="index.php?c=app&a=hadskycloudserver:index&s=sms_login">&nbsp;&nbsp;<span class=" fa fa-fw fa-phone">&nbsp;</span>用手机号登录账号&nbsp;&nbsp;</a></div><div class="pk-padding-bottom-5"><a class="pk-btn pk-btn-success" href="index.php?c=app&a=hadskycloudserver:index&s=sms_reg">&nbsp;&nbsp;<span class=" fa fa-fw fa-phone">&nbsp;</span>用手机号注册账号&nbsp;&nbsp;</a></div><div><a target="_blank" class="pk-btn pk-btn-danger" href="index.php?c=app&a=hadskycloudserver:index&s=sms_forgetpassword">&nbsp;&nbsp;<span class=" fa fa-fw fa-phone">&nbsp;</span>用手机号找回密码&nbsp;&nbsp;</a></div></div>\')})</script>';
	}

	//防止用户自行修改手机号
	if ($_G['GET']['C'] == 'saveuser' && $_G['USER']['ID'] == $_POST['id'] && $_G['USER']['PHONE']) {
		$_POST['phone'] = $_G['USER']['PHONE'];
	}

	//强制注册
	if ($_G['SET']['APP_PUYUETIAN_SMS_MUSTREG'] && ($_G['GET']['C'] == 'reg' || $_G['GET']['C'] == 'savereg')) {
		ExitGourl('index.php?c=app&a=hadskycloudserver:index&s=sms_reg');
	}
}
