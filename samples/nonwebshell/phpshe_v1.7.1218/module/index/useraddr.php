<?php
$menumark = 'useraddr';
pe_lead('hook/order.hook.php');
switch($act) {
	//####################// 添加地址 //####################//
	case 'add':
		if (isset($_p_pesubmit)) {
			pe_token_match();
			//if (!$cache_setting['web_guestbuy']) pe_jsonshow(array('result'=>false, 'show'=>'请先登录...'));
			if (!$_p_user_tname) pe_jsonshow(array('result'=>false, 'show'=>'请填写收货人'));
			if (!pe_formcheck('phone', $_p_user_phone)) pe_jsonshow(array('result'=>false, 'show'=>'请填写正确的手机号'));
			if (!$_p_address_province) pe_jsonshow(array('result'=>false, 'show'=>'请选择省份'));
			if (!$_p_address_city) pe_jsonshow(array('result'=>false, 'show'=>'请选择城市'));
			if (!$_p_address_area) pe_jsonshow(array('result'=>false, 'show'=>'请选择区县'));		
			if (!$_p_address_text) pe_jsonshow(array('result'=>false, 'show'=>'请填写详细地址'));
			$sql_set['address_province'] = $_p_address_province;
			$sql_set['address_city'] = $_p_address_city;
			$sql_set['address_area'] = $_p_address_area;
			$sql_set['address_text'] = $_p_address_text;
			$sql_set['address_atime'] = time();
			$sql_set['address_default'] = intval($_p_address_default);
			$sql_set['user_id'] = $_s_user_id;
			$sql_set['user_name'] = $_s_user_name;
			$sql_set['user_tname'] = $_p_user_tname;
			$sql_set['user_phone'] = $_p_user_phone;
			useraddr_add($sql_set);					
			/*if ($_p_address_default == 1) {
				$db->pe_update('useraddr', array('user_id'=>$user_id), array('address_default'=>0));
			}	
			if ($address_id = $db->pe_insert('useraddr', pe_dbhold($sql_set))) {
				pe_jsonshow(array('result'=>true, 'show'=>'添加成功', 'id'=>$address_id));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'添加失败...'));
			}*/
		}
		$seo = pe_seo($menutitle='新增地址');
		include(pe_tpl('useraddr_add.html'));
	break;
	//####################// 地址列表 //####################//
	default:
		useraddr_list(pe_dbhold($_g_id));
		/*$info_list = $db->pe_selectall('useraddr', array('user_id'=>$user_id, 'order by'=>'address_default desc, address_id desc'), '*', array(30, $_g_page));
		foreach ($info_list as $k=>$v) {
			if ($address_id && $address_id == $v['address_id']) {
				$info_list[$k]['sel'] = 1;
			}
			elseif (!$address_id && $k == 0) {
				$info_list[$k]['sel'] = 1;			
			}
		}
		pe_jsonshow(array('result'=>true, 'list'=>$info_list));*/	
	break;
}
?>