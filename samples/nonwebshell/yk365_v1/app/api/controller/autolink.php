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
header('Content-type: application/json'); 

if(isAjax()){ 

		$arr['web_name'] = !empty($_POST['sitename'])?addslashes($_POST['sitename']):'';
		$arr['web_qq']   = !empty($_POST['qq'])?addslashes($_POST['qq']):'';
		$arr['cate_id']  = !empty($_POST['cate_id'])?addslashes($_POST['cate_id']):'';
		$arr['web_url']  = !empty($_POST['siteurl'])?$_POST['siteurl']:'';
		$verify_code     = !empty($_POST['verify_code'])?addslashes($_POST['verify_code']):'';
		$arr['web_ctime'] = time();
		$arr['web_utime'] = time();
		

        if(empty($arr['cate_id'])){
             $arr['status'] = -1;
		     $arr['msg'] = "请选择网站分类!";
		     exit(json_encode($arr));
        }
        if(empty($arr['web_name'])){
             $arr['status'] = -1;
		     $arr['msg'] = "网站名称不能为空!";
		     exit(json_encode($arr));    	
        }

		if($_SESSION['code'] != $verify_code){
             $arr['status'] = -1;
		     $arr['msg'] = "验证码错误!";
		     exit(json_encode($arr));
		}
		$web_url = $arr['web_url'];
		//检查是否存在
		$website = get_one_website("a.web_url like '%$web_url%' ");
		 if(!empty($website)){
	         $arr['status'] = -1;
		     $arr['msg'] = "该网站已经提交，请勿重复提交！";
		     exit(json_encode($arr));	                
		                 	
		 }
          $res = $Db->insert(table('website'),$arr);
         
          $arr2['web_id']  =$Db->insert_id();
          $arr2['web_ip']   = get_client_ip();
           $Db->insert(table('webdata'),$arr2); //增加网站数据表
         if($res){
             $arr['status'] = 0;
		     $arr['msg'] = "你的网站已经成功提交！请必须做好我站链接后点击一次我站链接，系统马上审核开通你的网站！如果没有做上我们的链接是不会收录的！";
		     exit(json_encode($arr));
		 }
}


