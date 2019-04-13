<?php
if (!defined('puyuetian'))
	exit('Not Found puyuetian!Please contact QQ632827168');

//get获取所要访问的文件，phpscript文件夹内
if (!$_G['GET']['C']) {
	$_G['GET']['C'] = Cstr($_G['SET']['DEFAULTPAGE'], 'main', TRUE, 1, 255);
}

$_G['SYSTEM']['SCRIPTPATH'] = "{$_G['SYSTEM']['PATH']}/phpscript/{$_G['GET']['C']}.php";
if (file_exists($_G['SYSTEM']['SCRIPTPATH'])) {
	//防止CSRF攻击
	if ($_G['SET']['CHKCSRFPAGES'] && InArray($_G['SET']['CHKCSRFPAGES'], strtolower($_G['GET']['C']))) {
		if ($_G['CHKCSRFVAL'] != $_POST['chkcsrfval'] && $_G['CHKCSRFVAL'] != $_GET['chkcsrfval'] && $_G['SET']['CHKCSRF']) {
			//exit('Has been blocked by HadSky security mechanism, the reason: suspected CSRF attacks');
			$_G['HTMLCODE']['TIP'] = '疑似CSRF攻击的操作，已被系统拦截！';
			$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
		} else {
			require $_G['SYSTEM']['SCRIPTPATH'];
		}
	} else {
		require $_G['SYSTEM']['SCRIPTPATH'];
	}
} else {
	RunError("\"{$_G['SYSTEM']['SCRIPTPATH']}\" doesn't exist");
}
