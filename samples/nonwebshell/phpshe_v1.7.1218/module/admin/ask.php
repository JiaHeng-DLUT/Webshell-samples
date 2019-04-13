<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'ask';
pe_lead('hook/product.hook.php');
switch ($act) {
	//####################// 咨询回复 //####################//
	case 'edit':
		$ask_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if ($_p_info['ask_replytext']) {
				$_p_info['ask_replytime'] = time();
				$_p_info['ask_state'] = 1;
			}
			else {
				$_p_info['ask_replytime'] = $_p_info['ask_state'] = 0;		
			}
			if ($db->pe_update('ask', array('ask_id'=>$ask_id), pe_dbhold($_p_info))) {
				pe_success('修改成功!', $_g_fromto);
			}
			else {
				pe_error('修改失败...');
			}
		}
		$info = $db->pe_select('ask', array('ask_id'=>$ask_id));
		$seo = pe_seo($menutitle='修改咨询', '', '', 'admin');
		include(pe_tpl('ask_add.html'));
	break;
	//####################// 咨询删除 //####################//
	case 'del':
		pe_token_match();
		$ask_id = is_array($_p_ask_id) ? $_p_ask_id : $_g_id;
		$info_list = $db->pe_selectall('ask', array('ask_id'=>$ask_id));
		if ($db->pe_delete('ask', array('ask_id'=>$ask_id))) {
			foreach ($info_list as $v) {
				product_jsnum($v['product_id'], 'asknum');
			}
			pe_success('删除成功!');
		}
		else {
			pe_error('删除失败...');
		}
	break;
	//####################// 咨询列表 //####################//
	default :
		$sql_where = " and `ask_state` = '".intval($_g_state)."'";
		$_g_name && $sql_where .= " and `product_name` like '%{$_g_name}%'";
		$_g_text && $sql_where .= " and `ask_text` like '%{$_g_text}%'";
		$_g_user_name && $sql_where .= " and `user_name` like '%{$_g_user_name}%'";
		$sql_where .= " order by `ask_id` desc";		
		$info_list = $db->pe_selectall('ask', $sql_where, '*', array(20, $_g_page));

		$tj = $db->index('ask_state')->pe_selectall('ask', array('group by'=>'ask_state'), 'count(1) as num, `ask_state`');
		$tongji[1] = intval($tj[1]['num']);
		$tongji[0] = intval($tj[0]['num']);		

		$seo = pe_seo($menutitle='咨询管理', '', '', 'admin');
		include(pe_tpl('ask_list.html'));
	break;
}
?>