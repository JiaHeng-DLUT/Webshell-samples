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
/** website list */
function get_websites($cate_id = 0, $top_num = 10, $is_best = false, $field = 'ctime', $order = 'desc') 
{
	global $Db;
	
	$where = 'w.web_status=3';
	if (!in_array($field, array('grank','r360', 'brank', 'srank', 'arank', 'instat', 'outstat', 'views','utime', 'ctime'))) $field = 'ctime';
	if ($cate_id > 0) {
		$cate = get_one_category($cate_id);
		if (!empty($cate)) $where .= " AND w.cate_id IN (".$cate['cate_arrchildid'].")";
	}
	if ($is_best == true) $where .= " AND w.web_isbest=1";
	switch ($field) {
		case 'grank' :
			$sortby = "d.web_grank";
			break;
		case 'r360' :
			$sortby = "d.web_r360";
		break;
		case 'brank' :
			$sortby = "d.web_brank";
			break;
		case 'srank' :
			$sortby = "d.web_srank";
			break;
		case 'arank' :
			$sortby = "d.web_arank";
			break;
		case 'instat' :
			$sortby = "d.web_itime";
			break;
		case 'outstat' :
			$sortby = "d.web_otime";
			break;
		case 'views' :
			$sortby = "d.web_views";
			break;
		case 'utime' :
			$sortby = "d.web_utime";
			break;
		case 'ctime' :
			$sortby = "w.web_ctime";
			break;
		default :
			$sortby = "w.web_ctime";
			break;
	}
	$order = strtoupper($order);
	
$sql = "SELECT w.web_id, w.web_name, w.web_ico, w.web_url,w.web_pic,w.web_intro, w.web_ctime, c.cate_id, c.cate_name,d.web_r360, d.web_grank,  d.web_brank, d.web_srank, d.web_arank, d.web_instat, d.web_outstat, d.web_views 
FROM ".table('website')." w LEFT JOIN ".table('categories')." c ON w.cate_id=c.cate_id LEFT JOIN ".table('webdata')." d ON w.web_id=d.web_id WHERE $where ORDER BY $sortby $order LIMIT $top_num";
	$query = $Db->query($sql);
	$website = array();
	foreach($query as $web){
		$web['web_pic'] = get_webthumb($web['web_url']);
		$web['web_url'] =  $web['web_url'];
		$web['web_link'] = url('siteinfo',['wid'=>$web['web_id']]);
		$web['web_tags'] = isset($web['web_tags'])?get_format_tags($web['web_tags']):'';
		$web['web_ctime'] = date('Y-m-d', $web['web_ctime']);
		$web['cate_link'] = url('webdir',['cid'=>$web['cate_id']]);;
		$website[] = $web;
	}
	unset($web);
	
	
	return $website;
}

