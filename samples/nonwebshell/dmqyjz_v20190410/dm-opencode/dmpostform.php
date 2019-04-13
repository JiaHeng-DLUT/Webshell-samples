<?php
session_start();
define("IN_DEMOSOSO", false); //TRUE //false
$userdir='user_20130601_2148331669';
$test='n';
 $baseurl='http://'.substr($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],0,-14); 
 // echo $baseurl;
// routeid=$1&ifalias=n&file=baidumap&page=1
$routeid=25;//no use ,because override in file_inc
$ifalias='n';

 //print_r($_GET);

/*
上面是通过程序判断的，如果网站域名固定，可以在这里直接写好。以http开头，以斜杠结束。然后把上面的注释了。
$baseurl = 'http://www.yoursite.com/'; 

*/
 
 //print_r($_SERVER);
 $typeformarr =array("ordernow","contact","formblock","sendemail","colordemo","masonry","wookmark","previewofndlist",
 "videopop","sitelang","memlogin","memregister","memaddcart");//masonry replace by wookmark
//typeformarr element not use ?v=v in htaccess, just add ?v=v in url.

 function htmlentitdm2($v){   
 	$v = str_replace("..'", "===-", $v); //filter something  
	$v = str_replace(':','===-', $v);
	$v = str_replace('\\','===-', $v);
   return htmlentities(trim($v),ENT_QUOTES,"utf-8");
}//end func

function jump2($link){
    echo "<script LANGUAGE='javascript'>window.location='$link'</script>";
    exit;
}


 $type = @htmlentitdm2($_GET['type']);
 $mb = @htmlentitdm2($_GET['mb']);
 $site = @htmlentitdm2($_GET['site']);



if (!in_array($type, $typeformarr)) {echo 'sorry,type error';exit;}

$file='file_formpost/formpost_'.$type;//it need here
 
 //if($type=='sitelang'){ 
	//	if($mb=='reset' || $mb=='')setcookie("cursite",'');
		//else  setcookie("cursite",@$_GET['mb']);	
	   // jump2($baseurl);
//}
//else 

	if($type=='colordemo'){
	// dmpostform.php?type=colordemo&mb=style20160721_0855323118&site=cn
		//  dmpostform.php?type=colordemo&mb=style20180420_1235164259  /if cn,can pass
		

	// dmpostform.php?type=colordemo&mb=style20170705_1251178257&site=en
	// dmpostform.php?type=colordemo&mb=style20160506_1242421660&site=wuliu
	


		   if($mb=='')  setcookie("curstyless",'');
		   else setcookie("curstyless",$mb);	

		 //  echo $mb;
			 
			if($site=='')  setcookie("cursite",'cn');
			else setcookie("cursite",$site);	 


	      jump2($baseurl);
} 
else{ 
	require_once "indexDM_load.php";
}


 
 
?> 