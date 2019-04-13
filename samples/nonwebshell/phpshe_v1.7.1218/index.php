<?php
include('common.php');
$cache_category = cache::get('category');
$cache_category_arr = cache::get('category_arr');
$cache_class = cache::get('class');
$cache_class_arr = cache::get('class_arr');
$cache_userlevel = cache::get('userlevel');
$cache_menu = cache::get('menu');
$cache_ad = cache::get('ad');
pe_lead('hook/ad.hook.php');
pe_lead('hook/product.hook.php');
pe_lead('hook/category.hook.php');
pe_lead('hook/user.hook.php');
pe_lead('hook/wechat.hook.php');

$user = pe_login('user');

if (in_array("{$mod}.php", pe_dirlist("{$pe['path_root']}module/{$module}/*.php"))) {
	include("{$pe['path_root']}module/{$module}/{$mod}.php");
}
pe_result();
?>