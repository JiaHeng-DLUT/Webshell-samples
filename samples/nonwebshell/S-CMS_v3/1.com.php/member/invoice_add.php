<?php 
require '../conn/conn2.php';
require '../conn/function.php';
require 'auto.php';
require 'member_check.php';
require 'left.php';


$M_login=$_SESSION["M_login"];
$M_id=$_SESSION["M_id"];
$action=$_GET["action"];
if($action=="add"){
$I_company=$_POST["I_company"];
$I_no=$_POST["I_no"];
$I_list=$_POST["I_list"];
$I_money=number_format($_POST["I_money"],2,".","");
if($I_company!=""){

mysqli_query($conn,"insert into SL_invoice(I_company,I_mid,I_no,I_list,I_money,I_time,I_sh) values(
'".$I_company."',
".$M_id.",
'".$I_no."',
'".$I_list."',
".$I_money.",
'".date('Y-m-d H:i:s')."',
0
)");

box(lang("提交成功，请等待审核!/l/Success!"),"invoice_list.php","success");
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
		 <li ><a href="member_moneylist.php">余额明细</a></li>
		 <li class="active" ><a href="invoice_list.php">发票管理</a></li>
		  <li ><a href="member_fenlist.php">积分明细</a></li>
		   <li ><a href="member_role.php">奖励规则</a></li>
<?php if ($C_gifton==1){?><li ><a href="member_gift.php">兑换礼品</a></li><?php }?>
            
	     </ul>
	 </div>
	 <div class="col-sm-10 b-left">
		<p class="alert alert-danger hidden" role="alert" id="error"></p>
<form id="userinfo_save" method="POST" action="?action=add" class="form-horizontal" id="form">
                           
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("发票抬头/l/company")?></label>
								<div class="col-sm-4">
								    <input name="I_company" value="" class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("纳税人识别号/l/Tax Number")?></label>
								<div class="col-sm-4">
								    <input name="I_no" value="" class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("发票内容/l/Content")?></label>
								<div class="col-sm-4">
								   <input name="I_list" value="" class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("发票金额/l/Money")?></label>
								<div class="col-sm-4">

								<div class="input-group">
            <input name="I_money" value="" class="form-control" >
            <span class="input-group-addon">元</span>
        </div>
								   
								</div>
							</div>

							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"></label>
								<div class="col-sm-4">
								   说明：开发金额不得高于实际消费金额
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-4">
								   <input type="submit" value="<?php echo lang("申请发票/l/Edit")?>" class="btn btn-primary btn-block m_top_20" >
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