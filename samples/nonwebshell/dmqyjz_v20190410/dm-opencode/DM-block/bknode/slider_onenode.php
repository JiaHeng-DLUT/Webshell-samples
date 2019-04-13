 
<div id="<?php echo $dhtrigger?>" class="slickslider sliderdotsright <?php   echo $cssname;?>" <?php   echo $stylev;?>> 
 

<ul>
<?php 
 
 foreach($result as $k=>$v){
 		 
       $title=$v['title'];
      $titlestyle=$v['titlestyle'];      
      $dateday=substr($v['dateedit'],0,10);                        
     // $despv =  get_nodedespjj($v['despjj'],$v['desp'],$v['desptext'],$cus_substrnum);              
            $kvsm=$v['kvsm'];
            $kv=$v['kv'];
            if($kv<>'')  $imgv =  get_img($kv);
            else  $imgv =  get_img($kvsm);
           
            $url = get_url($v);
            $titlestylev=$titlestyle<>''?' style="'.$titlestyle.'" ':'';            
            $nodeurl = linkhref($url).$titlestylev;

?>
    <li class="img">
		<a <?php echo $nodeurl;?>> 
		  <img src="<?php echo $imgv;?>" alt="<?php echo $title;?>" style="width:100%;height:auto"  />
		 </a>
     <div class="title"><?php echo $title;?> </div>
 
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
              autoplaySpeed:2000,
              speed:1000,
               dots: <?php echo $ifdots;?>, 
               arrows:  <?php echo $ifarrows;?>,

	 });


});
</script>
