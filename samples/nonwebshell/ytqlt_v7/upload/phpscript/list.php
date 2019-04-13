<?php
if (!defined('puyuetian'))
	exit('403');

$sortid = Cnum($_G['GET']['SORTID'], 0, TRUE, 1);
$type = $_G['GET']['TYPE'];
$page = Cnum($_G['GET']['PAGE'], 1, TRUE, 1);
$syy = $page - 1;
$xyy = $page + 1;
$prenum = Cnum($_G['SET']['READLISTNUM'], 10, TRUE, 1);
$spos = ($page - 1) * $prenum;

if (!chkReadSortQx($sortid, 'readlevel')) {
	PkPopup('{
		content:"您所在的用户组阅读权限太低或自身阅读权限太低无法查看该板块内容",
		icon:2,
		hideclose:true,
		shade:true
	}');
}
if ($_GET['label']) {
	//安全处理
	$label = '';
	$labels = array_unique(explode(',', $_GET['label']));
	$sqllabel = ' and (';
	$i = 0;
	foreach ($labels as $value) {
		if ($value) {
			$sqllabel .= '`label` like ' . mysqlstr(preg_replace('/[\"\']+/', '', strip_tags($value)), TRUE, '%', TRUE) . ' or ';
		}
		$i++;
		if ($i > 9) {
			break;
		}
	}
	if ($sqllabel != ' and (') {
		$sqllabel = substr($sqllabel, 0, -4) . ')';
	} else {
		$sqllabel = '';
	}
}
if ($sortid) {
	$forumdata = $_G['TABLE']['READSORT'] -> getData($sortid);
	if ($forumdata['showchildlist']) {
		$forumdatas = $_G['TABLE']['READSORT'] -> getDatas(0, 0, "where `pid`={$sortid}", FALSE, 'id');
		$sql = " and (`sortid`={$sortid} or ";
		foreach ($forumdatas as $value) {
			$sql .= "`sortid`={$value['id']} or ";
		}
		$sql = substr($sql, 0, strlen($sql) - 4) . ')';
	} else {
		$sql = " and `sortid`={$sortid}";
	}
} else {
	if ($_G['SET']['READLISTSHOWBKS'] || $_G['SET']['READLISTHIDDENBKS']) {
		if ($_G['SET']['READLISTSHOWBKS']) {
			$sql = ' and (';
			$bks = explode(',', $_G['SET']['READLISTSHOWBKS']);
			foreach ($bks as $value) {
				$sql .= '`sortid`=' . $value . ' or ';
			}
			$sql = substr($sql, 0, strlen($sql) - 4) . ')';
		} else {
			$sql = ' and (';
			$bks = explode(',', $_G['SET']['READLISTHIDDENBKS']);
			foreach ($bks as $value) {
				$sql .= '`sortid`<>' . $value . ' and ';
			}
			$sql = substr($sql, 0, strlen($sql) - 5) . ')';
		}
	} else {
		$sql = '';
	}
}

if ($sqllabel) {
	$sql ? $sql .= ' ' . $sqllabel : $sql .= $sqllabel;
}

if ($type == 'high')
	$sql .= ' and `high`=1';
$template = template('list-2', TRUE, FALSE, FALSE);
$topreadhtml = $normalreadhtml = '';
if ($_G['GET']['ORDER'] == 'activetime' || $_G['GET']['ORDER'] == 'posttime') {
	$_G['SET']['READLISTORDER'] = $_G['GET']['ORDER'];
}

