<?php
if($act=='update'){
 

if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}
 
 if(!is_int(strpos($abc1,'||||||')))  $text = '出错，格式不对。';
else {


 
$daoarr = explode("||||||",$abc1);

//pre($daoarr);

    $style_normal = $daoarr[0];
    $style_hf = $daoarr[1];;
    $style_menu = $daoarr[2];
    $style_boxtitle = $daoarr[3];
    $style_blockid = $daoarr[4];
    $style_banner = $daoarr[5];

      $ss = "update ".TABLE_STYLE." set style_normal='$style_normal',style_hf='$style_hf',style_menu='$style_menu',style_boxtitle='$style_boxtitle',style_blockid='$style_blockid',style_banner='$style_banner' where pidname='$pidname' $andlangbh limit 1";
    //echo $ss;exit;    
   iquery($ss);  

 

   $text = '导入成功。需要重新生成数据库样式才能生效。';
}

?>

<p style="text-align: center;font-size:30px"><?php
echo $text;
?></p>




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
             请复制其他模板的数据库样式和标识：

       </td>
    </tr>

    <tr>
      <td  class="tr"> </td>
      <td > 
            
      <textarea rows="15" name="dao" class="form-control"></textarea> 

       </td>
    </tr>


    
  <tr>
      <td></td>
      <td>
      <input  class="mysubmit" type="submit" name="Submit" value="确定导入" /></td>
    </tr>
    </table>
<?php echo $inputmust;?>

</form>
<?php }
?>
