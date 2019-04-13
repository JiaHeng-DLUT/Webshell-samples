<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['USER']['ID'] != 1) {
	PkPopup('{title:"提示",content:"访问及日志数据仅创始人可以查看",icon:0,close:function(){location.href="index.php"},hideclose:true,shade:true}');
}

$_G['SET']['WEBTITLE'] = '网站访问日志查看';
$_G['TEMPLATE']['HEAD'] = 'null';
$_G['TEMPLATE']['BODY'] = 'superadmin:logs-main';
$_G['TEMPLATE']['FOOT'] = 'null';

LoadAppScript($_G['GET']['S'], 'access', 'logsphpscript');

$_G['HTMLCODE']['OUTPUT'] = template('superadmin:logs-' . Cstr($_G['GET']['S'], 'access', TRUE, 1, 255), TRUE);
