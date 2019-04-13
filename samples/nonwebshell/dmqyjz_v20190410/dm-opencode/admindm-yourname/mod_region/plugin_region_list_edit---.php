<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

?>

 
<?php 
 
 
   $sql_22 = "SELECT * from ".TABLE_REGION." where  pid='$pid' $andlangbh  order by pos desc,id";
   //ECHO $sql;
   $rowlist_22 = getall($sql_22);
    if($rowlist_22 == 'no')  echo '<p style="padding:55px;background:#eee">没有内容，请添加。</p>';
    else {
  ?>

<style>
.menu_list_edit a{color:blue;}
</style>
<table class="formtab  formtabhovertr menu_list_edit" style="width:100%">

    <td width="300" align=center>名称</td>
    <td width="220" class=proname></td>
   

  </tr> 
  <?php
      foreach($rowlist_22 as $v_22){
            $tidhere = $v_22['id'];
             $pidname_22 = $v_22['pidname'];
            $name_22 = decode($v_22['name']);  

            $sta_visi_v = $v_22['sta_visible']; 
    
           // menu_changesta($sta_visi_v,$jumpv,$tid);//trbg and tr_hide is in here
       menu_changesta($sta_visi_v,$jumpv,$tid,'sta_menu');


 
   $linkedit = 'mod_region.php?lang='.LANG.'&file='.$file.'&pid='.$pid.'&tid=';

//echo $linkedit;

 $edittext_22='<a href="'.$linkedit.$tidhere.'">编辑</a>';

    ?>
<tr  <?php echo $tr_hide;?>  style="border-top:2px solid #999">
  <td align="left"><strong><?php echo $name_22;?></strong>
    </td>
    <td >
    <?php  
  if($tidhere==$tid) echo '正在编辑';
   else  echo $edittext_22; 
    ?></td>
   
  </tr>
<?php
    } ?>
</table>

 

<?php 
}
 
?>