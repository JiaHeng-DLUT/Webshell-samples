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
include APP_PATH.__MODULE__.'/base.php';
$tempfile = 'video.html';
$table = table('videos');


if (empty($action)) $action = 'list';

/** list */
if ($action == 'list') {
	$pagetitle = '视频列表';
	
	$status  = isset($_GET['status'])?intval($_GET['status']):'';
	$cate_id = isset($_GET['cate_id'])?intval($_GET['cate_id']):'';
	$sort    = isset($_GET['sort'])?intval($_GET['sort']):'';
	$order   = isset($_GET['order'])?strtoupper(htmlspecialchars($_GET['order'])):'';
    $k       = isset($_GET['keywords'])?htmlspecialchars($_GET['keywords']):'';  
	$keywords = isset($_POST['keywords'])?addslashes(trim($_POST['keywords'])):$k;
	if (empty($order)) $order = 'DESC';
	
   	$key_url = !empty($keywords) ? '&keywords='.urlencode($keywords) : '';
	if($status){
      $param['status'] =$status;
	}
	if($cate_id){
		$param['cate_id'] =$cate_id;
	}
 	if($sort){
		$param['sort'] =$sort;
	}  
 	if($order){
		$param['order'] =$order;
	} 

    if($keywords){
    	$param['keywords'] = urlencode($keywords); 
    }

	$pageurl = url('video',$param);

    $category_option = get_category_option('video', 0, $cate_id, 0);



	$Youke->assign('status', $status);
	$Youke->assign('cate_id', $cate_id);
	$Youke->assign('sort', $sort);
	$Youke->assign('order', $order);
	$Youke->assign('keywords', $keywords);
	$Youke->assign('key_url', $key_url);
	$Youke->assign('category_option', $category_option);
	
	$where = "";
	switch ($status) {
		case 1 :
			$where .= " a.status=1";
			break;
		case 2 :
			$where .= " a.status=2";
			break;
		case 3 :
			$where .= " a.status=3";
			break;
		default :
			$where .= " a.status>-1";
			break;
	}
	


	if ($cate_id > 0) {
		$cate = get_one_category($cate_id);
		$where .= " AND a.cate_id IN (".$cate['cate_arrchildid'].")";
	}
	
	if ($keywords) $where .= " AND a.title like '%$keywords%'";
	
	switch ($sort) {
		case 1 :
			$field = "a.ctime";
			break;
		case 2 :
			$field = "a.views";
			break;
		default :
			$field = "a.ctime";
			break;
	}
	
	$result = get_video_list($where, $field, $order, $start, $pagesize);

	$videos = array();
	foreach ($result as $row) {
		switch ($row['status']) {
			case 1 :
				$status = '<span class="label label-primary">草稿</span>';
				break;
			case 2 :
				$status = '<span class="label label-default">待审核</span>';
				break;
			case 3 :
				$status = '<span class="label label-success" >已审核</span>';
				break;
		}

		$isbest = $row['isbest'] > 0 ? '<span class="label label-info">推荐</span>' : '<span class="label label-default">推荐</span>';
		$ishot = $row['ishot'] > 0 ? '<span class="label label-info">热门</span>' : '<span class="label label-default">热门</span>';		
		$row['attr'] = $isbest.' - '.$ishot.' - '.$status;

		$row['cate'] = '<a href="'.url('video',['cate_id'=>$row['cate_id']]).'">'.get_category_name($row['cate_id']).'</a>';
		$row['operate'] = '<a href="'.url('video',['act'=>'edit','id'=>$row['id']]).'">编辑</a>
		<a href="'.url('video',['act'=>'del','id'=>$row['id']]).'" onClick="return confirm(\'确认删除此内容吗？\');">删除</a>';
		$videos[] = $row;
	}
	
	$total = $Db->getCount($table.' a','*', $where);	
	$showpage = showpage($pageurl, $total, $curpage, $pagesize);
	
	$Youke->assign('keywords', $keywords);
	$Youke->assign('videos', $videos);
	$Youke->assign('showpage', $showpage);
	unset($result, $videos);
}

/** add */
if ($action == 'add') {

	$pagetitle = '添加视频';

	$cate_id = !empty($_GET['cate_id'])?intval($_GET['cate_id']):0;

	$category_option = get_category_option('video', 0, $cate_id,0);
   
	$Youke->assign('category_option', $category_option);
	$Youke->assign('status', 3);
	$Youke->assign('h_action', 'saveadd');
}

/** edit */
if ($action == 'edit') {
	$pagetitle = '编辑视频';
	
	$id    = intval($_GET['id']);
	$where = "a.id=$id";
	$row   = get_one_video($where);
	if (!$row) {
		msgbox('指定的内容不存在！');
	}
	$category_option = get_category_option('video', 0, $row['cate_id'], 0);
	
	$Youke->assign('category_option', $category_option);
	$Youke->assign('status', $row['status']);
	$Youke->assign('ishot', $row['ishot']);
	$Youke->assign('isbest', $row['isbest']);
	$Youke->assign('row', $row);
	$Youke->assign('h_action', 'saveedit');
}

