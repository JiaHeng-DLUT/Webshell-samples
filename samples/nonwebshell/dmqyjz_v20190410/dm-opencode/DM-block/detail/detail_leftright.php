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
 
$despcan = detail_nodetext('node','nodeprocan',$nodepidname);



?>

<?php
publishtext(); // in frontcommon.php
 
?>
<div class="content_desp ">

<div class="shopdetail_left">
<?php
$row_abm = detail_album('node',$nodepidname);
if(!$row_abm)   echo '<img src = "'.STAPATH.'img/noimg.png" alt="暂无相册" />';
else { 
  $cus_columnsv = ' '.cus_columnsfun($cus_columns_album); 
   if(substr($albumfg,0,5)=='self_')  $albumfile = TPLCURROOT.'selfblock/album/'.$albumfg;
   else  $albumfile = BLOCKROOT.'album/'.$albumfg;
  if(checkfile($albumfile))  require($albumfile);
 
}

 
 ?>
</div>

<div class="shopdetail_right">
<h1><?php echo decode($titledetail); ?></h1>


<?php
//if($proxinghao<>'') echo '<span style="font-size:14px;">型号：'.$proxinghao.'</span>';



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


 
?>

 
<?php 

//download
echo '<div class="detaildownbtn">';
echo '<span>';
detail_downloadurl($downloadurl);
echo '</span><span>';
detail_linkmore($linkmore);

echo '</span></div>';

?>




</div>
<div class="c"> </div>

<?php
detail_fontsize(); 

?>


<div class="nodetab">

 <div class="nodetabhd">

 <span class="cur">
 <?php
  echo $news_titlev; 
?>
 </span>
 
 <?php

 if($despcan) echo '<span class="ordertab dn">'.$can_titlev.'</span>';

?>


   </div><!--end nodetabhd-->



  <div class="nodetabcnt">
  	  <?php //显示 内容?>
  	  <div class="nodetabcntinc">

	<?php if($detailkv<>'' && $nodekvshow=='y'){ ?>
	<div class="kv c">
	<?php echo get_img($detailkv,$title,'div');?>
	</div>
	<?php
	 }

 

//---

dmblockid($despv);


?>
 </div>


 <?php
 
if($despcan) {
   echo '<div class="nodetabcntinc ordernowcnt dn">';
    dmblockid($despcan);
  echo '</div>';
}   

 


?>
 
  </div><!--end nodetabcnt-->

</div><!--end nodetab-->

</div>


<?php
 


if($sta_tag=='y') taglink($nodepidname,$tag_title);

 if(substr($nextprev,0,5)=='self_')  $file = TPLCURROOT.'selfblock/nextprev/'.$nextprev;
   else  $file = BLOCKROOT.'nextprev/'.$nextprev; 
if(checkfile($file)) require $file; 

$file = BLOCKROOT.'relative/vv_relative.php'; 
if(checkfile($file)) require $file;

 ?>
 
 
  