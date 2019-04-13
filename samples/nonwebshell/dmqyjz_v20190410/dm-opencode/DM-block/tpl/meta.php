<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php seo($seo1,'seo1') ?></title>
<meta name="description" content="<?php seo($seo3,'seo3') ?>" />
<meta name="keywords" content="<?php echo seo($seo2,'seo2') ?>" />
<meta name="author" content="DM建站系统 www.demososo.com" />
<?php 
if($sta_colseresponsive<>'y') {?>
<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no, width=device-width">
<?php } ?>
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
<link rel="shortcut icon" href="<?php echo UPLOADPATHIMAGE.$ico;?>" />
<?php
 $file =  TPLCURROOT.'/tpl/meta_cssjs.php';
  if(is_file($file)) require_once($file);
else require_once BLOCKROOT.'tpl/meta_cssjs.php'; 
?>
</head>
<?php
//if(isdmmobile()) $mobilecss=' page_mobile';
//else $mobilecss=' '; //------add by js
 
$pagenarrow=' nopagenarrow '.$curstyle; //body.nopagenarrow .headerfixed
if($sta_narrowscreen=='y') $pagenarrow=' container '.$curstyle;  //sta_narrowscreen in indexload.php
 
?>
<body class="<?php echo $bodycss.$pagenarrow;if($alias<>'index') echo ' page_other'?>">
 
