 
<div id="<?php echo $dhtrigger;?>" class="blockclientszoom <?php  echo  $cssname?>">
<ul>
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
        <li class="wow zoomIn <?php echo $cus_columnsv;?>">
               <?php echo $linkurlarr[0];?>
                 <img class="mt10" src="<?php echo $imgv?>"  alt="<?php echo $title?>"> 
              <?php echo $linkurlarr[1];?>     
            </li>
<?php  
 }
  ?>
  </ul>
</div>

 