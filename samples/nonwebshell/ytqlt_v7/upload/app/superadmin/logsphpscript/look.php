<?php
if (!defined('puyuetian'))
	exit('403');

$type = $_G['GET']['TYPE'];
$date = Cstr($_GET['date'], FALSE, $_G['STRING']['NUMERICAL'] . '-', 10, 10);
$ip = StringSafeCheck($_GET['ip']) ? $_GET['ip'] : FALSE;

if ($type == 'access') {
	$path = $_G['SYSTEM']['PATH'] . 'logs/access/' . $date . '/' . $ip . '.csv';
} elseif ($type == 'attack') {
	$path = $_G['SYSTEM']['PATH'] . 'logs/attack/' . $date . '.csv';
} else {
	exit('type 500');
}

if (!file_exists($path)) {
	exit('not found file');
}

if ($_G['GET']['DOWNLOAD'] == 'yes') {
	file_download($path, $date . ($ip ? '_' . $ip : '') . '_' . $type);
}
$content = iconv('utf-8', 'gb2312//IGNORE', "建议下载该文件并用Excel查看，下载地址：{$_G['SYSTEM']['LOCATION']}&download=yes\n\n") . file_get_contents($path);

header('Content-Type:text/plain;charset=gb2312');
exit($content);
