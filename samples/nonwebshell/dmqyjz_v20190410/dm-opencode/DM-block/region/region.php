  <div class="overlay"></div>
 <?php  
  
  if($sta_title=='y'){

 	?>
 <div class="regionhd <?php if($sta_width_title<>'y') echo ' container';?>">
 <h3 class="hd" <?php echo $titlestylev?>><?php echo $titleimgv?></h3>

<?php if($titlelinelong<>'hide') { ?>
 <div class="titleline  <?php echo $titlelinelongv;?> " <?php echo $titlelinelongstylev; ?>> 
	 <span class="titlelineshort"  <?php echo $titlelineshortstylev?>></span>
 </div>
 <?php } ?>

<?php if($despjj<>'') {?>
 <div class="regsubtitle"<?php echo $titlestylesubv?>><?php echo web_despdecode($despjj)?></div>
<?php }?>

 
</div>
<?php }?>

 <div class="regioncnt<?php if($sta_width_cnt<>'y') echo ' container';?>">   
  <?php
  //echo $allwidth_cntlast;
  				//if($blockid<>'') block($blockid);
               // else echo  $despv;

  if($blockid==''){
      columnecho($v['pidname']);
  }
  else   block($blockid);



				?>
	</div>

 <?php 
   if($linkurl<>'') {  
    $linktitle = $linktitle<>''?$linktitle:'更多';
?>
<div class="c tc regionmore dmbtn mt10">
   <a class="more"  <?php echo linkhref($linkurl);?> ><?php echo $linktitle;?></a>
</div>              
 <?php 
 }
?>