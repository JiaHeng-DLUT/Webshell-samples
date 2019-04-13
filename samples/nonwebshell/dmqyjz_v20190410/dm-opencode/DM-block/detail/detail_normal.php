<?php
if(!defined('IN_DEMOSOSO')) {
    exit('this is wrong page,please back to homepage');
}
?>

<?php
 //pre($row_detail);
$dhtrigger = 'slick'.rand(1000,9999);  
$videoid= $row_detail['videoid'];
$nodepidname= $row_detail['pidname'];
$detpriceold= $row_detail['detpriceold'];$detprice= $row_detail['detprice'];
$stock= $row_detail['stock'];
$sku= $row_detail['sku'];
$desptext= web_despdecode($row_detail['desptext']);
$desp= web_despdecode($row_detail['desp']);
$despv = $desptext<>''?$desptext:$desp;
$can_titlev = $can_title<>''?$can_title:'产品参数';
$news_titlev = $news_title<>''?$news_title:'内容详情';

$detailkv = $row_detail['kv']; 
$titledetail = $title; //override by album.so set again
?>
<h1><?php echo decode($titledetail); ?></h1>
<?php
publishtext(); // in frontcommon.php

detail_fontsize();
?>
<div class="content_desp">
	<?php 

  if($detailkv<>'' && $nodekvshow=='y'){   
    echo '<div class="kv c">';
    echo get_img($detailkv,$title,'div'); 
	   echo '</div>'; 
	 }
 
  

if($shop_price=='y'){ 
 $detlinktitlev = $detlinktitle<>''?$detlinktitle:PRICE_LINK;
  if($detprice<>0)  {
        echo '<div class="detailprice detailpriceold"><span class="w1">'.PRICE_TEXTOLD.'</span><span class="w2"><em>'.PRICE_CURRENCY.'</em><strong class="del">'.$detpriceold.'</strong></span></div>';

          echo '<div class="detailprice detailpricenow"><span class="w1">'.PRICE_TEXT.'</span><span class="w2"><em>'.PRICE_CURRENCY.'</em><strong class="price">'.$detprice.'</strong></span></div>';
        }
       // if($sku<>'') echo '<div class=" ">'.PRICE_MODEL.$sku.'</div>';
       // if($stock<>0) echo '<div class=" ">'.PRICE_STOCK.$stock.'</div>';
        if($detlinkurl<>'') echo '<div class="detaillinkurl dmbtn mt10 moresm"><a class="more " href="'.$detlinkurl.'" target="_blank"><i class="fa fa-shopping-cart"></i> '.$detlinktitlev.'</a></div>';
          

} //hide price part

//---先输出参数---------
$despcan = detail_nodetext('node','nodeprocan',$nodepidname);
 
if($despcan) {
	if($can_title<>'hide') echo '<div class="bodyheader"><h3>'.$can_titlev.'</h3></div>';
   echo '<div class="despcan">';
    dmblockid($despcan);
  echo '</div>';
}   

//download
//输出内容：
if($news_title<>'hide') echo '<div class="bodyheader"><h3>'.$news_titlev.'</h3></div>';


detail_downloadurl($downloadurl);

 
dmblockid($despv);


if($formblockid<>'') block($formblockid);

detail_linkmore($linkmore);
detail_sharebtn();
?>
</div>

<?php


if($sta_tag=='y') taglink($nodepidname,$tag_title);

 if(substr($nextprev,0,5)=='self_')  $file = TPLCURROOT.'selfblock/nextprev/'.$nextprev;
   else  $file = BLOCKROOT.'nextprev/'.$nextprev; 
if(checkfile($file)) require $file; 

 
$file = BLOCKROOT.'relative/vv_relative.php'; 
if(checkfile($file)) require $file;
 

 ?>
