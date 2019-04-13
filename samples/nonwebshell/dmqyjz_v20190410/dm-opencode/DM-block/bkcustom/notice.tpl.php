<?php 
//删除homenoticejs后，则不自动弹出 。
?>
<div class="homenotice homenoticejs">
   <a class="cnt" data-fancybox data-src="#homenoticedesp" href="javascript:;">
  <?php echo $namefront;?></a>
  <div class="desp" style="display:none"><div id="homenoticedesp"><?php echo $despv?></div></div>
</div>