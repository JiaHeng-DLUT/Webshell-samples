
 <div id="<?php echo $dhtrigger?>" class="news_scroll <?php   echo $cssname;?>"> 
 
  <ul>       
<?php 
 foreach($result as $v){

      $title=$v['title'];
      $titlestyle=$v['titlestyle'];       
      $dateday=substr($v['dateedit'],0,10);                        
      $despv =  get_nodedespjj($v['despjj'],$v['desp'],$v['desptext'],$cus_substrnum);  
      
      $url = get_url($v);
      $titlestylev=$titlestyle<>''?' style="'.$titlestyle.'" ':'';            
      $nodeurl = linkhref($url).$titlestylev;


 $arrdate = explode("-",$dateday);
 $year = @$arrdate[0];
 $month = @$arrdate[1];
 $day = intval(@$arrdate[2]);
 

 //$month = intval(@$arrdate[1]);
// $Month_E = array(1 => "Jan",
//         2 => "Feb",
//         3 => "Mar",
//         4 => "Apr",
//         5 => "May",
//         6 => "Jun",
//         7 => "Jul",
//         8 => "Aug",
//         9 => "Sep",
//         10 => "Oct",
//         11 => "Nov",
//         12 => "Dec");

//     $monthen = @$Month_E[$month];
     
 
   ?>


<li class="listgd">
     <div class="listleft">         
            <div class="circle">
            <div class="date">
              <span class="day"><?php echo $day?></span>
              <span class=""><?php echo $year.'-'.$month;?>  </span>           
            </div>                
            </div>
          </div>
           
		<div class="text">
			  <h4><a <?php echo $nodeurl?>><?php echo $title?></a></h4> 
			  <div class="datemob"> <?php echo $dateday;?> </div>                			  
			 <div class="desp"><?php echo $despv?> </div>
		</div>
  </li> 
   <?php
        }
   ?>    

  </ul>
</div> 



 <?php 
//if(is_int(strpos($cssname,'sliderenable'))){
?>
  <script>
$(function(){
  var num = <?php echo $cus_columns;?>;
 // if($('body').width()<800)   num = 3;
 // else    num = <?php echo $cus_columns;?>;
   $('#<?php echo $dhtrigger?>>ul').slick({  //use div to avoid gridcol2
 
         infinite: true,
              slidesToShow: num,
              slidesToScroll: num,
               autoplay:true,
              vertical:true, 
              dots: true, 
              arrows: false,              
 });
});
</script>
<?php 
//}
?>

