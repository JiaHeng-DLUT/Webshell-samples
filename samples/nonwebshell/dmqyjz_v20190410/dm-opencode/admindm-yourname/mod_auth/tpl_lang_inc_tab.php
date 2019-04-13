<?php

  $addedit_cur = $basicset_cur= $assets_cur ='';

 if($file=="edit")  { $addedit_cur=' active';$title='语言设置';}
 elseif($file=="basicset")  {  $basicset_cur=' active';$title='网站设置';}
  elseif($file=="assets")   { $assets_cur=' active';$title='资源管理';}
 

  ?>


 
  <div class="menutab"  style="margin-bottom:10px;"> 
 

<a class='<?php echo $basicset_cur ?>' href="<?php echo $jumpv;?>&file=basicset&act=edit&tid=<?php echo $tid;?>"><span>基本设置</span></a> 

 
  
 <a class='<?php echo $addedit_cur ?>' href="<?php echo $jumpv;?>&file=edit&act=edit&tid=<?php echo $tid;?>"><span>语言设置</span></a>
 <a class='<?php echo $assets_cur ?>' href="<?php echo $jumpv;?>&file=assets&act=edit&tid=<?php echo $tid;?>"><span>资源管理</span></a>
 
 </div>    
   
 
    