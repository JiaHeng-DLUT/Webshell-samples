<?php
if (!defined('puyuetian'))
	exit('403');

$_G['CACHE']['CREATE'] = FALSE;
if (Cnum(HADSKY_CACHELIFE) && !Cnum($_SESSION['HS_UID']) && (InArray(HADSKY_CACHEPAGES, $_G['GET']['C']) || !$_G['GET']['C'])) {
	//当前页面是否被缓存
	$_G['CACHE']['FILE'] = $_G['SYSTEM']['PATH'] . '/cache/' . md5($_G['SYSTEM']['LOCATION'] . isphonecome()) . '.html';
	if (file_exists($_G['CACHE']['FILE'])) {
		if (time() - filemtime($_G['CACHE']['FILE']) < Cnum(HADSKY_CACHELIFE)) {
			//缓存文件未过期
			exit(file_get_contents($_G['CACHE']['FILE']) . "\n<!-- Cache File -->");
		} else {
			//过期
			$_G['CACHE']['CREATE'] = TRUE;
		}
	} else {
		$_G['CACHE']['CREATE'] = TRUE;
	}
}
