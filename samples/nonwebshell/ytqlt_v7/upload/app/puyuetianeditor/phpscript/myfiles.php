<?php
if (!defined('puyuetian'))
	exit('403');

header("Content-Type:application/x-javascript");
$page = Cnum($_G['GET']['PAGE'], 1, TRUE, 1);
$snum = 10;
$r = array();
if ($_G['USER']['ID']) {
	$files = $_G['TABLE']['UPLOAD'] -> getDatas(($page - 1) * $snum, $snum, "where `uid`={$_G['USER']['ID']} order by `id` desc");
	$shows = 'id,name,datetime,target,suffix,url';
	foreach ($files as $key => $value) {
		if ($value['target'] != 'file') {
			$value['url'] = "uploadfiles/{$value['target']}s/{$_G['USER']['ID']}/" . substr($value['datetime'], 0, 8) . "/" . substr($value['datetime'], 8) . "_{$value['rand']}.{$value['suffix']}";
			$value['name'] = substr($value['datetime'], 8) . "_{$value['rand']}.{$value['suffix']}";
		}
		foreach ($value as $key2 => $value2) {
			if (!InArray($shows, $key2))
				unset($value[$key2]);
		}
		$r[$key] = $value;
	}
}
exit(json_encode($r));
