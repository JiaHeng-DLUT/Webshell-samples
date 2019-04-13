<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'order_pay';
switch ($act) {
	//####################// 充值记录 //####################//
	default:
		$_g_id && $sql_where .= " and `order_id` = '{$_g_id}'";
		$_g_state && $sql_where .= " and `order_state` = '{$_g_state}'";
		$_g_user_name && $sql_where .= " and `user_name` like '%{$_g_user_name}%'";
		$sql_where .= ' order by `order_id` desc';

		$info_list = $db->pe_selectall('order_pay', $sql_where, '*', array(50, $_g_page));
		$tongji_arr = $db->index('order_state')->pe_selectall('order_pay', array('group by'=>'order_state'), 'count(1) as `num`, `order_state`');
		foreach (array('wpay', 'success') as $v) {
			$tongji[$v] = intval($tongji_arr[$v]['num']);
			$tongji['all'] += $tongji[$v]; 
		}	
		
		$seo = pe_seo($menutitle='充值记录');
		include(pe_tpl('order_pay_list.html'));
	break;
}
?>