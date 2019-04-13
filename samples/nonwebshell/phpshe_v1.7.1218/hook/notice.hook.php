<?php
//发送邮件/短信通知
function add_noticelog($user_id, $type, $info = '') {
	global $db, $cache_setting;
	$cache_notice = cache::get('notice');
	$notice = $cache_notice[$type];
	$user = $db->pe_select('user', array('user_id'=>$user_id), 'user_phone, user_email');
	//发送用户邮件通知
	if ($notice['user']['notice_email_state'] && $user['user_email']) {
		$info_list['noticelog_type'] = 'email';
		$info_list['noticelog_user'] = $user['user_email'];
		$info_list['noticelog_name'] = notice_tag_replace($notice['user']['notice_email_name'], $info);
		$info_list['noticelog_text'] = notice_tag_replace($notice['user']['notice_email_text'], $info);
		$info_list['noticelog_atime'] = time();
		$sql_set[] = pe_dbhold($info_list, array('noticelog_text'));
	}
	//发送用户短信通知
	if ($notice['user']['notice_sms_state'] && $info['user_phone']) {
		$info_list['noticelog_type'] = 'sms';
		$info_list['noticelog_user'] = $info['user_phone'];
		$info_list['noticelog_name'] = '';
		$info_list['noticelog_text'] = "【{$cache_setting['sms_sign']}】".notice_tag_replace($notice['user']['notice_sms_text'], $info);
		$info_list['noticelog_atime'] = time();
		$sql_set[] = pe_dbhold($info_list);
	}
	//发送管理员邮件通知
	if ($notice['admin']['notice_email_state'] && $cache_setting['email_admin']) {
		foreach (explode(',', $cache_setting['email_admin']) as $v) {
			$info_list['noticelog_type'] = 'email';
			$info_list['noticelog_user'] = $v;			
			$info_list['noticelog_name'] = notice_tag_replace($notice['admin']['notice_email_name'], $info);
			$info_list['noticelog_text'] = notice_tag_replace($notice['admin']['notice_email_text'], $info);
			$info_list['noticelog_atime'] = time();
			$sql_set[] = pe_dbhold($info_list, array('noticelog_text'));	
		}		
	}
	//发送管理员短信通知
	if ($notice['admin']['notice_sms_state'] && $cache_setting['sms_admin']) {
		foreach (explode(',', $cache_setting['sms_admin']) as $v) {
			$info_list['noticelog_type'] = 'sms';
			$info_list['noticelog_user'] = $v;
			$info_list['noticelog_name'] = '';
			$info_list['noticelog_text'] = "【{$cache_setting['sms_sign']}】".notice_tag_replace($notice['admin']['notice_sms_text'], $info);
			$info_list['noticelog_atime'] = time();
			$sql_set[] = pe_dbhold($info_list);	
		}		
	}
	if (is_array($sql_set)) $db->pe_insert('noticelog', $sql_set);
	add_wechat_noticelog($user_id, $type, $info);
}

