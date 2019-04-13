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
				<li>表单管理</li>

			</ol>
					<div class="yto-box">
						
						<div class="panel panel-default">
							<div class="panel-heading">表单管理</div>
							<div class="table-responsive">
								<?php 
$sql2 = "select distinct(F_id) from SL_content,SL_form,SL_response where R_cid=C_id and C_fid=F_id and R_member=" . $_SESSION["M_id"] . " order by F_id";
$result2 = mysqli_query($conn, $sql2);
if (mysqli_num_rows($result2) > 0) {
    while ($row2 = mysqli_fetch_assoc($result2)) {
        $F_id = $row2["F_id"];
        $line = $line . "<table class=\"table\" style=\"font-size: 12px;\"><tr bgcolor='#f7f7f7'><td>" . lang("会员/l/Member") . "</td>";
        $sql = "select * from SL_content where C_Fid=" . $F_id . " order by C_order";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $line = $line . "<td>" . lang($row["C_title"]) . "</td>";
            }
        }
        $line = $line . "<td>" . lang("提交时间/l/Time") . "</td><td>" . lang("审核/l/Time") . "</td></tr>";
        $sql = "select distinct(R_rid),R_time,R_read,R_member from SL_response,SL_content where R_Cid=C_id and C_fid=" . $F_id . " and R_member=" . $_SESSION["M_id"] . " order by R_time";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $R_member = lang("未登录/l/Not logged");
                if ($row["R_member"] != "") {
                    $R_member = $_SESSION["M_login"];
                }
                $line = $line . "<tr ><td>" . $R_member . "</td>";
                $sql1 = "select * from SL_response,SL_content where R_Cid=C_id and C_fid=" . $F_id . " and R_rid like '" . $row["R_rid"] . "' order by C_order";
                $result1 = mysqli_query($conn, $sql1);
                if (mysqli_num_rows($result1) > 0) {
                    while ($row1 = mysqli_fetch_assoc($result1)) {
                        if (substr($row1["R_content"], -3) == "jpg" || substr($row1["R_content"], -3) == "png" || substr($row1["R_content"], -3) == "gif") {
                            $R_content = "<a href='../media/" . $row1["R_content"] . "' target='_blank'><img src='../media/" . $row1["R_content"] . "' height='30'> " . lang("点击查看大图/l/Click to enlarge") . "</a>";
                        } else {
                            if (substr($row1["R_content"], -3) == "doc" || substr($row1["R_content"], -3) == "pdf" || substr($row1["R_content"], -3) == "ppf" || substr($row1["R_content"], -3) == "rar") {
                                $R_content = "<a href='../media/" . $row1["R_content"] . "' target='_blank'><img src='img/file.gif'> " . lang("点击查看附件/l/Click to view attachments") . "</a>";
                            } else {
                                $R_content = $row1["R_content"];
                            }
                        }
                        $line = $line . "<td>" . $R_content . "</td>";
                    }
                }
                if ($row["R_read"] == 1) {
                    $read_info = "已审核";
                } else {
                    $read_info = "未审核";
                }
                $line = $line . "<td>" . $row["R_time"] . "</td><td>" . $read_info . "</td></tr>";
            }
        }
        $line = $line . "</table>";
    }
}
echo $line;
?>
</table>
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