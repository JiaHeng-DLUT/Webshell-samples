<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}


  if(!in_array($imgtype,$imgtype_img))//如果不存在能上传的类型
  {
  alert('出错，格式不支持。');jump($jumpv);exit;
  }
 if($maximg<$imgsize)
  {
  alert('出错，文件超允许的大小。');jump($jumpv);exit;
  }
 //echo substr('../../'.$imgfo_z.$fo_bef.$fo_now,0,-1);exit;
  if(!is_dir(substr($admin_img_dir.$fo_bef.$fo_now,0,-1)))
    {
 alert('出错，保存文件的目录不存在，请联系技术支持。');jump($jumpv);exit;
    }
/*
//$w_abm=100;$h_abm=100;$w_pro=100;$h_abm=pro;//this from sql
$w_abm_sm=100;$h_abm_sm=100;$w_pro_sm=100;$h_pro_sm=100;//this not temp from sql

$ss = "select * from fuser_cans where pbh='".USERBH."'";
     $row = getrow($ss);
     if($row<>'no'){
     $water=$row['water'];
     $w_abm=$row['w_abm'];$h_abm=$row['h_abm'];
     $w_pro=$row['w_pro'];$h_pro=$row['h_pro'];
     }
     else{
      $water='no';
     $w_abm=100;$h_abm=100;
     $w_pro=100;$h_pro=100;
     }
*/
//judge water,tomorrow do it.

    ?>