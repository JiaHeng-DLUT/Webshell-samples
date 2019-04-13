<?php
//购物车列表及检测
function cart_list($cart_id = null) {
	global $db;
	$all_list = $del_list = array();
	$user_id = $_SESSION['user_id'] ? $_SESSION['user_id'] : pe_user_id();
	if ($cart_id === 'all') {
		$sql_where['cart_act'] = 'cart';
	}
	else {
		$sql_where['cart_id'] = pe_dbhold($cart_id);
	}
	$sql_where['user_id'] = $user_id;
	$info_list = $db->pe_selectall('cart', pe_dbhold($sql_where));
	$cart_num = count($info_list);	
	foreach ($info_list as $k=>$v) {
		$error = null;
		$product_guid = intval($v['product_guid']);
		$product = product_buyinfo($product_guid);
		//未参团按原价购买
		if ($product['huodong_type'] == 'pintuan' && $v['cart_type'] != 'pintuan') $product['product_money'] = $product['product_smoney'];
		$buy['cart_id'] = $v['cart_id'];
		//检测商品是否失效或删除并格式化商品数据
		if ($product['product_id'] && $product['product_guid']) {
			$buy['product_id'] = $product['product_id'];
			$buy['product_guid'] = $product['product_guid'];
			$buy['product_name'] = $product['product_name'];
			$buy['product_rule'] = $product['product_rule'];
			$buy['product_logo'] = $product['product_logo'];
			$buy['product_money'] = $product['product_money'];		
			$buy['product_maxnum'] = $product['product_num'];
			$buy['product_num'] = $v['product_num'];
			if (!$error && ($product['product_type'] == 'virtual' or $product['huodong_type'] == 'pintuan') && $cart_num > 1) {
				$error = array('show'=>"只能单买", 'del'=>true);
			}
			if (!$error && $v['cart_type'] == 'pintuan' && !pintuan_check($v['huodong_id'], $v['pintuan_id'])) {
				$error = array('show'=>'拼团无效或结束', 'del'=>true);			
			}
			if (!$error && $buy['product_num'] > $buy['product_maxnum']) {
				$error = array('show'=>"仅剩{$buy['product_maxnum']}件");			
			}
		}
		else {
			$buy['product_id'] = $v['product_id'];
			$buy['product_guid'] = $v['product_guid'];
			$buy['product_name'] = $v['product_name'];
			$buy['product_rule'] = $v['product_rule'];
			$buy['product_logo'] = $v['product_logo'];
			$buy['product_money'] = $v['product_money'];
			$buy['product_maxnum'] = $v['product_num'];
			$buy['product_num'] = $v['product_num'];
			$error = array('show'=>'下架或失效', 'del'=>true);
		}
		$buy['product_money'] = product_money($buy['product_money']);
		$buy['product_allmoney'] = $buy['product_money'] * $buy['product_num'];
		$all_list[$product_guid] = $buy;
		$all_list[$product_guid]['error'] = $error;
		if ($error['del']) $del_list[$product_guid] = $all_list[$product_guid];	
		$info['order_type'] = $v['cart_type'];
		$info['order_virtual'] = $product['product_type'] == 'virtual' ? 1 : 0;
		$info['order_name'][] = $product['product_name'];
		//$info['order_product_id'][] = $buy['product_id'];
		//$info['order_product_num'] += $buy['product_num'];
		$info['order_product_money'] += $buy['product_allmoney'];
		$info['order_wl_money'] += $product['product_wlmoney'];
		$info['order_point_get'] += $product['product_point'] * $v['product_num'];
		$info['huodong_id'] = $v['huodong_id'];
		$info['pintuan_id'] = $v['pintuan_id'];
	}	
	//格式化显示数据
	$info['order_name'] = is_array($info['order_name']) ? implode(';', $info['order_name']) : '';
	//$info['order_product_id'] = is_array($info['order_product_id']) ? implode(',', $info['order_product_id']) : '';
	//$info['order_product_num'] = intval($info['order_product_num']);
	$info['order_product_money'] = pe_num($info['order_product_money'], 'round', 1, true);
	$info['order_wl_money'] = pe_num($info['order_wl_money'], 'round', 1, true);
	$info['order_money'] = pe_num($info['order_product_money'] + $info['order_wl_money'], 'round', 1, true);
	$info['order_point_get'] = intval($info['order_point_get']);
	return array('all_list'=>$all_list, 'del_list'=>$del_list, 'info'=>$info);
}

