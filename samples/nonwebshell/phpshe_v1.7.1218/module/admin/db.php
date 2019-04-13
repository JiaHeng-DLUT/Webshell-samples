<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0920 koyshe <koyshe@gmail.com>
 */
$menumark = 'db';
set_time_limit(0);
switch ($act) {
	//####################// 数据导入 //####################//
	case 'import':
		//pe_error('演示站已关闭导入数据功能');
		pe_token_match();
		if ($_g_dbname) {
			$db_list = pe_dirlist("{$pe['path_root']}data/dbbackup/{$_g_dbname}/phpshe_*#v*.sql");
			count($db_list) == 0 && pe_error("目录下没有有效的数据库文件");
			$db_listname = explode('#', $db_list[0]);
			pe_goto("admin.php?mod=db&act=import_one&path={$_g_dbname}&mark={$db_listname[0]}&num=1");
		}
		else {
			pe_error("请选择需要导入的数据库目录...");
		}
	break;
	//####################// 数据导入(执行) //####################//
	case 'import_one':
		if (is_file($sqlname = "{$pe['path_root']}data/dbbackup/{$_g_path}/{$_g_mark}#v{$_g_num}.sql")) {
			$num = $_g_num + 1;
			sql_import($sqlname) ? pe_success('数据导入中请勿刷新！', "admin.php?mod=db&act=import_one&path={$_g_path}&mark={$_g_mark}&num={$num}") : pe_error('数据导入失败...', 'admin.php?mod=db');
		}
		else {		
			pe_success('数据导入完成！', 'admin.php?mod=db');
		}
	break;
	//####################// 数据备份 //####################//
	case 'backup':
		$back_path = "{$pe['path_root']}data/dbbackup/".date('Ymd@His')."/";
		$table_list = $db->sql_selectall("show table status from `{$pe['db_name']}`");
		$mark = substr(md5(uniqid().rand(1, 999999).time().rand(1, 999999)), rand(1,24), 8);
		$pe_cutsql = "/*#####################@ pe_cutsql @#####################*/\n";
		if (isset($_p_pesubmit)) {//不分卷
			pe_token_match();
			if ($_p_backup_cut && $_p_backup_where == 'down') pe_error('本地下载不支持分卷备份...');
			if ($_p_backup_cut && !$_p_backup_cutsize) pe_error('请填写分卷文件大小...');
			if ($_p_backup_where == "server") {
				!is_dir($back_path) && mkdir($back_path, 0777, true);
				!is_writable($back_path) && pe_error("{$back_path} 目录没有写入权限...");
			}
			if (!$_p_backup_cut) {
				$sql_arr = array();
				foreach ($table_list as $v) {
					$sql_arr = array_merge($sql_arr, dosql($v['Name']));
				}
				$sql = implode($pe_cutsql, $sql_arr);
				if ($_p_backup_where == 'down') {
					down_file($sql, 'phpshe_db.sql');
				}
				elseif ($_p_backup_where == 'server') {
					if (file_put_contents("{$back_path}phpshe_{$mark}#v1.sql", $sql)) {
						file_put_contents("{$back_path}index.html", '');
						pe_success("数据备份完成！");
					}
					else {
						pe_error("数据备份失败...");
					}
				}
			}
			else {
				$vnum = 1;
				$sql_arr = array();
				foreach ($table_list as $v) {
					$sql_arr = array_merge($sql_arr, dosql($v['Name']));
					$sql = implode($pe_cutsql, $sql_arr);
					if (strlen($sql) >= $_p_backup_cutsize * 1000) {
						file_put_contents("{$back_path}phpshe_{$mark}#v{$vnum}.sql", $sql);
						$sql_arr = array();
						$vnum++;
					}
				}
				$sql && file_put_contents("{$back_path}phpshe_{$mark}#v{$vnum}.sql", $sql);
				file_put_contents("{$back_path}index.html", '');
				pe_success("数据分卷备份完成！");
			}
		}
	break;
	//####################// 数据删除 //####################//
	case 'del':
		//pe_error('演示站未开启删除权限');
		pe_token_match();
		pe_dirdel("{$pe['path_root']}data/dbbackup/{$_g_dbname}");
		pe_success('删除完成！');
	break;
	//####################// 数据备份恢复 //####################//
	default:
		$backup_list = (array)pe_dirlist("{$pe['path_root']}data/dbbackup/*");
		rsort($backup_list);
		$seo = pe_seo($menutitle='数据备份', '', '', 'admin');
		include(pe_tpl('db_list.html'));
	break;
}

function dosql($table)
{
	global $db;
	$info_create = $db->sql_select("show create table `{$table}`");
	$sql_arr[] = "DROP TABLE IF EXISTS `{$table}`;\n";
	$sql_arr[] = "{$info_create['Create Table']};\n";
	$data_num = $db->sql_num("select count(1) from `{$table}`");
	for ($i = 0; $i < $data_num; $i = $i + 30) {
		$data_list = $db->sql_selectall("select * from `{$table}` limit {$i}, 30");
		$sql = "INSERT INTO `{$table}` VALUES";
		foreach ($data_list as $vv) {
			$sql .= "(";
			foreach ($vv as $vvv) {
				$sql .= "'".addslashes($vvv)."',";
			}
			$sql = trim($sql, ',')."),\n";
		}
		$sql = trim(trim($sql), ',').";\n";
		$sql_arr[] = $sql;
	}
	return $sql_arr;
}

function down_file($sql, $filename)
{
	ob_end_clean();
	header("Content-Encoding: none");
	header("Content-Type: ".(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'application/octetstream' : 'application/octet-stream'));	
	header("Content-Disposition: ".(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'inline; ' : 'attachment; ')."filename=".$filename);	
	header("Content-Length: ".strlen($sql));
	header("Pragma: no-cache");	
	header("Expires: 0");
	echo $sql;
	$e = ob_get_contents();
	ob_end_clean();
}

function sql_import($filename)
{
	global $db;
	$sql_arr = explode('/*#####################@ pe_cutsql @#####################*/', file_get_contents($filename));
	echo "<p style='color:red;text-align:center;margin-top:50px'>数据导入中...请勿刷新浏览器！<br/>当前执行路径：{$filename}</p>";
	foreach ($sql_arr as $v) {
		$result = $db->query(trim($v));
	}
	return result;
}
?>