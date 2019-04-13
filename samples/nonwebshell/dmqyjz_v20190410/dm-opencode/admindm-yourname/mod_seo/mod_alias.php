<?php
/*  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);
 
 

//ifhaspidname(TABLE_NODE,$pid);
//ifhaspidname(TABLE_CATE,$catpid);
ifhave_lang(LANG);//TEST if have lang,if no ,then jump

 
$jumpv='mod_alias.php?lang='.LANG;
 
//----------
if($act == "del")
{ 
ifsuredel_field(TABLE_ALIAS,'id',$tid,'equal',$jumpv);

}

//-----------
$title = '别名管理';
 

require_once HERE_ROOT.'mod_common/tpl_header.php';
 
?>

 
<section class="content-header">

<?php 
 $reqfilename = 'mod_seo/nav_seo.php'; 
    $reqfile = HERE_ROOT.$reqfilename;
    require_once $reqfile;
 ?> 
</section>
  
 
 <section class="content pcnarrowwidth">  

   <?php   
       $file = HERE_ROOT.'mod_seo/tpl_alias_list.php';
      if(checkfile($file)) require $file;

        ?>
 </section>
<?php
require_once HERE_ROOT.'mod_common/tpl_footer.php';
?>


