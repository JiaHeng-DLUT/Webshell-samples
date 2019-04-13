<?php 
require '../conn/conn2.php';
require '../conn/function.php';

$action=$_GET["action"];
$M_pwdcode=urlencode($_GET["M_pwdcode"]);
$genkey=gen_key(20);
$from=$_SESSION["from"];
if($from==""){
$from="../member/index.asp";
}
$sql="Select * from SL_member Where M_pwdcode='".$M_pwdcode."'";
 
    $result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
    $M_login=$row["M_login"];
    }else{
    box("重置码错误!","member_login.asp","error");
    }
if($action=="setpwd"){
if($_POST["M_newpwd"]==$_POST["M_newpwd2"] && $_POST["M_newpwd"]!=""){
mysqli_query($conn,"update SL_member set M_pwd='".md5($_POST["M_newpwd"])."' where M_pwdcode='".$M_pwdcode."'");
mysqli_query($conn,"update SL_member set M_pwdcode='' where M_pwdcode='".$M_pwdcode."'");
box("重置密码成功，请返回登录!","member_login.php","success");
}else{
box("两次密码不一致!","back","error");
}
}

?>

<!DOCTYPE HTML>
<html>
<head>
<title>设置密码</title>
<meta charset="utf-8" />
<meta content="width=device-width, initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=yes" name="format-detection" />
<meta content="email=no" name="format-detection" />
<meta name="keywords" content=""  />
<meta name="description" content="" />
<link rel="stylesheet" href="../css/css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.css">
<script src="js/jquery.min.js" type="text/javascript" ></script>
<script src="js/bootstrap.min.js"></script>
<style>
body{ background: #eeeeee; padding-top:0px;}
a{ text-decoration:none} 
a:hover{ text-decoration:none;} 
</style>

</head>
<body>
<div style=" max-width: 600px; width: 100%; margin: 0px auto; padding: 20px;">
<div style="text-align: center; padding: 20px;"><img src="../<?php echo $C_logo?>" width="200"></div>
<div class="panel  panel-info ng-scope">
        <div class="panel-heading">
         设置密码
        </div>
        <div class="panel-body">
<form class="form-horizontal" method="post" action="?action=setpwd&M_pwdcode=<?php echo $M_pwdcode?>">
<div class="form-group">
          <label class="col-sm-2 control-label">用户名</label>
          <div class="col-sm-10">
          <?php echo $M_login?>
          </div>
          </div>
<div class="form-group">
          <label class="col-sm-2 control-label">设置密码</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="M_newpwd" placeholder="设置密码">
          </div>
          </div>
          <div class="form-group">
          <label class="col-sm-2 control-label">确认密码</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="M_newpwd2" placeholder="确认密码">
          </div>
          </div>
          <div class="form-group">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <button type="submit" class="btn btn-info btn-block">设置密码</button>
          </div>
          </div>
          <div class="form-group">
          <label class="col-sm-2 "></label>
          <div class="col-sm-10 ">
          <img src='http://static.websiteonline.cn/website/qr/index.php?url=http://<?php echo $C_domain?><?php echo $C_dir?>wxpay/login.php?genkey=<?php echo $genkey?>' style="display: none;">
            <?php if ($C_qqkj==1 ){?>
            <a href="../qq/qqlogin.php"><span class="label" style="background: #0099ff;"><i class="fa fa-qq"></i> QQ登录</span></a>
            <?php }?>
            <?php if ($C_wxkj==1){?>
            <a href="<?php if (wapstr()){ ?>http://<?php echo $C_domain?><?php echo $C_dir?>wxpay/login.php?genkey=<?php echo $genkey?><?php }else{?>javascript:;<?php }?>" <?php if (!wapstr()){?>data-toggle="tooltip" <?php }?>title="<div style='text-align:center;padding:10px;'><img src='http://static.websiteonline.cn/website/qr/index.php?url=http://<?php echo $C_domain?><?php echo $C_dir?>wxpay/login.php?genkey=<?php echo $genkey?>' width='150'></div>"><span class="label" style="background: #009900;"><i class="fa fa-wechat"></i> 微信登录</span></a>
            <?php }?>
            <div class="pull-right">
            <a href="../"><span class="label" style="background: #BBBBBB;">返回首页</span></a>
            <a href="member_reg.php"><span class="label" style="background: #BBBBBB;">注册</span></a>
            <a href="member_login.php"><span class="label" style="background: #BBBBBB;">登录</span></a>
            </div>
          </div>
          </div>
</form>
</div>
</div>
</div>
<script>
	$(function () { $("[data-toggle='tooltip']").tooltip({html : true }); });
</script>
</body>
</html>