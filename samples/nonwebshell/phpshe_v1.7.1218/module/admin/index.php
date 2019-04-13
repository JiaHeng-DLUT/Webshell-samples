<?php
/**
 * @copyright   2008-2014 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'index';
switch ($act) {
	//####################// phpinfo信息 //####################//
	case 'phpinfo':
		phpinfo();
	break;
	//####################// 后台首页 //####################//
	default:
		$time1 = strtotime(date('Y-m-d'));
		$time2 = $time1 - 86400;
		
		//待处理项
		$tongji['order_wpay'] = $db->pe_num('order', array('order_state'=>'wpay'));
		$tongji['order_wsend'] = $db->pe_num('order', array('order_state'=>'wsend'));
		//$tongji['order_wget'] = $db->pe_num('order', array('order_state'=>'wget'));
		$tongji['refund_wcheck'] = $db->pe_num('refund', array('refund_state'=>'wcheck'));
		$tongji['cashout_js'] = $db->pe_num('cashout', array('cashout_state'=>0));
		
		//数据统计
		$tongji['product_num'] = $db->pe_num('product');
		$tongji['category_num'] = $db->pe_num('category');
		$tongji['brand_num'] = $db->pe_num('brand');
		$tongji['comment_num'] = $db->pe_num('comment');	
		$tongji['order_num'] = $db->pe_num('order'); 
		$tongji['refund_num'] = $db->pe_num('refund'); 

		$tongji['iplog_num'] = $db->pe_num('iplog');
		$tongji['user_num'] = $db->pe_num('user'); 
		$tongji_arr = $db->pe_select('user', '', 'sum(user_money) as `money`, sum(user_point) as `point`'); 
		$tongji['user_money'] = $tongji_arr['money'];
		$tongji['user_point'] = $tongji_arr['point'];
		$tongji['cashout_num'] = $db->pe_num('cashout');
		$tongji['sign_num'] = $db->pe_num('signlog');				

		//流量统计
		$tongji['iplog_today'] = $db->pe_num('iplog', " and `iplog_atime` >= '{$time1}'");
		$tongji['iplog_lastday'] = $db->pe_num('iplog', " and `iplog_atime` >= '{$time2}' and `iplog_atime` < '{$time1}'");
		$tongji['user_today'] = $db->pe_num('user', " and `user_atime` >= '{$time1}'");
		$tongji['user_lastday'] = $db->pe_num('user', " and `user_atime` >= '{$time2}' and `user_atime` < '{$time1}'");
		$tongji['sign_today'] = $db->pe_num('signlog', " and `signlog_atime` >= '{$time1}'");
		$tongji['sign_lastday'] = $db->pe_num('signlog', " and `signlog_atime` >= '{$time2}' and `signlog_atime` < '{$time1}'");

		//流量统计报表
		$date1 = date('Y-m-d', strtotime("-10 day"));
		$date2 = date('Y-m-d');
		$time1 = strtotime($date1);
		$time2 = strtotime($date2);
		$iplog_list = $db->index('iplog_adate')->pe_selectall('iplog', " and `iplog_adate` >= '{$date1}' and `iplog_adate` <= '{$date2}' group by `iplog_adate`", "iplog_adate, count(1) as `num`");
		//生成折线图数据
		for ($i=$time1; $i<=$time2; $i=$i+86400) {
			$chart_x[] = pe_date($i, 'm-d');
			$chart_y[] = intval($iplog_list[pe_date($i, 'Y-m-d')]['num']);
		}
		
	
		//系统环境信息
		$php_os = PHP_OS;
		$php_version = PHP_VERSION;
		$php_mysql = $db->version();
		if (stripos($_SERVER["SERVER_SOFTWARE"], 'iis') !== false) {
			$iis_arr = explode('/', $_SERVER["SERVER_SOFTWARE"]);
			$php_apache = "IIS/{$iis_arr[1]}";
		}
		else {
			$apache_arr = explode(' ', $_SERVER["SERVER_SOFTWARE"]);
			$php_apache = $apache_arr[0];	
		}
		$seo = pe_seo($menutitle='网站概况', '', '', 'admin');
		include(pe_tpl('index.html'));
	break;
}
?>