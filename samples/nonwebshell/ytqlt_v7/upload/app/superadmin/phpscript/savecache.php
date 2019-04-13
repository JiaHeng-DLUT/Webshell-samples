<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['GET']['DO'] == 'refresh') {
	$path = scandir($_G['SYSTEM']['PATH'] . '/cache/');
	foreach ($path as $value) {
		if (end(explode('.', $value)) == 'html') {
			unlink($_G['SYSTEM']['PATH'] . '/cache/' . $value);
		}
	}
	$r = TRUE;
} elseif ($_G['GET']['DO'] == 'mysql_refresh') {
	mysql_query("truncate `{$_G['MYSQL']['PREFIX']}cache`");
} else {
	//保存数据库缓存
	//mysql_query("update `{$_G['MYSQL']['PREFIX']}set` `setvalue`='" . mysqlstr($_POST['mysqlcachecycle'], FALSE) . "' where `setname`='mysqlcachecycle'");
	//mysql_query("update `{$_G['MYSQL']['PREFIX']}set` `setvalue`='" . mysqlstr($_POST['mysqlcachetables'], FALSE) . "' where `setname`='mysqlcachetables'");
	//保存文件缓存
	$value = "<?php
define('HADSKY_CACHELIFE', " . Cnum($_POST['cachelife']) . ");
define('HADSKY_CACHEPAGES', '" . Cstr(strtolower($_POST['cachepages']), 'home,forum,list,read', $_G['STRING']['LOWERCASE'] . ',', 1, 255) . "');
define('HADSKY_CACHEREFRESH', " . Cnum($_POST['cacherefresh']) . ");
";
	$r = file_put_contents($_G['SYSTEM']['PATH'] . 'puyuetian/cache/config.php', $value);
	//保存访问控制设置
	file_put_contents($_G['SYSTEM']['PATH'] . 'puyuetian/access.php', str_replace('define("HADSKY_ACCESS", ' . HADSKY_ACCESS . ');', 'define("HADSKY_ACCESS", ' . Cnum($_POST['access_open'], 0, TRUE, 0, 1) . ');', file_get_contents($_G['SYSTEM']['PATH'] . 'puyuetian/access.php')));
	file_put_contents($_G['SYSTEM']['PATH'] . 'puyuetian/access.php', str_replace('define("HADSKY_ACCESS_MAXFILESIZE", ' . HADSKY_ACCESS_MAXFILESIZE . ');', 'define("HADSKY_ACCESS_MAXFILESIZE", ' . Cnum($_POST['access_maxfilesize'], 0, TRUE, 0) . ');', file_get_contents($_G['SYSTEM']['PATH'] . 'puyuetian/access.php')));
}
if ($_G['GET']['JSON']) {
	$r = $r ? '操作成功' : '操作失败';
	ExitJson($r, TRUE);
} else {
	header("Location:index.php?c=app&a=superadmin:index&s=home&t=cache&pkalert=show&alert=" . urlencode('操作成功！') . "&rnd={$_G['RND']}");
}
exit();
