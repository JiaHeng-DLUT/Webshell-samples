<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['USER']['ID']) {
	PkPopup('{
		content:"您已登录，无需注册",
		icon:2,
		hideclose:true,
		shade:true,
		submit:function(){
			location.href="index.php?c=center";
		}
	}');
}
$_G['SET']['WEBTITLE'] = '用户注册 - ' . $_G['SET']['WEBADDEDWORDS'];
if ($_G['SET']['OPENREG']) {
	$_G['HTMLCODE']['OUTPUT'] .= template('reg', TRUE);
} else {
	$_G['HTMLCODE']['TIP'] = $_G['SET']['CLOSEREGTIP'];
	$_G['HTMLCODE']['TIPJS'] = 'location.href="index.php"';
	$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
}
