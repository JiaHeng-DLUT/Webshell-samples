<div id="<?php echo  $dhtrigger;?>" class="grid2ceng">  <ul>
<?php 

 foreach($row_abm as $v){
               
			$tid=$v['id'];
			$title=$v['title'];			  
            $kvsm=$v['kvsm'];
			$desp=$v['desp'];		 
             
           // $addr2_big =  UPLOADPATHIMAGE.$kvsm;		    
       
 				

 			if(strpos($cssname, 'ridbigimg')>0) $img=get_img($kvsm,$title,'div');//thumb use big
 			else $img=get_thumb($kvsm,$title,'div');

 		     $imgbig=get_img($kvsm,$title,'nodiv');
 				

 
      ?>
 <li class="gcoverlayjia <?php echo $cus_columnsv;?>">
    <a href="<?php echo $imgbig?>"  title="<?php echo $title?>" data-fancybox="gallery" data-caption="<?php echo $title;?>">
    <div class="overlay"><span>+</span></div>
      <div class="img">
             <?php echo $img?>
            </div>
            <?php if($title<>'') echo '<h3>'.$title.'</h3>';?>    
    </a> </li>
<?php
}
?>
 </ul><div class="c"> </div>
</div>

 