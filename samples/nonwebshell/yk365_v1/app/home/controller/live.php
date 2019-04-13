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
$tempfile = 'live.html';

$id = I('get.id','','intval');
if(!empty($id)){
// 获得电视频道
$where = "a.id = ".$id;
    $liveInfo = get_one_live($where);	
}else{
	$liveInfo =get_live_list('','ctime','DESC',0,1)[0];
}


// 获得所有分类
$cate = get_categories_rid('live');

foreach($cate as $k=>$v){
	$cate_id = $v['cate_id'];
	$where = "a.cate_id = '$cate_id' ";
    $live = get_live_list($where,'ctime','DESC', 0,1000);
    $cate[$k]['children'] = $live;
}

$Youke->assign('cate',$cate);
$Youke->assign('liveInfo',$liveInfo);
if (!$Youke->isCached($tempfile)) {

	$Youke->assign('site_title', $options['site_title']);
	$Youke->assign('site_keywords', $options['site_keywords']);
	$Youke->assign('site_description', $options['site_description']);
    
}
Youke_display($tempfile);