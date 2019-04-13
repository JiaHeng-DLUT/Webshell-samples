<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'userlevel';
pe_lead('hook/cache.hook.php');
pe_lead('hook/user.hook.php');
switch ($act) {
	//####################// 等级添加 //####################//
	case 'add':
		if (isset($_p_pesubmit)) {
			pe_token_match();
			$_p_info['userlevel_zhe'] = pe_num($_p_info['userlevel_zhe']/100, 'floor', 2);
			if ($db->pe_insert('userlevel', pe_dbhold($_p_info))) {
				cache_write('userlevel');
				userlevel_callback();
				pe_success('添加成功!', 'admin.php?mod=userlevel');
			}
			else {
				pe_error('添加失败...');
			}
		}
		$info['userlevel_up'] = 1;
		$seo = pe_seo($menutitle='添加等级', '', '', 'admin');
		include(pe_tpl('userlevel_add.html'));
	break;
	//####################// 等级修改 //####################//
	case 'edit':
		$userlevel_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			$_p_info['userlevel_zhe'] = pe_num($_p_info['userlevel_zhe']/100, 'floor', 2);
			if ($db->pe_update('userlevel', array('userlevel_id'=>$userlevel_id), pe_dbhold($_p_info))) {
				cache_write('userlevel');
				userlevel_callback();
				pe_success('修改成功!', 'admin.php?mod=userlevel');
			}
			else {
				pe_error('修改失败...');
			}
		}
		$info = $db->pe_select('userlevel', array('userlevel_id'=>$userlevel_id));
		$seo = pe_seo($menutitle='修改等级', '', '', 'admin');
		include(pe_tpl('userlevel_add.html'));
	break;
	//####################// 等级删除 //####################//
	case 'del':
		pe_token_match();
		$userlevel_id = is_array($_p_userlevel_id) ? $_p_userlevel_id : intval($_g_id);
		if ($db->pe_delete('userlevel', array('userlevel_id'=>$userlevel_id))) {
			cache_write('userlevel');
			userlevel_callback();
			pe_success('删除成功!');
		}
		else {
			pe_error('删除失败...');
		}
	break;
	//####################// 等级列表 //####################//
	default :
		foreach ($ini['userlevel_up'] as $k=>$v) {
			$info_list[$k] = $db->pe_selectall('userlevel', array("userlevel_up"=>$k, "order by"=>"`userlevel_value` asc, `userlevel_id` asc"));
		}

		$tongji['all'] = $db->pe_num('userlevel');		
		$seo = pe_seo($menutitle='会员等级', '', '', 'admin');
		include(pe_tpl('userlevel_list.html'));
	break;
}
?>