/** website list */
function get_website_list($where ='', $field = 'ctime', $order = 'DESC', $start = 0, $pagesize = 10) 
{
	global $Db;
	if(!empty($where)){
       $where =" WHERE $where";
	}
	if (!in_array($field, array( 'r360','brank', 'srank', 'arank', 'instat', 'outstat', 'views', 'utime','ctime'))) $field = 'ctime';
	switch ($field) {

		case 'r360' :
			$sortby = "d.web_r360";
			break;
		case 'brank' :
			$sortby = "d.web_brank";
			break;
		case 'srank' :
			$sortby = "d.web_srank";
			break;
		case 'arank' :
			$sortby = "d.web_arank";
			break;
		case 'instat' :
			$sortby = "d.web_instat";
			break;
		case 'outstat' :
			$sortby = "d.web_outstat";
			break;
		case 'views' :
			$sortby = "d.web_views";
			break;
		case 'utime' :
			$sortby = "d.web_utime";
			break;
		case 'ctime' :
			$sortby = "w.web_ctime";
			break;
		default :
			$sortby = "w.web_ctime";
			break;
	}
	$order = strtoupper($order);
	if($sortby){

	}
  $sql = "SELECT w.web_id, w.web_name,w.web_ico,w.web_istop,w.web_isbest,w.web_ispay,w.web_url,w.web_pic,w.web_intro, w.web_status,w.web_ctime, c.cate_name, d.web_ip, d.web_grank,d.web_r360, d.web_brank, d.web_srank, d.web_arank, d.web_instat, d.web_outstat, d.web_views, d.web_utime FROM "
	.table('website')." w LEFT JOIN ".table('categories')." c ON w.cate_id=c.cate_id LEFT JOIN ".table('webdata')." d ON w.web_id=d.web_id $where ORDER BY  $sortby $order LIMIT $start, $pagesize";
	$query = $Db->query($sql);
	$website = array();
	
	foreach($query as $web){
		switch ($web['web_status']) {
			case 1 :
				$status = '黑名单';
				break;
			case 2 :
				$status = '待审核';
				break;
			case 3 :
				$status = '已审核';
				break;
		}
	   
		$web['web_pic']  =   get_webthumb($web['web_url']);
		$web['web_url']  =   $web['web_url'];
		$web['web_link'] =   url('siteinfo',['wid'=>$web['web_id']]);
		$web['web_status'] = $status;
		$web['web_ctime']  =  date('Y-m-d', $web['web_ctime']);
		$web['web_utime']  = date('Y-m-d', $web['web_utime']);
		$website[] = $web;
	}
	unset($web);
	
		
	return $website;
}
	
/** one website */
function get_one_website($where = 1) 
{
	global $Db;
	 $sql = "SELECT a.user_id, a.cate_id, a.web_id, a.web_name,a.web_ico, a.web_url,a.web_pic,a.web_pic, a.web_tags, a.web_intro,a.web_ispay,a.web_istop, a.web_isbest, a.web_status, a.web_ctime, b.web_ip, b.web_grank,b.web_r360,b.web_brank, b.web_srank, b.web_arank, b.web_instat, b.web_outstat, b.web_views, b.web_utime FROM ".table('website')." a LEFT JOIN ".table("webdata")." b ON a.web_id=b.web_id WHERE $where LIMIT 1";
	$web = $Db->query($sql,'Row');
	
	return $web;
}

/** rssfeed */
function get_website_rssfeed($cate_id = 0) 
{
	global $Db, $options;
		
	$where = "w.web_status=3";
	$cate = get_one_category($cate_id);
	if (!empty($cate)) $where .= " AND c.cate_id IN (".$cate['cate_arrchildid'].")";

	$sql = "SELECT w.web_id, w.cate_id, w.web_name, a.web_ico, w.web_url, w.web_intro, w.web_ctime, c.cate_name FROM ".table('website')." w LEFT JOIN ".table('categories')." c ON w.cate_id=c.cate_id";
	$sql .= " WHERE $where ORDER BY w.web_id DESC LIMIT 50";
	$query = $Db->query($sql);
	$website = array();
	foreach($query as $web){
		$web['web_link'] = url('siteinfo',['wid'=>$web['web_id']]);
		$web['web_intro'] = htmlspecialchars(strip_tags($web['web_intro']));
		$web['web_ctime'] = date('Y-m-d H:i:s', $web['web_ctime']);
		$website[] = $web;
	}
	unset($web);
	
		
	header("Content-Type: application/xml;");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	echo "<rss version=\"2.0\">\n";
	echo "<channel>\n";
	echo "<title>".$options['site_name']."</title>\n";
	echo "<link>".$options['site_url']."</link>\n";
	echo "<description>".$options['site_description']."</description>\n";
	echo "<language>zh-cn</language>\n";
	echo "<copyright><!--CDATA[".$options['site_copyright']."]--></copyright>\n";
	echo "<webmaster>".$options['site_name']."</webmaster>\n";
	echo "<generator>".$options['site_name']."</generator>\n";
	echo "<image>\n";
	echo "<title>".$options['site_name']."</title>\n";
	echo "<url>".$options['site_url']."logo.gif</url>\n";
	echo "<link>".$options['site_url']."</link>\n";
	echo "<description>".$options['site_description']."</description>\n";
	echo "</image>\n";
	
	foreach ($website as $web) {
		echo "<item>\n";
		echo "<link>".$web['web_link']."</link>\n";
		echo "<title>".$web['web_name']."</title>\n";
		echo "<author>".$options['site_name']."</author>\n";
		echo "<category>".$web['cate_name']."</category>\n";
		echo "<pubDate>".$web['web_ctime']."</pubDate>\n";
		echo "<guid>".$web['web_link']."</guid>\n";
		echo "<description>".$web['web_intro']."</description>\n";
		echo "</item>\n";
	}
	echo "</channel>\n";
	echo "</rss>";
	
	unset($options, $website);
}
	
