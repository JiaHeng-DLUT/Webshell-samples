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
$type     = isset($_GET['type'])?htmlspecialchars($_GET['type']):'';
$site_api = isset($_POST['site_api'])?htmlspecialchars($_POST['site_api']):'';
$url      = isset($_POST['url'])?htmlspecialchars($_POST['url']):'';
   if(empty($url)){
       	$arr['status'] = 0;
		$arr['msg'] = '采集地址不能为空';
		exit(json_encode($arr));
   }
if($type == 'game'){
//游戏接口
    if($site_api == 1){
    		//4399接口
		$content = get_url_content($url);
		$data = array();
		preg_match_all('/<h1><a href="(.*)">(.*)<\/a><\/h1>/U',$content,$data);
		$title = $data[2][0]; //游戏标题

		if($title){
		$arr['status'] = 1;
		$arr['msg'] = '采集成功';
		$arr['data']['title'] = $title;
		$arr['data']['url'] = $url;
		exit(json_encode($arr));
		}
    }else{
    	$arr['status'] = 0;
		$arr['msg'] = '该接口尚未开通';
		exit(json_encode($arr));
    }




}elseif($type== 'live'){
//直播









}else{
		$arr['status'] = 0;
		$arr['msg'] = '非法请求！';
		exit(json_encode($arr));
}








