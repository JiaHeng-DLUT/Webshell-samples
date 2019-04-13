<?php 
require '../conn/conn2.php';
require '../conn/function.php';

$id=intval($_REQUEST["id"]);

$action=$_GET["action"];
$_SESSION["from"]=$C_dir."bbs/item.php?id=".$id;
if($id==""){
$id=0;
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
    mysqli_query($conn,"update SL_bbs set B_view=B_view+1 where B_id=".$id);
$sql="Select * from SL_bbs,SL_bsort,SL_member,SL_lv where B_del=0 and B_sort=S_id and B_mid=M_id and M_lv=L_id and B_id=".$id;

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
    $B_title=lang($row["B_title"]);
    $B_content=str_replace("{@SL_安装目录}",$C_dir,lang($row["B_content"]));
    $B_time=$row["B_time"];
    $B_sort=$row["B_sort"];
    $S_title=lang($row["S_title"]);
    $B_view=$row["B_view"];
    $M_login=$row["M_login"];
    $M_pic=$row["M_pic"];
    $L_title=$row["L_title"];
    }
if(substr($M_pic,0,4)!="http"){
$M_pic="../media/".$M_pic;
}
$sql2="Select count(*) as B_count from SL_bbs where B_del=0 and B_sub=".$id;

$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
$B_count=$row2["B_count"];
if($action=="reply"){
$B_contentx=escape($_POST["B_content"]);

if(stripos($B_contentx,"<script")!==false){
    box("不支持加入javascript","back","error");
}

mysqli_query($conn,"insert into SL_bbs(B_title,B_content,B_time,B_mid,B_sub,B_sort) values('[回复]".$B_title."','".$B_contentx."','".date('Y-m-d H:i:s')."',".$_SESSION["M_id"].",".$id.",".intval($B_sort).")");
box("回复成功！","item.php?id=".$id,"success");
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
    <title><?php echo $B_title?> - <?php echo lang($C_webtitle)?></title>
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
<div class="row">
    <ul class="list-group">
<li class="list-group-item">
导航：<a href="index.php">论坛首页</a> - <a href="list.php?id=<?php echo $B_sort?>"><?php echo $S_title?></a> - <?php echo $B_title?>
</li>
    <li class="list-group-item" style="padding: 0px;">
    <div class="col-md-3" style="padding: 0px;">
        <div class="panel panel-primary" style="border: none">
    <div class="panel-heading" style="height: 38px;">

<span class="col-xs-6">
    浏览：<?php echo $B_view?>
</span>
<span class="col-xs-6">
    回复：<?php echo $B_count?>
</span>
<div style="font: 0px/0px sans-serif;clear: both;display: block"> </div>
    </div>
    <div class="panel-body">
        <div style="text-align: center;padding: 10px;height: 100%">
            <div style="font-weight: bold;margin: 20px;"><?php echo $M_login?></div>
            <img src="<?php echo $M_pic?>" style="width:120px;height:120px;border-radius:10px; ">
            <p style="margin: 10px;">等级：<?php echo $L_title?></p>
        </div>
    </div>
</div>
    </div>

<div class="col-md-9" style="padding: 0px;border-left: solid 1px #dddddd;min-height: 330px;">
<div class="panel panel-primary" style="border: none">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $B_title?></h3>
        <span style="float: right;margin-top:-17px;"><?php echo $B_time?></span>
    </div>
    <div class="panel-body">
        <?php echo $B_content?>
    </div>
</div>
</div>
<div style="font: 0px/0px sans-serif;clear: both;display: block"> </div>
</li>
<?php 

$i=1;
$sql="select * from SL_bbs,SL_member,SL_lv where B_mid=M_id and M_lv=L_id and B_sub=".$id." order by B_id asc";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$B_title=lang($row["B_title"]);
    $B_content=str_replace("{@SL_安装目录}",$C_dir,lang($row["B_content"]));
    $B_time=$row["B_time"];
    $B_view=$row["B_view"];
    $M_login=$row["M_login"];
    $M_pic=$row["M_pic"];
    $L_title=$row["L_title"];

if(substr($M_pic,0,4)!="http"){
$M_pic="../media/".$M_pic;
}

?>
    <li class="list-group-item" style="padding: 0px;">
    <div class="col-md-3" style="padding: 0px;">
        <div style="text-align: center;padding: 10px;height: 100%">
            <div style="font-weight: bold;margin: 20px;"><?php echo $M_login?></div>
            <img src="<?php echo $M_pic?>" style="width:120px;height:120px;border-radius:10px; ">
            <p style="margin: 10px;">等级：<?php echo $L_title?></p>
        </div>
    </div>

<div class="col-md-9" style="padding: 0px;border-left: solid 1px #dddddd;min-height: 240px;">
<div class="panel panel-primary" style="border: none">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $i?>楼 发表于<?php echo $B_time?></h3>
        
    </div>
    <div class="panel-body">
        <?php echo $B_content?>
    </div>
</div>
</div>
<div style="font: 0px/0px sans-serif;clear: both;display: block"> </div>
</li>
<?php 
$i=$i+1;
}
}

