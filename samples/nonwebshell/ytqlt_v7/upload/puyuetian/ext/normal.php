<?php
if (!defined('puyuetian'))
	exit('403');

//站点状态
if ($_G['SET']['SITESTATUS'] && $_G['GET']['C'] != 'login' && $_G['GET']['C'] != 'chklogin' && $_G['USER']['ID'] != 1 && $_G['GET']['C'] != 'app') {
	$_G['HTMLCODE']['MAIN'] = template('siteclosed', TRUE);
	template($_G['TEMPLATE']['MAIN']);
	exit();
}

//注入及xss防护，地址安全检测
if ($_G['SET']['SAFE_REQUEST_URI'] && $_G['USER']['ID'] != 1) {
	if ($_G['SET']['SAFE_REQUEST_URI'] == 2 && (!StringSafeCheck($_SERVER['REQUEST_URI'])) || ($_G['SET']['SAFE_REQUEST_URI'] == 1 && !GetSafeCheck())) {
		//记录日志
		$fp = $_G['SYSTEM']['PATH'] . 'logs/attack/' . date('Y-m-d') . '.csv';
		$qq = urldecode(urldecode($_SERVER['REQUEST_URI']));
		$str = '';
		if (!file_exists($fp)) {
			$str .= '"日期","时间","IP","UID","请求"' . "\n";
		}
		$str .= date('"Y-m-d","H:i:s","') . getClientInfos('ip') . '","' . $_G['USER']['ID'] . '","' . str_replace('"', '""', $qq) . "\"\n";
		file_put_contents($fp, iconv("UTF-8", "gb2312//IGNORE", $str), FILE_APPEND);
		//弹出提示
		PkPopup('{title:"警告",content:"您的请求包含非法字符，已被系统阻止",icon:2,close:function(){location.href="index.php"},hideclose:true,shade:true}');
	}
}

$postarray = array();
