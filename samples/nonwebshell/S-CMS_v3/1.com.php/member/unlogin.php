<?php
require '../conn/conn2.php';
require '../conn/function.php';

$P_id=intval($_REQUEST["P_id"]);
$no=intval($_POST["no"]);
$action=$_GET["action"];


if($action=="submit"){

	$O_id=intval($_GET["O_id"]);

	$name=$_POST["name"];
	$email=$_POST["email"];
	$mobile=$_POST["mobile"];
	$address=$_POST["address"];
	$postcode=$_POST["postcode"];
	$qq=$_POST["qq"];
	$remark=$_POST["remark"];

	mysqli_query($conn,"update SL_member set M_name='".$name."',M_email='".$email."',M_mobile='".$mobile."',M_add='".$address."',M_code='".$postcode."',M_qq='".$qq."' where M_id=".$_SESSION["M_id"]);//完善临时会员信息
	mysqli_query($conn,"update SL_orders set O_remark='".$remark."' where O_id=".$O_id);//为订单增加备注

	Header("Location: " . $C_dir."member/member_pay.php?O_id=".$O_id);
	die();

}


$sql="select * from SL_product where P_id=".$P_id; //读取产品信息
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$P_title=lang($row["P_title"]);
$P_price=$row["P_price"];
$P_path=$row["P_path"];
$P_rest=$row["P_rest"];
$P_shuxing=$row["P_shuxing"];

$P_name=$row["P_name"];
$P_email=$row["P_email"];
$P_address=$row["P_address"];
$P_mobile=$row["P_mobile"];
$P_postcode=$row["P_postcode"];
$P_qq=$row["P_qq"];

$P_remark=$row["P_remark"];
$P_sence=$row["P_sence"];
$P_sell=$row["P_sell"];

}
$sp=0;
foreach ($_POST as $x=>$value) {
if(splitx($x,"_",0)=="scvvvvv"){
$sc=$sc.splitx(splitx(splitx($P_shuxing,"@",splitx($x,"_",1)),"_",1),"|",$_POST[$x])."|";
$sp=$sp+splitx(splitx(splitx($P_shuxing,"@",splitx($x,"_",1)),"_",2),"|",$_POST[$x]);
}
}
$sc=substr($sc,0,strlen($sc)-1);
if($sc==""){
$sc="标配";
}

$O_shuxing=explode("|",$sc);
for ($j=0 ;$j< count($O_shuxing);$j++){
$shuxing=$shuxing.lang($O_shuxing[$j])." ";
}

$price=$P_price+$sp;
$money=round($no*$price,2);


if($_SESSION["M_login"]==""){
	$sql="Select count(*) as M_count from SL_member";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $M_count=$row["M_count"];

	$genkey=dec62($M_count+1);
	mysqli_query($conn,"insert into SL_member(M_login,M_pwd,M_email,M_fen,M_pic,M_regtime,M_from,M_need) values('临时用户".$genkey."','".strtoupper(md5($genkey))."','',0,'member.jpg','".date('Y-m-d H:i:s')."',0,'')");

	$sql="Select * from SL_member order by M_id desc limit 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $M_id=$row["M_id"];
    uplevel($M_id);

	$_SESSION["M_login"]="临时用户".$genkey;
	$_SESSION["M_pwd"]=strtoupper(md5($genkey));
	$_SESSION["M_vip"]=0;
	$_SESSION["M_id"]=$M_id;

	mysqli_query($conn,"insert into SL_orders(O_member,O_price,O_num,O_shuxing,O_state,O_pid,O_time,O_no) values(".$_SESSION["M_id"].",".round($price,2).",".$no.",'".$sc."',0,".$P_id.",'".date('Y-m-d H:i:s')."','".date("YmdHis").gen_key(5)."')");

	$sql="Select * from SL_orders order by O_id desc limit 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $O_id=$row["O_id"];

}else{

	$M_lv=getrs("select * from SL_member where M_id=".$_SESSION["M_id"],"M_lv");
	$L_discount=getrs("select * from SL_lv where L_id=".$M_lv,"L_discount");
	mysqli_query($conn,"Insert into SL_orders(O_member,O_price,O_num,O_shuxing,O_state,O_pid,O_time,O_no) values(".$_SESSION["M_id"].",".round($price*$L_discount*0.01,2).",".$no.",'".$sc."',0,".$P_id.",'".date('Y-m-d H:i:s')."','".date("YmdHis").gen_key(5)."')");
	$sql="select * from SL_orders order by O_id desc limit 1";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$O_id=$row["O_id"];

	$sql="Select * from SL_member,SL_lv Where M_lv=L_id and M_id=".$_SESSION["M_id"];
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
		$M_name=$row["M_name"];
		$M_code=$row["M_code"];
		$M_email=$row["M_email"];
		$M_qq=$row["M_QQ"];
		$M_add=$row["M_add"];
		$M_mobile=$row["M_mobile"];

	if($M_name!="" && $M_code!="" && $M_email!="" && $M_qq!="" && $M_add!="" && $M_mobile!=""){ 
		Header("Location: " . $C_dir."member/member_pay.php?O_id=".$O_id);
	}
}