for ($i = 0; $i < 2; $i++) {
	$readdatas = array();
	if (!$sortid && !$i) {
		if ($page == 1) {
			//动态页单独处理
			$sql2 = $sql;
			if ($_G['SET']['ACTIVETOPREADIDS']) {
				$_aids = explode(',', $_G['SET']['ACTIVETOPREADIDS']);
				foreach ($_aids as $_id) {
					$_readdata = $_G['TABLE']['READ'] -> getData(Cnum($_id));
					if ($_readdata) {
						$readdatas[] = $_readdata;
					}
				}
				unset($_aids, $_id, $_readdata);
			} else {
				continue;
			}
		} else {
			continue;
		}
	} else {
		//先读取置顶帖，在读取其他贴
		if ($sortid) {
			$i == 0 ? $sql2 = ' and `top`=1' . $sql : $sql2 = ' and `top`=0' . $sql;
		} else {
			$_sql = '';
			if ($_G['SET']['ACTIVETOPREADIDS']) {
				$_aids = explode(',', $_G['SET']['ACTIVETOPREADIDS']);
				foreach ($_aids as $_id) {
					$_sql .= '`id`<>' . Cnum($_id) . ' and ';
				}
				unset($_aids, $_id);
			}
			$_sql ? $sql2 = $sql . ' and ' . substr($_sql, 0, -5) : $sql2 = $sql;
		}
		$readdatas = $_G['TABLE']['READ'] -> getDatas($spos, $prenum, 'where `del`=0' . $sql2 . ' order by `' . Cstr($_G['SET']['READLISTORDER'], 'activetime', TRUE, 1, 255) . '` desc');
	}
	if ($i) {
		$readcount = $_G['TABLE']['READ'] -> getCount('where `del`=0' . $sql2 . ' order by `' . Cstr($_G['SET']['READLISTORDER'], 'activetime', TRUE, 1, 255) . '` desc');
		if ($readcount / $prenum > Cnum($readcount / $prenum)) {
			$pagecount = Cnum($readcount / $prenum) + 1;
		} else {
			$pagecount = Cnum($readcount / $prenum);
		}
		if ($page > $pagecount) {
			$page = $pagecount;
		}
	}
	if ($readdatas) {
		foreach ($readdatas as $readdata) {
			//该文章的版块信息
			if ($sortid) {
				$readsortdata = $forumdata;
			} else {
				$readsortdata = $_G['TABLE']['READSORT'] -> getData($readdata['sortid']);
			}
			//阅读次数高于9999次显示为9999+
			if ($readdata['looknum'] > 9999) {
				$readdata['looknum'] = '9999+';
			}
			//检测是否为回复查看帖
			if ($readdata['replyafterlook']) {
				if ($_G['USER']['ID']) {
					if (!$_G['TABLE']['REPLY'] -> getId(array('rid' => $readdata['id'], 'uid' => $_G['USER']['ID'], 'del' => 0)))
						$readdata['content'] = '该文章设置了回复查看，请回复后查看内容';
				} else {
					$readdata['content'] = '您需要登录并回复后才可以查看该文章内容';
				}
			}
			//部分内容回复后可见
			$readdata['content'] = preg_replace('/\<p class="PytReplylook"\>[\s\S]+?\<\/p\>/', '<p>隐藏内容</p>', $readdata['content']);
			//检测阅读权限是否合法
			if ((($_G['USERGROUP']['ID'] && Cnum($readdata['readlevel']) > Cnum($_G['USERGROUP']['READLEVEL'])) || (!$_G['USERGROUP']['ID'] && Cnum($readdata['readlevel']) > Cnum($_G['USER']['READLEVEL']))) || !chkReadSortQx($sortid, 'readlevel')) {
				$readdata['content'] = '您的阅读权限太低或您的用户组不被允许';
			}
			if ($readdata['uid']) {
				$readuserdata = $_G['TABLE']['USER'] -> getData($readdata['uid']);
			} else {
				$readuserdata = JsonData($_G['SET']['GUESTDATA']);
			}
			$replydata = $_G['TABLE']['REPLY'] -> getData($readdata['replyid']);
			if ($replydata['uid']) {
				$replyuserdata = $_G['TABLE']['USER'] -> getData($replydata['uid']);
			} else {
				$replyuserdata = JsonData($_G['SET']['GUESTDATA']);
			}
			if ($replydata['del']) {
				$replydata['content'] = '该回复正在审核，暂无法显示';
			}
			$i == 0 ? $topreadhtml .= template('list-2', TRUE, $template) : $normalreadhtml .= template('list-2', TRUE, $template);
		}
	}
}

//seo优化
if ($forumdata) {
	$label = $forumdata['label'];
	$_G['SET']['WEBTITLE'] = strip_tags($forumdata['title']) . (Cnum($_G['GET']['PAGE'], 1, TRUE, 1) != 1 ? ' - 第' . Cnum($_G['GET']['PAGE'], 1, TRUE, 1) . '页' : '') . ' - ' . $_G['SET']['WEBADDEDWORDS'];
	if ($forumdata['webtitle']) {
		$_G['SET']['WEBTITLE'] = $forumdata['webtitle'];
	}
	if ($forumdata['webkeywords']) {
		$_G['SET']['WEBKEYWORDS'] = $forumdata['webkeywords'];
	} else {
		if ($forumdata['label']) {
			$_G['SET']['WEBKEYWORDS'] = $forumdata['label'];
		}
	}
	if ($forumdata['webdescription']) {
		$_G['SET']['WEBKEYWORDS'] = $forumdata['webdescription'];
	} else {
		if ($forumdata['content']) {
			$_G['SET']['WEBDESCRIPTION'] = strip_tags($forumdata['content']) . '，' . $_G['SET']['WEBADDEDWORDS'];
		}
	}
} else {
	$label = $_G['SET']['DEFAULTLABEL'];
	if ($_G['SET']['DEFAULTPAGE'] != 'list') {
		$_G['SET']['WEBTITLE'] = '动态' . ($page != 1 ? ' - 第' . Cnum($_G['GET']['PAGE'], 1, TRUE, 1) . '页' : '') . ' - ' . $_G['SET']['WEBADDEDWORDS'];
	}
}

//读取版块标签
$labels = explode(',', $label);
$_G['TEMP']['LABELSHTML'] = '<div id="forumlabel">';
foreach ($labels as $value) {
	if ($value)
		$_G['TEMP']['LABELSHTML'] .= '<a href="javascript:">' . preg_replace('/[\'\"]+/', '', strip_tags($value)) . '</a>';
}
$_G['TEMP']['LABELSHTML'] .= '</div>';

$_G['HTMLCODE']['OUTPUT'] .= template('list-1', TRUE);
$_G['HTMLCODE']['OUTPUT'] .= $topreadhtml;
$_G['HTMLCODE']['OUTPUT'] .= $normalreadhtml;
$_G['HTMLCODE']['OUTPUT'] .= template('list-3', TRUE);
