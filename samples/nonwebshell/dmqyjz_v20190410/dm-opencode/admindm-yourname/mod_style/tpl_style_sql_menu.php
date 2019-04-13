<?php

if($act=='update'){

   if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

  $bscnt22 = '';
//pre($_POST);
  if(count($_POST)>1){
          foreach ($_POST as  $k=>$v) {
            if(strtolower($k)=='submit') break;
            $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
             
          }
      }
       $bscnt22 = substr($bscnt22,0,-5);
    //  echo $bscnt22;
      //$bscnt22 = "menu_height:##$abc1==#==menu_border:##$abc2==#==menu_bgcolor:##$abc3==#==menu_bgimg:##$abc4==#==menu_color:##$abc5==#==menu_bgcolor_h:##$abc6==#==menu_bgimg_h:##$abc7==#==menu_color_h:##$abc8==#==msub_height:##$abc9==#==msub_border:##$abc10==#==msub_bgcolor:##$abc11==#==msub_color:##$abc12==#==msub_bgcolor_h:##$abc13==#==msub_color_h:##$abc14==#==sta_menuright:##$abc15";

   //$ss = "update ".TABLE_STYLE." set menu_height='$abc1',menu_border='$abc2',menu_bgcolor='$abc3',menu_bgimg='$abc4',menu_color='$abc5',menu_bgcolor_h='$abc6',menu_bgimg_h='$abc7',menu_color_h='$abc8',msub_height='$abc9',msub_border='$abc10',msub_bgcolor='$abc11',msub_color='$abc12',msub_bgcolor_h='$abc13',msub_color_h='$abc14',sta_menuright='$abc15' where pidname='$pidname' $andlangbh limit 1";
    $ss = "update ".TABLE_STYLE." set  style_menu='$bscnt22' where pidname='$pidname' $andlangbh limit 1";

   //echo $ss;exit;    
   iquery($ss); 
  $jumpv = $jumpv_pf2.'&act=edit';
   jump($jumpv);

}
else{

   $menu_bgcolor=$menu_bgimg=$menu_color='';
      $menu_bgcolor_h=$menu_bgimg_h=$menu_color_h='';
      $menu_height=$menu_border='';

      $msub_bgcolor=$msub_color='';
      $msub_bgcolor_h=$msub_color_h='';
      $msub_height=$msub_border='';

      $sta_menuright=$sta_menufix=''; 

      
  $sql = "SELECT * from ".TABLE_STYLE."  where pidname='$pidname' $andlangbh   order by id limit 1";
$row = getrow($sql);


$style_menu=$row['style_menu'];

$bscntarr = explode('==#==',$style_menu); 
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

 
  <p class="hintbox">提示： 
   这里的菜单模板仅作用于PC端。如果改移动端，请改相关的css文件。
  </p>

<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert;?>" method="post">
  <table class="formtab">
  
  <tr>
      <td width="20%"  class="tr">主菜单的样式：</td>
      <td > 

   高度：
   <input name="menu_height" type="text"  value="<?php echo $menu_height;?>" size="15" />
   比如：60px
   <div class="c5"> </div>

   下划线样式：
   <input name="menu_border" type="text"  value="<?php echo $menu_border;?>" size="15" />
   比如：1px solid red

   <div class="c5"> </div>

     <strong>默认时:</strong>
      <br />
 背景色： <input name="menu_bgcolor" type="text"  value="<?php echo $menu_bgcolor;?>" size="15" />
   <?php spancolor($menu_bgcolor);?>
  <div class="c5"> </div>
 背景图片：  <input name="menu_bgimg" type="text"  value="<?php echo $menu_bgimg;?>" size="30" />
 <?php   echo  p2030_imgyt($menu_bgimg,'y','y'); 
       ?> 
 <div class="c5"> </div>

链接颜色：  <input name="menu_color" type="text"  value="<?php echo $menu_color;?>" size="15" />
   <?php spancolor($menu_color);?>
 <div class="inputclear" style="height:20px"> </div>


<strong>鼠标移上去时:</strong><br />
 背景色：  <input name="menu_bgcolor_h" type="text"  value="<?php echo $menu_bgcolor_h;?>" size="15" />
   <?php spancolor($menu_bgcolor_h);?>
 <div class="c5"> </div>
背景图片：  <input name="menu_bgimg_h" type="text"  value="<?php echo $menu_bgimg_h;?>" size="30" />
 <?php   echo  p2030_imgyt($menu_bgimg_h,'y','y'); 
       ?> 
 <div class="c5"> </div>
链接颜色：  <input name="menu_color_h" type="text"  value="<?php echo $menu_color_h;?>" size="15" />
    <?php spancolor($menu_color_h);?>

  
      </td>
    </tr>


 <tr>
      <td   class="tr">下拦子菜单的样式：</td>
      <td > 

   高度：
   <input name="msub_height" type="text"  value="<?php echo $msub_height;?>" size="15" />
   比如：30px

   <div class="c5"> </div>

   下划线样式：
   <input name="msub_border" type="text"  value="<?php echo $msub_border;?>" size="30" />
   比如：1px solid red
   <div class="c5"> </div>

     <strong>默认时:</strong>
      <br />
 背景色： <input name="msub_bgcolor" type="text"  value="<?php echo $msub_bgcolor;?>" size="15" />
   <?php spancolor($msub_bgcolor);?>
   <div class="c5"> </div>
链接颜色：  <input name="msub_color" type="text"  value="<?php echo $msub_color;?>" size="15" />
   <?php spancolor($msub_color);?>

 <div class="inputclear" style="height:20px"> </div>


<strong>鼠标移上去时:</strong><br />
 背景色 <input name="msub_bgcolor_h" type="text"  value="<?php echo $msub_bgcolor_h;?>" size="15" />
   <?php spancolor($msub_bgcolor_h);?>
 <div class="c5"> </div>

 链接颜色：  <input name="msub_color_h" type="text"  value="<?php echo $msub_color_h;?>" size="15" />
    <?php spancolor($msub_color_h);?>

  
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
