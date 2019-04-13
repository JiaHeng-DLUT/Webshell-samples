<?php
require '../conn/conn2.php';
require '../conn/function.php';
$T_id=$_GET["T_id"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站演示</title>
<style>
body{
font-family:"微软雅黑";
	margin:0;
	padding:0;
overflow-x:hidden;
overflow-y:hidden;
 }
a{ font-size:12px; color:#999999; text-decoration:none;}
a:hover {color:#FFFFFF;}

.box{width:450px; height:600px;background:#FFFFFF;box-shadow:0px 0px 20px #999999; padding:20px; text-align:center;position:absolute;left:50%; top:50%; margin-left:-230px; margin-top:-300px;}
.box img{ border:#CCCCCC solid 2px; padding:10px; margin:10px; box-shadow:0px 0px 10px #999999;}
</style>
<script>
function alertWin(){ 
float=document.getElementById("float");
float2=document.getElementById("float2");
float.style.position="absolute";
float.style.height=(document.documentElement.clientHeight-50)+"px";
float.style.width=(document.documentElement.clientWidth)+"px";
float.style.zIndex="50";
float.style.top="50px";
window.onresize = function(){
float.style.position="absolute";
float.style.height=(document.documentElement.clientHeight-50)+"px";
float.style.width=(document.documentElement.clientWidth)+"px";
float.style.zIndex="50";
float.style.top="50px";
}
float.innerHTML="<iframe src='http://demo.s-cms.cn/<?php echo $T_id?>' frameBorder='0' width='100%' height='100%'></iframe>"
}
</script>
</head>
<body <?php if (substr($T_id,0,1)=="s"){?>
	onLoad="alertWin()"
	<?php }?>>
<div style="height:20px; background:#000000; color:#CCCCCC; font-size:12px; padding:15px;"><img src="img/go.png" style="margin:0 0 -5px 20px;"> 
	<?php if (substr($T_id,0,1)=="s"){?>
	PC
	<?php }else{?>
	WAP
	<?php }?>
	模板<?php echo $T_id?>在线演示 <img src="img/info.png" style="margin:0 0 -5px 20px;"> 本页仅作模块展示，效果以实际运用到网站为准  <span style="float:right; margin-right:20px;"><img src="img/close.png" style="margin:0 0 -5px 20px;"> <a href="javascript:;" onClick="window.close();">关闭窗口</a></span></div>
<div id="float">
	<?php if (substr($T_id,0,1)=="w") {?>
<div class="box">手机模板编号<?php echo $T_id?><br><img src="http://www.s-cms.cn/media/<?php echo $T_id?>.jpg" height="280"><br>请扫描二维码查看演示<br><img src="http://static.websiteonline.cn/website/qr/index.php?url=http://<?php echo $T_id?>.demo.s-cms.cn" width="200" height="200"></div>
<?php }?></div>
</body>
</html>
