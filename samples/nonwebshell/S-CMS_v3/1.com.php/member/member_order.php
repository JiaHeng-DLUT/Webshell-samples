<?php 
require '../conn/conn2.php';
require '../conn/function.php';
require 'auto.php';
require 'member_check.php';
require 'left.php';

$action=$_GET["action"];
$O_id=intval($_GET["O_id"]);
$O_no=$_GET["O_no"];
$typex=$_GET["type"];

if($typex!=""){
$state="and O_state=".intval($typex);
}else{
$state="";
}

if($action=="del"){
mysqli_query($conn,"delete from SL_orders where O_id=".$O_id);
die();
}

if($action=="confirm"){
$sql="select * from SL_orders,SL_product where O_pid=P_id and O_no='".$O_no."'";

		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		if (mysqli_num_rows($result) > 0) {
			$P_title=$row["P_title"];
			$O_num=$row["O_num"];
			$O_shuxing=$row["O_shuxing"];
			$O_price=$row["O_price"];
		}

sendmail("您的网站有订单已确认","<h2>您的网站“".$C_webtitle."”有订单已确认</h2><hr>商品名称：".$P_title."<br>数量：".$O_num."<br>属性：".$O_shuxing."<br>价格：".round($O_num*$O_price,2)."元<hr>请进入“网站后台” - “商城管理” - “订单管理”查看详情！",$C_email);
mysqli_query($conn,"update SL_orders set O_state=3 where O_no='".$O_no."'");
die();
}

if($action=="refund"){
mysqli_query($conn,"update SL_orders set O_state=4 where O_no='".$O_no."'");
$sql="select * from SL_orders,SL_product where O_pid=P_id and O_no='".$O_id."'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		if (mysqli_num_rows($result) > 0) {
			$P_title=$row["P_title"];
			$O_num=$row["O_num"];
			$O_shuxing=$row["O_shuxing"];
			$O_price=$row["O_price"];
		}
sendmail("您的网站有退款待处理","<h2>您的网站“".$C_webtitle."”有退款待处理</h2><hr>商品名称：".$P_title."<br>数量：".$O_num."<br>属性：".$O_shuxing."<br>价格：".round($O_num*$O_price,2)."元<hr>请进入“网站后台” - “商城管理” - “订单管理”查看详情！",$C_email);
die();
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
  <link rel="stylesheet" href="css/cropper.min.css">
  <link rel="stylesheet" href="../css/sweetalert.css">
<style>
td{vertical-align:middle;}
</style>
 
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
				<li>
				<?php if ($typex!="") {?>
				购物车
				<?php }else{?>
				我的订单
				<?php }?>
				</li>

			</ol>

<?php if ($typex=="") {?>

<div class="yto-box">
						
						<div class="panel panel-default">
							<div class="panel-heading">我的订单</div>
							<div class="table-responsive">
								<table class="table table-condensed" style="font-size: 12px;">
								 <thead>
									<tr>
										<th width="55%"><?php echo lang("商品信息/l/Product title")?></th>
										<th width="15%"><?php echo lang("总价/l/Total")?></th>
										<th width="15%"><?php echo lang("状态/l/state")?></th>
										<th width="15%"><?php echo lang("操作/l/operation")?></th>
									</tr>
									</thead>
									<tbody>
									<?php 

		$sql="select * from SL_orders,SL_product,SL_lv,SL_member where M_lv=L_id and O_member=M_id and O_pid=P_id and O_member=".$M_id." group by O_no order by O_id desc";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {

$i=0;
$sql2="select * from SL_orders,SL_product,SL_lv,SL_member where M_lv=L_id and O_member=M_id and O_pid=P_id and O_member=".$M_id." and O_no='".$row["O_no"]."' order by O_id desc";
		$result2 = mysqli_query($conn, $sql2);
		if (mysqli_num_rows($result2) > 0) {
		while($row2 = mysqli_fetch_assoc($result2)) {
			if($i>0){
				$border="padding-top:10px;border-top: dashed 1px #dddddd;";
			}else{
				$border="";
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

			$P_list=$P_list."<div style='".$border."'><img src='../".splitx(splitx($row2["P_path"],"|",0),"__",0)."' style='height: 70px; display: inline-block;vertical-align:text-top;' alt=''><div style='display: inline-block;vertical-align:text-top;margin-left: 10px;'><p style='width: 200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;'><b><a href='../?type=productinfo&S_id=".$row2["P_id"]."' target='_blank' class='ng-binding'>".lang($row2["P_title"])."</a></b></p><p><b>属性：</b>".$O_shuxing."</p><p>".$row2["O_price"]."元 × ".$row2["O_num"]."件 </p><input type='hidden' name='O_id[]' value='".$row2["O_id"]."'></div></div>";
			$shuxing="";
			$money=$money+($row2["O_price"]*$row2["O_num"]);
			$i=$i+1;
		}
	}


		if ($row["O_state"]==0){
		$O_state=lang("未付款/l/No payment");
		$O_pay="<button class='btn btn-xs btn-primary' type='button' onclick=\"$('#".$row["O_no"]."').submit();\">前往支付</button>";
		}
		if ($row["O_state"]==1){
		$O_state=lang("已付款/l/Already paid");
		$O_pay=lang("请等待发货/l/Please wait for delivery");
		}
		if ($row["O_state"]==2){
		$O_state=lang("已发货/l/Already shipped");
		$O_pay="<a href='javascript:;' onclick=\"confirmx('".$row["O_no"]."')\" class='btn btn-xs btn-success'>".lang("确认收货/l/Confirmation")."</a> <a href='javascript:;' onclick=\"refund('".$row["O_no"]."')\"  class='btn btn-xs btn-danger'>".lang("申请退款/l/Refund")."</a>";
		}
		if ($row["O_state"]==3){
		$O_state=lang("已确认/l/confirmed");
		$O_pay=lang("已确认/l/confirmed");
		}
		if ($row["O_state"]==4){
		$O_state=lang("已申请退款/l/Has applied for a refund");
		$O_pay=lang("等待卖家处理/l/Waiting for the seller to deal with");
		}
		if ($row["O_state"]==5){
		$O_state=lang("已退款/l/Refunded");
		$O_pay=lang("交易结束/l/end of transaction");
		}

		if($row["O_state"]>0){
			$tradeno="<b>交易号</b>：".$row["O_tradeno"];
		}else{
			$tradeno="";
		}

		echo "<tr><td colspan='4' style='background:#f7f7f7'><div style=''><span style='width:300px;display:inline-block'><b>订单号</b>：".$row["O_no"]." </span>".$tradeno."</div></td></tr><tr><td><form id='".$row["O_no"]."' method='post' action='member_pay.php' style='margin-top:10px;'>".$P_list."</form></td><td ><p style='color:#ff0000;'>总价：".round($money,2).lang("元/l/yuan")."</p><p>邮费：".$row["O_postage"]."元</p></td><td><p>".$O_state."</p></td><td><p>".$O_pay."</p><p><a href='OK.php?O_no=".$row["O_no"]."' class='btn btn-warning btn-xs'>订单详情</a></p></td></tr>";
		$P_list="";

		$money=0;

		}
}

?>
									</tbody>
								</table>
					</div>

				</div>
			</div>


<?php }?>


