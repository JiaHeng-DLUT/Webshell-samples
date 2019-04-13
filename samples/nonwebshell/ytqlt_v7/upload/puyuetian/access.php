<?php
if (!defined('puyuetian'))
	exit('403');

//访问控制
//开关，true开，false关
define("HADSKY_ACCESS", 0);
define("HADSKY_ACCESS_MAXFILESIZE", 0);

if (HADSKY_ACCESS) {
	$_path = $_G['SYSTEM']['PATH'] . 'logs/access/' . date('Y-m-d');
	if (file_exists($_path) || (!file_exists($_path) && mkdir($_path, 0777, TRUE))) {
		$_fp = $_path . '/' . str_replace(':', '_', $_G['SYSTEM']['CLIENTIP']) . '.csv';
		$str = '';
		$_size = 0;
		if (!file_exists($_fp)) {
			$str .= '"时间","访问地址"' . "\n";
		} else {
			$_size = filesize($_fp);
		}
		if ($_size > HADSKY_ACCESS_MAXFILESIZE && Cnum(HADSKY_ACCESS_MAXFILESIZE, FALSE, TRUE, 0)) {
			//弹出提示
			$_G['SET']['WEBTITLE'] = '禁止访问';
			$_G['SET']['SITECLOSEDTIP'] = '您的IP：' . $_G['SYSTEM']['CLIENTIP'] . '已达今日最大访问次数。';
			$_G['HTMLCODE']['MAIN'] = template($_G['SYSTEM']['PATH'] . '/template/default/siteclosed.hst', TRUE);
			template($_G['SYSTEM']['PATH'] . 'template/default/main.hst');
			exit();
		}
		$str .= date('"H:i:s","') . str_replace('"', '""', urldecode(urldecode($_SERVER['REQUEST_URI']))) . "\"\n";
		file_put_contents($_fp, iconv("UTF-8", "gb2312//IGNORE", $str), FILE_APPEND);
	}
	unset($str, $_fp, $_path, $_size);
}
