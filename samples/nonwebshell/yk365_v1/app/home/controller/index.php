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
$tempfile = 'index.html';
$table    = table('webdata');



if (!$Youke->isCached($tempfile)) {
//入站数据更新
$url = !empty($_SERVER["HTTP_REFERER"])?trim($_SERVER["HTTP_REFERER"],'/'):'';
if(!empty($url)){
	 $url = get_root_domain($url);
	 // 检查时哪一个站点
	$where = "a.web_url like '%$url%'";
	$website = get_one_website($where);
    if(!empty($website)){
      //更新入站数据
	 $Db->query("UPDATE $table SET web_instat=web_instat+1 WHERE web_id=".$website['web_id']);	
    }
	
		
}

	$Youke->assign('site_title', $options['site_title']);
	$Youke->assign('site_keywords', $options['site_keywords']);
	$Youke->assign('site_description', $options['site_description']);

}


Youke_display($tempfile);