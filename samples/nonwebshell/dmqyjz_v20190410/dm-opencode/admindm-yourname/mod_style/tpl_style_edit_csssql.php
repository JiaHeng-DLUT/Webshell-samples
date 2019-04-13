

 <p>
 提示：这部分的样式来自数据库(或称为数据库样式)，所以需要点击 生成样式 才能生效。<br /> 
 <a class="but2" href="<?php echo $jumpv_p;?>&file=edit_csssql&&file2=generatecss&act=edit">生成样式</a> 
  </p> 

 
 <?php 
 if($file2 =='') $file2 = 'normal';

  $editnormal_cur=  $edithf_cur= $editmenu_cur= $editboxtitle_cur= $editbanner_cur ='';
   if($file2=='normal') $editnormal_cur = ' active';
  if($file2=='headfoot') $edithf_cur = ' active';
  if($file2=='menu') $editmenu_cur = ' active';
 if($file2=='boxtitle') $editboxtitle_cur = ' active';
 if($file2=='banner') $editbanner_cur = ' active';


 $jumpv_psql = $jumpv_p.'&file=edit_csssql';

?>

<ul  class="nav nav-tabs">

<li class="<?php echo $editnormal_cur;?>">
 <a   href="<?php echo $jumpv_psql;?>&file2=normal&act=edit">常用样式</a>
</li>

<li class="<?php echo $edithf_cur;?>">
 <a   href="<?php echo $jumpv_psql;?>&file2=headfoot&act=edit">页头和页尾样式</a>
</li>

<li class="<?php echo $editmenu_cur;?>">
 <a   href="<?php echo $jumpv_psql;?>&file2=menu&act=edit">菜单样式</a>
</li>

<li class="<?php echo $editbanner_cur;?>">
 <a   href="<?php echo $jumpv_psql;?>&file2=banner&act=edit">banner样式</a>
</li>


<li class="<?php echo $editboxtitle_cur;?>">
 <a   href="<?php echo $jumpv_psql;?>&file2=boxtitle&act=edit">传统盒子</a>
</li>

 

</ul>


<div  class="tab-content" style="padding:5px 0">
  <?php  
    require_once HERE_ROOT.'mod_style/tpl_style_sql_'.$file2.'.php';
 ?>
</div>


