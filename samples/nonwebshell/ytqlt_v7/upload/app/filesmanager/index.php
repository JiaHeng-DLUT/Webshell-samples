<?php
if (!defined('puyuetian'))
	exit('403');

/*
 * AppName:Filesmanger
 * Author:Puyuetian
 * QQ:632827168
 */

$suffixs = "html,htm,hst,php,js,css,txt,log";
$type = $_G['GET']['TYPE'];

if ($_G['USER']['ID'] != 1) {
	PkPopup('{content:"您无权操作",icon:2,shade:1}');
}

$spath = realpath($_G['SYSTEM']['PATH']);
$path = realpath($_GET['path']);
$_G['TEMP']['PATH'] = iconv('GBK', 'UTF-8//IGNORE', $path);
if (strpos($path, $spath) !== 0) {
	PkPopup('{content:"越权操作，请求路径：' . $path . '",icon:2,shade:1,hideclose:1,submit:function(){location.href="index.php?c=app&a=filesmanager:index&path="}}');
}

if ($type == 'look' || $type == '') {
	$files = scandir($path);
	foreach ($files as $file) {
		$pathfile = realpath($path . '/' . $file);
		$file = iconv('GBK', 'UTF-8//IGNORE', $file);
		if (filetype($pathfile) == 'dir') {
			if ($file == '..' && $path != $spath) {
				$syjml = substr($path, 0, strrpos($path, '/'));
				$filelist_dir .= "
						<tr>
							<td colspan='4' style='border-right:0'>
								 <a class='pk-text-warning pk-hover-underline' href='index.php?c=app&a=filesmanager:index&path=" . urlencode($syjml) . "#workarea'>上一级目录</a>
							</td>
						</tr>
						";
			}
			if ($file != '.' && $file != '..') {
				$filelist_dir .= "
				<tr>
					<td><span class='fa fa-folder-o pk-text-warning fa-fw' title='文件夹'></span><a class='pk-text-primary pk-hover-underline' href='index.php?c=app&a=filesmanager:index&path=" . urlencode($pathfile) . "#workarea'>{$file}</a></td>
					<td colspan='3' style='border-right:0'></td>
				</tr>
				";
			}
		} else {
			$filelist_file .= "
				<tr>
					<td><span class='fa fa-fw fa-file-o' title='文件'></span>{$file}</td>
					<td>" . date('Y-m-d H:i:s', filemtime($pathfile)) . "</td>
					<td>" . number_format((filesize($pathfile) / 1024), 2) . "KB</td>
					<td>
						<a class='pk-text-success pk-hover-underline' href='index.php?c=app&a=filesmanager:index&type=edit&path=" . urlencode($pathfile) . "#workarea'>编辑</a>
						<a class='pk-text-danger pk-hover-underline' href='javascript:' onclick=\"delFile('" . str_replace('\\', '\\\\', $pathfile) . "',this)\">删除</a>
					</td>
				</tr>
				";
		}
	}
	$filelist = $filelist_dir . $filelist_file;
	$_G['SET']['WEBTITLE'] = '文件在线管理器';
	$_G['HTMLCODE']['OUTPUT'] .= template('filesmanager:index', TRUE);
} elseif ($type == 'edit' || $type == 'save') {
	if (filetype($path) != 'file') {
		if ($type == 'save') {
			ExitJson('不存在的文件');
		}
		PkPopup('{content:"不存在的文件",icon:2,shade:1,hideclose:1,submit:function(){location.href="index.php?c=app&a=filesmanager:index&path=' . urlencode($path) . '"}}');
	}
	$suffix = substr($path, strrpos($path, '.') + 1);
	if (!InArray($suffixs, $suffix)) {
		if ($type == 'save') {
			ExitJson('不支持的文件格式');
		}
		PkPopup('{content:"不支持的文件格式",icon:2,shade:1,hideclose:1,submit:function(){location.href="index.php?c=app&a=filesmanager:index&path=' . urlencode($path) . '"}}');
	}
	if ($type == 'save') {
		$filecontent = $_POST['filecontent'];
		$r = file_put_contents($path, $filecontent);
		ExitJson('保存失败：' . $path, $r);
	}
	$filecontent1 = file_get_contents($path);
	$filecontent = htmlspecialchars($filecontent1);
	if ($filecontent1 && !$filecontent) {
		PkPopup('{content:"不支持该文件编码，仅支持UTF-8",icon:2,shade:1,hideclose:1}');
	}
	$urlpath = urlencode($path);
	$_G['SET']['WEBTITLE'] = '文件在线管理器';
	$_G['HTMLCODE']['OUTPUT'] .= template('filesmanager:edit', TRUE);
} elseif ($type == 'del') {
	$r = unlink($path);
	ExitJson('操作完成', $r);
} elseif ($type == 'mkdir' || $type == 'mkfile') {
	$mkname = $_GET['mkname'];
	if (!$mkname) {
		PkPopup('{content:"未输入名称",icon:2,shade:1,hideclose:1,submit:function(){location.href="index.php?c=app&a=filesmanager:index&path=' . urlencode($path) . '"}}');
	}
	if ($type == 'mkdir') {
		if (!file_exists($path . "/{$mkname}")) {
			$r = mkdir($path . "/{$mkname}");
		} else {
			PkPopup('{content:"目录已存在",icon:2,shade:1}');
		}
	} else {
		if (!file_exists($path . "/{$mkname}")) {
			$r = file_put_contents($path . "/{$mkname}", '');
		} else {
			PkPopup('{content:"文件已存在",icon:2,shade:1,hideclose:1,submit:function(){location.href="index.php?c=app&a=filesmanager:index&path=' . urlencode($path) . '"}}');
		}
	}
	if ($r !== FALSE) {
		PkPopup('{content:"目录或文件创建成功",icon:2,shade:1,hideclose:1,submit:function(){location.href="index.php?c=app&a=filesmanager:index&path=' . urlencode($path) . '"}}');
	}
	PkPopup('{content:"目录或文件创建失败",icon:2,shade:1,hideclose:1,submit:function(){location.href="index.php?c=app&a=filesmanager:index&path=' . urlencode($path) . '"}}');
}
