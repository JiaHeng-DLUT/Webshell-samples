<?php
/*
  欢迎使用DM建站系统，网址：www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}
//----------
 
?> 
 
<div class="menutab">

	<div class="fr" style="margin-right:30px">
	<span class="cp editmenuother cirbtn">编辑其他 &#8595; </span>
	</div><!--end fr-->
	

<?php

//--------------
 $editcan_cur= $editcfg_cur='';

 if($file=="editcan")   $editcan_cur=' active'; 
 elseif($file=="editcfg")   $editcfg_cur=' active';
 
echo '<a class="'.$editcan_cur.'" href="'.$jumpv.'&file=editcan&tid='.$tid.'"><span>修改标题</span></a>';
echo '<a class="'.$editcfg_cur.'" href="'.$jumpv.'&file=editcfg&tid='.$tid.'"><span>修改样式</span></a>';

?> 



</div>


<div class="editmenuother_cnt">
<?php
 require_once('plugin_region_list_edit.php');
?>
</div><!--end editmenuother_cnt-->

 