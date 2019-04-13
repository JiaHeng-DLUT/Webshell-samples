<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['GET']['CLEARCACHE']) {
	$path = $_G['SYSTEM']['PATH'] . 'app/superadmin/cache/';
	$files = scandir($path);
	foreach ($files as $filename) {
		if (filetype($path . $filename) == 'file' && end(explode('.', $filename)) == 'hsc') {
			unlink($path . $filename);
		}
	}
	ExitJson('清理完成', TRUE);
}

$url = $_GET['url'];
if (!$url) {
	ExitJson('请求非法');
}
$fn = $_G['SYSTEM']['PATH'] . 'app/superadmin/cache/' . md5($url . $_G['SET']['KEY'] . date('Ymd')) . '.hsc';

if (!$_G['GET']['NOCACHE'] && file_exists($fn)) {
	echo base64_decode(file_get_contents($fn));
	exit();
}

if (filter_var($url, FILTER_VALIDATE_URL)) {
	$apidata = GetPostData($url, '', 10);
	echo $apidata;
} else {
	$apidata = json_encode(apiData($url));
	header('Content-type:application/json');
	echo $apidata;
}

file_put_contents($fn, base64_encode($apidata));
exit();
