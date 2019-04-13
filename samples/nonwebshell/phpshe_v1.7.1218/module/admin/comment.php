<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'comment';
pe_lead('hook/product.hook.php');
switch ($act) {
	//####################// 评价修改 //####################//
	case 'edit':
		$comment_id = intval($_g_id);
		$info = $db->pe_select('comment', array('comment_id'=>$comment_id));
		if (isset($_p_pesubmit)) {
			pe_token_match();
			$_p_info['comment_logo'] = implode(',', array_filter($_p_comment_logo));
			if ($_p_info['comment_reply_text']) {
				$_p_info['comment_reply_time'] = time();
				$_p_info['comment_reply'] = 1;
			}
			else {
				$_p_info['comment_reply_time'] = $_p_info['comment_reply'] = 0;		
			}
			if ($db->pe_update('comment', array('comment_id'=>$comment_id), pe_dbhold($_p_info))) {
				product_jsnum($info['product_id'], 'commentnum');
				pe_success('修改成功!', $_g_fromto);
			}
			else {
				pe_error('修改失败...');
			}
		}
		$comment_logo = explode(',', $info['comment_logo']);
		$seo = pe_seo($menutitle='修改评价', '', '', 'admin');
		include(pe_tpl('comment_add.html'));
	break;
	//####################// 评价删除 //####################//
	case 'del':
		pe_token_match();
		$comment_id = is_array($_p_comment_id) ? $_p_comment_id : $_g_id;
		$info_list = $db->pe_selectall('comment', array('comment_id'=>$comment_id));
		if ($db->pe_delete('comment', array('comment_id'=>$comment_id))) {
			foreach ($info_list as $v) {
				product_jsnum($v['product_id'], 'commentnum');
			}			
			pe_success('删除成功!');
		}
		else {
			pe_error('删除失败...');
		}
	break;
	//####################// 晒图详情 //####################//
	case 'logo':
		$comment_id = intval($_g_id);
		$info = $db->pe_select('comment', array('comment_id'=>$comment_id));
		$info_list = $info['comment_logo'] ? explode(',', $info['comment_logo']) : array();
		$nownum = 0;
		foreach ($info_list as $k=>$v) {
			if ($k == $_g_num) $nownum = $k;
		}		
		$seo = pe_seo($menutitle='晒图详情');
		include(pe_tpl('comment_logo.html'));
	break;
	//####################// 评价列表 //####################//
	default :
		$star_arr = array('hao'=>'4,5', 'zhong'=>'3', 'cha'=>'1,2');		
		$_g_star && $sql_where .= " and `comment_star` in ({$star_arr[$_g_star]})";
		$_g_name && $sql_where .= " and `product_name` like '%{$_g_name}%'";
		$_g_text && $sql_where .= " and `comment_text` like '%{$_g_text}%'";
		strlen($_g_reply) && $sql_where .= " and `comment_reply` = '{$_g_reply}'";
		$_g_user_name && $sql_where .= " and `user_name` like '%{$_g_user_name}%'";
		$sql_where .= " order by `comment_id` desc";
		$info_list = $db->pe_selectall('comment', $sql_where, '*', array(20, $_g_page));

		$tj = $db->index('comment_star')->pe_selectall('comment', array('group by'=>'comment_star'), 'count(1) as num, `comment_star`');
		$tongji['hao'] = intval($tj[4]['num'] + $tj[5]['num']);
		$tongji['zhong'] = intval($tj[3]['num']);
		$tongji['cha'] = intval($tj[1]['num'] + $tj[2]['num']);
		$tongji['all'] = $tongji['hao'] + $tongji['zhong'] + $tongji['cha'];

		$seo = pe_seo($menutitle='评价管理', '', '', 'admin');
		include(pe_tpl('comment_list.html'));
	break;
}
?>