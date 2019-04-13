<?php
if (!defined('puyuetian'))
	exit('403');

global $quickpost1, $quickpost2, $forumdata;
$quickpost1 = '<!--';
$quickpost2 = '-->';
$_G['SET']['APP_PUYUETIANEDITOR_QUICKEDITCONFIG'] = '<script>' . $_G['SET']['APP_PUYUETIANEDITOR_QUICKEDITCONFIG'] . '</script>';
if ($_G['SET']['APP_PUYUETIANEDITOR_QUICKPOST'] && current(explode('.', $_G['SYSTEM']['DOMAIN'])) != 'm' && $forumdata['id']) {
	$quickpost1 = '';
	$quickpost2 = '';
}
