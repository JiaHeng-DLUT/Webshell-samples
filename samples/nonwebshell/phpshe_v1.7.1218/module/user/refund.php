<?php
$menumark = 'refund';
pe_lead('hook/order.hook.php');
pe_lead('hook/refund.hook.php');
switch($act) {
	//####################// 申请退款 //####################//
	case 'add':
		$orderdata_id = intval($_g_id);
		$info = $db->pe_select('orderdata', array('orderdata_id'=>$orderdata_id));
		$order = $db->pe_select('order', array('order_id'=>$info['order_id'], 'user_id'=>$_s_user_id));
		$info['refund_type'] = 1;
		$refund_maxmoney = refund_maxmoney($info['order_id'], $info['orderdata_id']);
		if (isset($_p_pesubmit)) {
			$refund_product_money = pe_num($_p_refund_product_money, 'round', 1);
			$refund_wl_money = pe_num($_p_refund_wl_money, 'round', 1);
			$refund_money = $refund_product_money + $refund_wl_money;
			if (!$order['order_id'] or !$info['orderdata_id']) pe_jsonshow(array('result'=>false, 'show'=>"订单不存在"));
			if (!in_array($order['order_state'], array('wsend', 'wget'))) pe_jsonshow(array('result'=>false, 'show'=>"订单状态错误"));
			if ($info['refund_id']) pe_jsonshow(array('result'=>false, 'show'=>'请勿重复申请'));
			if (!in_array($_p_refund_type, array(1,2))) pe_jsonshow(array('result'=>false, 'show'=>'请选择退款类型'));
			if ($_p_refund_type == 2 && $order['order_state'] == 'wsend') pe_jsonshow(array('result'=>false, 'show'=>'未发货订单不能退货'));
			if ($refund_money <= 0) pe_jsonshow(array('result'=>false, 'show'=>'请填写退款金额'));
			if ($refund_product_money > $refund_maxmoney['product']) pe_jsonshow(array('result'=>false, 'show'=>"商品最多可退{$refund_maxmoney['product']}元"));
			if ($refund_wl_money > $refund_maxmoney['wl']) pe_jsonshow(array('result'=>false, 'show'=>"运费最多可退{$refund_maxmoney['wl']}元"));		
			if (!$_p_refund_text) pe_jsonshow(array('result'=>false, 'show'=>'请填写申请原因'));
			$sql_set['refund_id'] = $refund_id = pe_guid('refund|refund_id');
			$sql_set['refund_type'] = intval($_p_refund_type);
			$sql_set['refund_product_money'] = $refund_product_money;
			$sql_set['refund_wl_money'] = $refund_wl_money;
			$sql_set['refund_money'] = $refund_money;
			$sql_set['refund_text'] = $_p_refund_text;
			$sql_set['refund_atime'] = time();
			$sql_set['refund_state'] = 'wcheck';
			$sql_set['order_id'] = $info['order_id'];
			$sql_set['orderdata_id'] = $info['orderdata_id'];
			$sql_set['product_id'] = $info['product_id'];
			$sql_set['product_guid'] = $info['product_guid'];
			$sql_set['product_name'] = $info['product_name'];
			$sql_set['product_rule'] = $info['product_rule'];
			$sql_set['product_logo'] = $info['product_logo'];
			$sql_set['product_money'] = $info['product_money'];	
			$sql_set['product_jjmoney'] = $info['product_jjmoney'];
			$sql_set['product_allmoney'] = $info['product_allmoney'];	
			$sql_set['product_num'] = $info['product_num'];
			$sql_set['user_id'] = $order['user_id'];
			$sql_set['user_name'] = $order['user_name'];
			if ($db->pe_insert('refund', pe_dbhold($sql_set, array('product_rule')))) {
				$db->pe_update('orderdata', array('orderdata_id'=>$info['orderdata_id']), array('refund_id'=>$refund_id, 'refund_state'=>'wcheck'));
				add_refundlog($refund_id, 'add');
				pe_jsonshow(array('result'=>true, 'show'=>'已提交待审核'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'提交失败'));
			}
		}
		$seo = pe_seo($menutitle='申请退款');
		include(pe_tpl('refund_add.html'));
	break;
	//####################// 修改退款 //####################//
	case 'edit':
		$refund_id = pe_dbhold($_g_id);
		$info = $db->pe_select('refund', array('refund_id'=>$refund_id, 'user_id'=>$_s_user_id));
		$refund_maxmoney = refund_maxmoney($info['order_id'], $info['orderdata_id']);	
		if (isset($_p_pesubmit)) {
			$refund_product_money = pe_num($_p_refund_product_money, 'round', 1);
			$refund_wl_money = pe_num($_p_refund_wl_money, 'round', 1);
			$refund_money = $refund_product_money + $refund_wl_money;
			if (!$info['refund_id']) pe_jsonshow(array('result'=>false, 'show'=>'申请不存在'));
			if (!in_array($info['refund_state'], array('wcheck', 'refuse'))) pe_jsonshow(array('result'=>false, 'show'=>'已不能修改'));
			if ($refund_money <= 0) pe_jsonshow(array('result'=>false, 'show'=>'请填写退款金额'));
			if ($refund_product_money > $refund_maxmoney['product']) pe_jsonshow(array('result'=>false, 'show'=>"商品最多可退{$refund_maxmoney['product']}元"));
			if ($refund_wl_money > $refund_maxmoney['wl']) pe_jsonshow(array('result'=>false, 'show'=>"运费最多可退{$refund_maxmoney['wl']}元"));		
			if (!$_p_refund_text) pe_jsonshow(array('result'=>false, 'show'=>'请填写申请原因'));
			$sql_set['refund_product_money'] = $refund_product_money;
			$sql_set['refund_wl_money'] = $refund_wl_money;
			$sql_set['refund_money'] = $refund_money;
			$sql_set['refund_text'] = $_p_refund_text;
			$sql_set['refund_state'] = 'wcheck';
			if ($db->pe_update('refund', array('refund_id'=>$refund_id), pe_dbhold($sql_set))) {
				$db->pe_update('orderdata', array('orderdata_id'=>$info['orderdata_id']), array('refund_id'=>$refund_id, 'refund_state'=>'wcheck'));
				add_refundlog($refund_id, 'edit');
				pe_jsonshow(array('result'=>true, 'show'=>'修改成功'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'修改失败'));
			}
		}
		$seo = pe_seo($menutitle='修改退款');
		include(pe_tpl('refund_add.html'));
	break;
	//####################// 填写单号 //####################//
	case 'send':
		$refund_id = pe_dbhold($_g_id);
		$info = $db->pe_select('refund', array('refund_id'=>$refund_id, 'user_id'=>$_s_user_id));	
		if (isset($_p_pesubmit)) {
			if (!$info['refund_id']) pe_jsonshow(array('result'=>false, 'show'=>'申请不存在'));
			if (!in_array($info['refund_state'], array('wsend'))) pe_jsonshow(array('result'=>false, 'show'=>'参数错误'));
			if (!$_p_refund_wl_name) pe_jsonshow(array('result'=>false, 'show'=>'请填写快递公司'));		
			if (!$_p_refund_wl_id) pe_jsonshow(array('result'=>false, 'show'=>'请填写快递单号'));
			$sql_set['refund_wl_name'] = $_p_refund_wl_name;
			$sql_set['refund_wl_id'] = $_p_refund_wl_id;
			$sql_set['refund_state'] = 'wget';
			if ($db->pe_update('refund', array('refund_id'=>$refund_id), pe_dbhold($sql_set))) {
				$db->pe_update('orderdata', array('orderdata_id'=>$info['orderdata_id']), array('refund_id'=>$refund_id, 'refund_state'=>'wget'));
				add_refundlog($refund_id, 'send');
				pe_jsonshow(array('result'=>true, 'show'=>'等待审核'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'提交失败'));
			}
		}
		$seo = pe_seo($menutitle='填写单号');
		include(pe_tpl('refund_send.html'));
	break;
	//####################// 取消退款 //####################//
	case 'close':
		pe_token_match();
		$refund_id = pe_dbhold($_g_id);
		$info = $db->pe_select('refund', array('refund_id'=>$refund_id, 'user_id'=>$_s_user_id));
		if (!$info['refund_id']) pe_jsonshow(array('result'=>false, 'show'=>'参数错误'));
		if (!in_array($info['refund_state'], array('wcheck', 'wsend', 'refuse'))) pe_jsonshow(array('result'=>false, 'show'=>'不能取消'));
		if (refund_close($refund_id)) {
			pe_jsonshow(array('result'=>true, 'show'=>'取消成功'));
		}
		else {
			pe_jsonshow(array('result'=>false, 'show'=>'取消失败'));		
		}
	break;
	//####################// 退款详情 //####################//
	case 'view':
		$refund_id = pe_dbhold($_g_id);
		$info = $db->pe_select('refund', array('refund_id'=>$refund_id, 'user_id'=>$_s_user_id));
		if (!$info['refund_id']) pe_404('退款信息不存在');
		$refundlog_list = $db->pe_selectall('refundlog', array('refund_id'=>$refund_id, 'order by'=>'refundlog_id desc'));
		$seo = pe_seo($menutitle='退款/退货详情');
		include(pe_tpl('refund_view.html'));
	break;
	//####################// 退款列表 //####################//
	default:
		$sql_where['user_id'] = $_s_user_id;
		$_g_state && $sql_where['refund_state'] = $_g_state;
		$sql_where['order by'] = 'refund_id desc';
		$info_list = $db->pe_selectall('refund', pe_dbhold($sql_where), '*', array('20', $_g_page));

		//统计数量
		$tongji_arr = $db->index('refund_state')->pe_selectall('refund', array('user_id'=>$_s_user_id, 'group by'=>'refund_state'), '`refund_state`, count(1) as `num`');
		foreach ($ini['refund_state'] as $k=>$v) {
			$tongji[$k] = intval($tongji_arr[$k]['num']);
			$tongji['all'] += $tongji[$k];	
		}
		$seo = pe_seo($menutitle='退款/退货');
		include(pe_tpl('refund_list.html'));
	break;
}
?>