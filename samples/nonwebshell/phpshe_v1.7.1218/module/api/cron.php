<?php
/**
 * @copyright   2008-2014 简好网络 <http://www.phpshe.com>
 * @creatdate   2015-0320 koyshe <koyshe@gmail.com>
 */
session_write_close();
$lock = pe_lock('cron');
//if (!$lock) die('locking');
$nowtime = time();
//记录用户ip
if (!$db->pe_num('iplog', array('iplog_ip'=>pe_dbhold(pe_ip()), 'iplog_adate'=>date('Y-m-d')))) {
	$db->pe_insert('iplog', array('iplog_ip'=>pe_dbhold(pe_ip()), 'iplog_adate'=>date('Y-m-d'), 'iplog_atime'=>time()));
}


//删除10天以上购物车商品
$db->pe_delete('cart', "and `cart_atime` <= ".($nowtime-864000));

//24小时未付款订单关闭
pe_lead('hook/order.hook.php');
$info = $db->pe_select('order', " and `order_state` = 'wpay' and `order_atime` <= ".($nowtime-86400));
order_callback_close($info, '订单未付款，超时关闭');

//24小时未成团拼团订单退款关闭
$info = $db->pe_select('pintuan', " and `pintuan_state` = 'wtuan' and `pintuan_etime` <= {$nowtime}");
if ($info['pintuan_id']) {
	$db->pe_update('pintuan', array('pintuan_id'=>$info['pintuan_id']), array('pintuan_state'=>'close'));
	$info_list = $db->pe_selectall('order', array('order_type'=>'pintuan', 'pintuan_id'=>$info['pintuan_id']));
	foreach ($info_list as $v) {
		order_callback_close($v, '拼团失败，订单自动关闭退款');
	}
}
//退款单退款
pe_lead('hook/order.hook.php');
$info_list = $db->pe_selectall('refund', array('refund_state'=>'success', 'refund_pstate'=>0), '*', array(5));
foreach ($info_list as $v) {
	add_moneylog($v['user_id'], 'back', $v['refund_money'], "订单退款返还，单号【{$v['order_id']}】");
	$db->pe_update('refund', array('refund_id'=>$v['refund_id']), array('refund_pstate'=>1, 'refund_presult'=>'success'));
}

//更新活动中商品
$info_list = $db->index('product_id')->sql_selectall("select * from (select * from `".dbpre."huodongdata` where `huodong_stime` <= '{$nowtime}' and `huodong_etime` > '{$nowtime}' order by product_money asc) a group by product_id");
foreach ($info_list as $v) {
	$db->pe_update('product', array('product_id'=>$v['product_id']), "product_money = '{$v['product_money']}', huodong_id = '{$v['huodong_id']}', huodong_type = '{$v['huodong_type']}', huodong_tag = '{$v['huodong_tag']}', huodong_stime = '{$v['huodong_stime']}', huodong_etime = '{$v['huodong_etime']}'");	
	$db->pe_update('prodata', array('product_id'=>$v['product_id']), "product_money = '{$v['product_money']}'");	
}
//取消已过期/删除活动商品
$product_idarr = array_keys($info_list);
$info_list = $db->index('product_id')->sql_selectall("select `product_id` from `".dbpre."product` where `huodong_id` > 0 and `product_id` not in('".implode("','", $product_idarr)."')");
$product_idarr = array_keys($info_list);
$db->pe_update('product', array('product_id'=>$product_idarr), "product_money = product_smoney, huodong_id = '', huodong_type = '', huodong_tag = '', huodong_stime = 0, huodong_etime = 0");
$db->pe_update('prodata', array('product_id'=>$product_idarr), "product_money = product_smoney");

//检测微信模板消息
pe_lead('hook/wechat.hook.php');
$info_list = $db->index('noticelog_id')->pe_selectall('wechat_noticelog', array('noticelog_state'=>'new', 'order by'=>'noticelog_id asc'), '*', array(5));
$db->pe_update('wechat_noticelog', array('noticelog_id'=>array_keys($info_list)), array('noticelog_stime'=>time(), 'noticelog_state'=>'send'));
foreach ($info_list as $k=>$v) {
	wechat_notice($v);
}

//检测短信/邮件通知
pe_lead('hook/qunfa.hook.php');
//$db->query("lock tables `".dbpre."noticelog` write");
$info_list = $db->index('noticelog_id')->pe_selectall('noticelog', array('noticelog_state'=>'new', 'order by'=>'noticelog_id asc'), '*', array(5));
$db->pe_update('noticelog', array('noticelog_id'=>array_keys($info_list)), array('noticelog_stime'=>time(), 'noticelog_state'=>'send'));
$db->pe_update('noticelog', "and `noticelog_state` = 'send' and `noticelog_stime` <='".(time()-60)."'", array('noticelog_state'=>'new'));
//$db->query("unlock tables");
foreach ($info_list as $k=>$v) {
	if ($v['noticelog_type'] == 'sms') {
		qunfa_sms($v['noticelog_user'], $v['noticelog_text'], $v['noticelog_id']);		
	}
	else {
		qunfa_email($v['noticelog_user'], array('qunfa_name'=>$v['noticelog_name'], 'qunfa_text'=>$v['noticelog_text']), $v['noticelog_id']);		
	}
}
pe_lock_del($lock);
?>