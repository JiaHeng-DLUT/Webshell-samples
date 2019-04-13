<?php
require 'conn/conn.php';
require 'conn/function.php';

$action=$_REQUEST["action"];
$G_title=$_POST["G_title"];
$G_name=$_POST["G_name"];
$G_mail=$_POST["G_mail"];
$G_phone=$_POST["G_phone"];
$G_msg=$_POST["G_msg"];
if(strpos($G_mail,"@")===false || strpos($G_mail,".")===false){
box(lang("请填写一个正确的邮箱！/l/Please fill in a correct mailbox!"),"back","error");
}
if(strlen($G_phone)!=11 || !is_numeric($G_phone)){
box(lang("请填写一个正确的手机号码！/l/Please fill in a correct phone number!"),"back","error");
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta content='text/html; charset=utf-8' http-equiv='Content-Type' />
<meta charset='utf-8' />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<script src="//apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"> </script>
<link rel="stylesheet" href="//apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.min.css" type="text/css" />
<style>
body{ font-family:"微软雅黑"; line-height:200%; color:#666666;}
</style>
<script type="text/javascript">
function refresh1(){ var vcode=document.getElementById('vcode'); vcode.src ="conn/code_1.php?nocache="+new Date().getTime();}
</SCRIPT>
</head>
<body>
<?php
if ($action==""){
?>
<div style="width:100%;max-width: 500px;margin: 20px auto;">
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            请输入验证码
        </h3>
    </div>
    <div class="panel-body">
    <form action="?action=save" method="post">
    <input type="hidden" name="G_title" value="<?php echo $_POST["G_title"]?>">
    <input type="hidden" name="G_name" value="<?php echo $_POST["G_name"]?>">
    <input type="hidden" name="G_mail" value="<?php echo $_POST["G_mail"]?>">
    <input type="hidden" name="G_phone" value="<?php echo $_POST["G_phone"]?>">
    <input type="hidden" name="G_msg" value="<?php echo $_POST["G_msg"]?>">
        <div class="input-group">
            <span class="input-group-addon">验证码</span>
            <input type="text" class="form-control" name="G_code">
            <span class="input-group-addon" style="padding: 0px;"><img id='vcode' src='conn/code_1.php' onclick='refresh1()'></span>
        </div>
        <button class="btn btn-primary" type="submit" style="margin: 10px 0">确定</button>
    </form>
    </div>
</div>
</div>
<?php
}

if ($action=="save"){
if($_POST["G_code"]!=$_SESSION["CmsCode"]){
box(lang("验证码错误！/l/Verification code error"),"index.php?type=guestbook","error");
}else{
if(!IsValidStr($G_title) || !IsValidStr($G_name) || !IsValidStr($G_mail) || !IsValidStr($G_phone) || !IsValidStr($G_msg)){
box(lang("留言内有不合适内容，请重新输入！/l/Contains illegal characters"),"index.php?type=guestbook","error");
die();
}
if($G_title!="" || $G_name!="" || $G_mail!="" || $G_phone!="" || $G_msg!=""){
mysqli_query($conn,"insert into SL_guestbook(G_title,G_name,G_phone,G_email,G_Msg,G_time) values('".Replace_Text($G_title)."','".Replace_Text($G_name)."','".Replace_Text($G_phone)."','".Replace_Text($G_mail)."','".Replace_Text($G_msg)."','".date('Y-m-d H:i:s')."')");


$sql="select count(*) as G_count from SL_guestbook where DATEDIFF(now(),G_time) = 0";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$G_count=$row["G_count"];


sendmail("您的网站“".lang($C_webtitle)."”有新的留言","您的网站“".lang($C_webtitle)."”收到新的留言<br>标题：".Replace_Text($G_title)."<br>姓名：".Replace_Text($G_name)."<br>电话：".Replace_Text($G_phone)."<br>邮箱：".Replace_Text($G_mail)."<br>消息：".Replace_Text($G_msg)."<br>留言时间：".date('Y-m-d H:i:s'),$C_email);

box(lang("留言成功[您是今日第".$G_count."位留言客户]，请耐心等待回复!/l/Successful message"),$C_dir."?type=guestbook","success");
}else{
box("请填全信息!","back","error");
}
}
}
?>
</body>
</html>