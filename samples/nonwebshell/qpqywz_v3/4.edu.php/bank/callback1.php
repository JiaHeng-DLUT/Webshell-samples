<?php 
require '../conn/conn2.php';
require '../conn/function.php';

$PID = $C_7PID;
$PKEY = $C_7PKEY;

if($PID=="" || $PKEY==""){
	die();
}

$json_string=file_get_contents("php://input");
$obj=json_decode($json_string);

$title = $obj->title;
$money = $obj->money;
$no = $obj->no;
$tradeno = $obj->tradeno;
$paytype = $obj->paytype;
$remark = $obj->remark;
$time = $obj->time;
$sign = $obj->sign;

if(strtolower(md5("money=".$money."&no=".$no."&paytype=".$paytype."&remark=".$remark."&time=".$time."&title=".$title."&tradeno=".$tradeno."&key=".$PKEY))==strtolower($sign)){ 

$sql="select * from SL_list where L_no like '".t($no)."'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) <= 0) {
	mysqli_query($conn,"update SL_member set M_money=M_money+".t($money)." where M_id=".t($remark));
	mysqli_query($conn,"insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(".t($remark).",'用户充值',".t($money).",'".date('Y-m-d H:i:s')."','".t($no)."',0)");
	}
echo "success";
}else{
echo "fail";
}

?>