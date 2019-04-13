 
<div id="<?php echo $dhtrigger;?>" class="  <?php echo $cssname;?>" <?php echo $stylev;?>>
 <ul>
<?php 
 foreach($result as $k=>$v){
    
    $title=$v['title'];
      $titlestyle=$v['titlestyle'];      
      $dateday=substr($v['dateedit'],0,10);                        
      $despv =  get_nodedespjj($v['despjj'],$v['desp'],$v['desptext'],$cus_substrnum);              
            $kvsm=$v['kvsm'];
            $imgv =  get_img($kvsm);
            $url = get_url($v);
            $titlestylev=$titlestyle<>''?' style="'.$titlestyle.'" ':'';            
            $nodeurl = linkhref($url).$titlestylev; 


  $kjia = $k+1; 
  $kyu = $kjia%$cus_columns;
?>
 <li class="gcoverlayjia  <?php echo $cus_columnsv;?>">
     <a  <?php echo $nodeurl;?>>
         <div class="overlay"><span>+</span></div>
           <div class="img">
              <img src="<?php echo $imgv?>" alt="<?php echo $title?>">
            </div>
           <h3><?php echo $title?></h3>
    </a> 
</li>

 <?php
    if(is_int(strpos($cssname,'sliderenable'))) $kyu=100000;
   if($kyu==0) echo '<li class="c"> </li>';
    }
 ?>
 </ul><div class="c"> </div>
  </div>
<div class="c"> </div>

<?php 
if(is_int(strpos($cssname,'sliderenable'))){

 
$ifdots = 'true';
$ifarrows = 'true';
 if(is_int(strpos($cssname,'dotsfalse'))) $ifdots = 'false';
if(is_int(strpos($cssname,'arrowsfalse'))) $ifarrows = 'false'; 
 
$num800 = $cus_columns<=3?$cus_columns:3;
$num600 = $cus_columns<=2?$cus_columns:2;
?>
 <script>
$(function(){
    

    $('#<?php echo $dhtrigger?>>ul').slick({ 
 
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
<?php 
}
?>