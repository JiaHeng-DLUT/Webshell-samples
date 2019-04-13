 
<div id="<?php echo $dhtrigger?>" class="slickslider fullsliders dmfull_height <?php echo $cssname;?>" <?php echo $stylev;?>>
  <ul>    
 <?php 
     

       foreach($result as $k=>$v){
              $title = $v['title']; 
                $imgv =  get_img($v['kv']); 
                
               // $imgv2 = testimgfunc($k,$testimgfolder);
               //if($imgv2<>'no') $imgv = $imgv2; 

               // $despjj = web_despdecode($v['despjj']);
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
    <li style="background-image:url(<?php echo $imgv?>)">
    <div class="opacitybg"> </div>
     <?php 
    if(!is_int(strpos($cssname,'hideslidetext'))){
      ?>
      <div class="text textcolor">
       
        <h4 class="wow fadeInDown"><?php    echo $title; ?></h4>
        <div class="desp wow fadeInUp"><?php   echo $despv;   ?></div>
       

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
       <?php
       }
       ?>
    </li>

 <?php 
}
 ?>
 
  </ul>
</div><!--sliders-->
 
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
              speed: 500,
              autoplay:true,
               dots: <?php echo $ifdots;?>, 
               arrows:  <?php echo $ifarrows;?>,
 });

});
</script>

