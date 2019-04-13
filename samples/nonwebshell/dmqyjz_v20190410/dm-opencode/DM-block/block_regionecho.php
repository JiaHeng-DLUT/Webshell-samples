<?php
$bgcolor=$bgimg='';
$bgrepeat= 'no-repeat';
$bgposi= 'center center';
$bgsize= 'cover';
$bgattach = 'fixed';
$stylev=$linkurl=$linktitle='';

$arr_cfg=$v['arr_cfg'];
$reganchor='';
$bscntarr = explode('==#==',$arr_cfg);
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }

$pid=$v['pid'];$tid=$v['id'];$template=$v['template'];
$name=$v['name'];
$blockid=$v['blockid'];
$despjj=$v['despjj'];

if($cssstyle<>'' || $bgcolor<>'' || $bgimg<>''){
 $stylebg = regionbg($bgcolor,$bgimg,$bgrepeat,$bgposi,$bgsize,$bgattach);
 if($cssstyle=='')   $stylev =  'style = "'.$stylebg.'"';
  else $stylev =  'style = "'.$stylebg.' '.$cssstyle.'"';
}


//------------------------
	if($titleimg<>'') 	$titleimgv = '<img src="'.UPLOADPATHIMAGE.$titleimg.'" alt="" />';
	 else   $titleimgv = $name;

//--------------------
$titlestylev = $titlestyle<>''?' style="'.$titlestyle.'"':'';
$titlestylesubv = $titlestylesub<>''?' style="'.$titlestylesub.'"':'';

$titlelinelongv = 'titlelinelong';
$titlelinelongstylev ='';
if($titlelinelong<>''){
   if($titlelinelong=='none') $titlelinelongv = '';
   else  $titlelinelongstylev = 'style="border-bottom:1px solid '.$titlelinelong.'"';
}

$titlelineshortv = 'titlelineshort';
$titlelineshortstylev ='';
if($titlelineshort<>''){
   $titlelineshortstylev = 'style="background:'.$titlelineshort.'"';
}


//-------------
 ?>


<?php // class  block is for js or hover edit link
$anchorv = $reganchor==''?'region'.$tid:$reganchor;
?>
 <div id="<?php echo $anchorv?>" class="regionbox <?php echo $cssname;?>" <?php echo $stylev?>>
 <?php
		   if(dmlogin()){ //is in func_block. bec declare.bec this file repeat require
               dmeditlink($pid,$tid,'regionblock');		//here is $pid,not pidnmae
             }

//----------------------

      if(substr($template,0,5)=='self_')  $req_file =  TPLCURROOT.'/selfblock/region/'.$template;
          else  $req_file =  BLOCKROOT.'region/'.$template;

       if(is_file($req_file)) require $req_file;
       else echo '<p style="background:#ccc;color:red">没有此文件: ...'.substr($req_file,8).' </p>';

 	?>

</div>
