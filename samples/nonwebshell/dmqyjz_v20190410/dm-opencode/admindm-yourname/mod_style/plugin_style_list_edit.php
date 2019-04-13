<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

?>

 
<?php 
 
 
   $sql_22 = "SELECT * from ".TABLE_STYLE." where   pid='0' $andlangbh   order by pos desc,pidname desc,id desc";
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
    <td width="220" class=proname></td>

  </tr> 
  <?php
      foreach($rowlist_22 as $v_22){
            $tidhere = $v_22['id'];
             $pidname_22 = $v_22['pidname']; $pidregion = $v_22['pidregion'];
            $name_22 = decode($v_22['title']);  
        if($pidname_22==$curstyle)  $name_22 = $name_22.'<span class="cred">[前台正在使用这个模板]</span>';  
 
   $linkedit = 'mod_style.php?lang='.LANG.'&file='.$file.'&pidname='.$pidname_22.'&act=edit';

 
//echo $linkedit;

 $edittext_22='<a href="'.$linkedit.'">编辑</a>';
?>
<tr style="border-top:2px solid #999">
  <td align="left"><strong><?php echo $name_22;?></strong>
    </td>
    <td align="left"><?php echo $pidregion;?></strong>
    </td>

    <td >
    <?php  
  if($pidname_22==$pidname) echo '正在编辑';
   else  echo $edittext_22; 
    ?></td>
   
  </tr>
<?php
    } ?>
</table>

 

<?php 
}
 
?>