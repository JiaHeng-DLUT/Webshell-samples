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
/** write cache */
function write_cache($cache_name, $cache_data = '') 
{
	$cache_data = $cache_data;
	$cache_dir = ROOT_PATH.'data/static/';
	$cache_file = $cache_dir.$cache_name.'.php';
	
	if (!is_dir($cache_dir)) {
		@mkdir($cache_dir, 0777);
	}
	
	if ($fp = @fopen($cache_file, 'wb')) {
		@fwrite($fp, "<?php\r\n//File name: ".$cache_name.".php\r\n//Creation time: ".date('Y-m-d H:i:s')."\r\n\r\nif (!defined('IN_YOUKE365')) exit('Access Denied');\r\n\r\n".$cache_data."\r\n?>");
		@fclose($fp);
		@chmod($cache_file, 0777);
	} else {
		echo 'Error: Can\'t write to '.$cache_name.' cache files, please check directory.!';
		exit;
	}
}

/** load cache */
function load_cache($cache_name) 
{
	static $static_data = array();
	if (!empty($cache_name)) {
		$cache_file = ROOT_PATH.'data/static/'.$cache_name.'.php';
		if (is_file($cache_file)) {
			@require($cache_file);
			return $static_data;
		} else {
			return false;
		}
	}
}

/** update cache */
function update_cache($cache_name = '') 
{
	$update_list = empty($cache_name) ? array() : (is_array($cache_name) ? $cache_name : array($cache_name));
	foreach ($update_list as $entry) {
		call_user_func($entry.'_cache');
	}
	unset($update_list);
}

/** config cache */
function options_cache() 
{
	global $Db;
	
	$sql = "SELECT * FROM ".table('options');
	$options = $Db->query($sql);
	$contents = "\$static_data = array(\r\n";
	foreach ($options as $opt) {
		$contents .= "\t'".addslashes($opt['option_name'])."' => '".addslashes($opt['option_value'])."',\r\n";
	}
	$contents .= ");";
	unset($options);
	
	write_cache('options', $contents);
}

/** district cache */
function districts_cache() 
{
	global $Db;
	
	$sql = "SELECT * FROM ".table('districts')." ORDER BY dist_order ASC, dist_id ASC";
	$districts = $Db->query($sql);
	$contents .= "\$static_data = array(\r\n";
	foreach ($districts as $dist) {
		$contents .= "\t'".$dist['dist_id']."' => array(\r\n\t\t'dist_id' => '".$dist['dist_id']."',\r\n\t\t'root_id' => '".$dist['root_id']."',\r\n\t\t'dist_name' => '".addslashes($dist['dist_name'])."',\r\n\t\t'dist_dir' => '".addslashes($dist['dist_dir'])."',\r\n\t\t'site_count' => '".$dist['site_count']."',\r\n\t),\r\n";
	}
	$contents .= ");";
	unset($districts);
	
	write_cache('districts', $contents);
}

/** adver cache */
function advers_cache() 
{
	global $Db;
	
	$sql = "SELECT * FROM ".table('advers')." ORDER BY adver_id DESC";
	$advers = $Db->query($sql);
	$contents = "\$static_data = array(\r\n";
	foreach ($advers as $ad) {
		$contents .= "\t'".$ad['adver_id']."' => array(\r\n\t\t'adver_type' => '".$ad['adver_type']."',\r\n\t\t'adver_name' => '".addslashes($ad['adver_name'])."',\r\n\t\t'adver_url' => '".addslashes($ad['adver_url'])."',\r\n\t\t'adver_code' => '".addslashes($ad['adver_code'])."',\r\n\t\t'adver_etips' => '".addslashes($ad['adver_etips'])."',\r\n\t\t'adver_days' => '".$ad['adver_days']."',\r\n\t\t'adver_date' => '".$ad['adver_date']."'\r\n\t),\r\n";
	}
	$contents .= ");";
	unset($advers);
	
	write_cache('advers', $contents);
}

/** link cache */
function links_cache() 
{
	global $Db;
	
	$sql = "SELECT * FROM ".table('links')." WHERE link_display=1 ORDER BY link_order ASC";
	$links = $Db->query($sql);
	$contents = "\$static_data = array(\r\n";
	foreach ($links as $link) {
		$contents .= "\t'".$link['link_id']."' => array(\r\n\t\t'link_name' => '".addslashes($link['link_name'])."',\r\n\t\t'link_url' => '".addslashes($link['link_url'])."',\r\n\t\t'logo_url' => '".addslashes($link['link_logo'])."',\r\n\t),\r\n";
	}
	$contents .= ");";
	unset($links);
	
	write_cache('links', $contents);
}

