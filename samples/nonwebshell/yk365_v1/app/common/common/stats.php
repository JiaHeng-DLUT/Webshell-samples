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
function get_stats()
{
	global $Db;
	
	$stat = array();
	$stat['cate_webdir'] = $Db->getCount(table('categories'),"*","cate_mod = 'webdir'");
	$stat['website']     = $Db->getCount(table('website'),"*");
	$stat['apply']       = $Db->getCount(table('website'),"*","web_status = 2");
	$stat['user']        = $Db->getCount(table('users'),"*", "user_type != 'admin'");
	$stat['adver']       = $Db->getCount(table('advers'),"*");
	$stat['link']        = $Db->getCount(table('links'),"*");
	$stat['feedback']    = $Db->getCount(table('feedback'),"*");
	$stat['page']        = $Db->getCount(table('pages'),"*");
	$stat['cate_article'] = $Db->getCount(table('categories'),"*","cate_mod = 'article'");
    $stat['article']      = $Db->getCount(table('articles'),"*");
	$stat['game']         = $Db->getCount(table('games'),"*");
	$stat['live']         = $Db->getCount(table('lives'),"*");
	$stat['cate_game']    = $Db->getCount(table('categories'),"*","cate_mod = 'game'");
	$stat['video']        = $Db->getCount(table('videos'),"*");
	$stat['cate_video']   = $Db->getCount(table('categories'),"*","cate_mod = 'video'");

	return $stat;
}
