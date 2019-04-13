 
<div class="relativenode imghg180 ">
<h3><?php echo $relativetitle;?></h3>
<div id="<?php echo $dhtrigger;?>">
<ul>
<?php
 
foreach($result as $v){ 
     $title = $v['title'];       
        $titlestyle=$v['titlestyle'];      
      $dateday=substr($v['dateedit'],0,10);                        
     // $despv =  get_nodedespjj($v['despjj'],$v['desp'],$v['desptext'],$cus_substrnum);              
            $kvsm=$v['kvsm'];
            $imgv =  get_img($kvsm);
            $url = get_url($v);
            $titlestylev=$titlestyle<>''?' style="'.$titlestyle.'" ':'';            
            $linkurl = linkhref($url).$titlestylev;

?>
  <li class="zoomimgwrap">
        
             <div class="tc img">
              <a <?php echo $linkurl?>><img class="mt10" src="<?php echo $imgv?>"  alt="<?php echo $title?>"></a>
            </div>
      
            <div class="text tc">
              <h4><a <?php echo $linkurl?>><?php echo $title?></a></h4>    
             
            </div>

      </li>
<?php 
 
 }
  ?>


  
 </ul>
</div>
</div>

 <script>
$(function(){
 
    $('#<?php echo $dhtrigger?>>ul').slick({
      slidesToShow: 5,
      slidesToScroll: 2,
      autoplay: true,
      autoplaySpeed: 2000,
      responsive: [
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1
      }
    }
  ]
    });
 });   
</script> 