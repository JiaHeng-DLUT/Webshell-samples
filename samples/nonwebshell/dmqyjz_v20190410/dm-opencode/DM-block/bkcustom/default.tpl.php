        <div class="boxcol <?php echo $cssname;?>">
 
           
              <?php if($blockimg<>''){ ?>                    
                <div class="img">
                 <?php 
                 if($linkurl<>'') echo '<a '.linkhref($linkurl).'>';               
                  ?>
                <img class="mt10 mb10" src="<?php echo get_img($blockimg);?>"  alt="<?php echo $namefront?>"> 
                 <?php 
                 if($linkurl<>'')  echo '</a>';
              ?>
                </div>    
              <?php }  ?> 
            
          
            <div class="text">
                  
               <?php
               if($namefront<>'') echo '<h4 class="blockhd">'.$namefront.'</h4>';
             ?>     			  
              <?php
               if($despjj<>'') echo '<div class="despjj">'.$despjj.'</div>';
             ?>
			  
         

             <?php
               if($despv<>'') echo '<div class="desp">'.$despv.'</div>';
             ?>
			  
               <?php 
                 if($linktitle<>'') {  
                  $linktitle = $linktitle<>''?$linktitle:'更多 >';
              ?>
              <div class="dmbtn mt10">
                 <a class="more"  <?php echo linkhref($linkurl);?>"><?php echo $linktitle;?></a>
              </div>              
               <?php 
               }
              ?>

            </div>

      </div>
      
    