   链接网址： &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="linkurl" type="text" value="<?php echo $linkurl?>"  class="form-control" />
<?php echo $xz_maybe;?> <span class="cgray">(如果有值，则会出现 链接)</span>

 <div class="inputclear"> </div>
 链接的字样：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="linktitle" type="text" value="<?php echo $linktitle?>"  size="30" />
<?php echo $xz_maybe;?> <span class="cgray">(可以填写‘查看详情’，如果不填，则为 ‘更多’)</span>
 <div class="inputclear"> </div>

 链接的颜色：
<select name="linkcss"> 
<?php select_from_arr($arr_linkmore,$linkcss,'');?>
   </select>
    <div class="inputclear"> </div>

  链接的尺寸：
<select name="linksize"> 
<?php select_from_arr($arr_linksize,$linksize,'');?>
 </select>
  <div class="inputclear"> </div>

 
 <div class="inputclear"> </div>

  是否圆角： 在cssname里加上morenocir(无圆角) 或 morecir50(更圆些) 试下