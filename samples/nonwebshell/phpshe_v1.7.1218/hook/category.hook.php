<?php
//分类树形列表
function category_treelist()
{
	global $db;
	pe_lead('include/class/categorytree.class.php');
	$category = new category();
	return $category->gettree($db->pe_selectall('category', array('order by'=> 'category_order asc, category_id asc')));
}
//分类层级路径
function category_path($id, $other = null)
{
	global $pe;
	$category_list = cache::get('category');
	pe_lead('include/class/categorytree.class.php');
	$category = new category();
	$pid_arr = $category->getpid_arr($category_list, $id);
	$path = "<a href='{$pe['host_root']}'>首页</a>";
	foreach ($pid_arr as $v) {
		$path .= " > <a href='".pe_url("product-list-{$category_list[$v]['category_id']}")."' title='{$category_list[$v]['category_name']}'>{$category_list[$v]['category_name']}</a>";
	}
	$id && $path .= " > <a href='".pe_url("product-list-{$category_list[$id]['category_id']}")."' title='{$category_list[$id]['category_name']}'>{$category_list[$id]['category_name']}</a>";
	$other && $path .= " > {$other}";
	return $path;
}

//分类下子分类id
function category_cidarr($id) {
	$category_list = cache::get('category');
	pe_lead('include/class/categorytree.class.php');
	$category = new category();
	$cid_arr = $category->getcid_arr($category_list, $id);
	if ($cid_arr) {
		$cid_arr[] = intval($id);
		return $cid_arr;
	}
	else {
		return $id;
	}
}

//分类下品牌列表
function category_brand($id) {
	global $db;
	$category_cidarr = category_cidarr($id);
	$sql = "select a.brand_id, a.brand_name from `".dbpre."brand` a, (select * from `".dbpre."product` where ".pe_sqlin('category_id', $category_cidarr).") b where a.`brand_id` = b.`brand_id` order by a.`brand_order` asc, a.`brand_id` asc";
	return $db->index('brand_id')->sql_selectall($sql);
}
?>