/** sitemap */
function get_website_sitemap($cate_id = 0) 
{
	global $Db, $options;
	
	$where = "web_status=3";
	$cate = get_one_category($cate_id);
	if (!empty($cate)) {
		if ($cate['cate_childcount'] > 0) {
			$where .= " AND cate_id IN (".$cate['cate_arrchildid'].")";
		} else {
			$where .= " AND cate_id=$cate_id";
		}
	}

	$sql = "SELECT web_id, web_url, web_ctime FROM ".table('website');
	$sql .= " WHERE $where ORDER BY web_id DESC LIMIT 250";
	$query = $Db->query($sql);
	$website = array();
	foreach($query as $web){
		$web['web_link'] = url('siteinfo',['wid'=>$web['web_id']],$options['site_url']);
		$web['web_ctime'] = date('Y-m-d H:i:s', $web['web_ctime']);
		$website[] = $web;
	}
	unset($web);
	
	
	header("Content-Type: application/xml;");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
	echo "<url>\n";
	echo "<loc>".$options['site_url']."</loc>\n";
	echo "<lastmod>".iso8601('Y-m-d\TH:i:s\Z')."</lastmod>\n";
	echo "<changefreq>always</changefreq>\n";
	echo "<priority>0.9</priority>\n";
	echo "</url>\n";
	
	$now = time();
	foreach ($website as $web) {
		$prior = 0.5;
		
		if (datediff('h', $web['web_ctime']) < 24) {
			$freq = "hourly";
			$prior = 0.8;
		} elseif (datediff('d', $web['web_ctime']) < 7) {
			$freq = "daily";
			$prior = 0.7;
		} elseif (datediff('w', $web['web_ctime']) < 4) {
			$freq = "weekly";
		} elseif (datediff('m', $web['web_ctime']) < 12) {
			$freq = "monthly";
		} else {
			$freq = "yearly";
		}
		
		echo "<url>\n";
		echo "<loc>".$web['web_link']."</loc>\n";
		echo "<lastmod>".iso8601('Y-m-d\TH:i:s\Z', $web['web_ctime'])."</lastmod>\n";
		echo "<changefreq>".$freq."</changefreq>\n";
		if ($prior != 0.5) {
			echo "<priority>".$prior."</priority>\n";
		}
		echo "</url>\n";
	}
	echo "</urlset>";
	
	unset($options, $website);
}

