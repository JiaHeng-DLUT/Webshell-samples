<?php
/**
 * @copyright   2008-2014 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'user';
pe_lead('hook/user.hook.php');
$cache_userlevel = cache::get('userlevel');
$cache_userlevel_arr = cache::get('userlevel_arr');
switch ($act) {
	//####################// 会员修改 //####################//
	case 'edit':
		$user_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			$_p_user_pw && $_p_info['user_pw'] = md5($_p_user_pw);
			$_p_user_paypw && $_p_info['user_paypw'] = md5($_p_user_paypw);
			if ($db->pe_update('user', array('user_id'=>$user_id), pe_dbhold($_p_info))) {
				userlevel_callback($user_id);
				pe_success('修改成功!', $_g_fromto);
			}
			else {
				pe_error('修改失败...');
			}
		}
		$info = $db->pe_select('user', array('user_id'=>$user_id));
		$seo = pe_seo($menutitle='修改会员', '', '', 'admin');
		include(pe_tpl('user_add.html'));
	break;
	//####################// 会员删除 //####################//
	case 'del':
		pe_token_match();
		if ($db->pe_delete('user', array('user_id'=>is_array($_p_user_id) ? $_p_user_id : intval($_g_id)))) {
			pe_success('会员删除成功!');
		}
		else {
			pe_error('会员删除失败...');
		}
	break;
	//####################// 充值(扣除)金额 //####################//
	case 'addmoney':
	case 'delmoney':
		$user_id = intval($_g_id);
		$info = $db->pe_select('user', array('user_id'=>$user_id));
		if (isset($_p_pesubmit)) {
			pe_token_match();
			$type = $act == 'delmoney' ? 'del' : 'add';
			$user_money = pe_num($_p_money, 'floor', 1);
			if (!$user_id) pe_jsonshow(array('result'=>false, 'show'=>'用户不存在'));
			if ($user_money < 0.1) pe_jsonshow(array('result'=>false, 'show'=>'请填写金额'));			
			if ($type == 'del' && $user_money > $info['user_money']) pe_jsonshow(array('result'=>false, 'show'=>'余额不足'));
			if (!$_p_text) pe_jsonshow(array('result'=>false, 'show'=>'请填写说明'));
			if (add_moneylog($user_id, $type, $user_money, $_p_text)) {
				pe_jsonshow(array('result'=>true, 'show'=>'操作成功'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'操作失败'));
			}
		}
		$cashout = $db->pe_select('cashout', array('user_id'=>$user_id, 'cashout_state'=>0));
		$seo = pe_seo($menutitle='充值(扣除)金额', '', '', 'admin');
		include(pe_tpl('user_addmoney.html'));
	break;
	//####################// 增加(扣除)积分 //####################//
	case 'addpoint':
	case 'delpoint':
		$user_id = intval($_g_id);
		$info = $db->pe_select('user', array('user_id'=>$user_id));
		if (isset($_p_pesubmit)) {
			pe_token_match();
			$type = $act == 'delpoint' ? 'del' : 'add';
			$user_point = intval($_p_point);
			if (!$user_id) pe_jsonshow(array('result'=>false, 'show'=>'用户不存在'));
			if ($user_point < 1) pe_jsonshow(array('result'=>false, 'show'=>'请填写积分'));
			if ($type == 'del' && $user_point > $info['user_point']) pe_jsonshow(array('result'=>false, 'show'=>'余额不足'));			
			if (!$_p_text) pe_jsonshow(array('result'=>false, 'show'=>'请填写说明'));
			if (add_pointlog($user_id, $type, $user_point, $_p_text)) {
				pe_jsonshow(array('result'=>true, 'show'=>'操作成功'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'操作失败'));
			}
		}
		$seo = pe_seo($menutitle='增加(扣除)积分', '', '', 'admin');
		include(pe_tpl('user_addpoint.html'));
	break;
	//####################// 变更推荐人 //####################//
	case 'add_tguser':
		$user_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			$user_name = pe_dbhold($_p_user_name);
			if ($user_name) {
				$tguser = $db->pe_select('user', array('user_name'=>$user_name));			
				if (!$tguser['user_id']) pe_jsonshow(array('result'=>false, 'show'=>'用户不存在'));
				if ($tguser['user_id'] == $user_id) pe_jsonshow(array('result'=>false, 'show'=>'推荐人不能为本人'));			
				if ($tguser['tguser_id'] == $user_id) pe_jsonshow(array('result'=>false, 'show'=>'不能互相推荐'));
			}
			else {
				$tguser['user_id'] = 0;
				$tguser['user_name'] = '';
			}
			$sql_set['tguser_id'] = $tguser['user_id'];
			$sql_set['tguser_name'] = $tguser['user_name'];			
			if ($db->pe_update('user', array('user_id'=>$user_id), pe_dbhold($sql_set))) {
				$db->query("TRUNCATE TABLE  `".dbpre."tguser`");
				//推荐关系父子数组
				$tguser_arr = $db->index('tguser_id|user_id')->pe_selectall('user', " and tguser_id > 0", 'user_id, user_name, user_atime, tguser_id, tguser_name');
				$user_list = $db->pe_selectall('user', array('order by'=>'user_id asc'), 'user_id, user_name');
				foreach ($user_list as $v) {
					tguser_build($v['user_id'], $v);
				}
				//生成新的推荐记录
				/*tguser_link($tguser_id);
				foreach ($tguser_list as $v) {
					tguser_build($v['user_id'], $v, 1);
				}*/	
				pe_jsonshow(array('result'=>true, 'show'=>'修改成功'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'修改失败'));
			}
		}
		$info = $db->pe_select('user', array('user_id'=>$user_id));
		$seo = pe_seo($menutitle='添加推荐人', '', '', 'admin');
		include(pe_tpl('user_add_tguser.html'));
	break;
	//####################// 发送邮件 //####################//
	case 'email':
		if (isset($_p_pesubmit)) {
			pe_token_match();
			!$_p_email_user && pe_error('收件人必须填写...');
			!$_p_email_name && pe_error('邮件标题必须填写...');
			!$_p_email_text && pe_error('邮件内容必须填写...');
			$email_user = explode(',', $_p_email_user);
			foreach ($email_user as $k=>$v) {
				if (!$v) continue;
				$noticelog_list[$k]['noticelog_user'] = pe_dbhold($v);
				$noticelog_list[$k]['noticelog_name'] = pe_dbhold($_p_email_name);
				$noticelog_list[$k]['noticelog_text'] = $_p_email_text;
				$noticelog_list[$k]['noticelog_atime'] = time();			
			}
			if ($db->pe_insert('noticelog', $noticelog_list)) {
				pe_success('发送成功!', '', 'dialog');
			}
			else {
				pe_error('发送失败...');
			}
		}
		$info_list = $db->pe_selectall('user', array('user_id'=>explode(',', $_g_id)));
		$email_user = array();
		foreach ($info_list as $v) {
			$v['user_email'] && $email_user[] = $v['user_email'];
		}
		$seo = pe_seo($menutitle='发送邮件', '', '', 'admin');
		include(pe_tpl('user_email.html'));
	break;
	//####################// 会员登录 //####################//
	case 'login':
		pe_token_match();
		$user = $db->pe_select('user', array('user_id'=>intval($_g_id)));
		$_SESSION['user_idtoken'] = md5($user['user_id'].$pe['host_root']);
		$_SESSION['user_id'] = $user['user_id'];
		$_SESSION['user_name'] = $user['user_name'];
		$_SESSION['user_ltime'] = $user['user_ltime'];
		$_SESSION['pe_token'] = pe_token_set($_SESSION['user_idtoken']);
		pe_success('会员登录成功！', 'user.php');
	break;
	//####################// 会员列表 //####################//
	default:
		$_g_name && $sqlwhere .= " and `user_name` like '%{$_g_name}%'";
		$_g_phone && $sqlwhere .= " and `user_phone` like '%{$_g_phone}%'";
		$_g_email && $sqlwhere .= " and `user_email` like '%{$_g_email}%'";
		$_g_userlevel_id && $sqlwhere .= " and `userlevel_id` = '{$_g_userlevel_id}'";
		if (in_array($_g_orderby, array('ltime|desc', 'point|desc', 'ordernum|desc'))) {
			$orderby = explode('|', $_g_orderby);
			$sqlwhere .= " order by `user_{$orderby[0]}` {$orderby[1]}";
		}
		else {
			$sqlwhere .= " order by `user_id` desc";
		}
		$info_list = $db->pe_selectall('user', $sqlwhere, '*', array(50, $_g_page));

		$tongji['all'] = $db->pe_num('user');
		$tongji_arr = $db->index('userlevel_id')->pe_selectall('user', array('group by'=>'userlevel_id'), 'userlevel_id, count(1) as `num`');
		foreach ($cache_userlevel as $k=>$v) {
			$tongji[$k] = intval($tongji_arr[$k]['num']);
		}
		$seo = pe_seo($menutitle='会员列表', '', '', 'admin');
		include(pe_tpl('user_list.html'));
	break;
}
//重建推层级表
function tguser_build($user_id, $tguser, $level=1) {
	global $db, $tguser_arr;
	if (is_array($tguser_arr[$user_id])) {
		foreach ($tguser_arr[$user_id] as $v) {
			$sql_set['tguser_id'] = $tguser['user_id'];
			$sql_set['tguser_name'] = $tguser['user_name'];
			$sql_set['tguser_level'] = $level;
			$sql_set['user_id'] = $v['user_id'];
			$sql_set['user_name'] = $v['user_name'];
			$sql_set['user_atime'] = $v['user_atime'];		
			$db->pe_insert('tguser', pe_dbhold($sql_set));
			tguser_build($v['user_id'], $tguser, $level+1);
		}
	}
}
//获取推荐关系链(已废弃)
/*function tguser_link($user_id) {
	global $db, $tguser_list, $tguser_arr;
	$info_list = $db->pe_selectall('user', array('tguser_id'=>$user_id));
	foreach ($info_list as $k=>$v) {
		$db->pe_delete('tguser', array('user_id'=>$v['user_id']));
		$tguser_list[$v['user_id']] = $v;
		$tguser_arr["{$v['tguser_id']}|{$v['user_id']}"] = $v;
		tguser_link($v['user_id']);
	}
}*/
?>