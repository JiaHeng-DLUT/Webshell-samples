 
<div id="<?php echo $dhtrigger?>" class="slickslider slicknormal_bg <?php echo $cssname;?>" <?php   echo $stylev;?>> 
 

<ul>
<?php 
 
 foreach($result as $k=>$v){
 		  $title = $v['title']; 
        $imgv =  get_img($v['kv']);

        
         
      //  $despjj = $v['despjj']; //副标题
       
        $stylvev = '';
        //if($k<>0) $stylvev = ' style="display:none" ';

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

 $bgv = 'style="background-image:url('.$imgv.');"';

?>
 <?php echo $linkurlarr[0];?>
    <li class="img"   <?php  echo $bgv;?>>  </li>	
	<?php echo $linkurlarr[1];?>  
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
              dots: <?php echo $ifdots;?>, 
               arrows:  <?php echo $ifarrows;?>,

	 });


});
</script>

