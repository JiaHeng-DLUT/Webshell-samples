<?php
/**
 * @copyright   2008-2014 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
switch ($act) {
	//####################// 检测用户名 //####################//
	case 'reg_name':
		$result = $db->pe_num('user', array('user_name'=>pe_dbhold($_g_value))) > 0 ? false : true;
		echo json_encode(array('result'=>$result));
	break;
	//####################// 检测邮箱 //####################//
	case 'reg_email':
		$result = $db->pe_num('user', array('user_email'=>pe_dbhold($_g_value))) > 0 ? false : true;
		echo json_encode(array('result'=>$result));
	break;
	//####################// 检测手机号 //####################//
	case 'phone':
		$result = $db->pe_num('user', " and `user_phone` = '".pe_dbhold($_g_value)."' and `user_id` != '{$_s_user_id}'") > 0 ? false : true;
		echo json_encode(array('result'=>$result));
	break;
	//####################// 检测邮箱 //####################//
	case 'email':
		$result = $db->pe_num('user', " and `user_email` = '".pe_dbhold($_g_value)."' and `user_id` != '{$_s_user_id}'") > 0 ? false : true;
		echo json_encode(array('result'=>$result));
	break;
	//####################// 检测重复绑定银行帐号 //####################//
	case 'userbank':
		$result = $db->pe_num('userbank', " and `userbank_num` = '".pe_dbhold($_g_value)."' and `userbank_id` != '".intval($_g_id)."'") > 0 ? false : true;
		echo json_encode(array('result'=>$result));
	break;
	//####################// 检测图片验证码 //####################//
	case 'authcode':
		$result = ($_g_value && strtolower($_s_authcode) == strtolower($_g_value)) ? true : false;
		echo json_encode(array('result'=>$result));
	break;
	//####################// 检测短信验证码 //####################//
	case 'yzm':
		pe_lead('hook/yzmlog.hook.php');
		echo json_encode(array('result'=>check_yzm($_g_phone ? $_g_phone : $_g_email, $_g_value)));
	break;
	//####################// 发送短信验证码 //####################//
	case 'send_yzm':
		pe_lead('hook/yzmlog.hook.php');
		$user_name = pe_dbhold($_g_value);
		if (stripos($_g_value, '@') === false) {
			$yzm_name = '手机号码';
			$yzm_type = 'phone';
		}
		else {
			$yzm_name = '邮箱';
			$yzm_type = 'email';
		}
		if (!$user_name) pe_jsonshow(array('result'=>false, 'show'=>"请填写账号信息"));
		if ($yzm_type == 'phone' && !pe_formcheck('phone', $user_name)) pe_jsonshow(array('result'=>false, 'show'=>"账号有误"));
		if ($yzm_type == 'email' && !pe_formcheck('email', $user_name)) pe_jsonshow(array('result'=>false, 'show'=>"账号有误"));
		$info = $db->pe_select('user', array("user_{$yzm_type}"=>$user_name), 'user_id');
		//检测号码存在/不存在
		if (in_array($_g_type, array('getpw', 'oldphone'))) {
			if (!$info['user_id']) pe_jsonshow(array('result'=>false, 'show'=>"{$yzm_name}不存在"));
		}
		else {
			if ($info['user_id']) pe_jsonshow(array('result'=>false, 'show'=>"{$yzm_name}已存在"));
		}
		//if (!$_g_authcode or strtolower($_s_authcode) != strtolower($_g_authcode)) pe_jsonshow(array('result'=>false, 'show'=>'请填写图片验证码'));
		$result = send_yzm($yzm_type, $user_name);
		pe_jsonshow($result);
	break;
}
?>