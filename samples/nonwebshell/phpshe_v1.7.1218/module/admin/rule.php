<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'rule';
pe_lead('hook/cache.hook.php');
pe_lead('include/class/upload.class.php');
switch ($act) {
	//####################// 规格添加 //####################//
	case 'add':
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if (!is_array($_p_name)) pe_error('请添加规格选项...');
			if ($rule_id = $db->pe_insert('rule', pe_dbhold($_p_info))) {
				foreach ($_p_name as $k=>$v) {
					if ($v == '') continue;
					$sql_set['ruledata_name'] = $v;
					$sql_set['ruledata_order'] = $k+1;
					if ($_FILES['logo']['size'][$k]) {
						$logofile['name'] = $_FILES['logo']['name'][$k];
						$logofile['type'] = $_FILES['logo']['type'][$k];
						$logofile['tmp_name'] = $_FILES['logo']['tmp_name'][$k];
						$logofile['error'] = $_FILES['logo']['error'][$k];
						$logofile['size'] = $_FILES['logo']['size'][$k];
						$upload = new upload($logofile);
						$sql_set['ruledata_logo'] = $upload->filehost;
					}
					if ($_p_id[$k]) {
						$db->pe_update('ruledata', array('ruledata_id'=>$_p_id[$k]), pe_dbhold($sql_set));
					}
					else {
						$sql_set['rule_id'] = $rule_id;
						$db->pe_insert('ruledata', pe_dbhold($sql_set));
					}
				}
				cache_write('rule');
				pe_success('添加成功!', 'admin.php?mod=rule');
			}
			else {
				pe_error('添加失败...');
			}
		}
		$seo = pe_seo($menutitle='添加规格', '', '', 'admin');
		include(pe_tpl('rule_add.html'));
	break;
	//####################// 规格修改 //####################//
	case 'edit':
		$rule_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if (!is_array($_p_name)) pe_error('请添加规格选项...');
			if ($db->pe_update('rule', array('rule_id'=>$rule_id), pe_dbhold($_p_info))) {
				$ruledata_list = $db->index('ruledata_id')->pe_selectall('ruledata', array('rule_id'=>$rule_id), 'ruledata_id');
				foreach ($_p_name as $k=>$v) {
					if ($v == '') continue;
					$sql_set['ruledata_name'] = $v;
					$sql_set['ruledata_order'] = $k+1;
					if ($_FILES['logo']['size'][$k]) {
						$logofile['name'] = $_FILES['logo']['name'][$k];
						$logofile['type'] = $_FILES['logo']['type'][$k];
						$logofile['tmp_name'] = $_FILES['logo']['tmp_name'][$k];
						$logofile['error'] = $_FILES['logo']['error'][$k];
						$logofile['size'] = $_FILES['logo']['size'][$k];
						$upload = new upload($logofile);
						$sql_set['ruledata_logo'] = $upload->filehost;
					}
					if ($_p_id[$k]) {
						unset($ruledata_list[$_p_id[$k]]);
						$db->pe_update('ruledata', array('ruledata_id'=>$_p_id[$k]), pe_dbhold($sql_set));
					}
					else {
						$sql_set['rule_id'] = $rule_id;
						$db->pe_insert('ruledata', pe_dbhold($sql_set));
					}					
				}
				$db->pe_delete('ruledata', array('ruledata_id'=>array_keys($ruledata_list)));
				cache_write('rule');
				pe_success('修改成功!', $_g_fromto);
			}
			else {
				pe_error('修改失败!' );
			}
		}
		$info = $db->pe_select('rule', array('rule_id'=>$rule_id));
		$info_list = $db->pe_selectall('ruledata', array('rule_id'=>$rule_id, 'order by'=>'ruledata_order asc'));

		$seo = pe_seo($menutitle='修改规格', '', '', 'admin');
		include(pe_tpl('rule_add.html'));
	break;
	//####################// 规格删除 //####################//
	case 'del':
		pe_token_match();
		$rule_id = intval($_g_id);
		if ($db->pe_delete('rule', array('rule_id'=>$rule_id))) {
			$db->pe_delete('ruledata', array('rule_id'=>$rule_id));
			cache_write('rule');
			pe_success('删除成功!');
		}
		else {
			pe_error('删除失败...');
		}
	break;
	//####################// 规格列表 //####################//
	default :
		$cache_rule = cache::get('rule');
		$info_list = $db->pe_selectall('rule', array("order by"=>"`rule_id` desc"), '*', array(20, $_g_page));
		$tongji['all'] = $db->pe_num('rule');		
		$seo = pe_seo($menutitle='商品规格', '', '', 'admin');
		include(pe_tpl('rule_list.html'));
	break;
}
?>