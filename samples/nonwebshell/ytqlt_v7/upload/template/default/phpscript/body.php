<?php
if (!defined('puyuetian'))
	exit('403');

$_G['USER']['ID'] ? $_G['HTMLCODE']['LOGINHTML'] .= template('logined', TRUE) : $_G['HTMLCODE']['LOGINHTML'] .= template('guest', TRUE);

//版块列表
$mainbkdatas = array();
$bkdatas = $_G['TABLE']['READSORT'] -> getDatas(0, 0, "where `pid`=0 and `show`=1 order by `rank`");
$mainbkdatas['PBK'] = $bkdatas;
foreach ($bkdatas as $bkdata) {
	$bkdatas2 = $_G['TABLE']['READSORT'] -> getDatas(0, 0, "where `pid`={$bkdata['id']} and `show`=1 order by `rank`");
	$mainbkdatas['CBK'][$bkdata['id']] = $bkdatas2;
}
$_G['TEMP']['BKDATAS'] = json_encode($mainbkdatas);
//推荐文章
global $tjwzhtml;
if ($_G['SET']['TEMPLATE_DEFAULT_TJWZIDS']) {
	$reads = explode(',', $_G['SET']['TEMPLATE_DEFAULT_TJWZIDS']);
	$tjwzhtml = '<div class="pk-row pk-margin-bottom-15 pk-background-color-white"><div class="pk-background-color-primary pk-text-white pk-w-sm-12 pk-padding-top-10 pk-padding-bottom-10">推荐文章</div><div class="pk-w-sm-12 pk-text-sm pk-text-default pk-padding-top-10 pk-padding-bottom-10">';
	foreach ($reads as $id) {
		$read = $_G['TABLE']['READ'] -> getData($id);
		$tjwzhtml .= "
								<a class='pk-display-block pk-padding-top-10 pk-padding-bottom-10 pk-text-truncate pk-hover-opacity' href='" . ReWriteURL('read', "id={$id}&page=1") . "' style='border-bottom: solid 1px #eee;'><span class='fa fa-file-text-o'></span> {$read['title']}</a>
								";
	}
	$tjwzhtml .= '</div></div>';
}

//精华文章
global $jhwzhtml;
$jhnum = Cnum($_G['SET']['TEMPLATE_DEFAULT_JHNUM']);
if ($jhnum) {
	$jhwzhtml = '<div class="pk-row pk-margin-bottom-15 pk-background-color-white"><div class="pk-background-color-primary pk-text-white pk-w-sm-12 pk-padding-top-10 pk-padding-bottom-10">最新精华</div><div class="pk-w-sm-12 pk-text-sm pk-text-default pk-padding-top-10 pk-padding-bottom-10">';
	$reads = $_G['TABLE']['READ'] -> getDatas(0, $jhnum, 'where high=1 and del=0 order by `id` desc');
	foreach ($reads as $read) {
		$jhwzhtml .= "
								<a class='pk-display-block pk-padding-top-10 pk-padding-bottom-10 pk-text-truncate pk-hover-opacity' href='" . ReWriteURL('read', "id={$read['id']}&page=1") . "' style='border-bottom: solid 1px #eee;'><span class='fa fa-diamond pk-text-secondary'></span> {$read['title']}</a>
								";
	}
	$jhwzhtml .= '</div></div>';
}

//最热文章
global $zrwzhtml;
$jhnum = Cnum($_G['SET']['TEMPLATE_DEFAULT_RTNUM']);
if ($jhnum) {
	$zrwzhtml = '<div class="pk-row pk-margin-bottom-15 pk-background-color-white"><div class="pk-background-color-primary pk-text-white pk-w-sm-12 pk-padding-top-10 pk-padding-bottom-10">最热的帖</div><div class="pk-w-sm-12 pk-text-sm pk-text-default pk-padding-top-10 pk-padding-bottom-10">';
	$reads = $_G['TABLE']['READ'] -> getDatas(0, $jhnum, 'where del=0 order by `looknum` desc');
	if ($reads) {
		foreach ($reads as $read) {
			$zrwzhtml .= "
								<a class='pk-display-block pk-padding-top-10 pk-padding-bottom-10 pk-text-truncate pk-hover-opacity' href='" . ReWriteURL('read', "id={$read['id']}&page=1") . "' style='border-bottom: solid 1px #eee;'><span class='fa fa-fire pk-text-danger'></span> {$read['title']}</a>
								";
		}
	}
	$zrwzhtml .= '</div></div>';
}
//我的小伙伴
if ($_G['GET']['C'] == $_G['SET']['DEFAULTPAGE']) {
	$_G['TEMP']['FRIENDLINKS'] .= '
<div class="pk-container pk-margin-top-15 pk-hide-sm">
	<div class="pk-row pk-padding-top-15 pk-padding-bottom-15 pk-background-color-white">
		<div class="pk-w-md-12 pk-text-sm">
			<div class="pk-padding-bottom-5 pk-margin-bottom-5" style="border-bottom: solid 1px #E0E0E0">我的小伙伴</div>
		</div>
		<div class="pk-w-md-12 pk-text-xs">
			<div class="pk-friendlink">
				' . $_G['SET']['FRIENDLINKS'] . '
			</div>
		</div>
	</div>
</div>
			';
}
