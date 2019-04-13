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

$fileurl  = url('article');
$tempfile = 'article.html';
$table    = table('articles');


if (empty($action)) $action = 'list';

/** list */
if ($action == 'list') {
	 $pagetitle = '文章列表';
	
	$status   = I('get.status','','intval');
	$cate_id  = I('get.cate_id','','intval');
	$sort     = I('get.sort','','intval');
	$order    = I('get.order','','strtoupper');
    $k        = I('get.keywords','');
	$keywords = I('get.keywords','','addslashes');
	if (empty($order)) $order = 'DESC';
	
	$pageurl  = $fileurl.'?status='.$status.'&cate_id='.$cate_id.'&sort='.$sort.'&order='.$order;
	$keyurl   = !empty($keywords) ? '&keywords='.urlencode($keywords) : '';
	$pageurl .= $keyurl;

    $category_option = get_category_option('article', 0, $cate_id, 0);



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
			$where .= " a.art_status=1";
			break;
		case 2 :
			$where .= " a.art_status=2";
			break;
		case 3 :
			$where .= " a.art_status=3";
			break;
		default :
			$where .= " a.art_status>-1";
			break;
	}
	
	if ($cate_id > 0) {
		$cate = get_one_category($cate_id);
		$where .= " AND a.cate_id IN (".$cate['cate_arrchildid'].")";
	}
	
	if ($keywords) $where .= " AND a.art_title like '%$keywords%'";
	
	switch ($sort) {
		case 1 :
			$field = "a.art_ctime";
			break;
		case 2 :
			$field = "a.art_views";
			break;
		default :
			$field = "a.art_ctime";
			break;
	}
	
	$result = get_article_list($where, $field, $order, $start, $pagesize);
	$articles = array();
	foreach ($result as $row) {
		switch ($row['art_status']) {
			case 1 :
				$art_status = '<span class="label label-primary>草稿</span>';
				break;
			case 2 :
				$art_status = '<span class="label label-default">待审核</span>';
				break;
			case 3 :
				$art_status = '<span class="label label-success">已审核</span>';
				break;
		}
		$art_ispay = $row['art_ispay'] > 0 ? '<span class="label label-info">付费</span>' : '<span class="label label-default">未付费</span>';
		$art_istop = $row['art_istop'] > 0 ? '<span class="label label-info">置顶</span>' : '<span class="label label-default">置顶</span>';
		$art_isbest = $row['art_isbest'] > 0 ? '<span class="label label-info">推荐</span>' : '<span class="label label-default">推荐</span>';
		$row['art_attr'] = $art_istop.' - '.$art_isbest.' - '.$art_ispay.' - '.$art_status;
		$row['art_cate'] = '<a href="'.$fileurl.'?cate_id='.$row['cate_id'].'">'.get_category_name($row['cate_id']).'</a>';
        
        $user = get_one_user($row['user_id']);
        $row['nick_name'] = $user['nick_name'];
		$articles[] = $row;
	}
	
	$total = $Db->getCount($table.' a','*',$where);	
	$showpage = showpage($pageurl, $total, $curpage, $pagesize);
	
	$Youke->assign('keywords', $keywords);
	$Youke->assign('articles', $articles);
	$Youke->assign('showpage', $showpage);
	unset($result, $articles);
}

/** add */
if ($action == 'add') {
	$pagetitle = '添加文章';

	$cate_id = I('get.cate_id','0','intval');
	$category_option = get_category_option('article', 0, $cate_id, 0);
	
	$Youke->assign('category_option', $category_option);
	$Youke->assign('status', 3);
	$Youke->assign('h_action', 'saveadd');
}

/** edit */
if ($action == 'edit') {
	$pagetitle = '编辑文章';
	
	$art_id = I('get.art_id','','intval');
	$where = "a.art_id=$art_id";
	$row = get_one_article($where);
	if (!$row) {
		msgbox('指定的内容不存在！');
	}
	$category_option = get_category_option('article', 0, $row['cate_id'], 0);
	$row['art_content'] = str_replace('[upload_dir]', $options['site_root'].$options['upload_dir'].'/', $row['art_content']);
	
	$Youke->assign('category_option', $category_option);
	$Youke->assign('ispay', $row['art_ispay']);
	$Youke->assign('istop', $row['art_istop']);
	$Youke->assign('isbest', $row['art_isbest']);
	$Youke->assign('status', $row['art_status']);
	$Youke->assign('article', $row);
	$Youke->assign('h_action', 'saveedit');
}

/** move */
if ($action == 'move') {
	$pagetitle = '移动文章';
			
	$art_ids = I($_POST['art_id'],$_GET['art_id']);
	if (empty($art_ids)) {
		msgbox('请选择要移动的文章！');
	}
	$aids = dimplode($art_ids);
	
	$category_option = get_category_option('article', 0, 0, 0);
	$articles = $Db->query("SELECT art_id, art_title FROM $table WHERE art_id IN ($aids)");
	
	$Youke->assign('category_option', $category_option);
	$Youke->assign('articles', $articles);
	$Youke->assign('h_action', 'savemove');
}

