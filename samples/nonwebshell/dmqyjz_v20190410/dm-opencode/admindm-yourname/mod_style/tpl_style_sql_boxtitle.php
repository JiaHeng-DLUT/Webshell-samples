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
 //$bscnt22 = "boxtitle_height:##$abc1==#==boxtitle_bgcolor:##$abc2==#==boxtitle_bgimg:##$abc3==#==boxtitle_color:##$abc4";

   //$ss = "update ".TABLE_STYLE." set boxtitle_height='$abc1',boxtitle_bgcolor='$abc2',boxtitle_bgimg='$abc3',boxtitle_color='$abc4'  where pidname='$pidname' $andlangbh limit 1";

$ss = "update ".TABLE_STYLE." set  style_boxtitle='$bscnt22' where pidname='$pidname' $andlangbh limit 1";


//echo $ss;exit;    
   iquery($ss);   
  $jumpv = $jumpv_pf2.'&act=edit';
  jump($jumpv);


}
else{

   $boxtitle_height=$boxtitle_bgcolor='';
      $boxtitle_bgimg=$boxtitle_color='';
      
  $sql = "SELECT * from ".TABLE_STYLE."  where  pidname='$pidname' $andlangbh   order by id limit 1";
$row = getrow($sql);

$style_boxtitle=$row['style_boxtitle'];
//echo $style_boxtitle;

$bscntarr = explode('==#==',$style_boxtitle); 
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
      <td  width="20%"  class="tr">传统盒子：</td>
      <td > 
      高度：  <input name="boxtitle_height" type="text"  value="<?php echo $boxtitle_height;?>" size="15" />
        比如：40px
       <div class="c15"> </div>
      背景色：   
   <input name="boxtitle_bgcolor" type="text"  value="<?php echo $boxtitle_bgcolor;?>" size="15" />
   <?php spancolor($boxtitle_bgcolor);?>
 <div class="c15"> </div>
 背景图片：<input name="boxtitle_bgimg" type="text"  value="<?php echo $boxtitle_bgimg;?>" size="30" />
<?php   echo  p2030_imgyt($boxtitle_bgimg,'y','y'); 
       ?> 
 <div class="c15"> </div>
 字体的颜色： 
   <input name="boxtitle_color" type="text"  value="<?php echo $boxtitle_color;?>" size="15" />
     <?php spancolor($boxtitle_color);?>
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
