<?php
if (!defined('puyuetian'))
	exit('Not Found puyuetian!Please contact QQ632827168');

$_G['APP']['LOADINFO'] = '';
$_G['APP']['TOTAL'] = 0;
foreach ($_G['SET'] as $key => $value) {
	$len = strlen($key);
	if ($len > 9 && substr($key, 0, 4) == 'APP_' && substr($key, $len - 5) == '_LOAD' && $value) {
		//符合加载条件，获取app目录
		$aname = strtolower(substr($key, 4, $len - 9));
		$loads = explode(',', $value);
		foreach ($loads as $load) {
			if ($load != "0" && $load != "1") {
				$apath = "app/{$aname}/{$load}.php";
				if (file_exists($apath)) {
					require $apath;
					$_G['APP']['TOTAL']++;
					$_G['APP']['LOADINFO'] .= "Success:\"{$aname}:{$load}\"\n";
				} else {
					$_G['APP']['LOADINFO'] .= "Error:\"{$aname}:{$load}\" doesn't exist\n";
				}
			}
		}

	}
}
unset($len, $key, $value, $aname, $loads, $load, $apath);
$_G['APP']['LOADINFO'] .= "Load HadSky Apps Total {$_G['APP']['TOTAL']}\n";
