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


$tempfile = 'index.html';

//实现跳转PC端
$visit = I('get.visit');
if($visit == 'pc'){
  session('visit_type','pc',24*3600); //一天有效时间
  redirect(url('home/index'));	
}


if (!$Youke->isCached($tempfile)) {

	$Youke->assign('site_title', $options['site_title']);
	$Youke->assign('site_keywords', $options['site_keywords']);
	$Youke->assign('site_description', $options['site_description']);

}

Youke_display($tempfile);