//获取订单对应表名
function order_table($id) {
	if (stripos($id, '_') !== false) {
		$id_arr = explode('_', $id);
		return "order_{$id_arr[0]}";
	}
	else {
		return "order";	
	}
}

//订单支付方式
function payment_list($type = 'order') {
	$cache_payment = cache::get('payment');
	$payment_list = array();
	foreach ($cache_payment as $k=>$v) {
		if (!$v['payment_state']) continue;
		if ($v['payment_type'] == 'balance' && !$_SESSION['user_id']) continue;
		if ($v['payment_type'] == 'alipay' && stripos($_SERVER["HTTP_USER_AGENT"], "MicroMessenger") !== false) continue;
		if ($type == 'order') {
			$payment_list[$k]['payment_name'] = $v['payment_name'];		
			$payment_list[$k]['payment_type'] = $v['payment_type'];
		}
		elseif ($type == 'pay' && !in_array($v['payment_type'], array('cod', 'balance', 'bank'))) {
			$payment_list[$k]['payment_name'] = $v['payment_name'];		
			$payment_list[$k]['payment_type'] = $v['payment_type'];
		}
		elseif ($type == 'admin' && !in_array($v['payment_type'], array('cod', 'bank'))) {
			$payment_list[$k]['payment_name'] = $v['payment_name'];		
			$payment_list[$k]['payment_type'] = $v['payment_type'];
		}
	}
	return $payment_list;
}

//订单状态计算
function order_stateshow($state, $type = 'html') {
	global $ini;
	$text = $ini['order_state'][$state];
	if ($state == 'success') {
		$html = "<span class=\"cgreen\">{$text}</span>";
	}
	elseif ($state == 'close') {
		$html = "<del class=\"c999\">{$text}</del>";
	}
	else {
		$html = "<span class=\"corg\">{$text}</span>";	
	}
	return $type == 'html' ? $html : $text;	
}

//退款状态计算
function refund_stateshow($state, $type = 'html') {
	global $ini;
	$text = $ini['refund_state'][$state];
	if ($state == 'success') {
		$html = "<span class=\"cgreen\">{$text}</span>";
	}
	elseif ($state == 'close') {
		$html = "<del class=\"c999\">{$text}</del>";
	}
	else {
		$html = "<span class=\"corg\">{$text}</span>";	
	}
	return $type == 'html' ? $html : $text;
}

//订单商品规格显示
function order_skushow($product_rule) {
	$html = '';
	if ($product_rule) {
		$product_rule = unserialize($product_rule);
		foreach ($product_rule as $v) {
			$html .= "{$v['name']}：{$v['value']}；";
		}
	}
	return trim($html, '；');
}

//订单创建操作
function order_calback_add($order, $cart_id = array()) {
	global $db;
	pe_lead('hook/user.hook.php');
	pe_lead('hook/product.hook.php');
	$info = is_array($order) ? $order : $db->pe_select('order', array('order_id'=>pe_dbhold($order)));
	if (!$info['order_id']) return false;
	//扣除交易使用积分和优惠券
	add_pointlog($info['user_id'], 'order_pay', $info['order_point_use'], "订单支付抵现，单号【{$info['order_id']}】");
	user_quanupdate($info['order_quan_id'], 1);
	//更新商品库存
	$orderdata_list = $db->pe_selectall('orderdata', array('order_id'=>$info['order_id']));
	foreach ($orderdata_list as $v) {
		product_jsnum($v['product_guid'], 'del_num', $v['product_num']);
	}
	//更新用户订单数
	$user_ordernum = $db->pe_num('order', array('user_id'=>$info['user_id']));
	$db->pe_update('user', array('user_id'=>$info['user_id']), array('user_ordernum'=>$user_ordernum));
	//发送消息通知
	add_noticelog($info['user_id'], 'order_add', $info);
	//清空购物车
	$db->pe_delete('cart', array('cart_id'=>pe_dbhold($cart_id)));	
	return true;
}

