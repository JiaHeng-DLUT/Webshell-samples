<?php 
require '../conn/conn2.php';
require '../conn/function.php';

if($C_member!=1){
  box(lang("管理员未开启会员中心！/l/Administrator did not open membership Center!"),"../","error");
}

if ($_SESSION["M_login"]!=""){
  Header("Location: index.php");
}


$sql="Select  * from SL_slide where S_del=0 order by S_id desc limit 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
    if ($C_memberbg=="" || is_null($C_memberbg)){
    $S_pic=$row["S_pic"];
}else{
$S_pic=$C_memberbg;
}
    }
if($_GET["uid"]!=""){
setcookie("uid",$_GET["uid"]);
}else{
setcookie("uid",0);
}
$action=$_GET["action"];
$genkey=gen_key(20);
$from=$_SESSION["from"];
if($from==""){
$from="../member/index.php";
}
$action=$_GET["action"];
if($action=="reg"){

if($_POST["Agreement"]!="1"){
box("请先同意会员注册协议!","back","error");
}

if(xcode($_POST["M_code"],'DECODE',$_SESSION["CmsCode"],0)!=$_SESSION["CmsCode"]){
 box(lang("验证码错误！/l/Verification code error"),"back","error");
 }else{
$M_login=$_POST["M_login"];
$M_pwd=$_POST["M_pwd"];
$M_pwd2=$_POST["M_pwd2"];
$M_email=$_POST["M_email"];
$M_need=$_POST["M_need"];
if(!IsValidStr($M_login) || !IsValidStr($M_pwd) || !IsValidStr($M_pwd2) || !IsValidStr($M_email) || !IsValidStr($M_need)){
box("输入内容包含敏感字符，请重新输入!","back","error");
}
if($M_pwd!=$M_pwd2){
box("两次输入密码不一致!","back","error");
}
if($M_need=="x"){
box("请选择一个业务需求！","back","error");
}
if($M_login!="" && $M_pwd!="" && $M_email!=""){
if(strpos($M_email,"@")===false){
box("请输入一个可用的邮箱!","back","error");
}else{
$sql="Select * from SL_member Where M_login='".$M_login."'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
box("用户名已被占用!","back","error");
}else{
if($M_login!=""){
mysqli_query($conn,"insert into SL_member(M_login,M_pwd,M_email,M_fen,M_pic,M_regtime,M_from,M_need) values('".$M_login."','".strtoupper(md5($M_pwd))."','".$M_email."',0,'member.jpg','".date('Y-m-d H:i:s')."',".intval($_COOKIE["uid"]).",'".$M_need."')");
}else{
  die("请填全信息！");
}

	$sql="Select * from SL_member order by M_id desc limit 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $M_id=$row["M_id"];
    uplevel($M_id);
if($_COOKIE["uid"]!=""){
mysqli_query($conn,"update SL_member set M_fen=M_fen+".$C_Invitation." where M_id=".intval($_COOKIE["uid"]));
mysqli_query($conn,"insert into SL_list(L_title,L_mid,L_change,L_time,L_type) values('邀请好友',".intval($_COOKIE["uid"]).",".$C_Invitation.",'".date('Y-m-d H:i:s')."',1)");
}
box("注册成功!您可以登录了！","member_login.php","success");
}
}
}else{
box("请填全信息!","back","error");
}
}
}
if($action=="login2"){
$M_mobile=$_POST["M_mobile"];
$M_need=$_POST["M_need"];
$M_code=$_POST["M_code"];
$M_name=$_POST["M_name"];
$M_qq=$_POST["M_qq"];
if($M_code==$_SESSION["reg_code"]){
  if($M_mobile!=""){
    mysqli_query($conn,"insert into SL_member(M_login,M_pwd,M_mobile,M_fen,M_pic,M_regtime,M_from,M_need,M_qq,M_name) values('".$M_mobile."','".gen_key(20)."','".$M_mobile."',0,'member.jpg','".date('Y-m-d H:i:s')."',".intval($_COOKIE["uid"]).",'".$M_need."','".$M_qq."','".$M_name."')");
  }else{
    die("请填全信息！");
  }
$sql="Select * from SL_member order by M_id desc limit 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$M_id=$row["M_id"];
$_SESSION["M_login"]=$row["M_login"];
$_SESSION["M_pwd"]=$row["M_pwd"];
$_SESSION["M_vip"]=$row["M_vip"];
$_SESSION["M_id"]=$row["M_id"];
uplevel($M_id);
if($_COOKIE["uid"]!=""){
mysqli_query($conn,"update SL_member set M_fen=M_fen+".$C_Invitation." where M_id=".intval($_COOKIE["uid"]));
mysqli_query($conn,"insert into SL_list(L_title,L_mid,L_change,L_time,L_type) values('邀请好友',".intval($_COOKIE["uid"]).",".$C_Invitation.",'".date('Y-m-d H:i:s')."',1)");
}

Header("Location: ".URLDecode($from)); 

}else{
box("验证码错误!","back","error");
}
}

