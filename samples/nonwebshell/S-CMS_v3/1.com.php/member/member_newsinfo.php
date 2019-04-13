<?php 
require '../conn/conn2.php';
require '../conn/function.php';
require 'auto.php';
require 'member_check.php';
require 'left.php';

$action=$_GET["action"];
$N_id=intval($_GET["N_id"]);
if($N_id!=""){
$aa="edit&N_id=".$N_id;
$sql="Select * from SL_news where N_id=".$N_id;

		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		if (mysqli_num_rows($result) > 0) {
		$N_title=lang($row["N_title"]);
		$N_view=$row["N_view"];
		$N_content=lang($row["N_content"]);
		$N_short=$row["N_short"];
		$N_pic=$row["N_pic"];
		$N_sort=$row["N_sort"];
		$N_date=$row["N_date"];
		$N_top=$row["N_top"];
		}
		}else{
$aa="add";
$N_date=date('Y-m-d H:i:s');
}
$N_author=$_SESSION["M_login"];
if($action=="add"){
ready(plug("x4","1"));
}
if($action=="edit"){
ready(plug("x4","2"));
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
				我要投稿
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
		 <li class="active"><a href="member_newsinfo.php">我要投稿</a></li>
	        <li ><a href="member_news.php?type=0">已通过</a></li>
            <li ><a href="member_news.php?type=1">未通过</a></li>
			<li ><a href="member_news.php?type=2">未审核</a></li>
            
	     </ul>
	 </div>
	 <div class="col-sm-10 b-left">
		<p class="alert alert-danger hidden" role="alert" id="error"></p>
<form id="userinfo_save" method="POST" action="?action=<?php echo $aa?>" class="form-horizontal" id="form">
                           
							<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("文章标题/l/title")?></label>
								<div class="col-sm-10">
								   <input name="N_title"  value="<?php echo $N_title?>" title="nickname" class="form-control" >
								</div>
							</div>
														<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("文章作者/l/author")?></label>
								<div class="col-sm-10">
								   <input maxlength="15" value="<?php echo $N_author?>" title="nickname" class="form-control" readonly >
								   <input name="N_author" value="<?php echo $N_author?>" title="nickname" class="form-control"  type="hidden">
								</div>
							</div>
														<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("发布时间/l/time")?></label>
								<div class="col-sm-10">
								   <input name="N_date"  value="<?php echo $N_date?>" title="nickname" class="form-control" >
								</div>
							</div>
														<div class="form-group">
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("文章内容/l/content")?></label>
								<div class="col-sm-10">
								   <textarea name='N_content' style='width:100%;height:350px;' id='content'><?php echo $N_content?></textarea>
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
								<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("新闻分类/l/Category")?></label>
								<div class="col-sm-10">
								   <select name="N_sort">
			<?php 
				$sql1="Select S_title,S_id from SL_nsort where S_del=0 and not S_sub=0 and S_tg=1";
				$result1 = mysqli_query($conn,  $sql1);
				if (mysqli_num_rows($result1) > 0) {
				while($row1 = mysqli_fetch_assoc($result1)) {
			?>
				<option value="<?php echo $row1["S_id"]?>" <?php if ($row1["S_id"]-$N_sort=0){ ?>selected="selected"<?php }?>><?php echo lang($row1["S_title"])?></option>
			<?php 

				}
			}

			?>
			  </select>
								</div>
							</div>
														
							<div class="form-group">
								<div class="col-sm-offset-2  col-sm-4">
								   <input type="submit" value="<?php echo lang("确定/l/Edit")?>" class="btn btn-primary btn-block m_top_20" >
								</div>
							</div>
</form>
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