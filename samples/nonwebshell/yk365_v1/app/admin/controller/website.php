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

$fileurl = url('website');
$tempfile = 'website.html';
$table = table('website');

if (empty($action)) $action = 'list';


/** list */
if ($action == 'list') {
	$pagetitle = '站点列表';
	
	$status  = I('get.status','','intval');
	$user_id = I('get.user_id','','intval');
	$cate_id = I('get.cate_id',0,'intval');
	$sort    = I('get.sort','','intval');
	$order   = I('get.order','','strtoupper');
	$get_keywords = I('get.keywords');
	$keywords     = I('post.keywords',$get_keywords,'addslashes');
	if (empty($order)) $order = 'DESC';



	if($status != null){
       $post_param['status'] = $status;
	}
	if($user_id != null){
       $post_param['user_id'] = $user_id;
	}
	if($cate_id != null){
       $post_param['cate_id'] = $cate_id;
	}
	if($sort != null){
       $post_param['sort']  = $sort;
	}
	if($order != null){
       $post_param['order'] = $order;
	}		
	

	$keyurl = !empty($keywords) ? '&keywords='.urlencode($keywords) : '';

	if($keywords != null){
       $post_param['keywords'] = urlencode($keywords);
	}
	$pageurl = url('website',$post_param);
	$category_option = get_category_option(0,$cate_id, 0);

	$Youke->assign('status', $status);
	$Youke->assign('user_id', $user_id);
	$Youke->assign('cate_id', $cate_id);
	$Youke->assign('sort', $sort);
	$Youke->assign('order', $order);
	$Youke->assign('keywords', $keywords);
	$Youke->assign('keyurl', $keyurl);
	$Youke->assign('category_option', $category_option);
	
	$where = '';
	$sql = "SELECT a.web_id, a.user_id, a.cate_id, a.web_name, a.web_url, a.web_ico,a.web_istop,a.web_ispay,a.web_isbest, a.web_status, a.web_ctime, b.web_ip, b.web_r360, b.web_brank, b.web_srank, b.web_arank, b.web_instat, b.web_outstat, b.web_views, b.web_errors, c.cate_name, u.nick_name FROM $table a LEFT JOIN ".table('webdata')." b ON a.web_id=b.web_id LEFT JOIN ".table('categories')." c ON a.cate_id=c.cate_id LEFT JOIN ".table('users')." u ON a.user_id=u.user_id where";

	switch ($status) {
		case 1 :
			$where .= " a.web_status=1";
			break;
		case 2 :
			$where .= " a.web_status=2";
			break;
		case 3 :
			$where .= " a.web_status=3";
			break;
		case 4 :
			$where .= " a.web_istop = 1";
			break;
		case 5 :
			$where .= " a.web_isbest = 1";
			break;
		case 6 :
			$where .= " a.web_ispay = 1";
			break;
		default :
			$where .= " a.web_status>-1";
			break;
	}
	
	if ($user_id > 0) {
		$where .= " AND a.user_id = '$user_id'";
	}
	
	if ($cate_id > 0) {
		$cate = get_one_category($cate_id);
		$where .= " AND a.cate_id IN (".$cate['cate_arrchildid'].")";
	}
	
	if ($keywords) $where .= " AND a.web_name like '%$keywords%'";
	
	switch ($sort) {
		case 1 :
			$field = "a.web_ctime";
			break;
		case 2 :
			$field = "b.web_brank";
			break;
		case 3 :
			$field = "b.web_r360";
			break;
		case 4 :
			$field = "b.web_srank";
			break;
		case 5 :
			$field = "b.web_arank";
			break;
		case 6 :
			$field = "b.web_instat";
			break;
		case 7 :
			$field = "b.web_outstat";
			break;
		case 8 :
			$field = "b.web_views";
			break;
		case 9 :
			$field = "b.web_errors";
			break;
		default :
			$field = "a.web_ctime";
			break;
	}
	
	$sql .= $where." ORDER BY $field $order LIMIT $start, $pagesize";

	$query = $Db->query($sql);

	$website = array();
	foreach($query as $web){
		switch ($web['web_status']) {
			case 1 :
				$web_status = '<span class="label label-danger">黑名单</span>';
				break;
			case 2 :
				$web_status = '<span class="label label-default" >待审核</span>';
				break;
			case 3 :
				$web_status = '<span class="label label-success">已审核</span>';
				break;

		}

		$web_ispay = $web['web_ispay'] > 0 ? '<span class="label label-danger">已付费</span>' : '<span class="label label-default">未付费</span>';
		$web_istop = $web['web_istop'] > 0 ? '<span class="label label-danger">已置顶</span>' : '<span class="label label-default">未置顶</span>';
		$web_isbest = $web['web_isbest'] > 0 ? '<span class="label label-danger">已推荐</span>' : '<span class="label label-default">未推荐</span>';
		$web['web_attr'] = $web_istop.' - '.$web_isbest.' - '.$web_ispay.' - '.$web_status;
		$web['web_cate'] = '<a href="'.$fileurl.'?cate_id='.$web['cate_id'].'">'.$web['cate_name'].'</a>';
		$web['nick_name'] = '<a href="'.$fileurl.'?user_id='.$web['user_id'].'" title="查看该用户提交的所有站点">'.$web['nick_name'].'</a>';
		$web['web_name'] = '<a href="'.$web['web_url'].'" target="_blank">'.$web['web_name'].'</a> '.($web['web_errors'] > 0 ? '<sup style="color: #f00;">error!</sup>' : '');
		$web['web_ip'] = long2ip($web['web_ip']);
		$web['web_arank'] = number_format($web['web_arank']);
		$web['web_ctime'] = date('Y-m-d', $web['web_ctime']);

		$web['web_operate'] = '';
		$website[] = $web;
	}

	unset($web);
	
	$total = $Db->getCount($table.' a','*',$where);
	$showpage = showpage($pageurl, $total, $curpage, $pagesize);
	
	$Youke->assign('website', $website);
	$Youke->assign('showpage', $showpage);
	unset($website);
}

