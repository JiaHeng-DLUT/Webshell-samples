<?php
if (!defined('puyuetian'))
	exit('403');

$id = $_G['GET']['ID'];
if (!$id) {
	$downloaddata = $_G['TABLE']['UPLOAD'] -> getData('idcode', $_G['GET']['IDCODE']);
	$id = $downloaddata['id'];
}
/*
 if ($_G['USER']['ID'] != 1) {
 $_G['GET']['JIFEN'] = $_G['GET']['TIANDOU'] = 0;
 }
 */
$jifen = Cnum($_G['GET']['JIFEN'], 0, TRUE, 0);
$tiandou = Cnum($_G['GET']['TIANDOU'], 0, TRUE, 0);
$name = htmlspecialchars(strip_tags($_GET['name']), ENT_QUOTES);

$chkr = FALSE;
if (!$chkr && !$id) {
	$chkr = '非法的下载ID';
}

if (!$chkr) {
	$downloaddata = $_G['TABLE']['UPLOAD'] -> getData($id);
	if (!$downloaddata) {
		$chkr = '不存在的下载记录';
	}
}

//判断是否为旧版数据
if (!json_decode($downloaddata['downloadeduids']) && $downloaddata['downloadeduids']) {
	//旧数据转为新数据并保存
	$olddata = explode('__', substr($downloaddata['downloadeduids'], 1, strlen($downloaddata['downloadeduids']) - 2));
	$downloaddata['downloadeduids'] = array();
	foreach ($olddata as $key => $value) {
		$downloaddata['downloadeduids']["uid_{$value}"] = time();
	}
	$downloaddata['downloadeduids'] = json_encode($downloaddata['downloadeduids']);
	$_G['TABLE']['UPLOAD'] -> newData(array('id' => $downloaddata['id'], 'downloadeduids' => $downloaddata['downloadeduids']));
}

$filepath = "{$_G['SYSTEM']['PATH']}/uploadfiles/{$downloaddata['target']}s/{$downloaddata['uid']}/" . substr($downloaddata['datetime'], 0, 8) . "/" . substr($downloaddata['datetime'], 8) . "_{$downloaddata['rand']}.{$downloaddata['suffix']}";

if (!$chkr && !file_exists($filepath) && $downloaddata['target'] != 'remote') {
	$chkr = '不存在的文件';
}

if (!$chkr) {
	$uploaduserdata = $_G['TABLE']['USER'] -> getData($downloaddata['uid']);
	if (!$downloaddata['name'] && $downloaddata['target'] != 'image') {
		if ($name == 'index.php?c=app&a=puyuetianeditor:index&s=showfile&id=' . $id) {
			$name = '附件下载';
		}
		$_G['TABLE']['UPLOAD'] -> newData(array('id' => $downloaddata['id'], 'name' => substr($name, 0, 128), 'tiandou' => $tiandou, 'jifen' => $jifen));
		$downloaddata = $_G['TABLE']['UPLOAD'] -> getData($downloaddata['id']);
	}
	$filesize = filesize($filepath);
	if ($filesize > 1000000000) {
		//G
		$showfilesize = round(($filesize / 1024000000), 2) . 'GB';
	} elseif ($filesize > 1000000) {
		//M
		$showfilesize = round(($filesize / 1024000), 2) . 'MB';
	} elseif ($filesize > 1000) {
		//K
		$showfilesize = round(($filesize / 1024), 2) . 'KB';
	} else {
		//B
		$showfilesize = round($filesize, 2) . 'B';
	}
	//判断该用户下载是否扣费
	if ($_SESSION['APP_PUYUETIANEDITOR_DOWNLOADSESSION_' . $_G['USER']['ID'] . '_' . $downloaddata['id']] != 'ok' && (((!OrderDownloadAttachment(array('attachmentdata' => $downloaddata)) && $_G['SET']['DOWNLOADEDRECORD']) || !$_G['SET']['DOWNLOADEDRECORD']) || !$_G['SET']['DOWNLOADEDRECORD'])) {
		//扣费
		$_G['TEMP']['CHKJFTD'] = 1;
	} else {
		//不扣费
		$_G['TEMP']['CHKJFTD'] = 0;
		$_G['TEMP']['_TIME'] = JsonData($downloaddata['downloadeduids'], "uid_{$_G['USER']['ID']}");
	}
	//已下载用户
	$_G['TEMP']['DOWNLOADEDUIDS'] = '';
	if ($_G['SET']['DOWNLOADEDRECORD']) {
		$uids = array();
		if (json_decode($downloaddata['downloadeduids'])) {
			foreach (json_decode($downloaddata['downloadeduids']) as $key => $value) {
				$uids[] = str_replace('uid_', '', $key);
			}
		} else {
			$uids = explode('_', substr($downloaddata['downloadeduids'], 1, -1));
		}
		$i = 0;
		foreach ($uids as $uid) {
			if ($i == 225) {
				break;
			}
			$uid && $_G['TEMP']['DOWNLOADEDUIDS'] .= '<a target="_blank" href="' . ReWriteURL('user', "id={$uid}&page=1") . '"><img src="userhead/' . $uid . '.png" style="width:48px;height:48px;margin:5.266px;border-radius:50%" onerror="this.src=\'userhead/0.png\'"></a>';
			$i++;
		}
	} else {
		$_G['TEMP']['DOWNLOADEDUIDS'] = '<script id="hidden_download_parent">$("#hidden_download_parent").parent().parent().remove()</script>';
	}
	$_G['SET']['WEBTITLE'] = $downloaddata['name'] . ' - 附件下载';
	$_G['HTMLCODE']['OUTPUT'] .= template('puyuetianeditor:showfile', TRUE);
} else {
	//出错处理
	$_G['HTMLCODE']['TIP'] = $chkr;
	$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
}
