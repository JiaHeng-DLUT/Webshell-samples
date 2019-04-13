<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['GET']['SUBMIT'] == 'yes') {
	if (!$_GET['ptxt']) {
		exit(json_encode(array('state' => 'no', 'msg' => '新文字版权不能为空')));
	}
	$_jd = file_get_contents("http://www.hadsky.com/index.php?c=app&a=zhanzhang:index2&s=deletepowered&yuncheckcode={$YUNCHECKCODE}&domain={$_G['SYSTEM']['DOMAIN']}&type=new&rnd={$_G['RND']}");
	$_jd = json_decode($_jd, TRUE);
	if (!$_jd) {
		exit(json_encode(array('state' => 'no', 'msg' => '连接云服器出错')));
	}
	if ($_jd['state'] != 'ok') {
		if ($_jd['msg'] == 404) {
			$_jd['msg'] = '请先绑定网站再操作<br>后台 - 首页 - 程序信息 - 站长信息 -认领网站';
		}
		exit(json_encode(array('state' => 'no', 'msg' => $_jd['msg'])));
	}
	foreach ($_jd['data'] as $value) {
		$fp = $_G['SYSTEM']['PATH'] . $value['filepath'];
		$ot = $value['oldtxt'];
		$nt = str_replace('[NEW_PTXT]', $_GET['ptxt'], $value['newtxt']);
		if (file_exists($fp)) {
			file_put_contents($fp, str_replace($ot, $nt, file_get_contents($fp)));
		}
	}
	exit(json_encode(array('state' => 'ok', 'msg' => '除去成功')));
}
