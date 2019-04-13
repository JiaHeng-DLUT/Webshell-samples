<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
<ul class="albumupdown">
<?php

         foreach($row_abm as $v){
               
			$tid=$v['id'];
			$title=$v['title'];			  
            $kvsm=$v['kvsm'];
			$desp=$v['desp'];
		 
             
            $addr2_big =  UPLOADPATHIMAGE.$kvsm;
		    
       
 			$img=get_thumb($kvsm,$title,'div');
 		 
 			$imgbig=get_img($kvsm,$title,'div');

?>
<li>

<?php 
echo '<div class="img">'.$imgbig.'</div>';
 
if($title<>'') echo '<div class="title">'.web_despdecode($title).'</div>';
if($desp<>'') echo '<div class="desp">'.web_despdecode($desp).'</div>';
?>
</li>

			 
          
 <?php
            }//end foreach
 
?>
</ul> 