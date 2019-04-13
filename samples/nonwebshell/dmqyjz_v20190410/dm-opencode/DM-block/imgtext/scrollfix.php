<div class=" tabs_wrapper">
  <ul class="imgtext_fix tabs_header"> 
  <?php
      
        foreach ($result_imgtext as $k => $v) {
          ?>
           <li  class="<?php echo $k==0?'active':''?>"><a href="#anchor<?php echo $k;?>"><?php echo $v['title'];?></a></li>
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
 
  $fullwidthv = $fullwidth=='n'?' container ':'';
 $cssname = $fullwidthv.$cssname;
$titlefgv = titlefgv($title,$titlefg);
 
$stylev = $cssstyle==''?'':' style = " '.$cssstyle.' "';

// $filearr = array('imgtop'=>'默认图片在上','imgleft'=>'图片在左','imgright'=>'图片在右','bsleft'=>'标识在左','bsright'=>'标识在右');

 echo  '<div id="anchor'.$k.'" class="imgtextline '.$cssname.'  tabs_content imgtextline'.$k.'" '.$dnv.' data-format='.$format.$stylev.'>';

if(dmlogin())  dmeditlink($pid,$tid,'imgtextsub');
 echo $titlefgv;
 imgtext_echocnt($format,$blockid,$imgv,$title,$despv,$haswow);
  

 echo '</div>';


	 
}


?>
</div>


<script>
$(function(){
  $('.imgtext_fix li').click(function(){
          $('.imgtext_fix li').removeClass('active');
          $(this).addClass('active');
           $('.imgtext_fix').addClass('stricky-fixed');

          

  });


    jQuery(window).scroll(function(){ 
      
       var topdistance = 100;
       
        var visiblock_min = 0;
        var visiblock_max = 0;
      var scrolldistance = jQuery(document).scrollTop();
      
      jQuery('.imgtextline').each(function(index){
      // var index = index+1;
         
         visiblock_min = jQuery(this).offset().top - topdistance; 
         visiblock_max = visiblock_min + jQuery(this).height();
        
         //console.log(index+":top:"+jQuery(this).offset().top);
         //    console.log(index+":scrolldistance:"+scrolldistance);
        //  console.log(index+":visiblock_min:"+visiblock_min);
        //  console.log(index+":visiblock_max:"+visiblock_max);
         
         
        
if(index==0)  {     
        
           }
       
          
         if(scrolldistance>visiblock_min && scrolldistance<visiblock_max){ 

             $('.imgtext_fix li').removeClass('active');
               $('.imgtext_fix li').eq(index).addClass('active');
               $('.imgtext_fix').addClass('stricky-fixed');  
            }


            
            var  scrollfinish =  jQuery('.imgtextline0').offset().top;
            
            if(scrolldistance<scrollfinish) $('.imgtext_fix').removeClass('stricky-fixed');
             
         
         
         });
         
 
  });
//-----------------




})
</script>