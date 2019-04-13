<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['TEMPLATE']['BODY'] == 'tip') {
	$_G['HTMLCODE']['TIPJS'] = str_replace(array("\r\n", "\r", "\n", PHP_EOL), ';', $_G['HTMLCODE']['TIPJS']);
	$_G['HTMLCODE']['TIPJS'] = str_replace('"', '\\"', $_G['HTMLCODE']['TIPJS']);
}
$_G['TEMPLATE']['BODY'] = 'tip';
