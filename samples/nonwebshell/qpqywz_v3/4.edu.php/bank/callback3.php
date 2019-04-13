<?php 
require '../conn/conn2.php';
require '../conn/function.php';

$PID = $C_7PID;
$PKEY = $C_7PKEY;

$json_string=file_get_contents("php://input");
$obj=json_decode($json_string);

$P_address = $obj->P_address;
$P_attach = $obj->P_attach;
$P_city = $obj->P_city;
$P_country = $obj->P_country;
$P_email = $obj->P_email;
$P_mobile = $obj->P_mobile;
$P_money = $obj->P_money;
$P_name = $obj->P_name;
$P_no = $obj->P_no;
$P_num = $obj->P_num;
$P_postcode = $obj->P_postcode;
$P_price = $obj->P_price;
$P_province = $obj->P_province;
$P_qq = $obj->P_qq;
$P_remarks = $obj->P_remarks;
$P_state = $obj->P_state;
$P_time = $obj->P_time;
$P_title = $obj->P_title;
$P_type = $obj->P_type;
$P_url = $obj->P_url;
$sign = $obj->sign;

if(strtolower(MD5("P_address=".$P_address."&P_attach=".$P_attach."&P_city=".$P_city."&P_country=".$P_country."&P_email=".$P_email."&P_mobile=".$P_mobile."&P_money=".$P_money."&P_name=".$P_name."&P_no=".$P_no."&P_num=".$P_num."&P_postcode=".$P_postcode."&P_price=".$P_price."&P_province=".$P_province."&P_qq=".$P_qq."&P_remarks=".$P_remarks."&P_state=".$P_state."&P_time=".$P_time."&P_title=".$P_title."&P_type=".$P_type."&P_url=".$P_url."&pkey=".$PKEY))==strtolower($sign)){ 
	//==============================================================================

$sql="Select * from SL_list Where L_no='".$P_no."'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) <= 0) {
mysqli_query($conn,"insert into SL_member(M_login,M_pwd,M_email,M_QQ,M_mobile,M_add,M_pic,M_name,M_code,M_regtime,M_lv) values('临时会员".$sign."','".$P_no."','".$P_email."','".$P_qq."','".$P_mobile."','".$P_address."','member.jpg','".$P_name."','".$P_postcode."','".date('Y-m-d H:i:s')."',1)");
$M_id=getrs("select * from SL_member where M_pwd where '".$P_no."' where M_id");
$P_id=splitx($P_attach,"|",0);
$sc=splitx($P_attach,"|",1);
if($P_state==2){ 
mysqli_query($conn,"Insert into SL_orders(O_member,O_price,O_num,O_shuxing,O_state,O_pid,O_time,O_tradeno) values(".$M_id.",".$P_money/$P_num.",".$P_num.",'".$sc."',3,".$P_id.",'".date('Y-m-d H:i:s')."','".$P_no."（7支付）')");
}
if($P_state==1){ 
mysqli_query($conn,"Insert into SL_orders(O_member,O_price,O_num,O_shuxing,O_state,O_pid,O_time,O_tradeno) values(".$M_id.",".$P_money/$P_num.",".$P_num.",'".$sc."',1,".$P_id.",'".date('Y-m-d H:i:s')."','".$P_no."（7支付）')");
}
	mysqli_query($conn,"insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(".$M_id.",'用户充值',".$P_money.",'".date('Y-m-d H:i:s')."','".$P_no."',0)");
	mysqli_query($conn,"insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(".$M_id.",'购买商品',-".$P_money.",'".date('Y-m-d H:i:s')."','".$P_no."',0)");
	sendmail("有订单已付款，请尽快发货","<h2>您的网站“".$C_webtitle2."”有订单已付款，请尽快发货</h2><hr>商品名称：".$P_title."<br>价格：".$P_money."元<br>交易号：".$P_no."（7支付）<br>状态：已付款（等待发货）<hr>请进入“网站后台” - “商城管理” - “订单管理”进行发货操作！",$C_email);
	}

	//==============================================================================
file_put_contents("log/".$P_no.".txt","success");
echo "success";
}else{
echo "fail";
}
?>