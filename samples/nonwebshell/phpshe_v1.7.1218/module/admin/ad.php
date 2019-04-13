<?php
/**
 * @copyright   2008-2014 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'ad';
pe_lead('hook/cache.hook.php');
$cache_category = cache::get('category');
$cache_category_arr = cache::get('category_arr');
if (is_array($cache_category_arr[0])) {
	foreach ($cache_category_arr[0] as $k=>$v) {
		$category_list['index_category'][] = array('id'=>$v['category_id'], 'name'=>$v['category_name']);
	}
}
$category_list = json_encode($category_list);
switch ($act) {
	//####################// 添加广告 //####################//
	case 'add':
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if ($_FILES['ad_logo']['size']) {
				pe_lead('include/class/upload.class.php');
				$upload = new upload($_FILES['ad_logo']);
				$_p_info['ad_logo'] = $upload->filehost;
			}
			$ad_position = explode('|', $_p_ad_position);
			$_p_info['ad_type'] = $ad_position[0];
			$_p_info['ad_position'] = $ad_position[1];
			$_p_info['category_id'] = intval($_p_info['category_id']);
			if ($db->pe_insert('ad', pe_dbhold($_p_info))) {
				cache_write('ad');
				pe_success('添加成功!', 'admin.php?mod=ad');
			}
			else {
				pe_error('添加失败...');
			}
		}
		$info['ad_state'] = 1;
		$seo = pe_seo($menutitle='添加广告', '', '', 'admin');
		include(pe_tpl('ad_add.html'));
	break;
	//####################// 修改广告 //####################//
	case 'edit':
		$ad_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if ($_FILES['ad_logo']['size']) {
				pe_lead('include/class/upload.class.php');
				$upload = new upload($_FILES['ad_logo']);
				$_p_info['ad_logo'] = $upload->filehost;
			}
			$ad_position = explode('|', $_p_ad_position);
			$_p_info['ad_type'] = $ad_position[0];
			$_p_info['ad_position'] = $ad_position[1];
			$_p_info['category_id'] = intval($_p_info['category_id']);
			if ($db->pe_update('ad', array('ad_id'=>$ad_id), pe_dbhold($_p_info))) {
				cache_write('ad');
				pe_success('修改成功!', $_g_fromto);
			}
			else {
				pe_error('修改失败...');
			}
		}
		$info = $db->pe_select('ad', array('ad_id'=>$ad_id));		
		$seo = pe_seo($menutitle='修改广告', '', '', 'admin');
		include(pe_tpl('ad_add.html'));
	break;
	//####################// 广告排序 //####################//
	case 'order':
		pe_token_match();
		foreach ($_p_ad_order as $k=>$v) {
			$result = $db->pe_update('ad', array('ad_id'=>$k), array('ad_order'=>$v));
		}
		if ($result) {
			cache_write('ad');
			pe_success('排序成功!');
		}
		else {
			pe_error('排序失败...');
		}
	break;
	//####################// 广告删除 //####################//
	case 'del':
		pe_token_match();
		$ad_id = is_array($_p_ad_id) ? $_p_ad_id : intval($_g_id);
		if ($db->pe_delete('ad', array('ad_id'=>$ad_id))) {
			cache_write('ad');
			pe_success('删除成功!');
		}
		else {
			pe_error('删除失败...');
		}
	break;
	//####################// 广告状态 //####################//
	case 'state':
		pe_token_match();
		$ad_id = is_array($_p_ad_id) ? $_p_ad_id : intval($_g_id);
		if ($db->pe_update('ad', array('ad_id'=>$ad_id), array('ad_state'=>$_g_state))) {
			cache_write('ad');
			pe_success("操作成功!");
		}
		else {
			pe_error("操作失败...");
		}
	break;
	//####################// 广告列表 //####################//
	default :
		$_g_type && $sql_where .= " and `ad_type` = '{$_g_type}'";
		$_g_position && $sql_where .= " and `ad_position` = '{$_g_position}'";
		$sql_where .= " order by `ad_order` asc, `ad_id` desc";
		$info_list = $db->pe_selectall('ad', $sql_where, '*', array(20, $_g_page));
		$tongji = $db->index('ad_type')->pe_selectall('ad', array('group by'=>'ad_type'), 'count(1) as num, ad_type');
		foreach ($ini['ad_type'] as $k=>$v){
			$tongji[$k] = intval($tongji[$k]['num']);
			$tongji['all'] += $tongji[$k]; 
		}
		$seo = pe_seo($menutitle='广告列表', '', '', 'admin');
		include(pe_tpl('ad_list.html'));
	break;
}
?>