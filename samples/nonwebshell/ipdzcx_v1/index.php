<?php
error_reporting(0);
require "ipdata.class.php";


if (!$_GET['ip']) {$ip = get_client_ip();}
else{$ip=$_GET['ip'];}
$ipdata = new ipdata();
$ipdata->geop($ip);
$ip2 = sprintf("%u", ip2long($ip));

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php
echo $ip;

?>的物理位置 - IP地址查询</title>
<link href="/images/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="header">
<div class="tianqi"><iframe width="310" scrolling="no" height="25" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&amp;id=40&amp;icon=1&amp;num=3"></iframe></div>
<div class="cms"><a href="https://www.60cms.com/" target="_blank">优能cms</a> <a href="https://www.60cms.com/dir/" target="_blank">优能目录</a> <a href="https://www.60cms.com/doc/" target="_blank">帮助文档</a> <a href="https://www.60cms.com/bbs/" target="_blank">优能论坛</a></div>
</div>
<div class="main">
<div class="logo"><a href="/"><img src="/images/logo.png"></a></div>
 <div class="so">
  <form name="sofrm" method="get" action="">
   <input name="ip" type="text" id="query" placeholder="<?php echo $ip; ?>" value="" class="soso">
   <input type="submit" value="查询" class="btn">
  </form>
 </div>
 <div class="ip">
  <div class="libox">
   <div class="name">IP地址</div>
   <div class="more"><?php echo $ip; ?></div>
  </div>
  <div class="libox">
   <div class="name">数字地址</div>
   <div class="more"><?php echo $ip2; ?></div>
  </div>
  <div class="libox">
   <div class="name">IP的物理位置</div>
   <div class="more"><?php echo $ipdata->Country.$ipdata->Local; ?></div>
  </div>
  
  
 </div>

</div>
<div class="footer">Copyright © 2019 优能cms(60cms.com) All Rights Reserved. 备案号：苏ICP备16004379号
</div>
</body>
</html>