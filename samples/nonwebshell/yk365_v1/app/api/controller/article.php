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
// 移动端网站获取接口

//ajax提交

if(isAjax()){ 

	 $page     = I('get.page',1,'intval');
	$limit  =10;
	$page  =($page-1)*$limit;
    $type     = I('get.type','');

//获得文章列表,允许通过条件
   if($type == 'get_article_list'){
         $w     = I('get.where','','addslashes');
        $where = 1;
        $where .= ' and a.art_status =3'; 
   	   if(!empty($w)){
   	   	 $where .= ' and '.$w;
   	   }
		$list = get_article_list($where,'ctime','DESC',$page,$limit);
		$count = count(get_article_list());
		foreach($list as $k=>$v){
		      $list[$k]['art_content']= get_str($v['art_content']);
		      $list[$k]['thumb']= get_img($v['art_content']);

		}
		  	$arr['status'] = 0;
			$arr['msg'] = '成功';
			$arr['start'] = $page;
			$arr['limit'] = $limit;
			$arr['data'] = $list;
			$arr['pages'] = ceil($count/$limit);
			exit(json_encode($arr));

   }
	  
}else{
       	$arr['status'] = -1;
		$arr['msg'] = '非法请求';
		exit(json_encode($arr));
}


