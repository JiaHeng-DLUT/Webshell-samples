<div class="tabs_js tabs_wrapper">
  <ul class="tabs_header"> 
  <?php
      
        foreach ($result_imgtext as $k => $v) {
          ?>
           <li  class="<?php echo $k==0?'active':''?>"><?php echo $v['title'];?></li>
   <?php
        
      }
    ?>

  </ul>

<div class="tabs_contentwrap">

<?php

foreach ($result_imgtext as $k=>$v) {
$pid= $v['pid'];$tid= $v['id'];
$title= $v['title'];$cssname= $v['cssname'];$fullwidth= $v['fullwidth'];
 $kv= $v['kv'];
   $imgv =  get_img($kv);
 $desptext= web_despdecode($v['desptext']);
$desp= web_despdecode($v['desp']);
$despv = $desptext<>''?$desptext:$desp;
$cssstyle='';
  $bscntarr = explode('==#==',$v['arr_can']); 
    if(count($bscntarr)>1){
      foreach ($bscntarr as   $bsvalue) {
       if(strpos($bsvalue, ':##')){
         $bsvaluearr = explode(':##',$bsvalue);
         $bsccc = $bsvaluearr[0];
         $$bsccc=$bsvaluearr[1];
       }
     }
    }
 
 if($linkdhtitle=='') $linkv = '';
 else $linkv = '<div class="dmbtn mt10"><a class="more" '.linkhref($linkdhurl).'>'.$linkdhtitle.'</a></div>'; 

$despv = $despv.$linkv;

$dnv = '';
 if($k>0) $dnv = ' style="display:none" ';

  $fullwidthv = $fullwidth=='n'?' container ':'';
 $cssname = $fullwidthv.$cssname;
$titlefgv = titlefgv($title,$titlefg);
$stylev = $cssstyle==''?'':' style = " '.$cssstyle.' "';

// $filearr = array('imgtop'=>'默认图片在上','imgleft'=>'图片在左','imgright'=>'图片在右','bsleft'=>'标识在左','bsright'=>'标识在右');

 echo  '<div id="anchor'.$k.'" class="imgtextline tabs_content  '.$cssname.'  line'.$k.'" '.$dnv.' data-format='.$format.$stylev.'>';
if(dmlogin())  dmeditlink($pid,$tid,'imgtextsub');
 echo $titlefgv;
imgtext_echocnt($format,$blockid,$imgv,$title,$despv,$haswow);
  

 echo '</div>';


	 
}


?>
</div>