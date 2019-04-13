<?php 
 //-----banner--------
 if($alias=='index')
 	$bannereffect = 'banner_block.php';
 //inc_brannereffect($bannereffect); 
 
  if(substr($bannereffect,0,5)=='self_') $file = TPLCURROOT.'selfblock/banner/'.$bannereffect;
   else $file = BLOCKROOT.'banner/'.$bannereffect;
  // echo $file;
   if(checkfile($file)) require_once($file);
 
//-----------------
?>