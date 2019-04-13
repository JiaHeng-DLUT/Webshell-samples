<?php 
require '../conn/conn2.php';
require '../conn/function.php';
require 'auto.php';
require 'member_check.php';
require 'left.php';

if ($_REQUEST["action"]=="exchange"){
$id =$_REQUEST["id"];
$gift=explode(",",$C_gift);
;
if(floor($M_fen)>=floor(splitx(splitx($C_gift,",",$id),"@",0))){
mysqli_query($conn,"update SL_member set M_fen=M_fen-".splitx(splitx($C_gift,",",$id),"@",0)." where M_id=".$_SESSION["M_id"]);
mysqli_query($conn,"insert into SL_list(L_title,L_mid,L_change,L_time,L_type,L_no,L_sh) values('兑换礼品 - ".splitx(splitx($C_gift,",",$id),"@",1)."',".$_SESSION["M_id"].",-".splitx(splitx($C_gift,",",$id),"@",0).",'".date('Y-m-d H:i:s')."',1,'".gen_key(20)."',1)");
box(lang("兑换成功！请主动联系客服人员领取礼品。/l/Success!"),"member_fenlist.php","success");
}else{
box(lang("积分不足！/l/error!"),"back","error");
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
    <script src="/assets/js/plugins/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <link rel="stylesheet" href="/assets/css/ie8.min.css">
    <script src="/assets/js/plugins/respond/respond.min.js"></script>
    <![endif]-->
	<script>
		var _ctxPath='';
	</script>    
</head>

<body class="body-index">

		<?php require 'top.php';?>
		
		<div class="container m_top_10">
		<ol class="breadcrumb">
				<li><i class="icon fa-home" aria-hidden="true"></i><a href="../">首页</a></li>
				<li>我的财富</li>
				<li class="active">
				兑换礼品
				</li>
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
		  <li ><a href="member_fenlist.php">积分明细</a></li>
		  <li ><a href="member_role.php">奖励规则</a></li>
		   <li class="active" ><a href="member_role.php">兑换礼品</a></li>

            
	     </ul>
	 </div>
	 <div class="col-sm-10 b-left">
					<div class="yto-box">
						<h5>兑换礼品规则</h5>
						<div class="panel panel-default">
							<div class="panel-heading">礼品</div>
							<div class="table-responsive">
								<table class="table table-bordered">
								 <thead>
									<tr>
										<th>礼品名称</th>
										<th>所需积分</th>
										<th>兑换</th>
										
									</tr>
									</thead>
									<tbody>
									
									
									
									<?php 
if ($C_gift!=""){
$gift=explode(",",$C_gift);
For($j = 0 ;$j< count($gift);$j++){
echo "<tr ><td>".splitx($gift[$j],"@",1)."</td><td>".splitx($gift[$j],"@",0)."</td><td><a href='?action=exchange&id=".$j."'><div class='yto-vip-progress'><span class='badge'>兑换</span></div></a></td></tr>";
}
}
									?>
									</tbody>
								</table>
								
					</div>
				</div>
				
				说明：消耗积分后，会员等级会随之变化。
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
	
</body>
</html>