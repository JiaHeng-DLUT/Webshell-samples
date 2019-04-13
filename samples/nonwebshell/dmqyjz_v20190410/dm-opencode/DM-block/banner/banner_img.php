<?php 
if($banner<>''){
if(!is_int(strpos($banner,'.'))) echo '<p style="padding:10px;background:red;color:#fff">出错，标识'.$banner.' 不是图片，不能用 效果文件：'.$bannereffect.'</p>';
}

if($banner<>''){
	$imgv = UPLOADPATHIMAGE.$banner;
?>
<div class="bannerwrap <?php echo $bannercssname?>" data-file="banner_img">
    <img src="<?php echo $imgv;?>" alt="" style="width:100%" />
</div> 
<?php } ?>