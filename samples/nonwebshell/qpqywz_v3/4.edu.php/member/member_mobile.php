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

  $M_mobile=filter_keyword($_POST["M_mobile"]);
  $code=filter_keyword($_POST["code"]);
  
  if($C_reg3==1){
    $sql="Select * from SL_member Where M_id=".$M_id." and M_pwdcode like '".$code."'";
  }else{
    $sql="Select * from SL_member Where M_id=".$M_id;
  }

  $result = mysqli_query($conn,  $sql);
      if (mysqli_num_rows($result) > 0) {
      mysqli_query($conn,"update SL_member set M_mobile='".$M_mobile."' where M_id=".$M_id);
      box("修改成功！","member_mobile.php","success");
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

function refresh2(){ var vcode=document.getElementById('vcode2'); vcode.src ="../conn/code_2.php?nocache="+new Date().getTime();}

function sendmobile(mailto){
if(mailto.length==11){
$('#myModalx').modal('show')
}else{
alert("请输入正确的手机号！")
}
}

function checkcode(){
  if($("#checkCode").val()==getCookie("CmsCode")){
    $('#myModalx').modal('hide')
    ajaxx("sendmobile.php?to="+$("#mobile").val()+"&action=edit&code="+$("#checkCode").val(), "", "mail", "");
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
          <li ><a href="member_email.php">绑定邮箱</a></li>
          <li class="active"><a href="member_mobile.php">绑定手机</a></li>
            <li><a href="member_pwdedit.php">密码修改</a></li>
            
       </ul>
   </div>
   <div class="col-sm-10 b-left">
    <p class="alert alert-danger hidden" role="alert" id="error"></p>

<?php if($C_reg3==1){?>
<form id="userinfo_save" method="POST" action="?action=edit" class="form-horizontal" id="form">
                           
              <div class="form-group">
                <label for="oldpass" class="col-sm-2 control-label"><?php echo lang("手机号/l/phone")?></label>
                <div class="col-sm-6">
          <div class="input-group">
                    <input name="M_mobile" maxlength="11" id="mobile" value="<?php echo $M_mobile?>" class="form-control" >
                    <span class="input-group-btn">
                        <button class="btn btn-info" type="button" id="send_btn" onclick="sendmobile($('#mobile').val())">获取验证码</button>
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
<?php }else{?>
<form id="userinfo_save" method="POST" action="?action=edit" class="form-horizontal" id="form">
              <div class="form-group">
                <label for="oldpass" class="col-sm-2 control-label"><?php echo lang("手机号/l/phone")?></label>
                <div class="col-sm-6">
                    <input name="M_mobile" maxlength="11" id="mobile" value="<?php echo $M_mobile?>" class="form-control" >
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2  col-sm-6">
                   <input type="submit" value="<?php echo lang("确定/l/Edit")?>" class="btn btn-primary btn-block m_top_20" >
                </div>
              </div>
</form>
<?php }?>
</div>
</div>
</div>
</div>
</div>
</div>
    

    <div class="modal fade" id="myModalx" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
            <button type="button" class="btn btn-info" onClick="checkcode()">确定发送</button>
          </div>
          </div>
          </form>
      </div>
    </div>
  </div>
</div>


<?php require 'foot.php';?>
  <!-- js plugins  -->

 <script type="text/javascript">



function getCookie(name)
{
var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
if(arr=document.cookie.match(reg))
return unescape(arr[2]);
else
return null;
}


  </script>
  
  

</body>
</html>