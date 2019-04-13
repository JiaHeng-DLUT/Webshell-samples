<?php
/*
	 
    //act:list edit del delimg updatetime submit(update add )
*/
require_once '../config_a/common.inc2010.php';
ifhave_lang(LANG);//TEST if have lang,if no ,then jump

zb_insert($_POST);

$jumpv='mod_account.php?lang='.LANG.'&pid='.$pid.'&type='.$type;
$jumpv_file=$jumpv.'&file='.$file;
 
//
$title = '超级管理员'; 
 


require_once HERE_ROOT.'mod_common/tpl_header.php';
?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        帐号管理
        <small> <?php echo $title?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../mod_account/mod_account.php?lang=<?php echo LANG?>"><i class="fa fa-dashboard"></i> 帐号管理</a></li>
        <li class="active"><?php echo $title?> </li>
      </ol>
    </section>
 
    <section class="content">
		   
        <?php
         
        require_once HERE_ROOT.'mod_account/tpl_account.php';
        ?>

 </section>

<?php 
 
require_once HERE_ROOT.'mod_common/tpl_footer.php';


?>