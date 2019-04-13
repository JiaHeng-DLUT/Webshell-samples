<?php
$cache_brand = cache::get('brand');
switch ($act) {
	//####################// 品牌列表 //####################//
	case 'list':	
		$word_arr = range('A', 'Z');
		$info_list = $db->pe_selectall('brand', array('order by'=>'brand_order asc, brand_id desc'));
		$seo = pe_seo($menutitle='品牌专区');
		include(pe_tpl('brand_list.html'));
	break;
	//####################// 品牌详情 //####################//
	default:
		$brand_id = intval($act);
		$category_pid = 0;
		$info = $db->pe_select('brand', array('brand_id'=>$brand_id));
		$sqlwhere .= " and `brand_id` = {$brand_id}";
		$orderby_arr = array('sellnum_desc', 'money_desc', 'money_asc', 'commentnum_desc', 'clicknum_desc');
		if (in_array($_g_orderby, $orderby_arr)) {
			$orderby = explode('_', $_g_orderby);
			$sqlwhere .= " order by `product_{$orderby[0]}` {$orderby[1]}";
		}
		else {
			$sqlwhere .= " order by `product_order` asc, `product_id` desc";
		}
		$info_list = $db->pe_selectall('product', $sqlwhere, '*', array(40, $_g_page));
		//当前路径
		$nowpath = category_path(0, "<a href='".pe_url('brand-list')."'>品牌专区</a> > {$info['brand_name']}");
		$menutitle = '品牌专区';
		$seo = pe_seo($info['brand_name']);
		include(pe_tpl('brand_view.html'));
	break;
}
?>