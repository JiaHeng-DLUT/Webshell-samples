<?php
/*  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);


ifhave_lang(LANG);//TEST if have lang,if no ,then jump

$title='相册标识';

require_once HERE_ROOT.'mod_module/mod_showblockid_inc.php';

 $cur_bid_album='cur';

//-----------

require_once HERE_ROOT.'mod_common/tpl_header_iframe.php';

?>
<div  class="showblockid cntwrap">

<div class="sidebar">

<?php 
require_once HERE_ROOT.'mod_module/mod_showblockid_sidebar.php';

?>
</div>

<div class="content">

<h3>相册标识列表：</h3>
 <?php
$sql = "SELECT * from ".TABLE_ALBUM." where   $noandlangbh and   pid='common'    order by pos desc,id desc"; //pos desc,id desc 
    // echo $sql; 
  $num_rows = getnum($sql);
     if($num_rows>0){
     
      $maxline = 100;
      
        $offset=5;
        $page_total=ceil($num_rows/$maxline); //maxline is in mod_node.php
      
        if (!isset($page)||($page<=0)) $page=1;
        if($page>$page_total) $page=$page_total;
        $start=($page-1)*$maxline;
        $sqltextlist2="$sql  limit $start,$maxline";
        $rowlisttext = getall($sqltextlist2); 

?>  
 
  <?php
  echo '<ul>';
        foreach($rowlisttext as $v){
    
     $tid = $v['id'];
      $title = $v['title'];
      $pidname = $v['pidname'];  
       
 
     echo '<li>'.admblockid($pidname).' '.adm_previewlink($pidname).$title.'</li>';

        }
        echo '</ul>';   
      }
      else { echo 'no record...';}


    ?>


<?php 
      $file='';
      require_once HERE_ROOT.'plugin/page_2010.php';
          
      ?>

 



</div> <!--end content-->

</div> <!--end cntwrap-->

 
<div  class="c"> </div>
 

 <?php
require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php';

?>
