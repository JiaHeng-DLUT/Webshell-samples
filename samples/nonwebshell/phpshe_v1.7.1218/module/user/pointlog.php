<?php
$menumark = 'pointlog';
switch($act) {
	//####################// 积分明细 //####################//
	default:
		$info_list = $db->pe_selectall('pointlog', array('user_id'=>$_s_user_id, 'order by'=>'pointlog_id desc'), '*', array(30, $_g_page));

		$tongji['all'] = $db->pe_num('pointlog', array('user_id'=>$_s_user_id));
		$seo = pe_seo($menutitle='积分明细');
		include(pe_tpl('pointlog_list.html'));
	break;
}
?>