//订单付款操作
function order_callback_pay($order, $order_outid = '', $order_payment = '') {
	global $db;
	pe_lead('hook/user.hook.php');
	pe_lead('hook/product.hook.php');
	$cache_payment = cache::get('payment');
	$info = is_array($order) ? $order : $db->pe_select(order_table($order), array('order_id'=>pe_dbhold($order)));
	if (!$info['order_id']) return false;
	if (order_table($info['order_id']) == 'order_pay') {
		//$info = $db->pe_select('order_pay', array('order_id'=>$order_id));
		if ($info['order_state'] != 'wpay') return;
		$sql_set['order_outid'] = $order_outid;
		$sql_set['order_payment'] = $order_payment;
		$sql_set['order_payment_name'] = $cache_payment[$order_payment]['payment_name'];
		$sql_set['order_state'] = 'success';
		$sql_set['order_pstate'] = 1;
		$sql_set['order_ptime'] = time();					
		$db->pe_update('order_pay', array('order_id'=>$info['order_id']), pe_dbhold($sql_set));
		add_moneylog($info['user_id'], 'recharge', $info['order_money'], "账户充值{$info['order_money']}元 - {$cache_payment[$order_payment]['payment_name']}");
	}
	else {
		//$info = $db->pe_select('order', array('order_id'=>$order_id));
		if (!$info['order_id']) return false;
		if ($order_outid) $sql_set['order_outid'] = $order_outid;
		if ($order_payment) {
			$sql_set['order_payment'] = $order_payment;
			$sql_set['order_payment_name'] = $cache_payment[$order_payment]['payment_name'];
		} 
		//检测是否为拼团
		$sql_set['order_state'] = $info['order_type'] == 'pintuan' ? 'wtuan' : 'wsend';
		$sql_set['order_pstate'] = 1;
		$sql_set['order_ptime'] = time();	
		if ($db->pe_update('order', array('order_id'=>$info['order_id']), pe_dbhold($sql_set))) {
			if ($info['order_payment'] == 'balance') {
				add_moneylog($info['user_id'], 'order_pay', $info['order_money'], "支付订单扣除，单号【{$info['order_id']}】");
			}
			//更新商品销量
			$orderdata_list = $db->pe_selectall('orderdata', array('order_id'=>$info['order_id']));
			foreach ($orderdata_list as $v) {
				product_jsnum($v['product_id'], 'add_sellnum', $v['product_num']);
			}			
			//发送消息通知
			$notice = array_merge($info, $sql_set);
			add_noticelog($info['user_id'], 'order_pay', $notice);
			//虚拟商品自动发货
			if ($info['order_virtual']) {
				order_callback_virtual($info);		
			}
			//拼团订单检测成团
			if ($info['order_type'] == 'pintuan') {
				order_callback_pintuan($info);
			}
			return true;
		}
		else {
			return false;
		}
	}
}

//订单发货操作
function order_callback_send($order, $order_wl_id='', $order_wl_name='') {
	global $db;
	$info = is_array($order) ? $order : $db->pe_select('order', array('order_id'=>pe_dbhold($order)));
	if (!$info['order_id']) return false;
	if ($order_wl_id) $sql_set['order_wl_id'] = $order_wl_id;
	if ($order_wl_name) $sql_set['order_wl_name'] = $order_wl_name;
	$sql_set['order_state'] = 'wget';
	$sql_set['order_sstate'] = 1;
	$sql_set['order_stime'] = time();
	if ($db->pe_update('order', array('order_id'=>$info['order_id']), pe_dbhold($sql_set))) {
		//取消退款处理中子订单
		pe_lead('hook/refund.hook.php');
		refund_close($info['order_id'], 'all');
		//发送消息通知
		$notice = array_merge($info, $sql_set);
		add_noticelog($info['user_id'], 'order_send', $notice);
		return true;
	}
	else {
		return false;
	}
}

