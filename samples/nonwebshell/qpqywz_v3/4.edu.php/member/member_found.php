<?php 
require '../conn/conn2.php';
require '../conn/function.php';

$action=$_GET["action"];
$genkey=gen_key(20);
$from=$_SESSION["from"];
if($from==""){
$from="../member/index.php";
}
if($action=="found"){
$M_email=Replace_Text($_POST["M_email"]);
$sql="Select * from SL_member Where M_email='".$M_email."'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
    $M_pwdcode=gen_key(20);
    mysqli_query($conn,"update SL_member set M_pwdcode='".$M_pwdcode."' where M_email='".$M_email."'");
    sendmail("找回密码邮件","请点击链接重新设置密码<br><a href=http://".$_SERVER["HTTP_HOST"].$C_dir."member/member_setpwd.php?M_pwdcode=".$M_pwdcode.">http://".$_SERVER["HTTP_HOST"].$C_dir."member/member_setpwd.php?M_pwdcode=".$M_pwdcode."</a><br>说明：重置密码后链接失效",$M_email);
box("请查收邮件!","member_login.php","success");
}else{
box("邮箱输入错误，请重新输入!","back","error");
}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>找回密码</title>
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
<div style="text-align: center; padding: 20px;"><a href="../"><img src="../<?php echo $C_logo?>" width="200"></a></div>
<div class="panel  panel-info ng-scope">
        <div class="panel-heading">
         找回密码
        </div>
        <div class="panel-body">
<form class="form-horizontal" method="post" action="?action=found">
<div class="form-group">
          <label class="col-sm-2 control-label">邮箱</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="M_email" placeholder="邮箱">
          </div>
          </div>
          <div class="form-group">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <button type="submit" class="btn btn-info btn-block">找回密码</button>
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