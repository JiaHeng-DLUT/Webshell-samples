<?php
/*	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
$mod_previ = 'normal';//default is admin,and set in common.inc
require_once '../config_a/common.inc2010.php';
//

if($file=='editkv' || $file=='editkvsm'  || $file=='editkvsm2'){}
else{echo 'file error';exit;}

ifhave_lang(LANG);//TEST if have lang,if no ,then jump
if($act <> "pos") zb_insert($_POST);
//-----------------------------
$jumpv='mod_node_edit_popup.php?lang='.LANG.'&tid='.$tid;
$jumpv_file=$jumpv.'&file='.$file;


$sta_kvtothumb='';
//-----------
 $sql="select * from ".TABLE_NODE." where id='$tid' $andlangbh order by id limit 1";
$row=getrow($sql);
if($row=='no'){alert('出错，没有此内容！');exit;}
else{ 
$title=$row['title'];
$pid=$row['pid'];
$catpid=$row['ppid'];
$pidname=$row['pidname'];$sta_orignimg=$row['sta_orignimg'];
 
ifhaspidname(TABLE_CATE,$pid);

$date=$row['dateedit'];
if($date=='') $date= date("Y-m-d");
//---
 $sqlcatmain="select * from ".TABLE_CATE." where pidname='$catpid' $andlangbh order by id limit 1";
$rowcatmain=getrow($sqlcatmain);
 

$arr_can=$rowcatmain['arr_can'];
$bscntarr = explode('==#==',$arr_can); 
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }
 
//------
}

$sta_kvtothumb='n'; //$sta_kvtothumb -- no use...
//---
require_once HERE_ROOT.'config_a/func.previ.php';//when normal,require is here.bec need catpid

/********************************************************/
$maincate = get_field(TABLE_CATE,'name',$catpid,'pidname');
$title= '内容修改 - '.$title;
 //---
 $editcan_cur=''; 
 $editalias_cur='';
 $editfield_cur='';
$editkv_cur='';
 $editkvsm_cur='';
$editdesp_cur='';
 $editalbum_cur='';
 $edittab_cur='';
  $editaccord_cur='';


 if($file=="editcan")   $editcan_cur=' cur'; 
 elseif($file=="editalias")   $editalias_cur=' cur';
 elseif($file=="editfield")   $editfield_cur=' cur';
 elseif($file=="editkv")   $editkv_cur=' cur';
 elseif($file=="editkvsm")   $editkvsm_cur=' cur';
 elseif($file=="editdesp")   $editdesp_cur=' cur';
 elseif($file=="editalbum")   $editalbum_cur=' cur';
 elseif($file=="edittab")   $edittab_cur=' cur';
  elseif($file=="editaccord")   $editaccord_cur=' cur';
 
/****************************/
//
//$fo_bef='upp/';$fo_now=$imgfo_abm;--put to imgprotect.php
/**
*
*****************************************/


if($act == "sta_node")
{
     $ss = "update ".TABLE_NODE." set sta_visible='$v' where id='$tid' and ppid='$catpid' $andlangbh limit 1";
    iquery($ss);
    jump($jumpv_catid);
}

if($act == "pos")
{
   foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_NODE." set  pos='$v' where id='$k' and ppid='$catpid' $andlangbh limit 1";
         iquery($ss);
        }
    jump($jumpv_catid);
}

/**/
if($act == "delnode") 
{ 
  //no here
 
}

/*****
****
***
*********************/
 
require_once HERE_ROOT.'mod_common/tpl_header_iframe.php'; 
 
//require_once HERE_ROOT.'mod_node/tpl_node_edit.php';
 require_once HERE_ROOT.'mod_node/tpl_node_'.$file.'.php';

 require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php'; 

?>