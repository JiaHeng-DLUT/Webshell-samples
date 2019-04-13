<?php
if (!defined('puyuetian'))
	exit('403');

$id = Cnum($_G['GET']['ID'], 0, TRUE, 1);
$page = Cnum($_G['GET']['PAGE'], 1, TRUE, 1);
$desc = Cnum($_G['GET']['DESC'], Cnum($_G['SET']['REPLYORDER'], 1, TRUE, 0, 1), TRUE, 0, 1);
$prenum = Cnum($_G['SET']['REPLYLISTNUM'], 10, TRUE, 1);
$spos = ($page - 1) * $prenum;
$template = template('read-2', TRUE, FALSE, FALSE);
$orderfield = $_G['GET']['ORDERFIELD'];
if ($orderfield == 'zannum') {
	$orderfield = 'zannum desc,id';
} else {
	$orderfield = 'id';
}

$readdata = $_G['TABLE']['READ'] -> getData(array('id' => $id, 'del' => 0));
$pagecount = $_G['TABLE']['REPLY'] -> getCount(array('rid' => $id, 'del' => 0));
$pagecount /= $prenum;
if (!is_int($pagecount)) {
	$pagecount = (int)$pagecount + 1;
}
if ($page > $pagecount) {
	$page = $pagecount;
}
if (!$readdata) {
	PkPopup('{
		content:"该主题已被删除或正在审核",
		icon:2,
		hideclose:true,
		shade:true
	}');
}

//各种检测
$chkr = FALSE;
if ((!InArray($_G['USERGROUP']['QUANXIAN'], 'lookread') && $_G['USERGROUP']['ID']) || (!InArray($_G['USER']['QUANXIAN'], 'lookread') && !$_G['USERGROUP']['ID'])) {
	$chkr = '您无权阅读文章';
}

//用户阅读权限的检测
if (!chkReadSortQx($readdata['sortid'], 'looklevel') || (($_G['USERGROUP']['ID'] && (Cnum($readdata['readlevel']) > Cnum($_G['USERGROUP']['READLEVEL']))) || (!$_G['USERGROUP']['ID'] && (Cnum($readdata['readlevel']) > Cnum($_G['USER']['READLEVEL'])))))
	$chkr = '您的阅读权限太低或您的用户组不被允许';

if (!isset($_SESSION['HS_LOOKREAD_' . $id])) {
	$_SESSION['HS_LOOKREAD_' . $id] = $readdata['looknum'];
	$_G['TABLE']['READ'] -> newData(array('id' => $id, 'looknum' => ($readdata['looknum'] + 1)));
}

//整片文章回复后查看的检测
if ($readdata['replyafterlook'] && $_G['USER']['ID'] != $readdata['uid'] && $_G['USER']['ID'] != 1) {
	if ($_G['USER']['ID']) {
		if (!$_G['TABLE']['REPLY'] -> getId(array('rid' => $readdata['id'], 'uid' => $_G['USER']['ID'], 'del' => 0))) {
			$readdata['content'] = '<p class="pk-width-all pk-padding-15 pk-text-center pk-text-default" style="border:dashed 1px orangered">该文章设置了回复查看，请回复后查看内容</p>';
		}
	} else {
		$readdata['content'] = '<p class="pk-width-all pk-padding-15 pk-text-center pk-text-default" style="border:dashed 1px orangered">您需要登录并回复后才可以查看该文章内容</p>';
	}
}
//部分内容回复后可见
if (strpos($readdata['content'], '<p class="PytReplylook">') !== FALSE && $_G['USER']['ID'] != $readdata['uid'] && $_G['USER']['ID'] != 1) {
	$_ls = '';
	if ($_G['USER']['ID']) {
		if (!$_G['TABLE']['REPLY'] -> getId(array('rid' => $readdata['id'], 'uid' => $_G['USER']['ID'], 'del' => 0))) {
			$_ls = '<p class="PytReplylook">该内容设置了回复查看，请回复后查看隐藏内容</p>';
		}
	} else {
		$_ls = '<p class="PytReplylook">您需要登录并回复后才可以查看隐藏的内容</p>';
	}
	if ($_ls)
		$readdata['content'] = preg_replace('/\<p class="PytReplylook"\>[\s\S]+?\<\/p\>/', $_ls, $readdata['content']);
}
//文章所属分类
$sortid = $readdata['sortid'];
if (!$_G['GET']['SORTID']) {
	$_G['GET']['SORTID'] = $sortid;
}
$bkdata = $_G['TABLE']['READSORT'] -> getData($sortid);
(InArray($bkdata['adminuids'], $_G['USER']['ID']) && $_G['USER']['ID']) ? $_G['TEMP']['BKADMIN'] = TRUE : $_G['TEMP']['BKADMIN'] = FALSE;
if (!$chkr) {
	if ($readdata['uid']) {
		$readuserdata = $_G['TABLE']['USER'] -> getData($readdata['uid']);
	} else {
		$readuserdata = JsonData($_G['SET']['GUESTDATA']);
	}
	if ($spos == 0) {
		//==============================置顶回复处理===========================
		$sql = 'where `rid`=' . Cnum($readdata['id']) . ' and `del`=0 and `top`=1 order by ' . $orderfield;
		if ($desc)
			$sql .= ' desc';
		$replydatas = $_G['TABLE']['REPLY'] -> getDatas(0, 0, $sql);
		if ($replydatas) {
			foreach ($replydatas as $replydata) {
				if ($replydata['uid']) {
					$replyuserdata = $_G['TABLE']['USER'] -> getData($replydata['uid']);
				} else {
					$replyuserdata = JsonData($_G['SET']['GUESTDATA']);
				}
				$replyhtmlcode .= template('read-2', TRUE, $template);
			}
		}
	}
	//==============================普通回复处理===========================
	$sql = 'where `rid`=' . Cnum($readdata['id']) . ' and `del`=0 and `top`=0 order by ' . $orderfield;
	if ($desc) {
		$sql .= ' desc';
	}
	$replydatas = $_G['TABLE']['REPLY'] -> getDatas($spos, $prenum, $sql);
	if ($replydatas) {
		foreach ($replydatas as $replydata) {
			if ($replydata['uid']) {
				$replyuserdata = $_G['TABLE']['USER'] -> getData($replydata['uid']);
			} else {
				$replyuserdata = JsonData($_G['SET']['GUESTDATA']);
			}
			$replyhtmlcode .= template('read-2', TRUE, $template);
		}
	}
	//seo重塑
	$_G['SET']['WEBKEYWORDS'] = strip_tags($readdata['title']);
	$_G['SET']['WEBDESCRIPTION'] = "{$_G['SET']['WEBKEYWORDS']}，{$_G['SET']['WEBADDEDWORDS']}";
	$_G['SET']['WEBTITLE'] = "{$_G['SET']['WEBKEYWORDS']}" . (Cnum($_G['GET']['PAGE'], 1, TRUE, 1) != 1 ? ' - 第' . Cnum($_G['GET']['PAGE'], 1, TRUE, 1) . '页' : '') . " - {$bkdata['title']} - {$_G['SET']['WEBADDEDWORDS']}";
	$_G['HTMLCODE']['OUTPUT'] .= template('read-1', TRUE);
	$_G['HTMLCODE']['OUTPUT'] .= $replyhtmlcode;
	$_G['HTMLCODE']['OUTPUT'] .= template('read-3', TRUE);
} else {
	$_G['HTMLCODE']['TIP'] = $chkr;
	$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
}