if($action=="login3"){
$M_email=$_POST["M_email"];
$M_need=$_POST["M_need"];
$M_code=$_POST["M_code"];
$M_name=$_POST["M_name"];
$M_qq=$_POST["M_qq"];
if($M_code==$_SESSION["reg_code"]){
  if($M_email!=""){
    mysqli_query($conn,"insert into SL_member(M_login,M_pwd,M_email,M_fen,M_pic,M_regtime,M_from,M_need,M_qq,M_name) values('".$M_email."','".gen_key(20)."','".$M_email."',0,'member.jpg','".date('Y-m-d H:i:s')."',".intval($_COOKIE["uid"]).",'".$M_need."','".$M_qq."','".$M_name."')");
  }else{
    die("请填全信息！");
  }

$sql="Select * from SL_member order by M_id desc limit 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$M_id=$row["M_id"];
$_SESSION["M_login"]=$row["M_login"];
$_SESSION["M_pwd"]=$row["M_pwd"];
$_SESSION["M_vip"]=$row["M_vip"];
$_SESSION["M_id"]=$row["M_id"];
uplevel($M_id);
if($_COOKIE["uid"]!=""){
mysqli_query($conn,"update SL_member set M_fen=M_fen+".$C_Invitation." where M_id=".intval($_COOKIE["uid"]));
mysqli_query($conn,"insert into SL_list(L_title,L_mid,L_change,L_time,L_type) values('邀请好友',".intval($_COOKIE["uid"]).",".$C_Invitation.",'".date('Y-m-d H:i:s')."',1)");
}
Header("Location: ".URLDecode($from)); 
}else{
box("验证码错误!","back","error");
}
}
if($C_regon==0){
box("管理员已关闭注册","back","error");
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="description" content="<?php echo lang($C_description)?>">
    <meta name="author" content="s-cms">
    <title><?php echo lang("会员注册/l/sign up")?> - <?php echo lang($C_webtitle)?></title>
    <link rel="shortcut icon" href="<?php echo $C_dir.$C_ico?>" type="image/x-icon" />
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="../css/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/toastr.min.css">
    <script src="js/toastr.min.js"></script>
    <script src="js/ajax.js"></script>
    <style type="text/css">  
    .navbar .nav > li .dropdown-menu {  
        margin: 0;  
    }  
    .navbar .nav > li:hover .dropdown-menu {  
        display: block;  
    }  
</style>  
<script type="text/javascript">
 function sub(){
  $('#sub').attr('disabled','disabled')
  $('#sub').html("登录中...")
  $('#sub2').attr('disabled','disabled')
  $('#sub2').html("登录中...")
 }
function sendmail(mailto){
  ajaxx("sendmail.php?action=reg&to="+mailto, "", "mail", "");
  //$("#send_btn").attr("disabled","true")
}
function sendmobile(mailto){
if(mailto.length==11){
$('#myModal').modal('show')
}else{
alert("请输入正确的手机号！")
}
}

function checkcode(){
  if($("#checkCode").val()==getCookie("CmsCode")){
    $('#myModal').modal('hide')
    ajaxx("sendmobile.php?action=reg&to="+$("#mobile").val()+"&code="+$("#checkCode").val(), "", "mail", "");
    setInterval("changebtn()",1000); //每1秒钟执行一次changebtn()
    $("#send_btn").attr("disabled","true")
    $("#send_btn").html("<span id='second'>60</span>秒后再试")
  }else{
    alert("验证码错误")
  }
}

function changebtn(){
  if($("#second").html()>0){
  $("#second").html($("#second").html()-1);
}else{
  $("#send_btn").removeAttr("disabled");
  $("#send_btn").html("发送");
}
}

function test(){
$.post("post.php",
    {
      genkey:"<?php echo $genkey?>",
    },
    function(data){
  if(data==1){
  document.location.href='<?php echo URLDecode($from)?>'
  }
    });
}
setInterval("test()",3000); //每3秒钟执行一次test()
function refresh1(){ var vcode=document.getElementById('vcode'); vcode.src ="../conn/code_1.php?nocache="+new Date().getTime();}
function refresh2(){ var vcode=document.getElementById('vcode2'); vcode.src ="../conn/code_2.php?nocache="+new Date().getTime();}
</script>
</head>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top s_top" role="navigation">
    
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="../"><img src="../<?php echo $C_logo?>" height="60"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<ul class="nav navbar-nav navbar-right">
<?php 

$sql="select * from SL_menu where U_del=0 and U_sub=0 and U_hide=0 order by U_order,U_id desc";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      if($row["U_type"]!="link"){
        echo "<li><a href=\"../?type=".$row["U_type"]."&S_id=".$row["U_typeid"]."\" >".lang($row["U_title"])." </a>";
      }else{
        echo "<li><a href=\"".splitx($row["U_url"],"|",0)."\" target=\"".splitx($row["U_url"],"|",1)."\">".lang($row["U_title"])." </a>";
      }
    
    $sql2="select * from SL_menu where U_del=0 and U_sub=".$row["U_id"]." and U_hide=0 order by U_order,U_id desc";
    $result2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($result2) > 0) {
    echo "<ul class=\"dropdown-menu\">";
    while($row2 = mysqli_fetch_assoc($result2)) {

      if($row2["U_type"]!="link"){
        echo "<li><a href=\"../?type=".$row2["U_type"]."&S_id=".$row2["U_typeid"]."\">".lang($row2["U_title"])."</a></li>";
      }else{
        echo "<li><a href=\"".splitx($row2["U_url"],"|",0)."\" target=\"".splitx($row2["U_url"],"|",1)."\">".lang($row2["U_title"])." </a>";
      }

        }
    echo "</ul>";
}
echo "</li>";
        }
}

