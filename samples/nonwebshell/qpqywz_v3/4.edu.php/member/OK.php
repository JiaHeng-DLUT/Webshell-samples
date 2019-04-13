<?php 
require '../conn/conn2.php';
require '../conn/function.php';
require 'auto.php';
require 'member_check.php';
require 'left.php';

$O_no=trim($_GET["O_no"]);
$action=trim($_REQUEST["action"]);

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
  <link rel="stylesheet" href="css/cropper.min.css">

 
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
				<li>我的订单</li>

			</ol>
			<div class="yto-box">

						<div class="panel panel-default">
							<div class="panel-heading"><?php echo lang("订单详情/l/Contribute")?></div>
							<div class="table-responsive">
								<table class="table" style="font-size: 12px;">
								 <thead>
									<tr>
										<th><?php echo lang("商品名称/l/Title")?></th>
										<th><?php echo lang("总价/l/Time")?></th>
										<th><?php echo lang("状态/l/Category")?></th>
										<th><?php echo lang("交易号/l/review")?></th>

									</tr>
									</thead>
									<tbody>
									<?php 
$sql2="select * from SL_orders,SL_product,SL_lv,SL_member where M_lv=L_id and O_member=M_id and O_pid=P_id and O_member=".$M_id." and O_no='".$O_no."' order by O_id desc";
		$result2 = mysqli_query($conn, $sql2);
		if (mysqli_num_rows($result2) > 0) {
		while($row2 = mysqli_fetch_assoc($result2)) {

if ($row2["O_state"]==0){
		$O_state=lang("未付款/l/No payment");
		$O_pay="<button class='btn btn-xs btn-primary' type='button' onclick=\"$('#".$row["O_no"]."').submit();\">前往支付</button>";
		}
		if ($row2["O_state"]==1){
		$O_state=lang("已付款/l/Already paid");
		$O_pay=lang("请等待发货/l/Please wait for delivery");
		}
		if ($row2["O_state"]==2){
		$O_state=lang("已发货/l/Already shipped");
		$O_pay="<a href='javascript:;' onclick=\"confirmx('".$row["O_no"]."')\" class='btn btn-xs btn-success'>".lang("确认收货/l/Confirmation")."</a> <a href='javascript:;' onclick=\"refund('".$row["O_no"]."')\"  class='btn btn-xs btn-danger'>".lang("申请退款/l/Refund")."</a>";
		}
		if ($row2["O_state"]==3){
		$O_state=lang("已确认/l/confirmed");
		$O_pay=lang("已确认/l/confirmed");
		}
		if ($row2["O_state"]==4){
		$O_state=lang("已申请退款/l/Has applied for a refund");
		$O_pay=lang("等待卖家处理/l/Waiting for the seller to deal with");
		}
		if ($row2["O_state"]==5){
		$O_state=lang("已退款/l/Refunded");
		$O_pay=lang("交易结束/l/end of transaction");
		}


	if($row2["O_shuxing"]==""){
		$O_shuxings="标配";
	}else{
		$O_shuxings=$row2["O_shuxing"];
	}
	$O_shuxing=explode("|",$O_shuxings);
	for ($j=0;$j< count($O_shuxing);$j++){
		$shuxing=$shuxing.lang($O_shuxing[$j])." ";
	}
	$O_shuxing=$shuxing;

			echo "<tr><td><div><img src='../".splitx(splitx($row2["P_path"],"|",0),"__",0)."' style='height: 70px; display: inline-block;vertical-align:text-top;' alt=''><div style='display: inline-block;vertical-align:text-top;margin-left: 10px;'><p style='width: 200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;'><b><a href='../?type=productinfo&S_id=".$row2["P_id"]."' target='_blank' class='ng-binding'>".lang($row2["P_title"])."</a></b></p><p><b>属性：</b>".$O_shuxing."</p><p>".$row2["O_price"]."元 × ".$row2["O_num"]."件 </p></div></div></td><td>".$row2["O_price"]*$row2["O_num"]."元</td><td>".$O_state."</td><td><p>订单号：".$row2["O_no"]."</p><p>交易号：".$row2["O_tradeno"]."</p><p>时间：".$row2["O_time"]."</p></td></tr>";
			$shuxing="";

		}
	}
?>
									</tbody>
								</table>
					</div>
				</div>


<div class="panel panel-default">
<div class="panel-heading">收货信息</div>
<div class="panel-body">
<p>收件人：<?php echo $M_name?></p>
						<p>收件地址：<?php echo $M_add?></p>
						<p>联系方式：<?php echo $M_mobile?></p>
						<p>邮政编码：<?php echo $M_code?></p>
						<div class="col-sm-4">
<input name="button" type="button" class="btn btn-primary btn-block m_top_20"  value="修改信息" onClick="document.location.href='member_edit.php'" />
</div>
</div>
</div>

<?php 
$sql="select * from SL_orders where O_no='".$O_no."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$O_wl=$row["O_wl"];
$O_wlid=$row["O_wlid"];
if($O_wlid!=""){
?>


<div class="panel panel-default">
<div class="panel-heading">物流查询 <span class="pull-right"><?php echo lang("物流公司/l/Logistics company")."：<b>".splitx($O_wl,"|",0)."</b> ".lang("运单号/l/Waybill number")."：<b>".$O_wlid?></b></span></div>
<div class="table-responsive">
<table class="table table-striped">
<tr><td>时间</td><td>地点</td><td>操作</td></tr>
<?php 
$wl_info=GetBody("http://www.kuaidi100.com/query?type=".splitx($O_wl,"|",1)."&postid=".$O_wlid,"");
$wl_info =json_decode($wl_info);
for($i=0;$i<count($wl_info->data);$i++){
echo "<tr><td>".$wl_info->data[$i]->time."</td><td>".$wl_info->data[$i]->location."</td><td>".$wl_info->data[$i]->context."</td></tr>";
}

?>
</table>
</div>
</div>


<?php
}
?>

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