<?php 
require '../conn/conn2.php';
require '../conn/function.php';

$info=getbody("https://www.paypal.com/cgi-bin/webscr",$_POST."&cmd=_notify-validate");
if($info=="VERIFIED"){
$money=$_POST["payment_gross"];
$total_fee=$_POST["payment_gross"];
$O_ids=$_POST["option_selection1"];
$trade_no=$_POST["txn_id"];
$subject=$_POST["item_name"];
$receiver_email=$_POST["receiver_email"];
$O_id=explode(",",$O_ids);
for ($j=0 ;$j< count($O_id);$j++){
$sql="select * from SL_orders,SL_product,SL_member,SL_lv where M_lv=L_id and O_pid=P_id and O_member=M_id and O_id=".$O_id[$j];
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$O_all=$row["O_price"]*$row["O_num"]*$row["L_discount"]*0.01;
}
$moneys=$moneys+$O_all;
}
if(round($moneys,2)==round($total_fee,2) && $receiver_email==$C_paypal){
$sql="select * from SL_orders where O_id=".splitx($O_ids,",",0);

		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		if (mysqli_num_rows($result) > 0) {
		$O_state=$row["O_state"];
		$O_price=$row["O_price"];
		$O_member=$row["O_member"];
		$M_id=$row["O_member"];
		}
		$sql="Select * from SL_list Where L_no='".t($trade_no)."'";
		
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		if (mysqli_num_rows($result) <= 0) {
	$O_id=explode(",",$O_ids);
	for ($i=0 ;$i< count($O_id);$i++){
	mysqli_query($conn,"update SL_orders set O_state=1,O_tradeno='".$trade_no."（PAYPAL付款）' where O_id=".$O_id[$i]);
	}
	mysqli_query($conn,"update SL_member set M_fen=M_fen+".$total_fee*$C_1yuan." where M_id=".$M_id);
	mysqli_query($conn,"insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(".$M_id.",'用户充值',".$total_fee*$C_rate.",'".date('Y-m-d H:i:s')."','".$trade_no."',0)");
	mysqli_query($conn,"insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(".$M_id.",'购买商品',-".$total_fee*$C_rate.",'".date('Y-m-d H:i:s')."','".$trade_no."',0)");
if($C_1yuan>0){
	mysqli_query($conn,"insert into SL_list(L_title,L_mid,L_change,L_time,L_type,L_no) values('购买商品',".$M_id.",".$total_fee*$C_1yuan*$C_rate.",'".date('Y-m-d H:i:s')."',1,'".$trade_no."')");
}
if($C_1yuan2>0){
	mysqli_query($conn,"insert into SL_list(L_title,L_mid,L_change,L_time,L_type,L_no) values('好友购买商品',".getrs("select * from SL_member where M_id=".$M_id,"M_from").",".$total_fee*$C_1yuan2*$C_rate.",'".date('Y-m-d H:i:s')."',1,'".$trade_no."')");
}
	sendmail("有订单已付款，请尽快发货","<h2>您的网站“".$C_webtitle2."”有订单已付款，请尽快发货</h2><hr>商品名称：".$subject."<br>价格：".$total_fee*$C_rate."元<br>交易号：".$trade_no."（PAYPAL付款）<br>状态：已付款（等待发货）<hr>请进入“网站后台” - “商城管理” - “订单管理”进行发货操作！",$C_email);
	}

}
}
?>