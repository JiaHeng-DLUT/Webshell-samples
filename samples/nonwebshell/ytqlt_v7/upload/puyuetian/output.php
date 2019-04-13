<?php
if (!defined('puyuetian'))
	exit('403');

//=========================模板初始化========================
$_G['HTMLCODE']['MAIN'] .= template($_G['TEMPLATE']['HEAD'], TRUE);
$_G['HTMLCODE']['MAIN'] .= template($_G['TEMPLATE']['BODY'], TRUE);
$_G['HTMLCODE']['MAIN'] .= template($_G['TEMPLATE']['FOOT'], TRUE);

$_G['HTML'] = template($_G['TEMPLATE']['MAIN'], TRUE);

//生成缓存文件
if (($_G['CACHE']['CREATE'] || ($_G['GET']['CACHE'] == 'refresh' && InArray(HADSKY_CACHEPAGES, $_G['GET']['C']) && HADSKY_CACHEREFRESH)) && HADSKY_CACHELIFE && !$_G['USER']['ID']) {
	file_put_contents($_G['CACHE']['FILE'], $_G['HTML']);
}
