<?php
//热销商品
function product_hotlist($num = 5) {
	global $db;
	return $db->pe_selectall('product', array('product_state'=>1, 'order by'=>'`product_sellnum` desc'), '*', array($num));
}

//新品推荐
function product_newlist($num = 5) {
	global $db;
	return $db->pe_selectall('product', array('product_istuijian'=>1, 'product_state'=>1, 'order by'=>'product_order asc, product_id desc'), '*', array($num));
}

//获取购买商品信息
function product_buyinfo($product_guid) {
	global $db;
	$sql_field = "a.`product_id`, a.`product_guid`, a.`product_rule`, a.`product_money`, a.`product_smoney`, a.`product_num`, b.`product_name`, b.`product_type`, b.`product_logo`, b.`product_wlmoney`, b.`product_point`, b.`huodong_id`, b.`huodong_type`, b.`huodong_tag`, b.`huodong_stime`, b.`huodong_etime`";
	$sql = "select {$sql_field} from `".dbpre."prodata` a, `".dbpre."product` b where a.`product_id` = b.`product_id` and a.`product_guid` = '{$product_guid}' and b.`product_state` = 1";
	$info = $db->sql_select($sql);
	return $info;
}

//商品数量更新
function product_jsnum($id, $type, $num = 1) {
	global $db;
	switch ($type) {
		case 'add_num':
		case 'del_num':
			$product_guid = intval($id);
			$info = $db->pe_select('prodata', array('product_guid'=>$product_guid), 'product_id, product_num');
			if ($type == 'add_num') {
				$product_num = $info['product_num'] + $num;
			}
			else {
				$product_num = $info['product_num'] > $num ? ($info['product_num'] - $num) : 0;	
			}	
			$db->pe_update('prodata', array('product_guid'=>$product_guid), array('product_num'=>$product_num));
			$product = $db->pe_select('prodata', array('product_id'=>$info['product_id']), 'sum(product_num) as `num`');
			$db->pe_update('product', array('product_id'=>$info['product_id']), array('product_num'=>$product['num']));
		break;
		case 'add_sellnum':
		case 'del_sellnum':
			$product_id = intval($id);
			$info = $db->pe_select('product', array('product_id'=>$product_id), 'product_id, product_sellnum');
			if ($type == 'add_sellnum') {
				$product_sellnum = $info['product_sellnum'] + $num;
			}
			else {
				$product_sellnum = $info['product_sellnum'] > $num ? ($info['product_sellnum'] - $num) : 0;	
			}	
			$db->pe_update('product', array('product_id'=>$info['product_id']), array('product_sellnum'=>$product_sellnum));	
		break;
		case 'clicknum':
			$product_id = intval($id);
			$db->pe_update('product', array('product_id'=>$product_id), "`product_clicknum` = `product_clicknum` + ".rand(3, 5)."");
		break;
		default:
			$product_id = intval($id);
			if (in_array($type, array('collectnum', 'asknum'))) {
				$num = $db->pe_num(substr($type, 0, -3), array('product_id'=>$product_id));
				$db->pe_update('product', array('product_id'=>$product_id), array("product_{$type}"=>$num));
			}
			else if($type == 'commentnum') {
				$num_hao = $db->pe_num('comment', array('product_id'=>$product_id, 'comment_star'=>array(4,5)));
				$num_zhong = $db->pe_num('comment', array('product_id'=>$product_id, 'comment_star'=>3));
				$num_cha = $db->pe_num('comment', array('product_id'=>$product_id, 'comment_star'=>array(1,2)));
				$comment = $db->pe_select('comment', array('product_id'=>$product_id), "sum(comment_star) as comment_star");
				$sql_comment['product_commentnum'] = $num_hao + $num_zhong + $num_cha;
				$sql_comment['product_commentrate'] = "{$num_hao},{$num_zhong},{$num_cha}";
				$sql_comment['product_commentstar'] = $comment['comment_star'];
				$db->pe_update('product', array('product_id'=>$product_id), $sql_comment);
			}
		break;
	}
}

//商品价格
function product_money($money) {
	global $user, $cache_userlevel;
	if ($user['user_id']) {
		$zhe = $cache_userlevel[$user['userlevel_id']]['userlevel_zhe'];
		$money = $zhe ? pe_num($money * $zhe, 'round', 1) : $money;	
	}
	return $money;
}

//计算商品活动价
function huodong_money($huodong_money, $money, $type, $value) {
	if ($huodong_money) return $huodong_money;
	if ($type == 'zhe') {
		$money = round($money * $value, 1);
	} 
	else {
		$money = round($money - $value, 1);	
	}
	return $money;
}

//活动标签
function huodong_tag($text) {
	return 'huodong_tag'.intval(strlen($text)/3);
}

//活动价格回调
function huodong_money_callback() {
	global $db;
	$sql = "update `".dbpre."huodongdata` a left join `".dbpre."product` b on a.`product_id` = b.`product_id`
		set a.`product_name` = b.`product_name`, a.`product_logo` = b.`product_logo`, a.`product_smoney` = b.`product_smoney`, a.`product_money` = b.`product_smoney` * a.`product_zhe`
		where a.huodong_type = 'zhekou' and b.`product_id` is not null";
	$db->sql_update($sql);
	$sql = "update `".dbpre."huodongdata` a left join `".dbpre."product` b on a.`product_id` = b.`product_id`
		set a.`product_name` = b.`product_name`, a.`product_logo` = b.`product_logo`, a.`product_smoney` = b.`product_smoney`
		where a.huodong_type = 'pintuan' and b.`product_id` is not null";
	$db->sql_update($sql);
}

//取消商品信息
function product_del_hdinfo($product_idarr) {
	global $db;
	$db->pe_update('product', array('product_id'=>$product_idarr), "product_money = product_smoney, huodong_id = '', huodong_type = '', huodong_tag = '', huodong_stime = 0, huodong_etime = 0");
	$db->pe_update('prodata', array('product_id'=>$product_idarr), "product_money = product_smoney");
}
?>