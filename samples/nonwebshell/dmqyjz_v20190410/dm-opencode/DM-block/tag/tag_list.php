<ul class="textlist">
<?php  
 foreach($result as $v2){
       $nodepidname = $v2['node'];
				 		//echo $nodepidname;

		   $sqllist22 = "SELECT * from ".TABLE_NODE." where  pidname='$nodepidname'   $andlangbh  limit 1";
 			if(getnum($sqllist22)>0){
 					$v = getrow($sqllist22);

 					 $title=$v['title'];
			$titlestyle=$v['titlestyle'];			 
			$dateday=substr($v['dateedit'],0,10);                        
			$despv =  get_nodedespjj($v['despjj'],$v['desp'],$v['desptext'],100);              
            $kvsm=$v['kvsm'];
            $imgv =  get_img($kvsm);
            $url = get_url($v);
            $titlestylev=$titlestyle<>''?' style="'.$titlestyle.'" ':'';            
            $linkurl = linkhref($url).$titlestylev;
            //echo $linkurl;

             
            if($kvsm<>""){
            	?>
            	<li class="hasimg">
            	<a class="img" <?php echo $linkurl;?>><img src="<?php echo $imgv;?>" alt="<?php echo $title;?></a>"></a>
            	<div class="text"><h4><span class="day"><?php echo $dateday;?></a></span>
            	<a <?php echo $linkurl;?>><?php echo $title;?></a></h4>
            	<p class="textshort"><?php echo $despv;?></a></p></div></li>
            	<?php 
            }
            else{
            	?>
            	<li class="noimg"><div class="text"><h4><span class="day"><?php echo $dateday;?></a></span>
            	<a <?php echo $linkurl;?>><?php echo $title;?></a></h4>
            	<p class="textshort"><?php echo $despv;?></a></p></div></li>
            	<?php 
            }


 			}//end getnum

 }
 ?>
</ul>
 
 