/** category cache */
function categories_cache() 
{
	global $Db;
	
	$sql = "SELECT * FROM ".table('categories')." ORDER BY cate_order ASC, cate_id ASC";
	$categories = $Db->query($sql);
	$contents .= "\$static_data = array(\r\n";
	foreach ($categories as $cate) {
		$contents .= "\t'".$cate['cate_id']."' => array(\r\n\t\t'cate_id' => '".$cate['cate_id']."',\r\n\t\t'root_id' => '".$cate['root_id']."',\r\n\t\t'cate_name' => '".addslashes($cate['cate_name'])."',\r\n\t\t'cate_dir' => '".addslashes($cate['cate_dir'])."',\r\n\t\t'cate_url' => '".addslashes($cate['cate_url'])."',\r\n\t\t'cate_isbest' => '".$cate['cate_isbest']."',\r\n\t\t'cate_keywords' => '".addslashes($cate['cate_keywords'])."',\r\n\t\t'cate_description' => '".addslashes($cate['cate_description'])."',\r\n\t\t'cate_arrparentid' => '".$cate['cate_arrparentid']."',\r\n\t\t'cate_arrchildid' => '".$cate['cate_arrchildid']."',\r\n\t\t'cate_childcount' => '".$cate['cate_childcount']."',\r\n\t\t'cate_postcount' => '".$cate['cate_postcount']."'\r\n\t),\r\n";
		
		$contents_1 = "\$static_data = array(\r\n";
		$contents_1 .= "\t'cate_id' => '".$cate['cate_id']."',\r\n\t'root_id' => '".$cate['root_id']."',\r\n\t'cate_name' => '".addslashes($cate['cate_name'])."',\r\n\t'cate_dir' => '".addslashes($cate['cate_dir'])."',\r\n\t'cate_url' => '".addslashes($cate['cate_url'])."',\r\n\t'cate_isbest' => '".$cate['cate_isbest']."',\r\n\t'cate_keywords' => '".addslashes($cate['cate_keywords'])."',\r\n\t'cate_description' => '".addslashes($cate['cate_description'])."',\r\n\t'cate_arrparentid' => '".$cate['cate_arrparentid']."',\r\n\t'cate_arrchildid' => '".$cate['cate_arrchildid']."',\r\n\t'cate_childcount' => '".$cate['cate_childcount']."',\r\n\t'cate_postcount' => '".$cate['cate_postcount']."',\r\n";
		$contents_1 .= ");";
		
		write_cache('category_'.$cate['cate_id'], $contents_1);
	}
	$contents .= ");";
	unset($categories);
	
	write_cache('categories', $contents);
}


/** archives cache */
function archives_cache() 
{
	global $Db;
	
	$sql = "SELECT web_ctime FROM ".table('website')." WHERE web_status=3 ORDER BY web_ctime DESC";
	$query = $Db->query($sql);
	$archives = array();
	foreach($query as $arc) {
		$archives[] = date('Y-m', $arc['web_ctime']);
	}
	unset($arc);
	
		
	$count = array_count_values($archives);
	unset($archives);
	
	foreach ($count as $key => $val) {
		list($year, $month) = explode('-', $key);
		$archives[$year][$month] = $val;
	}
		
	$contents = "\$static_data = array(\r\n";	
	if(is_array($archives)) {        
		foreach ($archives as $year => $arr) {
			$contents .= "\t'".$year."' => array(";
			ksort($arr);
			foreach ($arr as $month => $num) {
				$contents .= "\r\n\t\t'".$month."' => '".$num."',";
			}
			$contents .= "\r\n\t),\r\n";
		}
	}
	$contents .= ");";
	unset($archives);
	
	write_cache('archives', $contents);
}

/** stats cache */
function stats_cache() 
{
	global $Db;
	
	$category = $Db->getCount(table('categories'),'*');
	$website  = $Db->getCount(table('website'),'*');
	$adver   = $Db->getCount(table('advers'),'*');
	$link     = $Db->getCount(table('links'),'*');
	$feedback = $Db->getCount(table('feedback'),'*');
	$page     = $Db->getCount(table('pages'),'*');
	
	$contents = "\$static_data = array(\r\n";
	$contents .= "\t'category' => '".$category."',\r\n";
	$contents .= "\t'website' => '".$website."',\r\n";
	$contents .= "\t'adver' => '".$adver."',\r\n";
	$contents .= "\t'link' => '".$link."',\r\n";
	$contents .= "\t'feedback' => '".$feedback."',\r\n";
	$contents .= "\t'page' => '".$page."',\r\n";
	$contents .= ");";
	
	write_cache('stats', $contents);
}
