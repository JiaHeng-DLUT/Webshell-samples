<?php
if (!defined('puyuetian'))
	exit('403');

$r = FALSE;
if (strpos($_POST['ips'], '?') === FALSE) {
	$r = file_put_contents($_G['SYSTEM']['PATH'] . '/puyuetian/ips/config.php', '<?php exit("403"); ?>' . $_POST['ips']);
}

if ($_G['GET']['JSON']) {
	$r = $r ? '操作成功' : '操作失败';
	ExitJson($r, TRUE);
} else {
	header("Location:index.php?c=app&a=superadmin:index&s=home&t=ips&pkalert=show&alert=" . urlencode('操作成功！') . "&rnd={$_G['RND']}");
}
exit();
