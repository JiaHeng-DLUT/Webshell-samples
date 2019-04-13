<?php
if($banner<>''){
if(!is_int(strpos($banner,'.'))) echo '<p style="padding:10px;background:red;color:#fff">出错，标识'.$banner.' 不是图片，不能用 效果文件：'.$bannereffect.'</p>';
}
?>
<div class="bannerwrap <?php echo $bannercssname?>" data-file="banner_bg">
   <?php
   $bannerstyle='';
   $bgrootv = UPLOADROOTIMAGE.$banner;
   $bgv = UPLOADPATHIMAGE.$banner;
   $bgimgv  = "background-image: url('$bgv');";
      if($bannerbg<>'') {
          if($banner<>'') {
            if(is_file($bgrootv)) $bannerstyle= ' style="background-color:'.$bannerbg.';'.$bgimgv.'background-size:auto"';
            else  $bannerstyle = ' style="background-color:'.$bannerbg.'"';
        }
         else $bannerstyle = ' style="background-color:'.$bannerbg.'"';

      }
      else{
          if($banner<>'' &&  is_file($bgrootv)) $bannerstyle= ' style="'.$bgimgv.'"';
      }


   if($bannertext=='') $bannertext = $bannertitle;

   if($bannertext=='hide'){ $bannertext = '';}
   else {
         if($bannertextstyle<>'') $bannertextstyle=' style="'.$bannertextstyle.'"';
     $bannertext = '<h1 '.$bannertextstyle.' class="wow fadeInUp">'.strtoupper(decode($bannertext)).'</h1>';
    }
    ?>
    <div class="bannerbg bannerheight" <?php echo $bannerstyle;?>><?php echo $bannertext;?></div>
</div> 
