<?php 
require '../conn/conn2.php';
require '../conn/function.php';

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
    <title>论坛 - <?php echo lang($C_webtitle)?></title>
    <link href="<?php echo $C_dir.$C_ico?>" rel="shortcut icon" />
    <link href="../member/css/bootstrap.css" rel="stylesheet">
    <link href="../css/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../member/css/style.css" rel="stylesheet" type="text/css">
    <script src="../member/js/jquery.min.js"></script>
    <script src="../member/js/bootstrap.min.js"></script>
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
    <?php if ($_SESSION["M_login"]==""){?>
    <a href="../member/member_reg.php"><?php echo lang("注册/l/Sign Up")?></a> <a href="../member/member_login.php"><?php echo lang("登录/l/Sign In")?></a>
    <?php }else{?>
    <a href="../member"><?php echo $_SESSION["M_login"]?></a> <a href="../member/member_login.php?action=unlogin"><?php echo lang("退出/l/Sign Out")?></a>
    <?php }?>
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

$sql="select * from SL_menu where U_del=0 and U_sub=0 and U_hide=0 order by U_order,U_id desc";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      if($row["U_type"]!="link"){
        echo "<li><a href=\"../?type=".$row["U_type"]."&S_id=".$row["U_typeid"]."\" >".lang($row["U_title"])." </a>";
      }else{
        echo "<li><a href=\"".splitx($row["U_url"],"|",0)."\" target=\"".splitx($row["U_url"],"|",1)."\">".lang($row["U_title"])." </a>";
      }
    
    $sql2="select * from SL_menu where U_del=0 and U_sub=".$row["U_id"]." and U_hide=0 order by U_order,U_id desc";
    $result2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($result2) > 0) {
    echo "<ul class=\"dropdown-menu\">";
    while($row2 = mysqli_fetch_assoc($result2)) {

      if($row2["U_type"]!="link"){
        echo "<li><a href=\"../?type=".$row2["U_type"]."&S_id=".$row2["U_typeid"]."\">".lang($row2["U_title"])."</a></li>";
      }else{
        echo "<li><a href=\"".splitx($row2["U_url"],"|",0)."\" target=\"".splitx($row2["U_url"],"|",1)."\">".lang($row2["U_title"])." </a>";
      }

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
$sql="Select * from SL_bsort where S_del=0 and S_hide=0 order by S_order,S_id desc";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$S_sh=$row["S_sh"];
$S_lv=$row["S_lv"];

if($S_sh==1){
$sh_info="发帖限制：需要审核";
$sql2="Select count(*) as B_count from SL_bbs where B_del=0 and B_sort=".$row["S_id"]." and B_sh=1 and B_sub=0";
}else{
$sh_info="发帖限制：无需审核";
$sql2="Select count(*) as B_count from SL_bbs where B_del=0 and B_sort=".$row["S_id"]." and B_sub=0";
}
if($S_lv==0){
$lv_info="浏览权限：游客";
}else{
$lv_info="浏览权限：".getrs("select * from SL_lv where L_id=".$S_lv,"L_title");
}

$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
$B_count=$row2["B_count"];
if($S_sh==0){
$sql2="Select count(*) as B_count from SL_bbs where B_del=0 and B_sort=".$row["S_id"]." and year(B_time)=".date("Y",strtotime(date('Y-m-d H:i:s')))." and month(B_time)=".date("m",strtotime(date('Y-m-d H:i:s')))." and day(B_time)=".date("d",strtotime(date('Y-m-d H:i:s')))." and B_sub=0";
}else{
$sql2="Select count(*) as B_count from SL_bbs where B_del=0 and B_sort=".$row["S_id"]." and year(B_time)=".date("Y",strtotime(date('Y-m-d H:i:s')))." and month(B_time)=".date("m",strtotime(date('Y-m-d H:i:s')))." and day(B_time)=".date("d",strtotime(date('Y-m-d H:i:s')))." and B_sh=1 and B_sub=0";
}

$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
$B_count2=$row2["B_count"];
if($B_count==""){
$B_count=0;
}
if($B_count2==""){
$B_count2=0;
}

echo "<a href=\"list.php?id=".$row["S_id"]."\"><div class=\"col-md-6\"><div class=\"panel panel-primary\"><div class=\"panel-heading\"><h3 class=\"panel-title\">".lang($row["S_title"])."</h3></div><div class=\"panel-body\"><div style=\"display:inline-block\"><img src=\"../".$row["S_pic"]."\" style=\"width:70px;height:70px;border-radius:10px;margin-right:20px;margin-top:-60px;\"></div><div style=\"display:inline-block\"><p><b>".lang($row["S_content"])."</b></p><p>".$sh_info."</p><p>".$lv_info."</p><p>(<span style='color:#0099ff'>今日：".$B_count2."</span> / 总数：".$B_count.")</p></div></div></div></div></a>";
}
}
?>

<div style="font: 0px/0px sans-serif;clear: both;display: block"> </div>
</div>
    </div>
    </div>
    <!-- /.container -->
</body>
</html>