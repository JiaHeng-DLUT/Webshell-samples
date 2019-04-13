<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'moneylog';
switch ($act) {
	//####################// 资金明细 //####################//
	default:
		$_g_user_name && $sql_where .= " and `user_name` like '%{$_g_user_name}%'";
		$_g_type && $sql_where .= " and `moneylog_type` = '{$_g_type}'";
		$sql_where .= ' order by moneylog_id desc';

		$info_list = $db->pe_selectall('moneylog', $sql_where, '*', array(50, $_g_page));
		$tongji['all'] = $db->pe_num('moneylog');
		$seo = pe_seo($menutitle='资金明细');
		include(pe_tpl('moneylog_list.html'));
	break;
}
?>