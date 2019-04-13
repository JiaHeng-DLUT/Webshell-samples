<?php
if (!defined('puyuetian'))
	exit('403');

$url = apiData('login', TRUE);
ExitGourl($url . '&url=' . urlencode($_GET['url']));
