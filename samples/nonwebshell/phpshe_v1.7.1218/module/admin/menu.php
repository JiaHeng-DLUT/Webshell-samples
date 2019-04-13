<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'menu';
pe_lead('hook/cache.hook.php');
switch ($act) {
	//####################// 导航添加 //####################//
	case 'add':
		$menu_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if ($_p_info['menu_type'] != 'diy') {
				$_p_info['menu_url'] = $_p_info['menu_type'];
				$_p_info['menu_type'] = 'sys';
			}
			if ($db->pe_insert('menu', pe_dbhold($_p_info))) {
				cache_write('menu');
				pe_success('添加成功!', 'admin.php?mod=menu');
			}
			else {
				pe_error('添加失败...');
			}
		}
		$menu_sys_arr = menu_sys_arr();
		$info['menu_target'] = 1;
		$seo = pe_seo($menutitle='添加导航', '', '', 'admin');
		include(pe_tpl('menu_add.html'));
	break;
	//####################// 导航修改 //####################//
	case 'edit':
		$menu_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if ($_p_info['menu_type'] != 'diy') {
				$_p_info['menu_url'] = $_p_info['menu_type'];
				$_p_info['menu_type'] = 'sys';
			}
			if ($db->pe_update('menu', array('menu_id'=>$menu_id), pe_dbhold($_p_info))) {
				cache_write('menu');
				pe_success('修改成功!', 'admin.php?mod=menu');
			}
			else {
				pe_error('修改失败...');
			}
		}
		$info = $db->pe_select('menu', array('menu_id'=>$menu_id));
		$menu_sys_arr = menu_sys_arr();
		$seo = pe_seo($menutitle='修改导航', '', '', 'admin');
		include(pe_tpl('menu_add.html'));
	break;
	//####################// 导航删除 //####################//
	case 'del':
		pe_token_match();
		$menu_id = is_array($_p_menu_id) ? $_p_menu_id : intval($_g_id);
		if ($db->pe_delete('menu', array('menu_id'=>$menu_id))) {
			cache_write('menu');
			pe_success('删除成功!');
		}
		else {
			pe_error('删除失败...');
		}
	break;
	//####################// 导航排序 //####################//
	case 'order':
		pe_token_match();
		foreach ($_p_menu_order as $k=>$v) {
			$result = $db->pe_update('menu', array('menu_id'=>$k), array('menu_order'=>$v));
		}
		if ($result) {
			cache_write('menu');
			pe_success('排序成功!');
		}
		else {
			pe_error('排序失败...');
		}
	break;
	//####################// 导航列表 //####################//
	default :
		$info_list = $db->pe_selectall('menu', array('order by'=>'`menu_order` asc, `menu_id` asc'));
		$tongji['all'] = $db->pe_num('menu');
		$seo = pe_seo($menutitle='导航设置', '', '', 'admin');
		include(pe_tpl('menu_list.html'));
	break;
}
function menu_sys_arr() {
	pe_lead('hook/category.hook.php');
	$arr[] = 'line';
	$category_treelist = category_treelist();
	foreach ($category_treelist as $v) {
		$arr["[商品分类] {$v['category_showname']}"] = array("modurl"=>"product-list-{$v['category_id']}", "url"=>pe_url("product-list-{$v['category_id']}"));
	}
	$arr[] = 'line';
	$cache_class = cache::get('class');
	foreach ($cache_class as $v) {
		$arr["[文章分类] {$v['class_name']}"] = array("modurl"=>"article-list-{$v['class_id']}", "url"=>pe_url("article-list-{$v['class_id']}"));
	}
	$arr[] = 'line';
	//$arr['brand'] = '===品牌列表===';
	$arr['[其他栏目] 品牌专区'] = array("modurl"=>"brand-list", "url"=>pe_url("brand-list"));
	$arr['[其他栏目] 领券中心'] = array("modurl"=>"quan-list", "url"=>pe_url("quan-list"));
	$arr['[其他栏目] 限时折扣'] = array("modurl"=>"huodong-zhekou", "url"=>pe_url("huodong-zhekou"));
	$arr['[其他栏目] 限时拼团'] = array("modurl"=>"huodong-pintuan", "url"=>pe_url("huodong-pintuan"));
	/*$arr['page'] = '========@单页列表@========';
	$page_class = cache::get('page');
	foreach ($page_class as $v) {
		$arr[$v['page_name']] = "{$v['page_name']}|page-{$v['page_id']}";
	}*/
	return $arr;
}
?>