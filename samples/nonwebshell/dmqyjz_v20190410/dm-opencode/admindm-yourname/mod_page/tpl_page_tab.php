<div class="contenttoptop por">

	<div class="nodeeditrgtop">
	<div style="float:right;color:#999;font-size:16px">前台预览：<?php echo $pageurl;?>  </div>

	 
 
	</div> 

<div class="menutab">
<?php 

 //$sqlalbum = "SELECT id from ".TABLE_ALBUM." where pid='$pidname' $andlangbh order by id desc";//$pidname is in pro-modnews.php 
 
//$num_album = '有 <span class="cred">'.getnum($sqlalbum).'</span>个';

  $editdesp_cur=  $editcan_cur=  $editbuju_cur='';

 if($file=="edit_desp")  { $editdesp_cur=' active'; }
  elseif($file=="edit_can")   $editcan_cur=' active';
 



echo '<a class="'.$editdesp_cur.'"  href="'.$jumpv.'&file=edit_desp&act=edit"><span>修改内容</span></a>';
 echo '<a class="'.$editcan_cur.'"  href="'.$jumpv.'&file=edit_can&act=edit"><span>修改参数</span></a>';
 
 
 echo '<a class="'.$editbuju_cur.'" target="_blank" href="../mod_layout/mod_layout.php?lang='.LANG.'&pid='.$pidname.'&type=page"><span>修改布局</span></a>';
	//echo '<a class="'.$editalbum_cur.'"  href="'.$jumpv.'&file=edit_album&act=edit"><span>相册管理</span></a>';
	//echo '<a class="'.$editalbumset_cur.'"  href="'.$jumpv.'&file=edit_albumset&act=edit"><span>相册设置</span></a>';
	// echo '<a class="'.$editvideo_cur.'"  href="'.$jumpv.'&file=edit_video&act=edit"><span>视频管理</span></a>';
 

?>
</div>

<?php 
 if($file=='edit_desp'){
       
        
     		         
	}

if($file=='edit_albumset'){
	  if($content<>''){echo '<p class="p10 f14bgred">由于本页面的内容调用了'.check_blockid($content).'，所以这里的相册设置不起作用</p>';}
	}

?>
</div>

 