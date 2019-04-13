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
// 实现跳转移动端

$visit = I('get.visit');
if($visit == 'mobile'){
  session('visit_type','mobile',24*3600);
  redirect(url('mobile/index'));
}

// 自动识别跳转功能
if(session('visit_type') !='pc'){
	  if($cfg['is_mobile_status'] == 'yes'){
		if(is_mobile()){
			header('Location: '.url('mobile/index'));

		}
	}
}


    if(session('auth_cookie')){
		// user login
		$auth_cookie = session('auth_cookie');
		$user_info   = check_user_login($auth_cookie);    	
    }else{
    	$user_info   = '';
    }

    $Youke->assign('user_info', $user_info);

//头部搜索右侧文字广告	
  $ad_text = [];
  if(!empty($options['ad_text'])){
		foreach(explode("\r\n",$options['ad_text']) as $v){
		  $arr = explode('|',$v);
		  $arr2['title']= $arr[0];
		  if($arr[0]){
		  	 $arr2['url']  =  $arr[1];
		  }
		 

		  array_push($ad_text,$arr2);

		}
  }
$Youke->assign('ad_text', $ad_text);