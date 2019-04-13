<?php
//增加退款单
/*function refund_add($info, $post = array()) {
	global $db;
	$sql_set['refund_id'] = $refund_id = pe_guid('refund|refund_id');
	$sql_set['refund_type'] = $post['refund_type'];
	$sql_set['refund_product_money'] = $post['refund_product_money'];
	$sql_set['refund_wl_money'] = $post['refund_wl_money'] ;
	$sql_set['refund_money'] = $post['refund_product_money'] + $post['refund_wl_money'];
	$sql_set['refund_text'] = $post['refund_text'];
	$sql_set['refund_state'] = $post['refund_state'];
	$sql_set['refund_atime'] = time();
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
	$sql_set['user_id'] = $info['user_id'];
	$sql_set['user_name'] = $info['user_name'];	
	if ($db->pe_insert('refund', pe_dbhold($sql_set, array('product_rule')))) {
		$db->pe_update('orderdata', array('orderdata_id'=>$info['orderdata_id']), array('refund_id'=>$refund_id, 'refund_state'=>$post['refund_state']));
		return $refund_id;
	}
	else {
		return false;
	}
}*/

//修改退款单
/*function refund_edit($info, $post = array()) {
	global $db;
	$sql_set['refund_product_money'] = $post['refund_product_money'];
	$sql_set['refund_wl_money'] = $post['refund_wl_money'];
	$sql_set['refund_money'] = $post['refund_product_money'] + $post['refund_wl_money'];
	$sql_set['refund_text'] = $post['refund_text'];
	$sql_set['refund_state'] = $post['refund_state'];
	if ($db->pe_update('refund', array('refund_id'=>$info['refund_id']), pe_dbhold($sql_set))) {
		$db->pe_update('orderdata', array('orderdata_id'=>$info['orderdata_id']), array('refund_id'=>$info['refund_id'], 'refund_state'=>$post['refund_state']));
		return true;
	}
	else {
		return false;
	}
}*/

//退款通过操作
function refund_success($refund_id) {
	global $db;
	$info = $db->pe_select('refund', array('refund_id'=>$refund_id));
	if ($db->pe_update('refund', array('refund_id'=>$refund_id), array('refund_state'=>'success'))) {
		//更新对应子订单状态				
		$db->pe_update('orderdata', array('orderdata_id'=>$info['orderdata_id']), array('refund_id'=>$refund_id, 'refund_state'=>'success'));
		//如果子订单已全部退款，主订单关闭
		if (!$db->pe_num('orderdata', " and `order_id` = '{$info['order_id']}' and `refund_state` != 'success'")) {
			order_callback_close($info['order_id'], "订单退款关闭", false);
		}
		add_refundlog($refund_id, 'success');
		return true;
	}
	else {
		return false;
	}
}

//退款关闭操作
function refund_close($id, $type='one') {
	global $db;
	$id = pe_dbhold($id);
	if ($type == 'all') {
		$info_list = $db->pe_selectall('refund', array('order_id'=>$id, 'refund_state'=>array('wcheck', 'wsend', 'wget', 'refuse')));
	}
	else {
		$info_list = $db->pe_selectall('refund', array('refund_id'=>$id));
	}
	foreach ($info_list as $v) {
		$db->pe_update('refund', array('refund_id'=>$v['refund_id']), array('refund_state'=>'close'));
		$db->pe_update('orderdata', array('refund_id'=>$v['refund_id']), array('refund_id'=>0, 'refund_state'=>''));
		if ($type == 'all') {
			add_refundlog($v['refund_id'], 'admin_close');			
		}
		else {
			add_refundlog($v['refund_id'], 'close');		
		}	
	}
	return true;
}

//计算最大退款金额
function refund_maxmoney($order_id, $orderdata_id) {
	global $db;
	$order = $db->pe_select('order', array('order_id'=>$order_id), 'order_pstate, order_money, order_wl_money, order_product_money, order_quan_money, order_point_money');	
	if (!$order['order_pstate']) return array('product'=>'0.0', 'wl'=>'0.0');
	$orderdata = $db->pe_select('orderdata', array('orderdata_id'=>$orderdata_id));
	//计算最大退款商品金额
	if ($order['order_product_money'] > 0) {
		$zhekou = ($orderdata['product_allmoney'] / $order['order_product_money']) * ($order['order_quan_money'] + $order['order_point_money']);
		$max['product'] = pe_num($orderdata['product_allmoney'] - $zhekou, 'round', 1);	
	}
	else {
		$max['product'] = 0;
	}
	//计算最大退款运费金额
	$tongji = $db->pe_select('refund', " and `order_id` = '{$order_id}' and `orderdata_id` != '{$orderdata_id}' and `refund_state` != 'close'", 'sum(refund_wl_money) as `money`');
	$refund_wl_money = pe_num($tongji['money'], 'round', 1);
	$max['wl'] = pe_num($order['order_wl_money'] - $refund_wl_money, 'round', 1);
	//优惠券金额大于商品金额会出现负数
	if ($max['product'] < 0) $max['product'] = 0;
	if ($max['wl'] < 0) $max['wl'] = 0;
	return $max;
}

//增加退款操作记录
function add_refundlog($refund_id, $type, $text = '') {
	global $db, $ini;
	$info = $db->pe_select('refund', array('refund_id'=>$refund_id));
	switch ($type) {
		case 'add':
			$sql_set['refundlog_text'] = "发起了《{$ini['refund_type'][$info['refund_type']]}》申请，退款金额：{$info['refund_money']}元，说明：{$info['refund_text']}";
		break;
		case 'edit':
			$sql_set['refundlog_text'] = "修改了《{$ini['refund_type'][$info['refund_type']]}》申请，退款金额：{$info['refund_money']}元，说明：{$info['refund_text']}";
		break;
		case 'send':
			$sql_set['refundlog_text'] = "已寄回商品，快递公司：{$info['refund_wl_name']}，快递单号：{$info['refund_wl_id']}";
		break;
		case 'close':
		case 'admin_close':
			$sql_set['refundlog_text'] = "取消本次申请，退款关闭";
		break;
		case 'agree':
			$sql_set['refundlog_text'] = "同意本次申请，退款金额：{$info['refund_money']}元，退货地址：{$info['refund_tname']}，{$info['refund_phone']}，{$info['refund_address']}";
		break;	
		case 'refuse':
			$sql_set['refundlog_text'] = "拒绝本次申请，说明：{$text}";
		break;
		case 'success':
			$sql_set['refundlog_text'] = $text ? $text : "同意本次申请，已退款金额：{$info['refund_money']}元";
		break;
	}
	$sql_set['refundlog_atime'] = time();
	$sql_set['refund_id'] = $refund_id;
	if (in_array($type, array('add', 'edit', 'send', 'close'))) {
		$sql_set['user_id'] = $info['user_id'];
		$sql_set['user_name'] = $info['user_name'];
	}
	$db->pe_insert('refundlog', pe_dbhold($sql_set));
}
?>