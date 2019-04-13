<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'category';
pe_lead('hook/cache.hook.php');
pe_lead('hook/category.hook.php');
$category_treelist = category_treelist();
$cache_brand = cache::get('brand');
switch ($act) {
	//####################// 添加分类 //####################//
	case 'add':
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if ($category_id = $db->pe_insert('category', pe_dbhold($_p_info))) {
				cache_write('category');
				pe_success('添加成功!', 'admin.php?mod=category');
			}
			else {
				pe_error('添加失败!');
			}
		}
		$seo = pe_seo($menutitle='添加分类', '', '', 'admin');
		include(pe_tpl('category_add.html'));
	break;
	//####################// 修改分类 //####################//
	case 'edit':
		$category_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if ($db->pe_update('category', array('category_id'=>$category_id), pe_dbhold($_p_info))) {
				cache_write('category');
				pe_success('修改成功!', 'admin.php?mod=category');
			}
			else {
				pe_error('修改失败...');
			}
		}
		$info = $db->pe_select('category', array('category_id'=>$category_id));

		//不允许移动到的分类id数组
		$category = new category();
		$category_noid = $category->getcid_arr($category_treelist, $info['category_id']);
		$category_noid[] = $info['category_id'];

		$seo = pe_seo($menutitle='修改分类', '', '', 'admin');
		include(pe_tpl('category_add.html'));
	break;
	//####################// 分类排序 //####################//
	case 'order':
		pe_token_match();
		foreach ($_p_category_order as $k=>$v) {
			$result = $db->pe_update('category', array('category_id'=>$k), array('category_order'=>$v));
		}
		if ($result) {
			cache_write('category');
			pe_success('排序成功!');
		}
		else {
			pe_error('排序失败...');
		}
	break;
	//####################// 分类删除 //####################//
	case 'del':
		pe_token_match();
		$category_id = is_array($_p_category_id) ? $_p_category_id : intval($_g_id);
		if ($db->pe_delete('category', array('category_id'=>$category_id))) {
			cache_write('category');
			pe_success('删除成功!');
		}
		else {
			pe_error('删除失败...');
		}
	break;
	//####################// 分类列表 //####################//
	default :
		$info_list = $category_treelist;
		$tongji['all'] = $db->pe_num('category');
		$seo = pe_seo($menutitle='商品分类', '', '', 'admin');
		include(pe_tpl('category_list.html'));
	break;
}
?>