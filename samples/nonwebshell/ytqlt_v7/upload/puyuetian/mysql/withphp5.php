<?php
if (!defined('puyuetian'))
	exit('403');

//为了兼容或防止升级7遗漏的问题，php5.x将会用mysql方式多读一次数据库
//连接mysql数据库，共尝试3次
$r = false;
for ($i = 0; $i < 3; $i++) {
	$_G['MYSQL']['LINK'] = mysql_connect($_G['MYSQL']['LOCATION'], $_G['MYSQL']['USERNAME'], $_G['MYSQL']['PASSWORD']);
	if ($_G['MYSQL']['LINK']) {
		$r = true;
		break;
	}
}
if (!$r) {
	if (DEBUG) {
		PkPopup('{title:"php5.x兼容模式",content:"MySQL数据库连接出错:' . str_replace('"', '\\"', mysql_error()) . '",icon:2,shade:1}');
	} else {
		PkPopup('{title:"php5.x兼容模式",content:"MySQL数据库连接出错，如果你是网站管理员，可以修改index.php文件开启调试模式来显示错误详情。",icon:2,shade:1}');
	}
}
unset($i, $r);

if (!mysql_select_db($_G['MYSQL']['DATABASE'], $_G['MYSQL']['LINK'])) {
	PkPopup('{title:"php5.x兼容模式",content:"不存在“' . $_G['MYSQL']['DATABASE'] . '”库，请确认并创建后重试",icon:2,shade:1}');
}

//数据库编码设置
mysql_query($_G['MYSQL']['CHARSET'], $_G['MYSQL']['LINK']);
//防止mysql宽注入
mysql_query("set character_set_client=binary", $_G['MYSQL']['LINK']);
mysql_set_charset('utf8', $_G['MYSQL']['LINK']);
