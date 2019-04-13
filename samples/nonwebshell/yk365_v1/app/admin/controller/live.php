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

$fileurl  = url('live');
$tempfile = 'live.html';
$table    = table('lives');


if (empty($action)) $action = 'list';

/** list */
if ($action == 'list') {
	 $pagetitle = '电视直播列表';
	
	$cate_id  = I('get.cate_id','','intval');
	$sort     = I('get.sort','','intval');
	$order    = I('get.order','','strtoupper');
    $k        = I('get.keywords','');
	$keywords = I('get.keywords','','addslashes');
	if (empty($order)) $order = 'DESC';
	
	$pageurl  = $fileurl.'?cate_id='.$cate_id.'&sort='.$sort.'&order='.$order;
	$keyurl   = !empty($keywords) ? '&keywords='.urlencode($keywords) : '';
	$pageurl .= $keyurl;

    $category_option = get_category_option('live', 0, $cate_id, 0);

	$Youke->assign('cate_id', $cate_id);
	$Youke->assign('sort', $sort);
	$Youke->assign('order', $order);
	$Youke->assign('keywords', $keywords);
	$Youke->assign('keyurl', $keyurl);
	$Youke->assign('category_option', $category_option);
	
	$where = "";

	
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
	
	$result = get_live_list($where, $field, $order, $start, $pagesize);
	$lives = array();
	foreach ($result as $row) {
		$isbest = $row['isbest'] > 0 ? '<span class="label label-info">推荐</span>' : '<span class="label label-default">推荐</span>';
		$row['attr'] = $isbest;
		$row['cate'] = '<a href="'.$fileurl.'?cate_id='.$row['cate_id'].'">'.get_category_name($row['cate_id']).'</a>';
        $row['operate'] = '<a href="'.url('live',['act'=>'edit','id'=>$row['id']]).'">编辑</a> - <a href="'.url('live',['act'=>'del','id'=>$row['id']]).'" onClick="return confirm(\'确认删除此内容吗？\');">删除</a>';
		$lives[] = $row;
	}
	
	$total = $Db->getCount($table.' a','*',$where);	
	$showpage = showpage($pageurl, $total, $curpage, $pagesize);
   
	$Youke->assign('keywords', $keywords);
	$Youke->assign('lives', $lives);
	$Youke->assign('showpage', $showpage);
	unset($result, $lives);
}

/** add */
if ($action == 'add') {
	$pagetitle = '添加电视直播';

	$cate_id = I('get.cate_id','0','intval');
	$category_option = get_category_option('live', 0, $cate_id, 0);
	
	$Youke->assign('category_option', $category_option);
	$Youke->assign('h_action', 'saveadd');
}

/** edit */
if ($action == 'edit') {
	$pagetitle = '编辑电视直播';
	
	$id = I('get.id','','intval');
	$where = "a.id=$id";
	$row = get_one_live($where);
	if (!$row) {
		msgbox('指定的内容不存在！');
	}
	$category_option = get_category_option('live', 0, $row['cate_id'], 0);

	$Youke->assign('category_option', $category_option);
	$Youke->assign('isbest', $row['isbest']);
	$Youke->assign('live', $row);
	$Youke->assign('h_action', 'saveedit');
}

/** move */
if ($action == 'move') {
	$pagetitle = '移动电视直播';
			
	$ids = I($_POST['id'],$_GET['id']);
	if (empty($ids)) {
		msgbox('请选择要移动的电视直播！');
	}
	$aids = dimplode($ids);
	
	$category_option = get_category_option('live', 0, 0, 0);
	$lives = $Db->query("SELECT id, title FROM $table WHERE id IN ($aids)");
	
	$Youke->assign('category_option', $category_option);
	$Youke->assign('lives', $lives);
	$Youke->assign('h_action', 'savemove');
}

/** attr */
if ($action == 'attr') {
	$pagetitle = '属性设置';
	
	$ids =  I('post.id',$_GET['id']);
	if (empty($ids)) {
		msgbox('请选择要设置的电视直播！');
	}	
	$aids = dimplode($ids);
	
	$category_option = get_category_option('live', 0, 0, 0);
	$lives = $Db->query("SELECT id, title FROM $table WHERE id IN ($aids)");
	
	$Youke->assign('category_option', $category_option);
	$Youke->assign('lives', $lives);
	$Youke->assign('h_action', 'saveattr');
}

/** save data */
if (in_array($action, array('saveadd', 'saveedit'))) {
	$cate_id   = I('post.cate_id','intval');
	$title = I('post.title');
	$views  = I('views','0','intval');
	$video_url  = I('video_url','','addslashes');
	$isbest = I('isbest','0','intval');

	$time   = time();
	

	if ($cate_id <= 0) {
		msgbox('请选择电视直播所属分类！');
	} else {
		$row = get_one_category($cate_id);
		if(!empty($row['cate_mod']) && $row['cate_mod'] == 'live' && $row['cate_childcount'] > 0) {
			msgbox('指定的分类下有子分类，请选择子分类进行操作！');
		}
	}
	
	if (empty($title)) {
		msgbox('请输入电视直播标题！');
	}

	
	$data = array(
		'cate_id'     => $cate_id,
		'title'   => $title,
		'video_url' =>$video_url,
		'views'   => $views,
		'isbest'  => $isbest,
		'ctime'   => $time,
	);
	
	if ($action == 'saveadd') {
    	$query = $Db->query("SELECT id FROM $table WHERE title='$title'");
    	if (count($query)) {
        	msgbox('您所添加的电视直播已存在！');
    	}
		
		$data['user_id'] = $myself['user_id'];
		$Db->insert($table, $data);
		$Db->query("UPDATE ".table('categories')." SET cate_postcount=cate_postcount+1 WHERE cate_mod='live' AND cate_id=$cate_id");
		
		msgbox('电视直播添加成功！', $fileurl.'?act=add&cate_id='.$cate_id);	
	} elseif ($action == 'saveedit') {
		$id = intval($_POST['id']);
		$where ="id = '$id'";
		unset($data['ctime']);
		
		$Db->update($table, $data, $where);
		$Db->query("UPDATE ".table('categories')." SET cate_postcount=cate_postcount+1 WHERE cate_mod='live' AND cate_id=$cate_id");
		
		msgbox('电视直播编辑成功！', $fileurl);
	}
}

/** del */
if ($action == 'del') {
	
	$ids = !empty($_GET['id'])?$_GET['id']:'';
	if(is_array($ids)){
      $ids =  implode(',',$ids);
	}
	$Db->delete($table, 'id IN ('.$ids.')');
	unset($ids);
	
	msgbox('电视直播删除成功！', $fileurl);
}

/** move */
if ($action == 'savemove') {
	$ids =I($_POST['id']);
	$cate_id = I($_POST['cate_id'],'','intval');
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
	
	msgbox('电视直播移动成功！', $fileurl);
}

/** attr */
if ($action == 'saveattr') {
	$ids    = I($_POST['id']);
	$isbest = I($_POST['isbest'],'','intval');
	if (empty($ids)) {
		msgbox('请选择要设置的内容！');
	}
	
	$Db->update($table, array('isbest' => $isbest), 'id IN ('.dimplode($ids).')');
	
	msgbox('电视直播属性设置成功！', $fileurl);
}

Youke_display($tempfile);