/** down */
if ($action == 'down') {
	$pagetitle = '下载站点图片';
}

/** add */
if ($action == 'add') {
	$pagetitle = '添加站点';

	$cate_id = I('get.cate_id',0,'intval');
	$category_option = get_category_option(0, $cate_id, 0);
	
	$Youke->assign('category_option', $category_option);
	$Youke->assign('status', 3);
	$Youke->assign('h_action', 'saveadd');
}

/** edit */
if ($action == 'edit') {
	$pagetitle = '编辑站点';
	
	$web_id = I('get.web_id','','intval');
	$where = "a.web_id=$web_id";
	$web = get_one_website($where);

	if (!$web) {
		msgbox('指定的内容不存在！');
	}
	
	// 分类ID
	$parent_cids = get_category_parent_ids($web['cate_id']).','.$web['cate_id'];
	if (strpos($parent_cids, ',') !== false) {
		$cate_pids = explode(',', $parent_cids);
		array_shift($cate_pids);
	} else {
		$cate_pids = (array) $parent_cids;
	}
	
	// IP
	$row['web_ip'] = long2ip($web['web_ip']);
	
	// 状态
	$status = isset($row['web_status'])?$row['web_status']:'';
	
	$Youke->assign('cate_pids', $cate_pids);
	$Youke->assign('status', $web['web_status']);
	$Youke->assign('web', $web);
	$Youke->assign('h_action', 'saveedit');
}

/** move */
if ($action == 'move') {
	$pagetitle = '移动站点';
			
	$web_ids = (array) ($_POST['web_id'] ? $_POST['web_id'] : $_GET['web_id']);
	if (empty($web_ids)) {
		msgbox('请选择要移动的站点！');
	} else {
		$wids = dimplode($web_ids);
	}
	
	$category_option = get_category_option(0, 0, 0);
	$websites = $Db->query("SELECT web_id, web_name FROM $table WHERE web_id IN ($wids)");
	
	$Youke->assign('category_option', $category_option);
	$Youke->assign('websites', $websites);
	$Youke->assign('h_action', 'savemove');
}

/** attr */
if ($action == 'attr') {
	$pagetitle = '属性设置';
	
	$web_ids = (array) ($_POST['web_id'] ? $_POST['web_id'] : $_GET['web_id']);
	if (empty($web_ids)) {
		msgbox('请选择要设置的站点！');
	} else {
		$wids = dimplode($web_ids);
	}
	
	$category_option = get_category_option(0, 0, 0);
	$websites = $Db->query("SELECT web_id, web_name FROM $table WHERE web_id IN ($wids)");
	
	$Youke->assign('category_option', $category_option);
	$Youke->assign('websites', $websites);
	$Youke->assign('h_action', 'saveattr');
}

