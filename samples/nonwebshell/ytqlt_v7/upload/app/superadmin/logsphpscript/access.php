<?php
if (!defined('puyuetian'))
	exit('403');

$ap = $_G['SYSTEM']['PATH'] . 'logs/access/';
if ($_G['GET']['TYPE'] == 'look') {
	$date = Cstr($_GET['date'], FALSE, $_G['STRING']['NUMERICAL'] . '-', 10, 10);
	if (!$date) {
		ExitJson('日期非法');
	}
	$cfp = $_G['SYSTEM']['PATH'] . 'logs/cache/access/detail/' . $date . '.csv';
	if ($date != date('Y-m-d') && file_exists($cfp)) {
		//读取缓存
		$cache = json_decode(file_get_contents($cfp), TRUE);
		ExitJson($cache, TRUE);
	}
	$ap = $ap . $date . '/';
	$files = array();
	if ($dh = opendir($ap)) {
		$i = 0;
		while (($file = readdir($dh)) !== false) {
			if ($file != "." && $file != "..") {
				//获取文件名称
				//$files[$i]["name"] = $file;
				//获取文件大小
				$files[$i]["size"] = round((filesize($ap . $file) / 1024), 2);
				//获取文件最近修改日期
				//$files[$i]["time"] = date("Y-m-d H:i:s", filemtime($ap . $file));
				//获取ip地址
				$files[$i]["ip"] = str_replace('.csv', '', $file);
				//获取访问次数
				$files[$i]["pv"] = count(explode("\n", file_get_contents($ap . $file))) - 1;
				$i++;
			}
		}
	}
	closedir($dh);
	foreach ($files as $k => $v) {
		$size[$k] = $v['size'];
		//$time[$k] = $v['time'];
		//$name[$k] = $v['name'];
	}
	//按时间排序
	//array_multisort($time, SORT_DESC, SORT_STRING, $files);
	//按名字排序
	//array_multisort($name,SORT_DESC,SORT_STRING, $files);
	//按大小排序
	array_multisort($size, SORT_DESC, SORT_NUMERIC, $files);
	if ($date != date('Y-m-d') && !file_exists($cfp)) {
		//写入缓存
		file_put_contents($cfp, json_encode($files));
	}
	ExitJson($files, TRUE);
}
$riqis = scandir($ap, 1);
$rqarray = array();
foreach ($riqis as $key => $value) {
	if (strlen(str_replace('-', '', $value)) != 8) {
		continue;
	}
	$cfp = $_G['SYSTEM']['PATH'] . 'logs/cache/access/list/' . $value . '.csv';
	if ($value != date('Y-m-d') && file_exists($cfp)) {
		//读取缓存
		$cache = json_decode(file_get_contents($cfp), TRUE);
		//ip
		$rqarray[substr($value, 0, 4)] += $cache['ip'];
		$rqarray[substr($value, 0, 7)] += $cache['ip'];
		$rqarray[$value] = $cache['ip'];
		//pv
		$rqarray[substr($value, 0, 4) . '_pv'] += $cache['pv'];
		$rqarray[substr($value, 0, 7) . '_pv'] += $cache['pv'];
		$rqarray[$value . '_pv'] = $cache['pv'];
		continue;
	}
	//年访量
	if (!$rqarray[substr($value, 0, 4)]) {
		$rqarray[substr($value, 0, 4)] = 0;
		$rqarray[substr($value, 0, 4) . '_pv'] = 0;
	}
	//月访量
	if (!$rqarray[substr($value, 0, 7)]) {
		$rqarray[substr($value, 0, 7)] = 0;
		$rqarray[substr($value, 0, 7) . '_pv'] = 0;
	}
	//日访量
	$rqarray[$value] = 0;
	$rqarray[$value . '_pv'] = 0;
	$_riqi = scandir($ap . $value . '/');
	foreach ($_riqi as $_value) {
		if (is_file($ap . $value . '/' . $_value)) {
			//ip
			$rqarray[substr($value, 0, 4)]++;
			$rqarray[substr($value, 0, 7)]++;
			$rqarray[$value]++;
			//pv
			$count = count(explode("\n", file_get_contents($ap . $value . '/' . $_value))) - 1;
			$rqarray[substr($value, 0, 4) . '_pv'] += $count;
			$rqarray[substr($value, 0, 7) . '_pv'] += $count;
			$rqarray[$value . '_pv'] += $count;
		}
	}
	if ($value != date('Y-m-d') && !file_exists($cfp)) {
		//写入缓存
		$cache = array();
		//ip
		$cache['ip'] = $rqarray[$value];
		//pv
		$cache['pv'] = $rqarray[$value . '_pv'];
		file_put_contents($cfp, json_encode($cache));
	}
}
$_G['TEMP']['ACCESS_DATA'] = json_encode($rqarray);
