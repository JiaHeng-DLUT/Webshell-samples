<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['GET']['DO'] != 'update') {
	ExitJson('请求参数非法');
}

if (!class_exists('ZipArchive')) {
	ExitJson('PHP不存在ZIP扩展库，请先下载ZIP扩展。');
}

$r = apiData("update&nowversion={$nowversion}");
if ($r['state'] != 'ok') {
	ExitJson($r['datas']['msg']);
}

$name = md5($r['datas']['newversion']);
$up = $_G['SYSTEM']['PATH'] . "app/superadmin/updatezip/{$name}.zip";
$base64 = $r['datas']['content'];
$md5 = $r['datas']['md5'];

if ($md5 != md5($base64)) {
	ExitJson('文件校验失败，请重新下载');
}

$r = file_put_contents($up, base64_decode($r['datas']['content']));
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

ExitJson('更新成功', TRUE);