/** save data */
if (in_array($action, array('saveadd', 'saveedit'))) {
	$cate_id    = I('post.cate_id','','intval');
	$web_name   = I('post.web_name');
	$web_ico    = I('post.web_ico');
	$web_url    = I('post.web_url');
	$web_tags   = I('post.web_tags','','addslashes');
	$web_intro  = I('post.web_intro','','addslashes');
	$web_ip     = I('post.web_ip');
	$web_r360   = I('post.web_r360',0,'intval');
	$web_brank  = I('post.web_brank',0,'intval');
	$web_srank  = I('post.web_srank',0,'intval');
	$web_arank  = I('post.web_arank',0,'intval');
	$web_instat = I('post.web_instat',0,'intval');
	$web_outstat= I('post.web_outstat',0,'intval');
	$web_views  = I('post.web_views',0,'intval');
	$web_errors = I('post.web_errors',0,'intval');
	$web_ispay  = I('post.web_ispay',0,'intval');
	$web_istop  = I('post.web_istop',0,'intval');
	$web_isbest = I('post.web_isbest',0,'intval');
	$web_status = I('post.web_status','','intval');
	$web_time = time();


	
	if ($cate_id <= 0) {
		msgbox('请选择网站所属分类！');
	} else {
		$cate = get_one_category($cate_id);
		if ($cate['cate_childcount'] > 0) {
			msgbox('指定的分类下有子分类，请选择子分类进行操作！');
		}
	}
	
	if (empty($web_name)) {
		msgbox('请输入网站名称！');
	}
	
	if (empty($web_url)) {
		msgbox('请输入网站域名！');
	} else {
		if (!is_valid_domain($web_url)) {
			msgbox('请输入正确的网站域名！');
		}
	}
	
	if (empty($web_intro)) {
		msgbox('请输入网站简介！');
	}


	$web_tags = str_replace('，', ',', $web_tags);
	$web_tags = str_replace(',,', ',', $web_tags);
	if (substr($web_tags, -1) == ',') {
		$web_tags = substr($web_tags, 0, strlen($web_tags) - 1);
	}
	
	$web_ip = sprintf("%u", ip2long($web_ip));
	$web_data['web_ico']   = $web_ico;
	$web_data['cate_id']   = $cate_id;
	$web_data['web_name']  = $web_name;
	$web_data['web_url']   = $web_url;
	$web_data['web_tags']  = $web_tags;
	$web_data['web_intro'] = $web_intro;
	$web_data['web_ispay'] = $web_ispay;
	$web_data['web_istop'] = $web_istop;
	$web_data['web_isbest'] = $web_isbest;
	$web_data['web_status'] = $web_status;
	$web_data['web_ctime']  = $web_time;


	
	$stat_data = array(
		'web_ip'    => $web_ip,
		'web_r360'  => $web_r360,
		'web_brank' => $web_brank,
		'web_srank' => $web_srank,
		'web_arank' => $web_arank,
		'web_instat'  => $web_instat,
		'web_outstat' => $web_outstat,
		'web_views'   => $web_views,
		'web_errors'  => $web_errors,
		'web_utime'   => time(),
	);
	
	if ($action == 'saveadd') {
    	$query = $Db->query("SELECT web_id FROM $table WHERE web_url='$web_url'");
    	if (count($query)) {
        	msgbox('您所添加的网站已存在！');
    	}
		
		$web_data['user_id'] = $myself['user_id'];
		$Db->insert($table, $web_data);
		$stat_data['web_id'] = $Db->insert_id();

		$Db->insert(table('webdata'), $stat_data);
		$Db->query("UPDATE ".table('categories')." SET cate_postcount=cate_postcount+1 WHERE cate_id=$cate_id");
		update_cache('archives');
		
		msgbox('网站添加成功！', $fileurl.'?act=add&cate_id='.$cate_id);	
	} elseif ($action == 'saveedit') {
		$web_id = I('post.web_id','','intval');
		$where = "web_id = '$web_id'";
		unset($web_data['web_ctime']);
		$web_data['web_utime'] =time();
		$Db->update($table, $web_data, $where);

		$Db->update(table('webdata'), $stat_data, $where);
		
		$Db->query("UPDATE ".table('categories')." SET cate_postcount=cate_postcount+1 WHERE cate_id=$cate_id");
		update_cache('archives');
		
		msgbox('网站修改成功！', $fileurl);
	}
}

/** del */
if ($action == 'del') {
	// $web_id = I('get.web_id');
	$web_ids = (array) ($_POST['web_id'] ? $_POST['web_id']:$_GET['web_id']);
	
	$Db->delete($table, 'web_id IN ('.dimplode($web_ids).')');
	$Db->delete(table('webdata'), 'web_id IN ('.dimplode($web_ids).')');
	update_cache('archives');
	unset($web_ids);
	
	msgbox('网站删除成功！', $fileurl);
}

