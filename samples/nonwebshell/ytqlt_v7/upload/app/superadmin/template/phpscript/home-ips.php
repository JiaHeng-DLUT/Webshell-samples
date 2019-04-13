<?php
if (!defined('puyuetian'))
	exit('403');

global $BANIPS;
$BANIPS = htmlspecialchars(file_get_contents($_G['SYSTEM']['PATH'] . '/puyuetian/ips/config.php'));
