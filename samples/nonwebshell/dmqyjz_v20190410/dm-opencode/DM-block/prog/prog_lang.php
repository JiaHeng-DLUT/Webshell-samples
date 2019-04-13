 <?php 
 if(LANGICOSWITCH=='y'){
 $sql = "SELECT id,lang,langpath,domain from ".TABLE_LANG." where pbh='".USERBH."' and sta_visible='y' order by pos desc,id";
 $langnum = getnum($sql);				 				 
if($langnum>1)
{
	$rowalllang = getall($sql);
?>
     <div class="langimg">
     	 <div class="clicknextshow  cp">
     	 <img src="<?php echo STAPATH;?>img/langimg/<?php echo LANG?>.gif" height="16" title="<?php echo LANG?>" alt="<?php echo LANG?>" />
			<i class="langarrow"></i>
     	 </div>
	 		<div class="langimginc dn">
	 			  <?php 
							  $sql = "SELECT lang,langpath from ".TABLE_LANG." where pbh='".USERBH."' and lang<>'" .LANG. "' and sta_visible='y' order by pos desc,id";
								$rowlist = getall($sql);
								if($rowlist=='no') echo '暂无内容';
								else{
									if(SITEIDBYDOMAIN=='y'){ 
									 foreach ($rowalllang as  $v) {										    
										    if(MAINLANG<>$v['lang']){
												   $langsrc = STAPATH.'img/langimg/'.$v['lang'].'.gif';	   
											       echo '<a  href="http://'.$v['domain'].'"><img src="'.$langsrc.'" alt="'.$v['lang'].'" /></a>';
											   }
										   } 
										 }
									else{	
										foreach($rowlist as $v){ 								 
										  $lang=$v['lang']; 
										  $langpath=$v['langpath']; 
										  $langsrc = STAPATH.'img/langimg/'.$lang.'.gif';	

										  if($lang==MAINLANG)	$link = BASEURL;			    
										   else $link = BASEURL.$langpath.'/';
										  echo '<a title="'.$lang.'" href="'.$link.'"><img src="'.$langsrc.'" alt="'.$lang.'" /></a>';
										}
									}




							}


	 			  ?>

	 		</div>

     </div>
 <?php 
     }
 }
  ?>