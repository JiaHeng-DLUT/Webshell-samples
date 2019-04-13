<?php
if (!defined('puyuetian'))
	exit('403');

function SearchSql($ws) {
	$sql = $sqlorder1 = $sqlorder2 = '';
	foreach ($ws as $value) {
		//模糊搜索
		$sql .= 'concat(`title`,`content`) like ' . mysqlstr($value, TRUE, '%', TRUE) . ' or ';
		//内容相关度
		$sqlorder1 .= "length(replace(concat(`title`,`content`)," . mysqlstr($value) . ",''))+";
		//关键词频率
		$sqlorder2 .= "(length(concat(`title`,`content`))-length(replace(concat(`title`,`content`)," . mysqlstr($value) . ",'')))/length(" . mysqlstr($value) . ")+";
	}
	if ($sql) {
		$sql = '(' . mb_substr($sql, 0, mb_strlen($sql) - 4) . ')';
		$sqlorder1 = '(' . mb_substr($sqlorder1, 0, mb_strlen($sqlorder1) - 1) . ') asc,';
		$sqlorder2 = '(' . mb_substr($sqlorder2, 0, mb_strlen($sqlorder2) - 1) . ') desc,';
	}
	return "where `del`=0 and {$sql} order by {$sqlorder2}{$sqlorder1}`id` desc";
}

function searchws($str) {
	$ws = explode(' ', $_GET['w']);
	foreach ($ws as $w) {
		$str = str_replace($w, '<b style="color:red">' . $w . '</b>', $str);
	}
	return $str;
}

if (!InArray($_G['USER']['QUANXIAN'], 'search')) {
	if ($_G['USER']['ID']) {
		$tmp = '{icon:2,content:"您无权使用搜索功能"}';
	} else {
		$tmp = '{icon:0,content:"请登录后再操作",submit:function(){location.href="index.php?c=login"}}';
	}
	PkPopup($tmp);
}
$w = trim($_GET['w']);
if (!$w && $w !== 0) {
	PkPopup('{icon:2,content:"搜索词非法或无效"}');
}
$ws = array_unique(explode(' ', $w));
//exit($mysqlws);
$template = template('puyuetian_search:list', TRUE, FALSE, FALSE);
$page = Cnum($_G['GET']['PAGE'], 1, TRUE, 1);
$pnum = Cnum($_G['SET']['APP_PUYUETIAN_SEARCH_SHOWCOUNT'], 100, TRUE, 1);
$counts = $_G['TABLE']['READ'] -> getCount(SearchSql($ws));
$pages = ceil($counts / $pnum);
$readdatas = $_G['TABLE']['READ'] -> getDatas(($page - 1) * $pnum, $pnum, SearchSql($ws));
$readhtml = '';
if ($readdatas) {
	foreach ($readdatas as $readdata) {
		$i++;
		//检测是否允许该用户组进入
		$readsortdata = $_G['TABLE']['READSORT'] -> getData($readdata['sortid']);
		if (!InArray($readsortdata['allowgroupids'], $_G['USER']['GROUPID']) && $readsortdata['allowgroupids']) {
			$readdata['content'] = '您的用户组目前不允许进入该板块';
		}
		//检测是否为回复查看帖
		if ($readdata['replyafterlook']) {
			if (!$_G['USER']['ID'] || ($_G['USER']['ID'] && !$_G['TABLE']['REPLY'] -> getId(array('rid' => $readdata['id'], 'uid' => $_G['USER']['ID'], 'del' => 0)))) {
				$readdata['content'] = '您需要登录并回复后才可以查看该文章内容';
			}
		}
		//检测阅读权限是否合法
		if ((Cnum($readdata['readlevel']) > getUserQX(FALSE, 'readlevel')) || !chkReadSortQx($sortid, 'readlevel')) {
			$readdata['content'] = '您的阅读权限太低，无法查看该文章';
		}
		//检测是否有隐藏内容
		$readdata['content'] = preg_replace('/\<p class="PytReplylook"\>[\s\S]+?\<\/p\>/', '<p>[隐藏内容]</p>', $readdata['content']);
		$title = searchws(strip_tags($readdata['title']));
		$content = mb_substr(strip_tags($readdata['content']), 0, 255);
		$content = str_replace(array(" ", "　", '&nbsp;', "\n", "\r", "\t"), '', $content);
		$content = searchws($content);
		if (mb_strlen($readdata['content']) > 255) {
			$content .= '...';
		}
		$url = ReWriteURL('read', "id={$readdata['id']}&page=1");
		$url2 = 'http' . ($_SERVER['HTTPS'] == 'on' ? 's' : '') . '://' . $_G['SYSTEM']['DOMAIN'] . '/' . $url;
		$readhtml .= template(FALSE, TRUE, $template);
	}
}

$_G['HTMLCODE']['OUTPUT'] .= template('puyuetian_search:main', TRUE);
