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
$tempfile = 'game.html';
$table = table('games');
$fileurl = url('game');

if (empty($action)) $action = 'list';

/** list */
if ($action == 'list') {
	 $pagetitle = '游戏列表';
	
	$status   = I('get.status','','intval');
	$cate_id  = I('get.cate_id','','intval');
	$sort     = I('get.sort','','intval');
	$order    = I('get.order');
    $k        = I('get.keywords');  
	$keywords = isset($_POST['keywords'])?addslashes(trim($_POST['keywords'])):$k;
	if (empty($order)) $order = 'DESC';
	
	
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

	$pageurl = url('game',$param);
	$keyurl = !empty($keywords) ? '&keywords='.urlencode($keywords) : '';
	

    $category_option = get_category_option('game', 0, $cate_id, 0);



	$Youke->assign('status', $status);
	$Youke->assign('cate_id', $cate_id);
	$Youke->assign('sort', $sort);
	$Youke->assign('order', $order);
	$Youke->assign('keywords', $keywords);
	$Youke->assign('keyurl', $keyurl);
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
	
	$result = get_game_list($where, $field, $order, $start, $pagesize);

	$games = array();
	foreach ($result as $row) {
		switch ($row['status']) {
			case 1 :
				$status = '<span class="label label-primary>草稿</span>';
				break;
			case 2 :
				$status = '<span class="label label-default">待审核</span>';
				break;
			case 3 :
				$status = '<span  class="label label-success">已审核</span>';
				break;
		}

		$isbest = $row['isbest'] > 0 ? '<span class="label label-info">推荐</span>' : '<span class="label label-default">推荐</span>';
		$ishot = $row['ishot'] > 0 ? '<span class="label label-info">热门</span>' : '<span class="label label-default">热门</span>';		
		$row['attr'] = $isbest.' - '.$ishot.' - '.$status;

		$row['cate'] = '<a href="'.$fileurl.'?cate_id='.$row['cate_id'].'">'.get_category_name($row['cate_id']).'</a>';
		$row['operate'] = '<a href="'.$fileurl.'?act=edit&id='.$row['id'].'">编辑</a>&nbsp;|&nbsp;<a href="'.$fileurl.'?act=del&id='.$row['id'].'" onClick="return confirm(\'确认删除此内容吗？\');">删除</a>';
		$games[] = $row;
	}
	
	$total = $Db->getCount($table.' a','*',$where);	
	$showpage = showpage($pageurl, $total, $curpage, $pagesize);
	
	$Youke->assign('keywords', $keywords);
	$Youke->assign('games', $games);
	$Youke->assign('showpage', $showpage);
	unset($result, $games);
}

/** add */
if ($action == 'add') {

	$pagetitle = '添加游戏';

	$cate_id = I('get.cate_id',0,'intval');

	$category_option = get_category_option('game', 0, $cate_id,0);
   
	$Youke->assign('category_option', $category_option);
	$Youke->assign('status', 3);
	$Youke->assign('h_action', 'saveadd');
}

/** edit */
if ($action == 'edit') {
	$pagetitle = '编辑游戏';
	
	$id    = I('get.id','','intval');
	$where = "a.id=$id";
	$row   = get_one_game($where);
	if (!$row) {
		msgbox('指定的内容不存在！');
	}
	$category_option = get_category_option('game', 0, $row['cate_id'], 0);
	
	$Youke->assign('category_option', $category_option);
	$Youke->assign('status', $row['status']);
	$Youke->assign('ishot', $row['ishot']);
	$Youke->assign('isbest', $row['isbest']);
	$Youke->assign('row', $row);
	$Youke->assign('h_action', 'saveedit');
}

/** move */
if ($action == 'move') {
	$pagetitle = '移动游戏';
			
	$ids = (array) ($_POST['id'] ? $_POST['id'] : $_GET['id']);
	if (empty($ids)) {
		msgbox('请选择要移动的游戏！');
	}
	$aids = dimplode($ids);
	
	$category_option = get_category_option('game', 0, 0, 0);
	$games = $Db->query("SELECT id, title FROM $table WHERE id IN ($aids)");
	
	$Youke->assign('category_option', $category_option);
	$Youke->assign('games', $games);
	$Youke->assign('h_action', 'savemove');
}

/** attr */
if ($action == 'attr') {
	$pagetitle = '属性设置';
	
	$ids = (array) ($_POST['id'] ? $_POST['id'] : $_GET['id']);
	if (empty($ids)) {
		msgbox('请选择要设置的游戏！');
	}	
	$aids = dimplode($ids);
	
	$category_option = get_category_option('game', 0, 0, 0);
	$games = $Db->query("SELECT id, title FROM $table WHERE id IN ($aids)");
	
	$Youke->assign('category_option', $category_option);
	$Youke->assign('games', $games);
	$Youke->assign('h_action', 'saveattr');
}

/** save data */
if (in_array($action, array('saveadd', 'saveedit'))) {
	

	$cate_id  = I('post.cate_id','','intval');
	$title    = I('post.title');
	$cover    = I('post.cover');
	$url      = I('post.url');
	$ishot    = I('post.ishot','intval');
	$isbest   = I('post.isbest','intval');
	$status   = I('post.status','','intval');
	$time     = time();
	

	if ($cate_id <= 0) {
		msgbox('请选择游戏所属分类！');
	} else {
		$row = get_one_category($cate_id);
		if ($row['cate_mod'] == 'game' && $row['cate_childcount'] > 0) {
			msgbox('指定的分类下有子分类，请选择子分类进行操作！');
		}
	}
	
	if (empty($title)) {
		msgbox('请输入游戏标题！');
	}




	$data = array(
		'cate_id' => $cate_id,
		'title'   => $title,
		'url'     => $url,
		'cover'   => $cover,
		'status'  => $status,
		'ishot'   => $ishot,
		'isbest'  => $isbest,
		'ctime'   => $time,
	);
	
	if ($action == 'saveadd') {
    	$query = $Db->query("SELECT id FROM $table WHERE title='$title'");
    	if (count($query)) {
        	msgbox('您所添加的游戏已存在！');
    	}
		
		$data['user_id'] = $myself['user_id'];
		$Db->insert($table, $data);
		$Db->query("UPDATE ".table('categories')." SET cate_postcount=cate_postcount+1 WHERE cate_mod='game' AND cate_id=$cate_id");
		
		msgbox('游戏添加成功！', $fileurl.'?act=add&cate_id='.$cate_id);	
	} elseif ($action == 'saveedit') {
		$id    = I('post.id','','intval');
		$where = "id = '$id'";
		unset($data['ctime']);
		
		$Db->update($table, $data, $where);
		$Db->query("UPDATE ".table('categories')." SET cate_postcount=cate_postcount+1 WHERE cate_mod='game' AND cate_id=$cate_id");
		
		msgbox('游戏编辑成功！', $fileurl);
	}
}

/** del */
if ($action == 'del') {
	$ids = (array) ($_POST['id'] ? $_POST['id'] : $_GET['id']);
	
	$Db->delete($table, 'id IN ('.dimplode($ids).')');
	unset($ids);
	
	msgbox('游戏删除成功！', $fileurl);
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
	
	msgbox('游戏移动成功！', $fileurl);
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
	msgbox('游戏属性设置成功！', $fileurl);
}
Youke_display($tempfile);
