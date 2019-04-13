<?php
if (!defined('puyuetian'))
	exit('403');

global $outhtml, $nowchecktitle, $type;
$type = $_G['GET']['TYPE'];
if (!$type || ($type != 'read' && $type != 'reply')) {
	$type = 'read';
}
$nowchecktitle = '文章';
$page = Cnum($_G['GET']['PAGE'], 1, TRUE, 1);
$shownum = 50;
$spos = ($page - 1) * $shownum;
$postchecks = $_G['TABLE'][strtoupper($type)] -> getDatas($spos, $shownum, 'where `del`=1 order by `id` desc');
if ($postchecks) {
	foreach ($postchecks as $postcheck) {
		$userdata = $_G['TABLE']['USER'] -> getData($postcheck['uid']);
		if ($type == 'reply') {
			$readdata = $_G['TABLE']['READ'] -> getData($postcheck['rid']);
			$title = '回复:' . htmlspecialchars($readdata['title'], ENT_QUOTES);
			$nowchecktitle = '回复';
		} else {
			$title = htmlspecialchars($postcheck['title'], ENT_QUOTES);
			$nowchecktitle = '文章';
		}
		$outhtml .= "
<tr class='pk-text-center pk-text-truncate'>
	<td>
		<input class='check-chkbox' name='ids[]' type='checkbox' value='{$postcheck['id']}'>
	</td>
	<td>{$postcheck['id']}</td>
	<td>
		<a class='pk-hover-underline' target='_blank' href='index.php?c=user&id={$userdata['id']}'>{$userdata['nickname']}</a>
	</td>
	<td>{$title}</td>
	<td>" . date('Y-m-d H:i:s', $postcheck['posttime']) . "</td>
</tr>
<tr>
	<td colspan='99'>
		<div class='recontent pk-word-break-all' style='height:40px;padding:5px;overflow:hidden;max-width:100%' ondblclick='if(\$(this).outerHeight()==40){\$(this).css(\"height\",\"\")}else{\$(this).outerHeight(40)}'>
			" . htmlspecialchars($postcheck['content'], ENT_QUOTES) . "
		</div>
	</td>
</tr>
		";
	}
}
