<?php
/**
 * @copyright   2008-2014 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-1116 koyshe <koyshe@gmail.com>
 */
$menumark = 'payment';
pe_lead('hook/cache.hook.php');
switch ($act) {
	//####################// 支付修改 //####################//
	case 'edit':
		$payment_id = intval($_g_id);
		$info = $db->pe_select('payment', array('payment_id'=>$payment_id));
		if (isset($_p_pesubmit)) {
			pe_token_match();
			$_p_info['payment_config'] = $_p_config ? serialize($_p_config) : '';
			if ($db->pe_update('payment', array('payment_id'=>$payment_id), $_p_info)) {
				cache_write('payment');
				if ($info['payment_type'] == 'wechat') {
					pe_lead('hook/wechat.hook.php');
					wechat_config(true);
				}
				pe_success('修改成功!', 'admin.php?mod=payment');
			}
			else {
				pe_error('修改失败...' );
			}
		}		
		$info['payment_model'] = $info['payment_model'] ? unserialize($info['payment_model']) : array();
		$info['payment_config'] = $info['payment_config'] ? unserialize($info['payment_config']) : array();
		$seo = pe_seo($menutitle='修改支付方式', '', '', 'admin');
		include(pe_tpl('payment_add.html'));
	break;
	//####################// 支付状态 //####################//
	case 'state':
		pe_token_match();
		if ($db->pe_update('payment', array('payment_id'=>is_array($_p_payment_id) ? $_p_payment_id : $_g_id), array('payment_state'=>$_g_state))) {
			cache_write('payment');
			pe_success("操作成功!");
		}
		else {
			pe_error("操作失败...");
		}
	break;
	//####################// 支付排序 //####################//
	case 'order':
		pe_token_match();
		foreach ($_p_payment_order as $k => $v) {
			$result = $db->pe_update('payment', array('payment_id'=>$k), array('payment_order'=>$v));
		}
		if ($result) {
			cache_write('payment');
			pe_success('排序成功!');
		}
		else {
			pe_error('排序失败...');
		}
	break;
	//####################// 安装支付 //####################//
	case 'install':
		pe_token_match();
		$payment_type = pe_dbhold($_g_type);
		if ($db->pe_num('payment', array('payment_type'=>$payment_type))) pe_error("支付类型 {$payment_type} 已存在");
		$info = payment_info($payment_type);
		if (!$info['name']) pe_error('支付插件不存在');
		$_p_info['payment_name'] = $info['name'];
		$_p_info['payment_type'] = $info['type'];
		$_p_info['payment_desc'] = $info['desc'];
		$_p_info['payment_model'] = $info['model'] ? serialize($info['model']) : '';
		$_p_info['payment_state'] = 1;
		if ($db->pe_insert('payment', pe_dbhold($_p_info, array('payment_model')))) {
			cache_write('payment');
			pe_success('安装成功!');
		}
		else {
			pe_error('安装失败');
		}
	break;
	//####################// 卸载支付 //####################//
	case 'uninstall':
		pe_token_match();
		if ($db->pe_delete('payment', array('payment_id'=>intval($_g_id)))) {
			cache_write('payment');
			pe_success('卸载成功!');
		}
		else {
			pe_error('卸载失败');
		}
	break;
	//####################// 支付列表 //####################//
	default:
		$info_list = $db->index('payment_type')->pe_selectall('payment', array('order by'=>'`payment_order` asc, `payment_id` asc'));
		$new_arr = pe_dirlist("{$pe['path_root']}include/plugin/payment/*");
		$new_list = array();
		foreach ($new_arr as $v) {
			$info = payment_info($v);	
			if (is_array($info_list[$v])) continue;
			if ($info['name']) $new_list[$v] = $info;	
		}
		$tongji['all'] = count($info_list) + count($new_list);
		$seo = pe_seo($menutitle='支付方式', '', '', 'admin');
		include(pe_tpl('payment_list.html'));		
	break;
}
function payment_info($type) {
	global $pe;
	$file = "{$pe['path_root']}include/plugin/payment/{$type}/install.php";
	if (is_file($file)) {
		$info = include($file);
		if ($info['type'] == $type && $info['name']) return $info;	
	}
	return array();
}
?>