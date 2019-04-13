<?php
/**
 * @copyright   2008-2014 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'admin';
$adminlevel_list = $db->index('adminlevel_id')->pe_selectall('adminlevel');
switch ($act) {
	//####################// 帐号添加 //####################//
	case 'add':
		if (isset($_p_pesubmit)) {
			pe_token_match();
			$_p_admin_pw && $_p_info['admin_pw'] = md5($_p_admin_pw);
			if ($db->pe_insert('admin', $_p_info)) {
				pe_success('添加成功!', 'admin.php?mod=admin');
			}
			else {
				pe_error('添加失败...');
			}
		}
		$seo = pe_seo($menutitle='添加帐号', '', '', 'admin');
		include(pe_tpl('admin_add.html'));
	break;
	//####################// 帐号修改 //####################//
	case 'edit':
		$admin_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			$_p_admin_pw && $_p_info['admin_pw'] = md5($_p_admin_pw);
			if ($db->pe_update('admin', array('admin_id'=>$admin_id), $_p_info)) {
				pe_success('修改成功!', 'admin.php?mod=admin');
			}
			else {
				pe_error('修改失败...');
			}
		}
		$info = $db->pe_select('admin', array('admin_id'=>$admin_id));
		$seo = pe_seo($menutitle='修改帐号', '', '', 'admin');
		include(pe_tpl('admin_add.html'));
	break;
	//####################// 帐号删除 //####################//
	case 'del':
		pe_token_match();
		$_g_id == 1 && pe_error('默认帐号不可删除...');
		if ($db->pe_delete('admin', array('admin_id'=>$_g_id))) {
			pe_success('删除成功!');
		}
		else {
			pe_error('删除失败...');
		}
	break;
	//####################// 管理帐号 //####################//
	default:
		$info_list = $db->pe_selectall('admin', '', '*', array(50, $_g_page));
		$tongji['all'] = $db->pe_num('admin');
		$seo = pe_seo($menutitle='管理账号', '', '', 'admin');
		include(pe_tpl('admin_list.html'));
	break;
}
?>