//订单收货完成操作
function order_callback_success($order) {
	global $db, $cache_setting, $ini;
	pe_lead('hook/user.hook.php');
	pe_lead('hook/product.hook.php');
	$info = is_array($order) ? $order : $db->pe_select('order', array('order_id'=>pe_dbhold($order)));
	if (!$info['order_id']) return false;
	$sql_set['order_state'] = 'success';
	if ($info['order_payment'] == 'cod') {
		$sql_set['order_pstate'] = 1;
		$sql_set['order_ptime'] = time();
	}
	$sql_set['order_ftime'] = time();
	if ($db->pe_update('order', array('order_id'=>$info['order_id']), pe_dbhold($sql_set))) {
		//取消退款处理中子订单
		pe_lead('hook/refund.hook.php');
		refund_close($info['order_id'], 'all');
		add_pointlog($info['user_id'], 'give', $info['order_point_get'], "交易完成获得，单号【{$info['order_id']}】");
		if ($info['order_payment'] == 'cod') {
			//更新商品销量
			$orderdata_list = $db->pe_selectall('orderdata', array('order_id'=>$info['order_id']));
			foreach ($orderdata_list as $v) {
				product_jsnum($v['product_id'], 'add_sellnum', $v['product_num']);
			}
		}
		//更新用户累计消费
		$db->pe_update('user', array('user_id'=>$info['user_id']), "`user_money_cost` = `user_money_cost` + '{$info['order_money']}'");
		userlevel_callback($info['user_id']);
		//给上级推广用户发钱
		if ($cache_setting['tg_state']) {
			$tguser_list = $db->pe_selectall('tguser', array('user_id'=>$info['user_id']));
			foreach ($tguser_list as $v) {
				$moneylog_money = $info['order_money'] * $cache_setting["tg_fc{$v['tguser_level']}"];
				$moneylog_text = "获得{$ini['tg_level'][$v['tguser_level']]}级下线【{$info['user_name']}】".($cache_setting["tg_fc{$v['tguser_level']}"]*100)."%收益，单号【{$info['order_id']}】消费{$info['order_money']}元";
				add_moneylog($v['tguser_id'], 'tg', $moneylog_money, $moneylog_text);
				//计算已获得总佣金
				$tj = $db->pe_select('moneylog', array('user_id'=>$v['tguser_id'], 'moneylog_type'=>'tg'), 'sum(moneylog_in) as `money`');
				$db->pe_update('user', array('user_id'=>$v['tguser_id']), array('user_money_tg'=>$tj['money']));
			}
		}
		return true;
	}
	else {
		return false;
	}
}

//订单关闭操作
function order_callback_close($order, $order_closetext = '', $refund = true) {
	global $db;
	pe_lead('hook/user.hook.php');
	pe_lead('hook/product.hook.php');
	$info = is_array($order) ? $order : $db->pe_select('order', array('order_id'=>pe_dbhold($order)));
	if (!$info['order_id']) return false;
	if ($info['order_state'] == 'close') return true;
	$sql_set['order_ftime'] = time();
	$sql_set['order_state'] = 'close';
	$sql_set['order_closetext'] = $order_closetext;
	if ($db->pe_update('order', array('order_id'=>$info['order_id']), pe_dbhold($sql_set))) {
		if ($info['order_pstate'] && $refund) {
			//已付款生成退款单退款
			order_callback_refund($info, $order_closetext);
		}
		else {
			//未付款可以释放商品库存
			$info_list = $db->pe_selectall('orderdata', array('order_id'=>$info['order_id']));
			foreach ($info_list as $v) {
				product_jsnum($v['product_guid'], 'add_num', $v['product_num']);
			}
		}
		//退积分和优惠券
		add_pointlog($info['user_id'], 'back', $info['order_point_use'], "订单取消返还，单号【{$info['order_id']}】");
		user_quanupdate($info['order_quan_id'], 0);
		//发送消息通知
		$notice = array_merge($info, $sql_set);
		add_noticelog($info['user_id'], 'order_close', $notice);
		return true;
	}
	else {
		return false;
	}
}

