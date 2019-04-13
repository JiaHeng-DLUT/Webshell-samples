 <?php 
 $dhtrigger = 'slick'.rand(1000,9999);  
 ?>
<div id="<?php echo $dhtrigger?>"  class="mobishopalbum"> 
 

<ul>
<?php 
global $detail_title;
 //echo $detail_title;
 foreach($row_abm as $v){
 		 
 		 	$tid=$v['id'];
			$title=$v['title'];			  
            $kvsm=$v['kvsm'];
			$desp=$v['desp'];		

			if($title=='')  $title = $detail_title;
       

 			//if(strpos($albumcssname, 'ridbigimg')>0) $img=get_img($kvsm,$title,'divno');//thumb use big
 			//else $img=get_thumb($kvsm,$title,'divno');

 		     $imgbig=get_img($kvsm,$title,'nodiv');
?>
    <li class="img">
		  
		    <a href="<?php echo $imgbig?>"  data-fancybox="gallery" data-caption="<?php echo $title;?>"> 
		    <img src="<?php echo $imgbig;?>" alt="<?php echo $title;?>" style="width:100%;height:auto"  />
		    </a>
	 
	</li>
	<?php
		}
	?>
</ul>
</div>


 <div class="mobishopalbumlist" >
   <ul>
   
            <?php
 foreach($row_abm as $k=>$v){
               
			$tid=$v['id'];
			$title=$v['title'];			  
            $kvsm=$v['kvsm'];
			 
       $img=get_thumb($kvsm,$title,'nodiv');
      $imgbig=get_img($kvsm,$title,'nodiv');
?>
   <li><img class="" src="<?php echo $img;?>"  data-imgmid="<?php echo $imgbig;?>"  data-imgbig="<?php echo $imgbig;?>" alt="<?php echo $title;?>" /></li>
   
   <?php
		}
   ?>
        

     </ul>
 </div>


 <?php
getCssSingle(STAPATH.'assets/vendor/albumlarge/albumlarge.css');
//getJsSingle(STAPATH.'assets/vendor/albumlarge/albumlarge.js');
?>



 <?php 
$ifdots = 'true';
$ifarrows = 'true';
 if(is_int(strpos($cssname,'dotsfalse'))) $ifdots = 'false';
if(is_int(strpos($cssname,'arrowsfalse'))) $ifarrows = 'false'; 

$ifdots = 'false';
?>

<script>
$(function(){
	    $('#<?php echo $dhtrigger?>>ul').slick({ 
	        infinite: true,
              slidesToShow: 1,
              slidesToScroll: 1,
              autoplay:true,
               dots: <?php echo $ifdots;?>, 
               arrows:  <?php echo $ifarrows;?>,

	 });

$('.mobishopalbumlist li').eq(0).addClass('active');

$('.mobishopalbumlist li').click(function(){
	var indexv = $(this).index();

	$('.mobishopalbumlist li').removeClass('active').eq(indexv).addClass('active');

	//alert(indexv);
	$('#<?php echo $dhtrigger?>>ul').slick('slickGoTo', indexv);

});
 
//---------------
	

});
</script>

 