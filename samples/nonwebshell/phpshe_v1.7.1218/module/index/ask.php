<?php
switch ($act) {
	//####################// 新增咨询 //####################//
	case 'add':
		if (isset($_p_pesubmit)) {
			$product_id = intval($_g_id);
			if (!pe_login('user')) pe_jsonshow(array('result'=>false, 'show'=>'请先登录...'));
			if (!$_p_ask_text) pe_jsonshow(array('result'=>false, 'show'=>'请填写咨询内容...'));
			$info = $db->pe_select('product', array('product_id'=>$product_id), 'product_id, product_name, product_logo');
			if (!$info['product_id']) pe_jsonshow(array('result'=>false, 'show'=>'无效商品...'));			
			$info['product_id'] = $info['product_id'];
			$info['product_name'] = $info['product_name'];
			$info['product_logo'] = $info['product_logo'];
			$info['ask_text'] = $_p_ask_text;
			$info['ask_atime'] = time();
			$info['user_id'] = $_s_user_id;
			$info['user_name'] = $_s_user_name;
			$info['user_ip'] = pe_ip();
			if ($db->pe_insert('ask', pe_dbhold($info))) {
				product_jsnum($info['product_id'], 'asknum');
				pe_jsonshow(array('result'=>true, 'show'=>'提交成功！管理员会尽快答复...'));
			}
			else {
				pe_jsonshow(array('result'=>false, 'show'=>'提交失败，请重新提交...'));
			}
		}
	break;
	//####################// 咨询列表 //####################//
	default:
		$sql_where['product_id'] = intval($_g_id);
		$sql_where['order by'] = "`ask_id` desc";
		$info_list = $db->pe_selectall('ask', $sql_where, '*', array('20', $_g_page));
		foreach ($info_list as $k=>$v) {
			$info_list[$k]['ask_atime'] = pe_date($v['ask_atime'], 'Y-m-d');
		}
		pe_jsonshow(array('list'=>$info_list, 'page'=>$db->page->ajax('ask_page')));
	break;
}
?>