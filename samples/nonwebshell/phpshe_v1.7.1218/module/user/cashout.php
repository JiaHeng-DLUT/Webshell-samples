<?php
/**
 * @copyright   2008-2014 简好网络 <http://www.phpshe.com>
 * @creatdate   2016-0101 koyshe <koyshe@gmail.com>
 */
switch ($act) {
	//####################// 提现申请 //####################//
	case 'add':
		$menumark = 'cashout_add';
		$info = $db->pe_select('user', array('user_id'=>$_s_user_id));
		$userbank_list = $db->index('userbank_id')->pe_selectall('userbank', array('user_id'=>$_s_user_id, 'order by'=>'userbank_id desc'));
		$cache_setting['cashout_fee'] = round($cache_setting['cashout_fee'], 4);
		//!count($userbank_list) && pe_error('请先添加收款账户', 'user.php?mod=userbank&act=add');
		if (isset($_p_pesubmit)) {
			$cashout_money = round($_p_cashout_money, 1); 
			$cashout_fee = round($cashout_money * $cache_setting['cashout_fee'], 1);
			if (!is_array($userbank_list[$_p_userbank_id])) pe_jsonshow(array('result'=>false, 'show'=>'请选择收款账户'));
			if ($cashout_money < $cache_setting['cashout_min']) pe_jsonshow(array('result'=>false, 'show'=>"提现金额小于{$cache_setting['cashout_min']}元"));
			if ($cashout_money > $info['user_money']) pe_jsonshow(array('result'=>false, 'show'=>'余额不足'));
			$sql_set['cashout_money'] = $cashout_money - $cashout_fee;
			$sql_set['cashout_fee'] = $cashout_fee;
			$sql_set['cashout_atime'] = time();
			$sql_set['cashout_ip'] = pe_ip();
			$sql_set['cashout_bankname'] = $userbank_list[$_p_userbank_id]['userbank_name'];
			$sql_set['cashout_banknum'] = $userbank_list[$_p_userbank_id]['userbank_num'];
			$sql_set['cashout_banktname'] = $userbank_list[$_p_userbank_id]['userbank_tname'];
			$sql_set['cashout_bankaddress'] = $userbank_list[$_p_userbank_id]['userbank_address'];	
			$sql_set['user_id'] = $info['user_id'];
			$sql_set['user_name'] = $info['user_name'];
			if ($db->pe_insert('cashout', pe_dbhold($sql_set))) {
				add_moneylog($_s_user_id, 'cashout', $cashout_money, "提现{$cashout_money}元，手续费{$cashout_fee}元，实到账{$sql_set['cashout_money']}元");
				pe_jsonshow(array('result'=>true, 'show'=>'申请已提交'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'提交失败'));
			}
		}
		$seo = pe_seo($menutitle='申请提现');
		include(pe_tpl('cashout_add.html'));
	break;
	//####################// 取消提现 //####################//
	case 'del':
		$info = $db->pe_select('cashout', array('cashout_id'=>intval($_g_id), 'cashout_state'=>0, 'user_id'=>$_s_user_id));
		if (!$info['cashout_id']) pe_jsonshow(array('result'=>false, 'show'=>'参数无效'));
		$sql_set['cashout_state'] = 2;
		$sql_set['cashout_ptime'] = time();		
		if ($db->pe_update('cashout', array('cashout_id'=>$info['cashout_id']), $sql_set)) {
			$cashout_money = $info['cashout_money'] + $info['cashout_fee'];
			add_moneylog($info['user_id'], 'back', $cashout_money, "用户取消提现，退回{$cashout_money}元");
			pe_jsonshow(array('result'=>true, 'show'=>'取消成功'));
		}
		else {
			pe_jsonshow(array('result'=>false, 'show'=>'取消失败'));
		}
	break;
	//####################// 结算列表 //####################//
	default:
		$menumark = 'cashout_list';
		$info_list = $db->pe_selectall('cashout', array('user_id'=>$_s_user_id, 'order by'=>'`cashout_id` desc'), '*', array(20, $_g_page));

		$seo = pe_seo($menutitle='提现记录');
		include(pe_tpl('cashout_list.html'));
	break;
}
?>