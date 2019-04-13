<?php
if (!defined('puyuetian'))
	exit('403');

$_G['TEMP']['PHPINFO'] = phpinfo() ? '' : '信息获取失败';
exit();
