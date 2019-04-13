<?php
if (!defined('puyuetian'))
	exit('403');

$id = Cnum($_G['GET']['ID'], 0, TRUE, 0);
$sortid = Cnum($_G['GET']['SORTID'], 0, TRUE, 0);
$type = $_G['GET']['TYPE'];
$_G['FORUMDATA'] = $_G['TABLE']['READSORT'] -> getDatas(0, 0, 'where `show`=1 order by `rank` asc');
$_G['FORUMDATAJSON'] = json_encode($_G['FORUMDATA']);

if (!InArray('read,reply', $type)) {
	PkPopup('{
		content:"您的阅读权限太低或您的用户组不被允许",
		icon:2,
		hideclose:true,
		shade:true
	}');
}
if ($id) {
	//标题
	$_G['SET']['WEBTITLE'] = '编辑帖子';
	//检测版主
	if ($type == 'reply') {
		$_ls = $_G['TABLE']['REPLY'] -> getData($id);
		$_ls = $_ls['rid'];
		$sortid = $_G['TABLE']['READ'] -> getData($_ls);
		$sortid = $sortid['sortid'];
	} else {
		$sortid = $_G['TABLE']['READ'] -> getData($id);
		$sortid = $sortid['sortid'];
	}
	$bkdata = $_G['TABLE']['READSORT'] -> getData($sortid);
	$bkadmin = FALSE;
	if (InArray($bkdata['adminuids'], $_G['USER']['ID'])) {
		$bkadmin = TRUE;
	}
	//=============================编辑帖子=============================
	if (!InArray(getUserQX(), 'edit' . $type)) {
		PkPopup('{
			content:"您所在用户组或自身无权编辑帖子",
			icon:2,
			hideclose:true,
			shade:true
		}');
	}
	$rrdata = $_G['TABLE'][strtoupper($type)] -> getData(array('id' => $id, 'del' => 0));
	if (!$rrdata) {
		PkPopup('{
			content:"不存在或已被删除的帖子",
			icon:2,
			hideclose:true,
			shade:true
		}');
	}
	if (($rrdata['uid'] != $_G['USER']['ID']) && !InArray(getUserQX(), 'admin') && !$bkadmin) {
		PkPopup('{
			content:"您无权管理该帖",
			icon:2,
			hideclose:true,
			shade:true
		}');
	}
	if ($type == 'read') {
		$rrdata['title'] = htmlspecialchars($rrdata['title'], ENT_QUOTES);
		$sortid = $rrdata['sortid'];
		$label = $rrdata['label'];
	} else {
		$readdata = $_G['TABLE']['READ'] -> getData($rrdata['rid']);
		$rrdata['title'] = htmlspecialchars('回复主题：' . $readdata['title'], ENT_QUOTES);
	}
	$rrdata['content'] = htmlspecialchars($rrdata['content'], ENT_QUOTES);
} else {
	//标题
	$_G['SET']['WEBTITLE'] = '发布帖子';
	//新发布前奏
	if (!InArray(getUserQX(), 'post' . $type)) {
		if ($_G['USER']['ID']) {
			PkPopup('{
				content:"您所在用户组或自身无权发帖",
				icon:2,
				hideclose:true,
				shade:true
			}');
		}
		ExitGourl('index.php?c=login&referer=' . urlencode("index.php?c=edit&sortid={$sortid}&type={$type}&id={$id}"));
	}
}
$_G['HTMLCODE']['OUTPUT'] .= template('edit', TRUE);
