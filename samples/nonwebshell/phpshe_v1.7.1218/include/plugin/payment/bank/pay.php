<?php
include('../../../../common.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>转账汇款</title>
<script type="text/javascript" src="{$pe['host_root']}include/js/jquery.js"></script>
<script type="text/javascript" src="{$pe['host_root']}include/js/global.js"></script>
<script type="text/javascript" src="{$pe['host_root']}include/plugin/layer/layer.js"></script>
</head>
<body>
<div class="tixing">汇款成功后，请提供订单号给在线客服处理！</div>
<?php
$cache_payment = cache::get('payment');
$payment = $cache_payment['bank']['payment_config'];
echo '<div class="bank_text">'.nl2br($payment['bank_text']).'</div>';
?>
<!--<div class="center">
<form method="post">
	<input type="hidden" name="pe_token" />
	<input type="hidden" name="pesubmit" />	
	<input type="submit" value="确认已汇款"  class="tjbtn" />
</form>
</div>-->
<style type="text/css">
.tixing{background:#FFFBE5; color:#ff4400; padding:8px 10px; border:1px solid #FBEED5; font-family:"宋体"; margin-top:10px; font-size:12px;}
.bank_text{line-height:35px; padding:20px; font-size:14px; font-family:'微软雅黑'; color:#666; text-align:center}
.tjbtn{width:120px; height:35px; line-height:35px; background:#ff5500; color:#fff; text-align:center; border:0; border-radius:2px; margin:0 auto; font-family:'微软雅黑'}
.center{margin:0 auto; text-align:center}
</style>
</body>
</html>