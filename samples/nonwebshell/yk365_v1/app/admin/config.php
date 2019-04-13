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
$pagesize = 30;
$curpage = isset($_GET['page'])?intval($_GET['page']):'1';
if ($curpage > 1) {
	$start = ($curpage - 1) * $pagesize;
} else {
	$start = 0;
	$curpage = 1;
}
$act = isset($_POST['act'])?htmlspecialchars($_POST['act']):'';
$action = isset($_GET['act'])?htmlspecialchars($_GET['act']):$act;

$category_modules = array(
	'webdir'   => '网站目录',
	 'article' => '文章资讯',
	 'game'    =>'小游戏',
	 'video'   =>'视频',
	 'live'    =>'电视直播',
	 );

//接口地址
$game_site_api = array(
	'1'=>'http://www.4399.com',
	);

$Youke->assign('game_site_api',$game_site_api);
