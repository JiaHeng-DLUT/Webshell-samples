
<tr style="background:#fcf6ee">
<td  class="tr">链接：</td>
 <td width="78%">

 字样： <input name="linktitle" type="text" value="<?php echo $linktitle?>"  size="30" />
<?php echo $xz_maybe;?>
 <div class="inputclear"> </div>

网址：  <input name="linkurl" type="text" value="<?php echo $linkurl?>"  class="form-control" />
<?php echo $xz_maybe;?>

 </td>
</tr>


<tr style="background:#fff">
 <td class="tr">背景： </td>
 <td>

 背景色：
<input name="bgcolor" type="text" value="<?php echo $bgcolor?>"  size="35" /><?php echo $xz_maybe;?>
          <?php spancolor($bgcolor);?>
           (<a target="_blank" href="<?php echo $dmlink_color;?>">配色方案</a>)
        <div class="inputclear"> </div>


背景图片：
<input name="bgimg" type="text" value="<?php echo $bgimg?>" size="25" />
<a class="needpopup" href="../mod_imgfj/mod_imgfj.php?pid=name&lang=<?php echo LANG; ?>"  >名称附件</a>

 <?php
 if($bgimg<>''){
     $bgimgv = UPLOADROOTIMAGE.$bgimg;
      if(!is_file($bgimgv)) echo '<p class="cred">'.$bgimg.'图片不存在，请检查。</p>';
      else echo p2030_imgyt($bgimg,'y','y') ;
 }
 ?>
 <div class="inputclear"> </div>

 背景图片的位置：
 <input name="bgposi" type="text" value="<?php echo $bgposi?>" size="25" />
<span class="cgray">参考： center center </span>
 <div class="inputclear"> </div>


背景图片是否固定：
<input name="bgattach" type="text" value="<?php echo $bgattach?>" size="25" />
<span class="cgray">参考：fixed 或者 scroll </span>
<div class="inputclear"> </div>

背景图片重复：
<input name="bgrepeat" type="text" value="<?php echo $bgrepeat?>" size="25" />
<span class="cgray">参考：no-repeat 或者  repeat-x 或者  repeat-y </span>
<div class="inputclear"> </div>
背景图片尺寸：
<input name="bgsize" type="text" value="<?php echo $bgsize?>" size="25" />
 <span class="cgray">参考：cover 或者 contain</span>

 </td>
</tr>
