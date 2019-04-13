<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
//when in layout,use this file to render,like group,ndli etc, different from region.
 
 
 // <div  class="block" data-effect="<php echo $effect>">  
 $pidnameeditlink = $pidname;
?>



 <div  class="block" data-effect="<?php echo $effect?>">   <?php //block is for hover edit link...?>
 <?php 

if(dmlogin()){ //is in func_block. bec declare.bec this file repeat require
//  echo $edittype.'ccccc';
    if($edittype=='vblock') dmeditlink($pidnameeditlink,'','vblock');
    if($edittype=='imgfj') dmeditlink($pidnameeditlink,'','imgfj');
    if($edittype=='prog') dmeditlink($pidnameeditlink,'','prog'); 
    if($edittype=='myprog') dmeditlink($pidnameeditlink,'','myprog');    
    if($edittype=='dmregion') dmeditlink($pidnameeditlink,'','dmregion');
     if($edittype=='video') dmeditlink($pidnameeditlink,'','video');
     if($edittype=='album') dmeditlink($pidnameeditlink,'','album');
     if($edittype=='music') dmeditlink($pidnameeditlink,'','music');
     if($edittype=='imgtext') dmeditlink($pidnameeditlink,'','imgtext');
     if($edittype=='form') dmeditlink($pidnameeditlink,'','form');
}
?>

  <?php 

 //echo $reqfile;	
  if($reqfile=='imgfj') { 
         if(is_int(strpos($pidname,'|'))){
            $arrimg = explode('|',$pidname); 
            //pre($arrimg);
            echo '<a '.linkhref($arrimg[0]).'><img src="'.UPLOADPATHIMAGE.$arrimg[2].'" alt="'.$arrimg[1].'" /></a>';
         }

        else echo '<img src="'.UPLOADPATHIMAGE.$pidname.'" alt="" />';
 
   } 
   else {     
    $nodealbum='n';//must need for valbum
        if($edittype=='prog') $reqfile2 = BLOCKROOT.$reqfile;
        else if($edittype=='myprog') $reqfile2 = TPLCURROOT.'selfblock/'.$reqfile;
        else if($edittype=='dmregion') $reqfile2 = REGIONROOT.$reqfile;
        else if($edittype=='video') $reqfile2 = BLOCKROOT.'video/'.$reqfile;
        else if($edittype=='album' || $edittype=='music' ||  $edittype=='imgtext' || $edittype=='form') $reqfile2 = BLOCKROOT.$reqfile; 
     //   else if($edittype=='form') $reqfile2 = BLOCKROOT.'form/'.$reqfile;
        else $reqfile2 = BLOCKROOT.$reqfile;
 
        if(checkfile($reqfile2))  require $reqfile2;//go to vblock.php
   		 
	 }

 
 ?>


 </div>