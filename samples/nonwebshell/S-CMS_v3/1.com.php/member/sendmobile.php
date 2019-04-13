<?php 
require '../conn/conn2.php';
require '../conn/function.php';
require '../conn/mobile.php';

$action=urlencode($_REQUEST["action"]);
$mailto=urlencode($_REQUEST["to"]);
$code=urlencode($_REQUEST["code"]);
if($code!==$_COOKIE["CmsCode"]){
echo "error|图形验证码不正确！";
die();
}
if(strlen(URLDecode($mailto))!=11){
echo "error|手机号码格式不正确！";
die();
}
if($action=="pwd"){

$_SESSION["pwd_code"]=rand(10000, 99999);
if($C_userid=="" || $C_codeid=="" || $C_codekey==""){
echo "error|请到后台-基本设置-短信设置中配置短信接口";
die();
}else{
mysqli_query($conn,"update SL_member set M_pwdcode='".$_SESSION["pwd_code"]."' where M_mobile like '".URLDecode($mailto)."'");
sendmobile($_SESSION["pwd_code"],$mailto) ;
echo "success|发送成功！";
die();
}
}
if($action=="edit"){

$_SESSION["edit_code"]=rand(10000, 99999);
if($C_userid=="" || $C_codeid=="" || $C_codekey==""){
echo "error|请到后台-基本设置-短信设置中配置短信接口";
die();
}else{
$sql="Select * from SL_member Where M_mobile like '".URLDecode($mailto)."' and not M_id=".$_SESSION["M_id"];

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
echo "error|手机号码已被占用，请换其他号码!";
die();
}else{
mysqli_query($conn,"update SL_member set M_pwdcode='".$_SESSION["edit_code"]."' where M_id=".$_SESSION["M_id"]);
sendmobile("【".$C_smssign."】您的验证码为".$_SESSION["edit_code"]."；1分钟内有效,请尽快验证！",$mailto) ;
echo "success|发送成功！";
die();
}
}
}
;
if($action=="login"){

$_SESSION["login_code"]=rand(10000, 99999);
if($C_userid=="" || $C_codeid=="" || $C_codekey==""){
echo "error|请到后台-基本设置-短信设置中配置短信接口";
die();
}else{
$sql="Select * from SL_member Where M_mobile like '".URLDecode($mailto)."'";

    $result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        ;
sendmobile("【".$C_smssign."】您的验证码为".$_SESSION["login_code"]."；1分钟内有效,请尽快验证！",$mailto) ;
mysqli_query($conn,"update SL_member set M_pwdcode='".$_SESSION["login_code"]."' where M_mobile like '".URLDecode($mailto)."'");
echo "success|发送成功！";
}else{
echo "error|此手机号码尚未注册会员，请先注册！";
}
die();
}
}
;
if($action=="reg"){

$_SESSION["reg_code"]=rand(10000, 99999);
if($C_userid=="" or $C_codeid=="" or $C_codekey==""){
echo "error|请到后台-基本设置-短信设置中配置短信接口";
die();
}else{
$sql="Select * from SL_member Where M_mobile like '".URLDecode($mailto)."'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
echo "error|手机号已被占用，请换其他手机号";
die();
}else{
sendmobile("【".$C_smssign."】您的验证码为".$_SESSION["reg_code"]."；1分钟内有效,请尽快验证！",$mailto) ;
echo "success|发送成功！";
die();
}
}
}
?>