<?php

/*

    //act:list edit del delimg updatetime submit(update add )
*/
$mod_previ = 'other';//default is admin,and set in common.inc
require_once '../config_a/common.inc2010.php';
$title = '后台首页';


//
require_once HERE_ROOT.'mod_common/tpl_header.php'; 

?>


<section class="content-header">
     
      
      <h1><?php echo $title?></h1>
</section>
  
 
 <section class="content">
 <?php
	require_once HERE_ROOT.'mod_common/tpl_index.php';
?>
</section>

<?php
require_once HERE_ROOT.'mod_common/tpl_footer.php'; 
?> 