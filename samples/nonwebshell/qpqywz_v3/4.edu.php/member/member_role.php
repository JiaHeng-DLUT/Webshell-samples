<?php 
require '../conn/conn2.php';
require '../conn/function.php';
require 'auto.php';
require 'member_check.php';
require 'left.php';
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
				奖励规则
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
		   <li class="active" ><a href="member_role.php">奖励规则</a></li>
<?php if ($C_gifton==1){?><li ><a href="member_gift.php">兑换礼品</a></li><?php }?>
            
	     </ul>
	 </div>
	 <div class="col-sm-10 b-left">
					<div class="yto-box">
						<h5>积分奖励规则</h5>
						<div class="panel panel-default">
							<div class="panel-heading">等级</div>
							<div class="table-responsive">
								<table class="table table-bordered">
								 <thead>
									<tr>
										<th>等级名称</th>
										<th>享受折扣（原价×百分比）</th>
										<th>所需积分</th>
										
									</tr>
									</thead>
									<tbody>
									<?php 
									$sql="select * from SL_lv  order by L_order,L_id";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
		echo "<tr ><td><div class='yto-vip-progress'><span class='badge'>".lang($row["L_title"])."</span></div></td><td>".$row["L_discount"]." %</td><td>".$row["L_fen"]." 分</td></tr>";
				}
	}
									?>
									</tbody>
								</table>
					</div>
				</div>
				
				<div class="panel panel-default">
							<div class="panel-heading">奖励规则</div>
							<div class="table-responsive">
								<table class="table table-bordered">
								 <thead>
									<tr>
										<th></th>
										<th>事件</th>
										<th>积分奖励</th>
										
									</tr>
									</thead>
									<tbody>
<?php if($C_1yuan!=0){?>
<tr><td>1</td><td>每消费1元</td><td>+<?php echo $C_1yuan?></td></tr>
<?php }?>

<?php if ($C_data!=0){?>
<tr><td>2</td><td>完善资料</td><td>+<?php echo $C_data?></td></tr>
<?php }?>

<?php if ($C_sign!=0){?>
<tr><td>3</td><td>每日签到</td><td>+<?php echo $C_sign?></td></tr>
<?php }?>

<?php if ($C_Invitation!=0){?>
<tr><td>4</td><td>邀请好友注册</td><td>+<?php echo $C_Invitation?></td></tr>
<?php }?>

<?php if ($C_1yuan2!=0){?>
<tr><td>5</td><td>邀请好友消费1元</td><td>+<?php echo $C_1yuan2?></td></tr>
<?php }?>

									</tbody>
								</table>
					</div>
				</div>
				<?php if ($C_Invitation!=0 || $C_1yuan2!=0){ ?>我的邀请链接：<u><?php echo gethttp().splitx($_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"],"/member",0)?>/member/member_reg.php?uid=<?php echo $M_id?></u> 复制给发送给好友吧！<?php }?>
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