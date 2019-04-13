<?php
if (!defined('puyuetian'))
	exit('403');

$PP = $_G['SYSTEM']['PATH'] . '/app/puyuetianeditor/phpscript/' . $_G['GET']['S'] . '.php';

if (file_exists($PP)) {
	require $PP;
} else {
	exit('"' . $PP . '" doesn\'t exist');
}
