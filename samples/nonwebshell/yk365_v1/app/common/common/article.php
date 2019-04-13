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

/**
 * 
 * 
 * @param  integer $cate_id [文章分类ID]
 * @param  integer $limit   [限制显示数量]
 * @param  boolean $is_best [是否推荐文章]
 * @param  string  $order_field   [排序字段]
 * @param  string  $order   [排序方式]
 * @return [type]           [description]
 */
function get_articles($cate_id = 0, $limit = 10, $is_best = false, $order_field = 'ctime', $order = 'desc')
{
	global $Db;
	
	$where = "a.art_status=3 AND c.cate_mod='article'";
	if (!in_array($order_field, array('views', 'ctime'))) $order_field = 'ctime';

	if ($cate_id > 0) {
		$cate = get_one_category($cate_id);
		if (!empty($cate)) $where .= " AND a.cate_id IN ('".$cate['cate_arrchildid']."')";
	}
	if ($is_best == true) $where .= " AND a.art_isbest=1";

	switch ($order_field) {
		case 'views' :
			$sortby = "a.art_views";
			break;
		case 'ctime' :
			$sortby = "a.art_ctime";
			break;
		default :
			$sortby = "a.art_ctime";
			break;
	}
	$order = strtoupper($order);
	//允许的字段
	$field= 'a.art_id, a.art_title, a.art_tags, a.art_content,a.art_intro,a.art_ispay,a.art_istop, a.art_isbest, a.art_views, a.art_ctime,a.art_utime, c.cate_id, c.cate_mod, c.cate_name, c.cate_dir';

	$sql = "SELECT $field FROM ".table('articles')." a LEFT JOIN ".table('categories')." c ON a.cate_id=c.cate_id WHERE $where ORDER BY $sortby $order LIMIT $limit";

	$query   = $Db->query($sql);
	$results = array();
	foreach($query as $row){
		$row['art_link'] =  url('artinfo',['aid'=>$row['art_id']]);
		$row['art_tags'] =  get_format_tags($row['art_tags']);
		$row['art_ctime'] = date('Y-m-d', $row['art_ctime']);
		$row['art_utime'] = date('Y-m-d', $row['art_utime']);
		$row['cate_link'] = url($row['cate_mod'],['cid'=>$row['cate_id']]);
		$results[] = $row;
	}

	return $results;
}

/**
 * [get_article_list 获得文章列表]
 * @param  string  $where    [筛选条件]
 * @param  string  $order_field    [排序字段]
 * @param  string  $order    [description]
 * @param  integer $start    [description]
 * @param  integer $pagesize [description]
 * @return [type]            [description]
 */
function get_article_list($where = '',$order_field = 'ctime',$order = 'DESC',$start = 0,$pagesize = 10)
{
	global $Db;

	if(!empty($where)){
       $where =" WHERE $where";
	}
	if (!in_array($order_field, array('views', 'ctime'))) $order_field = 'ctime';
	switch ($order_field) {
		case 'views' :
			$sortby = "a.art_views";
			break;
		case 'ctime' :
			$sortby = "a.art_ctime";
			break;
		default :
			$sortby = "a.art_ctime";
			break;
	}
	$order = strtoupper($order);
	//允许的字段
	$field = 'a.user_id,a.art_id, a.art_title,a.art_content,a.art_tags, a.art_intro, a.art_views, a.art_ispay,a.art_istop, a.art_isbest, a.art_status, a.art_ctime, c.cate_id, c.cate_name';

	$sql = "SELECT $field FROM ".table('articles')." a LEFT JOIN ".table('categories')." c ON a.cate_id=c.cate_id  $where ORDER BY a.art_istop DESC, $sortby $order LIMIT $start, $pagesize";
	
	$query = $Db->query($sql);
	$results = array();
	foreach($query as $row){
		switch ($row['art_status']) {
			case 1 :
				$art_status = '<font color="#333333">草稿</font>';
				break;
			case 2 :
				$art_status = '<font color="#ff3300">待审核</font>';
				break;
			case 3 :
				$art_status = '<font color="#008800">已审核</font>';
				break;
		}
		$art_istop = $row['art_istop'] > 0 ? '<font color="#ff0000">置顶</font>' : '<font color="#cccccc">置顶</font>';
		$art_isbest = $row['art_isbest'] > 0 ? '<font color="#ff3300">推荐</font>' : '<font color="#cccccc">推荐</font>';
        $art_ispay = $row['art_ispay'] > 0 ? '<font color="#ff3300">付费</font>' : '<font color="#cccccc">付费</font>';
		$row['art_attr']  =  $art_istop.' - '.$art_isbest.' - '.$art_ispay.' - '.$art_status;
		$row['art_link']  =  url('artinfo',['aid'=>$row['art_id']]);
		$row['art_ctime'] =  $row['art_ctime'];
		$row['art_utime'] = isset($row['art_utime'])?date('Y-m-d', $row['art_utime']):'';
		$results[] = $row;

		
	}
		
	return $results;
}
	
/**
 * [get_one_article 获得一篇文章]
 * @param  integer $where  [筛选条件]
 * @return [array]         [返回数组数据]
 */
function get_one_article($where = 1)
{
	global $Db;
	$field = 'a.user_id, a.cate_id, a.art_id, a.art_title, a.art_tags, a.copy_from, a.copy_url, a.art_intro, a.art_content, a.art_views,a.art_ispay, a.art_istop, a.art_isbest, a.art_status, a.art_ctime, a.art_utime, c.cate_id, c.cate_name';

	$sql  = "SELECT $field FROM ".table('articles')." a LEFT JOIN ".table('categories')." c ON a.cate_id=c.cate_id WHERE $where LIMIT 1";
	$row = $Db->query($sql,'Row');
	
	return $row;
}