/** attr */
if ($action == 'attr') {
	$pagetitle = '属性设置';
	
	$art_ids =  I('post.art_id',$_GET['art_id']);
	if (empty($art_ids)) {
		msgbox('请选择要设置的文章！');
	}	
	$aids = dimplode($art_ids);
	
	$category_option = get_category_option('article', 0, 0, 0);
	$articles = $Db->query("SELECT art_id, art_title FROM $table WHERE art_id IN ($aids)");
	
	$Youke->assign('category_option', $category_option);
	$Youke->assign('articles', $articles);
	$Youke->assign('h_action', 'saveattr');
}

/** save data */
if (in_array($action, array('saveadd', 'saveedit'))) {
	$cate_id   = I('post.cate_id','intval');
	$art_title = I('post.art_title');
	$art_tags  = I('post.art_tags','','addslashes');
	$copy_from = I('post.copy_from');
	$copy_url  = I('post.copy_url');
	$art_intro = I('post.art_intro','','strip_tags');
	  if(!get_magic_quotes_gpc()){
//没有开启再去转义，开启就没有必要了
        $art_content =   addslashes($_POST['art_content']);
 }else{
 	    $art_content = htmlspecialchars($_POST['art_content']);
 }
	$art_views  = I('art_views','0','intval');
	$art_ispay  = I('art_ispay','0','intval');
	$art_istop  = I('art_istop','0','intval');
	$art_isbest = I('art_isbest','0','intval');
	$art_status = I('art_status','0','intval');
	$art_time   = time();
	

	if ($cate_id <= 0) {
		msgbox('请选择文章所属分类！');
	} else {
		$row = get_one_category($cate_id);
		if(!empty($row['cate_mod']) && $row['cate_mod'] == 'article' && $row['cate_childcount'] > 0) {
			msgbox('指定的分类下有子分类，请选择子分类进行操作！');
		}
	}
	
	if (empty($art_title)) {
		msgbox('请输入文章标题！');
	}
	

	
	if (empty($copy_from)) $copy_from = '原创';
	if (empty($copy_url)) $copy_url = $options['site_url'];
	

	
	$art_content = str_replace($options['site_root'].$options['upload_dir'].'/', '[upload_dir]', $art_content);
	
	$art_data = array(
		'cate_id'     => $cate_id,
		'art_title'   => $art_title,
		'copy_from'   => $copy_from,
		'copy_url'    => $copy_url,
		'art_content' => $art_content,
		'art_views'   => $art_views,
		'art_ispay'   => $art_ispay,
		'art_istop'   => $art_istop,
		'art_isbest'  => $art_isbest,
		'art_status'  => $art_status,
		'art_ctime'   => $art_time,
	);
	
	if ($action == 'saveadd') {
    	$query = $Db->query("SELECT art_id FROM $table WHERE art_title='$art_title'");
    	if (count($query)) {
        	msgbox('您所添加的文章已存在！');
    	}
		
		$art_data['user_id'] = $myself['user_id'];
		$Db->insert($table, $art_data);
		$Db->query("UPDATE ".table('categories')." SET cate_postcount=cate_postcount+1 WHERE cate_mod='article' AND cate_id=$cate_id");
		
		msgbox('文章添加成功！', $fileurl.'?act=add&cate_id='.$cate_id);	
	} elseif ($action == 'saveedit') {
		$art_id = intval($_POST['art_id']);
		$where ="art_id = '$art_id'";
		unset($art_data['art_ctime']);
		
		$Db->update($table, $art_data, $where);
		$Db->query("UPDATE ".table('categories')." SET cate_postcount=cate_postcount+1 WHERE cate_mod='article' AND cate_id=$cate_id");
		
		msgbox('文章编辑成功！', $fileurl);
	}
}

/** del */
if ($action == 'del') {
	
	$art_ids = !empty($_GET['art_id'])?$_GET['art_id']:'';
	if(is_array($art_ids)){
      $art_ids =  implode(',',$art_ids);
	}
	$Db->delete($table, 'art_id IN ('.$art_ids.')');
	unset($art_ids);
	
	msgbox('文章删除成功！', $fileurl);
}

/** move */
if ($action == 'savemove') {
	$art_ids =I($_POST['art_id']);
	$cate_id = I($_POST['cate_id'],'','intval');
	if (empty($art_ids)) {
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
	
	$Db->update($table, array('cate_id' => $cate_id), 'art_id IN ('.dimplode($art_ids).')');
	
	msgbox('文章移动成功！', $fileurl);
}

/** attr */
if ($action == 'saveattr') {
	$art_ids    = I($_POST['art_id']);
	$art_ispay  = I($_POST['art_ispay'],'','intval');
	$art_istop  = I($_POST['art_istop'],'','intval');
	$art_isbest = I($_POST['art_isbest'],'','intval');
	$art_status = I($_POST['art_status'],'','intval');
	if (empty($art_ids)) {
		msgbox('请选择要设置的内容！');
	}
	
	$Db->update($table, array('art_ispay' => $art_ispay, 'art_istop' => $art_istop, 'art_isbest' => $art_isbest, 'art_status' => $art_status), 'art_id IN ('.dimplode($art_ids).')');
	
	msgbox('文章属性设置成功！', $fileurl);
}

Youke_display($tempfile);
