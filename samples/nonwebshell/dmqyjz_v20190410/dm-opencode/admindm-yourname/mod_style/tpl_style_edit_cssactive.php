<?php
      
if($act=='update'){

  $ss = "update ".TABLE_STYLE." set  sta_sqlcss='$abc1'  where pidname='$pidname' $andlangbh limit 1";
   //echo $ss;exit;    
   iquery($ss);  


 $jumpv = $jumpv_pf.'&act=edit';
 jump($jumpv);

}
else{


  $sql = "SELECT sta_sqlcss from ".TABLE_STYLE."  where pidname='$pidname' $andlangbh   order by id limit 1";
$row = getrow($sql);
$sta_sqlcss = $row['sta_sqlcss'];

 $jumpv_insert = $jumpv_pf.'&act=update';

 


?>
 

 <p>如果你会css的话，可能不喜欢使用数据库css的方式，那么可以在下面选择不开启它。</p>
<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert;?>" method="post">
  <table class="formtab">
 


   <tr>
      <td   class="tr">开启数据库样式：</td>
      <td >
      <select name="pagelayout">
    <?php select_from_arr($arr_yn,$sta_sqlcss,'');?>
     </select>

    <?php
      if($sta_sqlcss<>'y') echo '<p class="cred">您已取消数据库样式</p>';
    ?>
   <br /> 
     <p class="cgray">默认是开启的。
     <br />
     如果你不懂css的话，这个一定要开启，不然会影响前台样式。
     </p>
      </td>
    </tr>



        
    
  <tr>
    <td   class="tr"> </td>
      <td>
      <input  class="mysubmit" type="submit" name="Submit" value="提交" /></td>
    </tr>
    </table>
    <?php 
     //<p class="hintbox">使用上传的图片的方法：[uploadpath]1/****.jpg</p>
?>
    <?php echo $inputmust;?>
    
</form>
 
<?php
 }
 
?>

 