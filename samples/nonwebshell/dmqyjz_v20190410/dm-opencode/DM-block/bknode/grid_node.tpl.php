
 <div id="<?php echo $dhtrigger;?>" class="gridnode <?php echo $cssname;?>" <?php echo $stylev;?>>
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


//echo '<p>'.$kyu.'<p>';
    ?>
     <li class="boxcol wow fadeInUp <?php echo $cus_columnsv;?>">
        <div class="bor">
             <div class="img">
              <a <?php echo $nodeurl;?>>                  
              <img class="mt10" src="<?php echo $imgv?>"  alt="<?php echo $title?>"> 
         <?php 

       if(is_int(strpos($cssname,'bgvideo')))  echo '<div class="bgvideoarrow"></div>';
          
         ?>
            </a>

        
            </div>

             <div class="text">
              <h5 class="tc"><?php echo $title?></h5>    
             <?php 
              if($cus_substrnum>0) echo '<div class="desp">'.$despv.'</div>';
             ?>             
        
              <?php 
              
               if($nodebtnmore<>''){               
              ?>
              <div class="tc dmbtn pb10">
                 <a  class="more"  <?php echo $linkurl;?>><?php echo $nodebtnmore;?>  </a>
              </div>              
               <?php 
               }
              ?>
            </div>
         </div>   
     </li>
  <?php
   if(is_int(strpos($cssname,'sliderenable'))) $kyu=100000;
   if($kyu==0) echo '<li class="c"> </li>';
}
?>
</ul> <div class="c"> </div>
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