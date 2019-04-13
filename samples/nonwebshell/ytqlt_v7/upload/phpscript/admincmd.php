<?php
if (!defined('puyuetian'))
	exit('403');

if (!$_G['USER']['ID']) {
	if ($_G['GET']['JSON']) {
		ExitJson('请登录');
	} else {
		exit('please login');
	}
}

$table = $_G['GET']['TABLE'];
$field = $_G['GET']['FIELD'];
$id = Cnum($_G['GET']['ID'], FALSE, TRUE, 1);
$value = $_GET['value'];

if (!InArray('read,reply', $table) || !InArray('top,high,sortid,locked', $field) || !$id) {
	if ($_G['GET']['JSON']) {
		ExitJson('参数非法');
	} else {
		exit('illegal parameter');
	}
}

$data = $_G['TABLE'][strtoupper($table)] -> getData($id);

if (!$data) {
	if ($_G['GET']['JSON']) {
		ExitJson('不存在的id');
	} else {
		exit('Does not exist ID');
	}
}

if ($table == 'reply') {
	$sortid = $_G['TABLE']['READ'] -> getData($data['rid']);
	$sortid = $sortid['sortid'];
}
$sortid = $data['sortid'];
$bkdata = $_G['TABLE']['READSORT'] -> getData($sortid);
$bkadmin = FALSE;
if (InArray($bkdata['adminuids'], $_G['USER']['ID'])) {
	$bkadmin = TRUE;
}

if ($_G['USER']['ID'] == 1 || InArray(getUserQX(), 'superman') || ($table == 'reply' && $field == 'top' && ($_G['USER']['ID'] == $data['uid'] || InArray(getUserQX(), 'admin')))) {
	$_G['TABLE'][strtoupper($table)] -> newData(array('id' => $id, $field => $value));
	if ($_G['GET']['JSON']) {
		ExitJson('操作成功', TRUE);
	} else {
		exit('ok');
	}
} else {
	if ($_G['GET']['JSON']) {
		ExitJson('无权操作');
	} else {
		exit('Unauthorized operation');
	}
}
