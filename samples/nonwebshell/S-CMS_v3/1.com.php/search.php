<?php
require 'conn/conn.php';
require 'conn/function.php';

$action=$_GET["action"];
$keyword=t($_REQUEST["keyword"]);

$sql="Select * from SL_slide where S_del=0 order by S_id desc limit 1";
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
    <title><?php echo lang("搜索页面/l/search")?> - <?php echo lang($C_webtitle)?></title>
    <link href="<?php echo $C_dir.$C_ico?>" rel="shortcut icon" />
    <link href="member/css/bootstrap.css" rel="stylesheet">
    <link href="css/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="member/css/style.css" rel="stylesheet" type="text/css">
    <script src="member/js/jquery.min.js"></script>
    <script src="member/js/bootstrap.min.js"></script>
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
    <?php 
    if($C_member==1){
    if ($_SESSION["M_login"]==""){
        ?>
    <a href="member/member_reg.php"><?php echo lang("注册/l/Sign Up")?></a> <a href="member/member_login.php"><?php echo lang("登录/l/Sign In")?></a>

    <?php
}else{
    ?>
    <a href="member"><?php echo $_SESSION["M_login"]?></a> <a href="member/member_login.php?action=unlogin"><?php echo lang("退出/l/Sign Out")?></a>
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

$sql="select * from SL_menu where U_del=0 and U_sub=0 and U_hide=0 order by U_order,U_id desc";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      if($row["U_type"]!="link"){
        echo "<li><a href=\"./?type=".$row["U_type"]."&S_id=".$row["U_typeid"]."\" >".lang($row["U_title"])." </a>";
      }else{
        echo "<li><a href=\"".splitx($row["U_url"],"|",0)."\" target=\"".splitx($row["U_url"],"|",1)."\">".lang($row["U_title"])." </a>";
      }
    
    $sql2="select * from SL_menu where U_del=0 and U_sub=".$row["U_id"]." and U_hide=0 order by U_order,U_id desc";
    $result2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($result2) > 0) {
    echo "<ul class=\"dropdown-menu\">";
    while($row2 = mysqli_fetch_assoc($result2)) {

      if($row2["U_type"]!="link"){
        echo "<li><a href=\"./?type=".$row2["U_type"]."&S_id=".$row2["U_typeid"]."\">".lang($row2["U_title"])."</a></li>";
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
<form id="userinfo_save" method="POST" action="?action=search" class="form-horizontal" style="padding: 10px;">
<div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="<?php echo lang("输入关键词/l/Input your Keywords")?>" value="<?php echo $keyword?>">
                    <span class="input-group-btn">
                        <button class="btn btn-info" type="submit"><?php echo lang("搜索/l/Search")?></button>
                    </span>
                </div>
</form>
<?php

if ($action=="search" && $keyword!=""){

$sql="select * from SL_text where T_del=0 and (T_title like '%".$keyword."%' or T_content like '%".$keyword."%' ) order by T_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
if($C_html==1){
$search_info=$search_info."<div class='list'><table><tr><td colspan='2' ><a href='".$C_dir."html/about/".$row["T_id"].".html' target='_blank'><font size='+1' color='#0066ff'><u>".str_Replace($keyword,"<font color='red'>".$keyword."</font>",lang($row["T_title"]))."</u></font></a></td></tr><tr><td width='20%' align='center' valign='middle'><img src='".$row["T_pic"]."' class='search_pic'></td><td width='80%'>".str_replace($keyword,"<font color='red'>".$keyword."</font>",mb_substr(strip_tags(lang($row["T_content"])),0,100,"utf-8"))."...<br><font color='#006600'>".$_SERVER["HTTP_HOST"].$C_dir."html/about/".$row["T_id"].".html</font><br> <font color='#777777'>位置：<a href='".$C_dir."index.php'>".lang($C_webtitle)."</a> - <a href='".$C_dir."html/about/".$row["T_id"].".html'>".lang($row["T_title"],lang($row["T_title"]))."</a></font></td></tr></table></div>";
}else{
$search_info=$search_info."<div class='list'><table><tr><td colspan='2' ><a href='index.php?type=text&S_id=".$row["T_id"]."' target='_blank'><font size='+1' color='#0066ff'><u>".str_Replace($keyword,"<font color='red'>".$keyword."</font>",lang($row["T_title"]))."</u></font></a></td></tr><tr><td width='20%' align='center' valign='middle'><img src='".$row["T_pic"]."' class='search_pic'></td><td width='80%'>".str_replace($keyword,"<font color='red'>".$keyword."</font>",mb_substr(strip_tags(lang($row["T_content"])),0,100,"utf-8"))."...<br><font color='#006600'>".$_SERVER["HTTP_HOST"].$C_dir."index.php?type=text&S_id=".$row["T_id"]."</font><br> <font color='#777777'>位置：<a href='".$C_dir."index.php'>".lang($C_webtitle)."</a> - <a href='index.php?type=text&S_id=".$row["T_id"]."'>".lang($row["T_title"],lang($row["T_title"]))."</a></font></td></tr></table></a></div>";
}
        }
$search1=1;
}else{
$search1=0;
    }

$sql="select * from SL_news,SL_nsort where N_del=0 and S_del=0 and (N_title like '%".$keyword."%' or N_content like '%".$keyword."%' ) and N_sort=S_id order by N_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
if($C_html==1){
$search_info=$search_info."<div class='list'><table><tr><td colspan='2' ><a href='".$C_dir."html/news/".$row["N_id"].".html' target='_blank'><font size='+1' color='#0066ff'><u>".str_Replace($keyword,"<font color='red'>".$keyword."</font>",lang($row["N_title"]))."</u></font></a></td></tr><tr><td width='20%' align='center' valign='middle' ><img src='".$row["N_pic"]."' class='search_pic'></td><td width='80%'>".str_replace($keyword,"<font color='red'>".$keyword."</font>",mb_substr(strip_tags(lang($row["N_content"])),0,100,"utf-8"))."...<br><font color='#006600'>".$_SERVER["HTTP_HOST"].$C_dir."html/news/".$row["N_id"].".html</font><br> <font color='#777777'>位置：<a href='".$C_dir."index.php'>".lang($C_webtitle)."</a> - <a href='".$C_dir."html/news/list-".$row["S_id"].".html'>".lang($row["S_title"])."</a> - <a href='".$C_dir."html/news/".$row["N_id"].".html'>".lang($row["N_title"],lang($row["N_title"]))."</a></font></td></tr></table></div>";
}else{
$search_info=$search_info."<div class='list'><table><tr><td colspan='2' ><a href='index.php?type=newsinfo&S_id=".$row["N_id"]."' target='_blank'><font size='+1' color='#0066ff'><u>".str_Replace($keyword,"<font color='red'>".$keyword."</font>",lang($row["N_title"]))."</u></font></a></td></tr><tr><td width='20%' align='center' valign='middle' ><img src='".$row["N_pic"]."' class='search_pic'></td><td width='80%'>".str_replace($keyword,"<font color='red'>".$keyword."</font>",mb_substr(strip_tags(lang($row["N_content"])),0,100,"utf-8"))."...<br><font color='#006600'>".$_SERVER["HTTP_HOST"].$C_dir."index.php?type=newsinfo&S_id=".$row["N_id"]."</font><br> <font color='#777777'>位置：<a href='".$C_dir."index.php'>".lang($C_webtitle)."</a> - <a href='index.php?type=news&S_id=".$row["S_id"]."'>".lang($row["S_title"])."</a> - <a href='index.php?type=newsinfo&S_id=".$row["N_id"]."'>".lang($row["N_title"],lang($row["N_title"]))."</a></font></td></tr></table></a></div>";
}
        }
$search2=1;
        }else{
$search2=0;
}

$sql="select * from SL_product,SL_psort where P_del=0 and S_del=0 and (P_title like '%".$keyword."%' or P_content like '%".$keyword."%' ) and P_sort=S_id order by P_id desc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
if($C_html==1){
$search_info=$search_info."<div class='list'><table><tr><td colspan='2' ><a href='".$C_dir."html/product/".$row["P_id"].".html' target='_blank'><font size='+1' color='#0066ff'><u>".str_Replace($keyword,"<font color='red'>".$keyword."</font>",lang($row["P_title"]))."</u></font></a></td></tr><tr><td width='20%' align='center' valign='middle' ><img src='".splitx(splitx($row["P_path"],"|",0),"__",0)."' class='search_pic'></td><td width='80%'>".str_replace($keyword,"<font color='red'>".$keyword."</font>",mb_substr(strip_tags(lang($row["P_content"])),0,100,"utf-8"))."...<br><font color='#006600'>".$_SERVER["HTTP_HOST"].$C_dir."html/productsinfo_".$row["P_id"].".html</font><br> <font color='#777777'>位置：<a href='".$C_dir."index.php'>".lang($C_webtitle)."</a> - <a href='".$C_dir."html/product/list-".$row["S_id"].".html'>".lang($row["S_title"])."</a> - <a href='".$C_dir."html/product/".$row["P_id"].".html'>".lang($row["P_title"],lang($row["P_title"]))."</a></font></td></tr></table></div>";
}else{
$search_info=$search_info."<div class='list'><table><tr><td colspan='2' ><a href='index.php?type=productinfo&S_id=".$row["P_id"]."' target='_blank'><font size='+1' color='#0066ff'><u>".str_Replace($keyword,"<font color='red'>".$keyword."</font>",lang($row["P_title"]))."</u></font></a></td></tr><tr><td width='20%' align='center' valign='middle' ><img src='".splitx(splitx($row["P_path"],"|",0),"__",0)."' class='search_pic'></td><td width='80%'>".str_replace($keyword,"<font color='red'>".$keyword."</font>",mb_substr(strip_tags(lang($row["P_content"])),0,100,"utf-8"))."...<br><font color='#006600'>".$_SERVER["HTTP_HOST"].$C_dir."index.php?type=productinfo&S_id=".$row["P_id"]."</font><br> <font color='#777777'>位置：<a href='".$C_dir."index.php'>".lang($C_webtitle)."</a> - <a href='index.php?type=news&S_id=".$row["S_id"]."'>".lang($row["S_title"])."</a> - <a href='index.php?type=productinfo&S_id=".$row["P_id"]."'>".lang($row["P_title"],lang($row["P_title"]))."</a></font></td></tr></table></div>";
}
        }
$search3=1;
        }else{
$search3=0;
    }
}

if($search1+$search2+$search3==0 && $keyword!=""){
echo lang("很抱歉，没有找到与\"".$keyword."\"相关的内容！/l/sorry, couldn't find a \"".$keyword."\" related ");
}
if($_SESSION["f"]==1){
echo cnfont($search_info,"f");
}else{
echo cnfont($search_info,"j");
}

?>


</div>



    </div>
    </div>
    <!-- /.container -->
</body>

</html>