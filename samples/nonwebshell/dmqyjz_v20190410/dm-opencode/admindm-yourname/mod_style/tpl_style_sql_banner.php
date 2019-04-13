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

$ss = "update ".TABLE_STYLE." set  style_banner='$bscnt22' where pidname='$pidname' $andlangbh limit 1";

//echo $bscnt22;
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

$style_banner=$row['style_banner'];
//echo $style_boxtitle;

$bscntarr = explode('==#==',$style_banner); 
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
      <td  width="20%" class="tr">banner样式：
          <br />
          <span class="cgray">除首页外的banner样式</span>

      </td>
      <td > 
     
 是否开启：
 <select name="banner_enable">
    <?php select_from_arr($arr_yn,$banner_enable,'');?>
     </select>
     <br />
     <span class="cgray">(如果布局里的banner有值。则 虽然这里开启了，会也不在前台显示。
     <br />如果要显示，方法一：把对应页面的banner值设置为空，或者方法二：通过下面的设置把所有的banner隐藏。)</span>
      <div class="c5"></div>

  隐藏布局里的banner设置：
 <select name="banner_textfirst">
    <?php select_from_arr($arr_yn,$banner_textfirst,'');?>
     </select>
     <br />
     <span class="cgray">(只有上面开启了，这里的隐藏设置才在前台有效。)</span>
      <div class="c5"></div>

 
        样式：  <input name="banner_style" type="text"  value="<?php echo $banner_style;?>" class="form-control" />
        比如： padding-top:120px;padding-bottom:100px
       <div class="c15"> </div>

      背景色：   
   <input name="banner_bgcolor" type="text"  value="<?php echo $banner_bgcolor;?>" size="15" />
   <?php spancolor($banner_bgcolor);?>
 <div class="c15"> </div>
 背景图片：<input name="banner_bgimg" type="text"  value="<?php echo $banner_bgimg;?>" size="30" />
<?php   echo  p2030_imgyt($banner_bgimg,'y','y'); 
       ?> 
 <div class="c15"> </div>
 字体的颜色： 
   <input name="banner_color" type="text"  value="<?php echo $banner_color;?>" size="15" />
     <?php spancolor($banner_color);?>
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
