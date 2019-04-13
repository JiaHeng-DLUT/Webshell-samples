<?php
if (!defined('puyuetian'))
	exit('403');

global $forumdata, $forumgourl;
$forumdata['readcount'] = $_G['TABLE']['READ'] -> getCount(array('sortid' => $forumdata['id']));
if ($forumdata['url']) {
	$forumgourl = $forumdata['url'];
} else {
	$forumgourl = ReWriteURL('list', "sortid={$forumdata['id']}&page=1");
}
$forumdata['todayreadcount'] = $_G['TABLE']['READ'] -> getCount('where `sortid`=' . $forumdata['id'] . ' and  `posttime`>' . strtotime(date('Y-m-d 00:00:00', time())) . ' and `posttime`<' . strtotime(date('Y-m-d 23:59:59', time())));

$_G['TEMP']['CFHTML'] = '';
$childforumsdata = $_G['TABLE']['READSORT'] -> getDatas(0, 0, "where `pid`={$forumdata['id']} and `show`=1 order by `rank`");
foreach ($childforumsdata as $childforumdata) {
	$childforumdata['readcount'] = getReadCount($childforumdata['id']);
	$childforumdata['todayreadcount'] = getReadCount($childforumdata['id'], 'today');
	if ($childforumdata['url']) {
		$cforumgourl = $childforumdata['url'];
	} else {
		$cforumgourl = ReWriteURL('list', "sortid={$childforumdata['id']}&page=1");
	}
	$_G['TEMP']['CFHTML'] .= '
	<div class="pk-w-sm-6 pk-w-md-3 pk-overflow-hidden" onclick="location.href=\'' . $cforumgourl . '\'">
		<div class="pk-row pk-padding-top-10 pk-padding-bottom-10" style="height:52px;line-height:32px;">
			<div class="pk-w-sm-4 pk-text-right">
				<img height="32" src="' . $childforumdata['logourl'] . '" onerror="this.src=\'template/default/img/forum.png\';this.onerror=\'\'" alt="">
				<span class="pk-radius-all pk-background-color-danger pk-text-white pk-position-absolute pk-text-center pk-cursor-pointer forumtodaycount" style="width: 16px;height: 16px;line-height:16px;font-size: 8px;right:5px;top:-5px;" title="总帖' . $childforumdata['readcount'] . '，今日' . $childforumdata['todayreadcount'] . '">' . $childforumdata['todayreadcount'] . '</span>
			</div>
			<div class="pk-w-sm-8 pk-padding-0 pk-text-truncate pk-text-default">
				' . $childforumdata['title'] . '
			</div>
		</div>
	</div>
		';
}