/**
 * [get_prev_article 上一页文章]
 * @param  integer $aid [文章ID]
 * @return [array]       [返回数组数据]
 */
function get_prev_article($aid = 0)
{
	global $Db;
	
	$field = 'art_id, art_title';
	$row = $Db->query("SELECT $field FROM ".table('articles')." WHERE art_status = 3 AND art_id < $aid ORDER BY art_id DESC LIMIT 1",'Row');

	if (!empty($row)) {
		$row['art_link'] = url('artinfo',['aid'=>$row['art_id']]);
	}
	
	return $row;
}

/**
 * [get_next_article 下一页文章]
 * @param  integer $aid [文章ID]
 * @return [array]       [返回数组数据]
 */
function get_next_article($aid = 0) 
{
	global $Db;
	
	$field = 'art_id, art_title';
	$row = $Db->query("SELECT $field FROM ".table('articles')." WHERE art_status=3 AND art_id > $aid ORDER BY art_id ASC LIMIT 1",'Row');
	if (!empty($row)) {
		$row['art_link'] = url('artinfo',['aid'=>$row['art_id']]);
	}
	return $row;
}


	
/** sitemap */
function get_article_sitemap($cate_id = 0) 
{
	global $Db, $options;
	
	$where = "art_status=3";
	$cate = get_one_category($cate_id);
	if (!empty($cate)) {
		if ($cate['cate_childcount'] > 0) {
			$where .= " AND cate_id IN (".$cate['cate_arrchildid'].")";
		} else {
			$where .= " AND cate_id=$cate_id";
		}
	}

	$sql = "SELECT art_id, art_ctime FROM ".table('articles');
	$sql .= " WHERE $where ORDER BY art_id DESC LIMIT 50";
	$query = $Db->query($sql);
	$results = array();
	foreach($query as $row){
		$row['art_link'] = url('artinfo',['aid'=>$row['art_id']],$options['site_url']);
		$row['art_ctime'] = date('Y-m-d H:i:s', $row['art_ctime']);
		$results[] = $row;
	}
	unset($row);
	
	
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
	foreach ($results as $row) {
		$prior = 0.5;
		
		if (datediff('h', $row['art_ctime']) < 24) {
			$freq = "hourly";
			$prior = 0.8;
		} elseif (datediff('d', $row['art_ctime']) < 7) {
			$freq = "daily";
			$prior = 0.7;
		} elseif (datediff('w', $row['art_ctime']) < 4) {
			$freq = "weekly";
		} elseif (datediff('m', $row['art_ctime']) < 12) {
			$freq = "monthly";
		} else {
			$freq = "yearly";
		}
		
		echo "<url>\n";
		echo "<loc>".$row['art_link']."</loc>\n";
		echo "<lastmod>".iso8601('Y-m-d\TH:i:s\Z', $row['art_ctime'])."</lastmod>\n";
		echo "<changefreq>".$freq."</changefreq>\n";
		if ($prior != 0.5) {
			echo "<priority>".$prior."</priority>\n";
		}
		echo "</url>\n";
	}
	echo "</urlset>";
	
	unset($options, $results);
}

/** sodir api */
function get_article_api($cate_id = 0, $start = 0, $pagesize = 0) 
{
	global $Db, $options;
		
	$where = "a.art_status=3 AND c.cate_mod='article'";
	$cate = get_one_category($cate_id);
	if (!empty($cate)) {
		if ($cate['cate_childcount'] > 0) {
			$where .= " AND a.cate_id IN (".$cate['cate_arrchildid'].")";
		} else {
			$where .= " AND a.cate_id=$cate_id";
		}
	}

	$sql = "SELECT a.art_id, a.cate_id, a.art_title, a.art_tags, a.art_intro, a.art_content, a.art_views, a.art_ctime, c.cate_name FROM ".table('articles')." a LEFT JOIN ".table('categories')." c ON a.cate_id=c.cate_id";
	$sql .= " WHERE $where ORDER BY a.art_id DESC LIMIT $start, $pagesize";
	$query = $Db->query($sql);
	$results = array();
	foreach($query as $row){
		$row['art_link'] = url('artinfo',['aid'=>$row['art_id']]);;
		$row['art_intro'] = htmlspecialchars(strip_tags($row['art_intro']));
		$row['art_ctime'] = date('Y-m-d H:i:s', $row['art_ctime']);
		$results[] = $row;
	}
	unset($row);
	
	
	$total = $Db->getCount(table('articles').' a','*',$where);
	
	header("Content-Type: application/xml;");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
	echo "<total>".$total."</total>";
	
	foreach ($posts as $row) {
		echo "<url>\n";
		echo "<name>".$row['art_title']."</name>\n";
		echo "<link>".$row['art_link']."</link>\n";
		echo "<tags>".$row['art_tags']."</tags>\n";
		echo "<desc>".$row['art_intro']."</desc>\n";
		echo "<content><!--CDATA[".$row['art_content']."]--></desc>\n";
		echo "<cate>".$row['cate_name']."</cate>\n";
		echo "<time>".$row['art_ctime']."</time>\n";		
		echo "</url>\n";
	}
	echo "</urlset>\n";
	
	unset($options, $results);
}
