<?php
if (!defined('puyuetian'))
	exit('403');

$type = $_G['GET']['TYPE'];
$tsetpath = 'superadmin:app';
//==========================安装应用======================================
if ($_G['GET']['ML'] == 'install') {
	$r = installAT($type, $_G['GET']['T']);
	if ($r !== TRUE) {
		ExitJson($r);
	}
	ExitJson('操作成功', TRUE);
	//==========================卸载应用======================================
} elseif ($_G['GET']['ML'] == 'uninstall') {
	$r = uninstallAT($type, $_G['GET']['T']);
	if ($r !== TRUE) {
		ExitJson($r);
	}
	ExitJson('操作成功', TRUE);
	//==========================导出模板数据======================================
} elseif ($_G['GET']['ML'] == 'json') {
	$jsonarray = array();
	$perfix = $type . '_' . $_G['GET']['T'] . '_';
	foreach ($_G['SET'] as $key => $value) {
		if (substr($key, 0, strlen(strtoupper($perfix))) != strtoupper($perfix)) {
			continue;
		}
		$jsonarray[strtolower($key)] = $value;
	}
	header('Content-type:text/json');
	exit(json_encode($jsonarray));
	//==========================加载应用设置======================================
} elseif ($_G['GET']['ML'] == 'setting') {
	$tsetpath = "{$_G['SYSTEM']['PATH']}{$type}/{$_G['GET']['T']}/setting.hst";
} else {
	//==========================获取本地插件信息======================================
	$_G['TEMP']['DATA'] = htmlspecialchars(json_encode(getAT($type)), ENT_QUOTES);
}

$contenthtml = template($tsetpath, TRUE);
