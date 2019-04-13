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
$fileurl = url('cache');
$tempfile = 'cache.html';

$cache_array = array(
	'options' => '系统设置',
	'links' => '友情链接',
	'advers' => '网站广告',
	'categories' => '网站分类',
	'archives' => '数据归档',
	'stats' => '数据统计'
);



if (empty($action)) $action = 'info';

/** info and show */
if (in_array($action, array('info', 'show'))) {
	switch ($action) {
		case 'info' :
			$pagetitle = '缓存管理';
			
			$caches = array();
			foreach ($cache_array as $name => $desc)	{
				$filepath = ROOT_PATH.'data/static/'.$name.'.php';
				
				if (is_file($filepath)) {
					$cachefile['name'] = $name;
					$cachefile['desc'] = $desc;
					$cachefile['size'] = get_real_size(filesize($filepath));
					$cachefile['mtime'] = gmdate('Y-m-d H:i', @filemtime($filepath));
					
					$fp = fopen($filepath, 'rb');
					$nr = fread($fp, 100);
					fclose($fp);
					
					$detail = explode("\n", $nr);
					$cachefile['ctime'] = (strlen($detail[2]) == 37) ? substr($detail[2], 17, 16) : '未知';
					$caches[] = $cachefile;
				}
			}
			unset($cachefile);
			
			$Youke->assign('caches', $caches);
			break;
		case 'show' :
			$cache_id = I('get.cache_id');
			$pagetitle = '查看 '.$cache_id.' 缓存';
			
			$Youke->assign('h_action', 'update');
			
			if (in_array($cache_id, array_keys($cache_array))) {
				$filepath = ROOT_PATH.'data/static/'.$cache_id.'.php';
				
				if (is_file($filepath)) {
					$fp = fopen($filepath, 'rb');
					$cache_data = fread($fp, filesize($filepath));
					$cache_data = str_replace("<?php\r\n//File name: ".$cache_id.".php\r\n", '', $cache_data);
					$cache_data = str_replace("\r\nif (!defined('IN_YOUKE365')) exit('Access Denied');\r\n", '', $cache_data);
					$cache_data = str_replace("\r\n?>", '', $cache_data);
					
					ob_start();
					print_r(htmlspecialchars($cache_data));
					$data = ob_get_contents();
					ob_end_clean();
					
					$Youke->assign('data', $data);
				} else {
					msgbox('缓存文件不存在！');
				}
			} else {		
				msgbox('缓存文件不存在！');
			}
			break;
	}
}

/** update */
if ($action == 'update') {
	$cache_id = I('get.cache_id');
	update_cache($cache_id);
	
	msgbox($caches[$cache_id].'缓存更新成功！');
}

/** update static */
if ($action == 'update_static') {
	options_cache();
	links_cache();
	advers_cache();
	categories_cache();
	archives_cache();
	stats_cache();
	del_dir(ROOT_PATH.'runtime/');//更新缓存目录
	msgbox('所有缓存更新成功！');
}

Youke_display($tempfile);
