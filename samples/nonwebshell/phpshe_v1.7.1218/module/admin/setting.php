<?php
/**
 * @copyright   2008-2014 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'setting';
pe_lead('hook/cache.hook.php');
switch ($act) {
	//####################// 积分设置 //####################//
	case 'point':
		if (isset($_p_pesubmit)) {
			pe_token_match();
			$sql = "update `".dbpre."setting` set `setting_value` = case `setting_key`
				when 'point_state' then '".pe_dbhold($_p_info['point_state'])."'
				when 'point_money' then '".pe_dbhold($_p_info['point_money'])."'
				when 'point_reg' then '".pe_dbhold($_p_info['point_reg'])."'
				when 'point_login' then '".pe_dbhold($_p_info['point_login'])."'
				when 'point_comment' then '".pe_dbhold($_p_info['point_comment'])."' else `setting_value` end";
			if ($db->sql_update($sql)) {
				cache_write('setting');
				pe_success('设置成功!');
			}
			else {
				pe_error('设置失败...');
			}
		}
		$info = $db->index('setting_key')->pe_selectall('setting');		
		$seo = pe_seo($menutitle='积分设置', '', '', 'admin');
		include(pe_tpl('setting_point.html'));		
	break;
	//####################// 短信设置 //####################//
	case 'sms':
		if (isset($_p_pesubmit)) {
			pe_token_match();
			$sql = "update `".dbpre."setting` set `setting_value` = case `setting_key`
				when 'sms_key' then '".pe_dbhold($_p_info['sms_key'])."'
				when 'sms_sign' then '".pe_dbhold($_p_info['sms_sign'])."'
				when 'sms_admin' then '".pe_dbhold($_p_info['sms_admin'])."' else `setting_value` end";
			if ($db->sql_update($sql)) {
				cache_write('setting');
				pe_success('设置成功!');
			}
			else {
				pe_error('设置失败...');
			}
		}
		$info = $db->index('setting_key')->pe_selectall('setting');	
		$notice_list = $db->index('notice_obj|notice_type')->pe_selectall('notice');
		$seo = pe_seo($menutitle='短信设置', '', '', 'admin');
		include(pe_tpl('setting_sms.html'));
	break;
	//####################// 短信测试 //####################//
	case 'sms_test':
		pe_token_match();
		if (!$_g_user) pe_error('管理员手机号未填写...');
		foreach (explode(',', $_g_user) as $k=>$v) {
			if (!$v) continue;
			$sql_set[$k]['noticelog_type'] = 'sms';
			$sql_set[$k]['noticelog_user'] = pe_dbhold($v);
			$sql_set[$k]['noticelog_name'] = '';
			$sql_set[$k]['noticelog_text'] = "【简好网络】尊敬的用户：您好，欢迎使用简好网络旗下软件 - PHPSHE商城系统，官网：http://www.phpshe.com";
			$sql_set[$k]['noticelog_atime'] = time();			
		}
		if ($db->pe_insert('noticelog', $sql_set)) {
			pe_success('发送成功!');
		}
		else {
			pe_error('发送失败...');
		}
	break;
	//####################// 邮箱设置 //####################//
	case 'email':
		if (isset($_p_pesubmit)) {
			pe_token_match();
			$sql = "update `".dbpre."setting` set `setting_value` = case `setting_key`
				when 'email_smtp' then '".pe_dbhold($_p_info['email_smtp'])."'
				when 'email_ssl' then '".pe_dbhold($_p_info['email_ssl'])."'
				when 'email_port' then '".pe_dbhold($_p_info['email_port'])."'
				when 'email_name' then '".pe_dbhold($_p_info['email_name'])."'
				when 'email_pw' then '".pe_dbhold($_p_info['email_pw'])."'
				when 'email_nname' then '".pe_dbhold($_p_info['email_nname'])."'
				when 'email_admin' then '".pe_dbhold($_p_info['email_admin'])."' else `setting_value` end";
			if ($db->sql_update($sql)) {
				cache_write('setting');
				pe_success('设置成功!');
			}
			else {
				pe_error('设置失败...');
			}
		}
		$info = $db->index('setting_key')->pe_selectall('setting');
		$notice_list = $db->index('notice_obj|notice_type')->pe_selectall('notice');			
		$seo = pe_seo($menutitle='邮箱设置', '', '', 'admin');
		include(pe_tpl('setting_email.html'));		
	break;
	//####################// 邮件测试 //####################//
	case 'email_test':
		pe_token_match();
		if (!$_g_user) pe_error('管理员邮箱未填写...');
		foreach (explode(',', $_g_user) as $k=>$v) {
			if (!$v) continue;
			$sql_set[$k]['noticelog_type'] = 'email';
			$sql_set[$k]['noticelog_user'] = pe_dbhold($v);
			$sql_set[$k]['noticelog_name'] = 'PHPSHE商城系统测试邮件';
			$sql_set[$k]['noticelog_text'] = '尊敬的用户：您好，欢迎使用简好网络旗下软件 - PHPSHE商城系统<br/><br/>简好网络官网：http://www.phpshe.com<br/><br/>邮件发送日期：'.pe_date(time());
			$sql_set[$k]['noticelog_atime'] = time();			
		}
		if ($db->pe_insert('noticelog', $sql_set)) {
			pe_success('发送成功!');
		}
		else {
			pe_error('发送失败...');
		}	
	break;
	//####################// 会员设置 //####################//
	case 'user':
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if ($_p_info['cashout_min'] <= 0) $_p_info['cashout_min'] = 0.1;
			$sql = "update `".dbpre."setting` set `setting_value` = case `setting_key`
				when 'web_guestbuy' then '".intval($_p_info['web_guestbuy'])."'
				when 'web_checkphone' then '".intval($_p_info['web_checkphone'])."'
				when 'web_checkemail' then '".intval($_p_info['web_checkemail'])."'
				when 'cashout_min' then '".round($_p_info['cashout_min'], 1)."'
				when 'cashout_fee' then '".(round($_p_info['cashout_fee'], 2)/100)."'
				when 'tg_state' then '".intval($_p_info['tg_state'])."'
				when 'tg_fc1' then '".(round($_p_info['tg_fc1'], 2)/100)."'
				when 'tg_fc2' then '".(round($_p_info['tg_fc2'], 2)/100)."'
				when 'tg_fc3' then '".(round($_p_info['tg_fc3'], 2)/100)."' else `setting_value` end";
			if ($db->sql_update($sql)) {
				cache_write('setting');
				pe_success('设置成功!');
			}
			else {
				pe_error('设置失败...');
			}
		}
		$info = $db->index('setting_key')->pe_selectall('setting');
		$seo = pe_seo($menutitle='会员设置', '', '', 'admin');
		include(pe_tpl('setting_user.html'));
	break;
	//####################// 网站设置 //####################//
	default:
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if ($_FILES['web_logo']['size']) {
				pe_lead('include/class/upload.class.php');
				$upload = new upload($_FILES['web_logo']);
				$_p_info['web_logo'] = $upload->filehost;
				$sqlset .= "when 'web_logo' then '{$upload->filehost}'";
			}
			if ($_FILES['wap_logo']['size']) {
				pe_lead('include/class/upload.class.php');
				$upload = new upload($_FILES['wap_logo']);
				$_p_info['wap_logo'] = $upload->filehost;
				$sqlset .= "when 'wap_logo' then '{$upload->filehost}'";
			}
			if ($_FILES['web_qrcode']['size']) {
				pe_lead('include/class/upload.class.php');
				$upload = new upload($_FILES['web_qrcode']);
				$_p_info['web_qrcode'] = $upload->filehost;
				$sqlset .= "when 'web_qrcode' then '{$upload->filehost}'";
			}
			$sql = "update `".dbpre."setting` set `setting_value` = case `setting_key` {$sqlset}
				when 'web_title' then '".pe_dbhold($_p_info['web_title'])."'
				when 'web_keywords' then '".pe_dbhold($_p_info['web_keywords'])."'
				when 'web_description' then '".pe_dbhold($_p_info['web_description'])."'
				when 'web_copyright' then '".pe_dbhold($_p_info['web_copyright'])."'
				when 'web_icp' then '".pe_dbhold($_p_info['web_icp'])."'
				when 'web_phone' then '".pe_dbhold($_p_info['web_phone'])."'
				when 'web_qq' then '".pe_dbhold($_p_info['web_qq'])."'
				when 'web_hotword' then '".pe_dbhold($_p_info['web_hotword'])."'
				when 'web_wlname' then '".pe_dbhold($_p_info['web_wlname'])."'
				when 'web_tongji' then '".pe_dbhold($_p_info['web_tongji'], 'all')."' else `setting_value` end";
			if ($db->sql_update($sql)) {
				cache_write('setting');
				pe_success('设置成功!');
			}
			else {
				pe_error('设置失败...');
			}
		}	
		$info = $db->index('setting_key')->pe_selectall('setting');
		$seo = pe_seo($menutitle='网站设置', '', '', 'admin');
		include(pe_tpl('setting_base.html'));
	break;
}
?>