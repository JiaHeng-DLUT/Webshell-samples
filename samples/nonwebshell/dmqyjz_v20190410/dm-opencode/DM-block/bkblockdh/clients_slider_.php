 
<div id="<?php echo $dhtrigger;?>" class="slickslider blockclients <?php  echo  $cssname?>">
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
$linkurlarr =  get_nodelinkurl($linkdhurl);
?>
         <div class="img">
              <?php echo $linkurlarr[0];?>
                 <img class="mt10" src="<?php echo $imgv?>"  alt="<?php echo $title?>"> 
              <?php echo $linkurlarr[1];?>    
            </div>
<?php 
 
 }
  ?>
</div>

 <?php 
 $bxauto= 'true';
if(is_int(strpos($cssname,'bxstop'))) $bxauto= 'false'; 
 ?>

 <script>
$(function(){
  //var bxcarouselid = '#<?php echo $dhtrigger?>>ul';
   
   $('#<?php echo $dhtrigger?>').slick({  //use div to avoid gridcol2
 
         infinite: true,
              slidesToShow: <?php echo $cus_columns;?>,
              slidesToScroll: 3,
              autoplay:true,
              responsive: [                  
                  {
                    breakpoint: 800,
                    settings: {
                      slidesToShow: 3,
                      slidesToScroll: 1
                    }
                  },
                  {
                    breakpoint: 480,
                    settings: {
                      slidesToShow: 2,
                      slidesToScroll: 1
                    }
                  }
                  ]


 });


});
</script>
