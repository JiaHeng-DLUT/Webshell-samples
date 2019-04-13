<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

  if(!in_array($imgtype,$attach_type))//如果不存在能上传的类型
  {
  alert('出错，格式不支持。');echo $backlist;exit;
  }
 if($attach_size<$imgsize)
  {
  alert('出错，文件超出允许的大小。');echo $backlist;exit;
  }
  //echo UPLOADROOTIMAGE;
 
   if(!is_dir(UPLOADROOTIMAGE))
    {
 alert('出错，保存文件的目录不存在。必须以当前语言的标识（upload/image/'.LANG.'）一致。');exit;
    }
 
	
 // echo strlen('y1010/20101007_1120501091.jpg');exit;is 29 jpeg is 30
 //echo '$imgsqlname:'.$imgsqlname;
   if($imgsqlname<>'' && is_file(UPLOADROOTIMAGE.$imgsqlname)) {
     $return_v=$imgsqlname;//edit img ,and img must exist.   else give new name to old img.     

   }
	 else   $return_v = date("Ymd_His").'_'.rand(1000,9999).'.'.$imgtype; //echo "== $return_v =";
	 
    $imgdate2 = UPLOADROOTIMAGE.$return_v;//need to root folder;
	
 //echo $imgdate2.'<br>';
	
   //echo '===='.$imgsqlname;exit;
//echo $_FILES["addr$i"]["tmp_name"].'<br>';;
    move_uploaded_file($_FILES["addr$i"]["tmp_name"],$imgdate2);
    //small img
    if($up_add_s=='y'){
       $imgfirstpart= gl_img_s($imgdate2,$imgtype);
        $addrrr_sm=$imgfirstpart. "_s.".$imgtype;
        $return_v_s='';
    }
    else{
       $return_v_s = $return_v;   
       $addrrr_sm = UPLOADROOTIMAGE.$return_v_s; 
    }
 //echo $imgdate2.'<br>';
 //echo $addrrr_sm;

 $waterimgv= UPLOADROOTIMAGE.$waterimg;
if($up_water=='y') {  
     if($waterimg<>'')  {        
        if(is_file($waterimgv))  require("../plugin/upload_water.php");
        else { echo '水印图片不存在';exit;}
     }
    }  

if($up_small=='y') require("../plugin/upload_imgsm.php");    
 
if($up_delbig=='y') { unlinkdm($imgdate2); }
   
 ?>