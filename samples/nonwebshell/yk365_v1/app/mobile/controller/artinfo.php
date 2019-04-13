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


   $tempfile = 'artinfo.html';
   $table = table('articles');
   $aid = I('get.id','','addslashes');

if (!$Youke->isCached($tempfile)) {

 // 获取单个文章信息
   $where = "a.art_id = $aid";
   $info = get_one_article($where);  
   $Youke->assign('info',$info);
   $Db->query("UPDATE $table SET art_views= art_views+1 WHERE art_id=".$aid." LIMIT 1");
	$Youke->assign('site_title', $options['site_title']);
	$Youke->assign('site_keywords', $options['site_keywords']);
	$Youke->assign('site_description', $options['site_description']);


}
Youke_display($tempfile,$aid);
