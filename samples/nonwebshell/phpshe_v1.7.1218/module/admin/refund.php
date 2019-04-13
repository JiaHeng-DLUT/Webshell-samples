<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'refund';
pe_lead('hook/order.hook.php');
pe_lead('hook/refund.hook.php');
switch ($act) {
	//####################// 退款详情 //####################//
	case 'view':
		$refund_id = pe_dbhold($_g_id);
		$info = $db->pe_select('refund', array('refund_id'=>$refund_id));
		$refundlog_list = $db->pe_selectall('refundlog', array('refund_id'=>$refund_id, 'order by'=>'refundlog_id desc'));
		$seo = pe_seo($menutitle='退款/退货详情', '', '', 'admin');
		include(pe_tpl('refund_view.html'));
	break;
	//####################// 审核通过 //####################//
	case 'agree':
		$refund_id = pe_dbhold($_g_id);
		$info = $db->pe_select('refund', array('refund_id'=>$refund_id));
		$refund_maxmoney = refund_maxmoney($info['order_id'], $info['orderdata_id']);
		$address_list = $db->index('address_id')->pe_selectall('refund_addr', array('order by'=>'`address_order` asc, `address_id` desc'));
		if (isset($_p_pesubmit)) {
			pe_token_match();
			/*$refund_product_money = pe_num($_p_refund_product_money, 'round', 1);
			$refund_wl_money = pe_num($_p_refund_wl_money, 'round', 1);
			$refund_money = $refund_product_money + $refund_wl_money;
			if ($refund_money <= 0) pe_jsonshow(array('result'=>false, 'show'=>"请填写退款金额"));
			if ($refund_product_money > $refund_maxmoney['product']) pe_jsonshow(array('result'=>false, 'show'=>"商品最多可退{$refund_maxmoney['product']}元"));
			if ($refund_wl_money > $refund_maxmoney['wl']) pe_jsonshow(array('result'=>false, 'show'=>"运费最多可退{$refund_maxmoney['wl']}元"));*/
			if (!in_array($info['refund_state'], array('wcheck', 'refuse'))) pe_jsonshow(array('result'=>false, 'show'=>'参数错误'));
			//仅退款直接退款成功
			if ($info['refund_type'] == 1) {
				refund_success($refund_id);
				pe_jsonshow(array('result'=>true, 'show'=>'操作成功！'));
			}
			if (!is_array($address_list[$_p_address_id])) pe_jsonshow(array('result'=>false, 'show'=>"请选择退货地址"));			
			$sql_set['refund_tname'] = $address_list[$_p_address_id]['refund_tname'];
			$sql_set['refund_phone'] = $address_list[$_p_address_id]['refund_phone'];
			$sql_set['refund_address'] = $address_list[$_p_address_id]['refund_address'];
			$sql_set['refund_state'] = $refund_state = 'wsend';			
			/*$sql_set['refund_product_money'] = $refund_product_money;
			$sql_set['refund_wl_money'] = $refund_wl_money;
			$sql_set['refund_money'] = $refund_money;*/
			if ($db->pe_update('refund', array('refund_id'=>$refund_id), pe_dbhold($sql_set))) {
				$sqlset_orderdata['refund_id'] = $refund_id;
				$sqlset_orderdata['refund_state'] = $refund_state;				
				$db->pe_update('orderdata', array('orderdata_id'=>$info['orderdata_id']), pe_dbhold($sqlset_orderdata));
				add_refundlog($refund_id, 'agree');
				pe_jsonshow(array('result'=>true, 'show'=>'操作成功！'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'操作失败'));
			}
		}
		$seo = pe_seo($menutitle='同意退款/退货申请', '', '', 'admin');
		include(pe_tpl('refund_agree.html'));
	break;
	//####################// 审核拒绝 //####################//
	case 'refuse':
		$refund_id = pe_dbhold($_g_id);
		$info = $db->pe_select('refund', array('refund_id'=>$refund_id));
		$refund_maxmoney = refund_maxmoney($info['order_id'], $info['orderdata_id']);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if (!in_array($info['refund_state'], array('wcheck', 'wsend', 'wget'))) pe_jsonshow(array('result'=>false, 'show'=>'参数错误'));
			if (!$_p_refund_text) pe_jsonshow(array('result'=>false, 'show'=>'请填写审核说明'));
			if ($db->pe_update('refund', array('refund_id'=>$refund_id), array('refund_state'=>'refuse'))) {
				$sqlset_orderdata['refund_id'] = $refund_id;
				$sqlset_orderdata['refund_state'] = 'refuse';				
				$db->pe_update('orderdata', array('orderdata_id'=>$info['orderdata_id']), pe_dbhold($sqlset_orderdata));
				add_refundlog($refund_id, 'refuse', $_p_refund_text);
				pe_jsonshow(array('result'=>true, 'show'=>'操作成功！'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'操作失败'));
			}
		}
		$seo = pe_seo($menutitle='拒绝退款/退货申请', '', '', 'admin');
		include(pe_tpl('refund_refuse.html'));
	break;
	//####################// 确认收货退款 //####################//
	case 'success':
		pe_token_match();
		$refund_id = pe_dbhold($_g_id);
		$info = $db->pe_select('refund', array('refund_id'=>$refund_id));
		if ($info['refund_state'] != 'wget') pe_error('参数错误');
		if (refund_success($refund_id)) {
			pe_success('操作成功!');		
		}
		else {
			pe_error('操作失败...');		
		}
	break;
	//####################// 退款删除 //####################//
	case 'del':
		pe_token_match();
		$refund_id = pe_dbhold($_g_id);
		$info = $db->pe_select('refund', array('refund_id'=>$refund_id));
		if ($info['refund_state'] != 'close') pe_error('参数错误');
		if ($db->pe_delete('refund', array('refund_id'=>$refund_id))) {
			$db->pe_delete('refundlog', array('refund_id'=>$refund_id));
			pe_success('删除成功!');
		}
		else {
			pe_error('删除失败...');
		}
	break;
	//####################// 退款列表 //####################//
	default:
		$_g_state && $sql_where['refund_state'] = $_g_state;
		$_g_id && $sql_where['refund_id'] = $_g_id; 
		$_g_order_id && $sql_where['order_id'] = $_g_order_id; 		
		$sql_where['order by'] = 'refund_id desc';
		$info_list = $db->pe_selectall('refund', pe_dbhold($sql_where), '*', array(50, $_g_page));

		//统计数量
		$tongji_arr = $db->index('refund_state')->pe_selectall('refund', array('group by'=>'refund_state'), 'refund_state, count(1) as `num`');
		foreach ($ini['refund_state'] as $k=>$v) {
			$tongji[$k] = intval($tongji_arr[$k]['num']);
			$tongji['all'] += $tongji[$k];
		}
		$seo = pe_seo($menutitle='退款/退货管理', '', '', 'admin');
		include(pe_tpl('refund_list.html'));
	break;
}
?>