?>

<li class="list-group-item" style="padding: 0px;">
     <a href="list.php?id=<?php echo $B_sort?>" class=" btn btn-info pull-right" style="margin:10px; ">返回板块</a> <a class="btn btn-primary pull-right" style="margin:10px; " href="bbs.php">发帖</a>
     <div style="font: 0px/0px sans-serif;clear: both;display: block"> </div>
</li>


<li class="list-group-item" style="padding: 0px;">
    <div class="col-md-3" style="padding: 0px;">
        <div style="text-align: center;padding: 10px;height: 100%">
            <div style="font-weight: bold;margin: 20px;"><?php 
            if ($_SESSION["M_id"]!=""){
            echo $_SESSION["M_login"];
            }else{
            echo "尚未登录";
        }
                    ?></div>
            <img src="<?php 
            if ($_SESSION["M_id"]!=""){
$M_pic=getrs("select * from SL_member where M_id=".$_SESSION["M_id"],"M_pic");
if(substr($M_pic,0,4)!=="http"){
$M_pic="../media/".$M_pic;
}
            echo $M_pic;
            }else{
            echo "../media/member.jpg";
        }
                    ?>" style="width:120px;height:120px;border-radius:10px; ">
            <p style="margin: 10px;"><a href="../member/member_login.php?action=unlogin">退出登录</a></p>
        </div>
    </div>

<div class="col-md-9" style="padding: 0px;border-left: solid 1px #dddddd;">
<?php if ($_SESSION["M_id"]!=""){?>
<form action="?action=reply&id=<?php echo $id?>" method="post">
<script charset='utf-8' src='../kindeditor/kindeditor.js'></script><script charset='utf-8' src='../kindeditor/lang/zh_CN.js'></script><script>KindEditor.ready(function(K) {K.create('#content', {uploadJson : '../kindeditor/php/upload_json.php', fileManagerJson : '../kindeditor/php/file_manager_json.php',allowFileManager : true,items:['source', '|', 'fullscreen', 'undo', 'redo', 'print', 'cut', 'copy', 'paste','plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright','justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript','superscript', '|', 'selectall', '-','title', 'fontname', 'fontsize', '|', 'textcolor', 'bgcolor', 'bold','italic', 'underline', 'strikethrough', 'removeformat', '|', 'image','multiimage','flash', 'media', 'advtable', 'hr', 'emoticons', 'link', 'unlink', '|', 'about'] });});</script><textarea name='B_content' style='width:100%;height:240px;' id='content'></textarea>
<button type="submit" class=" btn btn-info" style="margin:10px; ">回复</button>
</form>
<?php }else{?>

<div style="text-align: center;padding:100px 0;border-bottom: solid 1px #dddddd;">
您目前还是游客，请 <a href="../member/member_login.php">登录</a> 或 <a href="../member/member_reg.php">注册</a>
</div>
<a class="btn btn-info" style="margin:10px; ">回复</a>
<?php }?>
</div>
<div style="font: 0px/0px sans-serif;clear: both;display: block"> </div>
</li>
</ul>
</div>
</div>
    </div>
    </div>
    <!-- /.container -->
</body>

</html>