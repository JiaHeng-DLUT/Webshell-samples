 
 
 <?php 
 
 $edit_edit_cur=  $edit_alias_cur= $edit_layoutlist_cur= $edit_layoutdetail_cur= $edit_field_cur='';
 if($file=='mainedit' || $file=='maineditcan') $edit_edit_cur = ' active';
  if($file=='mainalias') $edit_alias_cur = ' active';
  if($file=='mainlayoutlist') $edit_layoutlist_cur = ' active';
 if($file=='mainlayoutdetail') $edit_layoutdetail_cur = ' active';
 if($file=='mainfield') $edit_field_cur = ' active';
 
?>

<div  class="menutab" style="padding-left:15px;padding-right:15px">

 <a class="<?php echo $edit_edit_cur;?>"  href="<?php echo $jumpv_tid;?>&file=mainedit&act=edit"><span>修改主分类</span></a>
 

  <a  class="<?php echo $edit_alias_cur;?>"  href="<?php echo $jumpv_tid;?>&file=mainalias&act=edit"><span>修改别名</span></a>
 

<?php  
if( $sta_field =='y') {
?>

  <a  class="<?php echo $edit_field_cur;?>"  href="<?php echo $jumpv_tid;?>&file=mainfield&act=edit"><span>字段属性管理</span></a>
 
<?php 
}
?>


 

</div>


 
