<?php
if (!defined('puyuetian'))
	exit('403');

$_G = array();
$mysql_type = $_POST['mysql_type'];
$mysql_location = $_POST['mysql_location'];
$mysql_username = $_POST['mysql_username'];
$mysql_password = $_POST['mysql_password'];
$mysql_database = $_POST['mysql_database'];
$mysql_prefix = $_POST['mysql_prefix'];
$mysql_charset = $_POST['mysql_charset'];
$adminusername = Cstr($_POST['adminusername']);
if (Cnum($adminusername)) {
	$adminusername = FALSE;
}
$adminpassword = Cstr($_POST['adminpassword'], FALSE, FALSE, 5, 16);
$adminemail = filter_var($_POST['adminemail'], FILTER_VALIDATE_EMAIL);

if (!$mysql_location || !$mysql_username || !$mysql_database || !$mysql_prefix || !$mysql_charset || !InArray('mysql', $mysql_type)) {
	ExitJson("请填写正确的数据库信息");
}
if (!$adminusername || !$adminpassword || !$adminemail) {
	ExitJson("请填写正确的创世人信息，用户名不能为纯数字");
}

//mysql/config.php配置文件写入
$mysql_config = "<?php
if (!defined('puyuetian'))
	exit('403');
\$_G['SQL']['TYPE'] = '{$mysql_type}';
\$_G['SQL']['LOCATION'] = '{$mysql_location}';
\$_G['SQL']['USERNAME'] = '{$mysql_username}';
\$_G['SQL']['PASSWORD'] = '{$mysql_password}';
\$_G['SQL']['DATABASE'] = '{$mysql_database}';
\$_G['SQL']['CHARSET'] = '{$mysql_charset}';
\$_G['SQL']['PREFIX'] = '{$mysql_prefix}';
\$_G['MYSQL']['LOCATION'] = \$_G['SQL']['LOCATION'];
\$_G['MYSQL']['USERNAME'] = \$_G['SQL']['USERNAME'];
\$_G['MYSQL']['PASSWORD'] = \$_G['SQL']['PASSWORD'];
\$_G['MYSQL']['DATABASE'] = \$_G['SQL']['DATABASE'];
\$_G['MYSQL']['CHARSET'] = \$_G['SQL']['CHARSET'];
\$_G['MYSQL']['PREFIX'] = \$_G['SQL']['PREFIX'];";
file_put_contents($mp . 'puyuetian/mysql/config.php', $mysql_config);
//pdo连接数据库
try {
	$_G['PDO'] = new PDO("{$mysql_type}:host={$mysql_location};dbname={$mysql_database}", $mysql_username, $mysql_password . '', array(PDO::MYSQL_ATTR_INIT_COMMAND => $mysql_charset));
} catch (PDOException $e) {
	ExitJson($e -> getMessage());
}
//导入MySQL数据
$string = file_get_contents($mp . 'install/mysqldata/hadsky.sql');
//去除bom
if (ord(substr($string, 0, 1)) == 239 && ord(substr($string, 1, 1)) == 187 && ord(substr($string, 2, 1)) == 191) {
	$string = substr($string, 3);
}
//数据表前缀替换
$string = str_replace('`pk_', "`{$mysql_prefix}", $string);
$querys = explode(";\r\n", $string);
if (count($querys) < 5) {
	$querys = explode(";\n", $string);
}
$err = 1;
$rs = '';
foreach ($querys as $query) {
	$err++;
	if (trim($query, "\x00..\x1F")) {
		$r = sqlQuery($query);
		if (!$r) {
			ExitJson("出错行{$err}：" . sqlError() . "，出错语句：" . htmlspecialchars($query));
		}
	}
}
//创始人信息更新
$s_t = CreateRandomString(7);
$key = CreateRandomString(32);
sqlQuery("update `{$mysql_prefix}user` set `username`='{$adminusername}',`password`='" . md5($adminpassword) . "',`email`='{$adminemail}',`session_token`='{$s_t}' where `id`=1");
sqlQuery("update `{$mysql_prefix}set` set `setvalue`='{$key}' where `setname`='key'");
//云服务域名处理
if ($_POST['hs_username']) {
	$YCCP = '../yuncheckcode.htm';
	$YUNCHECKCODE = CreateRandomString(16);
	file_put_contents($YCCP, json_encode(array('yuncheckcode' => $YUNCHECKCODE, 'deadline' => (time() + 300))));
	$r = GetPostData("http://www.hadsky.com/index.php?c=app&a=zhanzhang:index2&s=installbinding&yuncheckcode={$YUNCHECKCODE}&domain={$_G['SYSTEM']['DOMAIN']}&rnd={$_G['RND']}", "username={$_POST['hs_username']}&password=" . md5($_POST['hs_password']), 5);
	$r = json_decode($r, TRUE);
	if ($r['state'] == 'ok') {
		mysql_query("update `{$mysql_prefix}set` set `setvalue`='{$r['datas']['msg']}' where `setname`='app_hadskycloudserver_sitekey'");
		ExitJson('安装和云服务绑定成功完成', TRUE);
	} else {
		ExitJson('pkalert|安装已完成，但云服务绑定失败：' . ($r['datas']['msg'] ? $r['datas']['msg'] : '通讯失败'), TRUE);
	}
}

ExitJson('安装成功完成', TRUE);
