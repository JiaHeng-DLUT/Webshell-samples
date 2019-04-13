<?php
/*  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);


ifhave_lang(LANG);//TEST if have lang,if no ,then jump

if($ppid=='') $ppid='common';
$title='查看标识';

require_once HERE_ROOT.'mod_module/mod_showblockid_inc.php';

if($ppid=='common')  $cur_bid_blockid='cur';
else  $cur_bid_blockid_mb='cur';

//-----------

require_once HERE_ROOT.'mod_common/tpl_header_iframe.php';

?>
<style>
 table.formtab { margin-bottom:0 }

</style>

<div  class="showblockid cntwrap">

<div class="sidebar">

<?php 
require_once HERE_ROOT.'mod_module/mod_showblockid_sidebar.php';

?>
</div>

<div class="content">

 
  <table class="formtab">
  

  <tr>
    <td class="tl" colspan="2" style="border:0">

<div class="" style="display:inline-block">

<ul  class="nav nav-tabs" >

<?php
$i=0;

foreach ($arr_block as $k => $v) {
  ?>

    <li <?php if($i==0) echo 'class="active"';?>>
    <a href="#<?php echo $k?>" data-toggle="tab">
       <?php 
        
      if($k<>'music') echo $v;
       ?>
    </a>
  </li>

  <?php
  $i++;
}
?>


</ul>

</div></td></tr>

  <tr>
    <td class="tl" colspan="2" style="border:0">

<div   class="tab-content">


 <?php
$i=0;
foreach ($arr_block as $k => $v) {
  if($k<>'music') {
  ?>
 <div class="tab-pane fade <?php if($i==0) echo 'in active'?>" id="<?php echo $k;?>">

 <?php
 //and (pidstylebh='$curstyle' or pidstylebh='') 
  $sql = "SELECT name,pidname,pidcate,pidstylebh,template from ".TABLE_BLOCK."  where pidstylebh='$ppid' and pid='$k' and sta_visible='y' and typecolumn<>'column'   $andlangbh order by  pos desc,id desc";
 //echo $sql;
 
 
 if(getnum($sql)>0){
  $rowlist = getall($sql);
  
  echo '<ul>';
        
       foreach($rowlist as $v){
           
           
             $name = $v['name'];
             $pidname = $v['pidname'];  
             $template = $v['template']; 

             if(is_int(strpos($template,'mbblock/')))  $bgv ='style="background:#e2e2e2"';   
             else $bgv='';   
        
            echo '<li '.$bgv.'>'.admblockid($pidname).' '.adm_previewlink($pidname).$name.'</li>';
       
               }
               echo '</ul>';
             }
    else { echo 'no record...';}
?>

  </div> <!--end tab-pane-->
<?php
$i++;
}

}

?>

 </div>


 </td>
  </tr>
  </table>

  </div> <!--end content-->
</div> <!--end cntwrap--> 
<div  class="c"> </div>

 <?php
require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php';

?>
