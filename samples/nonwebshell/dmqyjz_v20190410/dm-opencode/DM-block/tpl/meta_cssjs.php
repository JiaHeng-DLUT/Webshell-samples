<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
	if(is_file(TPLCURROOT.'tpl/meta_cssjs.php')) { 
	require_once TPLCURROOT.'tpl/meta_cssjs.php'; 
}
else { 
	 require_once DISPLAYROOT.'a_meta_cssjs.php'; 
}	
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
<?php 
//add css
$DMcommon = 'assets/cssjs/DM.css';
$DMcompress = 'assets/cssjs/DMcompress.css';
$DMheader = 'assets/cssjs/DMheader.css';
getcssarr($DMcompress);
getcssarr($DMcommon); 
getcssarr($DMheader); 
if($skincss<>''){
	$skincssv = 'assets/skincss/'.$skincss;
	getcssarr($skincssv); //加载皮肤
}
if($addcss<>'') getcssarr($addcss); 

//$csutomcss_root = TPLCURROOT.'cssjs/'.HTMLDIR.'_custom.css';
//$csutomcss_path = TPLCURPATH.'cssjs/'.HTMLDIR.'_custom.css';
//if(is_file($csutomcss_root)) getcsssingle($csutomcss_path);

$curcssroot = TPLCURROOT.'cssjs/'.HTMLDIR.'.css';
$curcss =   HTMLDIR.'.css';
if(is_file($curcssroot)) getcssarr($curcss); //加载当前模板下的css。没有之个css就不加。
 //----add js---- 
$jquery = 'assets/jquery.js';
$DMcompress_js = 'assets/cssjs/DMcompress.js';
$DMjs = 'assets/cssjs/DM.js';
getjsarr($jquery);
getjsarr($DMcompress_js);
getjsarr($DMjs);

if($addjs<>'') getjsarr($addjs);
 
$mbjsroot = TPLCURROOT.'cssjs/'.HTMLDIR.'.js';
$mbjspath =  HTMLDIR.'.js';
if(is_file($mbjsroot))  getjsarr($mbjspath);//加载当前模板下的js。没有之个js就不加。
?> 