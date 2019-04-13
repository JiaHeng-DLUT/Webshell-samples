<?php
if (!defined('puyuetian'))
	exit('Not Found puyuetian!Please contact QQ632827168');
/********************************************
 puyuetianPHP框架扩展部分初始化代码
 *******************************************/
define('AUTOEXT', FALSE);
if (AUTOEXT) {
	//自动扩展框架php脚本
	$_G['EXT']['PATH'] = $_G['SYSTEM']['PATH'] . '/puyuetian/ext/';
	$_G['EXT']['TOTAL'] = 0;
	$_G['EXT']['FILES'] = array();
	$_G['EXT']['LOADINFO'] = '';
	$PLUGFILES = scandir($_G['EXT']['PATH']);
	foreach ($PLUGFILES as $FILENAME) {
		if (filetype($_G['EXT']['PATH'] . $FILENAME) == 'file' && end(explode('.', $FILENAME)) == 'php') {
			$_G['EXT']['TOTAL']++;
			$_G['EXT']['FILES'][] = "{$_G['EXT']['PATH']}{$FILENAME}";
			require $_G['EXT']['PATH'] . $FILENAME;
		}
	}
	unset($PLUGFILES, $FILENAME);
	$_G['EXT']['LOADINFO'] .= "Load Frame Exts Total {$_G['EXT']['TOTAL']}\n";
} else {
	//手动扩展框架php脚本
	//需要预处理的
	require $_G['SYSTEM']['PATH'] . '/puyuetian/ext/preload.php';
	//自定义函数
	require $_G['SYSTEM']['PATH'] . '/puyuetian/ext/function.php';
	//用户身份识别
	require $_G['SYSTEM']['PATH'] . '/puyuetian/ext/uia.php';
	//其他加载项目
	require $_G['SYSTEM']['PATH'] . '/puyuetian/ext/normal.php';
	//加载应用扩展脚本
	require $_G['SYSTEM']['PATH'] . '/puyuetian/ext/loadapps.php';
}
