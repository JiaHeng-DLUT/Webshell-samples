<?php
if (!defined('puyuetian'))
	exit('403');

if (!$_G['SET']['TEMPLATE_' . strtoupper($_G['SET']['TEMPLATENAME']) . '_BODYNOTTOHOME']) {
	$_G['TEMPLATE']['BODY'] = 'home';
} else {
	$_G['HTMLCODE']['OUTPUT'] .= template('home', TRUE);
}

if ($_G['SET']['DEFAULTPAGE'] != 'home') {
	$_G['SET']['WEBTITLE'] = '首页 - ' . $_G['SET']['WEBADDEDWORDS'];
}

//$_G['HTMLCODE']['OUTPUT'] .= template('home', TRUE);
