 

<div id="<?php echo $dhtrigger;?>" class="testimonialsbox  <?php  echo  $cssname?>" <?php  echo  $stylev?>>
<?php
 
foreach($result as $v){

          $title = $v['title'];  
          $imgv =  get_img($v['kv']);
         
        
        $despv =  get_nodedesp($v['desp'],$v['desptext']);  

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
          
        // $linkurlarr =  get_nodelinkurl($linkdhurl);


?>
        <div class="<?php echo $cus_columnsv;?>">  
            <div class="testimonialsboxinc">	
				<div class="img"> 
					<div class="imginc">    
						<img src="<?php echo $imgv?>" alt="<?php echo $title?>" />
					</div>
					<div class="title"><span><?php echo $title; ?></span></div>
					<div class="bz"><?php echo $titlebz1; ?></div>
                 </div>
				 <div class="text  wow fadeInUp">  <?php echo $despv?></div> 
			 </div> 
      </div>
<?php 
 
 }
  ?>

</div>

 <?php 
$ifdots = 'true';
$ifarrows = 'true';
 if(is_int(strpos($cssname,'dotsfalse'))) $ifdots = 'false';
if(is_int(strpos($cssname,'arrowsfalse'))) $ifarrows = 'false';
$num800 = $cus_columns<=3?$cus_columns:3;
$num600 = $cus_columns<=2?$cus_columns:2; 
 ?>

 <script>
$(function(){
  //var bxcarouselid = '#<?php echo $dhtrigger?>>ul';
   
   $('#<?php echo $dhtrigger?>').slick({  //use div to avoid gridcol2
 
         infinite: true,
              slidesToShow: <?php echo $cus_columns;?>,
              slidesToScroll: <?php echo $cus_columns;?>,
              autoplay:true,
               dots: <?php echo $ifdots;?>, 
               arrows:  <?php echo $ifarrows;?>,
                 responsive: [                                 
                  {
                    breakpoint: 800,
                    settings: {
                      slidesToShow: <?php echo $num800;?>,
                      slidesToScroll: <?php echo $num800;?>,
                    }
                  },
                   {
                    breakpoint: 600,
                    settings: {
                      slidesToShow: <?php echo $num600;?>,
                      slidesToScroll: <?php echo $num600;?>,
                    }
                  },
                  {
                    breakpoint: 480,
                    settings: {
                      slidesToShow: 1,
                      slidesToScroll: 1,
                    }
                  }
                  ]
 });
});
</script>
