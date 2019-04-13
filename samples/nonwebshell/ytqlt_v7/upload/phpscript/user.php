<?php
if (!defined('puyuetian'))
	exit('403');

$id = Cnum($_G['GET']['ID'], $_G['USER']['ID'], TRUE, 0);
$page = Cnum($_G['GET']['PAGE'], 1, TRUE, 1);
if ($_G['SET']['OLDUSERCENTERTONEWUSERCENTER']) {
	ExitGourl('index.php?c=center&uid=' . $id . '&page=' . $page);
}
$chkr = false;
for ($rf = 0; $rf < 1; $rf++) {
	if (!$id) {
		if (!$_G['USER']['ID']) {
			header('Location:index.php?c=login&referer=' . urlencode($_G['SYSTEM']['LOCATION']));
			exit();
		}
		$chkr = '非法的ID参数！';
		break;
	}
	if (!InArray(getUserQX(), 'lookuser') && $id != $_G['USER']['ID']) {
		$chkr = '您无权查看用户资料！';
		break;
	}

	$userdata = $_G['TABLE']['USER'] -> getData($id);

	if (!$userdata) {
		$chkr = '未找到的用户！';
		break;
	}

	//用户组
	$usergroupdata = $_G['TABLE']['USERGROUP'] -> getData($userdata['groupid']);
	if (!$usergroupdata) {
		$usergroupdata['usergroupname'] = '逍遥法外（暂无用户组）';
	} else {
		$userdata['readlevel'] = $usergroupdata['readlevel'];
	}
	//隐私设置
	if (JsonData($userdata['data'], 'privacysettings') && $_G['USER']['ID'] != $userdata['id'] && $_G['USER']['ID'] != 1 && !InArray(getUserQX(), 'superman')) {
		$userdata['readlevel'] = $userdata['address'] = $userdata['birthday'] = $userdata['phone'] = $userdata['qq'] = $userdata['email'] = $userdata['tiandou'] = '保密';
	}
}
if ($chkr) {
	$_G['HTMLCODE']['TIP'] = $chkr;
	$_G['HTMLCODE']['TIPJS'] = 'location.href="index.php"';
	$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
} else {
	//seo优化
	$_G['SET']['WEBKEYWORDS'] = "{$userdata['nickname']}的个人信息,{$userdata['username']}";
	$_G['SET']['WEBDESCRIPTION'] = "{$userdata['nickname']}的个人信息，{$userdata['sign']}，{$_G['SET']['WEBADDEDWORDS']}";
	$_G['SET']['WEBTITLE'] = "{$userdata['nickname']}的个人信息" . ($page != 1 ? " - 第{$page}页" : '') . " - {$_G['SET']['WEBADDEDWORDS']}";
	$_G['HTMLCODE']['OUTPUT'] .= template('user', TRUE);
}
