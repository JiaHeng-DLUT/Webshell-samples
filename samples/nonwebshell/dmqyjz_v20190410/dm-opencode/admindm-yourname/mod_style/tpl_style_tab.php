<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
  
*/
 ?>


 

  <div class="menutab"> 

  <div class="fr" style="margin-right:30px">
	<span class="cp editmenuother cirbtn">编辑其他 &#8595; </span>
	</div><!--end fr-->

 
<a class='<?php echo $edit_cur ?>' href="<?php echo $jumpv_p;?>&file=edit_can&act=edit"><span  >修改参数</span></a> 

 
 <a class='<?php echo $editblockid_cur ?>' href="<?php echo $jumpv_p?>&file=edit_blockid&act=edit"><span  >修改标识</span></a>
<!--
 <a class='<-?php echo $editcustomcss_cur ?>' href="<-?php echo $jumpv_p?->&file=edit_newcustomcss&act=edit"><span  >修改样式</span></a>
-->
  <a class='<?php echo $editcssfile_cur ?>' href="<?php echo $jumpv_p?>&file=edit_newcssfile&act=edit"><span  >修改样式文件</span></a>

 </div>    
   


 <div class="editmenuother_cnt">
<?php
 require_once('plugin_style_list_edit.php');
?>
</div><!--end editmenuother_cnt-->
 


    