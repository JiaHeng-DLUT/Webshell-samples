<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
  
*/

require_once '../config_a/common.inc2010.php';
ifhave_lang(LANG);//TEST if have lang,if no ,then jump

  
  $pidstring = substr($pid,0,4);  
  
   /// if($pidstring=='comm') {$title ='公共页面布局';}
 //else if($pidstring=='page') {ifhaspidname(TABLE_MENU,$pid);$title ='单页布局';}
    if($pidstring=='cate') {ifhaspidname(TABLE_CATE,$pid);$title ='分类的字段管理';}
 else {echo '出错!';exit;}
 
  
 if($act <> "pos") zb_insert($_POST);
//
$jumpv='mod_field.php?lang='.LANG.'&pid='.$pid.'&type='.$type;
$jumpv_file=$jumpv.'&file='.$file;

//----------
if($act == "pos")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_FIELD." set  pos='$v' where id='$k'  $andlangbh  limit 1";
         iquery($ss);
        }
      jump($jumpv);
}
if($act == "sta")
{
     $ss = "update ".TABLE_FIELD." set sta_visible='$v' where id=$tid $andlangbh limit 1";
	// echo $ss;exit;
    iquery($ss);
    jump($jumpv);
}

 if($act == "del") 
{ 
ifcandel_field(TABLE_FIELDOPTION,'pid',$pidname,'','出错，有选项不能删除，请先删除它的选项！或者不用删除，直接隐藏这个属性。',$jumpv);
//ifcandel_field($table,$field,$value,$typelike,$back)


ifcandel_field(TABLE_FIELDVALUE,'pid',$pidname,'','出错，有文章用到了这个选项！请先删除用了这个选项的文章！',$jumpv);
//ifcandel_field($table,$field,$value,$typelike,$back)


 ifsuredel_field(TABLE_FIELD,'pidname',$pidname,'',$jumpv);
 //ifsuredel_field($table,$field,$value,$typelike,$back)

}

require_once HERE_ROOT.'mod_common/tpl_header_iframe.php';
?>
 
 
 <section class="content"> 
   

  <div class="contenttop">

 
 <?php
  if($file=='list'){?>
    <a href='<?php echo $jumpv.'&file=addedit&act=add';?>'><i class="fa fa-plus-circle"></i> 添加字段</a>
<?php
  }
 
  if($file<>'list'){
    ?>
   <a href="<?php echo $jumpv; ?>"><i class="fa fa-arrow-left"></i>  返回字段管理</a>

  <?php 
  }
?>
</div>


<?php
  require_once HERE_ROOT.'mod_field/tpl_field_'.$file.'.php'; 	 
?>
</section>
<?php
require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php';
?>
 