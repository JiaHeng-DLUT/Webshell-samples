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

function Youke_display($template, $cache_id = NULL, $compile_id = NULL) {
	global $Youke, $options;
	
	template_exists($template);
	
	// common
	$options = stripslashes_deep($options);
	$stats = get_stats();

   $search_words = get_format_tags($options['search_words']);
    if(!isset($search_words)){
       $search_words ='';
    }
    $Youke->assign('search_words',$search_words);
	$Youke->assign('site_root', $options['site_root']);
	$Youke->assign('site_name', $options['site_name']);
	$Youke->assign('site_url', $options['site_url']);
	$Youke->assign('site_copyright', $options['site_copyright']);

	$Youke->assign('cfg', $options); 
	$Youke->assign('stat', $stats); 

	$content = $Youke->fetch($template, $cache_id, $compile_id);

	echo $content;
	#gzip
	$buffer = ob_get_contents();
	ob_end_clean();
	$options['is_enabled_gzip'] == 'yes' ? ob_start('ob_gzhandler') : ob_start();
	
	echo $buffer;
}





