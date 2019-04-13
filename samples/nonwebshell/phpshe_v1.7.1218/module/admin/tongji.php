<?php
/**
 * @copyright   2008-2014 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'tongji';
switch ($act) {
	//####################// 订单统计 //####################//
	case 'order':
		$time1 = $_g_date1 ? strtotime($_g_date1) : strtotime('-1 month');
		$time2 = $_g_date2 ? strtotime("{$_g_date2} 23:59:59") : strtotime(date('Y-m-d')." 23:59:59");
		$_g_date1 = date('Y-m-d', $time1);
		$_g_date2 = date('Y-m-d', $time2);
		$new_list = $db->index('order_date')->pe_selectall('order', " and `order_atime` >= '{$time1}' and `order_atime` <= '{$time2}' group by `order_date`", "count(1) as `num`, sum(`order_money`) as `money`, from_unixtime(order_atime, '%Y-%m-%d') as `order_date`");
		$pay_list = $db->index('order_date')->pe_selectall('order', " and `order_ptime` >= '{$time1}' and `order_ptime` <= '{$time2}' group by `order_date`", "count(1) as `num`, sum(`order_money`) as `money`, from_unixtime(order_ptime, '%Y-%m-%d') as `order_date`");
		$send_list = $db->index('order_date')->pe_selectall('order', " and `order_stime` >= '{$time1}' and `order_stime` <= '{$time2}' group by `order_date`", "count(1) as `num`, sum(`order_money`) as `money`, from_unixtime(order_stime, '%Y-%m-%d') as `order_date`");
		$success_list = $db->index('order_date')->pe_selectall('order', " and `order_ftime` >= '{$time1}' and `order_ftime` <= '{$time2}' and `order_state` = 'success' group by `order_date`", "count(1) as `num`, sum(`order_money`) as `money`, from_unixtime(order_ftime, '%Y-%m-%d') as `order_date`");
		$close_list = $db->index('order_date')->pe_selectall('order', " and `order_ftime` >= '{$time1}' and `order_ftime` <= '{$time2}' and `order_state` = 'close' group by `order_date`", "count(1) as `num`, sum(`order_money`) as `money`, from_unixtime(order_ftime, '%Y-%m-%d') as `order_date`");		

		for ($i=$time1; $i<=$time2; $i=$i+86400) {
			$all['num_new'] += $order_list[date('Y-m-d', $i)]['num_new'] = intval($new_list[date('Y-m-d', $i)]['num']);
			$all['num_pay'] += $order_list[date('Y-m-d', $i)]['num_pay'] = intval($pay_list[date('Y-m-d', $i)]['num']);
			$all['num_send'] += $order_list[date('Y-m-d', $i)]['num_send'] = intval($send_list[date('Y-m-d', $i)]['num']);
			$all['num_success'] += $order_list[date('Y-m-d', $i)]['num_success'] = intval($success_list[date('Y-m-d', $i)]['num']);
			$all['num_close'] += $order_list[date('Y-m-d', $i)]['num_close'] = intval($close_list[date('Y-m-d', $i)]['num']);

			$all['money_new'] += $order_list[date('Y-m-d', $i)]['money_new'] = round($new_list[date('Y-m-d', $i)]['money'], 1);
			$all['money_pay'] += $order_list[date('Y-m-d', $i)]['money_pay'] = round($pay_list[date('Y-m-d', $i)]['money'], 1);
			$all['money_send'] += $order_list[date('Y-m-d', $i)]['money_send'] = round($send_list[date('Y-m-d', $i)]['money'], 1);
			$all['money_success'] += $order_list[date('Y-m-d', $i)]['money_success'] = round($success_list[date('Y-m-d', $i)]['money'], 1);
			$all['money_close'] += $order_list[date('Y-m-d', $i)]['money_close'] = round($close_list[date('Y-m-d', $i)]['money'], 1);
		}
		krsort($order_list);
		$seo = pe_seo($menutitle='订单统计', '', '', 'admin');
		include(pe_tpl('tongji_order.html'));
	break;
	//####################// 热销排行 //####################//
	case 'sell':
		$time1 = $_g_date1 ? strtotime($_g_date1) : strtotime('-1 month');
		$time2 = $_g_date2 ? strtotime("{$_g_date2} 23:59:59") : strtotime(date('Y-m-d')." 23:59:59");
		$_g_date1 = date('Y-m-d', $time1);
		$_g_date2 = date('Y-m-d', $time2);		
		$sql = "select a.*, sum(a.`product_num`) as `sellnum`, sum(a.`product_allmoney`) as `sellmoney` from `".dbpre."orderdata` a left join `".dbpre."order` b on a.`order_id` = b.`order_id` where b.`order_state` = 'success' and b.`order_atime` >= '{$time1}' and b.`order_atime` <= '{$time2}' group by a.`product_id` order by sum(a.`product_num`) desc";
		$info_list = $db->sql_selectall($sql);
		$seo = pe_seo($menutitle='热销排行', '', '', 'admin');
		include(pe_tpl('tongji_sell.html'));
	break;
	//####################// 消费排行 //####################//
	case 'user':
		$time1 = $_g_date1 ? strtotime($_g_date1) : strtotime('-1 month');
		$time2 = $_g_date2 ? strtotime("{$_g_date2} 23:59:59") : strtotime(date('Y-m-d')." 23:59:59");
		$_g_date1 = date('Y-m-d', $time1);
		$_g_date2 = date('Y-m-d', $time2);		
		$sql = "select a.`user_name`, count(1) as `num`, sum(a.`order_money`) as `money` from `".dbpre."order` a left join `".dbpre."user` b on a.`user_id` = b.`user_id` where a.`order_state` = 'success' and a.`order_atime` >= '{$time1}' and a.`order_atime` <= '{$time2}' and a.`user_id` > 0 group by a.`user_id` order by sum(a.`order_money`) desc";
		$info_list = $db->sql_selectall($sql);
		$seo = pe_seo($menutitle='消费排行', '', '', 'admin');
		include(pe_tpl('tongji_user.html'));
	break;
	//####################// 短信/邮件记录 //####################//
	case 'notice':
	case 'notice_del':
		if ($act == 'notice_del') {
			pe_token_match();
			if ($db->pe_delete('noticelog', array('noticelog_id'=>$_g_id))) {
				pe_success('删除成功!');
			}
			else {
				pe_error('删除失败...');
			}
		}
		$info_list = $db->pe_selectall('noticelog', array('order by'=>'noticelog_id desc'), '*', array(50, $_g_page));
		//$tongji['all'] = $db->pe_num('noticelog');
		$seo = pe_seo($menutitle='短信/邮件记录', '', '', 'admin');
		include(pe_tpl('tongji_notice.html'));
	break;
	//####################// 访客统计 //####################//
	default:
		$info_list = $db->pe_selectall('iplog', array('order by'=>'`iplog_atime` desc'), '*', array(50, $_g_page));
		$seo = pe_seo($menutitle='访客统计', '', '', 'admin');
		include(pe_tpl('tongji_iplog.html'));
	break;
}
?>