//订单整单退款操作
function order_callback_refund($order, $refund_text) {
	global $db;
	pe_lead('hook/refund.hook.php');
	$info = is_array($order) ? $order : $db->pe_select('order', array('order_id'=>pe_dbhold($order)));
	if (!$info['order_id']) return false;
	//取消未完成的退款单
	refund_close($info['order_id'], 'all');
	//生成新的系统退款单
	$info_list = $db->pe_selectall('orderdata', array('order_id'=>$info['order_id']));
	foreach ($info_list as $v) {
		if ($v['refund_state'] == 'success') continue;
		$refund_maxmoney = refund_maxmoney($v['order_id'], $v['orderdata_id']);
		$sql_set['refund_id'] = $refund_id = pe_guid('refund|refund_id');
		$sql_set['refund_type'] = 1;
		$sql_set['refund_product_money'] = $refund_maxmoney['product'];
		$sql_set['refund_wl_money'] = $refund_maxmoney['wl'];
		$sql_set['refund_money'] = $refund_maxmoney['product'] + $refund_maxmoney['wl'];
		$sql_set['refund_text'] = $refund_text;
		$sql_set['refund_state'] = 'success';
		$sql_set['refund_atime'] = time();
		$sql_set['order_id'] = $v['order_id'];
		$sql_set['orderdata_id'] = $v['orderdata_id'];
		$sql_set['product_id'] = $v['product_id'];
		$sql_set['product_guid'] = $v['product_guid'];
		$sql_set['product_name'] = $v['product_name'];
		$sql_set['product_rule'] = $v['product_rule'];
		$sql_set['product_logo'] = $v['product_logo'];
		$sql_set['product_money'] = $v['product_money'];	
		$sql_set['product_jjmoney'] = $v['product_jjmoney'];
		$sql_set['product_allmoney'] = $v['product_allmoney'];	
		$sql_set['product_num'] = $v['product_num'];
		$sql_set['user_id'] = $info['user_id'];
		$sql_set['user_name'] = $info['user_name'];
		if ($db->pe_insert('refund', pe_dbhold($sql_set, array('product_rule')))) {
			$db->pe_update('orderdata', array('orderdata_id'=>$v['orderdata_id']), array('refund_id'=>$refund_id, 'refund_state'=>'success'));
			add_refundlog($refund_id, 'success', $refund_text);
		}	
	}
	//order_callback_close($order_id, $refund_text);
}

//订单评价操作
function order_callback_comment($order) {
	global $db, $cache_setting;
	pe_lead('hook/user.hook.php');
	pe_lead('hook/product.hook.php');
	$info = is_array($order) ? $order : $db->pe_select('order', array('order_id'=>pe_dbhold($order)));
	if (!$info['order_id']) return false;
	if ($db->pe_update('order', array('order_id'=>$info['order_id']), array('order_comment'=>1))) {
		//更新商品评价数
		$info_list = $db->pe_selectall('orderdata', array('order_id'=>$info['order_id']));
		foreach ($info_list as $k=>$v) {
			product_jsnum($v['product_id'], 'commentnum');
		}
		add_pointlog($info['user_id'], 'give', $cache_setting['point_comment'], "发表评价获得，单号【{$info['order_id']}】");	
		return true;
	}
	else {
		return false;
	}
}

