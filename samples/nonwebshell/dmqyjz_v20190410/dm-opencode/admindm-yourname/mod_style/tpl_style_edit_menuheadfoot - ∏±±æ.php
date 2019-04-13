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



  require_once HERE_ROOT.'mod_style/tpl_style_generatecssNEW.php';

 // jump($jumpv);


}
else{

   $header_bgcolor=$header_bgimg='';
      $header_color=$header_color_a=$header_color_ahover='';
      $footer_bgcolor=$footer_bgimg=$footer_color=$footer_color_a=$footer_color_ahover='';
      $headertop_bgcolor=$headertop_color=$headertop_color_a=$headertop_color_ahover='';
      
      
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
      <td width="20%"  class="tr">公共样式：</td>
      <td> 
      网站是否窄屏：<select name="bodynarrow" >
    <?php select_from_arr($arr_yn,$bodynarrow,'');?>
     </select>
      
     <div class="c15"></div>

      网站背景颜色：<input name="bodybg" type="text"  value="<?php echo $bodybg;?>" size="15" />
      <?php spancolor($bodybg);?>
     <div class="c15"></div>
     内容背景颜色：<input name="contentwrapbg" type="text"  value="<?php echo $contentwrapbg;?>" size="15" />
      <?php spancolor($contentwrapbg);?>
     <div class="c15"></div>


     网站字体颜色：<input name="bodycolor" type="text"  value="<?php echo $bodycolor;?>" size="15" />
      <?php spancolor($bodycolor);?>
     <div class="c15"></div>
     
     <strong>链接的颜色：</strong>
     <div class="c5"></div>
     默认时：
     <input name="color_a" type="text"  value="<?php echo $color_a;?>" size="15" />
          <?php spancolor($color_a);?>
 
        鼠标移上时：
     <input name="color_ahover" type="text"  value="<?php echo $color_ahover;?>" size="15" />
          <?php spancolor($color_ahover);?>

          <br /><br />

      </td>
    </tr>
    <tr>
    <td width="12%" class="tr">最顶部一栏的样式： 
    </td>
    <td width="88%"> 

    背景色：<input name="headertop_bgcolor" type="text"  value="<?php echo $headertop_bgcolor;?>" size="15" />
    <?php spancolor($headertop_bgcolor);?>
 
    &nbsp;&nbsp;&nbsp;
 字体颜色：<input name="headertop_color" type="text"  value="<?php echo $headertop_color;?>" size="15" />
 <?php spancolor($headertop_color);?>
 <div class="c15"></div>
 
 <strong>链接的颜色：</strong>
 <div class="c5"></div>
 默认时：
 <input name="headertop_color_a" type="text"  value="<?php echo $headertop_color_a;?>" size="15" />
    <?php spancolor($headertop_color_a);?>
    &nbsp;&nbsp;&nbsp;
  鼠标移上时：
 <input name="headertop_color_ahover" type="text"  value="<?php echo $headertop_color_ahover;?>" size="15" />
    <?php spancolor($headertop_color_ahover);?>
 
    <br /><br />
    </td>
  </tr>
  
    <tr>
      <td width="20%"  class="tr">头部的样式：</td>
      <td> 

      背景色：<input name="header_bgcolor" type="text"  value="<?php echo $header_bgcolor;?>" size="15" />
     <?php spancolor($header_bgcolor);?> 
      </td>
    </tr>
    
   <tr>
      <td width="12%" class="tr">底部的样式： 
      </td>
      <td width="88%"> 

      背景色：<input name="footer_bgcolor" type="text"  value="<?php echo $footer_bgcolor;?>" size="15" />
     <?php spancolor($footer_bgcolor);?>

     &nbsp;&nbsp;&nbsp;
字体颜色：<input name="footer_color" type="text"  value="<?php echo $footer_color;?>" size="15" />
 <?php spancolor($footer_color);?>
<div class="c15"></div>

<strong>链接的颜色：</strong>
<div class="c5"></div>
默认时：
<input name="footer_color_a" type="text"  value="<?php echo $footer_color_a;?>" size="15" />
     <?php spancolor($footer_color_a);?>
     &nbsp;&nbsp;&nbsp;
   鼠标移上时：
<input name="footer_color_ahover" type="text"  value="<?php echo $footer_color_ahover;?>" size="15" />
     <?php spancolor($footer_color_ahover);?>
 
     <br /><br />
      </td>
    </tr>
    
   
      

   
 
  <tr style="background:#2480C4;color:#fff">
  <td > </td>
      <td   class="tl">提示： 
   这里的菜单模板仅作用于PC端。如果改移动端，请改相关的css文件。</td>
    </tr>   
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
   &nbsp; &nbsp; &nbsp;

链接颜色：  <input name="menu_color" type="text"  value="<?php echo $menu_color;?>" size="15" />
   <?php spancolor($menu_color);?>
 <div class="inputclear" style="height:20px"> </div>


<strong>鼠标移上去时:</strong><br />
 背景色：  <input name="menu_bgcolor_h" type="text"  value="<?php echo $menu_bgcolor_h;?>" size="15" />
   <?php spancolor($menu_bgcolor_h);?>

   &nbsp; &nbsp; &nbsp;
链接颜色：  <input name="menu_color_h" type="text"  value="<?php echo $menu_color_h;?>" size="15" />
    <?php spancolor($menu_color_h);?>

    <br /><br />
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
   &nbsp; &nbsp; &nbsp;
链接颜色：  <input name="msub_color" type="text"  value="<?php echo $msub_color;?>" size="15" />
   <?php spancolor($msub_color);?>

 <div class="inputclear" style="height:20px"> </div>


<strong>鼠标移上去时:</strong><br />
 背景色 <input name="msub_bgcolor_h" type="text"  value="<?php echo $msub_bgcolor_h;?>" size="15" />
   <?php spancolor($msub_bgcolor_h);?>
   &nbsp; &nbsp; &nbsp;

 链接颜色：  <input name="msub_color_h" type="text"  value="<?php echo $msub_color_h;?>" size="15" />
    <?php spancolor($msub_color_h);?>

    <br /><br />
      </td>
    </tr>
    <tr style="background:#2480C4;color:#fff">
  <td > </td>
      <td   class="tl">其他</td>
    </tr>

    <tr>
      <td  width="20%"  class="tr">侧边栏标题：<br /><br /></td>
      <td > 
  背景色：   
   <input name="boxtitle_bgcolor" type="text"  value="<?php echo $boxtitle_bgcolor;?>" size="15" />
   <?php spancolor($boxtitle_bgcolor);?>
   &nbsp; &nbsp; &nbsp;
 
 字体的颜色： 
   <input name="boxtitle_color" type="text"  value="<?php echo $boxtitle_color;?>" size="15" />
     <?php spancolor($boxtitle_color);?>

     <br /><br />

  </td>
    </tr>

    <tr style="background:#2480C4;color:#fff">
  <td > </td>
      <td   class="tl">自定义css</td>
    </tr>

    <tr>
      <td  width="20%"  class="tr">自定义css：</td>
      <td > 
  <textarea  style="height:450px" name = "customcss_textarea"  class="form-control"><?php echo $customcss_textarea?></textarea>

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
