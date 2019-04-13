<?php
if (!defined('puyuetian'))
	exit('403');

$type = $_G['GET']['TYPE'];
$page = Cnum($_G['GET']['PAGE'], 1, TRUE, 1);
$tsetpath = 'superadmin:appstore';
$_G['TEMP']['DATA'] = array();
//==========================获取应用======================================
$r = apiData('getapplist&type=' . $type . '&page=' . $page);
if ($r['state'] == 'ok') {
	$datas = $r['datas']['data'];
	foreach ($datas as $key => $data) {
		$lj = $_G['SYSTEM']['PATH'] . $type . '/' . $data['dir'] . '/config.json';
		if (file_exists($lj)) {
			$datas[$key]['downloaded'] = TRUE;
		} else {
			$datas[$key]['downloaded'] = FALSE;
		}
	}
} elseif ($r['state'] == 'no') {
	$datas = $r['datas']['msg'] ? $r['datas']['msg'] : '未知错误';
	$r['datas']['pagecount'] = 1;
} else {
	$r['state'] = 'no';
	$datas = '数据获取失败';
	$r['datas']['pagecount'] = 1;
}

$_G['TEMP']['CLOUD'] = htmlspecialchars(json_encode(array('data' => $datas, 'pagecount' => $r['datas']['pagecount'], 'state' => $r['state'])), ENT_QUOTES);
//$_G['TEMP']['LOCAL'] = htmlspecialchars(json_encode(getAT($type)), ENT_QUOTES);

$contenthtml = template($tsetpath, TRUE);
