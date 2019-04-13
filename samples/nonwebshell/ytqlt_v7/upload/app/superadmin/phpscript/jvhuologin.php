<?php
if (!defined('puyuetian'))
	exit('403');

ExitGourl('http://www.jvhuo.com/api.html?apiuid=' . $_G['SET']['APP_JVHUO_APIUID'] . '&apicode=' . $_G['SET']['APP_JVHUO_APICODE'] . '&s=login&url=' . urlencode($_GET['url']));
