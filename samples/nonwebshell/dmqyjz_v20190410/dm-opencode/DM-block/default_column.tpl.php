        <?php         

       if($blockid<>'') {
           echo '<div class="boxcol '.$cssname.'">';
           if($namefront<>'') echo '<h4 class="blockhd">'.$namefront.'</h4>';
            block($blockid);
          echo '</div>';
      }
        else{
 
        ?>

        <div class="boxcol <?php echo $cssname;?>">                  
           <?php
               if($namefront<>'') echo '<h4 class="blockhd">'.$namefront.'</h4>';
             ?> 
              <?php if($blockimg<>''){ ?>                    
                <div class="img">
                 <?php 
                 if($linkurl<>'') echo '<a '.linkhref($linkurl).'>';               
                  ?>
                <img   src="<?php echo get_img($blockimg);?>"  alt="<?php echo $namefront?>"> 
                 <?php 
                 if($linkurl<>'')  echo '</a>';
              ?>
                </div>    
              <?php }  ?>  
           
             <?php
               if($despv<>'') {
                  echo '<div class="desp">';
                   dmblockid($despv);
                  echo '</div>';

               }
             ?>			  
              <?php 
                 if($linktitle<>'') {  
              ?>
              <div class="dmbtn mt10">
                 <a class="more"  <?php echo linkhref($linkurl);?> ><?php echo $linktitle;?> > </a>
              </div>              
               <?php 
               }
              ?>
          
      </div>
      <?php
   			}
      ?>
      