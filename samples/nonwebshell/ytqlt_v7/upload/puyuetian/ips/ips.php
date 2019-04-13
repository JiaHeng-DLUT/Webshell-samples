<?php
if (!defined('puyuetian'))
	exit('403');

$_G['SYSTEM']['CLIENTIP'] = getClientInfos('ip');
$cip = explode('.', $_G['SYSTEM']['CLIENTIP']);
$ips = explode("\r\n", str_replace('<?php exit("403"); ?>', '', file_get_contents($_G['SYSTEM']['PATH'] . '/puyuetian/ips/config.php')));
foreach ($ips as $ip) {
	if (!$ip) {
		continue;
	}
	$ip = explode('.', $ip);
	$ban = TRUE;
	foreach ($ip as $key => $value) {
		if ($cip[$key] != $value && $value != '*') {
			$ban = FALSE;
			break;
		}
	}
	if ($ban) {
		$_G['SET']['WEBTITLE'] = '禁止访问';
		$_G['SET']['SITECLOSEDTIP'] = '您的IP：' . $_G['SYSTEM']['CLIENTIP'] . '处于网站黑名单中，请联系管理员。';
		$_G['HTMLCODE']['MAIN'] = template($_G['SYSTEM']['PATH'] . '/template/default/siteclosed.hst', TRUE);
		template($_G['SYSTEM']['PATH'] . '/template/default/main.hst');
		exit();
	}
}
unset($cip, $ips, $ip, $ban, $key, $value);
