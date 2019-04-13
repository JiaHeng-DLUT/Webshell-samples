<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'class';
pe_lead('hook/cache.hook.php');
switch ($act) {
	//####################// 分类添加 //####################//
	case 'add':
		$class_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if ($db->pe_insert('class', pe_dbhold($_p_info))) {
				cache_write('class');
				pe_success('添加成功!', 'admin.php?mod=class');
			}
			else {
				pe_error('添加失败...');
			}
		}
		$seo = pe_seo($menutitle='添加分类', '', '', 'admin');
		include(pe_tpl('class_add.html'));
	break;
	//####################// 分类修改 //####################//
	case 'edit':
		$class_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if ($db->pe_update('class', array('class_id'=>$class_id), pe_dbhold($_p_info))) {
				cache_write('class');
				pe_success('修改成功!', 'admin.php?mod=class');
			}
			else {
				pe_error('修改失败...');
			}
		}
		$info = $db->pe_select('class', array('class_id'=>$class_id));

		$seo = pe_seo($menutitle='修改分类', '', '', 'admin');
		include(pe_tpl('class_add.html'));
	break;
	//####################// 分类删除 //####################//
	case 'del':
		pe_token_match();
		$_g_id == 1 && pe_error('网站公告不能删除...');
		if ($db->pe_delete('class', array('class_id'=>$_g_id))) {
			cache_write('class');
			pe_success('删除成功!');
		}
		else {
			pe_error('删除失败...');
		}
	break;
	//####################// 分类排序 //####################//
	case 'order':
		pe_token_match();
		foreach ($_p_class_order as $k=>$v) {
			$result = $db->pe_update('class', array('class_id'=>$k), array('class_order'=>$v));
		}
		if ($result) {
			cache_write('class');
			pe_success('排序成功!');
		}
		else {
			pe_error('排序失败...');
		}
	break;
	//####################// 分类列表 //####################//
	default :
		$_g_type = $_g_type == 'help' ? 'help' : 'news';
		$info_list = $db->pe_selectall('class', array('class_type'=>$_g_type, 'order by'=>'`class_order` asc, `class_id` asc'));
		$seo = pe_seo($menutitle='文章分类', '', '', 'admin');
		include(pe_tpl('class_list.html'));
	break;
}
?>