//虚拟订单发货操作
function order_callback_virtual($order) {
	global $db;
	$info = is_array($order) ? $order : $db->pe_select('order', array('order_id'=>pe_dbhold($order)));
	if (!$info['order_id']) return false;
	if (!$info['order_virtual']) return true;
	$orderdata = $db->pe_select('orderdata', array('order_id'=>$info['order_id']));
	$info['product_id'] = $orderdata['product_id'];
	$info['product_num'] = $orderdata['product_num'];
	$nowdate = date('Y-m-d');
	//更新已过期卡密
	$db->pe_update('prokey', " and `product_id` = '{$info['product_id']}' and `prokey_state` = 'new' and `prokey_edate` < '{$nowdate}'", array('prokey_state'=>'expire'));
	$product = $db->pe_select('product', array('product_id'=>$info['product_id']), 'prokey_type, prokey_user, prokey_pw, prokey_edate');
	if ($product['prokey_type'] == 'one') {
		if ($product['prokey_edate'] >= date('Y-m-d')) {
			for ($num = 1; $num <= $info['product_num']; $num++) {
				$sql_set[$num]['prokey_user'] = $product['prokey_user'];
				$sql_set[$num]['prokey_pw'] = $product['prokey_pw'];
				$sql_set[$num]['prokey_edate'] = $product['prokey_edate'];
				$sql_set[$num]['prokey_atime'] = time();			
				$sql_set[$num]['prokey_state'] = 'success';			
				$sql_set[$num]['product_id'] = $info['product_id'];
				$sql_set[$num]['order_id'] = $info['order_id'];
				$sql_set[$num]['user_id'] = $info['user_id'];
				$sql_set[$num]['user_name'] = $info['user_name'];
			}
			$result = $db->pe_insert('prokey', pe_dbhold($sql_set));
		}
	}
	else {
		$prokey_list = $db->pe_selectall('prokey', array('product_id'=>$info['product_id'], 'prokey_state'=>'new', 'order by'=>'prokey_id asc'), '*', array($info['product_num']));
		if (count($prokey_list) >= $info['product_num']) {
			foreach ($prokey_list as $v) {
				$sql_set['prokey_state'] = 'success';
				$sql_set['order_id'] = $info['order_id'];
				$sql_set['user_id'] = $info['user_id'];
				$sql_set['user_name'] = $info['user_name'];
				$result = $db->pe_update('prokey', array('prokey_id'=>$v['prokey_id']), pe_dbhold($sql_set));
			}
		}
	}
	if ($result) {
		order_callback_send($info);
		order_callback_success($info);
		return true;
	}
	else {
		return false;
	}
}

