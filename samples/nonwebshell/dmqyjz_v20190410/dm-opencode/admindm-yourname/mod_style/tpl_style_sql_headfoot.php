<?php
if($act=='update'){

   if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

 
  $bscnt22 = '';
  if(count($_POST)>1){
          foreach ($_POST as  $k=>$v) {
            if(strtolower($k)=='submit') break;
            $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
             
          }
      }
       $bscnt22 = substr($bscnt22,0,-5);
      //$bscnt22 = "header_bgcolor:##$abc1==#==header_bgimg:##$abc2==#==header_color:##$abc3==#==header_color_a:##$abc4==#==header_color_ahover:##$abc5==#==footer_bgcolor:##$abc6==#==footer_color:##$abc7==#==footer_color_a:##$abc8==#==footer_color_ahover:##$abc9==#==sta_header_width:##$abc10";



   //$ss = "update ".TABLE_STYLE." set header_bgcolor='$abc1',header_bgimg='$abc2',header_color='$abc3',header_color_a='$abc4',header_color_ahover='$abc5',footer_bgcolor='$abc6',footer_bgimg='$abc7',footer_color='$abc8',footer_color_a='$abc9',footer_color_ahover='$abc10',sta_header_width='$abc11' where pidname='$pidname' $andlangbh limit 1";
  
  $ss = "update ".TABLE_STYLE." set  style_hf='$bscnt22' where pidname='$pidname' $andlangbh limit 1";

   //echo $ss;exit;    
   iquery($ss);   
  $jumpv = $jumpv_pf2.'&act=edit';
  jump($jumpv);


}
else{

   $header_bgcolor=$header_bgimg='';
      $header_color=$header_color_a=$header_color_ahover='';
      $footer_bgcolor=$footer_bgimg=$footer_color=$footer_color_a=$footer_color_ahover='';
      $footerbar_bgcolor=$footerbar_color=$footerbar_color_a=$footerbar_color_ahover='';
      $sta_header_width='';
      
  $sql = "SELECT * from ".TABLE_STYLE."  where  pidname='$pidname' $andlangbh   order by id limit 1";
$row = getrow($sql);

$style_hf=$row['style_hf'];

$bscntarr = explode('==#==',$style_hf); 
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }
    


 
$jumpv_insert = $jumpv_pf2.'&act=update';

?>

<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert;?>" method="post">
  <table class="formtab">
    <tr>
      <td width="20%"  class="tr">页头的样式：</td>
      <td> 

      背景色：<input name="header_bgcolor" type="text"  value="<?php echo $header_bgcolor;?>" size="15" />
     <?php spancolor($header_bgcolor);?>
      <div class="inputclear"></div>
 背景图片：  <input name="header_bgimg" type="text"  value="<?php echo $header_bgimg;?>" size="30" />
 <?php   echo  p2030_imgyt($header_bgimg,'y','y'); 
?>

<div class="inputclear"></div>
字体颜色：<input name="header_color" type="text"  value="<?php echo $header_color;?>" size="15" />
 <?php spancolor($header_color);?>
<div class="c15"></div>
<strong>链接的颜色：</strong>
<div class="c5"></div>
默认时：
<input name="header_color_a" type="text"  value="<?php echo $header_color_a;?>" size="15" />
<?php spancolor($header_color_a);?>
 <div class="c5"></div>
   鼠标移上时：
<input name="header_color_ahover" type="text"  value="<?php echo $header_color_ahover;?>" size="15" />
     <?php spancolor($header_color_ahover);?>
 

      </td>
    </tr>
    
   <tr>
      <td width="12%" class="tr">页尾的样式： 
      </td>
      <td width="88%"> 

      背景色：<input name="footer_bgcolor" type="text"  value="<?php echo $footer_bgcolor;?>" size="15" />
     <?php spancolor($footer_bgcolor);?>
<div class="c5"></div>
      背景图片：  <input name="footer_bgimg" type="text"  value="<?php echo $footer_bgimg;?>" size="30" />
 <?php   echo  p2030_imgyt($footer_bgimg,'y','y'); 
?>


   
<div class="inputclear"></div>
字体颜色：<input name="footer_color" type="text"  value="<?php echo $footer_color;?>" size="15" />
 <?php spancolor($footer_color);?>
<div class="c15"></div>

<strong>链接的颜色：</strong>
<div class="c5"></div>
默认时：
<input name="footer_color_a" type="text"  value="<?php echo $footer_color_a;?>" size="15" />
     <?php spancolor($footer_color_a);?>
 <div class="c5"></div>
   鼠标移上时：
<input name="footer_color_ahover" type="text"  value="<?php echo $footer_color_ahover;?>" size="15" />
     <?php spancolor($footer_color_ahover);?>
 

      </td>
    </tr>
    
   
      <tr>
      <td width="12%" class="tr">底部最后一栏的样式： 
      </td>
      <td width="88%"> 

      背景色：<input name="footerbar_bgcolor" type="text"  value="<?php echo $footerbar_bgcolor;?>" size="15" />
     <?php spancolor($footerbar_bgcolor);?>
 

   
<div class="inputclear"></div>
字体颜色：<input name="footerbar_color" type="text"  value="<?php echo $footerbar_color;?>" size="15" />
 <?php spancolor($footerbar_color);?>
<div class="c15"></div>

<strong>链接的颜色：</strong>
<div class="c5"></div>
默认时：
<input name="footerbar_color_a" type="text"  value="<?php echo $footerbar_color_a;?>" size="15" />
     <?php spancolor($footerbar_color_a);?>
 <div class="c5"></div>
   鼠标移上时：
<input name="footerbar_color_ahover" type="text"  value="<?php echo $footerbar_color_ahover;?>" size="15" />
     <?php spancolor($footerbar_color_ahover);?>
 

      </td>
    </tr>
    

   
  <tr>
      <td></td>
      <td>
      <input  class="mysubmit" type="submit" name="Submit" value="提交" /></td>
    </tr>
    </table>

    <?php echo $inputmust;?>
    
</form>
<?php }
?>
<script>
function checkhere(thisForm) {
  
}

</script>
