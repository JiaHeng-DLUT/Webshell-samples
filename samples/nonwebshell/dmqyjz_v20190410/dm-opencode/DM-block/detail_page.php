<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

 
?>
<div class="content_desp">
<?php
 
//download
detail_downloadurl($downloadurl);
 

//---music
$resmusic = detail_music('node',$pidname);
if($resmusic) {
	 $musicfile = BLOCKROOT.'music/'.$musicfg;
   if(checkfile($musicfile))  require($musicfile);
}   
//album
$row_abm = detail_album('node',$pidname);
if($row_abm){   
  $albumfile = BLOCKROOT.'album/'.$albumfg;
  if(checkfile($albumfile))  require($albumfile);
}



 //视频的内容
   $detailvideo = detail_video('node',$pidname);
      if($detailvideo)   block($detailvideo); 


 

dmblockid($despv);

detail_linkmore($linkmore);

?>
</div> 