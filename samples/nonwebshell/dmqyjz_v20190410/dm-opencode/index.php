<?php 
define("IN_DEMOSOSO", false); //TRUE //false
$userdir='user_20130601_2148331669';
$test='n';
$baseurl='http://'.substr($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],0,-9); 


/*
上面是通过程序判断的，如果网站域名固定，可以在这里直接写好。以http开头，以斜杠结束。然后把上面的注释了。
$baseurl = 'http://www.yoursite.com/'; 
*/
/*
//可以限制其他域名访问本站。
$enterurl = $_SERVER['HTTP_HOST'];
$allowurl ='www.yoursite---.cnnnn';
$jumpurl = 'http://'.$allowurl;
if($enterurl<>$allowurl) {
	Header("HTTP/1.1 301 Moved Permanently");
	header('Location:'.$jumpurl); 	
}
*/

require_once "indexDM_load.php";


 
?>


