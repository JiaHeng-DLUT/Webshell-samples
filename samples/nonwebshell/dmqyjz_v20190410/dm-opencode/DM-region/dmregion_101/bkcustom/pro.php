  <?php
       if($despv<>'') echo '<div class="desp">'.$despv.'</div>';
 ?>

 <?php 
$ifdots = 'false';
$ifarrows = 'true';
 //if(is_int(strpos($cssname,'dotsfalse'))) $ifdots = 'false';
//if(is_int(strpos($cssname,'arrowsfalse'))) $ifarrows = 'false'; 
//$num800 = $cus_columns<=3?$cus_columns:3;
//$num600 = $cus_columns<=2?$cus_columns:2;
$num800 = 3;
$num600 = 2;
?>
 <script>
$(function(){
      $('.wineproslider').slick({ 
          infinite: true,
              slidesToShow: 4,
              slidesToScroll: 1,
              autoplay:true, 
              dots: <?php echo $ifdots;?>, 
              arrows:  <?php echo $ifarrows;?>,
                responsive: [                                 
                  {
                    breakpoint: 800,
                    settings: {
                      slidesToShow: <?php echo $num800;?>,
                      slidesToScroll:  <?php echo $num800;?>,
                    }
                  },
                   {
                    breakpoint: 600,
                    settings: {
                      slidesToShow: <?php echo $num600;?>,
                      slidesToScroll:  <?php echo $num600;?>,
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