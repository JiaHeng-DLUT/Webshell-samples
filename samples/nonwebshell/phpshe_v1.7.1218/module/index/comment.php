<?php
switch ($act) {
	//####################// 评价列表 //####################//
	default:
		$product_id = intval($id);
		$info = $db->pe_select('product', array('product_id'=>$product_id), 'product_commentrate, product_commentnum');
		$tongji = explode(',', $info['product_commentrate']);
		if (isset($_g_page)) {
			$star_arr = array('hao'=>array(4,5), 'zhong'=>3, 'cha'=>array(1,2));	
			if (array_key_exists($_g_star, $star_arr)) $sql_where['comment_star'] = $star_arr[$_g_star];
			$sql_where['product_id'] = $product_id;
			$sql_where['order by'] = "`comment_id` desc";	
			$info_list = $db->pe_selectall('comment', $sql_where, 'user_name,user_logo,comment_id,comment_star,comment_logo,comment_text,comment_atime,comment_reply,comment_reply_text,comment_reply_time', array('20', $_g_page));
			foreach ($info_list as $k=>$v) {
				$info_list[$k]['comment_star'] = pe_comment($v['comment_star'], 14);
				$info_list[$k]['comment_atime'] = pe_date($v['comment_atime'], 'Y-m-d');
				$info_list[$k]['comment_reply_time'] = pe_date($v['comment_reply_time'], 'Y-m-d');
				$info_list[$k]['user_logo'] = pe_thumb($v['user_logo'], '_120', '_120', 'avatar');
				//评价晒图
				if ($v['comment_logo']) {
					$comment_logo_arr = explode(',', $v['comment_logo']);
					foreach ($comment_logo_arr as $kk=>$vv) {
						$comment_logo[$kk]['logo'] = pe_thumb($vv, '_400', '_400');
						$comment_logo[$kk]['url'] = pe_url('comment-logo', "id={$v['comment_id']}&num={$kk}");
					}	
				}
				else {
					$comment_logo = array();
				}
				$info_list[$k]['comment_logo'] = $comment_logo;
			}
			$result = count($info_list) ? true : false;
			pe_jsonshow(array('result'=>$result, 'list'=>$info_list, 'page'=>$db->page->ajax('comment_page')));
		}
	break;
}
?>