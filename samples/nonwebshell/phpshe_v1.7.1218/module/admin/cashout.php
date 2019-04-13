<?php
$menumark = 'cashout';
switch ($act) {
	//####################// 提现开关 //####################//
	case 'open':
		if ($db->pe_update('setting', array('setting_key'=>'cashout_isopen'), array('setting_value'=>intval($_g_open)))) {
			pe_lead('hook/cache.hook.php');
			cache_write('setting');
			pe_success('操作成功!');
		}
		else {
			pe_error('操作失败...');
		}
	break;
	//####################// 审核通过 //####################//
	case 'success':
		$cashout_id = is_array($_p_cashout_id) ? $_p_cashout_id : $_g_id;
		$cashout_list = $db->pe_selectall('cashout', array('cashout_id'=>$cashout_id));
		foreach ($cashout_list as $v) {
			$info = $db->pe_select('cashout', array('cashout_id'=>$v['cashout_id']));
			if ($info['cashout_state']) continue;
			$db->pe_update('cashout', array('cashout_id'=>$info['cashout_id']), array('cashout_state'=>1, 'cashout_ptime'=>time()));
		}
		pe_success('审核成功！');
	break;
	//####################// 审核拒绝 //####################//
	case 'refuse':
		pe_lead('hook/user.hook.php');
		$cashout_id = is_array($_p_cashout_id) ? $_p_cashout_id : $_g_id;
		$cashout_list = $db->pe_selectall('cashout', array('cashout_id'=>$cashout_id));
		foreach ($cashout_list as $v) {
			$info = $db->pe_select('cashout', array('cashout_id'=>$v['cashout_id']));
			if ($info['cashout_state']) continue;
			$db->pe_update('cashout', array('cashout_id'=>$info['cashout_id']), array('cashout_state'=>2, 'cashout_ptime'=>time()));
			$cashout_money = $info['cashout_money'] + $info['cashout_fee'];
			add_moneylog($info['user_id'], 'back', $cashout_money, "提现未通过，退回{$cashout_money}元");
		}
		pe_success('拒绝成功！');
	break;
	//####################// 提现列表 //####################//
	default:
		$sql_where = " and `cashout_state` = ".intval($_g_state);
		$_g_name && $sql_where = " and `user_name` = '{$_g_name}'";
		$_g_banknum && $sql_where .= " and `cashout_banknum` = '{$_g_banknum}'";
		$_g_banktname && $sql_where .= " and `cashout_banktname` = '{$_g_banktname}'";
		$_g_bankname && $sql_where .= " and `cashout_bankname` = '{$_g_bankname}'";
		$info_list = $db->pe_selectall('cashout', $sql_where, '*', array(20, $_g_page));

		$tj = $db->index('cashout_state')->pe_selectall('cashout', array('group by'=>'cashout_state'), 'count(1) as num, `cashout_state`');
		$tongji[0] = intval($tj[0]['num']);
		$tongji[1] = intval($tj[1]['num']);
		$tongji[2] = intval($tj[2]['num']);
		
		$seo = pe_seo($menutitle='提现管理');
		include(pe_tpl('cashout_list.html'));
	break;
}
?>