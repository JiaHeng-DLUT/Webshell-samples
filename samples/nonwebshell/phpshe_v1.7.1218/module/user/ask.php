<?php
$menumark = 'ask';
switch($act) {
	//####################// 咨询列表 //####################//
	default:
		$info_list = $db->pe_selectall('ask', array('user_id'=>$_s_user_id, 'order by'=>'ask_id desc'), '*', array(20, $_g_page));
		
		$tongji['all'] = $db->pe_num('ask', array('user_id'=>$_s_user_id));
		$seo = pe_seo($menutitle='我的咨询');
		include(pe_tpl('ask_list.html'));
	break;
}
?>