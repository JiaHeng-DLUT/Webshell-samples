<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
switch ($act) {
	//####################// 管理员退出 //####################//
	case 'logout':
		unset($_SESSION['admin_idtoken'], $_SESSION['admin_id'], $_SESSION['admin_name']);
		pe_success('退出成功！', 'admin.php');
	break;
	//####################// 管理员登录 //####################//
	default:
		if (isset($_p_pesubmit)) {
			$sql_set['admin_name'] = $_p_admin_name;
			$sql_set['admin_pw'] = md5($_p_admin_pw);
			if (!$_p_authcode || strtolower($_s_authcode) != strtolower($_p_authcode)) pe_jsonshow(array('result'=>false, 'show'=>'验证码错误'));
			if ($info = $db->pe_select('admin', pe_dbhold($sql_set))) {
				$db->pe_update('admin', array('admin_id'=>$info['admin_id']), array('admin_ltime'=>time()));
				$_SESSION['admin_idtoken'] = md5($info['admin_id'].$pe['host_root']);
				$_SESSION['admin_id'] = $info['admin_id'];
				$_SESSION['admin_name'] = $info['admin_name'];
				$_SESSION['pe_token'] = pe_token_set($_SESSION['admin_idtoken']);
				pe_jsonshow(array('result'=>true, 'show'=>'登录成功'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'帐号或密码错误'));
			}
		}
		$seo = pe_seo('管理员登录', '', '', 'admin');
		include(pe_tpl('do_login.html'));
	break;
}
?>