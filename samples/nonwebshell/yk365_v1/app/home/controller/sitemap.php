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

$cate_id =  I('get.cid',0,'intval');


	
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
	$sql .= " WHERE $where ORDER BY web_id DESC LIMIT 10000";
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

	
	unset($website);


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
	$sql .= " WHERE $where ORDER BY art_id DESC LIMIT 10000";
	$query = $Db->query($sql);
	$results = array();
	foreach($query as $row){
		$row['art_link'] = url('artinfo',['aid'=>$row['art_id']],$options['site_url']);
		$row['art_ctime'] = date('Y-m-d H:i:s', $row['art_ctime']);
		$results[] = $row;
	}
	unset($row);
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
