<?php
$menumark = 'collect';
switch($act) {
	//####################// 收藏删除 //####################//
	case 'del':
		pe_token_match();
		$collect_id = intval($_g_id);
		$info = $db->pe_select('collect', array('collect_id'=>$collect_id));
		if ($db->pe_delete('collect', array('collect_id'=>$collect_id, 'user_id'=>$_s_user_id))) {
			pe_lead('hook/product.hook.php');
			product_jsnum($info['product_id'], 'collectnum');
			pe_jsonshow(array('result'=>true, 'show'=>'删除成功'));
		}
		else {
			pe_jsonshow(array('result'=>false, 'show'=>'删除失败'));
		}
	break;
	//####################// 收藏列表 //####################//
	default:
		$sql = "select * from `".dbpre."collect` a, `".dbpre."product` b where a.`product_id` = b.`product_id` and a.`user_id` = '{$_s_user_id}' order by a.`collect_id` desc";
		$info_list = $db->sql_selectall($sql, array(20, $_g_page));
		$tongji['all'] = $db->pe_num('collect', array('user_id'=>$_s_user_id));		

		$seo = pe_seo($menutitle='我的收藏');
		include(pe_tpl('collect_list.html'));
	break;
}
?>