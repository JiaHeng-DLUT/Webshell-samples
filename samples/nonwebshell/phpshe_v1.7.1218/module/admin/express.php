<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'setting';
pe_lead('hook/cache.hook.php');
switch ($act) {
	//####################// 模板添加 //####################//
	case 'add':
		$express_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if (is_array($_p_tag_name)) {
				foreach ($_p_tag_name as $k=>$v) {
					$tag_list[$k]['name'] = $v;
					$tag_list[$k]['type'] = $_p_tag_type[$k];				
					$tag_list[$k]['value'] = $_p_tag_value[$k];			
					$tag_list[$k]['position'] = $_p_tag_position[$k];	
				}
			}
			$_p_info['express_tag'] = is_array($tag_list) ? serialize($tag_list) : '';
			if ($db->pe_insert('express', pe_dbhold($_p_info, array('express_tag')))) {
				//cache_write('express');
				pe_success('添加成功!', 'admin.php?mod=express');
			}
			else {
				pe_error('添加失败...');
			}
		}
		$tag_list = array();
		$seo = pe_seo($menutitle='模板添加', '', '', 'admin');
		include(pe_tpl('express_add.html'));
	break;
	//####################// 模板修改 //####################//
	case 'edit':
		$express_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if (is_array($_p_tag_name)) {
				foreach ($_p_tag_name as $k=>$v) {
					$tag_list[$k]['name'] = $v;
					$tag_list[$k]['type'] = $_p_tag_type[$k];				
					$tag_list[$k]['value'] = $_p_tag_value[$k];			
					$tag_list[$k]['position'] = $_p_tag_position[$k];	
				}
			}
			$_p_info['express_tag'] = is_array($tag_list) ? serialize($tag_list) : '';
			if ($db->pe_update('express', array('express_id'=>$express_id), pe_dbhold($_p_info, array('express_tag')))) {
				//cache_write('express');
				pe_success('修改成功!', 'admin.php?mod=express');
			}
			else {
				pe_error('修改失败...');
			}
		}
		$info = $db->pe_select('express', array('express_id'=>$express_id));
		$tag_list = $info['express_tag'] ? unserialize($info['express_tag']) : array();
	
		$seo = pe_seo($menutitle='模板修改', '', '', 'admin');
		include(pe_tpl('express_add.html'));
	break;
	//####################// 模板删除 //####################//
	case 'del':
		pe_token_match();
		$express_id = is_array($_p_express_id) ? $_p_express_id : intval($_g_id);
		if ($db->pe_delete('express', array('express_id'=>$express_id))) {
			//cache_write('express');
			pe_success('删除成功!');
		}
		else {
			pe_error('删除失败...');
		}
	break;
	//####################// 模板排序 //####################//
	case 'order':
		pe_token_match();
		foreach ($_p_express_order as $k=>$v) {
			$result = $db->pe_update('express', array('express_id'=>$k), array('express_order'=>$v));
		}
		if ($result) {
			//cache_write('express');
			pe_success('排序成功!');
		}
		else {
			pe_error('排序失败...');
		}
	break;
	//####################// 模板列表 //####################//
	default :
		$info_list = $db->pe_selectall('express', array('order by'=>'`express_order` asc, `express_id` desc'));
		$seo = pe_seo($menutitle='运单模板', '', '', 'admin');
		include(pe_tpl('express_list.html'));
	break;
}
?>