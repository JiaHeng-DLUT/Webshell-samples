<?php
if (!defined('puyuetian'))
	exit('403');

//安装成功，锁定安装程序
file_put_contents($mp . 'install/install.locked', 'install locked!');

$HTMLCODE .= template("{$tpath}complete.hst", TRUE);
