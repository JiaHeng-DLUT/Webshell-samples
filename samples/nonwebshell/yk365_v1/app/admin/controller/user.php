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
$tempfile = 'user.html';
$table = table('users');

if (empty($action)) $action = 'list';

/** list */
if ($action == 'list') {
	$pagetitle = '会员列表';
	
	$user_type = !empty($_GET['user_type'])?htmlspecialchars($_GET['user_type']):'';
	$keywords  = !empty($_POST['keywords'])?htmlspecialchars($_POST['keywords']):'';
	$pageurl   =  url('user',['keywords'=>urlencode($keywords)]);

	$where = '1';
	$where .= !empty($user_type) ? " AND user_type='$user_type'" : "";
	$where .= !empty($keywords) ? " AND user_email like '%$keywords%' OR nick_name like '%$keywords%'" : "";

	$result = get_user_list($where, 'join_time', 'DESC', $start, $pagesize);
	$users = array();
	foreach ($result as $row) {
		$row['user_type'] = $user_types[$row['user_type']];
		$row['join_time'] = date('Y-m-d H:i:s', $row['join_time']);
		$row['user_status'] = $row['user_status'] == 1 ? '<span class="label label-success">正常</span>' : '<span class="label label-danger" >待验证</span>';
		$row['user_operate'] ='<a href="'.url('user').'?act=edit&user_id='.$row['user_id'].'">编辑</a>';
		if($row['user_type'] == 'admin'){
		   $row['user_operate'] .='&nbsp;|&nbsp;<a href="'.url('user').'?act=del&user_id='.$row['user_id'].'" onClick="return confirm(\'确认删除此内容吗？\');">删除</a>';
		}

		$users[] = $row;
	}
	if($user_type){
      $param['user_type'] =$user_type;
	}
    if($keywords){
    		 $param['keywords'] = urlencode($keywords);
    }
    $key_url =  url('user',$param);

	$total = $Db->getCount($table,'*',$where);	
	$showpage = showpage($pageurl, $total, $curpage, $pagesize);
	$Youke->assign('key_url', $key_url);
	$Youke->assign('usertype_option', get_usertype_option($user_type));
	$Youke->assign('user_type', $user_type);
	$Youke->assign('keywords', $keywords);
	$Youke->assign('users', $users);
	$Youke->assign('showpage', $showpage);
	unset($result, $users);
}

/** add */
if ($action == 'add') {
	$pagetitle = '添加会员';
	
	$Youke->assign('usertype_option', get_usertype_option());
	$Youke->assign('status', 1);
	$Youke->assign('h_action', 'saveadd');
}

/** edit */
if ($action == 'edit') {
	$pagetitle = '编辑会员';
	
	$user_id = !empty($_GET['user_id'])?intval($_GET['user_id']):'';
	$user    = get_one_user($user_id);
	if (!$user) {
		msgbox('指定的会员不存在！');
	}
	
	$Youke->assign('usertype_option', get_usertype_option($user['user_type']));
	$Youke->assign('status', $user['user_status']);
	$Youke->assign('user', $user);
	$Youke->assign('h_action', 'saveedit');
}

/** save data */
if (in_array($action, array('saveadd', 'saveedit'))) {
	$user_type   = !empty($_POST['user_type'])?htmlspecialchars($_POST['user_type']):'';
	$user_email  = !empty($_POST['user_email'])?htmlspecialchars($_POST['user_email']):'';
	$user_pass   = !empty($_POST['user_pass'])?htmlspecialchars($_POST['user_pass']):'';
	$nick_name   = !empty($_POST['nick_name'])?htmlspecialchars($_POST['nick_name']):'';
	$user_qq     = !empty($_POST['user_qq'])?htmlspecialchars($_POST['user_qq']):'';
	$user_status = !empty($_POST['user_status'])?intval($_POST['user_status']):'';
	$join_time   = time();
	
	if (empty($user_type)) {
		msgbox('请选择会员类型！');
	}
	
	if (empty($user_email)) {
		msgbox('请输入电子邮箱！');
	} else {
		if (!is_valid_email($user_email)) {
			msgbox('请输入正确的电子邮箱！');
		}
	}
	
	if (empty($user_pass)) {
		msgbox('请输入登录密码！');
	}	
	
	$data = array(
		'user_type' => $user_type,
		'user_email' => $user_email,
		'user_pass' => md5($user_pass),
		'nick_name' => $nick_name,
		'user_qq' => $user_qq,
		'user_status' => $user_status,
		'join_time' => $join_time,
	);
	
	if ($action == 'saveadd') {
    	$query = $Db->query("SELECT user_id FROM $table WHERE user_email='$user_email'");
    	if (count($query)) {
        	msgbox('您所添加的会员已存在！');
    	}
		
		$Db->insert($table, $data);
		
		msgbox('会员添加成功！', url('user',['act'=>'add']));	
	} elseif ($action == 'saveedit') {
		$user_id = intval($_POST['user_id']);
		$where = "user_id = '$user_id'";
		
		$Db->update($table, $data, $where);
		
		msgbox('会员编辑成功！', url('user'));
	}
}

/** del */
if ($action == 'del') {
	$user_ids = (array) ($_POST['user_id'] ? $_POST['user_id'] : $_GET['user_id']);
	
	$Db->delete($table, 'user_id IN ('.dimplode($user_ids).')');
	unset($user_ids);
	
	msgbox('会员删除成功！', url('user'));
}

/** set pass */
if ($action == 'setpass') {
	$user_ids = (array) ($_POST['user_id'] ? $_POST['user_id'] : $_GET['user_id']);
	
	$Db->update($table, array('user_status' => 1), 'user_id IN ('.dimplode($user_ids).')');
	unset($user_ids);
	
	msgbox('所选内容设置成功！', url('user'));
}

/** del */
if ($action == 'nopass') {
	$user_ids = (array) ($_POST['user_id'] ? $_POST['user_id'] : $_GET['user_id']);
	
	$Db->update($table, array('user_status' => 0), 'user_id IN ('.dimplode($user_ids).')');
	unset($user_ids);
	
	msgbox('所选内容设置成功！', url('user'));
}

Youke_display($tempfile);

