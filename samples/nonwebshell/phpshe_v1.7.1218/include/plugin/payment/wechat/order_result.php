<?php
include('../../../../common.php');
pe_lead('hook/order.hook.php');
$order_id = pe_dbhold($_g_id);
$order = $db->pe_select(order_table($order_id), array('order_id'=>$order_id));
if ($order['order_pstate']) {
	$result = order_pay_goto($order_id, 0);
	pe_jsonshow(array('result'=>true, 'show'=>$result['show'], 'url'=>$result['url']));
}
else {
	pe_jsonshow(array('result'=>false));		
}
?>