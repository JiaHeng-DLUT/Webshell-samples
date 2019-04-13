 
 
<tr>
<td colspan="2" class="trbg">
  区域参数
</td></tr>

<tr  style="background:#fff">
<td  class="tr">显示标题：</td>
<td >     
 
<select name="sta_title"> <?php select_from_arr($arr_yn,$sta_title,'');?>
</select>
<?php 
if($sta_title<>'y') echo '<p class="hintbox">提示：标题已设置为不显示</p>';
?> 
  </td>
</tr>


  
   <tr  style="background:#fff">
      <td  class="tr"> 宽度：</td>
      <td >   
      标题是否全宽：  
<select name="sta_width_title"> <?php select_from_arr($arr_yn,$sta_width_title,'');?>
     </select>
       <div class="c5"> </div>
      内容是否全宽： 
        
<select name="sta_width_cnt"> <?php select_from_arr($arr_yn,$sta_width_cnt,'');?>
     </select>
     
        </td>
    </tr> 
 
  


<tr>
<td colspan="2" class="trbg">
  区域的标题参数 
</td></tr>

 

 <tr  style="background:#fff">
      <td  class="tr">标题用图片代替：</td>
     <td >     
     <input name="titleimg" type="text" value="<?php echo $titleimg?>"  size="35" /> <?php echo $xz_maybe;?>  
 <?php echo  p2030_imgyt($titleimg,'y','y');
 ?> 
        </td>
    </tr>


 <tr  style="background:#fff">
      <td  class="tr">标题的样式：</td>
     <td >     
     <input name="titlestyle" type="text" value="<?php echo $titlestyle?>"  size="35"  /> <?php echo $xz_maybe;?>  
 
 <span class="cgray">试下： color:red </span>
        </td>
    </tr>

 <tr  style="background:#fff">
      <td  class="tr">副标题的样式：</td>
     <td >     
     <input name="titlestylesub" type="text" value="<?php echo $titlestylesub?>"  size="35"  /> <?php echo $xz_maybe;?>  
 
  <span class="cgray">试下： color:red </span>
        </td>
    </tr>


     <tr>
      <td  class="tr">标题下划线的颜色  -- 长：</td>
      <td >      
          <input   name="titlelinelong" type="text" value="<?php echo $titlelinelong?>"   size="35"  /> <?php echo $xz_maybe;?>   
          <?php 
          if($titlelinelong<>'')  spancolor($titlelinelong); 
          ?><br />
        <span class="cgray">默认会有颜色，如果为none则无颜色，如果为hide则隐藏长短下划线。 </span>
        <br /> (<a target="_blank" href="<?php echo $dmlink_color;?>">配色方案</a>)
   </td>
    </tr> 

 <tr>
      <td  class="tr">标题下划线的颜色  -- 短：</td>
      <td >  
      <input  name="titlelineshort" type="text" value="<?php echo $titlelineshort?>"   size="35" /> <?php echo $xz_maybe;?>  
 
<?php 
          if($titlelineshort<>'')  spancolor($titlelineshort); 
          ?><br />
        <span class="cgray">默认会有颜色，如果为none则无颜色 </span>

        </td>
    </tr> 

   

 