/** move */
if ($action == 'move') {
	$pagetitle = '移动视频';
			
	$ids = (array) ($_POST['id'] ? $_POST['id'] : $_GET['id']);
	if (empty($ids)) {
		msgbox('请选择要移动的视频！');
	}
	$aids = dimplode($ids);
	
	$category_option = get_category_option('video', 0, 0, 0);
	$videos = $Db->query("SELECT id, title FROM $table WHERE id IN ($aids)");
	
	$Youke->assign('category_option', $category_option);
	$Youke->assign('videos', $videos);
	$Youke->assign('h_action', 'savemove');
}

/** attr */
if ($action == 'attr') {
	$pagetitle = '属性设置';
	
	$ids = (array) ($_POST['id'] ? $_POST['id'] : $_GET['id']);
	if (empty($ids)) {
		msgbox('请选择要设置的视频！');
	}	
	$aids = dimplode($ids);
	
	$category_option = get_category_option('video', 0, 0, 0);
	$videos = $Db->query("SELECT id, title FROM $table WHERE id IN ($aids)");
	
	$Youke->assign('category_option', $category_option);
	$Youke->assign('videos', $videos);
	$Youke->assign('h_action', 'saveattr');
}

/** save data */
if (in_array($action, array('saveadd', 'saveedit'))) {
	

	$cate_id = I('post.cate_id','','intval');
	$title   = I('post.title');
	$url     = I('post.url');
	$ishot   = I('post.ishot',0,'intval');
	$isbest  = I('post.isbest',0,'intval');
	$status  = I('post.status','','intval');
	$time    = time();
	

	if ($cate_id <= 0) {
		msgbox('请选择视频所属分类！');
	} else {
		$row = get_one_category($cate_id);
		if (!empty($row['cate_mod']) && $row['cate_mod'] == 'video' && $row['cate_childcount'] > 0) {
			msgbox('指定的分类下有子分类，请选择子分类进行操作！');
		}
	}
	
	if (empty($title)) {
		msgbox('请输入视频标题！');
	}


    if(!empty($_FILES['cover']['name'])){
		//上传封面
			 $Upload = new FileUpload;
			 $Upload->set('path',ROOT_PATH.$options['upload_dir'].'/video');
			 if(!$Upload->upload('cover')){
		       msgbox($Upload->getErrorMsg()); 
			 }else{

			   $cover = '/'.$options['upload_dir'].'/video/'.$Upload->getFileName();
			 }
		     if($Upload->getFileName()){
		     	$data['cover'] = $cover;
		     }

    }


	$data['cate_id'] = $cate_id;
    $data['title']   = $title;
    $data['url']     = $url;
    $data['status']  = $status;
    $data['ishot']   = $ishot;
    $data['isbest']  = $isbest;
    $data['ctime']   = $time;


	if ($action == 'saveadd') {
    	$query = $Db->query("SELECT id FROM $table WHERE title='$title'");
    	if (count($query)) {
        	msgbox('您所添加的视频已存在！');
    	}
		
		$data['user_id'] = $myself['user_id'];
		$Db->insert($table, $data);
		$Db->query("UPDATE ".table('categories')." SET cate_postcount=cate_postcount+1 WHERE cate_mod='video' AND cate_id=$cate_id");
		
		msgbox('视频添加成功！', url('video').'?act=add&cate_id='.$cate_id);	
	} elseif ($action == 'saveedit') {
		$id    = I('post.id','','intval');
		$where = "id ='$id'";
		unset($data['ctime']);
		
		$Db->update($table, $data, $where);
		$Db->query("UPDATE ".table('categories')." SET cate_postcount=cate_postcount+1 WHERE cate_mod='video' AND cate_id=$cate_id");
		
		msgbox('视频编辑成功！', url('video'));
	}
}

/** del */
if ($action == 'del') {
	$ids = (array) ($_POST['id'] ? $_POST['id'] : $_GET['id']);
	
	$Db->delete($table, 'id IN ('.dimplode($ids).')');
	unset($ids);
	
	msgbox('视频删除成功！', url('video'));
}

/** move */
if ($action == 'savemove') {
	$ids = (array) $_POST['id'];
	$cate_id = I('post.cate_id','','intval');
	if (empty($ids)) {
		msgbox('请选择要移动的内容！');
	}
	if ($cate_id <= 0) {
		msgbox('请选择分类！');
	} else {
		$cate = get_one_category($cate_id);
		if ($cate['cate_childcount'] > 0) {
			msgbox('指定的分类下有子分类，请选择子分类进行操作！');
		}
	}
	
	$Db->update($table, array('cate_id' => $cate_id), 'id IN ('.dimplode($ids).')');
	
	msgbox('视频移动成功！', url('video'));
}

/** attr */
if ($action == 'saveattr') {
	$ids = (array) $_POST['id'];
	$status = I('post.status','','intval');	
	$ishot  = I('post.ishot','','intval');
	$isbest = I('post.isbest','','intval');
	if (empty($ids)) {
		msgbox('请选择要设置的内容！');
	}
	
	$Db->update($table, array('ishot' => $ishot, 'isbest' => $isbest, 'status' => $status), 'id IN ('.dimplode($ids).')');
	
	msgbox('视频属性设置成功！', url('video'));
}

Youke_display($tempfile);
