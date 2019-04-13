<?php
if (!defined('puyuetian'))
	exit('403');

$readsorts = $_G['TABLE']['READSORT'] -> getDatas(0, 0);
foreach ($readsorts as $readsort) {
	if ($_G['GET']['T'] == 'edit' && $_G['GET']['ID'] == $readsort['id']) {
		continue;
	}
	$forumlist .= "<option value='{$readsort['id']}'>" . htmlspecialchars($readsort['title']) . " ID:{$readsort['id']}</option>";
}

if (!$_G['GET']['T']) {
	$_G['GET']['T'] = 'edit';
}
if ($_G['GET']['T'] == 'edit') {
	if (Cnum($_G['GET']['ID']))
		$forumdata = HSCSArray($_G['TABLE']['READSORT'] -> getData($_G['GET']['ID']));
	$contenthtml = template('superadmin:forum-edit', TRUE);
} else {
	$contenthtml = template('superadmin:forum-' . $_G['GET']['T'], TRUE);
}
