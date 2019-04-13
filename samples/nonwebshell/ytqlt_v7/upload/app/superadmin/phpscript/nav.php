<?php
if (!defined('puyuetian'))
	exit('403');

$nav_data = str_replace(array("\t", " ", "\r", "\n", "\r\n", PHP_EOL), '', file_get_contents("{$_G['SYSTEM']['PATH']}app/superadmin/template/js/navigation.json"));

//加载插件及模板
$tpath = array("{$_G['SYSTEM']['PATH']}template/", "{$_G['SYSTEM']['PATH']}app/");
$tjson = array(',{"HADSKY_HOOK":"TEMPLATE"}', ',{"HADSKY_HOOK":"APP"}');
for ($i = 0; $i < count($tpath); $i++) {
	$_json = '';
	$scan = scandir($tpath[$i]);
	foreach ($scan as $name) {
		if ($name && $name != '.' && $name != '..' && filetype($tpath[$i] . $name) == 'dir') {
			if (file_exists($tpath[$i] . $name . '/config.xml') && !file_exists($tpath[$i] . $name . '/install.json') && (file_exists($tpath[$i] . $name . '/setting.html') || file_exists($tpath[$i] . $name . '/setting.hst'))) {
				$xml = simplexml_load_string(file_get_contents($tpath[$i] . $name . '/config.xml'));
				$tname = $xml -> name;
				//加载应用图标
				if ($i) {
					//插件
					if (file_exists("{$_G['SYSTEM']['PATH']}app/{$name}/logo.png")) {
						$imgattr = '\\" style=\\"background-image:url(app/' . $name . '/logo.png);height:14px;width:14px;background-size:100% 100%;background-repeat:no-repeat';
					} else {
						$imgattr = 'plug';
					}
				} else {
					//模板
					if (file_exists("{$_G['SYSTEM']['PATH']}template/{$name}/logo.png")) {
						$imgattr = '\\" style=\\"background-image:url(template/' . $name . '/logo.png);height:14px;width:14px;background-size:100% 100%;background-repeat:no-repeat';
					} else {
						$imgattr = 'puzzle-piece';
					}
				}
				$_json .= ',{"icon":"' . $imgattr . '","title":"' . str_replace(array('"', "\r", "\n", "\r\n", PHP_EOL), array('\\"', '', ''), $tname) . '","t":"' . $name . '"}';
			}
		}
	}
	$nav_data = str_replace($tjson[$i], $_json, $nav_data);
}

exit($nav_data);
