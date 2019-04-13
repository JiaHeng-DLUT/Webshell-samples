<?php
if (!defined('puyuetian'))
	exit('Not Found puyuetian!Please contact QQ632827168');

$id = Cnum($_G['GET']['ID'], 0, TRUE, 0);

if (!chkReadSortQx($id, 'readlevel')) {
	PkPopup('{
		content:"您的阅读权限太低或您的用户组不被允许",
		icon:2,
		hideclose:true,
		shade:true
	}');
}
$template = template('forum-2', TRUE, FALSE, FALSE);
if ($_G['SET']['FORUMSHOWIDS'] && !$id) {
	$sql = '';
	$bkids = explode(',', $_G['SET']['FORUMSHOWIDS']);
	foreach ($bkids as $bkid) {
		if (!Cnum($bkid, FALSE, TRUE, 1)) {
			continue;
		}
		$sql .= "`id`='{$bkid}' or ";
	}
	if ($sql) {
		$sql = 'where (' . substr($sql, 0, strlen($sql) - 4) . ') order by `rank`';
	} else {
		$sql = 'where `id`=0';
	}
} else {
	$sql = "where `pid`={$id} and `show`=1 order by `rank`";
}
$forumdatas = $_G['TABLE']['READSORT'] -> getDatas(0, 0, $sql);
if ($forumdatas) {
	foreach ($forumdatas as $forumdata) {
		$forumhtml .= template('forum-2', TRUE, $template);
	}
}

if ($id) {
	$pdata = $_G['TABLE']['READSORT'] -> getData($id);
	$_G['SET']['WEBTITLE'] = strip_tags($pdata['title']) . $_G['SET']['WEBADDEDWORDS'];
	if ($pdata['webkeywords']) {
		$_G['SET']['WEBDESCRIPTION'] = $pdata['webkeywords'];
	} else {
		$_G['SET']['WEBDESCRIPTION'] = strip_tags($pdata['title']);
	}
	if ($pdata['webdescription']) {
		$_G['SET']['WEBDESCRIPTION'] = $pdata['webdescription'];
	} else {
		if ($pdata['content']) {
			$_G['SET']['WEBDESCRIPTION'] = strip_tags($pdata['content']) . '，' . $_G['SET']['WEBADDEDWORDS'];
		}
	}
} else {
	$_G['SET']['WEBTITLE'] = '版块列表 - ' . $_G['SET']['WEBADDEDWORDS'];
}

$_G['HTMLCODE']['OUTPUT'] .= template('forum-1', TRUE) . $forumhtml . template('forum-3', TRUE);
