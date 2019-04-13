<?php
if (!defined('puyuetian'))
	exit('403');

function chkinstall($as, $at) {
	return TRUE;
	global $_G;
	$getjson = json_decode(GetPostData("http://www.hadsky.com/index.php?c=app&a=zhanzhang:index6&s=appinstall&at={$at}&domain={$_G['SYSTEM']['DOMAIN']}&sitekey=" . md5($_G['SET']['APP_HADSKYCLOUDSERVER_SITEKEY']) . "&rnd={$_G['RND']}", '', 10), true);
	if (!$getjson) {
		header('Location:index.php?c=app&a=superadmin:index&s=' . $as . '&alert=' . urlencode('暂时无法安装请稍后再试') . '&pkalert=show&rnd=' . $_G['RND']);
		exit('<script>top.location.href="index.php?c=app&a=superadmin:index"</script>');
	}

	if ($getjson['state'] != 'ok') {
		header('Location:index.php?c=app&a=superadmin:index&s=' . $as . '&alert=' . urlencode($getjson['datas']['msg']) . '&pkalert=show&rnd=' . $_G['RND']);
		exit('<script>top.location.href="index.php?c=app&a=superadmin:index"</script>');
	}
}

function apiData($s, $return = false) {
	global $_G;
	$url = 'http://www.hadsky.com/index.php?c=app&a=zhanzhang:index6&s=' . $s;
	$url .= '&domain=' . $_G['SYSTEM']['DOMAIN'] . '&sitekey=' . md5($_G['SET']['APP_HADSKYCLOUDSERVER_SITEKEY']);
	if ($return) {
		return $url;
	}
	$data = GetPostData($url, '', 10);
	$json = json_decode($data, TRUE);
	if (InArray('ok,no', $json['state'])) {
		return $json;
	} else {
		return array('state' => 'no', 'datas' => array('msg' => '请求失败或返回数据非法：' . $data));
	}
}

function getAT($type) {
	global $_G;
	$array = array();
	$tpath = $_G['SYSTEM']['PATH'] . $type;
	$appnavs = '';
	$scan = scandir($tpath);
	foreach ($scan as $name) {
		$fn = $tpath . '/' . $name;
		if ($name == '.' || $name == '..' || filetype($fn) != 'dir') {
			continue;
		}
		if (!file_exists($fn . '/config.json')) {
			continue;
		}
		$iarray = json_decode(file_get_contents($fn . '/config.json'), TRUE);
		$iarray['install'] = file_exists($fn . '/install.json') ? TRUE : FALSE;
		$iarray['setting'] = file_exists($fn . '/setting.hst') ? TRUE : FALSE;
		$iarray['running'] = $_G['SET'][strtoupper($type) . '_' . strtoupper($name) . '_' . 'LOAD'] ? TRUE : FALSE;
		if ($iarray['install']) {
			$iarray['status'] = '已下载';
		} else {
			$iarray['status'] = '已安装';
		}
		if ($iarray['running']) {
			$iarray['status'] = '已开启';
		}
		$array[$name] = $iarray;
	}
	return $array;
}

function installAT($type, $t) {
	global $_G;
	$fpath = "{$_G['SYSTEM']['PATH']}{$type}/{$t}/install.json";
	if (!file_exists($fpath)) {
		return '安装失败，未找到安装数据';
	}
	$jsondata = json_decode(file_get_contents($fpath), TRUE);
	if (!$jsondata) {
		return '安装数据解析出错';
	}
	if (!rename($fpath, "{$_G['SYSTEM']['PATH']}{$type}/{$t}/uninstall.json")) {
		return '安装或升级失败，无写入权限';
	}
	$prefix = $type . '_' . $t . '_';
	$iarray = array();
	foreach ($jsondata as $key => $value) {
		//数据校验
		if (substr($key, 0, strlen($prefix)) != $prefix) {
			continue;
		}
		$iarray['setname'] = $key;
		$iarray['setvalue'] = $value;
		$_G['TABLE']['SET'] -> newData($iarray);
	}
	return TRUE;
}

function uninstallAT($type, $t) {
	global $_G;
	$sysapps = 'default,superadmin,verifycode,systememail,puyuetianeditor,hadskycloudserver,jvhuo,filesmanager,mysqlmanager,puyuetian_search';
	if (InArray($sysapps, strtolower($_G['GET']['T']))) {
		return '不可卸载系统应用';
	}
	$fpath = "{$_G['SYSTEM']['PATH']}{$type}/{$t}/uninstall.json";
	if (!file_exists($fpath)) {
		return '卸载失败，未找到卸载数据';
	}
	$jsondata = json_decode(file_get_contents($fpath), TRUE);
	if (!$jsondata) {
		return '卸载数据解析出错';
	}
	if (!rename($fpath, "{$_G['SYSTEM']['PATH']}{$type}/{$t}/install.json")) {
		return '卸载失败，无写入权限';
	}
	$prefix = $type . '_' . $t . '_';
	$iarray = array();
	foreach ($jsondata as $key => $value) {
		//数据校验
		if (substr($key, 0, strlen($prefix)) != $prefix) {
			continue;
		}
		$_G['TABLE']['SET'] -> delData('setname', $key);
	}
	return TRUE;
}
