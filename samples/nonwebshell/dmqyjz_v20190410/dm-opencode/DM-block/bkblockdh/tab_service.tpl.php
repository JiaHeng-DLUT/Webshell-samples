 
<div class="tabs_js tabs_wrapper <?php echo $cssname;?>">
  <ul class="tabs_header">
    <?php
      
        foreach ($result as $k => $v) {
          ?>
           <li  class="<?php echo $k==0?'active':''?>"><?php echo $v['title'];?></li>
   <?php
        
      }
    ?>
  </ul>


<div class="tabs_contentwrap">

           <?php
           
               foreach ($result as $k => $v) {
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

      <div class="tabs_content" <?php echo $k==0?'':' style="display:none"'?>>
             <div class="boxcol colfull">

             <?php
              if ($k%2==0) {
                 ?>

                      <div class="img fl col_2f5">
                            <?php echo $linkurlarr[0]?>
                            <img class="mt10" src="<?php echo $imgv?>"  alt="<?php echo $title?>">
                            <?php echo $linkurlarr[1]?>
                        </div>

                        <div class="text  fl col_3f5">
                            
                           <div class="desp"><?php echo $despv?> </div>
                        </div>


                <?php
               }
               else  {
                ?>


                        <div class="text  fl col_3f5">
                             
                           <div class="desp"><?php echo $despv?> </div>
                        </div>

                         <div class="img fl col_2f5">
                            <?php echo $linkurlarr[0]?>
                            <img class="mt10" src="<?php echo $imgv?>"  alt="<?php echo $title?>">
                            <?php echo $linkurlarr[1]?>
                        </div>



                <?php
               }

              ?>



                  </div>

     </div>

       <?php

            }
               
        ?>

</div><!--end tab_content-->

 </div>
