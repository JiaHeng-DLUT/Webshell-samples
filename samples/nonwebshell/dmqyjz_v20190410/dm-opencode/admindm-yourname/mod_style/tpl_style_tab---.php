<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
  
*/
 ?>



<?php
 if($file=='list' || $file=='add') { }
else {
?>

  <div class="menutab"> 

 
<a class='<?php echo $edit_cur ?>' href="<?php echo $jumpv_p;?>&file=edit_can&act=edit"><span  >修改参数</span></a> 

 <a class='<?php echo $editcss_cur ?>' href="<?php echo $jumpv_p?>&file=edit_cssdesp&act=edit"><span  >修改样式</span></a>

 <a class='<?php echo $editblockid_cur ?>' href="<?php echo $jumpv_p?>&file=edit_blockid&act=edit"><span  >修改标识</span></a>

 <a class='<?php echo $editlayout_cur ?>' href="<?php echo $jumpv_p?>&file=edit_layout&act=edit"><span  >修改公共布局</span></a>

  <a class='<?php echo $editdaoout_cur ?>' href="<?php echo $jumpv_p?>&file=edit_daoout&act=edit"><span  >导出</span></a>
 <a class='<?php echo $editdaoin_cur ?>' href="<?php echo $jumpv_p?>&file=edit_daoin&act=edit"><span  >导入</span></a>

 </div>    
   
 <?php } ?>

    