?> 
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>



    <!-- Header Carousel -->
    <div  style="height: 100%;position: relative;">
<div style="position:fixed;  z-index:-1;filter: blur(5px);background-image:url(../<?php echo $S_pic?>);background-repeat: no-repeat;background-position:center center;width:100%;height:100%;background-size: cover;" ></div>
<div style="position:fixed;  z-index:-2;background-image:url(../<?php echo $S_pic?>);background-repeat: no-repeat;background-position:center center;width:100%;height:100%;background-size: cover;" ></div>

    <!-- Page Content -->

<div style="height:150px;" class="hidden-xs"></div>
<div style="height:80px;" class="visible-xs"></div>
<div class="container" >
<div class="row">
<div class="col-lg-5 col-sm-12 col-xs-12 pull-right animated fadeInRight" id="login">
<div class="panel  panel-info ng-scope" style="background-color: rgba(0,0,0,0.5); color: #ffffff;border: none;padding: 20px;">
<div class="panel-body">
<ul class="nav nav-tabs" id="tabs1" style="margin-bottom:20px;">

<?php if ($C_reg1==1){ ?>
<li><a href="#tab1" data-toggle="tab">帐号注册</a></li>
<?php }?>
<?php if ($C_reg3==1){?>
<li><a href="#tab2" data-toggle="tab">手机注册</a></li>
<?php }?>
<?php if ($C_reg2==1){?>
<li><a href="#tab3" data-toggle="tab">邮箱注册</a></li>
<?php }?>

