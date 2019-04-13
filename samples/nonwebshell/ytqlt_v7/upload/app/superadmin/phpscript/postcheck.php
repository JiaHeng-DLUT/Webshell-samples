<?php
if (!defined('puyuetian'))
	exit('403');

$type = $_G['GET']['TYPE'];
if (!$type || ($type != 'read' || 'reply')) {
	$type = 'read';
}
$page = Cnum($_G['GET']['PAGE'], 1, TRUE, 1);
$shownum = 50;
$spos = ($page - 1) * $shownum;
$postchecks = $_G['TABLE'][strtoupper($type)] -> getDatas($spos, $shownum, 'where `del`=2 order by `id` desc');
if ($postchecks) {
	foreach ($postchecks as $postcheck) {
		$userdata = $_G['TABLE']['USER'] -> getData($postcheck['uid']);
		if ($type == 'reply') {
			$readdata = $_G['TABLE']['READ'] -> getData($postcheck['rid']);
			$title = '回复:' . $readdata['title'];
		} else {
			$title = $postcheck['title'];
		}
		$outhtml .= "
<tr>
	<td><input class='check-chkbox' type='checkbox' value='{$postcheck['id']}'></td>
	<td><a target='_blank' href='index.php?c=user&id={$userdata['id']}'>{$userdata['nickname']}</a></td>
	<td>{$title}</td>
	<td>" . date('Y-m-d H:i:s', $postcheck['posttime']) . "</td>
</tr>
<tr>
	<td colspan='99'>
		<div style='height:40px;padding:5px;' ondblclick='if(\$(this).height==40){\$(this).height='auto'}else{\$(this).height=40}'>
			{\$postcheck['content']}
		</div>
	</td>
</tr>
		";
	}
}
