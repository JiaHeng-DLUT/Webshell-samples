<?php 
require '../conn/conn2.php';
require '../conn/function.php';
require 'auto.php';
require 'member_check.php';
require 'left.php';

$M_login=$_SESSION["M_login"];
$M_id=$_SESSION["M_id"];
$action=$_GET["action"];
if($action=="edit"){

  $M_email=filter_keyword($_POST["M_email"]);
  $code=filter_keyword($_POST["code"]);

  $sql="Select * from SL_member Where M_id=".$M_id." and M_pwdcode like '".$code."'";
  		$result = mysqli_query($conn,  $sql);
		if (mysqli_num_rows($result) > 0) {
		mysqli_query($conn,"update SL_member set M_email='".$M_email."' where M_id=".$M_id);
    	box("修改成功！","member_email.php","success");
      }else{
        box("验证码错误！","back","error");
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
 
   <link rel="stylesheet" href="../css/sweetalert.css">
   <link rel="stylesheet" href="css/toastr.min.css">

  <!-- css plugins -->

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/icheck.min.js"></script>
  <script src="js/page.js"></script>
  <script src="js/yto_cityselect.js"></script>
  <script src="js/cropper.min.js"></script>
  <script src="js/cropper-set.js"></script>
  <script src="js/bootstrap-datetimepicker.js"></script>
  <script src="js/toastr.min.js"></script>
  <script src="js/ajax.js"></script>

<script>
function sendmail(to){
	ajaxx("sendmail.php?to="+to+"&action=edit", "", "mail", "");
}
 </script>




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
				<li class="active">信息修改</li>
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
	        <li class="active"><a href="member_email.php">绑定邮箱</a></li>
	        <li><a href="member_mobile.php">绑定手机</a></li>
            <li><a href="member_pwdedit.php">密码修改</a></li>
            
	     </ul>
	 </div>
	 <div class="col-sm-10 b-left">
		<p class="alert alert-danger hidden" role="alert" id="error"></p>
<form id="userinfo_save" method="POST" action="?action=edit" class="form-horizontal" id="form">
                           
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("邮箱/l/Email")?></label>
								<div class="col-sm-6">
					<div class="input-group">
                    <input name="M_email" maxlength="50" id="email" value="<?php echo $M_email?>" class="form-control" >
                    <span class="input-group-btn">
                        <button class="btn btn-info" type="button" onclick="sendmail($('#email').val())">获取验证码</button>
                    </span>
                </div>
								</div>
							</div>
														
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("验证码/l/code")?></label>
								<div class="col-sm-6">
								   <input name="code" maxlength="50" value=""  class="form-control" >
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-offset-2  col-sm-6">
								   <input type="submit" value="<?php echo lang("确定/l/Edit")?>" class="btn btn-primary btn-block m_top_20" >
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

 <script type="text/javascript">
	  $(function() {
		  'use strict';
		  setTimeout(function(){
	          $("#error:parent").removeClass("hidden");
	          },200);

		  $("#address").citySelect();
		  
		  $('#birthday').datetimepicker({
			    format: 'yyyy-mm-dd',
			    startDate: '1950-01-01',
			    endDate: '2020-12-30',
			    weekStart : 1,
				todayBtn : 1,
				autoclose : 1,
				initialDate:'1985-01-01',
				todayHighlight : 1,
				startView : 4,
				minView : 2,
				fontAwesome:true,
				forceParse : 0,
				linkFormat: 'yyyy-mm-dd',
		        linkField:'birthday_hidden'
			});

	  });
	</script>
	
	

</body>
</html>