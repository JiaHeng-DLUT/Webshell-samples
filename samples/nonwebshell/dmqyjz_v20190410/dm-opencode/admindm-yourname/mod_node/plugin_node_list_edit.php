<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

?>

 

<style>
.menu_list_edit a{color:blue;}
</style>
<table class="formtab  formtabhovertr menu_list_edit" style="width:100%">

    <td width="300" align=center>标题</td>
    <td width="220" class=proname></td>
  </tr> 




  <?php 
 
 //mod_blockdh.php?lang=cn&catpid=cate20160707_0437114782&page=0&catid=csub20160707_0904417537
//mod_node.php?lang=cn&catpid=cate20150805_1125344029&catid=csub20150805_1127279495

 $catid_v="ppid='$catpid' and pid='$pid'";// $pid in mod_node_edit.php
   
 $sql_22 = "SELECT * from ".TABLE_NODE." where $catid_v  and id>=$tid $andlangbh order by pos desc,id desc limit 10"; 
  
 $rowlist_22 = getall($sql_22);
    if($rowlist_22 == 'no')  echo '无内容';
    else {
  ?>


  <?php
      foreach($rowlist_22 as $v_22){
            $title22 = $v_22['title'];
             $tidhere22 = $v_22['id'];  
              $sta_visi_v = $v_22['sta_visible'];
 
 

             menu_changesta($sta_visi_v,'',$tidhere22,'sta_menu');

// mod_node_edit.php?lang=cn&act=editdesp&tid=10&file=editdesp
$linkedit = 'mod_node_edit.php?lang='.LANG.'&act=editdesp&tid='.$tidhere22.'&file=editdesp';
 $edittext_22='<a href="'.$linkedit.'">编辑</a>';

 
    ?>
<tr  <?php echo $tr_hide;?>  style="border-top:2px solid #999">
  <td align="left">
  <?php  echo '[ID:'.$tidhere22.'] 标题：'.$title22;   
 
 ?>
 
 </td>
    <td ><?php  
    if($tid==$tidhere22) echo '正在编辑';
    else echo $edittext_22;      ?></td>
   
  </tr>
 <?php
     
 
    } ?>

 <?php
     
 
    } ?>











  <?php 
 
 //mod_blockdh.php?lang=cn&catpid=cate20160707_0437114782&page=0&catid=csub20160707_0904417537
//mod_node.php?lang=cn&catpid=cate20150805_1125344029&catid=csub20150805_1127279495

 $catid_v="ppid='$catpid' and pid='$pid'";// $pid in mod_node_edit.php
   
 $sql_22 = "SELECT * from ".TABLE_NODE." where $catid_v  and id<$tid $andlangbh order by pos desc,id desc limit 10"; 
  //echo  $sql_22 ;
 $rowlist_22 = getall($sql_22);
    if($rowlist_22 == 'no')  echo '无内容';
    else {
  ?>


  <?php
      foreach($rowlist_22 as $v_22){
            $title22 = $v_22['title'];
             $tidhere22 = $v_22['id'];  
              $sta_visi_v = $v_22['sta_visible'];
 

 

             menu_changesta($sta_visi_v,'',$tidhere22,'sta_menu');

 
// mod_node_edit.php?lang=cn&act=editdesp&tid=10&file=editdesp
$linkedit = 'mod_node_edit.php?lang='.LANG.'&act=editdesp&tid='.$tidhere22.'&file=editdesp';
 $edittext_22='<a href="'.$linkedit.'">编辑</a>';

    ?>
<tr  <?php echo $tr_hide;?>  style="border-top:2px solid #999">
  <td align="left">
  <?php  echo '[ID:'.$tidhere22.'] 标题：'.$title22;   
 if($tid==$tidhere22) echo '<span class="cred">(当前)</span>';
 ?>
 
 </td>
    <td ><?php  echo $edittext_22;      ?></td>
   
  </tr>
 <?php
     
 
    } ?>





 <?php
     
 
    } ?>









</table>


