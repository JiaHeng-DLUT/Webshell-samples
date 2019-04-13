<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}


if($act=='update'){ 
	//echo $_POST['inputmust'];
       if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}


  $bscnt22 = '';
  if(count($_POST)>1){
          foreach ($_POST as  $k=>$v) {
            if(strtolower($k)=='submit') break;
            $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
             
          }
      }
       $bscnt22 = substr($bscnt22,0,-5);


    $ss = "update ".TABLE_CATE." set arr_can='$bscnt22'  where pidname='$pidname' $andlangbh limit 1";
   //echo $bscnt22;exit;
  //echo $ss;exit;
			iquery($ss); 	
  	jump($jumpvedit);

	 

	
	}
	
else{
 
 
$jump_insertupdatesub = $jumpvfp.'&act=update';
if($sta_listcan_inherit<>'y') require_once HERE_ROOT.'mod_category/plugin_cate_can.php';
 else  echo  '<p>提示：因为本子分类 继承了主类，所以这里不能修改参数。</p>';
}
?>

 