</ul>
<style>
.nav-tabs li a{color:#ffffff}
</style>

<div class="tab-content">

<?php if ($C_reg1==1){ ?>
<div class="tab-pane" id="tab1">
<form class="form-horizontal" method="post" action="?action=reg">
<div class="form-group" style="padding: 30px 0 0 0;">
          <label class="col-sm-2 control-label"><?php echo lang("用户名/l/UserName")?></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="M_login" placeholder="<?php echo lang("用户名/l/UserName")?>">
          </div>
          </div>
          <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang("邮箱/l/Email")?></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="M_email" placeholder="<?php echo lang("邮箱/l/Email")?>">
          </div>
          </div>
          <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang("密码/l/Password")?></label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="M_pwd" placeholder="<?php echo lang("密码/l/Password")?>">
          </div>
          </div>
          <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang("确认密码/l/Repeat")?></label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="M_pwd2" placeholder="<?php echo lang("确认密码/l/Repeat Password")?>">
          </div>
          </div>
<?php if ($C_need!="" && !is_null($C_need)){?>
          <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang("业务需求/l/Need")?></label>
          <div class="col-sm-10">
          <select class="form-control" name="M_need">
          <option value="x">请选择</option>
          <?php 
          $need=explode(PHP_EOL,$C_need);
          for($i=0;$i<count($need);$i++){
            echo "<option value=\"".$need[$i]."\">".$need[$i]."</option>".PHP_EOL;
          }
          ?>
          </select>
          </div>
          </div>
<?php }?>
          <div class="form-group">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
          <div class="input-group">

            <iframe src="../conn/code_1.php?name=M_code" scrolling="no" frameborder="0" width="100%" height="40"></iframe>
            
          </div>
          </div>
          </div>


          <?php if ($_COOKIE["uid"]!=0 ){?>
          <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang("邀请人/l/From")?></label>
          <div class="col-sm-10">
          <?php echo getrs("select * from SL_member where M_id=".intval($_COOKIE["uid"]),"M_login")?>
          </div>
          </div>
          <?php }?>

          <div class="form-group">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
          <div class="input-group" style="margin-bottom:-7px">
            <input type="checkbox" value="1" name="Agreement"> 同意<a href="javascript:;" onclick="$('#myModal2').modal('show')" style="color:#ffffff;">《会员注册协议》</a>
          </div>
          </div>
          </div>


          <div class="form-group">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <button type="submit" class="btn btn-info btn-block"><?php echo lang("注册/l/Sign Up")?></button>
          </div>
          </div>
</form>
</div>
<?php }?>


<?php if ($C_reg3==1 ){?>
<div class="tab-pane" id="tab2">
<form class="form-horizontal" method="post" action="?action=login2">
<div class="form-group" style="padding: 40px 0 10px 0;">
          <label class="col-sm-2 control-label"><?php echo lang("手机号/l/UserName")?></label>
          <div class="col-sm-10">
          <div class="input-group">
                    <input type="text" class="form-control" id="mobile" name="M_mobile" placeholder="<?php echo lang("手机号/l/UserName")?>" >
                    <span class="input-group-btn">
                        <button class="btn btn-info" type="button" id="send_btn" onclick="sendmobile($('#mobile').val())">获取验证码</button>
                    </span>
                </div>
          </div>
          </div>
          <div class="form-group" style="padding: 5px 0;">
          <label class="col-sm-2 control-label"><?php echo lang("验证码/l/Code")?></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="M_code" placeholder="<?php echo lang("验证码/l/Password")?>" >
          </div>
          </div>

          <div class="form-group" style="padding: 5px 0;">
          <label class="col-sm-2 control-label"><?php echo lang("联系人/l/name")?></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="M_name" placeholder="<?php echo lang("联系人/l/name")?>" >
          </div>
          </div>

          <div class="form-group" style="padding: 5px 0;">
          <label class="col-sm-2 control-label"><?php echo lang("QQ/l/QQ")?></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="M_qq" placeholder="<?php echo lang("QQ/l/QQ")?>" >
          </div>
          </div>

          <?php if ($C_need!="" && !is_null($C_need)){?>
          <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang("业务需求/l/Need")?></label>
          <div class="col-sm-10">
          <select class="form-control" name="M_need">
          <option value="x">请选择</option>
          <?php 
          $need=explode(PHP_EOL,$C_need);
          for($i=0;$i<count($need);$i++){
            echo "<option value=\"".$need[$i]."\">".$need[$i]."</option>".PHP_EOL;
          }
          ?>
          </select>
          </div>
          </div>
          <?php }?>

          <div class="form-group">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
          <div class="input-group" style="margin-bottom:-7px">
            <input type="checkbox" value="1" name="Agreement"> 同意<a href="javascript:;" onclick="$('#myModal2').modal('show')" style="color:#ffffff;">《会员注册协议》</a>
          </div>
          </div>
          </div>

          <div class="form-group" style="padding: 10px 0;">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <button type="submit" id="sub" class="btn btn-info btn-block"><?php echo lang("注册/l/Sign Up")?></button>
          </div>
          </div>
</form>
</div>
<?php }?>


<?php if ($C_reg2==1 ){?>

<div class="tab-pane" id="tab3">
<form class="form-horizontal" method="post" action="?action=login3">
<div class="form-group" style="padding: 40px 0 10px 0;">
          <label class="col-sm-2 control-label"><?php echo lang("邮箱/l/Email")?></label>
          <div class="col-sm-10">
            <div class="input-group">
                    <input type="text" class="form-control" id="email" name="M_email" placeholder="<?php echo lang("邮箱/l/Email")?>" >
                    <span class="input-group-btn">
                        <button class="btn btn-info" type="button" id="send_btn" onclick="sendmail($('#email').val())">获取验证码</button>
                    </span>
                </div>
          </div>
          </div>
          <div class="form-group" style="padding: 5px 0;">
          <label class="col-sm-2 control-label"><?php echo lang("验证码/l/Password")?></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="M_code" placeholder="<?php echo lang("验证码/l/Password")?>" >
          </div>
          </div>
          <div class="form-group" style="padding: 5px 0;">
          <label class="col-sm-2 control-label"><?php echo lang("联系人/l/name")?></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="M_name" placeholder="<?php echo lang("联系人/l/name")?>" >
          </div>
          </div>

          <div class="form-group" style="padding: 5px 0;">
          <label class="col-sm-2 control-label"><?php echo lang("QQ/l/QQ")?></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="M_qq" placeholder="<?php echo lang("QQ/l/QQ")?>" >
          </div>
          </div>

          <?php if ($C_need!="" && !is_null($C_need)){?>
          <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang("业务需求/l/Need")?></label>
          <div class="col-sm-10">
          <select class="form-control" name="M_need">
          <option value="x">请选择</option>
          <?php 
          $need=explode(PHP_EOL,$C_need);
          for($i=0;$i<count($need);$i++){
            echo "<option value=\"".$need[$i]."\">".$need[$i]."</option>".PHP_EOL;
          }
          ?>
          </select>
          </div>
          </div>
<?php }?>

<div class="form-group">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
          <div class="input-group" style="margin-bottom:-7px">
            <input type="checkbox" value="1" name="Agreement"> 同意<a href="javascript:;" onclick="$('#myModal2').modal('show')" style="color:#ffffff;">《会员注册协议》</a>
          </div>
          </div>
          </div>


          <div class="form-group" style="padding: 10px 0;">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <button type="submit" id="sub" class="btn btn-info btn-block"><?php echo lang("注册/l/Sign Up")?></button>
          </div>
          </div>
</form>
</div>
<?php }?>

</div>
<div class="form-group" style="padding: 10px 0;">
          <label class="col-sm-2 "></label>
          <div class="col-sm-10 ">
          <img src='http://static.websiteonline.cn/website/qr/index.php?url=http://<?php echo $C_domain?><?php echo $C_dir?>wxpay/login.php?genkey=<?php echo $genkey?>' style="display: none;">
          <?php if( $C_qqkj==1){ ?>
            <a href="../qq/qqlogin.php" class="btn btn-xs btn-info"><i class="fa fa-qq"></i> <?php echo lang("QQ登录/l/QQ")?></a>
            <?php }?>
            <?php if ($C_wxkj==1){?>
            <a href="<?php if(wapstr()){ ?>http://<?php echo $C_domain?><?php echo $C_dir?>wxpay/login.php?genkey=<?php echo $genkey?><?php }else{?>javascript:;<?php }?>" <?php if (!wapstr()){?>data-toggle="tooltip" <?php }?>title="<div style='text-align:center;padding:10px;'><img src='http://static.websiteonline.cn/website/qr/index.php?url=http://<?php echo $C_domain?><?php echo $C_dir?>wxpay/login.php?genkey=<?php echo $genkey?>' width='150'></div>" class="btn btn-xs btn-success"><i class="fa fa-wechat"></i> <?php echo lang("微信登录/l/Wechat")?></a>
            <?php }?>
            <div class="pull-right">

            <a href="member_login.php"  class="btn btn-xs btn-default"><?php echo lang("登录/l/Sign In")?></a>
            <a href="member_found.php"  class="btn btn-xs btn-default"><?php echo lang("忘记密码/l/Forgot")?></a>
            </div>
          </div>
          </div>

</div>
</div>
</div>


<div class="col-lg-5 hidden-sm hidden-xs animated fadeInLeft" style="margin-top:200px;max-width: 500px;color: #ffffff;" id="s_left">

<h3 style="line-height: 200%;text-indent:2em;"><?php echo lang($C_description)?></h3>
</div>
        <!-- Marketing Icons Section -->
</div>
    </div>
    </div>
    <!-- /.container -->



<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
    <form class="form-horizontal" method="post" action="?action=login3">
    <div class="form-group" style="padding: 40px 0 10px 0;">
          <label class="col-sm-2 control-label">图形验证</label>
          <div class="col-sm-10">
          <div class="input-group">
                    <input type="text" class="form-control" id="checkCode" placeholder="输入图形验证码" >
                    <span class="input-group-addon" style="padding: 0px;">
                    <img id='vcode2' src='../conn/code_2.php'  onclick='refresh2()'>
                    </span>
                </div>
          </div>
          </div>
          <div class="form-group" style="padding: 10px 0;">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <button type="button"  class="btn btn-info" onClick="checkcode()">确定发送</button>
          </div>
          </div>
          </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <?php echo str_Replace(PHP_EOL,"<br>",file_get_contents("agreement.txt"));?>
      </div>
    </div>
  </div>
</div>

<script>
$(function () {
$("[data-toggle='tooltip']").tooltip({html : true }); 
});


function getCookie(name)
{
var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
if(arr=document.cookie.match(reg))
return unescape(arr[2]);
else
return null;
}

$("#tabs1").find("li:eq(0)").attr("class","active")
$(".tab-content").find("div:eq(0)").attr("class","tab-pane active")

</script>
</body>

</html>