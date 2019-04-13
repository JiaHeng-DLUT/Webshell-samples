<?php
/*	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);
 
  
//ifhaspidname(TABLE_NODE,$pid);
//ifhaspidname(TABLE_CATE,$catpid);
ifhave_lang(LANG);//TEST if have lang,if no ,then jump
 $wheretype='';
if($catid=='contact') { 
 $title = '留言管理 ';
 $wheretype=" and type='contact' ";
}
 elseif($catid=='ordernow') {
 $title = '订单(询盘)管理 ';
 $wheretype=" and type='ordernow' ";
 }
 elseif($catid=='formblock') {
  $title   = get_field(TABLE_FIELD,'name',$catpid,'pidname');
  $wheretype=" and type='formblock' and pid='$catpid' ";
  }

$filearr =  array("contact", "ordernow", "formblock");  
if(!in_array($catid,$filearr))   {echo 'type is error.';exit;}


$jumpv='mod_comment.php?lang='.LANG.'&catid='.$catid.'&catpid='.$catpid;
$jumpv_pidname=$jumpv.'&pidname='.$pidname;
$jumpv_file=$jumpv.'&file='.$file;
$jumpv_pidnamefile=$jumpv_pidname.'&file='.$file;


 


 if($act == "del")
{     
  
     ifsuredel_field(TABLE_COMMENT,'id',$tid,'eq',$jumpv.'&page='.$page);
       
 
}


//-----------

require_once HERE_ROOT.'mod_common/tpl_header.php'; 
require_once HERE_ROOT.'mod_comment/tpl_comment.php'; 
?> 

 <?php
require_once HERE_ROOT.'mod_common/tpl_footer.php';

?>