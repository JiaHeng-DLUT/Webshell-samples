<?php
if (!defined('puyuetian'))
	exit('Not Found puyuetian!Please contact QQ632827168');

$a = Cstr(strtolower($_GET['a']), FALSE, $_G['STRING']['LOWERCASE'] . $_G['STRING']['NUMERICAL'] . '_:', 3, 255);
if ($a && strpos($a, ':') === FALSE) {
	$a .= ':index';
}
if (!$a) {
	PkPopup('{content:"非法的请求参数",icon:2,shade:1,hideclose:1,nomove:1,submit:function(){window.close()}}');
}
$a = explode(':', $a);
if (count($a) != 2) {
	PkPopup('{content:"非法的插件请求",icon:2,shade:1,hideclose:1,nomove:1,submit:function(){window.close()}}');
}
$_G['SYSTEM']['APPDIR'] = $a[0];
$_G['SYSTEM']['APPFILE'] = $a[1];
if (InArray('load,embed', $_G['SYSTEM']['APPFILE'])) {
	PkPopup('{content:"加载文件禁止直接访问",icon:2,shade:1,hideclose:1,nomove:1,submit:function(){window.close()}}');
}
$_G['SYSTEM']['APPPATH'] = $_G['SYSTEM']['PATH'] . "app/{$_G['SYSTEM']['APPDIR']}/{$_G['SYSTEM']['APPFILE']}.php";
if (!file_exists($_G['SYSTEM']['APPPATH']) || !$_G['SET']['APP_' . strtoupper($_G['SYSTEM']['APPDIR']) . '_LOAD']) {
	PkPopup('{content:"不存在的应用或未启用",icon:2,shade:1,hideclose:1,nomove:1,submit:function(){window.close()}}');
}

require $_G['SYSTEM']['APPPATH'];
