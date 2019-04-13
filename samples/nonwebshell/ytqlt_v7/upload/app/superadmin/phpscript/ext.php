<?php
if (!defined('puyuetian'))
	exit('403');

$appsp = "{$_G['SYSTEM']['PATH']}/app/{$_G['GET']['AN']}/embedsas/{$_G['GET']['SN']}.php";

if (file_exists($appsp)) {
	require $appsp;
} else {
	RunError("\"{$appsp}\" doesn't exist");
}