/** move */
if ($action == 'savemove') {
	$web_ids = (array) $_POST['web_id'];
	$cate_id =  I('post.cate_id','','intval');
	if (empty($web_ids)) {
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
	
	$Db->update($table, array('cate_id' => $cate_id), 'web_id IN ('.dimplode($web_ids).')');
	update_cache('archives');
	
	msgbox('网站移动成功！', $fileurl);
}

/** attr */
if ($action == 'saveattr') {
	$web_ids    = (array) $_POST['web_id'];
	$web_ispay  = intval($_POST['web_ispay'],0);
	$web_istop  = intval($_POST['web_istop'],0);
	$web_isbest = intval($_POST['web_isbest'],0);
	$web_status = intval($_POST['web_status']);
	if (empty($web_ids)) {
		msgbox('请选择要设置的内容！');
	}
	

	$websites = $Db->query("SELECT w.web_id, w.web_name, u.user_email FROM $table w LEFT JOIN ".table("users")." u ON w.user_id=u.user_id WHERE w.web_id IN (".dimplode($web_ids).")");
	foreach ($websites as $row) {
		if ($web_status == 3) {
			$site_link = url('home/siteinfo',['wid'=>$row['web_id']]);
			//发送邮件
			// if (!empty($options['smtp_host']) && !empty($options['smtp_port']) && !empty($options['smtp_auth']) && !empty($options['smtp_user'])  && !empty($options['smtp_pass'])) {	
			// 	$Youke->assign('site_name', $options['site_name']);
			// 	$Youke->assign('site_url', $options['site_url']);
			// 	$Youke->assign('web_name', $row['web_name']);
			// 	$Youke->assign('site_link', $site_link);
			// 	$mailbody = $Youke->fetch('audit_mail.html');
				
			// 	if(!$ sendmail($row['user_email'], '['.$options['site_name'].'] 网站已通过审核！', $mailbody);){
			// 		msgbox('您开启了邮件验证，邮件配置错误');
			// 	}
			// }
		}		
		$web_id =$row['web_id'];
		$Db->update($table, array('web_istop' => $web_istop, 'web_isbest' => $web_isbest, 'web_status' => $web_status), "web_id = '$web_id'");
	}
	
	$Db->update($table, array('web_ispay' => $web_ispay,'web_istop' => $web_istop, 'web_isbest' => $web_isbest, 'web_status' => $web_status), 'web_id IN ('.dimplode($web_ids).')');
	
	msgbox('网站属性设置成功！', $fileurl);
}

/** metainfo */
if ($action == 'metainfo') {
	$url = I('get.url');
	if (empty($url)) {
		exit('-2'); //请输入网站域名！
	} else {
		if (!is_valid_domain($url)) {
			exit('-1');  //'请输入正确的网站域名！'
		}
	}
	
    $url  = rtrim($url,'/');
	$meta = get_sitemeta($url);	
    $ico_status  = get_ico($url);
    if(!empty($ico_status)){
      $ico = $url.'/favicon.ico';
    }
	$html='<script type="text/javascript">';

	if(!empty($meta['title'])){
  	$html.='$("#web_name").val("'.$meta['title'].'");';
	}
	if(!empty($meta['keywords'])){
      $html.='$("#web_tags").val("'.$meta['keywords'].'");';
	}
	if(!empty($meta['description'])){
	  $html.='$("#web_intro").val("'.$meta['description'].'");';
	}
	if(!empty($ico)){
      $html.='$("#web_ico").val("'.$ico.'");'; 
	}

	
	$html.='</script>';
	echo $html;
	unset($meta);
}

/** webdata */
if ($action == 'webdata') {
	$url = I('get.url');
	if (empty($url)) {
		exit('-2'); //请输入网站域名！
	} else {
		if (!is_valid_domain($url)) {
			exit('-1');  //'请输入正确的网站域名！'
		}
	}
	
	$url = str_replace('http://','',$url);
	$url = str_replace('https://','',$url);
	$ip  = get_serverip($url);
	$brank = get_baidurank($url);
	$srank = get_sogourank($url);
	$arank = get_alexarank($url);
	$r360 =  get_r360($url);
	echo '<script type="text/javascript">';
	echo '$("#web_ip").val("'.$ip.'");';
	echo '$("#web_brank").val("'.$brank.'");';
	echo '$("#web_r360").val("'.$r360.'");';
	echo '$("#web_srank").val("'.$srank.'");';
	echo '$("#web_arank").val("'.$arank.'");';
	echo '</script>';
}

Youke_display($tempfile);



