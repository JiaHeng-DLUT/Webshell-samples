<?php
/****************优客365网址导航系统 开源版********************/
/*                                                            */
/*  Youke365.site (C)2017 Youke365 Inc.                       */
/*  This is NOT a freeware, use is subject to license terms   */
/*  优客365网址导航开源版 个人用户可免费使用  请保留底部版权  */
/*  2018.4                                                    */
/*  官方网址：http://www.youke365.site                        */
/*  官方论坛：http://bbs.youke365.site                        */                           
/**************************************************************/

if (!defined('IN_YOUKE365')) exit('Access Denied');
include APP_PATH.__MODULE__.'/base.php';
$fileurl = url('database');
$tempfile = 'database.html';

$Dbak = new DataBak(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_CHARSET);
$datadir = $Dbak->datadir;

if (!isset($action)) $action = 'backup';

/** backup */
if ($action == 'backup') {
	$pagetitle = '数据库备份';
	$tabels = $Dbak->get_tables();
	
	$Youke->assign('tables', $tabels);
	$Youke->assign('h_action', 'do_backup');
}

/** restore */
if ($action == 'restore') {
	$pagetitle = '数据库恢复';
			
	$i = 0;
	if (is_dir($datadir)) {
		$dirs = dir($datadir);
		$files = array();
		$today = date('Y-m-d',time());
		while ($file = $dirs->read()) {
			$filepath = $datadir.'/'.$file;
			$pathinfo = pathinfo($file);
			if (is_file($filepath) && $pathinfo['extension'] == 'php') {
				$moday = date('Y-m-d', @filemtime($filepath));
				$mtime = date('Y-m-d H:i', @filemtime($filepath));
						
				$fileinfo = array(
					'filename' => htmlspecialchars($file),
					'filesize' => get_real_size(filesize($filepath)),
					'filemtime' => ($moday == $today) ? '<font color="#FF0000">'.$mtime.'</font>' : $mtime,
					'filepath' => urlencode($file),
				);
				$i++;
				$files[] = $fileinfo;
			}
		}

		unset($fileinfo);
		$dirs->close();
	}
			
	$Youke->assign('files', $files);
	$Youke->assign('h_action', 'do_restore');
}

/** maintain */
if ($action == 'maintain') {
	$pagetitle = '数据库维护';
	
	$Youke->assign('h_action', 'do_maintain');
}

/** 显示数据信息 */
if ($action == 'dbinfo') {
	$pagetitle = '数据库信息';
	
	$mysql_version = mysqli_get_server_info($Dbak->conn);
	$mysql_runtime = '';
	$query = $Db->query("SHOW STATUS");
	foreach($query as $row){
		if (preg_match("/^uptime+$/i", $row['Variable_name'])){
			$mysql_runtime = $row['Value'];
		}
	}
	$mysql_runtime = format_timespan($mysql_runtime);

	$query = $Db->query("SHOW TABLE STATUS");
	$table_num = $table_rows = $data_size = $index_size = $free_size = 0;
	$tables = array();
	
	foreach($query as $table) {
		$data_size = $data_size + $table['Data_length'];
		$index_size = $index_size + $table['Index_length'];
		$table_rows = $table_rows + $table['Rows'];
		$free_size = $free_size + $table['Data_free'];
		
		$table['Data_length'] = get_real_size($table['Data_length']);
		$table['Index_length'] = get_real_size($table['Index_length']);
		$table['Data_free'] = $table['Data_free'] > 0 ? '<font color="#ff0000">'.get_real_size($table['Data_free']).'</font>' : get_real_size($table['Data_free']);
		$table_num ++;
		$tables[] = $table;
	}
	unset($table);
	
	$data_size = get_real_size($data_size);
	$index_size = get_real_size($index_size);
	$free_size = get_real_size($free_size);
	
	$Youke->assign('tables', $tables);
	$Youke->assign('data_size', $data_size);
	$Youke->assign('index_size', $index_size);
	$Youke->assign('free_size', $free_size);
	$Youke->assign('table_num', $table_num);
	$Youke->assign('table_rows', $table_rows);

	$Youke->assign('h_action', 'do_maintain');
}

/**数据备份 */
if ($action == 'do_backup') {
	$baktype = I('post.baktype');
	$tables  = I('post.table','');
	$volsize = intval($_POST['volsize']);
	
	if ($volsize <= 0) {
		msgbox('分卷文件大小不能小于0！');
	}
	
	if ($baktype == 'full') {
		if ($Dbak->export_sql('', $volsize)) {
			msgbox('数据备份成功！');
		} else {
			msgbox('数据备份失败！');
		}
	}
	
	if ($baktype == 'custom') {
		if (empty($tables)) {
			msgbox('请选择您要备份的数据表！');
		}
		
		if ($Dbak->export_sql($tables, $volsize)) {
			msgbox('数据备份成功！');
		} else {
			msgbox('数据备份失败！');
		}		
	}
}

/** 数据还原 */
if ($action == 'import') {
	$bakfile = I('get.file');
	$filepath = $Dbak->datadir.$bakfile;
	
	if (empty($bakfile)) {
		msgbox('请指定要恢复的文件！');
	}
	
	if ($Dbak->import_sqlfile($filepath)) {
		msgbox('数据恢复成功！');
	} else {
		msgbox('数据恢复失败！');
	}
}

/** 数据删除 */
if ($action == 'delete') {
	$bakfile = I('get.file');
	$filepath = $Dbak->datadir.$bakfile;
	
	if (unlink($filepath)) {
		msgbox('文件删除成功！',url('database',['act'=>'restore']));
	} else {
		msgbox('文件删除失败！');
	}
}

/** 数据库优化 */
if ($action == 'do_maintain') {
	$doname = array (
		'check' => '检查',
		'repair' => '修复',
		'analyze' => '分析',
		'optimize' => '优化',
	);
	$tables = $Dbak->get_tables();
	
	$doarr = I('post.do');
	if (empty($doarr)) {
		msgbox('请选择你要执行的操作！');
	}
	$result ='';
	foreach ($doarr as $do) {
		foreach ($tables as $table) {
			if ($Db->query($do.' TABLE '.$table)) {
				$result .= $doname[$do].'“'.$table.'”-----------------------------------<font color="#008800">成功！</font><br />';
			} else {
				$result .= $doname[$do].'“'.$table.'”-----------------------------------<font color="#ff0000">失败！</font><br />';
			}
		}
	}
	msgbox($result);
}

Youke_display($tempfile);

