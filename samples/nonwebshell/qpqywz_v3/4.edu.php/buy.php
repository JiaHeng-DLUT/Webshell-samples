<?php
require 'conn/conn.php';
require 'conn/function.php';


$genkey=gen_key(20);
$action=urlencode($_GET["action"]);
$no=urlencode($_POST["no"]);
$P_id=intval($_REQUEST["P_id"]);

if($action=="buy"){

$sql="select * from SL_product where P_id=".intval($P_id);
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$P_title=lang($row["P_title"]);
$P_price=$row["P_price"];
$P_rest=$row["P_rest"];
$P_shuxing=$row["P_shuxing"];
$P_name=$row["P_name"];
$P_email=$row["P_email"];
$P_address=$row["P_address"];
$P_mobile=$row["P_mobile"];
$P_postcode=$row["P_postcode"];
$P_qq=$row["P_qq"];
$P_remark=$row["P_remark"];
$P_sence=$row["P_sence"];
$P_sell=$row["P_sell"];
if($P_name==1 || $P_email==1 || $P_address==1 || $P_mobile==1 || $P_postcode==1 || $P_qq==1 || $P_remark==1){
$P_contact=1;
}else{
$P_contact=0;
}
}
$sp=0;
foreach ($_POST as $x=>$value) {
if(splitx($x,"_",0)=="scvvvvv"){
$sc=$sc.splitx(splitx(splitx($P_shuxing,"@",splitx($x,"_",1)),"_",1),"|",$_POST[$x])."|";
$sp=$sp+splitx(splitx(splitx($P_shuxing,"@",splitx($x,"_",1)),"_",2),"|",$_POST[$x]);
}
}
$sc=substr($sc,0,strlen($sc)-1);
if($sc==""){
$sc="标配";
}
;
$O_shuxing=explode("|",$sc);
for ($j=0 ;$j< count($O_shuxing);$j++){
$shuxing=$shuxing.lang($O_shuxing[$j])." ";
}
$price=$P_price+$sp;
$money=round($no*$price,2);
$sign=strtolower(md5($C_7pkey.$money));
if($P_sell==""){
$P_sell="a";
}
echo "//7-pay.cn/code/code.asp?key=".$C_7PID."&attach=".$P_id."|".$shuxing."&title=".$P_title."&content=".$shuxing."&money=".$money."&input=false&contact=".$P_contact."&name=".$P_name."&address=".$P_address."&mobile=".$P_mobile."&remark=".$P_remark."&postcode=".$P_postcode."&qq=".$P_qq."&email=".$P_email."&num=".$no."&numon=1&sign=".$sign."&sence=".$P_sence."&callback=".urlencode("http://".$_SERVER["HTTP_HOST"].$C_dir."bank/callback3.php")."&list=0&error=请到后台“基本设置”-“收款设置”检查7支付PID和Pkey是否填写正确！&goods=".getbody("http://7-pay.cn/encode/index.asp","str=".$P_sell.".pkey=".$C_7PKEY);
die();
}


if($action=="addcart"){
if($_SESSION["M_login"]==""){
echo "error1|请先登录会员帐号！";
die();
}

$sql="select * from SL_product where P_id=".$P_id;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$P_title=$row["P_title"];
$P_rest=$row["P_rest"];
$P_price=$row["P_price"];
$P_shuxing=$row["P_shuxing"];
}
if(floor($no)<1 || floor($no)>floor($P_rest)){
box(lang("库存不足！/l/Lack of stock!"),"back","error");
}
$sp=0;
foreach ($_POST as $x=>$value) {
if(splitx($x,"_",0)=="scvvvvv"){
$sc=$sc.splitx(splitx(splitx($P_shuxing,"@",splitx($x,"_",1)),"_",1),"|",$_POST[$x])."|";
$sp=$sp+splitx(splitx(splitx($P_shuxing,"@",splitx($x,"_",1)),"_",2),"|",$_POST[$x]);
}
}
$sc=substr($sc,0,strlen($sc)-1);
if($sc==""){
$sc="标配";
}
$price=$P_price+$sp;

$M_lv=getrs("select * from SL_member where M_id=".$_SESSION["M_id"],"M_lv");
$L_discount=getrs("select * from SL_lv where L_id=".$M_lv,"L_discount");

mysqli_query($conn,"Insert into SL_orders(O_member,O_price,O_num,O_shuxing,O_state,O_pid,O_time,O_no) values(".$_SESSION["M_id"].",".round($price*$L_discount*0.01,2).",".$no.",'".$sc."',0,".$P_id.",'".date('Y-m-d H:i:s')."','".date("YmdHis").gen_key(5)."')");

sendmail("您的网站有新的订单提交","<h2>您的网站“".lang($C_webtitle)."”有新的订单提交</h2><hr>商品名称：".lang($P_title)."<br>数量：".$no."<br>属性：".$sc."<br>价格：".round($price,2)."元<hr>请进入“网站后台” - “商城管理” - “订单管理”查看详情！",$C_email);
echo "success|加入购物成功！";
die();
}
if($action=="input"){
if($_SESSION["M_login"]==""){
$_SESSION["from"]=URLEncode("//".$_SERVER["HTTP_HOST"].$C_dir."index.php?type=productinfo&S_id=".$P_id);
box("请先登录会员!",$C_dir."member/member_login.php","error");
}
$sql="select * from SL_product where P_id=".$P_id;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$P_title=$row["P_title"];
$P_rest=$row["P_rest"];
$P_price=$row["P_price"];
$P_shuxing=$row["P_shuxing"];
}
if(floor($no)<1 || floor($no)>floor($P_rest)){
box(lang("库存不足！/l/Lack of stock!"),"back","error");
}
$sp=0;
foreach ($_POST as $x=>$value) {
if(splitx($x,"_",0)=="scvvvvv"){
$sc=$sc.splitx(splitx(splitx($P_shuxing,"@",splitx($x,"_",1)),"_",1),"|",$_POST[$x])."|";
$sp=$sp+splitx(splitx(splitx($P_shuxing,"@",splitx($x,"_",1)),"_",2),"|",$_POST[$x]);
}
}
$sc=substr($sc,0,strlen($sc)-1);
if($sc==""){
$sc="标配";
}
$price=$P_price+$sp;

$M_lv=getrs("select * from SL_member where M_id=".$_SESSION["M_id"],"M_lv");
$L_discount=getrs("select * from SL_lv where L_id=".$M_lv,"L_discount");

mysqli_query($conn,"Insert into SL_orders(O_member,O_price,O_num,O_shuxing,O_state,O_pid,O_time,O_no) values(".$_SESSION["M_id"].",".round($price*$L_discount*0.01,2).",".$no.",'".$sc."',0,".$P_id.",'".date('Y-m-d H:i:s')."','".date("YmdHis").gen_key(5)."')");
$sql="select * from SL_orders order by O_id desc limit 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$O_id=$row["O_id"];
}
sendmail("您的网站有新的订单提交","<h2>您的网站“".lang($C_webtitle)."”有新的订单提交</h2><hr>商品名称：".lang($P_title)."<br>数量：".$no."<br>属性：".$sc."<br>价格：".round($price,2)."元<hr>请进入“网站后台” - “商城管理” - “订单管理”查看详情！",$C_email);
box("订单提交成功！",$C_dir."member/member_pay.php?O_id=".$O_id,"success");
}

?>