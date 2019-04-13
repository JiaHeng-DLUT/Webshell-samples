<?php
if (!defined('puyuetian'))
	exit('403');

$datas = $_G['TABLE']['READSORT'] -> getDatas(0, 0, 'order by `rank` desc');
$_G['GET']['READSORTHTML'] = '';
foreach ($datas as $data) {
	$_G['GET']['READSORTHTML'] .= "<option value='{$data['id']}'>{$data['title']}</option>";
}
if ($_G['GET']['TABLE'] == 'read' || $_G['GET']['TABLE'] == 'reply') {

	$_G['TEMP']['PAGE'] = Cnum($_G['GET']['PAGE'], 1, TRUE, 1);
	$spos = ($_G['TEMP']['PAGE'] - 1) * 100;
	$sql = '';
	if ($_G['GET']['SORTID']) {
		$sql .= " and `sortid`={$_G['GET']['SORTID']}";
	}
	if ($_G['GET']['UID']) {
		$sql .= " and `uid`={$_G['GET']['UID']}";
	}
	if (Cnum($_G['GET']['DATE1']) > 10000000 && Cnum($_G['GET']['DATE1']) < 99999999) {
		$sql .= " and `posttime`>=" . strtotime($_G['GET']['DATE1']);
	}
	if (Cnum($_G['GET']['DATE2']) > 10000000 && Cnum($_G['GET']['DATE2']) < 99999999) {
		$sql .= " and `posttime`<=" . strtotime($_G['GET']['DATE2']);
	}
	$datas = $_G['TABLE'][strtoupper($_G['GET']['TABLE'])] -> getDatas($spos, 100, 'where `del`=0' . $sql . ' order by `id` desc');
	foreach ($datas as $data) {
		$readid = $data['id'];
		if ($_G['GET']['TABLE'] == 'reply') {
			$readdata = $_G['TABLE']['READ'] -> getData($data['rid']);
			$data['sortid'] = $readdata['sortid'];
			$data['title'] = htmlspecialchars('第' . $data['fnum'] . '楼回复《' . $readdata['title'] . '》：' . $data['content'], ENT_QUOTES);
			$readid = $readdata['id'];
		}
		$sortdata = $_G['TABLE']['READSORT'] -> getData($data['sortid']);
		$sortname = $sortdata['title'];
		$username = $_G['TABLE']['USER'] -> getData($data['uid']);
		$username = $username['username'];
		$_G['TEMP']['LIST'] .= "
<div class='pk-row pk-padding-10 pk-text-sm' style='border:solid 1px #EEEEEE;border-top:none'>
	<div class='pk-w-sm-1 pk-text-center' style='border-right:solid 1px #EEEEEE'>
		<input type='checkbox' name='ids[]' value='{$data['id']}'>
	</div>
	<div class='pk-w-sm-2 pk-text-truncate' style='border-right:solid 1px #EEEEEE'>
		<a target='_target' class='pk-hover-underline pk-text-secondary' href='index.php?c=list&sortid={$sortdata['id']}&page=1'>{$sortname}&nbsp;</a>
	</div>
	<div class='pk-w-sm-4 pk-text-truncate' style='border-right:solid 1px #EEEEEE'>
		<a target='_target' class='pk-hover-underline pk-text-secondary' href='index.php?c=read&id={$readid}&page=1#{$_G['GET']['TABLE']}list' title='{$data['title']}'>{$data['title']}&nbsp;</a>
	</div>
	<div class='pk-w-sm-2 pk-text-truncate' style='border-right:solid 1px #EEEEEE'>
		<a target='_target' class='pk-hover-underline pk-text-secondary' href='index.php?c=user&id={$data['uid']}&page=1'>{$username}&nbsp;</a>
	</div>
	<div class='pk-w-sm-3 pk-text-truncate'>" . date('Y-m-d H:i:s', $data['posttime']) . "</div>
</div>
";
	}
}
