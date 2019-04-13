<?php
if (!defined('puyuetian'))
	exit('Not Found puyuetian!Please contact QQ632827168');

$array = array();
$id = Cnum($_G['GET']['ID'], FALSE, TRUE, 1);
$type = strtoupper($_G['GET']['TYPE']);
$r = FALSE;
if (($type == 'READ' || $type == 'REPLY') && $id) {
	if (!isset($_COOKIE[$type . '_ZANNUM_' . $id])) {
		setcookie($type . '_ZANNUM_' . $id, 'Yes', time() + 3600);
		$RA = $_G['TABLE'][$type] -> getData($id);
		if ($RA) {
			$zannum = Cnum($RA['zannum']);
			$array['id'] = $id;
			$array['zannum'] = $zannum + 1;
			$_G['TABLE'][$type] -> newData($array);
			$r = TRUE;
		}
	}
}
if ($_G['GET']['JSON']) {
	ExitJson('操作完成', $r);
} else {
	exit(($r ? 'True' : 'False'));
}
