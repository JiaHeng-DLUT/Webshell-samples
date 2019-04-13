 
<div class="gridaboutus   gridcol2divi <?php echo $cssname;?>">     
      <?php 
      foreach($result as $k=>$v){       
        $title = $v['title'];
        
        $imgv =  get_img($v['kv']); 

		    $despv =  get_nodedesp($v['desp'],$v['desptext']);
 
       // $linkurlarr =  get_nodelinkurl($linkdhurl);

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

$kjia = $k+1; 
  $kyu = $kjia%$cus_columns;

    ?>
        <div class="boxcol  <?php echo $cus_columnsv;?>">
	 
             <div class="img">
              <?php echo $linkurlarr[0];?> 
              <img class="mt10" src="<?php echo $imgv?>"  alt="<?php echo $title?>">   
              <?php echo $linkurlarr[1];?>
            </div>
	 
            <div class="text">
              <h4><?php echo $title?></h4>    
			  
             <div class="desp"><?php echo $despv?> </div>
			  
              <?php 
              
                if($linkdhurl<>''){ //为了保证grid的高度，这里的按钮，要不全有，要不全不要。 
                    $linkdhtitlev='查看详情>';
                    if($linkdhtitle<>'') $linkdhtitlev=$linkdhtitle;
              ?>
              <div class="dmbtn mt10">
                 <a class="more" <?php echo linkhref($linkdhurl)?> ><?php echo $linkdhtitlev;?></a>
              </div>              
               <?php 
               }
              ?>
            </div>

      </div>
  <?php
  
  if($kyu==0) echo '<div class="c"> </div>';
}
?>
 
</div>

