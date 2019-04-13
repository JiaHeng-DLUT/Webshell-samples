<?php
/**
 * @copyright   2008-2014 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'adminlevel';
$modact_list['商品中心'][] = array('name'=>'商品管理', 'modact'=>'product|prokey', 'menumark'=>'product');
$modact_list['商品中心'][] = array('name'=>'商品分类', 'modact'=>'category', 'menumark'=>'category');	
$modact_list['商品中心'][] = array('name'=>'品牌管理', 'modact'=>'brand', 'menumark'=>'brand');	
$modact_list['商品中心'][] = array('name'=>'规格管理', 'modact'=>'rule', 'menumark'=>'rule');	
$modact_list['商品中心'][] = array('name'=>'评价管理', 'modact'=>'comment', 'menumark'=>'comment');
$modact_list['交易中心'][] = array('name'=>'订单管理', 'modact'=>'order', 'menumark'=>'order');
$modact_list['交易中心'][] = array('name'=>'退款/退货', 'modact'=>'refund|refund_addr', 'menumark'=>'refund');
$modact_list['交易中心'][] = array('name'=>'资金明细', 'modact'=>'moneylog', 'menumark'=>'moneylog');		
$modact_list['交易中心'][] = array('name'=>'积分明细', 'modact'=>'pointlog', 'menumark'=>'pointlog');
$modact_list['交易中心'][] = array('name'=>'充值记录', 'modact'=>'order_pay', 'menumark'=>'order_pay');
$modact_list['交易中心'][] = array('name'=>'提现管理', 'modact'=>'cashout', 'menumark'=>'cashout');
$modact_list['营销中心'][] = array('name'=>'优惠券/码', 'modact'=>'quan', 'menumark'=>'quan');
$modact_list['营销中心'][] = array('name'=>'限时折扣', 'modact'=>'zhekou', 'menumark'=>'zhekou');
$modact_list['营销中心'][] = array('name'=>'拼团活动', 'modact'=>'pintuan', 'menumark'=>'pintuan');
$modact_list['营销中心'][] = array('name'=>'签到活动', 'modact'=>'sign', 'menumark'=>'sign');
$modact_list['用户中心'][] = array('name'=>'会员管理', 'modact'=>'user', 'menumark'=>'user');
$modact_list['用户中心'][] = array('name'=>'会员等级', 'modact'=>'userlevel', 'menumark'=>'userlevel');
$modact_list['用户中心'][] = array('name'=>'管理账号', 'modact'=>'admin', 'menumark'=>'admin');	
$modact_list['用户中心'][] = array('name'=>'管理权限', 'modact'=>'adminlevel', 'menumark'=>'adminlevel');	
$modact_list['文章中心'][] = array('name'=>'分类管理', 'modact'=>'class', 'menumark'=>'class');	
$modact_list['文章中心'][] = array('name'=>'文章管理', 'modact'=>'article', 'menumark'=>'article');
$modact_list['控制面板'][] = array('name'=>'网站设置', 'modact'=>'setting|notice|express', 'menumark'=>'setting');	
$modact_list['控制面板'][] = array('name'=>'微信设置', 'modact'=>'wechat|wechat_notice', 'menumark'=>'wechat');
$modact_list['控制面板'][] = array('name'=>'支付设置', 'modact'=>'payment', 'menumark'=>'payment');
$modact_list['控制面板'][] = array('name'=>'导航管理', 'modact'=>'menu', 'menumark'=>'menu');
$modact_list['控制面板'][] = array('name'=>'广告管理', 'modact'=>'ad', 'menumark'=>'ad');	
$modact_list['控制面板'][] = array('name'=>'友情链接', 'modact'=>'link', 'menumark'=>'link');
$modact_list['控制面板'][] = array('name'=>'模板管理', 'modact'=>'moban', 'menumark'=>'moban');	
$modact_list['控制面板'][] = array('name'=>'数据统计', 'modact'=>'tongji', 'menumark'=>'tongji');
$modact_list['控制面板'][] = array('name'=>'数据备份', 'modact'=>'db', 'menumark'=>'db');	
$modact_list['控制面板'][] = array('name'=>'缓存管理', 'modact'=>'cache', 'menumark'=>'cache');
switch ($act) {
	//####################// 管理添加 //####################//
	case 'add':
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if (is_array($_p_modact)) {
				foreach ($modact_list as $v) {
					foreach ($v as $vv) {
						if (in_array($vv['modact'], $_p_modact)) {
							$modact_arr[] = $vv['modact'];
							$menumark_arr[] = $vv['menumark'];
						} 
					}
				}
			}
			$_p_info['adminlevel_modact'] = is_array($modact_arr) ? serialize($modact_arr) : '';			
			$_p_info['adminlevel_menumark'] = is_array($menumark_arr) ? serialize($menumark_arr) : '';			
			if ($db->pe_insert('adminlevel', $_p_info)) {
				cache::write('adminlevel');
				pe_success('添加成功!', 'admin.php?mod=adminlevel');
			}
			else {
				pe_error('添加失败...');
			}
		}
		$info['adminlevel_modact'] = array();
		$seo = pe_seo($menutitle='添加权限', '', '', 'admin');
		include(pe_tpl('adminlevel_add.html'));
	break;
	//####################// 管理修改 //####################//
	case 'edit':
		$adminlevel_id = intval($_g_id);
		$_g_id == 1 && pe_error('总管理员不能修改...');
		if (isset($_p_pesubmit)) {
			pe_token_match();
			if (is_array($_p_modact)) {
				foreach ($modact_list as $v) {
					foreach ($v as $vv) {
						if (in_array($vv['modact'], $_p_modact)) {
							$modact_arr[] = $vv['modact'];
							$menumark_arr[] = $vv['menumark'];
						} 
					}
				}
			}
			$_p_info['adminlevel_modact'] = is_array($modact_arr) ? serialize($modact_arr) : '';			
			$_p_info['adminlevel_menumark'] = is_array($menumark_arr) ? serialize($menumark_arr) : '';
			if ($db->pe_update('adminlevel', array('adminlevel_id'=>$adminlevel_id), $_p_info)) {
				cache::write('adminlevel');
				pe_success('修改成功!', 'admin.php?mod=adminlevel');
			}
			else {
				pe_error('修改失败...');
			}
		}
		$info = $db->pe_select('adminlevel', array('adminlevel_id'=>$adminlevel_id));
		$info['adminlevel_modact'] = $info['adminlevel_modact'] ? unserialize($info['adminlevel_modact']) : array();		
		$seo = pe_seo($menutitle='修改权限', '', '', 'admin');
		include(pe_tpl('adminlevel_add.html'));
	break;
	//####################// 管理删除 //####################//
	case 'del':
		pe_token_match();
		$_g_id == 1 && pe_error('总管理员权限不能删除');
		if ($db->pe_delete('adminlevel', array('adminlevel_id'=>$_g_id))) {
			cache::write('adminlevel');
			pe_success('删除成功!');
		}
		else {
			pe_error('删除失败...');
		}
	break;
	//####################// 管理列表 //####################//
	default:
		$info_list = $db->pe_selectall('adminlevel', '', '*', array(50, $_g_page));
		$tongji['all'] = $db->pe_num('adminlevel');
		$seo = pe_seo($menutitle='管理权限', '', '', 'admin');
		include(pe_tpl('adminlevel_list.html'));
	break;
}
?>