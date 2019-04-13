<?php 
//pre($result_imgtext);
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
 $fullwidthv = $fullwidth=='n'?' container ':'';  
 $cssname = $fullwidthv.$cssname;

$titlefgv = titlefgv($title,$titlefg);

$stylev = $cssstyle==''?'':' style = " '.$cssstyle.' "';


// $filearr = array('imgtop'=>'默认图片在上','imgleft'=>'图片在左','imgright'=>'图片在右','bsleft'=>'标识在左','bsright'=>'标识在右');

 echo  '<div id="anchor'.$k.'" class="imgtextline '.$cssname.' line'.$k.'" '.$dnv.' data-format='.$format.$stylev.'>';

  if(dmlogin())  dmeditlink($pid,$tid,'imgtextsub');	
  echo $titlefgv;
  imgtext_echocnt($format,$blockid,$imgv,$title,$despv,$haswow);
  

 echo '</div>';

	 
}


?>