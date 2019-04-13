<?php 
require '../conn/conn2.php';
require '../conn/function.php';

if($C_member!=1){
  box(lang("管理员未开启会员中心！/l/Administrator did not open membership Center!"),"../","error");
}

if ($_SESSION["M_login"]!=""){
	Header("Location: index.php");
}

$genkey=gen_key(20);
$action=$_GET["action"];
$from=$_GET["from"];

if($from==""){
$from=$C_dir."member/index.php";
}

$sql="Select * from SL_slide where S_del=0 order by S_id desc limit 1";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
    if ($C_memberbg=="" || is_null($C_memberbg)){
    $S_pic=$row["S_pic"];
}else{
$S_pic=$C_memberbg;
}
}
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="description" content="<?php echo lang($C_description)?>">
    <title><?php echo lang("会员登录/l/sign in")?> - <?php echo lang($C_webtitle)?></title>
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
    .nav-tabs li a{color:#ffffff}
</style>  

<script>
 function sub(){
  $('#sub').attr('disabled','disabled')
  $('#sub').html("登录中...")
  $('#sub2').attr('disabled','disabled')
  $('#sub2').html("登录中...")
 }
function sendmail(mailto){
  ajaxx("sendmail.php?action=login&to="+mailto, "", "mail", "");
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
    ajaxx("sendmobile.php?action=login&to="+$("#mobile").val()+"&code="+$("#checkCode").val(), "", "mail", "");
    setInterval("changebtn()",1000);
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
</SCRIPT>
</head>

<body>
<?php 
if ($action=="login"){
if($_POST["M_code"]!=$_SESSION["CmsCode"]){
box(lang("验证码错误！/l/Verification code error"),"back","error");
}else{
$M_login=Replace_Text($_POST["M_login"]);
$M_pwd=md5($_POST["M_pwd"]);
$sql="Select * from SL_member where M_del=0 and M_login like '".$M_login."' and M_pwd like '".$M_pwd."'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) > 0) {
$_SESSION["M_login"]=$M_login;
$_SESSION["M_pwd"]=$M_pwd;
$_SESSION["M_vip"]=$row["M_vip"];
$_SESSION["M_id"]=$row["M_id"];

box(lang("登录成功！/l/Success"),URLDecode($from),"success");
}else{
box(lang("账号或密码错误！/l/Account or password error"),"member_login.php","error");
}
}
}
if($action=="login2"){
$M_mobile=Replace_Text($_POST["M_mobile"]);
$M_code=Replace_Text($_POST["M_code"]);
if($M_code==$_SESSION["login_code"]){
$sql="Select * from SL_member where M_del=0 and M_mobile like '".$M_mobile."' and M_pwdcode like '".$_SESSION["login_code"]."' and M_pwdcode<>''";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) > 0) {
$_SESSION["M_login"]=$row["M_login"];
$_SESSION["M_pwd"]=$row["M_pwd"];
$_SESSION["M_id"]=$row["M_id"];

Header("Location: ".URLDecode($from)); 

}else{
box("验证码错误1!","back","error");
}
}else{
box("验证码错误2!","back","error");
}
}

if($action=="login3"){
$M_email=Replace_Text($_POST["M_email"]);
$M_code=Replace_Text($_POST["M_code"]);

if($M_code==$_SESSION["login_code"]){
$sql="Select * from SL_member Where M_del=0 and M_email like '".$M_email."' and M_pwdcode like '".$_SESSION["login_code"]."' and M_pwdcode<>''";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) > 0) {
$_SESSION["M_login"]=$row["M_login"];
$_SESSION["M_pwd"]=$row["M_pwd"];
$_SESSION["M_id"]=$row["M_id"];

Header("Location: ".URLDecode($from)); 
}else{
box("验证码错误1!","back","error");
}
}else{
box("验证码错误2!","back","error");
}
}


if($action=="unlogin"){
$_SESSION["M_id"]="";
$_SESSION["M_login"]="";
$_SESSION["M_pwd"]="";
$_SESSION["M_vip"]="";
$_SESSION["from"]="";
box(lang("退出成功！/l/Quit successfully"),URLDecode($from),"success");
}
  ?>


<nav class="navbar navbar-inverse navbar-fixed-top s_top hidden-sm" role="navigation">
    <div class="s_head" style="padding-top:4px;">
    <div class="container">
    <div class="pull-left">
    <span style="font-size: 12px;"><?php echo lang($C_webtitle)?></span>
    </div>
    <div class="pull-right">
    <?php if ($_SESSION["M_login"]==""){?>
    <a href="member_reg.php"><?php echo lang("注册/l/Sign Up")?></a> <a href="member_login.php"><?php echo lang("登录/l/Sign In")?></a>
    <?php }else{?>
    <a href="index.php"><?php echo $_SESSION["M_login"]?></a> <a href="membe_login.php?action=unlogin"><?php echo lang("退出/l/Sign Out")?></a>
    <?php }?>
    </div>
    </div>
    </div>
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

<nav class="navbar navbar-inverse navbar-fixed-bottom s_top hidden-xs" role="navigation">
    
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                
                <p style="margin:20px 0 0 10px; "><?php echo lang($C_foot).$C_code?></p>

            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Header Carousel -->
    <div  style="height: 100%;position: relative;">



<div style="position:fixed; z-index:-1;filter: blur(5px);background-image:url(../<?php echo $S_pic?>);background-repeat: no-repeat;background-position:center center;width:100%;height:100%;background-size: cover;"></div>

<div style="position:fixed; z-index:-2;background-image:url(../<?php echo $S_pic?>);background-repeat: no-repeat;background-position:center center;width:100%;height:100%;background-size: cover;"></div>

