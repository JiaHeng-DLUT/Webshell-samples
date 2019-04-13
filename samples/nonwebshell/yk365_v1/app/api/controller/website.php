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



if(isAjax()){ 
//ajax提交
	$page     = I('page',1,'addslashes');
	$type     = I('type','','addslashes');
	$limit  =10;
	$page  =($page-1)*$limit;

   if($type ==1){
		//获得最新网站 
		    $where = 'w.web_status =3';
			$list = get_website_list($where,'ctime','DESC',$page,$limit);
			$count = count(get_website_list());
				    $arr['status'] = 0;
					$arr['msg'] = '成功';
					$arr['start'] = $page;
					$arr['limit'] = $limit;
					$arr['data']  = $list;
					$arr['pages'] = ceil($count/$limit);
					exit(json_encode($arr));

   }elseif($type ==2){
//获得推荐网站
    $where = 'w.web_isbest =1 and w.web_status =3';
	$list = get_website_list($where,'ctime','DESC',$page,$limit);
	$count = count(get_website_list($where));

		    	$arr['status'] = 0;
			$arr['msg'] = '成功';
			$arr['start'] = $page;
			$arr['limit'] = $limit;
			$arr['data']  = $list;
			$arr['pages'] = ceil($count/$limit);
			exit(json_encode($arr));
   }elseif($type =='get_site_by_cid'){
   	$cid     = I('cid','0','intval');
//获得网站通过分类网站
    $where = 1;
    if(!empty($cid)){
        $where .= " and w.cate_id = '$cid' ";
    }
     $where .= " and w.web_status =3";
	$list = get_website_list($where,'ctime','DESC',$page,$limit);
	$count = $Db->getCount(table('website').' w','*',$where);


		    $arr['status'] = 0;
			$arr['msg'] = '成功';
			$arr['start'] = $page;
			$arr['limit'] = $limit;
			$arr['data']  = $list;
			$arr['pages'] = ceil($count/$limit);
			exit(json_encode($arr));
   }

}else{
       	$arr['status'] = -1;
		$arr['msg'] = '非法请求';
		exit(json_encode($arr));
}


