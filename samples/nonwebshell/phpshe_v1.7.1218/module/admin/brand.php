<?php
$menumark = 'brand';
pe_lead('hook/cache.hook.php');
switch ($act) {
	//####################// 添加品牌 //####################//
	case 'add':
		if (isset($_p_pesubmit)) {
			pe_token_match();
			pe_lead('include/class/pinyin.class.php');
			$pinyin = new pinyin();
			$_p_info['brand_word'] = strtoupper(substr($pinyin->output($_p_info['brand_name']), 0, 1));
			if ($brand_id = $db->pe_insert('brand', pe_dbhold($_p_info))) {
				if ($_FILES['brand_logo']['size']) {
					pe_lead('include/class/upload.class.php');
					$upload = new upload($_FILES['brand_logo'], 'data/attachment/brand/', array('filename'=>$brand_id));
					$db->pe_update('brand', array('brand_id'=>$brand_id), array('brand_logo'=>$upload->filehost));
				}
				cache_write('brand');
				pe_success('添加成功!', 'admin.php?mod=brand');
			}
			else {
				pe_error('添加失败!');
			}
		}
		$seo = pe_seo($menutitle='添加品牌', '', '', 'admin');
		include(pe_tpl('brand_add.html'));
	break;
	//####################// 修改品牌 //####################//
	case 'edit':
		$brand_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if ($_FILES['brand_logo']['size']) {
				pe_lead('include/class/upload.class.php');
				$upload = new upload($_FILES['brand_logo'], 'data/attachment/brand/', array('filename'=>$brand_id));
				$_p_info['brand_logo'] = $upload->filehost;
			}
			pe_lead('include/class/pinyin.class.php');
			$pinyin = new pinyin();
			$_p_info['brand_word'] = strtoupper(substr($pinyin->output($_p_info['brand_name']), 0, 1));
			if ($db->pe_update('brand', array('brand_id'=>$brand_id), pe_dbhold($_p_info))) {
				cache_write('brand');
				pe_success('修改成功!', 'admin.php?mod=brand');
			}
			else {
				pe_error('修改失败...');
			}
		}
		$info = $db->pe_select('brand', array('brand_id'=>$brand_id));
		$seo = pe_seo($menutitle='修改品牌', '', '', 'admin');
		include(pe_tpl('brand_add.html'));
	break;
	//####################// 品牌排序 //####################//
	case 'order':
		pe_token_match();
		foreach ($_p_brand_order as $k=>$v) {
			$result = $db->pe_update('brand', array('brand_id'=>$k), array('brand_order'=>$v));
		}
		if ($result) {
			cache_write('brand');
			pe_success('排序成功!');
		}
		else {
			pe_error('排序失败...');
		}
	break;
	//####################// 品牌删除 //####################//
	case 'del':
		pe_token_match();
		$brand_id = is_array($_p_brand_id) ? $_p_brand_id : intval($_g_id);
		if ($db->pe_delete('brand', array('brand_id'=>$brand_id))) {
			pe_success('删除成功!');
		}
		else {
			pe_error('删除失败...');
		}
	break;
	//####################// 品牌列表 //####################//
	default :
		$info_list = $db->pe_selectall('brand', array('order by'=>'brand_order asc, brand_id desc'), '*', array(30, $_g_page));
		$tongji['all'] = $db->pe_num('brand');
		$seo = pe_seo($menutitle='品牌管理', '', '', 'admin');
		include(pe_tpl('brand_list.html'));
	break;
}
?>