$sql="Select * from SL_slide order by S_id desc limit 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) > 0) {
    if ($C_memberbg=="" || is_null($C_memberbg)){
        $S_pic=$row["S_pic"];
    }else{
        $S_pic=$C_memberbg;
    }
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo lang($C_description)?>">
    <meta name="author" content="s-cms">
    <title><?php echo lang("购买产品/l/search")?> - <?php echo lang($C_webtitle)?></title>
    <link href="<?php echo $C_dir.$C_ico?>" rel="shortcut icon" />
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="../css/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <style type="text/css">  
    .navbar .nav > li .dropdown-menu {  
        margin: 0;  
    }  
    .navbar .nav > li:hover .dropdown-menu {  
        display: block;  
    }  
    .search_pic{padding:5px;border:#CCCCCC solid 1px;width:100%;max-width:150px;min-width:100px;}
    table{width: 100%;}
    .search_area{background: #FFFFFF;margin: 100px 0 70px 0;border:2px #EEEEEE solid; border-radius: 10px;padding: 20px;font-size: 14px;}
    .search_area .list{padding: 10px;}
    .search_area td{padding: 10px;}
    .bg1{position:fixed; z-index:-1;filter: blur(5px);background-image:url(../<?php echo $S_pic?>);background-repeat: no-repeat;background-position:center center;width:100%;height:100%;background-size: cover;}
    .bg2{position:fixed; z-index:-2;background-image:url(../<?php echo $S_pic?>);background-repeat: no-repeat;background-position:center center;width:100%;height:100%;background-size: cover;}
.col-sm-10 p{margin-top:10px}
</style>
</head>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top s_top" role="navigation">
    <div class="s_head" style="padding-top:4px;">
    <div class="container">
    <div class="pull-left">
    <span style="font-size: 12px;"><?php echo lang($C_webtitle)?></span>
    </div>


    <div class="pull-right">
    <?php 
    if($C_member==1){
    if ($_SESSION["M_login"]==""){
        ?>
    <a href="member_reg.php"><?php echo lang("注册/l/Sign Up")?></a> <a href="member_login.php"><?php echo lang("登录/l/Sign In")?></a>
    <?php
}else{
    ?>
    <a href="index.php"><?php echo $_SESSION["M_login"]?></a> <a href="member_login.php?action=unlogin"><?php echo lang("退出/l/Sign Out")?></a>
    <?php }
}
    ?>
    </div>


    </div>
    </div>
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="../"><img src="../<?php echo $C_logo?>" height="60"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<ul class="nav navbar-nav navbar-right">

    <?php
$sql="select * from SL_menu where U_sub=0 and U_hide=0 order by U_order,U_id desc";
$result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
        echo "<li ><a href=\"../?type=".$row["U_type"]."&S_id=".$row["U_typeid"]."\" >".lang($row["U_title"])." </a>";
        $sql2="select * from SL_menu where U_sub=".$row["U_id"]." and U_hide=0 order by U_order,U_id desc";
        $result2 = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($result2) > 0) {
            echo "<ul class=\"dropdown-menu\">";
            while($row2 = mysqli_fetch_assoc($result2)) {
                echo "<li><a href=\"../?type=".$row2["U_type"]."&S_id=".$row2["U_typeid"]."\">".lang($row2["U_title"])."</a></li>";
            }
            echo "</ul>";
        }
        echo "</li>";
    }
}
    ?>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

