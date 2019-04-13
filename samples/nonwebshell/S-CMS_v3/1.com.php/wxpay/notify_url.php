<?php 
require '../conn/conn2.php';
require '../conn/function.php';


$APPID = $C_wx_appid;
$MCHID = $C_wx_mchid;
$KEY = $C_wx_key;
$APPSECRET = $C_wx_appsecret;
	

if($MCHID=="" || $KEY==""){
	die();
}

$NOTIFY_URL = "http://".$C_domain.$C_dir."wxpay/notify_url.php";

$postArr = file_get_contents("php://input");

libxml_disable_entity_loader(true);

$postObj = simplexml_load_string( $postArr );

$appid=$postObj->appid;
$attach=$postObj->attach;
$bank_type=$postObj->bank_type;
$cash_fee=$postObj->cash_fee;
$device_info=$postObj->device_info;
$fee_type=$postObj->fee_type;
$is_subscribe=$postObj->is_subscribe;
$mch_id=$postObj->mch_id;
$nonce_str=$postObj->nonce_str;
$openid=$postObj->openid;
$out_trade_no=$postObj->out_trade_no;
$result_code=$postObj->result_code;
$return_code=$postObj->return_code;
$time_end=$postObj->time_end;
$total_fee=$postObj->total_fee;
$trade_type=$postObj->trade_type;
$transaction_id=$postObj->transaction_id;
$sign=$postObj->sign;
$O_ids=$attach;

if (strtolower(MD5("appid=".$appid."&attach=".$attach."&bank_type=".$bank_type."&cash_fee=".$cash_fee."&fee_type=".$fee_type."&is_subscribe=".$is_subscribe."&mch_id=".$mch_id."&nonce_str=".$nonce_str."&openid=".$openid."&out_trade_no=".$out_trade_no."&result_code=".$result_code."&return_code=".$return_code."&time_end=".$time_end."&total_fee=".$total_fee."&trade_type=".$trade_type."&transaction_id=".$transaction_id."&key=".$KEY))==strtolower($sign)){

if($result_code=="SUCCESS"){
if(strpos($O_ids,"|")>0){
$M_id=intval(splitx($O_ids,"|",0));
$sql="Select * from SL_list where L_no='".t($transaction_id)."'";

		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		if (mysqli_num_rows($result) <= 0) {
		mysqli_query($conn,"update SL_member set M_money=M_money+".($total_fee/100)." where M_id=".intval($M_id));
		mysqli_query($conn,"insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(".$M_id.",'用户充值',".($total_fee/100).",'".date('Y-m-d H:i:s')."','".$transaction_id."',0)");
		sendmail("有用户通过微信充值","用户ID：".$M_id."<br>充值金额：".($total_fee/100)."元<br>交易单号：".$transaction_id,$C_email);
		}

}else{

$sql="select * from SL_orders where O_id=".intval(splitx($O_ids,",",0));

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) > 0) {
	$O_state=$row["O_state"];
	$O_price=$row["O_price"];
	$O_member=$row["O_member"];
}

if($O_state==0 && $O_price!=""){
$O_id=explode(",",$O_ids);
for ($i=0 ;$i< count($O_id);$i++){
mysqli_query($conn,"update SL_orders set O_state=1,O_tradeno='".$transaction_id."（微信付款）' where O_id=".intval($O_id[$i]));
}
mysqli_query($conn,"update SL_member set M_fen=M_fen+".$total_fee/100*$C_1yuan." where M_id=".intval($O_member));
mysqli_query($conn,"insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(".$O_member.",'用户充值',".($total_fee/100).",'".date('Y-m-d H:i:s')."','".$transaction_id."',0)");
mysqli_query($conn,"insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(".$O_member.",'购买产品',-".($total_fee/100).",'".date('Y-m-d H:i:s')."','".$transaction_id."',0)");
if($C_1yuan>0){
mysqli_query($conn,"insert into SL_list(L_title,L_mid,L_change,L_time,L_type,L_no) values('购买商品',".$O_member.",".$total_fee/100*$C_1yuan.",'".date('Y-m-d H:i:s')."',1,'".$transaction_id."')");
}
if($C_1yuan2>0){
mysqli_query($conn,"insert into SL_list(L_title,L_mid,L_change,L_time,L_type,L_no) values('好友购买商品',".getrs("select * from SL_member where M_id=".intval($M_id),"M_from").",".$total_fee/100*$C_1yuan2.",'".date('Y-m-d H:i:s')."',1,'".$transaction_id."')");
}
sendmail("有订单已付款，请尽快发货","<h2>您的网站“".$C_webtitle2."”有订单已付款，请尽快发货</h2><hr>商品编号：".$O_ids."<br>价格：".round($total_fee/100,2)."元<br>交易号：".$transaction_id."（微信付款）<br>状态：已付款（等待发货）<hr>请进入“网站后台” - “商城管理” - “订单管理”进行发货操作！",$C_email);
}
}
}
}else{
echo 0;
}
?>