<?php if ($typex!="") {?>
<form action="member_pay.php" method="post">
					<div class="yto-box">
						<div class="panel panel-default">
							<div class="panel-heading">
								购物车
	 </div>
							<div class="table-responsive">
								<table class="table table-condensed" style="font-size: 12px;">
								 <thead>
									<tr>

										<th><?php echo lang("图片/l/PIc")?></th>
										<th></th>
										<th><?php echo lang("总价/l/Total")?></th>

										<th><?php echo lang("移除/l/delete")?></th>
									</tr>
									</thead>
									<tbody>
									<?php 
									$sql="select * from SL_orders,SL_product,SL_lv,SL_member where M_lv=L_id and O_member=M_id and O_pid=P_id and O_member=".$M_id." ".$state." order by O_id desc";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {

		$moneyx=$moneyx+$row["O_num"]*$row["O_price"];

		if($row["O_shuxing"]==""){
			$O_shuxings="标配";
		}else{
			$O_shuxings=$row["O_shuxing"];
		}
		$O_shuxing=explode("|",$O_shuxings);
		for ($j=0;$j< count($O_shuxing);$j++){
			$shuxing=$shuxing.lang($O_shuxing[$j])." ";
		}
		$O_shuxing=$shuxing;

		echo "<tr id='item_".$row["O_id"]."'><td><a href='".$C_dir."index.php?type=productinfo&S_id=".$row["P_id"]."' target='_blank'><img src='".$C_dir.splitx(splitx($row["P_path"],"|",0),"__",0)."' height='70'></a></td><td><p><b>".mb_substr(lang($row["P_title"]),0,24,"utf-8")."</b><input type='hidden' name='O_id[]' value='".$row["O_id"]."'></p><p>属性：".$O_shuxing."</p><p>".round($row["O_price"],2).lang("元/l/yuan")."×".$row["O_num"]."</p></td><td><p style='color:#ff0000;'>".round($row["O_num"]*$row["O_price"],2).lang("元/l/yuan")."</p></td><td><a href='javascript:;' onclick='del(".$row["O_id"].")' class='btn btn-xs btn-warning'><i class='fa fa-times-circle'></i> ".lang("移除/l/delete")."</td></tr>";
				$shuxing="";
		}
}
?>
									</tbody>
								</table>
					</div>

				</div>
				<div class="pull-right">
					<p style="font-size: 15px; font-weight: bold;color: #FF0000">总价：<?php echo round($moneyx,2)?>元</p>
					<input type="submit" value="全部支付" class="btn btn-primary btn-block m_top_20">
					</div>
			</div>
		<?php }?>
		</div>
	</div>
	</form>
		<?php require 'foot.php';?>

	<!-- js plugins  -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/icheck.min.js"></script>
	<script src="js/page.js"></script>
	<script src="../js/sweetalert.min.js"></script>
		<script>
	function del(id) {
    swal({
        title: "",
        text: "确定要从购物车移除吗？",
        type: "warning",
        showCancelButton: true
    },
    function() {
        $.get("member_order.php?action=del&O_id=" + id,
        function(data, status) {
            $("#item_" + id).hide();
        });
    });
}

function confirmx(id) {
    swal({
        title: "",
        text: "要确认收货吗？",
        type: "warning",
        showCancelButton: true
    },
    function() {
        $.ajax({
            url: "member_order.php?action=confirm&O_no=" + id,
            type: "DELETE"
        }).done(function(data) {
            swal({
                title: "",
                text: "已确认收货！",
                type: "success",
            },
            function() {
                location.reload()
            })
        }).error(function(data) {
            swal("", "操作失败了!", "error");
        });

    });
}

function refund(id) {
    swal({
        title: "",
        text: "确定要申请退款吗？",
        type: "warning",
        showCancelButton: true
    },
    function() {

        $.ajax({
            url: "member_order.php?action=refund&O_no=" + id,
            type: "DELETE"
        }).done(function(data) {
            swal({
                title: "",
                text: "已提交退款申请！",
                type: "success",
            },
            function() {
                location.reload()
            })
        }).error(function(data) {
            swal("", "操作失败了!", "error");
        });

    });
}
	</script>
</body>
</html>