<?php 
define("IN_DEMOSOSO", false); //TRUE //false
header("Access-Control-Allow-Origin:*");
// 响应类型
//header("Access-Control-Allow-Methods:POST");
header("Content-type:application/json;charset=utf-8");//字符编码设置 
 $userdir='user_20130601_2148331669';
 $baseurlapi='http://'.substr($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],0,-12); 
  $baseurl='http://'.substr($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],0,-16); 
 //echo $baseurl;
// echo 'aaaaaaa';
 require_once "apiindexDM_load.php";
 
?>