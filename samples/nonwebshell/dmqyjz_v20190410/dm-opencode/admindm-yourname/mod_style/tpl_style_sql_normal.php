<?php
if($act=='update'){

   if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

 //pre($_POST);
 $bscnt22 = '';
  if(count($_POST)>1){
          foreach ($_POST as  $k=>$v) {
            if(strtolower($k)=='submit') break;
            $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
             
          }
      }
//echo substr($bscnt22,0,-5);
      $bscnt22 = substr($bscnt22,0,-5);
 //$bscnt22 = "sta_widthscreen:##$abc1==#==pagewidth:##$abc2==#==body_bgcolor:##$abc3==#==body_bgimg:##$abc4==#==body_bgimgset:##$abc5==#==color_body:##$abc6==#==color_a:##$abc7==#==color_ahover:##$abc8";


   //$ss = "update ".TABLE_STYLE." set sta_widthscreen='$abc2',pagewidth='$abc3',body_bgcolor='$abc4',body_bgimg='$abc5',body_bgimgset='$abc6',color_body='$abc7',color_a='$abc8',color_ahover='$abc9' where pidname='$pidname' $andlangbh limit 1";
  $ss = "update ".TABLE_STYLE." set  style_normal='$bscnt22' where pidname='$pidname' $andlangbh limit 1";

 //echo $ss;exit;    
   iquery($ss);   
  $jumpv = $jumpv_pf2.'&act=edit';
    jump($jumpv);


}
else{

   $body_bgcolor=$body_bgimg=$body_bgimgset=$sta_widthscreen=$pagewidth='';
      $color_body=$color_a=$color_ahover='';
      
  $sql = "SELECT * from ".TABLE_STYLE."  where  pidname='$pidname' $andlangbh   order by id limit 1";
$row = getrow($sql);
$style_normal=$row['style_normal'];

$bscntarr = explode('==#==',$style_normal); 
//pre($bscntarr);
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
      <td  width="20%"  class="tr">页面宽度：</td>
      <td > 
        <input name="pagewidth" type="text"  value="<?php echo $pagewidth;?>" size="15" /> 
         比如：1200px
         </td>
    </tr>


    <tr>
      <td width="12%" class="tr">页面(body)的样式：</td>
      <td width="88%"> 

     页面的背景色：<input name="body_bgcolor" type="text"  value="<?php echo $body_bgcolor;?>" size="15" />
     <?php spancolor($body_bgcolor);?>
<div class="c5"></div>
页面的背景图片：<input name="body_bgimg" type="text"  value="<?php echo $body_bgimg;?>" size="30" />
 <?php   echo  p2030_imgyt($body_bgimg,'y','y'); 
       ?> 
<div class="c5"></div>
页面的背景图片的设置：
 <select name="body_bgimgset">
    <?php select_from_arr($arr_body_bgset,$body_bgimgset,'');?>
     </select>

      </td>
    </tr>
    
     <tr>
      <td   class="tr">字体的颜色：</td>
      <td > 
      页面字体颜色：
   <input name="color_body" type="text"  value="<?php echo $color_body;?>" size="15" />
   <?php spancolor($color_body);?>
 <div class="inputclear"> </div>
 <strong>链接的颜色：</strong>
   <br />
     默认时：<input name="color_a" type="text"  value="<?php echo $color_a;?>" size="15" />
     <?php spancolor($color_a);?>
  <span class="inputhengdivi"></span>
   <div class="inputclear"> </div>
   鼠标移上时：
   <input name="color_ahover" type="text"  value="<?php echo $color_ahover;?>" size="15" /><?php spancolor($color_ahover);?>
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
   if (thisForm.name.value=="")
  {
    alert("请输入标题。");
    thisForm.name.focus();
    return (false);
  } 
}

</script>
