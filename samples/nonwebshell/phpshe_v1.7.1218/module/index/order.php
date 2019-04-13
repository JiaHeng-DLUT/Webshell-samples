<?php
/**
 * @copyright   2008-2014 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
pe_lead('hook/order.hook.php');
$cache_payment = cache::get('payment');
$payment_list = payment_list('order');
$user_id = $user['user_id'] ? $user['user_id'] : pe_user_id();
switch ($act) {
	//####################// 提交订单 //####################//
	case 'add':
	//case 'add_pintuan':
		$cart_id = $_g_id ? explode(',', $_g_id) : array();
		$cart = cart_list($cart_id);
		$info_list = $cart['all_list'];
		$info = $cart['info'];
		//$user = $db->pe_select('user', array('user_id'=>$_s_user_id));
		$user['user_point'] = intval($user['user_point']);
		$user['user_money'] = pe_num($user['user_money'], 'round', 1, true);
		$user_point_money = $cache_setting['point_money'] ? round($user['user_point']/$cache_setting['point_money'], 1) : 0;
		user_quancheck();
		$quan_list = user_quanlist($cart);
		if (isset($_p_pesubmit)) {
			$order_quan_id = intval($_p_order_quan_id);
			$order_point_use = $cache_setting['point_state'] ? intval($_p_order_point_use) : 0;
			if (!user_checkguest()) pe_jsonshow(array('result'=>false, 'show'=>'请先登录'));
 			if (!count($info_list)) pe_jsonshow(array('result'=>false, 'show'=>'购物车商品为空'));
			if (!$_p_order_payment) pe_jsonshow(array('result'=>false, 'show'=>'请选择付款方式'));
			if ($order_quan_id && !$quan_list[$order_quan_id]['quan_id']) pe_jsonshow(array('result'=>false, 'show'=>'优惠券无效'));
			if ($order_point_use > $user['user_point']) pe_jsonshow(array('result'=>false, 'show'=>'积分余额不足'));
			//虚拟商品不用检测收货地址
 			if (!$info['order_virtual']) {
	 			$address = useraddr_info($_p_address_id);
				if (!$address['address_id']) pe_jsonshow(array('result'=>false, 'show'=>'请选择收货地址'));			
 			}
 			//输出购买错误信息
			foreach ($info_list as $v) {
				if ($v['error']) pe_jsonshow(array('result'=>false, 'show'=>"【{$v['error']['show']}】{$v['product_name']}"));
			}
			$sql_order['order_id'] = $order_id = pe_guid('order|order_id');	
			//检测拼团id	
			/*if ($act == 'add_pt') {
				$order_ptid = pe_dbhold($_g_ptid);
				if ($order_ptid && $db->pe_num('order', array('order_id'=>$order_ptid, 'order_ptid'=>$order_ptid, 'order_state'=>'wtuan'))) {
					$sql_order['order_ptid'] = $order_ptid;
				}
				else {
					$sql_order['order_ptid'] = $order_id;
				}				
			}*/
			$sql_order['order_type'] = $info['order_type'];	
			$sql_order['order_virtual'] = $info['order_virtual'];
			$sql_order['order_name'] = $info['order_name'];	
			//$sql_order['order_product_id'] = $info['order_product_id'];		
			$sql_order['order_product_money'] = $info['order_product_money'];
			//$sql_order['order_product_num'] = $info['order_product_num'];
			$sql_order['order_wl_money'] = $info['order_wl_money'];
			$sql_order['order_money'] = $info['order_money'];
			$sql_order['order_point_get'] = $info['order_point_get'];
			$sql_order['order_atime'] = time();
			$sql_order['order_payment'] = $_p_order_payment;
			$sql_order['order_payment_name'] = $cache_payment[$_p_order_payment]['payment_name'];
			$sql_order['order_state'] = $_p_order_payment == 'cod' ? 'wsend' : 'wpay';
			$sql_order['order_text'] = $_p_order_text;
			$sql_order['huodong_id'] = $info['huodong_id'];	
			$sql_order['pintuan_id'] = $info['pintuan_id'];	
			$sql_order['user_id'] = $_s_user_id;
			$sql_order['user_name'] = $_s_user_name;
			$sql_order['user_address'] = "{$address['address_province']}{$address['address_city']}{$address['address_area']}{$address['address_text']}";
			$sql_order['user_tname'] = $address['user_tname'];
			$sql_order['user_phone'] = $address['user_phone'];
			if ($order_quan_id) {
				$sql_order['order_quan_id'] = $order_quan_id;
				$sql_order['order_quan_name'] = $quan_list[$order_quan_id]['quan_name'];
				$sql_order['order_quan_money'] = $quan_list[$order_quan_id]['quan_money'];
			}
			if ($order_point_use) {
				$sql_order['order_point_use'] = $order_point_use;
				$sql_order['order_point_money'] = $cache_setting['point_money'] ? round($order_point_use/$cache_setting['point_money'], 1) : 0;
			}
			$sql_order['order_money'] = $sql_order['order_money'] - $sql_order['order_quan_money'] - $sql_order['order_point_money'];
			if ($sql_order['order_money'] < 0) $sql_order['order_money'] = 0;
			if ($db->pe_insert('order', pe_dbhold($sql_order))) {
				foreach ($info_list as $v) {
					$sql_orderdata['product_id'] = $v['product_id'];
					$sql_orderdata['product_guid'] = $v['product_guid'];
					$sql_orderdata['product_name'] = $v['product_name'];
					$sql_orderdata['product_rule'] = $v['product_rule'];
					$sql_orderdata['product_logo'] = $v['product_logo'];
					$sql_orderdata['product_money'] = $v['product_money'];
					$sql_orderdata['product_allmoney'] = $v['product_allmoney'];
					$sql_orderdata['product_num'] = $v['product_num'];
					$sql_orderdata['order_id'] = $order_id;
					$db->pe_insert('orderdata', pe_dbhold($sql_orderdata, array('product_rule')));
				}
				order_calback_add($order_id, $cart_id);
				//金额为0直接支付成功
				if ($sql_order['order_money'] == 0) {
					order_callback_pay($order_id, '', 'balance');
					$ret = order_pay_goto($order_id, false);			
					pe_jsonshow(array('result'=>true, 'show'=>'订单支付成功', 'url'=>$ret['url']));
				}
				else {
					pe_jsonshow(array('result'=>true, 'show'=>'订单提交成功', 'url'=>"{$pe['host_root']}index.php?mod=order&act=pay&id={$order_id}"));				
				}
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'订单提交失败'));
			}	
		}
		$seo = pe_seo($menutitle='提交订单');
		include(pe_tpl('order_add.html'));
	break;
	//####################// 订单支付 //####################//
	case 'pay':
		$order_id = pe_dbhold($_g_id);
		$info = $db->pe_select('order', array('order_id'=>$order_id));
		//$user = $db->pe_select('user', array('user_id'=>$_s_user_id), 'user_money');
		$user['user_money'] = pe_num($user['user_money'], 'round', 1, true);
		if (isset($_p_pesubmit)) {
			if (!$info['order_id']) pe_jsonshow(array('result'=>false, 'show'=>'订单号错误'));
			if ($info['order_pstate']) pe_jsonshow(array('result'=>false, 'show'=>'订单已支付'));
			if ($info['order_type'] == 'pintuan' && !pintuan_check($info['huodong_id'], $info['pintuan_id'])) pe_jsonshow(array('result'=>false, 'show'=>'拼团无效或结束'));
			$order_payment = $_p_order_payment ? pe_dbhold($_p_order_payment) : $info['order_payment'];
			if ($order_payment == 'cod' or !array_key_exists($order_payment, $cache_payment)) pe_jsonshow(array('result'=>false, 'show'=>'支付方式错误'));
			if ($order_payment == 'balance') {
				if (!$_p_user_paypw) pe_jsonshow(array('result'=>false, 'show'=>'请填写支付密码'));
				if ($user['user_paypw'] != md5($_p_user_paypw)) pe_jsonshow(array('result'=>false, 'show'=>'支付密码错误'));
				if ($user['user_money'] < $info['order_money']) pe_jsonshow(array('result'=>false, 'show'=>'账户余额不足'));
				order_callback_pay($info, '', $order_payment);
				$ret = order_pay_goto($order_id, false);			
				pe_jsonshow(array('result'=>true, 'show'=>'订单支付成功', 'url'=>$ret['url']));
			}
			else {
				pe_jsonshow(array('result'=>true, 'id'=>$order_id, 'url'=>"{$pe['host_root']}include/plugin/payment/{$order_payment}/pay.php?id={$order_id}"));
			}			
		}
		if (!$info['order_id']) pe_404('订单号错误');
		$seo = pe_seo($menutitle="支付订单");
		include(pe_tpl('order_pay.html'));
	break;
	//####################// 快递查询跳转 //####################//
	case 'kuaidi':
		$json = json_decode(file_get_contents("http://www.kuaidi100.com/autonumber/autoComNum?text={$_g_id}"), true);
		$wl_code = $json['auto'][0]['comCode'];
		pe_goto("http://www.kuaidi100.com/chaxun?com={$wl_code}&nu={$_g_id}");
	break;
}
?>