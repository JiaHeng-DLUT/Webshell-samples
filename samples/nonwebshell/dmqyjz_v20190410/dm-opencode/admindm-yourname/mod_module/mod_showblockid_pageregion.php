<?php
/*  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);


ifhave_lang(LANG);//TEST if have lang,if no ,then jump

$title='查看标识';

require_once HERE_ROOT.'mod_module/mod_showblockid_inc.php';

 $cur_bid_pageregion='cur';

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
          <li class="active"> <a href="#a1" data-toggle="tab"> 公共页面区域 </a> </li>
          <li class=""> <a href="#a2" data-toggle="tab"> 当前模板区域 </a> </li>
          <li class=""> <a href="#a3" data-toggle="tab"> 组合区块 </a> </li>
          <li class=""> <a href="#a4" data-toggle="tab"> prog文件 </a> </li>
         
        </ul>
      </div>
</td>
</tr>

<tr>
    <td class="tl" colspan="2" style="border:0">
        <div   class="tab-content">
            <div class="tab-pane fade in active " id="a1">

 
<?php
 
 $sql = "SELECT name,pidname from ".TABLE_REGION." where pidstylebh='common' and pid='0'   $andlangbh  order by pos desc,id desc";

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
 else { echo '没有记录...';}
    
    
  ?>


</div><!--end tab-pane-->



 <div class="tab-pane fade in   " id="a2">

 
<?php
 
 $sql = "SELECT name,pidname from ".TABLE_REGION." where pidstylebh='$curstyle' and pid='0'   $andlangbh  order by pos desc,id desc";

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
 else { echo ' 没有记录...';}
    
    
  ?>


</div><!--end tab-pane-->



<div class="tab-pane fade" id="a3">
 
<?php

//-----group block-------------
 $sql = "SELECT name,pidname,pidstylebh from ".TABLE_BLOCKGROUP." where pid='0' $andlangbh  order by pidstylebh ,pos desc,id desc";
 
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
  else { echo '没有记录...';}
  ?>
</div><!--end tab-pane-->

<div class="tab-pane fade" id="a4">

            <?php
           
                  $filedir = BLOCKROOT.'prog/';
                  if(is_dir($filedir)){
                    $filearr = getFile($filedir);
                    echo '<ul>';
                        foreach ($filearr as $v) {
                            $v = substr($v,0,-4);
                             echo '<li> '.admblockid($v).' </li>';
                        }

                        echo '</ul>';

                    }
                    else{
                        echo '<option>'.$filedir.' 目录不存在</option>';
                    }

              ?>


</div><!--end tab-pane-->
 


  </div> <!--end tab-content-->
</td>
</tr>
 </table>


  </div> <!--end content-->
  </div> <!--end cntwrap-->
 
<div  class="c"> </div>


 <?php
require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php';

?>
