<?php
if (!defined('puyuetian'))
	exit('403');

if ((!InArray($_G['USERGROUP']['QUANXIAN'], 'uploadfile') && $_G['USERGROUP']['ID']) || (!InArray($_G['USER']['QUANXIAN'], 'uploadfile') && !$_G['USERGROUP']['ID'])) {
	uploadexit('您无权上传文件');
}

if (!$_GET['url']) {
	ExitJson('url地址错误');
}

$uploadarray = array();
$uploadarray['target'] = 'remote';
$uploadarray['uid'] = $_G['USER']['ID'];
$uploadarray['datetime'] = date('YmdHis', time());
$uploadarray['rand'] = CreateRandomString(6);
$uploadarray['suffix'] = '远程文件';
$uploadarray['idcode'] = md5($uploadarray['uid'] . $uploadarray['datetime'] . $uploadarray['rand'] . $uploadarray['suffix']);
$uploadarray['jifen'] = $uploadarray['tiandou'] = $uploadarray['downloadcount'] = 0;
$uploadarray['name'] = '';
$uploadarray['uploadtime'] = time();
$uploadarray['url'] = $_GET['url'];
$_G['TABLE']['UPLOAD'] -> newData($uploadarray);
$id = $_G['TABLE']['UPLOAD'] -> getId(array('idcode' => $uploadarray['idcode'], 'uid' => $uploadarray['uid']));
ExitJson($id, true);
