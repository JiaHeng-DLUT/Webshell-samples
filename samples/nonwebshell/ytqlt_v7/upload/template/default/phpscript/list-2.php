<?php
if (!defined('puyuetian'))
	exit('403');

global $readdata, $replyuserdata, $replydata, $imgshtml, $lgtime;
if ($readdata['high']) {
	$readdata['title'] = '<span title="精华" class="fa fa-diamond pk-text-primary"></span> ' . $readdata['title'];
}
if ($readdata['top']) {
	$readdata['title'] = '<span title="置顶" class="fa fa-arrow-up pk-text-danger"></span> ' . $readdata['title'];
}
$readdata['olddata']['content'] = $readdata['content'];
if ($replyuserdata['id'] && $_G['SET']['TEMPLATE_DEFAULT_LISTCONTENTTYPE']) {
	$readdata['content'] = "{$replyuserdata['nickname']}：" . EqualReturn(strip_tags($replydata['content'], ''), '', '[Image]');
}
//图片加载
$i = 0;
$_G['TEMP']['IMGS'] = '';
$imgshtml = array();
$noimglist = 'emotion';
if (preg_match_all('#<img.*?src="(.*?)".*?alt="(.*?)".*?\>#', $readdata['content'], $match)) {
	foreach ($match[1] as $key => $value) {
		if (!InArray($noimglist, $match[2][$key])) {
			if ($i > 2)
				break;
			$i++;
			$imgshtml[$i] = '
						<div class="pk-w-sm-(-i-) pk-overflow-hidden pk-text-center" style="max-height:180px">
							<img class="ImageLoading pk-max-width-all pk-max-height-all pk-cursor-pointer" src="template/default/img/loading.gif" data-src="' . $value . '" alt="" onclick="LookImage(this)" />
						</div>';
		}
	}
	$i = count($imgshtml);
	if ($i) {
		$i = 12 / $i;
		foreach ($imgshtml as $value) {
			$_G['TEMP']['IMGS'] .= str_replace('(-i-)', $i, $value);
		}
	}
}
//发表时间人性化
$readlistorder = Cstr($_G['SET']['READLISTORDER'], 'activetime', TRUE, 1, 255);
if ($readlistorder != 'posttime')
	$readlistorder = 'activetime';
$lgtime = time() - Cnum($readdata[$readlistorder]);
if ($lgtime < 60) {
	$lgtime = '刚刚';
} elseif ($lgtime < 3600) {
	$lgtime = (int)($lgtime / 60) . '分钟前';
} elseif ($lgtime < 86400) {
	$lgtime = (int)($lgtime / 3600) . '小时前';
} else {
	$lgtime = (int)($lgtime / 86400) . '天前';
}
$_G['TEMP']['READADMINLINK'] = '';
//版主检测
$bkdata = $_G['TABLE']['READSORT'] -> getData($readdata['sortid']);
if (InArray(getUserQX(), 'superman')) {
	if ($readdata['top']) {
		$_G['TEMP']['READADMINLINK'] .= '<a href="javascript:" onclick="pkalert(&quot;确认取消该文章的置顶？&quot;,&quot;提示&quot;,&quot;window.open(\'index.php?c=admincmd&table=read&field=top&value=0&id=' . $readdata['id'] . '&chkcsrfval=' . $_G['CHKCSRFVAL'] . '\',\'pk-di\');pkalert(\'取消成功\')&quot;)">取消置顶</a>&nbsp;';
	} else {
		$_G['TEMP']['READADMINLINK'] .= '<a href="javascript:" onclick="pkalert(&quot;确认设置该文章置顶？&quot;,&quot;提示&quot;,&quot;window.open(\'index.php?c=admincmd&table=read&field=top&value=1&id=' . $readdata['id'] . '&chkcsrfval=' . $_G['CHKCSRFVAL'] . '\',\'pk-di\');pkalert(\'设置成功\')&quot;)">设为置顶</a>&nbsp;';
	}
	if ($readdata['high']) {
		$_G['TEMP']['READADMINLINK'] .= '<a href="javascript:" onclick="pkalert(&quot;确认取消该文章的精华？&quot;,&quot;提示&quot;,&quot;window.open(\'index.php?c=admincmd&table=read&field=high&value=0&id=' . $readdata['id'] . '&chkcsrfval=' . $_G['CHKCSRFVAL'] . '\',\'pk-di\');pkalert(\'取消成功\')&quot;)">取消精华</a>&nbsp;';
	} else {
		$_G['TEMP']['READADMINLINK'] .= '<a href="javascript:" onclick="pkalert(&quot;确认设置该文章精华？&quot;,&quot;提示&quot;,&quot;window.open(\'index.php?c=admincmd&table=read&field=high&value=1&id=' . $readdata['id'] . '&chkcsrfval=' . $_G['CHKCSRFVAL'] . '\',\'pk-di\');pkalert(\'设置成功\')&quot;)">设为精华</a>&nbsp;';
	}
}
if (InArray(getUserQX(), 'admin') || (InArray($bkdata['adminuids'], $_G['USER']['ID']) && $_G['USER']['ID'])) {
	$_G['TEMP']['READADMINLINK'] .= '<a href="index.php?c=edit&type=read&id=' . $readdata['id'] . '">编辑</a>&nbsp;<a href="javascript:" onclick="pkalert(\'确认删除该文章？\',\'提示\',&quot;delread(\'' . $readdata['id'] . '\',\'read\',function(){$(\'#listdivbox-' . $readdata['id'] . '\').remove()})&quot;)">删除</a>';
}
