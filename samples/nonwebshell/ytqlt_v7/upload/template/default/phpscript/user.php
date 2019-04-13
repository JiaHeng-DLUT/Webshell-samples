<?php
if (!defined('puyuetian'))
	exit('403');

global $userdata, $page, $id;
$showcount = Cnum($_G['SET']['SHOWUSERINFOREADCOUNT'], 10, TRUE, 1);
$readdatas = $_G['TABLE']['READ'] -> getDatas(($page - 1) * $showcount, $showcount, "where `uid`={$id} and `del`=false order by `id` desc");
$_G['TEMP']['ACTIVEHTML'] = '';
if ($readdatas) {
	foreach ($readdatas as $readdata) {
		$_G['TEMP']['ACTIVEHTML'] .= '
<div class="pk-row" onclick="if($(window).width()<1000){location.href=\'' . ReWriteURL('read', "id={$readdata['id']}&page=1") . '\'}">
	<div class="pk-w-sm-12">
		<div class="pk-row pk-padding-bottom-15 pk-padding-top-15" style="border-bottom: solid 1px #E0E0E0">
			<div class="pk-w-sm-7 pk-text-truncate pk-padding-right-0">
				<span class="pk-badge pk-background-color-success pk-text-xs pk-radius-4 pk-cursor-default" title="已被阅读次数">' . $readdata['looknum'] . '</span>
				<a class="pk-hover-underline" target="_blank" href="' . ReWriteURL('read', "id={$readdata['id']}&page=1") . '">' . $readdata['title'] . '</a>
			</div>
			<div class="pk-w-sm-5 pk-text-right pk-text-nowrap pk-padding-left-0">
				<span class="fa fa-commenting-o"></span>&nbsp;' . ($readdata['fs'] - 1) . '
				<span class="fa fa-calendar"></span>&nbsp;' . date('Y-m-d', $readdata['posttime']) . '
			</div>
		</div>
	</div>
</div>
					';
	}
}
