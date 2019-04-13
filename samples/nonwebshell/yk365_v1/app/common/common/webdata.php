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
/** 获取META信息 */
function get_sitemeta($url)
{
	 $data = get_url_content($url);
	
	$meta = array();
	if (!empty($data)) {
		#Title
		preg_match('/<TITLE>([\w\W]*?)<\/TITLE>/si', $data, $matches);
		if (!empty($matches[1])) {
			$meta['title'] = $matches[1];
		}
		
		#Keywords
		preg_match('/<META\s+name="keywords"\s+content="([\w\W]*?)"/si', $data, $matches);		
		if (empty($matches[1])) {
			preg_match("/<META\s+name='keywords'\s+content='([\w\W]*?)'/si", $data, $matches);			
		}
		if (empty($matches[1])) {
			preg_match('/<META\s+content="([\w\W]*?)"\s+name="keywords"/si', $data, $matches);			
		}
		if (empty($matches[1])) {
			preg_match('/<META\s+http-equiv="keywords"\s+content="([\w\W]*?)"/si', $data, $matches);			
		}
		if (!empty($matches[1])) {
			$meta['keywords'] = $matches[1];
		}
		
		#Description
		preg_match('/<META\s+name="description"\s+content="([\w\W]*?)"/si', $data, $matches);		
		if (empty($matches[1])) {
			preg_match("/<META\s+name='description'\s+content='([\w\W]*?)'/si", $data, $matches);			
		}
		if (empty($matches[1])) {
			preg_match('/<META\s+content="([\w\W]*?)"\s+name="description"/si', $data, $matches);					
		}
		if (empty($matches[1])) {
			preg_match('/<META\s+http-equiv="description"\s+content="([\w\W]*?)"/si', $data, $matches);			
		}
		if (!empty($matches[1])) {
			$meta['description'] = $matches[1];
		}
	}
    
	return $meta; 
}

/** Server IP */
function get_serverip($url)
{
	$domain = get_domain($url);
	if ($domain) {
		$ip = gethostbyname($domain);
	} else {
		$ip = 0;
	}
	
	return $ip;
}

/** Google Pagerank */
function get_pagerank($url)
{
	require(CORE_PATH.'include/pagerank.php');
	
	$pr = new PageRank();
	$rank = $pr->getGPR($url);
	return $rank;
}

/** Baidu Pagerank */
function get_baidurank($url)
{
	  $data= get_url_content('http://seo.chinaz.com/?q='.$url);
      preg_match_all('/<p class="ReLImgCenter"><span>百度权重：<\/span>(.*)<img src="(.*)" \/><\/a><\/p>(.*)/',$data,$arr);
        $num = strripos($arr[2][0],'.gif');

        $rank = substr($arr[2][0],$num-1,1);
         if(isset($rank)){
           return  $rank;  //返回权重值
         }else{
          return  "0";
        }
}

/** Sogou Pagerank */
function get_sogourank($url)
{
	$data = get_url_content("http://rank.ie.sogou.com/sogourank.php?ur=http://$url");
	if (preg_match('/sogourank=(\d+)/i', $data, $matches)) {
		$rank = intval($matches[1]);
	} else {
		$rank = 0;
	}
	return $rank;
}

/*获取网站360权重*/
function get_r360($url)
{
   //360r  
    $R360 = "http://seo.chinaz.com/ajaxseo.aspx?t=360rank&callback=jQuery1113045199355007779163_1547540597383".$url;
    $site =curl_request($R360,['host'=>$url]);
    preg_match("/:\"(\d)\"/iUs",$site,$arr);
   
  
    return $arr[1];
}

/** Alexa Rank */
function get_alexarank($url)
{
	$data = get_url_content("http://xml.alexa.com/data?cli=10&dat=nsa&ver=quirk-searchstatus&url=$url");
	if (preg_match('/<POPULARITY[^>]*URL[^>]*TEXT[^>]*\"([0-9]+)\"/i', $data, $matches)) {
		$rank = strip_tags($matches[1]);
	} else {
		$rank = 0;
	}
	return $rank;
}
