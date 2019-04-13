<?php
/*  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);


ifhave_lang(LANG);//TEST if have lang,if no ,then jump

$title='查看标识';

require_once HERE_ROOT.'mod_module/mod_showblockid_inc.php';

 $cur_bid_form='cur';

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

<h3>表单区块标识列表：</h3>



<?php
 $sql = "SELECT name,pidname from ".TABLE_FIELD." where pid='block' and type='block'  $andlangbh  order by pos desc,id";
if(getnum($sql)>0){
$rowlist = getall($sql);
echo '<ul>';
 
      
     foreach($rowlist as $v){
         
         
           $name = $v['name'];
           $pidname = $v['pidname'];  
            
      
          echo '<li>'.admblockid($pidname).' '.adm_previewlink($pidname).$name.'</li>';
     
             }
             echo '</ul>';
           }
  else { echo 'no record...';}
     
     
   ?>

</div> <!--end content-->

</div> <!--end cntwrap-->

 
<div  class="c"> </div>

 <?php
require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php';

?>
