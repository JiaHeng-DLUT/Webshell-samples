<?php
$menumark = 'order';
pe_lead('hook/order.hook.php');
switch($act) {
	//####################// 订单详情 //####################//
	case 'view':
		$order_id = pe_dbhold($_g_id);
		$info = $db->pe_select('order', array('order_id'=>$order_id, 'user_id'=>$_s_user_id));
		if (!$info['order_id']) pe_error('参数错误...');
		$product_list = $db->pe_selectall('orderdata', array('order_id'=>$order_id));
		$prokey_list = $db->pe_selectall('prokey', array('order_id'=>$order_id, 'order by'=>'prokey_id asc'));
		$seo = pe_seo($menutitle='订单详情');
		include(pe_tpl('order_view.html'));
	break;
	//####################// 订单取消 //####################//
	case 'close':
		$order_id = pe_dbhold($_g_id);
		$info = $db->pe_select('order', array('order_id'=>$order_id, 'user_id'=>$_s_user_id));
		if (isset($_p_pesubmit)) {
			if (!$info['order_id']) pe_jsonshow(array('result'=>false, 'show'=>'参数错误'));
			if ($info['order_state'] != 'wpay') pe_jsonshow(array('result'=>false, 'show'=>'订单不可取消'));
			if (!$_p_order_closetext) pe_jsonshow(array('result'=>false, 'show'=>'请填写取消原因'));
			if (order_callback_close($info, $_p_order_closetext)) {
				pe_jsonshow(array('result'=>true, 'show'=>'操作成功'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'操作失败'));
			}
		}
		if (!$info['order_id']) pe_error('参数错误', '', 'dialog');
		$seo = pe_seo($menutitle='订单取消');
		include(pe_tpl('order_close.html'));
	break;
	//####################// 订单确认收货 //####################//
	case 'success':
		$order_id = pe_dbhold($_g_id);
		$info = $db->pe_select('order', array('order_id'=>$order_id, 'user_id'=>$_s_user_id));
		if (!$info['order_id']) pe_jsonshow(array('result'=>false, 'show'=>'参数错误'));
		if ($info['order_state'] != 'wget') pe_jsonshow(array('result'=>false, 'show'=>'未发货订单不能确认'));
		if (in_array($info['order_payment'], array('alipay_db', 'cod'))) pe_jsonshow(array('result'=>false, 'show'=>'参数错误'));
		if (order_callback_success($info)) {
			pe_jsonshow(array('result'=>true, 'show'=>'操作成功'));
		}
		else {
			pe_jsonshow(array('result'=>false, 'show'=>'操作失败'));
		}
	break;
	//####################// 订单评价 //####################//
	case 'comment':
		$order_id = pe_dbhold($_g_id);
		$info = $db->pe_select('order', array('order_id'=>$order_id, 'user_id'=>$_s_user_id));
		if (!$info['order_id']) pe_jsonshow(array('result'=>false, 'show'=>'参数错误'));
		if ($info['order_state'] != 'success') pe_jsonshow(array('result'=>false, 'show'=>'订单未完成'));
		if ($info['order_comment']) pe_jsonshow(array('result'=>false, 'show'=>'请勿重复评价'));
		$info_list = $db->pe_selectall('orderdata', array('order_id'=>$order_id));
		if (isset($_p_pesubmit)) {
			pe_token_match();
			//$user = $db->pe_select('user', array('user_id'=>$_s_user_id),'user_logo');
			foreach ($info_list as $k=>$v) {
				$sql_set[$k]['comment_star'] = intval($_p_comment_star[$v['orderdata_id']]);
				$sql_set[$k]['comment_text'] = $_p_comment_text[$v['orderdata_id']];
				$sql_set[$k]['comment_logo'] = is_array($_p_comment_logo[$v['orderdata_id']]) ? implode(',', array_filter($_p_comment_logo[$v['orderdata_id']])) : '';	
				$sql_set[$k]['comment_atime']= time();
				$sql_set[$k]['product_id'] = $v['product_id'];
				$sql_set[$k]['product_name'] = $v['product_name'];
				$sql_set[$k]['product_logo'] = $v['product_logo'];
				$sql_set[$k]['order_id'] = $order_id;
				$sql_set[$k]['user_ip'] = pe_ip();
				$sql_set[$k]['user_id'] = $_s_user_id;
				$sql_set[$k]['user_name'] = $_s_user_name;
				$sql_set[$k]['user_logo'] = $user['user_logo'];
				if (!$sql_set[$k]['comment_text']) pe_jsonshow(array('result'=>false, 'show'=>'请填写评价内容'));
			}
			if ($db->pe_insert('comment', pe_dbhold($sql_set))) {
				order_callback_comment($info);
				pe_jsonshow(array('result'=>true, 'show'=>'评价成功'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'评价失败'));
			}
		}
		$seo = pe_seo($menutitle='订单评价', '', '', 'user');
		include(pe_tpl('order_comment.html'));
	break;
	//####################// 订单列表 //####################//
	default:
		if (in_array($_g_state, array('wpay', 'wsend', 'wget', 'success'))) {
			$sql_where .= " and `order_state` = '".pe_dbhold($_g_state)."'";	
		}
		elseif ($_g_state == 'wpj') {
			$sql_where .= " and `order_state` = 'success' and `order_comment` = 0";			
		}
		$sql_where .= " and `user_id` = '{$_s_user_id}' order by `order_id` desc";
		$info_list = $db->pe_selectall('order', $sql_where, '*', array(20, $_g_page));
		foreach ($info_list as $k=>$v) {
			$info_list[$k]['product_list'] = $db->pe_selectall('orderdata', array('order_id'=>$v['order_id']));
		}
		//统计订单数量
		$tongji_arr = $db->index('order_state')->pe_selectall('order', array('user_id'=>$_s_user_id, 'group by'=>'order_state'), '`order_state`, count(1) as `num`');
		foreach ($ini['order_state'] as $k=>$v) {
			$tongji[$k] = intval($tongji_arr[$k]['num']);
			$tongji['all'] += intval($tongji[$k]);
		}
		$tongji['wpj'] = $db->pe_num('order', array('user_id'=>$_s_user_id, 'order_state'=>'success', 'order_comment'=>0));
		$seo = pe_seo($menutitle='我的订单');
		include(pe_tpl('order_list.html'));
	break;
}
?>