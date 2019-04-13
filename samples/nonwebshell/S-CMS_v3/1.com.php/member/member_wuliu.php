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
				<li>查询物流</li>

			</ol>
					<div class="yto-box">
						<h5><?php echo lang("查询物流/l/Check Logistics")?></h5>
						<?php 
$O_id=trim(urlencode($_REQUEST["O_id"]));
$sql="select * from SL_orders where O_id=".$O_id."";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$O_wl=$row["O_wl"];
$O_wlid=$row["O_wlid"];
if($O_id!=""){
?>

<p><?php echo lang("物流公司/l/Logistics company")?>：<?php echo splitx($O_wl,"|",0)?></p>
<p><?php echo lang("运单号/l/Waybill number")?>：<?php echo $O_wlid?></p>

<?php }?>

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

	</div>
	
		<?php require 'foot.php';?>

	<!-- js plugins  -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/icheck.min.js"></script>
	<script src="js/page.js"></script>
	
</body>
</html>