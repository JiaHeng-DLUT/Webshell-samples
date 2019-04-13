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
function Youke_display($template, $cache_id = NULL, $compile_id = NULL) {
	global $Youke, $action, $fileurl, $pagetitle;
	
	template_exists($template);
	
	$Youke->assign('action', $action);
	$Youke->assign('fileurl', $fileurl);
	$Youke->assign('pagetitle', $pagetitle);
	$Youke->display($template, $cache_id, $compile_id);
}