/** sodir api */
function get_website_api($cate_id = 0, $start = 0, $pagesize = 0) 
{
	global $Db, $options;
		
	$where = "w.web_status=3";
	$cate = get_one_category($cate_id);
	if (!empty($cate)) {
		if ($cate['cate_childcount'] > 0) {
			$where .= " AND w.cate_id IN (".$cate['cate_arrchildid'].")";
		} else {
			$where .= " AND w.cate_id=$cate_id";
		}
	}

	$sql = "SELECT w.web_id, w.cate_id, w.web_name, w.web_url, w.web_tags, w.web_intro, w.web_ctime, c.cate_name FROM ".table('website')." w LEFT JOIN ".table('categories')." c ON w.cate_id=c.cate_id";
	$sql .= " WHERE $where ORDER BY w.web_id DESC LIMIT $start, $pagesize";
	$query = $Db->query($sql);
	$website = array();
	foreach($query as $web){
		$web['web_link'] =  url('siteinfo',['wid'=>$web['web_id']]);
		$web['web_intro'] = htmlspecialchars(strip_tags($web['web_intro']));
		$web['web_ctime'] = date('Y-m-d H:i:s', $web['web_ctime']);
		$website[] = $web;
	}
	unset($web);
	
	
	$total = $Db->getCount(table('website').' w','*',$where);
	
	header("Content-Type: application/xml;");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	echo "<urlset xmlns=\"http://www.sodir.org/sitemap/\">\n";
	echo "<total>".$total."</total>";
	
	foreach ($website as $web) {
		echo "<url>\n";
		echo "<name>".$web['web_name']."</name>\n";
		echo "<link>".$web['web_link']."</link>\n";
		echo "<tags>".$web['web_tags']."</tags>\n";
		echo "<desc>".$web['web_intro']."</desc>\n";
		echo "<cate>".$web['cate_name']."</cate>\n";
		echo "<time>".$web['web_ctime']."</time>\n";		
		echo "</url>\n";
	}
	echo "</urlset>\n";
	
	unset($options, $website);
}

/** archives */
function get_archives() 
{
	global $Db;
	
	$archives = array();
	if (load_cache('archives')) {
		$archives = load_cache('archives');
	} else {
		$time = array();
		$sql = "SELECT web_ctime FROM ".table('website')." WHERE web_status=3 ORDER BY web_ctime DESC";
		$query = $Db->query($sql);
		foreach($query as $row){
			$time[] = date('Y-m', $row['web_ctime']);
		}
		unset($row);
		
		
		$count = array_count_values($time);
		unset($time);
		
		foreach ($count as $key => $val) {
			list($year, $month) = explode('-', $key);
			$archives[$year][$month] = $val;
		}
	}
		
	$newarr = array();
	foreach ($archives as $year => $arr) {
		foreach ($arr as $month => $count) {
			$newarr[$year][$month]['site_count'] = $count;
			$newarr[$year][$month]['arc_link'] = url('archives',['date'=>$year.$month]);
		}
	}
	unset($archives);
	
	return $newarr;
}

/** rss  */
function iso8601($format, $timestamp = NULL) 
{
	if ($timestamp === NULL) {
		$timestamp = time() - date('Z');
	} elseif ($timestamp <= 0) {
		return '';
	}
	$timestamp += (8 * 3600);
	
	return gmdate($format, time());
}

function getTop($limit=10)
{
 	global $Db;
 	if(!empty($limit)){
     $limit = "limit $limit";
 	}
 	$sql = "SELECT w.web_id, w.cate_id, w.web_name, w.web_url, w.web_tags,w.web_pic, w.web_intro, w.web_ctime, w.web_utime, c.cate_name FROM ".table('website')." w LEFT JOIN ".table('categories')." c ON w.cate_id=c.cate_id where w.web_istop =1 ORDER BY w.web_utime DESC $limit";

	$query = $Db->query($sql);


	$website = array();
	foreach($query as $web){
		$web['web_pic']   = get_webthumb($web['web_url']);
		$web['web_url']   =  $web['web_url'];
		$web['web_tags']  = get_format_tags($web['web_tags']);
		$web['web_ctime'] = date('Y-m-d', $web['web_ctime']);
		$web['cate_link'] = url('webdir',['cid'=>$web['cate_id']]);
		$web['web_link']  =   url('siteinfo',['wid'=>$web['web_id']]);
		$website[] = $web;
	}

	return $website;
}
