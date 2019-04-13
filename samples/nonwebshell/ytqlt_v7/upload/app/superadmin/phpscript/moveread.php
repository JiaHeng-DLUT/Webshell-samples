<?php
if (!defined('puyuetian'))
	exit('403');

$ids = (array)$_POST['ids'];
$sortid = Cnum($_POST['sortid']);

if ($_G['GET']['TABLE'] == 'read' && $sortid && count($ids)) {
	foreach ($ids as $id) {
		if (Cnum($id))
			mysql_query("update `{$_G['MYSQL']['PREFIX']}read` set `sortid`={$sortid} where `id`={$id}");
	}
	$r = '操作成功！';
} else {
	$r = '未选择版块或文章为空！';
}
if ($_G['GET']['JSON']) {
	ExitJson($r, TRUE);
} else {
	header("Location:index.php?c=app&a=superadmin:index&s={$_G['GET']['OS']}&t={$_G['GET']['OT']}&table={$_G['GET']['TABLE']}&sortid={$_G['GET']['SORTID']}&uid={$_G['GET']['UID']}&date1={$_G['GET']['DATE1']}&date2={$_G['GET']['DATE2']}&pkalert=show&alert=" . urlencode($r) . "&rnd={$_G['RND']}");
}
exit();
