<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['GET']['TYPE'] == 'out') {
	UserLogout(TRUE);
	setcookie('USERNAME', '', time() - 3600);
	setcookie('PASSWORD', '', time() - 3600);
	setcookie('SESSION_TOKEN', '', time() - 3600);
	if ($_G['GET']['JSON']) {
		ExitJson('退出成功', true);
	}
	ExitGourl('index.php?from=loginout');
}

if ($_G['USER']['ID']) {
	PkPopup('{
		content:"您已登录",
		icon:2,
		hideclose:true,
		shade:true,
		submit:function(){
			location.href="index.php?c=center"
		}
	}');
}
$_G['SET']['WEBTITLE'] = '用户登录 - ' . $_G['SET']['WEBADDEDWORDS'];
$_G['HTMLCODE']['OUTPUT'] .= template('login', TRUE);