<nav class="navbar navbar-inverse navbar-fixed-bottom s_top" role="navigation">
    
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                
                <p style="margin:20px 0 0 10px; "><?php echo lang($C_foot).$C_code?></p>

            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Header Carousel -->
<div style="height: 100%;position: relative;">
<div class="bg1"></div>
<div class="bg2"></div>

    <!-- Page Content -->
<div class="container" style="z-index: 9999">
<div class="search_area">
<?php

echo "<form class=\"form-horizontal\" action=\"?action=submit&O_id=".$O_id."\" method=\"post\">";
echo "<div class=\"form-group\"><label for=\"firstname\" class=\"col-sm-2 control-label\"></label><div class=\"col-sm-10\">您正在使用免登录购物功能，请正确填写收货信息</div></div>";

if($P_name==1){
	echo "<div class=\"form-group\"><label for=\"firstname\" class=\"col-sm-2 control-label\">您的姓名</label><div class=\"col-sm-10\"><input type=\"text\" placeholder=\"您的姓名\" class=\"form-control\" name=\"name\" required></div></div>";
}

if($P_email==1){
	echo "<div class=\"form-group\"><label for=\"firstname\" class=\"col-sm-2 control-label\">电子邮箱</label><div class=\"col-sm-10\"><input type=\"text\" placeholder=\"电子邮箱\" class=\"form-control\" name=\"email\" required></div></div>";
}

if($P_address==1){
	echo "<div class=\"form-group\"><label for=\"firstname\" class=\"col-sm-2 control-label\">收件地址</label><div class=\"col-sm-10\"><input type=\"text\" placeholder=\"收件地址\" class=\"form-control\" name=\"address\" required></div></div>";
}

if($P_mobile==1){
	echo "<div class=\"form-group\"><label for=\"firstname\" class=\"col-sm-2 control-label\">手机号码</label><div class=\"col-sm-10\"><input type=\"text\" placeholder=\"手机号码\" class=\"form-control\" name=\"mobile\" required></div></div>";
}

if($P_postcode==1){
	echo "<div class=\"form-group\"><label for=\"firstname\" class=\"col-sm-2 control-label\">邮政编码</label><div class=\"col-sm-10\"><input type=\"text\" placeholder=\"邮政编码\" class=\"form-control\" name=\"postcode\" required></div></div>";
}

if($P_qq==1){
	echo "<div class=\"form-group\"><label for=\"firstname\" class=\"col-sm-2 control-label\">QQ号码</label><div class=\"col-sm-10\"><input type=\"text\" placeholder=\"QQ号码\" class=\"form-control\" name=\"qq\" required></div></div>";
}

if($P_remark==1){
	echo "<div class=\"form-group\"><label for=\"firstname\" class=\"col-sm-2 control-label\">备注留言</label><div class=\"col-sm-10\"><input type=\"text\" placeholder=\"备注留言\" class=\"form-control\" name=\"remark\" required></div></div>";
}

?>

<div class="form-group">
	<label for="firstname" class="col-sm-2 control-label"></label><div class="col-sm-10">
<div style="background: #f7f7f7;min-height: 110px;">
<div class="col-sm-2">
	<img src="../<?php echo splitx(splitx($P_path,"|",0),"_",0)?>" style="margin-top: 10px;height: 90px;">
</div>
<div class="col-sm-10">
	<p>购买产品：<?php echo $P_title?></p>
	<p>产品属性：<?php echo $shuxing?></p>
	<p>应付金额：<span style="font-size: 20px;color: #ff0000"><?php echo $money?>元</span></p>
</div>
</div>
</div></div>

<div class="form-group">
	<label for="firstname" class="col-sm-2 control-label"></label><div class="col-sm-10">
<button type="submit" class="btn btn-info">提交订单</button>
</div></div>

</form>
</div>
    </div>
    </div>
</body>

</html>