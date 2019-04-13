<?php
if (!defined('puyuetian'))
	exit('403');

$c = $_G['GET']['C'];
if ($c == 'preview') {
	$c = 'read';
}
if (InArray('edit,read', $c) && $_G['GET']['PYTEDITORLOAD'] != 'no') {
	$_G['SET']['EMBED_HEAD'] .= '<link rel="stylesheet" href="app/puyuetianeditor/template/css/PytEditor.css">';
	$_G['SET']['EMBED_FOOT'] .= '<script>if($(window).width()>1000){' . $_G['SET']['APP_PUYUETIANEDITOR_PC' . strtoupper($c) . 'CONFIG'] . ';var PytEditorHeight=\'' . $_G['SET']['APP_PUYUETIANEDITOR_PCHEIGHT'] . '\'}else{' . $_G['SET']['APP_PUYUETIANEDITOR_PHONE' . strtoupper($c) . 'CONFIG'] . ';var PytEditorHeight=\'' . $_G['SET']['APP_PUYUETIANEDITOR_PHONEHEIGHT'] . '\'}</script><script src="app/puyuetianeditor/template/js/PytEditor.js"></script><script src="app/puyuetianeditor/template/js/PytEditorInit.js"></script>';
}