//拼团订单检测操作
function order_callback_pintuan($order) {
	global $db;
	$info = is_array($order) ? $order : $db->pe_select('order', array('order_id'=>pe_dbhold($order)));
	if (!$info['order_id']) return false;
	//如果拼团活动或团单结束则订单退款关闭
	if (!pintuan_check($info['huodong_id'], $info['pintuan_id'])) {
		order_callback_close($order, '拼团结束，订单自动关闭退款');
		return true;
	}
	//没有团单id则创建团单
	if  (!$info['pintuan_id']) {
		$huodong = $db->pe_select('huodongdata', array('huodong_id'=>$info['huodong_id']));
		$sql_set['pintuan_id'] = $info['pintuan_id'] = $info['order_id'];
		$sql_set['pintuan_money'] = $huodong['product_money'];
		$sql_set['pintuan_num'] = $huodong['product_ptnum'];
		$sql_set['pintuan_atime'] = time();
		$sql_set['pintuan_stime'] = time();					
		$sql_set['pintuan_etime'] = time() + 86400;
		//如果拼团结束时间超过活动结束时间，以活动结束时间为准
		if ($sql_set['pintuan_etime'] > $huodong['huodong_etime']) $sql_set['pintuan_etime'] = $huodong['huodong_etime'];
		$sql_set['pintuan_state'] = 'wtuan';
		$sql_set['product_id'] = $huodong['product_id'];		
		$sql_set['product_name'] = $huodong['product_name'];
		$sql_set['product_logo'] = $huodong['product_logo'];	
		$sql_set['product_money'] = $huodong['product_smoney'];
		$sql_set['huodong_id'] = $huodong['huodong_id'];
		$sql_set['user_id'] = $info['user_id'];	
		$sql_set['user_name'] = $info['user_name'];		
		$db->pe_insert('pintuan', pe_dbhold($sql_set));
		$db->pe_update('order', array('order_id'=>$info['order_id']), array('pintuan_id'=>$info['pintuan_id']));
	}
	//插入参团记录
	$sqlset_pintuanlog['pintuanlog_atime'] = time();
	$sqlset_pintuanlog['pintuan_id'] = $info['pintuan_id'];
	$sqlset_pintuanlog['order_id'] = $info['order_id'];
	$user = $db->pe_select('user', array('user_id'=>$info['user_id']), 'user_id, user_name, user_logo');
	$sqlset_pintuanlog['user_id'] = $user['user_id'];
	$sqlset_pintuanlog['user_name'] = $user['user_name'];
	$sqlset_pintuanlog['user_logo'] = $user['user_logo'];
	$db->pe_insert('pintuanlog', pe_dbhold($sqlset_pintuanlog));
	//计算成团需人数
	$pintuan = $db->pe_select('pintuan', array('pintuan_id'=>$info['pintuan_id']));
	//计算已参与人数
	$info_list = $db->pe_selectall('order', array('pintuan_id'=>$info['pintuan_id'], 'order_state'=>'wtuan'));
	if (count($info_list) >= $pintuan['pintuan_num']) {
		//拼团成功更新订单信息
		$db->pe_update('order', array('pintuan_id'=>$info['pintuan_id'], 'order_state'=>'wtuan'), array('order_state'=>'wsend'));
		//拼团成功更新拼团信息
		$db->pe_update('pintuan', array('pintuan_id'=>$info['pintuan_id']), array('pintuan_state'=>'success'));
		//成团后未付款的的订单关闭
		$order_list = $db->pe_selectall('order', array('pintuan_id'=>$info['pintuan_id'], 'order_state'=>'wpay'));
		foreach ($order_list as $v) {
			order_callback_close($v, "拼团结束，未付款订单自动关闭");
		}
		//检测虚拟商品自动发货
		foreach ($info_list as $v) {
			order_callback_virtual($v);
		}
	}
}

//订单支付后跳转
function order_pay_goto($order_id, $jump = 1) {
	global $db, $pe;
	if (order_table($order_id) == 'order_pay') {
		$show = '充值成功！';
		$url = "{$pe['host_root']}user.php?mod=moneylog";	
	}
	else {
		$show = '支付成功！';
		$info = $db->pe_select('order', array('order_id'=>$order_id));
		if ($info['order_type'] == 'pintuan') {
			$url = "{$pe['host_root']}index.php?mod=order&act=pintuan&id={$info['pintuan_id']}";	
		}
		else {
			$url = "{$pe['host_root']}user.php?mod=order&act=view&id={$order_id}";		
		}
	}
	if ($jump) {
		pe_success($show, $url);
	}
	else {
		return array('show'=>$show, 'url'=>$url);
	}
}

//拼团检测
function pintuan_check($huodong_id, $pintuan_id = 0) {
	global $db;
	if ($pintuan_id) {
		$info = $db->pe_select('pintuan', array('pintuan_id'=>$pintuan_id));
		if (!$info['pintuan_id']) return false;
		if (in_array($info['pintuan_state'], array('success', 'close'))) return false;
	}
	else {
		$info = $db->pe_select('huodong', array('huodong_id'=>$huodong_id));
		if (!$info['huodong_id']) return false;
		if ($info['huodong_stime'] > time() or $info['huodong_etime'] <= time()) return false;
	}
	return true;
}

//订单调价显示
function order_jjmoney_show($money) {
	if ($money > 0) {
		return '手动改价 +'.round($money, 1).'元';
	}
	elseif ($money < 0) {
		return '手动改价 '.round($money, 1).'元';
	}
	return '-';
}
?>