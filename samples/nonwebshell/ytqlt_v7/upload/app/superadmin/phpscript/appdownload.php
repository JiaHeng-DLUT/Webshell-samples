<?php
if (!defined('puyuetian'))
	exit('403');

if (!$_G['GET']['DIR']) {
	ExitJson('缺少参数');
}

if (!class_exists('ZipArchive')) {
	ExitJson('PHP不存在ZIP扩展库，请先下载ZIP扩展。');
}

$r = apiData('appdown&dir=' . $_G['GET']['DIR']);
if ($r['state'] != 'ok') {
	ExitJson($r['datas']['msg']);
}

if (!$r['datas']['content']) {
	ExitJson('数据传输失败');
}

$appname = md5($_G['GET']['DIR']);
$up = $_G['SYSTEM']['PATH'] . "app/superadmin/appzip/{$appname}.zip";
$base64 = $r['datas']['content'];
$md5 = $r['datas']['md5'];

if ($md5 != md5($base64)) {
	ExitJson('文件校验失败，请重新下载');
}

$r = file_put_contents($up, base64_decode($base64));
if (!$r) {
	ExitJson('写入失败，请保证网站目录下文件具有被写入权限');
}

$zip = new ZipArchive;
$res = $zip -> open($up);
if ($res !== TRUE) {
	ExitJson('解压失败：' . $res);
}
$zip -> extractTo($_G['SYSTEM']['PATH']);
$zip -> close();
unlink($up);

$lj = $_G['SYSTEM']['PATH'] . $_G['GET']['TYPE'] . '/' . $_G['GET']['DIR'] . '/';
if (file_exists($lj . 'uninstall.json')) {
	if (file_exists($lj . 'install.json')) {
		unlink($lj . 'install.json');
	}
}

ExitJson('下载成功', TRUE);
