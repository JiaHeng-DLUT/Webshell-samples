<?php
switch($act) {
	//####################// 修改头像  //####################//
	case 'logo':
		$menumark = 'setting_logo';
		$info = $db->pe_select('user', array('user_id'=>$_s_user_id), 'user_logo');
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if ($db->pe_update('user', array('user_id'=>$_s_user_id), array('user_logo'=>pe_dbhold($_p_user_logo)))) {
				pe_jsonshow(array('result'=>true, 'show'=>'提交成功'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'提交失败'));
			}
		}
		$seo = pe_seo($menutitle='修改头像');
		include(pe_tpl('setting_logo.html'));
	break;
	//####################// 登录密码修改  //####################//
	case 'pw':
		$menumark = 'setting_pw';
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if (!$db->pe_num('user', array('user_id'=>$_s_user_id, 'user_pw'=>md5($_p_user_oldpw)))) pe_jsonshow(array('result'=>false, 'show'=>'当前密码错误'));
			if (strlen($_p_user_pw) < 6 or strlen($_p_user_pw) > 20) pe_jsonshow(array('result'=>false, 'show'=>'新密码为6-20位字符'));
			if ($_p_user_pw != $_p_user_pw1) pe_jsonshow(array('result'=>false, 'show'=>'新密码与确认密码不一致'));
			if ($db->pe_update('user', array('user_id'=>$_s_user_id), array('user_pw'=>md5($_p_user_pw)))) {
				pe_jsonshow(array('result'=>true, 'show'=>'修改成功'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'修改失败'));
			}
		}
		$seo = pe_seo($menutitle='修改登录密码');
		include(pe_tpl('setting_pw.html'));
	break;
	//####################// 支付密码修改  //####################//
	case 'paypw':
		$menumark = 'setting_pw';
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if ($user['user_paypw'] && !$db->pe_num('user', array('user_id'=>$_s_user_id, 'user_paypw'=>md5($_p_user_oldpw)))) pe_jsonshow(array('result'=>false, 'show'=>'当前密码错误'));
			if (strlen($_p_user_pw) < 6 or strlen($_p_user_pw) > 20) pe_jsonshow(array('result'=>false, 'show'=>'新密码为6-20位字符'));
			if ($_p_user_pw != $_p_user_pw1) pe_jsonshow(array('result'=>false, 'show'=>'新密码与确认密码不一致'));
			if ($db->pe_update('user', array('user_id'=>$_s_user_id), array('user_paypw'=>md5($_p_user_pw)))) {
				pe_jsonshow(array('result'=>true, 'show'=>'修改成功'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'修改失败'));
			}
		}
		$seo = pe_seo($menutitle='修改支付密码');
		include(pe_tpl('setting_paypw.html'));
	break;
	//####################// 个人信息 //####################//
	default:
		$menumark = 'setting_base';
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if ($_p_user_phone) {
				if (!pe_formcheck('phone', $_p_user_phone)) pe_jsonshow(array('result'=>false, 'show'=>'请填写正确的手机号'));
				if ($db->pe_num('user', " and `user_phone` = '".pe_dbhold($_p_user_phone)."' and `user_id` != '{$_s_user_id}'")) pe_jsonshow(array('result'=>false, 'show'=>'手机号已存在'));
			}
			if ($_p_user_email) {
				if (!pe_formcheck('email', $_p_user_email)) pe_jsonshow(array('result'=>false, 'show'=>'请填写正确的邮箱'));
				if ($db->pe_num('user', " and `user_email` = '".pe_dbhold($_p_user_email)."' and `user_id` != '{$_s_user_id}'")) pe_jsonshow(array('result'=>false, 'show'=>'邮箱已存在'));
			}
			$sql_set['user_tname'] = $_p_user_tname;
			$sql_set['user_phone'] = $_p_user_phone;
			$sql_set['user_email'] = $_p_user_email;
			if ($db->pe_update('user', array('user_id'=>$_s_user_id), pe_dbhold($sql_set))) {
				pe_jsonshow(array('result'=>true, 'show'=>'修改成功'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'修改失败'));
			}
		}
		$info = $db->pe_select('user', array('user_id'=>$_s_user_id));				
		$seo = pe_seo($menutitle='个人信息');
		include(pe_tpl('setting_base.html'));
	break;
}
?>