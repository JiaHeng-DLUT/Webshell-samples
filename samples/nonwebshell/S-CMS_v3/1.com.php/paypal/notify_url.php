<?php 
require '../conn/conn2.php';
require '../conn/function.php';

$info=getbody("https://www.paypal.com/cgi-bin/webscr",$_POST."&cmd=_notify-validate");
if($info=="VERIFIED"){
$money=$_POST["payment_gross"];
$M_id=$_POST["option_selection1"];
$trade_no=$_POST["txn_id"];
$receiver_email=$_POST["receiver_email"];

if($receiver_email==$C_paypal){
mysqli_query($conn,"update SL_member set M_money=M_money+".$money*$C_rate." where M_id=".$M_id);
mysqli_query($conn,"insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(".$M_id.",'用户充值',".$money*$C_rate.",'".date('Y-m-d H:i:s')."','".$trade_no."',0)");
sendmail("有用户通过PAYPAL充值","用户ID：".$M_id."<br>充值金额：".$money*$C_rate."元<br>交易单号：".$trade_no,$C_email);
}
}

?>