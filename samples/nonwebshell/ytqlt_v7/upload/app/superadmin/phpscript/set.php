<?php
if (!defined('puyuetian'))
	exit('403');

$tpath = "{$_G['SYSTEM']['PATH']}/template/";
$templatelist = '';
$scan = scandir($tpath);
foreach ($scan as $name) {
	if ($name && $name != '.' && $name != '..' && filetype($tpath . $name) == 'dir') {
		if (file_exists($tpath . $name . '/config.xml')) {
			$xml = simplexml_load_file($tpath . $name . '/config.xml');
			$tname = $xml -> name;
			$templatelist .= "<option value='{$name}'>{$tname}($name)</option>";
		}
	}
}

$_G['TEMP']['UGS'] = '';
$ugds = $_G['TABLE']['USERGROUP'] -> getDatas(0, 0);
foreach ($ugds as $value88) {
	$_G['TEMP']['UGS'] .= '<option value="' . $value88['id'] . '">' . htmlspecialchars($value88['usergroupname']) . '</option>';
}
if ($_G['GET']['T'])
	$contenthtml = template('superadmin:set-' . $_G['GET']['T'], TRUE);
else
	$contenthtml = template('superadmin:set-base', TRUE);
