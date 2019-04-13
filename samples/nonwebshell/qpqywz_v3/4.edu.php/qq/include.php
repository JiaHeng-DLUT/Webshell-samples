<?php
function qqkefu(){
global $conn,$C_dir,$C_domain,$C_wcode,$C_qq,$C_mobile,$C_qqon;
$sql="select * from SL_config limit 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if(mysqli_num_rows($result) > 0) {
$C_qq1=$row["C_qq1"];
$C_qq2=$row["C_qq2"];
$C_qq3=$row["C_qq3"];
$C_qq4=$row["C_qq4"];
$C_member=$row["C_member"];
$C_top=$row["C_top"];
$C_kfon=$row["C_kfon"];
}

if ($C_kfon==1){
$kf1="none";
$kf2="block";
}else{
$kf1="block";
$kf2="none";
}

$QQkefu="<link href='".$C_dir."css/lanrenzhijia.css' rel='stylesheet' type='text/css' /><script src='".$C_dir."js/jquery.KinSlideshow-1.2.1.min.js' type='text/javascript'></script>";
$QQkefu=$QQkefu."<div id='online_qq_layer' style='z-index:1000;'><div id='online_qq_tab'><div class='online_icon'><a target='_blank' id='floatShow' style='display:".$kf1.";' href='javascript:void(0);'>&nbsp;</a><a target='_blank' id='floatHide' style='display:".$kf2.";' href='javascript:void(0);'>&nbsp;</a></div></div><div id='onlineService' style='display:".$kf2."'><div class='online_windows overz'><div class='online_w_top'></div><div class='online_w_c overz'>";
if($C_qq1==1){
	$x=1;
	$QQkefu=$QQkefu."<div class='online_bar expand' id='onlineSort".$x."'><h2><a onclick='changeOnline(".$x.")'>".lang("在线客服/l/Online Service")."</a></h2><div class='online_content overz' id='onlineType".$x."'><ul class='overz'>";
		$qq=explode(",",lang($C_qq));
		for($i = 0 ;$i<count($qq);$i++){
		if ($qq[$i]!=""){
		if (strpos($qq[$i],"|")!==false){
		if (Is_Numeric(splitx($qq[$i],"|",0))){
		$QQkefu=$QQkefu."<li><a title='".lang("点击这里给我发消息/l/Click here to send me a message.")."' href='http://wpa.qq.com/msgrd?v=3&uin=".splitx($qq[$i],"|",0)."&site=qq&menu=yes' target='_blank' class='qq_icon'>".splitx($qq[$i],"|",1)."</a></li>";
		}else{
		$QQkefu=$QQkefu."<li><a title='".lang("点击这里给我发消息/l/Click here to send me a message.")."' href='http://www.taobao.com/webww/ww.php?ver=3&touid=".urlencode(splitx($qq[$i],"|",0))."&siteid=cntaobao&status=1&charset=utf-8' target='_blank' class='ww_icon'>".splitx($qq[$i],"|",1)."</a></li>";
		}
		}else{
		if (Is_Numeric(splitx($qq[$i]."|","|",0))){
		$QQkefu=$QQkefu."<li><a title='".lang("点击这里给我发消息/l/Click here to send me a message.")."' href='http://wpa.qq.com/msgrd?v=3&uin=".splitx($qq[$i]."|","|",0)."&site=qq&menu=yes' target='_blank' class='qq_icon'>".splitx($qq[$i]."|","|",1)."</a></li>";
		}else{
		$QQkefu=$QQkefu."<li><a title='".lang("点击这里给我发消息/l/Click here to send me a message.")."' href='http://www.taobao.com/webww/ww.php?ver=3&touid=".urlencode(splitx($qq[$i]."|","|",0))."&siteid=cntaobao&status=1&charset=utf-8' target='_blank' class='ww_icon'>".splitx($qq[$i]."|","|",1)."</a></li>";
		}
		}
		}
		}
	$QQkefu=$QQkefu."</ul></div></div>";
}
if($C_qq2==1){
$x=$x+1;
$QQkefu=$QQkefu."<div class='online_bar collapse2' id='onlineSort".$x."'><h2><a onclick='changeOnline(".$x.")'>".lang("电话客服/l/Telephone service")."</a></h2><div class='online_content overz' id='onlineType".$x."'><ul class='overz'>";
$mobile=explode("|",$C_mobile);
for($j = 0 ;$j< count($mobile);$j++){
$QQkefu=$QQkefu."<li>".$mobile[$j]."</li>";
}
$QQkefu=$QQkefu."</ul></div></div>";
}
if($C_qq3==1){
$x=$x+1;
$QQkefu=$QQkefu."<div class='online_bar collapse2' id='onlineSort".$x."'><h2><a onclick='changeOnline(".$x.")'>".lang("网站二维码/l/site QR code")."</a></h2><div class='online_content overz' id='onlineType".$x."'><ul class='overz'><script type='text/javascript' src='".$C_dir."js/qrcode.min.js'></script><div id='qrcode' style='margin:0 0 10px 10px;'></div><script>var qrcode = new QRCode('qrcode', {width: 110,height: 110,colorDark: '#000000',colorLight: '#ffffff',correctLevel: QRCode.CorrectLevel.H});qrcode.makeCode('http://".$C_domain."');</script></ul></div></div>";
}
if($C_qq4==1){
$x=$x+1;
$QQkefu=$QQkefu."<div class='online_bar collapse2' id='onlineSort".$x."'><h2><a onclick='changeOnline(".$x.")'>".lang("微信公众号/l/wechat")."</a></h2><div class='online_content overz' id='onlineType".$x."'><ul class='overz'><img src='".$C_dir.$C_wcode."' width='120' /></ul></div></div>";
}
$QQkefu=$QQkefu."</div><div class='online_w_bottom'></div></div></div></div>";
if($C_qqon==0){
$QQkefu="";
}
$QQkefu=$QQkefu."<link type='text/css' rel='stylesheet' href='".$C_dir."css/style.css'><div class='toolbar'>";
if($C_member==1){
$QQkefu=$QQkefu."<a href='".$C_dir."member' class='toolbar-item toolbar-item-feedback'></a>";
}
if($C_top==1){
$QQkefu=$QQkefu."<a href='javascript:scroll(0,0)' class='toolbar-item toolbar-item-top'></a>";
}
$QQkefu=$QQkefu."</div>";
return $QQkefu;
}
?>