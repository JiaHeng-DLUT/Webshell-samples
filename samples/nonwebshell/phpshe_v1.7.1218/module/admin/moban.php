<?php
/**
 * @copyright   2008-2014 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'moban';
switch ($act) {
	//####################// 下载解压 //####################//
	case 'down':
		$moban_id = intval($_g_id);
		$moban_name = file_get_contents("http://www.phpshe.com/index.php?mod=api&act=moban_down&id={$moban_id}&type=mark");
		$moban_file = file_get_contents("http://www.phpshe.com/index.php?mod=api&act=moban_down&id={$moban_id}");
		$moban_zip = "{$pe['path_root']}data/cache/thumb/{$moban_name}";	

		file_put_contents($moban_zip, $moban_file);
		if (!is_file($moban_zip)) {
			echo json_encode(array('result'=>false, 'show'=>'模板下载失败'));
			die();
		}
		$moban_zip_arr = explode("{$pe['path_root']}data/cache/thumb/", $moban_zip);
		$moban_zip_name = explode('.', $moban_zip_arr[1]);
		$moban_template = "{$pe['path_root']}template/{$moban_zip_name[0]}/";
		if (@is_dir($moban_template) === false) {
			mkdir($moban_template, 0777, true);
		}
		else {
			echo json_encode(array('result'=>false, 'show'=>'模板已存在'));
			die();
		}
		pe_lead('include/class/pclzip.class.php');
		$unzip = new PclZip($moban_zip);
		$zip_list = $unzip->extract(PCLZIP_OPT_PATH, $moban_template);
		if (!count($zip_list)) {
			echo json_encode(array('result'=>false, 'show'=>'模板解压失败'));
			die();
		}
		echo json_encode(array('result'=>true));
	break;
	//####################// 设置模板 //####################//
	case 'setting':
		pe_token_match();
		if ($db->pe_update('setting', array('setting_key'=>'web_tpl'), array('setting_value'=>pe_dbhold($_g_tpl)))) {
			pe_lead('hook/cache.hook.php');
			cache_write('setting');
			cache_write('template');
			pe_success('启用成功!');
		}
		else {
			pe_error('启用失败...');
		}
	break;
	//####################// 删除模板 //####################//
	case 'del':
		pe_token_match();
		$tpl_name = pe_dbhold($_g_tpl);
		if ($tpl_name == 'default') pe_error('默认模板不能删除...');
		if ($db->pe_num('setting', array('setting_key'=>'web_tpl', 'setting_value'=>$tpl_name))) {
			pe_error('使用中不能删除');
		}
		else {
			pe_dirdel("{$pe['path_root']}template/{$tpl_name}");
			pe_success('删除成功!');
		}
	break;
	//####################// 模板管理 //####################//
	default:
		$info_list = pe_dirlist('template/*');
		$moban_now = $cache_setting['web_tpl'];
		foreach ($info_list as $k=>$v) {
			if (!is_dir("{$pe['path_root']}template/{$v}")) unset($info_list[$k]);
		}
		$seo = pe_seo($menutitle='模板管理', '', '', 'admin');
		include(pe_tpl('moban_list.html'));
	break;
}
function moban_config($tpl){
	global $pe;
	$config = @file_get_contents("{$pe['path_root']}template/{$tpl}/index/config.ini");
	$config_arr = explode("\n", iconv("gbk", "utf-8", $config));
	foreach ($config_arr as $v) {
		$v_arr = explode('=', $v);
		$key = trim($v_arr[0]);
		$config_list[$key] = trim($v_arr[1]);
	}
	return $config_list;
}
?>