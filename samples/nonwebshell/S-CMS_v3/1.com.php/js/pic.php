<?php 
require '../conn/conn2.php';
require '../conn/function.php';
$P_id=intval($_GET["P_id"]);
?>

<!DOCTYPE html>
<html>
<head>
<title>图片轮播</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link type="text/css" rel="stylesheet" href="../css/pic.css" />
<style>
body{margin: 0px;}
</style>
</head>
<body>
<section class="cntr">
	<div class="m10">
		<div class="cntr mt20">
			<ul class="pgwSlideshow">
<?php 
$pic=getrs("select * from SL_product where P_id=".$P_id,"P_path");
$P_pic=explode("|",$pic);
For($j = 0 ;$j< count($P_pic);$j++){
if(is_file($C_dirx.splitx($P_pic[$j],"__",0))){
$pic=splitx($P_pic[$j],"__",0);
}else{
$pic="images/nopic.png";
}
if(strpos($P_pic[$j],"__")!==false){
$info=splitx($P_pic[$j],"__",1);
}else{
$info="";
}
echo "<li><img src=\"../".$pic."\" alt=\"".$info."\"></li>";
}
?>
			</ul>
  		</div>
	</div>    
</section>
<script src="../js/pic.js" type="text/javascript"></script>
</body>
</html>
