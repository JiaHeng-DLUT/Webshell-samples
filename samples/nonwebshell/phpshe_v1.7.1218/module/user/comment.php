<?php
$menumark = 'comment';
switch($act) {
	//####################// 评价列表 //####################//
	default:
		$info_list = $db->pe_selectall('comment', array('user_id'=>$_s_user_id, 'order by'=>'comment_id desc'), '*', array(20, $_g_page));

		$tongji['all'] = $db->pe_num('comment', array('user_id'=>$_s_user_id));	
		$seo = pe_seo($menutitle='我的评价');
		include(pe_tpl('comment_list.html'));
	break;
}
?>