<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
  
*/
$mod_previ = 'normal';//default is admin,and set in common.inc
require_once '../config_a/common.inc2010.php';
ifhave_lang(LANG);//TEST if have lang,if no ,then jump


ifhaspidname(TABLE_NODE,$pid);
ifhaspidname(TABLE_CATE,$catpid);
 
//if($act <> "pos") zb_insert($_POST);
//
$jumpv='mod_fieldvalue.php?lang='.LANG.'&pid='.$pid.'&catpid='.$catpid.'&type=cate';
$jumpv_file=$jumpv.'&file='.$file;


//-----------
 if($act=="pos"){
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_ALBUM." set  pos='$v' where id='$k'  $andlangbh  limit 1";
         iquery($ss);
        }
      jump($jumpv);
}
//-----------
$title='';
 
require_once HERE_ROOT.'mod_common/tpl_header_iframe.php';
?>
 
 
 <section class="content">  
 
<div class="contenttop">
<a target="_blank" href="../mod_category/mod_category.php?lang=<?php echo LANG; ?>&catid=<?php echo $catpid; ?>&file=field&act=edit"><i class="fa fa-arrow-left"></i> 字段管理</a> 
</div>
 
<?php
 
require_once HERE_ROOT.'mod_field/tpl_fieldvalue_list.php';
 ?>
 </section>

 <?php
 
require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php';
?>
 