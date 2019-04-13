<?php 
require '../conn/conn2.php';
require '../conn/function.php';
require 'auto.php';
require 'member_check.php';
require 'left.php';

$M_login = $_SESSION["M_login"];
$M_id = $_SESSION["M_id"];
$action = $_GET["action"];

$sql = "Select * from SL_member Where M_id=" . $M_id;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$M_pwd = $row["M_pwd"];
if ($action == "edit") {
    if (md5($_POST["M_pwd"]) == strtolower($M_pwd) && $_POST["M_newpwd"] == $_POST["M_newpwd2"]) {
        $sql = "Select * from SL_member Where M_id=" . $M_id;
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            mysqli_query($conn, "update SL_member set M_pwd='" . md5($_POST["M_newpwd"]) . "' where M_id=" . $M_id);
        }
		$_SESSION["M_id"]="";
		$_SESSION["M_login"]="";
		$_SESSION["M_pwd"]="";
		$_SESSION["M_vip"]="";
		$_SESSION["from"]="";

        box(lang("修改成功！/l/Success!") , "member_login.php", "success");
    } else {
        box(lang("旧密码输入错误或新密码不一致!/l/Old password input error or new password is not consistent") , "back", "error");
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="<?php echo lang("会员中心/l/Member Center")?>">
  <title><?php echo lang("会员中心/l/Member Center")?></title>
<link href="../<?php echo $C_ico?>" rel="shortcut icon" />

  <!-- Stylesheets -->
      <link rel="stylesheet" href="../css/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/site.min.css">
  <!-- css plugins -->
  <link rel="stylesheet" href="css/icheck.min.css">
 
  <!--[if lt IE 9]>
    <script src="http://ec.yto.net.cn/assets/js/plugins/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <link rel="stylesheet" href="http://ec.yto.net.cn/assets/css/ie8.min.css">
    <script src="http://ec.yto.net.cn/assets/js/plugins/respond/respond.min.js"></script>
    <![endif]-->
	<script>
		var _ctxPath='';
	</script>    
</head>

<link rel="stylesheet" href="css/cropper.min.css">
<body id="crop-avatar" class="body-index">
  

<?php require 'top.php';?>

<div class="page">
<div class="container m_top_10">
			<ol class="breadcrumb">
				<li><i class="icon fa-home" aria-hidden="true"></i><a href="../">首页</a></li>
				<li>用户信息</li>
				<li class="active">密码修改</li>
			</ol>
		<div class="yto-box">
		<div class="row">
	 <div class="col-sm-2 hidden-xs">
	 <div class="my-avatar center-block p_bottom_10">
							<span class="avatar"> 
							  
							    
							      <img alt="..." src="<?php echo $M_pic?>"> 
							    
							    
							  
							</span>
	</div>
	<h5 class="text-center p_bottom_10">您好！<?php echo $M_login?></h5>
	     <ul class="nav nav-pills nav-stacked">
	        <li ><a href="member_edit.php">基本信息</a></li>
	        <li ><a href="member_email.php">绑定邮箱</a></li>
	        <li ><a href="member_mobile.php">绑定手机</a></li>
            <li class="active"><a href="member_pwdedit.php">密码修改</a></li>
            
	     </ul>
	 </div>
	 <div class="col-sm-10 b-left">
		<p class="alert alert-danger hidden" role="alert" id="error"></p>
<form id="userinfo_save" method="POST" action="?action=edit" class="form-horizontal" id="form">
                           
							
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("昵称/l/Nick Name")?></label>
								<div class="col-sm-4">
								   <input name="M_login" maxlength="15" value="<?php echo $M_login?>" title="nickname" class="form-control" readonly>
								</div>
							</div>
														<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("原密码/l/Original password")?></label>
								<div class="col-sm-4">
								   <input type="password" name="M_pwd" maxlength="15" value="<?php 
								   if (substr($M_login,0,2)=="Q_" || substr($M_login,0,2)=="W_" ){
								    echo $M_pwd ;
								}?>" title="nickname" class="form-control" placeholder="<?php echo lang("原密码/l/Original password")?>">
								</div>
							</div>
														<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("新密码/l/New password")?></label>
								<div class="col-sm-4">
								   <input type="password" name="M_newpwd" maxlength="15" value="" title="nickname" class="form-control" placeholder="<?php echo lang("新密码/l/New password")?>">
								</div>
							</div>
														<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("确认密码/l/Confirm password")?></label>
								<div class="col-sm-4">
								   <input type="password" name="M_newpwd2" maxlength="15" value="" title="nickname" class="form-control" placeholder="<?php echo lang("确认密码/l/Confirm password")?>">
								</div>
							</div>
														
							<div class="form-group">
								<div class="col-sm-offset-2  col-sm-4">
								   <input type="submit" value="<?php echo lang("修改/l/Edit")?>" class="btn btn-primary btn-block m_top_20" >
								</div>
							</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<?php require 'foot.php';?>
  <!-- js plugins  -->
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/icheck.min.js"></script>
  <script src="js/page.js"></script>
  <script src="js/yto_cityselect.js"></script>
  <script src="js/cropper.min.js"></script>
  <script src="js/cropper-set.js"></script>
  <script src="js/bootstrap-datetimepicker.js"></script>

</body>
</html>