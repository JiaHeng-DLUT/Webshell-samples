<?php 
require '../conn/conn2.php';
require '../conn/function.php';
require 'auto.php';
require 'member_check.php';
require 'left.php';

$N_type=$_REQUEST["type"];
if($N_type==""){
$N_type=0;
}
$action=$_GET["action"];
$N_id=intval($_GET["N_id"]);
if($action=="del"){
mysqli_query($conn,"delete from SL_news where N_id=".$N_id);
box(lang("删除成功！/l/success"),"member_news.php","success");
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
				<li>文章投稿</li>
				<li class="active">
				<?php 
				switch($N_type){
				case 0:
				echo "已通过";
				case 1:
				echo "未通过";
				case 2:
				echo "未审核";
				}
				?>
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
		 <li ><a href="member_newsinfo.php">我要投稿</a></li>
	        <li class="<?php if ($N_type==0){ ?>active<?php }?>"><a href="?type=0">已通过</a></li>
            <li class="<?php if ($N_type==1){ ?>active<?php }?>"><a href="?type=1">未通过</a></li>
			<li class="<?php if ($N_type==2){ ?>active<?php }?>"><a href="?type=2">未审核</a></li>
            
	     </ul>
	 </div>
	 <div class="col-sm-10 b-left">
<div class="yto-box">
						<div class="panel panel-default">
							<div class="panel-heading">我的投稿</div>
							<div class="table-responsive">
								<table class="table table-condensed" style="font-size: 12px;">
								 <thead>
									<tr>
										<th><?php echo lang("文章标题/l/Title")?></th>
										<th><?php echo lang("投稿时间/l/Time")?></th>
										<th><?php echo lang("文章分类/l/Category")?></th>
										<th><?php echo lang("审核/l/review")?></th>
										<th><?php echo lang("编辑/l/edit")?></th>
										<th><?php echo lang("删除/l/delete")?></th>
									</tr>
									</thead>
									<tbody>
									<?php 
		$sql="select * from SL_news,SL_nsort where S_del=0 and N_del=0 and N_sort=S_id and N_author='".$M_login."'  and N_sh=".intval($N_type)." order by N_id desc";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
		if ($row["N_sh"]==0){
		$sh_info="<font color='#009900'>".lang("已通过/l/Already passed")."</font>";
		}
		if ($row["N_sh"]==1){
		$sh_info="<font color='#ff0000'>".lang("未通过/l/not passed")."</font>";
		}
		if ($row["N_sh"]==2){
		$sh_info="<font color='#ff9900'>".lang("未审核/l/Not audited")."</font>";
		}
		
		echo "<tr><td>".lang($row["N_title"])."</td><td>".$row["N_date"]."</td><td>".lang($row["S_title"])."</td><td>".$sh_info."</td><td><a href='member_newsinfo.php?N_id=".$row["N_id"]."' class='btn btn-xs btn-success'><i class='fa fa-pencil-square-o'></i> ".lang("编辑/l/edit")."</td><td><a href='member_news.php?action=del&N_id=".$row["N_id"]."' class='btn btn-xs btn-warning'><i class='fa fa-times-circle'></i> ".lang("删除/l/delete")."</td></a></tr>";
				}
}

?>
									</tbody>
								</table>
					</div>
				</div>
			</div>

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