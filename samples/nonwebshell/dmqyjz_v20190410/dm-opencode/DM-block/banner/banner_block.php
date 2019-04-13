<?php 
global $banner;global $bannercssname;
if($banner<>''){
?>
<div class="bannerwrap <?php echo $bannercssname?>" data-file="banner_block">
   <?php 
    block($banner);
   ?>
</div> 
<?php } ?>