<?php
switch ($act) {
	//####################// 商品收藏 //####################//
	case 'collect':
		$product_id = intval($_g_id);
		if (!pe_login('user')) pe_jsonshow(array('result'=>false, 'show'=>'请先登录'));
		$info = $db->pe_select('product', array('product_id'=>$product_id), 'product_id, product_collectnum');
		if (!$info['product_id']) pe_jsonshow(array('result'=>false, 'show'=>'无效商品'));
		$sql_where['product_id'] = $product_id;	
		$sql_where['user_id'] = $_s_user_id;
		if ($db->pe_num('collect', pe_dbhold($sql_where))) {
			$db->pe_delete('collect', pe_dbhold($sql_where));
			product_jsnum($product_id, 'collectnum');
			pe_jsonshow(array('result'=>true, 'show'=>'已取消', 'type'=>'del', 'num'=>$info['product_collectnum']-1));
		}
		else {
			$sql_where['collect_atime'] = time();
			$db->pe_insert('collect', pe_dbhold($sql_where));
			product_jsnum($product_id, 'collectnum');
			pe_jsonshow(array('result'=>true, 'show'=>'收藏成功', 'type'=>'add', 'num'=>$info['product_collectnum']+1));
		}
	break;
	//####################// 商品列表 //####################//
	case 'list':
		$category_id = intval($id);
		$category_zk_id = is_array($cache_category_arr[$category_id]) ? $category_id : intval($cache_category[$category_id]['category_pid']);
		$info = $db->pe_select('category', array('category_id'=>$category_id));
		//搜索
		$sql_where = " and `product_state` = 1";
		$category_id && $sql_where .= " and ".pe_sqlin('category_id', category_cidarr($category_id));
		$_g_brand && $sql_where .= " and `brand_id` = ".intval($_g_brand);
		$_g_keyword && $sql_where .= " and `product_name` like '%".pe_dbhold($_g_keyword)."%'";
		$orderby_arr = array('sellnum_desc', 'money_desc', 'money_asc', 'commentnum_desc', 'clicknum_desc');
		if (in_array($_g_orderby, $orderby_arr)) {
			$orderby = explode('_', $_g_orderby);
			$sql_where .= " order by `product_{$orderby[0]}` {$orderby[1]}";
		}
		else {
			$sql_where .= " order by `product_order` asc, `product_id` desc";
		}
		$info_list = $db->pe_selectall('product', $sql_where, '*', array(40, $_g_page));
		//品牌列表
		$brand_list = category_brand($category_id);
		//热销排行
		$product_hotlist = product_hotlist();
		//当前路径
		if (isset($_g_keyword)) {
			$nowpath = category_path(0, '搜索&nbsp;&nbsp;“'.htmlspecialchars($_g_keyword)."”");
			$seo = pe_seo('站内搜索');
		}
		else {
			$nowpath = $category_id ? category_path($category_id) : category_path($category_id, '全部商品');
			$seo = pe_seo($info['category_title']?$info['category_title']:$info['category_name'], $info['category_keys'], pe_text($info['category_desc']));
		}
		include(pe_tpl('product_list.html'));
	break;
	//####################// 商品内容 //####################//
	default:
		$product_id = intval($act);
		$info = $db->pe_select('product', array('product_id'=>$product_id));
		if (!$info['product_id']) pe_404();
		$info['product_money'] = product_money($info['product_money']);
		$info['product_smoney'] = product_money($info['product_smoney']);
		$category_id = $info['category_id'];
		$category_pid = $cache_category[$category_id]['category_pid'];
		$comment_ratearr = explode(',', $info['product_commentrate']);
		if ($info['product_commentnum']) {
			$comment_star = pe_num($info['product_commentstar']/$info['product_commentnum'], 'round', 1, true);
			$comment_rate_hao = intval($comment_ratearr[0]/$info['product_commentnum']*100);
			$comment_rate_zhong = intval($comment_ratearr[1]/$info['product_commentnum']*100);
			$comment_rate_cha = intval($comment_ratearr[2]/$info['product_commentnum']*100);
		}
		else {
			$comment_star = '5.0';
			$comment_rate_hao = '100';
			$comment_rate_zhong = '0';
			$comment_rate_cha = '0';
		}
		$comment_point = ($cache_setting['point_state'] && $cache_setting['point_comment']) ? "(+{$cache_setting['point_comment']}积分)":'';
		//优惠券列表
		$quan_list = $db->pe_selectall('quan', "and `quan_type` = 'online' and `quan_edate` >= '".date('Y-m-d')."' and (`product_id` = '' or find_in_set({$product_id}, `product_id`)) order by `quan_money` asc");
		//商品规格
		if ($info['product_rule']) {
			$rule_list = unserialize($info['product_rule']);
			$product_guid = '';
		}
		else {
			$rule_list = array();
			$prodata = $db->pe_select('prodata', array('product_id'=>$product_id), 'product_guid');
			$product_guid = $prodata['product_guid'];
		}
		$prodata_list = $db->pe_selectall('prodata', array('product_id'=>$product_id, 'order by'=>'product_order asc'), 'product_guid, product_ruleid, product_money, product_mmoney, product_num');
		foreach ($prodata_list as $k=>$v) {
			$prodata_list[$k]['product_money'] = product_money($v['product_money']);
			//if ($info['product_money'] != $info['product_smoney']) $prorule_list[$k]['product_money'] = $info['product_money'];
			if (!$v['product_num']) unset($prodata_list[$k]);
		}
		$prodata_list = json_encode($prodata_list);
		//更新点击
		product_jsnum($product_id, 'clicknum');		
		//商品相册
		$album_list = explode(',', $info['product_album']);
		//热销排行
		$product_hotlist = product_hotlist();
		//新品推荐
		$product_newlist = product_newlist(2);
		//当前路径
		$nowpath = category_path($info['category_id'], $info['product_name']);
		$info['product_desc'] = $info['product_desc'] ? $info['product_desc'] : pe_cut(pe_text($info['product_text']), 200);
		$seo = pe_seo($info['product_name'], $info['product_keys'], $info['product_desc']);
		//检测拼团
		if ($info['huodong_type'] == 'pintuan') {
			$huodong = $db->pe_select('huodongdata', array('huodong_id'=>$info['huodong_id']), 'product_ptnum');
			$info['product_ptnum'] = $huodong['product_ptnum'];
			include(pe_tpl('product_pintuan.html'));
		}
		else {
			include(pe_tpl('product_view.html'));
		}
	break;
}
?>