//发送微信模板通知
function add_wechat_noticelog($user_id, $type, $info = '') {
	global $db, $pe, $cache_setting;
	$cache_notice = cache::get('wechat_notice');
	$notice = $cache_notice[$type];
	$user = $db->pe_select('user', array('user_id'=>$user_id));
	switch($type) {
		case 'order_add':
			//统计订单商品数量
			$tj = $db->pe_select('orderdata', array('order_id'=>$info['order_id']), 'sum(product_num) as `num`');
			if ($notice['user']['notice_state'] && $user['user_wx_openid']) {
				$info_list[0]['noticelog_data']['first'] = array('value'=>'亲，您的订单已提交成功，请及时付款哦');
				$info_list[0]['noticelog_data']['keyword1'] = array('value'=>$info['order_id']);
				$info_list[0]['noticelog_data']['keyword2'] = array('value'=>$info['order_name']);
				$info_list[0]['noticelog_data']['keyword3'] = array('value'=>"{$tj['num']}件");
				$info_list[0]['noticelog_data']['keyword4'] = array('value'=>"{$info['order_money']}元");
				$info_list[0]['noticelog_data']['keyword5'] = array('value'=>$info['order_payment_name']);
				$info_list[0]['noticelog_url'] = "{$pe['host_root']}user.php?mod=order&act=view&id={$info['order_id']}";
				$info_list[0]['noticelog_tpl'] = $notice['user']['notice_tpl'];
				$info_list[0]['noticelog_tplid'] = $notice['user']['notice_tplid'];
				$info_list[0]['user_id'] = $user['user_id'];
				$info_list[0]['user_name'] = $user['user_name'];
				$info_list[0]['user_wx_openid'] = $user['user_wx_openid'];
			}
			if ($notice['admin']['notice_state'] && $cache_setting['wechat_admin_openid']) {
				foreach (explode(',', $cache_setting['wechat_admin_openid']) as $k=>$v) {
					$info_list[$k+1]['noticelog_data']['first'] = array('value'=>'您好，您收到了一个新订单');
					$info_list[$k+1]['noticelog_data']['keyword1'] = array('value'=>$info['order_id']);
					$info_list[$k+1]['noticelog_data']['keyword2'] = array('value'=>$info['order_name']);
					$info_list[$k+1]['noticelog_data']['keyword3'] = array('value'=>"{$tj['num']}件");
					$info_list[$k+1]['noticelog_data']['keyword4'] = array('value'=>"{$info['order_money']}元");
					$info_list[$k+1]['noticelog_data']['keyword5'] = array('value'=>$info['order_payment_name']);
					$info_list[$k+1]['noticelog_data']['remark'] = array('value'=>'付款状态：未支付');
					$info_list[$k+1]['noticelog_tpl'] = $notice['admin']['notice_tpl'];
					$info_list[$k+1]['noticelog_tplid'] = $notice['admin']['notice_tplid'];
					$info_list[$k+1]['user_wx_openid'] = $v;
				}
			}
		break;
		case 'order_pay':
			if ($notice['user']['notice_state'] && $user['user_wx_openid']) {
				$info_list[0]['noticelog_data']['first'] = array('value'=>'亲，您的订单已支付成功，正在为您备货，请耐心等待');
				$info_list[0]['noticelog_data']['keyword1'] = array('value'=>"{$info['order_money']}元");
				$info_list[0]['noticelog_data']['keyword2'] = array('value'=>$info['order_name']);
				$info_list[0]['noticelog_data']['keyword3'] = array('value'=>$info['order_payment_name']);
				$info_list[0]['noticelog_data']['keyword4'] = array('value'=>$info['order_id']);
				$info_list[0]['noticelog_data']['keyword5'] = array('value'=>pe_date(time()));
				$info_list[0]['noticelog_url'] = "{$pe['host_root']}user.php?mod=order&act=view&id={$info['order_id']}";
				$info_list[0]['noticelog_tpl'] = $notice['user']['notice_tpl'];
				$info_list[0]['noticelog_tplid'] = $notice['user']['notice_tplid'];
				$info_list[0]['user_id'] = $user['user_id'];
				$info_list[0]['user_name'] = $user['user_name'];
				$info_list[0]['user_wx_openid'] = $user['user_wx_openid'];
			}
			if ($notice['admin']['notice_state'] && $cache_setting['wechat_admin_openid']) {
				foreach (explode(',', $cache_setting['wechat_admin_openid']) as $k=>$v) {
					$info_list[$k+1]['noticelog_data']['first'] = array('value'=>'您好，您有一笔订单收款成功');
					$info_list[$k+1]['noticelog_data']['keyword1'] = array('value'=>$info['user_name']);
					$info_list[$k+1]['noticelog_data']['keyword2'] = array('value'=>$info['order_id']);
					$info_list[$k+1]['noticelog_data']['keyword3'] = array('value'=>"{$info['order_money']}元");
					$info_list[$k+1]['noticelog_data']['keyword4'] = array('value'=>pe_date(time()));
					$info_list[$k+1]['noticelog_tpl'] = $notice['admin']['notice_tpl'];
					$info_list[$k+1]['noticelog_tplid'] = $notice['admin']['notice_tplid'];
					$info_list[$k+1]['user_wx_openid'] = $v;
				}
			}
		break;
		case 'order_send':
			$info_list[0]['noticelog_data']['first'] = array('value'=>'亲，您的订单已发货，请注意查收');
			$info_list[0]['noticelog_data']['keyword1'] = array('value'=>$info['order_name']);
			$info_list[0]['noticelog_data']['keyword2'] = array('value'=>pe_date(time()));
			$info_list[0]['noticelog_data']['keyword3'] = array('value'=>$info['order_wl_name']);
			$info_list[0]['noticelog_data']['keyword4'] = array('value'=>$info['order_wl_id']);
			$info_list[0]['noticelog_data']['keyword5'] = array('value'=>$info['user_address']);
			$info_list[0]['noticelog_url'] = "{$pe['host_root']}user.php?mod=order&act=view&id={$info['order_id']}";
			$info_list[0]['noticelog_tpl'] = $notice['user']['notice_tpl'];
			$info_list[0]['noticelog_tplid'] = $notice['user']['notice_tplid'];
			$info_list[0]['user_id'] = $user['user_id'];
			$info_list[0]['user_name'] = $user['user_name'];
			$info_list[0]['user_wx_openid'] = $user['user_wx_openid'];
		break;
		case 'order_close':
			$info_list[0]['noticelog_data']['first'] = array('value'=>'亲，您的订单已被关闭');
			$info_list[0]['noticelog_data']['keyword1'] = array('value'=>$info['order_name']);
			$info_list[0]['noticelog_data']['keyword2'] = array('value'=>$info['order_id']);
			$info_list[0]['noticelog_data']['keyword3'] = array('value'=>$info['order_closetext']);
			$info_list[0]['noticelog_url'] = "{$pe['host_root']}user.php?mod=order&act=view&id={$info['order_id']}";
			$info_list[0]['noticelog_tpl'] = $notice['user']['notice_tpl'];
			$info_list[0]['noticelog_tplid'] = $notice['user']['notice_tplid'];
			$info_list[0]['user_id'] = $user['user_id'];
			$info_list[0]['user_name'] = $user['user_name'];
			$info_list[0]['user_wx_openid'] = $user['user_wx_openid'];
		break;
	}
	if (is_array($info_list)) {
		foreach ($info_list as $v) {
			$v['noticelog_name'] = $v['noticelog_data']['first']['value'];
			$v['noticelog_data'] = serialize($v['noticelog_data']);		
			$v['noticelog_atime'] = time();
			$db->pe_insert('wechat_noticelog', pe_dbhold($v, array('noticelog_data', 'noticelog_url')));
		}	
	}
}

//替换通知模板标签
function notice_tag_replace($text, $info) {
	$GLOBALS['notice_taginfo'] = $info;
	if (!function_exists('notice_tag_replace_nn')) {
		function notice_tag_replace_nn($match) { 
			return $GLOBALS['notice_taginfo'][$match[1]];	
		}
	}
	return preg_replace_callback('|{([^}]*)}|', "notice_tag_replace_nn", $text);
	/*if (version_compare(PHP_VERSION, '5.3', '<')) {
		return preg_replace_callback('|{([^}]*)}|', create_function('$match', 'return $GLOBALS[\'notice_taginfo\'][$match[1]];'), $text);	
	}
	else {
		return preg_replace_callback('|{([^}]*)}|', function($match) {
			return $GLOBALS['notice_taginfo'][$match[1]];
		}, $text);	
	}*/
}
?>