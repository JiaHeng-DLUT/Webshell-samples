
<?php
/*
  power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}
//----------
//$sqlalbum = "SELECT id from ".TABLE_ALBUM." where pid='$pidname' $andlangbh order by id desc";//$pidname is in pro-modnews.php 
//$num_album = '有 <span class="cred">'.getnum($sqlalbum).'</span>个';
/*
$sqltab = "SELECT id from ".TABLE_BLOCK." where pid='$pidname' and type='tab' and typefrom='node' $andlangbh order by id desc";
$num_tab = '有 <span class="cred">'.getnum($sqltab).'</span>个';

$sqlaccord = "SELECT id from ".TABLE_BLOCK." where pid='$pidname' and type='accord' and typefrom='node' $andlangbh order by id desc";
$num_accord = '有 <span class="cred">'.getnum($sqlaccord).'</span>个';
*/ 
$sqlimgfj = "SELECT id from ".TABLE_IMGFJ."  where pid='$pidname' $andlangbh order by id desc";
$num_imgfj = '有 <span class="cred">'.getnum($sqlimgfj).'</span>个';


?> 
<div class="contenttoptop por">

<div class="fr nodeeditrgtop">
<?php echo admlink($row);?>
</div> 

<div class="menutab">
<?php  

 $editcan_cur=  $edittag_cur=  $editdesp_cur= $editprocan_cur=$editotherinfo_cur= $editcate_cur=$editcate2_cur=$editalbum_cur='';
 $editvideo_cur=$editvideo2_cur= $editmusic_cur='';

if($file=="editdesp")   $editdesp_cur=' active';
elseif($file=="editcan")   $editcan_cur=' active';
elseif($file=="edittag")   $edittag_cur=' active';
elseif($file=="editprocan")   $editprocan_cur=' active';
elseif($file=="editotherinfo")   $editotherinfo_cur=' active';
elseif($file=="editcate")   $editcate_cur=' active'; 
elseif($file=="editcatemulti")   $editcate2_cur=' active'; //2 is multi cate.
elseif($file=="editalbum")   $editalbum_cur=' active';
elseif($file=="editvideo")   $editvideo_cur=' active';
elseif($file=="editvideo2")   $editvideo2_cur=' active';
elseif($file=="editmusic")   $editmusic_cur=' active';

echo '<a class="bg22'.$editdesp_cur.'" href="'.$jumpv.'&act=list&file=editdesp"><span>修改内容</span></a>';

echo '<a class="bg22'.$editcate_cur.'" href="'.$jumpv.'&act=list&file=editcate"><span style="font-weight:bold">修改分类</span></a>';
 

echo '<a class="bg22'.$editcan_cur.'" href="'.$jumpv.'&act=edit&file=editcan"><span>修改参数</span></a>';


if($sta_tag=='y')
 echo '<a class="bg22'.$edittag_cur.'" href="'.$jumpv.'&act=list&file=edittag"><span>标签管理</span></a>';

 echo '<a class="bg22'.$editprocan_cur.'" href="'.$jumpv.'&file=editprocan"><span style="color:blue">产品参数</span></a>';
 


 //echo '<a class="bg22'.$editkvsm_cur.'" href="'.$jumpv.'&act=list&file=editkvsm"><span>修改缩略图片</span></a>';

//echo '&nbsp;&nbsp;&nbsp;&nbsp;';
 //$numalbum = num_subnode(TABLE_ALBUM,'pid',$pidname);
 //$linkalbum = '../mod_album/mod_album.php?lang='.LANG.'&pid='.$pidname.'&type=node';
 //echo '<a class="bg22'.$editalbum_cur.'" href="'.$jumpv.'&act=list&file=editalbum"><span>相册管理</span></a>';
 //echo '<a class="bg22 needpopup '.$editalbum_cur.'" href="'.$linkalbum.'"><span>相册管理('.$numalbum.')</span></a>';

 //$numalbum = num_subnode(TABLE_VIDEO,'pid',$pidname);
 //$linkvideo = '../mod_video/mod_video.php?lang=cn&pid='.$pidname.'&act=edit&type=node';
 //echo '<a class="bg22 needpopup '.$editvideo_cur.'" href="'.$linkvideo.'&file=editvideo"><span>视频管理('.$numalbum.')</span></a>';
 
 



 //$numalbum = num_subnode(TABLE_MUSIC,'pid',$pidname);
 //$linkmusic = '../mod_music/mod_music.php?lang='.LANG.'&pid='.$pidname.'&type=node';
 //echo '<a class="bg22'.$editalbum_cur.'" href="'.$jumpv.'&act=list&file=editalbum"><span>相册管理</span></a>';
 //if(MUSICENABLE=='y')
 //echo '<a class="bg22 needpopup '.$editmusic_cur.'" href="'.$linkmusic.'"><span>音乐管理('.$numalbum.')</span></a>';


?>
 
 
</div>
<?php 
if($file=='editdesp' ||  $file=='editprocan' || $file == 'editotherinfo'){
  $jump_imgfj='../mod_imgfj/mod_imgfj.php?pid='.$pidname.'&lang='.LANG;
  
  $numimgtext = num_subnode(TABLE_IMGTEXT,'pid',$pidname);
  $numalbum = num_subnode(TABLE_ALBUM,'pid',$pidname);
  $numvideo = num_subnode(TABLE_VIDEO,'pid',$pidname);
  $nummusic = num_subnode(TABLE_MUSIC,'pid',$pidname);
  ?>
<div class="" style="margin:0px;padding:6px;border:0px solid blue">
 <a href="<?php echo $jump_imgfj; ?>"  class="needpopup">私有编辑器附件管理(<?php echo num_imgfj($pidname);?>)  </a>
  或  <?php echo $text_imgfjlink_bjq ?> 
  | 
   <a target="_blank" href="../mod_imgtext/mod_mainimgtext.php?lang=<?php echo LANG?>&pid=<?php echo $pidname?>">图文编辑器(<span class="cred"><?php echo $numimgtext;?></span>)</a>
  
   |   <a target="_blank" href="../mod_album/mod_mainalbum.php?lang=<?php echo LANG?>&pid=<?php echo $pidname?>">相册(<span class="cred"><?php echo $numalbum;?></span>)</a>
   |   <a target="_blank" href="../mod_video/mod_video.php?lang=<?php echo LANG?>&pid=<?php echo $pidname?>">视频(<span class="cred"><?php echo $numvideo;?></span>)</a>

   | <a target="_blank" href="../mod_music/mod_mainmusic.php?lang=<?php echo LANG?>&pid=<?php echo $pidname?>">音乐(<span class="cred"><?php echo $nummusic;?></span>)</a> 

 </div>
<?php 
}
?>
 

</div>


<div class="editmenuother_cnt">
<?php
 //require_once('plugin_node_list_edit.php'); //no use...
?>
</div><!--end editmenuother_cnt-->

 

