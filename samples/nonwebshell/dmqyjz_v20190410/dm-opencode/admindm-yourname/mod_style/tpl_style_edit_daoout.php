<?php
if($act=='update'){
 


   $sql = "SELECT * from ".TABLE_STYLE." where pidname='$pidname'  $andlangbh   limit 1";
                           $row = getrow($sql);

$style_normal = $row['style_normal'];
$style_hf = $row['style_hf'];
$style_menu = $row['style_menu'];
$style_boxtitle = $row['style_boxtitle'];
$style_blockid = $row['style_blockid'];
$style_banner = $row['style_banner'];
 
 $daoouttext = $style_normal.'||||||'.$style_hf.'||||||'.$style_menu.'||||||'.$style_boxtitle.'||||||'.$style_blockid.'||||||'.$style_banner;


 
 
?>

 <table class="formtab">

      <tr>
      <td width="20%"  class="tr">导出数据库样式和标识: </td>
      <td > 
              
<textarea rows="15" class="form-control"><?php 
echo  $daoouttext;
?></textarea>
       </td>
    </tr>


 
    </table>



<?php 

}
else{


$jumpv_insert = $jumpv_pf.'&act=update';

?>

 
 


<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert;?>" method="post" enctype="multipart/form-data">
  <table class="formtab">

      <tr>
      <td width="20%"  class="tr"> </td>
      <td > 
              导出数据库样式和标识，这样其他的模板就可以导入。

       </td>
    </tr>



    
  <tr>
      <td></td>
      <td>
      <input  class="mysubmit" type="submit" name="Submit" value="确定导出" /></td>
    </tr>
    </table>
<?php echo $inputmust;?>

</form>
<?php }
?>
