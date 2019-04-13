<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
<div class="blockimg updonw_blockimg">
<?php

         foreach($row_abm as $v){
               
			$tid=$v['id'];
			$title=$v['title'];			  
            $kvsm=$v['kvsm'];
			$desp=$v['desp'];
		 
             
            $addr2_big =  UPLOADPATHIMAGE.$kvsm;
		    
       
 			$img=get_thumb($kvsm,$title,'div');
 		 
 			$imgbig=get_img($kvsm,$title,'div');

echo $imgbig;
 
 }//end foreach
 
?>
</div> 
 