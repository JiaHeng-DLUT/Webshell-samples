<?php
/*	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
$mod_previ = 'normal';//default is admin,and set in common.inc
require_once '../config_a/common.inc2010.php';
$menu_content = 'y';
require_once HERE_ROOT.'config_a/func.previ.php';//when normal,require is here.
//

 

$jumpv='mod_pop_album_other.php?lang='.LANG.'&pid='.$pid.'&type='.$type;

//-------------
if($act=='insert'){

  echo 'bbb';
}

//----------------
require_once HERE_ROOT.'mod_common/tpl_header_iframe.php';
?>


 <section class="content">
        <?php
    
 if($act=='list') {
    if($type=='album') { 
          
        $num = num_subnode(TABLE_ALBUM,'pid',$pid);
        $link = '../mod_album/mod_album.php?lang'.LANG.'&pid='.$pid.'&type=node';
      echo  "<p style='padding:50px;text-align:center'><a class='needpopup'  href='$link'><i class='fa fa-folder'></i> 管理图片</a><br />($num)<p>";
     
   


    }
    else if($type=='video') { }

    else {  echo 'type is error';exit;}

    
 }//end act=list

        ?>
 </section>
<?php
require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php';
?>