<div class="container" style="z-index: 9999">
<div class="row">
<div class="col-lg-5 col-sm-12 col-xs-12 pull-right animated fadeInRight" id="login">
<div class="panel  panel-info ng-scope" style="background-color: rgba(0,0,0,0.5); color: #ffffff;border: none;padding: 20px;">

<div class="panel-body">
<div class="visible-xs" style="height: 100px;"></div>
<ul class="nav nav-tabs" id="tabs1" style="margin-bottom:20px;">

<?php if ($C_reg1==1 ){?>
<li><a href="#tab1" data-toggle="tab">帐号登录</a></li>
<?php }?>
<?php if ($C_reg3==1 ){?>
<li><a href="#tab2" data-toggle="tab">手机登录</a></li>
<?php }?>
<?php if ($C_reg2==1){?>
<li><a href="#tab3" data-toggle="tab">邮箱登录</a></li>
<?php }?>

</ul>

<div class="tab-content">

<?php if ($C_reg1==1){?>
<div class="tab-pane" id="tab1">
<form class="form-horizontal" method="post" action="?action=login">
<div class="form-group" style="padding: 40px 0 10px 0;">
          <label class="col-sm-2 control-label"><?php echo lang("用户名/l/UserName")?></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="M_login" placeholder="<?php echo lang("用户名/l/UserName")?>" >
          </div>
          </div>
          <div class="form-group" style="padding: 10px 0;">
          <label class="col-sm-2 control-label"><?php echo lang("密码/l/Password")?></label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="M_pwd" placeholder="<?php echo lang("密码/l/Password")?>" >
          </div>
          </div>
          <div class="form-group" style="padding: 10px 0;">
          <label class="col-sm-2 control-label"><?php echo lang("验证码/l/Code")?></label>
          <div class="col-sm-10">
          <div class="input-group">
            <input type="text" class="form-control" name="M_code" placeholder="<?php echo lang("验证码/l/Code")?>">
            <span class="input-group-addon" style="padding: 0px;"><img id='vcode' src='../conn/code_1.php' onclick='refresh1()'></span>
          </div>
          </div>
          </div>
          <div class="form-group" style="padding: 10px 0;">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <button type="submit" id="sub" class="btn btn-info btn-block"><?php echo lang("登录/l/Sign In")?></button>
          </div>
          </div>
</form>
</div>
<?php }?>

<?php if ($C_reg3==1){?>
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
          <div class="form-group" style="padding: 10px 0;">
          <label class="col-sm-2 control-label"><?php echo lang("验证码/l/Password")?></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="M_code" placeholder="<?php echo lang("验证码/l/Password")?>" >
          </div>
          </div>

          <div class="form-group" style="padding: 10px 0;">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <button type="submit" id="sub" class="btn btn-info btn-block"><?php echo lang("登录/l/Sign In")?></button>
          </div>
          </div>
</form>
</div>
<?php }?>

<?php if ($C_reg2==1){?>
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
          <div class="form-group" style="padding: 10px 0;">
          <label class="col-sm-2 control-label"><?php echo lang("验证码/l/Password")?></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="M_code" placeholder="<?php echo lang("验证码/l/Password")?>" >
          </div>
          </div>
          <div class="form-group" style="padding: 10px 0;">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <button type="submit" id="sub" class="btn btn-info btn-block"><?php echo lang("登录/l/Sign In")?></button>
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
          <?php if ($C_qqkj==1){?>
            <a href="../qq/qqlogin.php" class="btn btn-xs btn-info"><i class="fa fa-qq"></i> <?php echo lang("QQ登录/l/QQ")?></a>
            <?php }?>
            <?php if ($C_wxkj==1){?>
            <a href="<?php if (wapstr()){?>http://<?php echo $C_domain?><?php echo $C_dir?>wxpay/login.php?genkey=<?php echo $genkey?><?php }else{?>javascript:;<?php }?>" <?php if (!wapstr()){?>data-toggle="tooltip" <?php }?>title="<div style='text-align:center;padding:10px;'><img src='http://static.websiteonline.cn/website/qr/index.php?url=http://<?php echo $C_domain?><?php echo $C_dir?>wxpay/login.php?genkey=<?php echo $genkey?>' width='150'></div>" class="btn btn-xs btn-success"><i class="fa fa-wechat"></i> <?php echo lang("微信登录/l/Wechat")?></a>
            <?php }?>
            <div class="pull-right">
            <a href="member_reg.php"  class="btn btn-xs btn-default"><?php echo lang("注册/l/Sign up")?></a>
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
                    <img id='vcode2' src='../conn/code_2.php' onclick='refresh2()'>
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


<script>
$(function () {
$("[data-toggle='tooltip']").tooltip({html : true }); 

$("#login").css("margin-top",($(window).height()-$("#login").height()-50)/2+40);
    $("#s_left").css("margin-top",($(window).height()-$("#s_left").height()-50)/2+40);
  });

    window.onresize = function(){
        $("#login").css("margin-top",($(window).height()-$("#login").height()-50)/2+40);
        $("#s_left").css("margin-top",($(window).height()-$("#s_left").height()-50)/2+40);
}


function getCookie(c_name) {
					if(document.cookie.length > 0) {
						c_start = document.cookie.indexOf(c_name + "=");//获取字符串的起点
						if(c_start != -1) {
							c_start = c_start + c_name.length + 1;//获取值的起点
							c_end = document.cookie.indexOf(";", c_start);//获取结尾处
							if(c_end == -1) c_end = document.cookie.length;//如果是最后一个，结尾就是cookie字符串的结尾
							return decodeURI(document.cookie.substring(c_start, c_end));//截取字符串返回
						}
					}
					return "";
				}


$("#tabs1").find("li:eq(0)").attr("class","active")
$(".tab-content").find("div:eq(0)").attr("class","tab-pane active")

</script>
</body>
</html>