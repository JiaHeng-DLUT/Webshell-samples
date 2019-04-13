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
$tempfile = 'adver.html';
$table = table('advers');

if (empty($action)) $action = 'list';

/** list */
if ($action == 'list') {
	$pagetitle = '广告列表';
	
	$adtype   = !empty($_GET['type'])?intval($_GET['type']):'';
	$adstatus = !empty($_GET['status'])?intval($_GET['status']):'';
	$k        = !empty($_GET['keywords'])?htmlspecialchars($_GET['keywords']):'';
	$keywords = !empty($_POST['keywords'])? htmlspecialchars($_POST['keywords']):$k;
	$pageurl  = url('adver',['type'=>$adtype]);
	$keyurl   = !empty($keywords) ? '&keywords='.urlencode($keywords) : '';
	$pageurl .= $keyurl;
	
	switch ($adtype) {
		case 1 :
			$where = " adver_type=1";
			break;
		case 2 :
			$where = " adver_type=2";
			break;
		default :
			$where = " adver_type>-1";
			break;
	}

	$where .= !empty($keywords) ? " AND adver_name like '%$keywords%'" : "";
	$result = get_adver_list($where, 'adver_id', 'DESC', $start, $pagesize);

	$advers = array();
	foreach ($result as $row) {
		$endtime = $row['adver_date'] + $row['adver_days'] * 24 * 3600;
			
		if ($row['adver_days'] > 0) {
			$row['adver_time_status'] = $endtime > $row['adver_date'] ? '<span class="label label-info">指定期限</span>' : '<span class="label label-danger">已过期</span>';
		} else {
			$row['adver_time_status'] = '<span class="label label-success">长期有效</span>';
		}
		$row['adver_date'] = date('Y-m-d H:i:s', $endtime);
		$row['adver_operate'] = '<a href="'.url('adver',['act'=>'edit','adver_id'=>$row['adver_id']]).'">编辑</a>&nbsp;|&nbsp;<a href="'.url('adver',['act'=>'del','adver_id'=>$row['adver_id']]).'" onClick="return confirm(\'确认删除此内容吗？\');">删除</a>';
		$advers[] = $row;
	}
		
	$total = $Db->getCount($table,"*",$where);	
	$showpage = showpage($pageurl, $total, $curpage, $pagesize);
	
	$Youke->assign('keywords', $keywords);
	$Youke->assign('adtype_option', get_adtype_option($adtype));
	$Youke->assign('advers', $advers);
	$Youke->assign('showpage', $showpage);
	unset($result, $advers);
}

/** add */
if ($action == 'add') {
	$pagetitle = '添加新广告';
		
	$Youke->assign('ad_type', 1);
	$Youke->assign('h_action', 'saveadd');
}

/** edit */
if ($action == 'edit') {
	$pagetitle = '编辑广告';
	
	$adver_id = intval($_GET['adver_id']);
	$adver = get_one_adver($adver_id);
	if (!$adver) {
		msgbox('指定的内容不存在！');
	}
		
	$Youke->assign('ad_type', $adver['adver_type']);
	$Youke->assign('adver', $adver);
	$Youke->assign('h_action', 'saveedit');
}

/** save data */
if (in_array($action, array('saveadd', 'saveedit'))) {
	$adver_type = intval($_POST['adver_type']);
	$adver_name = I('post.adver_name');
	$adver_url  = I('post.adver_url');
	$adver_code  = I('post.adver_code');
	$adver_etips = I('post.adver_etips');
	$adver_days   = intval($_POST['adver_days']);
	$adver_status = intval($_POST['adver_status']);
	$adver_date    = time();

	  if(!get_magic_quotes_gpc()){
//没有开启再去转义，开启就没有必要了
        $adver_code =   I('post.adver_code','','addslashes');
 }else{
 	    $adver_code  =  I('post.adver_code');
 }
	if (empty($adver_name)) {
		msgbox('请输入广告名称！');
	}


	
	$data = array(
		'adver_type'  => $adver_type,
		'adver_name'  => $adver_name,
		'adver_url'   => $adver_url,
		'adver_code'  => $adver_code,
		'adver_etips' => $adver_etips,
		'adver_days'  => $adver_days,
		'adver_date'  => $adver_date,
		'adver_status'=> $adver_status,
	);
	
	if ($action == 'saveadd') {
    	$query = $Db->query("SELECT adver_id FROM $table WHERE adver_name='$adver_name'");
   		if (count($query)) {
        	msgbox('您所添加的广告已存在！');
    	}
		
		$Db->insert($table, $data);
		update_cache('advers');
		
		msgbox('广告添加成功！', url('adver',['act'=>'add']));
	} elseif ($action == 'saveedit') {

		$adver_id = intval($_POST['adver_id']);
		$where   ="adver_id = '$adver_id'";
		
		$Db->update($table, $data, $where);
		update_cache('advers');
		
		msgbox('广告修改成功！', url('adver'));
	}
}

/** del */
if ($action == 'del') {
	$adver_ids = (array) ($_POST['adver_id'] ? $_POST['adver_id'] : intval($_GET['adver_id']));
	
	$Db->delete($table, 'adver_id IN ('.dimplode($adver_ids).')');
	update_cache('advers');
	unset($adver_ids);
	
	msgbox('广告删除成功！',url('adver'));
}

Youke_display($tempfile);

