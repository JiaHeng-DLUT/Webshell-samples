 
<div id="<?php echo $dhtrigger?>" class="slickslider bannerwater01 <?php echo $cssname;?>" <?php echo $stylev;?>>
 <ul>
<?php 
 
 foreach($result as $k=>$v){
 	 
		
		 $title = $v['title'];
		  $imgv =  get_img($v['kv']);

				   $linkdhtitle = $linkdhurl = $titlebz1=$titlebz2=$titlebz3='';
          $arr_can = $v['arr_can'];
          $bscntarr = explode('==#==',$arr_can); 
          if(count($bscntarr)>1){
            foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
           }
          }



				        $despjj = web_despdecode($v['despjj']);
				        $despv =  get_nodedesp($v['desp'],$v['desptext']);
						
 
 $linkurlarr =  get_nodelinkurl($linkdhurl);
 
?>

<li>		 
	 <img src="<?php echo $imgv?>" alt="<?php echo $title;?>"  />
	
	  <?php 
if(!is_int(strpos($cssname,'opacitybgfalse'))) echo '<div class="opacitybg"> </div>';
	  ?> 
	    <div class="text">
        <h4><?php    echo $title; ?></h4>
        <div class="desp"><?php   echo $despv;   ?></div>
		

        <?php 
            if($linkdhurl<>''){
                  $linkdhtitlev = $linkdhtitle<>''?$linkdhtitle:'查看详情 >'; 
              ?>
              <div class="bkmore dmbtn more3">
  				<a class="more"  <?php echo linkhref($linkdhurl)?> ><?php echo $linkdhtitlev;?></a>
             </div>
               <?php
            } 
        ?>
     
	  </div>

	</li>

 
	<?php
		}
	?>
	</ul>
 </div>

 
<?php 
$ifdots = 'true';
$ifarrows = 'true';
 if(is_int(strpos($cssname,'dotsfalse'))) $ifdots = 'false';
if(is_int(strpos($cssname,'arrowsfalse'))) $ifarrows = 'false'; 
?>
<script>
$(function(){
	   $('#<?php echo $dhtrigger?>>ul').slick({  
	        infinite: true,
              slidesToShow: 1,
              slidesToScroll: 1,
              autoplay:true,
			  fade:true,
			 // vertical:true, 
               dots: <?php echo $ifdots;?>, 
               arrows:  <?php echo $ifarrows;?>,

	 });


});
</script>

