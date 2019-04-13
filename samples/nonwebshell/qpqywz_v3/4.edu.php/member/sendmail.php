<?php 
require '../conn/conn2.php';
require '../conn/function.php';

$action=urlencode($_REQUEST["action"]);
$mailto=urlencode($_REQUEST["to"]);
if(strpos(URLDecode($mailto),"@")===false){
echo "error|邮箱格式不正确！";
die();
}
if($action=="pwd"){

$_SESSION["pwd_code"]=rand(10000, 99999);
mysqli_query($conn,"update SL_member set M_pwdcode='".$_SESSION["pwd_code"]."' where M_email like '".URLDecode($mailto)."'");
sendmail("您的验证码","您的验证码为 <b>".$_SESSION["pwd_code"]."</b>，请妥善保管不要告诉他人。",URLDecode($mailto)) ;
echo "success|发送成功！";
die();
}
if($action=="edit"){

$_SESSION["edit_code"]=rand(10000, 99999);
$sql="Select * from SL_member Where M_email like '".URLDecode($mailto)."' and not M_id=".$_SESSION["M_id"];

    $result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
echo "error|邮箱已被占用，请换其他邮箱!";
die();
}else{
mysqli_query($conn,"update SL_member set M_pwdcode='".$_SESSION["edit_code"]."',M_email='".URLDecode($mailto)."' where M_id=".$_SESSION["M_id"]);
sendmail("您的验证码","您的验证码为 <b>".$_SESSION["edit_code"]."</b>，请妥善保管不要告诉他人。",URLDecode($mailto)) ;
echo "success|发送成功！";
die();
}
}

if($action=="login"){

$_SESSION["login_code"]=rand(10000, 99999);
$sql="Select * from SL_member Where M_email like '".URLDecode($mailto)."'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
mysqli_query($conn,"update SL_member set M_pwdcode='".$_SESSION["login_code"]."' where M_email like '".URLDecode($mailto)."'");
sendmail("您的验证码","您的验证码为 <b>".$_SESSION["login_code"]."</b>，请妥善保管不要告诉他人。",URLDecode($mailto)) ;
echo "success|发送成功！";
}else{
echo "error|此邮箱尚未注册会员，请先注册！";
}

die();
}

if($action=="reg"){
$_SESSION["reg_code"]=rand(10000, 99999);
$sql="Select * from SL_member Where M_email like '".URLDecode($mailto)."'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
echo "error|邮箱已被注册使用，请直接登录";
die();
}else{
sendmail("您的验证码","您的验证码为 <b>".$_SESSION["reg_code"]."</b>，请妥善保管不要告诉他人。",URLDecode($mailto)) ;
echo "success|发送成功！";
die();
}
}
?>