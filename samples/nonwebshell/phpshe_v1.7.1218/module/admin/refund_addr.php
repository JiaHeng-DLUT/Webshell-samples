<?php
$menumark = 'refund_addr';
switch($act) {
	//####################// 添加地址 //####################//
	case 'add':
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if (!$_p_info['refund_tname']) pe_jsonshow(array('result'=>false, 'show'=>'请填写收货人'));
			if (!$_p_info['refund_phone']) pe_jsonshow(array('result'=>false, 'show'=>'请填写手机号码'));
			if (!$_p_info['refund_address']) pe_jsonshow(array('result'=>false, 'show'=>'请填写退货地址'));
			if ($db->pe_insert('refund_addr', pe_dbhold($_p_info))) {
				pe_jsonshow(array('result'=>true, 'show'=>'添加成功'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'添加失败'));
			}
		}
		$seo = pe_seo($menutitle='新增地址');
		include(pe_tpl('refund_addr_add.html'));
	break;
	//####################// 修改地址 //####################//
	case 'edit':
		$address_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if (!$_p_info['refund_tname']) pe_jsonshow(array('result'=>false, 'show'=>'请填写收货人'));
			if (!$_p_info['refund_phone']) pe_jsonshow(array('result'=>false, 'show'=>'请填写手机号码'));
			if (!$_p_info['refund_address']) pe_jsonshow(array('result'=>false, 'show'=>'请填写退货地址'));					
			if ($db->pe_update('refund_addr', array('address_id'=>$address_id), pe_dbhold($_p_info))) {
				pe_jsonshow(array('result'=>true, 'show'=>'修改成功'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'修改失败'));
			}
		}
		$info = $db->pe_select('refund_addr', array('address_id'=>$address_id));
		$seo = pe_seo($menutitle='修改地址');
		include(pe_tpl('refund_addr_add.html'));
	break;
	//####################// 地址删除 //####################//
	case 'del':
		pe_token_match();
		if ($db->pe_delete('refund_addr', array('address_id'=>is_array($_p_address_id) ? $_p_address_id : $_g_id))) {
			pe_success('删除成功！');
		}
		else {
			pe_error('删除失败...');
		}
	break;
	//####################// 地址排序 //####################//
	case 'order':
		pe_token_match();
		foreach ($_p_address_order as $k=>$v) {
			$result = $db->pe_update('refund_addr', array('address_id'=>$k), array('address_order'=>$v));
		}
		if ($result) {
			pe_success('排序成功!');
		}
		else {
			pe_error('排序失败...');
		}
	break;
	//####################// 地址列表 //####################//
	default:
		$info_list = $db->pe_selectall('refund_addr', array('order by'=>'`address_order` asc, `address_id` desc'));
		$seo = pe_seo($menutitle='退货地址');
		include(pe_tpl('refund_addr_list.html'));
	break;
}
?>