<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2010-1001 koyshe <koyshe@gmail.com>
 */
//####################// 万能文本缓存类-20111128-koyshe //####################//
class cache { 
	public static $cache_list = array();
	/**
	 * 解析名称/路径
	 *
	 * @param string $cachename 缓存文件名
	 */
	public static function cache_arr($cachename)
	{
		global $pe;
		$cache_arr = explode('/', $cachename);
		if (count($cache_arr) > 1) {
			$cache_path = "{$cache_arr[0]}/";
			$cache_name = $cache_arr[1];
		}
		else {
			$cache_path = "";
			$cache_name = $cache_arr[0];		
		}
		$result['name'] = $cache_name;
		$result['path'] = "{$pe['path_root']}data/cache/{$cache_path}{$cache_name}.cache.php";
		return $result;
	}
	/**
	 * 读取相应缓存文件
	 *
	 * @param string $cachename
	 */
	public static function get($cachename)
	{		
		if (!array_key_exists($cachename, self::$cache_list)) {
			$cache_arr = self::cache_arr($cachename);
			$cache_list[$cachename] = include($cache_arr['path']);
		}
		return $cache_list[$cachename];
	}
	/**
	 * 生成相应缓存文件
	 *
	 * @param string $cachename 缓存文件名
	 * @param string $index_arr 缓存索引 or 带索引的自定义数组
	 */
	public static function write($cachename, $index_arr = '')
	{
		if (is_array($index_arr)) {
			self::write_diy($cachename, $index_arr, 0);	
		}
		else {
			self::write_default($cachename, $index_arr, 0);		
		}
	}
	/**
	 * 生成通用缓存操作
	 *
	 * @param string $cachename 缓存文件名
	 * @param string $index 缓存索引
	 * @param int $js 是否同时生成js缓存
	 */
	public static function write_default($cachename, $index, $js)
	{
		global $pe, $db;
		$cache_arr = self::cache_arr($cachename);
		$info_list = $db->pe_selectall($cache_arr['name']);
		$data_list = array();
		//默认是主键为索引
		if (!$index) {
			foreach ($info_list as $v) {
				$data_list[$v["{$cache_arr['name']}_id"]] = $v;
			}
		}
		//自定义索引
		elseif ($index && stripos($index, '|') === false) {
			foreach ($info_list as $v) {
				$data_list[$v[$index]] = $v;
			}
		}
		//父子二级索引(最多只支持二级索引)
		elseif ($index && stripos($index, '|') !== false) {
			$indexarr = explode('|', $index);
			foreach ($info_list as $v) {
				$data_list[$v[$indexarr[0]]][$v[$indexarr[1]]] = $v;
			}
		}
		self::write_diy($cachename, $data_list, 0);
		if ($js == 1) {
			$cache = "var {$cachename}=".json_encode($data_list);
			file_put_contents(str_ireplace('.php', '.js', $cache_arr['path']), $cache);
		}
	}
	/**
	 * 生成自定义缓存操作
	 *
	 * @param string $cachename 缓存文件名
	 * @param string $data      缓存数据
	 * @param int    $js        是否生成js缓存
	 */
	public static function write_diy($cachename, $data, $js)
	{
		$cache_arr = self::cache_arr($cachename);
		$cache = "<?php".PHP_EOL."return unserialize('".addcslashes(serialize($data), "\\\'")."');".PHP_EOL."?>";
		/*$cache = "<?php\n\r\$cache=unserialize(stripslashes('".addslashes(serialize($index_arr))."'));\n\r?>";*/
		file_put_contents($cache_arr['path'], $cache);	
	}
}
?>