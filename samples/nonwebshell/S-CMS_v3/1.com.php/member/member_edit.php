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
$pic_code=gen_key(20);

file_put_contents("../media/".$pic_code.".jpg", base64_decode(splitx($_POST["headFile"],",",1)));

$M_qq=htmlspecialchars($_POST["M_QQ"]);
$M_add=htmlspecialchars($_POST["M_add"]);
$M_pic=htmlspecialchars($_POST["M_pic"]);
$M_name=htmlspecialchars($_POST["M_name"]);
$M_code=htmlspecialchars($_POST["M_code"]);
$M_info=htmlspecialchars($_POST["M_info"]);
if($M_name!=""){

mysqli_query($conn,"update SL_member set
		M_QQ='".$M_qq."',
		M_info='".$M_info."',
		M_add='".$M_add."',
		M_name='".$M_name."',
		M_code='".$M_code."'
		where M_id=".$M_id);

if($_POST["headFile"]!=""){
mysqli_query($conn,"update SL_member set M_pic='".$pic_code.".jpg' where M_id=".$M_id);
}

box(lang("修改成功!/l/Success!"),"member_edit.php","success");
}else{
box(lang("请填全资料!/l/Please fill in all the information!"),"back","error");
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
	        <li class="active"><a href="member_edit.php">基本信息</a></li>
	        <li><a href="member_email.php">绑定邮箱</a></li>
	        <li><a href="member_mobile.php">绑定手机</a></li>
            <li><a href="member_pwdedit.php">密码修改</a></li>
            
	     </ul>
	 </div>
	 <div class="col-sm-10 b-left">
		<p class="alert alert-danger hidden" role="alert" id="error"></p>
<form id="userinfo_save" method="POST" action="?action=edit" class="form-horizontal" id="form">
                           <div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("头像/l/Head")?></label>
								<div class="col-sm-4">								
								<div class="avatar-edit"  title="<?php echo lang("点击上传头像/l/Click upload Avatar")?>">

								    <img id="headUrlImg" src="<?php echo $M_pic?>"> 

                                <input type="hidden"  name="headFile"  class="headimg">
                                <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                                </div>
								</div>
							</div>
							
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("昵称/l/Nick Name")?></label>
								<div class="col-sm-4">
								   <input name="M_login" maxlength="50" value="<?php echo htmlspecialchars($M_login)?>" title="nickname" class="form-control" readonly>
								</div>
							</div>
														<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("真实姓名/l/True Name")?></label>
								<div class="col-sm-4">
								   <input name="M_name" maxlength="50" value="<?php echo htmlspecialchars($M_name)?>" title="nickname" class="form-control" >
								</div>
							</div>
														
														<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("QQ号码/l/QQ Number")?></label>
								<div class="col-sm-4">
								   <input name="M_QQ" maxlength="50" value="<?php echo htmlspecialchars($M_qq)?>" title="nickname" class="form-control" >
								</div>
							</div>
														<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("联系地址/l/Address")?></label>
								<div class="col-sm-4">
								   <input name="M_add" maxlength="50" value="<?php echo htmlspecialchars($M_add)?>" title="nickname" class="form-control" >
								</div>
							</div>

														<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("邮政编码/l/Postcode")?></label>
								<div class="col-sm-4">
								   <input name="M_code" maxlength="50" value="<?php echo htmlspecialchars($M_code)?>" title="nickname" class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("手机号码/l/MobilePhone")?></label>
								<div class="col-sm-4" style="padding-top:7px; ">
								   <?php echo htmlspecialchars($M_mobile)?> <a href="member_mobile.php" class="btn btn-xs btn-primary">修改</a>
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("电子邮箱/l/E-mail")?></label>
								<div class="col-sm-4" style="padding-top:7px; ">
								   <?php echo htmlspecialchars($M_email)?> <a href="member_email.php" class="btn btn-xs btn-primary">修改</a>
								</div>
							</div>

							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("备注信息/l/Remarks")?></label>
								<div class="col-sm-10" style="padding-top:7px; ">
								   <textarea name='M_info' style='width:100%;height:350px;' id='content'><?php echo htmlspecialchars($M_info)?></textarea>
								    <script type="text/javascript" charset="utf-8" src="../ueditor/ueditor.config.js"></script>
								    <script type="text/javascript" charset="utf-8" src="../ueditor/ueditor.all.min.js"> </script>
								    <script>
								    	var ue = UE.getEditor('content',{
										    toolbars: [
											    ['bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc']
											],
										    autoHeightEnabled: true,
										    autoFloatEnabled: true
										});
								    </script>
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

	  <div class="modal fade" id="avatar-modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <h4 class="modal-title">修改头像</h4>
        </div>
      
         <div class="modal-body  avatar-form">
              <div class="avatar-body">

                <!-- Upload image and data -->
                <div class="avatar-upload">
                  <input type="hidden" class="avatar-src" name="avatar-src">
                  <input type="hidden" class="avatar-data" name="avatar-data">
                  
                  <div class="input-group input-group-file">

		            <span class="btn btn-default btn-file">
		               <i aria-hidden="true" class="icon fa-upload"></i>
		               <span>浏览本地照片</span>
		               <input type="file" class="avatar-input" id="avatarInput" name="avatar-input">
		      </span>
		    </div>                 
                </div>

                <!-- Crop and preview -->
                <div class="row">
                  <div class="col-md-9">
                    <div class="avatar-wrapper"></div>
                  </div>
                  <div class="col-md-3">
                    <div class="avatar-preview preview-lg"></div>
                    <div class="avatar-preview preview-md"></div>
                    <div class="avatar-preview preview-sm"></div>
                  </div>
                </div>
                <div class="row avatar-btns">
                  <div class="col-md-4 col-md-offset-4">
                      <button type="botton" class="btn btn-primary btn-block avatar-save">完成</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- </form> -->
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