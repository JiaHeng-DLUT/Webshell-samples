 
 <div id="<?php echo $dhtrigger;?>" class="sidebar_imgleft <?php echo $cssname;?>" <?php echo $stylev;?>>
   <ul>  
      <?php 
      foreach($result as $k=>$v){
		        $title=$v['title'];
      $titlestyle=$v['titlestyle'];      
      $dateday=substr($v['dateedit'],0,10);                        
      $despv =  get_nodedespjj($v['despjj'],$v['desp'],$v['desptext'],$cus_substrnum);              
            $kvsm=$v['kvsm'];
            $imgv =  get_img($kvsm);
            $url = get_url($v);
            $titlestylev=$titlestyle<>''?' style="'.$titlestyle.'" ':'';            
            $nodeurl = linkhref($url).$titlestylev; 

  
    ?>
     <li> 
             <div class="img">
              <a <?php echo $nodeurl;?>> <img class="mt10" src="<?php echo $imgv?>"  alt="<?php echo $title?>">  </a>
            </div>			
			<div class="text">
				<h5 class="title"><a <?php echo $nodeurl;?>><?php echo $title?></a></h5>
				 
				<?php  if($cus_substrnum>0) 
						echo '<div class="desp">'.$despv.'</div>';
				?>
           </div> 
     </li> 
  <?php
  
}
?> 
</ul>
</div>
 