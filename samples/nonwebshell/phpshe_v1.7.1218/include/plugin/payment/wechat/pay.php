<?php
include('../../../../common.php');
pe_lead('hook/order.hook.php');
pe_lead('hook/wechat.hook.php');

$order_id = pe_dbhold($_g_id);
$order = $db->pe_select(order_table($order_id), array('order_id'=>$order_id));
$info = wechat_webpay($order_id);

if (!$info['result']) pe_404($info['show']);
$html = <<<html
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
html;
if ($pe['mobile']) {
	$html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />';
}
$html .= <<<html
<title>微信扫码支付</title>
<script type="text/javascript" src="{$pe['host_root']}include/js/jquery.js"></script>
<script type="text/javascript" src="{$pe['host_root']}include/js/global.js"></script>
<script type="text/javascript" src="{$pe['host_root']}include/plugin/layer/layer.js"></script>
</head>
<body style="background:#2E3B41">
	<div class="sm_box">
		<div><img src="{$info['qrcode']}" /></div>
		<p>请用微信扫描二维码完成支付</p>
		<div class="smje">支付金额：<span>¥ {$order['order_money']}</span></div>
	</div>
	<style type="text/css">
	.sm_box{width:380px; margin:70px auto 0; background:#fff; border-radius:4px; text-align:center; height:480px; font-family:微软雅黑}
	.sm_box img{width:270px; height:270px; margin-top:50px}
	.sm_box p{font-size:22px; color:#666}
	.smje{font-size:18px; color:#666}
	.smje span{color:#ff6600; font-size:22px;}
	.layui-layer{width:160px; !important}
	</style>
	<script type="text/javascript">
	$(function(){
		setInterval(function(){
			$.getJSON("{$pe['host_root']}include/plugin/payment/wechat/order_result.php?id={$order_id}", function(json){
				if (json.result) {
					layer.msg(json.show, {icon: 1});
					setTimeout(function(){
						window.location.href = json.url;
					}, 2000)
				}
			})
		}, 5000);
	})
	</script>
</body>
</html>
html;
echo $html;
?>