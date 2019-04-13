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
//采集接口
header('Content-type:text/json');  //json输出

$type = I('get.type'); //请求类型

if ($type == 'get_meta') {
	 $url = I('get.url');
	if (empty($url)) {
		echo error_json('请输入网址');
		exit;
	} else {
		if (!is_valid_domain($url)) {
			echo error_json('域名格式错误');
			exit;
		}
	}

	$meta = get_sitemeta($url);	
	echo success_json('采集成功',$meta);
	exit;
}elseif ($type == 'data') {
	 $url =I('get.url');
	if (empty($url)) {
		echo error_json('请输入网址');
		exit;
	} else {
		if (!is_valid_domain($url)) {
			echo error_json('域名格式错误');
			exit;
		}
	}
	$url  = str_replace('http://','',$url);
	$url  = str_replace('https://','',$url);	
	$data['ip']   = get_serverip($url);
	$data['r360']  = get_r360($url);
	$data['brank'] = get_baidurank($url);
	$data['srank'] = get_sogourank($url);
	$data['arank'] = get_alexarank($url);
	echo success_json('采集成功',$data);
	exit;
}elseif ($type == 'check') {
	$url = I('get.url');
	if (empty($url)) {
		echo error_json('请输入网址');
		exit;
	} else {
		if (!is_valid_domain($url)) {
			echo error_json('域名格式错误');
			exit;
		}
	}
			
	$query = $Db->query("SELECT web_id FROM ".table('website')." WHERE web_url='$url'");
	if (count($query)) {

		echo error_json('该域名已存在，请勿重复提交');
			exit;
	} 
	echo success_json('成功');
	exit;


}elseif ($type == 'category') {

	$key = !empty($_GET['key'])?urldecode($_GET['key']):0;
	$ids = explode(',', $key);
	$cid = array_pop($ids);
	$cid = intval($cid);
		
	 $sql = "SELECT cate_id, cate_name FROM ".table('categories')." WHERE root_id='$cid' and cate_mod ='webdir' ORDER BY cate_id ASC";
	$categories = $Db->query($sql);
	if (!empty($categories) && is_array($categories)) {
		$temp = array();
		foreach ($categories as $row) {
			$temp[$row['cate_id']]	= $row['cate_name'];
		}
		unset($categories);
		
		echo json_encode($temp);
		exit;
	}
}else{
	echo error_json('非法请求');
	exit;
}
