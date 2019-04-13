<div class="contenttoptop">

	<div class="fr nodeeditrgtop">
	<div style="float:right;color:#999;font-size:16px">前台预览：<?php echo $pageurl;?> <i class="fa fa-external-link-square"></i></div>

	 
	<div class="fr" style="margin-right:30px">
	<span class="cp editmenuother cirbtn">编辑其他 &#8595; </span>
	</div><!--end fr-->
	 
	</div> 

<div class="menutab">
<?php 

 $sqlalbum = "SELECT id from ".TABLE_ALBUM." where pid='$pidname' $andlangbh order by id desc";//$pidname is in pro-modnews.php 
 
$num_album = '有 <span class="cred">'.getnum($sqlalbum).'</span>个';

  $editdesp_cur=  $editalias_cur= $editbuju_cur= $editalbum_cur= $editalbumset_cur=$editvideo_cur='';

 if($file=="edit_desp" || $file=="edit_can")  { $editdesp_cur=' active'; }
  elseif($file=="edit_alias")   $editalias_cur=' active';
  elseif($file=="edit_buju" or $file=="edit_bujucate")   $editbuju_cur=' active';
elseif($file=="edit_album")   $editalbum_cur=' active';
elseif($file=="edit_albumset")   $editalbumset_cur=' active';
elseif($file=="edit_video")   $editvideo_cur=' active';
 




echo '<a class="'.$editdesp_cur.'"  href="'.$jumpv.'&file=edit_desp&act=edit"><span>修改内容</span></a>';
echo '<a class="'.$editalias_cur.'"  href="'.$jumpv.'&file=edit_alias&act=edit"><span>修改别名</span></a>';
if($regionid==''){
	echo '<a class="'.$editbuju_cur.'"  href="'.$jumpv.'&file=edit_buju&act=edit"><span>修改布局</span></a>';
	echo '<a class="'.$editalbum_cur.'"  href="'.$jumpv.'&file=edit_album&act=edit"><span>相册管理('.$num_album.')</span></a>';
	echo '<a class="'.$editalbumset_cur.'"  href="'.$jumpv.'&file=edit_albumset&act=edit"><span>相册设置</span></a>';
	echo '<a class="'.$editvideo_cur.'"  href="'.$jumpv.'&file=edit_video&act=edit"><span>视频管理</span></a>';
 }

?>
</div>

<?php 
 if($file=='edit_desp'){
       
         if($content<>''){
         	echo '<p class="p10 f14bgred">此处内容调用'.check_blockid($content).'<span class="blue">(可以通过 修改布局 来取消调用)</span></p>';
     		}  
     		         
	}

if($file=='edit_albumset'){
	  if($content<>''){echo '<p class="p10 f14bgred">由于本页面的内容调用了'.check_blockid($content).'，所以这里的相册设置不起作用</p>';}
	}

?>
</div>

<div class="editmenuother_cnt">
<?php
 require_once('plugin_page_list_edit.php');
?>
</div><!--end editmenuother_cnt-->
