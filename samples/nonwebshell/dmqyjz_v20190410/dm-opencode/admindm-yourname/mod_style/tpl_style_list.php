<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}


?>


 <div class="contenttop">            
   <a href="<?php echo $jumpv?>&file=add&act=add"><i class="fa fa-plus-circle"></i> 添加模板</a>
 </div>

 
 <div style="background: #bbdbfb;height: 35px;margin:15px 0;padding:5px">
 <span style="color:red">正在启用的模板：</span>
 </div>
 <ul class="stylegrid gridimghover">

<?php 

$sql = "SELECT * from ".TABLE_STYLE." where $noandlangbh and pidname='$curstyle' and pid='0' order by pos desc,pidname desc,id desc limit 1";
   //echo $sql;
$row = getrow($sql);
 if($row=='no') echo $norr2;
else{

   $kv=$row['kv'];
   $title=$row['title']; 
   $pidnamecur=$row['pidname'];
    $htmldir=$row['htmldir']; 

$kv = '<img src='.get_img($kv, '', '').' alt="" width="200" height="200" />';


  $edit = '<a  class="but1"   href="'.$jumpv.'&pidname='.$pidnamecur.'&file=edit_can&act=edit">修改</a>';
   $edit2  = ' <a  class="but1"   href="'.$jumpv.'&pidname='.$pidnamecur.'&file=edit_blockid&act=edit">修改标识</a>';




?>

<li style="height: auto;width:90%">
<div class="img fl col-md-3">
<?php 
echo '<a href="'.BASEURLPATH.'"  target="_blank">'.$kv.'</a>';
?>
</div>

<div class="img fl tl col-md-9">

<h3><?php echo $title;?></h3>
<div class="cgray" style="padding:5px 0"><?php echo $pidnamecur;?></div>
<div  style="padding:5px 0">
 模板目录: <strong class="cblue"><?php echo $htmldir;?></strong></div>
 

<div class="edit"  style="height:30px">
 <?php 
  echo $edit; 
  echo $edit2;
   ?>
  
     <a class="but1" href="../mod_layout/mod_layout.php?lang=<?php echo LANG; ?>">页面布局</a>

</div>
 
 

</div> 

</li>


<?php
}


?>
 
 
 </ul>

<div class="c"> </div>
 <div style="background: #bbdbfb;height: 35px;margin:15px 0;padding:5px">其他模板：</div>
<?php
$sql = "SELECT * from ".TABLE_STYLE." where $noandlangbh and pidname<>'$curstyle' and pid='0' order by pos desc,pidname desc,id desc";
   //echo $sql;
$rowlist = getall($sql);
 if($rowlist=='no') echo $norr2;
else{
?>
<form method=post action="<?php echo $jumpv;?>&act=pos">
<ul class="stylegrid gridimghover">

<?php

foreach($rowlist as $vcat){
   $tid=$vcat['id']; $title=$vcat['title']; 
   $pidnamecur=$vcat['pidname']; $pidregion=$vcat['pidregion']; 
    $htmldir=$vcat['htmldir']; 
// if($pidname==$pidnamecur) $curclass=' style="color:#fff;background:red;padding:3px;" ';
// else $curclass=' ';

$kv=$vcat['kv'];
 //$imgsmall2 = p2030_imgyt($kv, 'y', 'n');
$kv = '<img src='.get_img($kv, '', '').' alt="" width="200" height="200" />';


 $sta_visible=$vcat['sta_visible']; 
 
menu_changesta($sta_visible,$jumpv,$tid,'sta');

   $edit = '<a  class="but1"   href="'.$jumpv.'&pidname='.$pidnamecur.'&file=edit_can&act=edit">修改</a>';
    $daoout = '<a  class="but1"   href="'.$jumpv.'&pidname='.$pidnamecur.'&file=edit_daoout&act=edit">导出</a>';

    $edit2 = ' <a  class="but1"   href="'.$jumpv.'&pidname='.$pidnamecur.'&file=edit_cssdesp&act=edit">修改样式</a>';
 $edit2 .= ' <a  class="but1"   href="'.$jumpv.'&pidname='.$pidnamecur.'&file=edit_blockid&act=edit">修改标识</a>';
 //$edit2 .=  ' <a class="but2" href="'.$jumpv.'&pidname='.$pidnamecur.'&file=edit_layout&act=edit">公共布局</a>';

 
 $js_back = $jumpv.'&pidname='.$pidnamecur;
$activatestyle= "<p><a href=javascript:confirmaction('activatestyle','nodel','$js_back','确定启用这个模板？这会直接影响前台效果！')  class=but2>启用模板</a></p>";

 
 $dirhere = TEMPLATEROOT.$htmldir;
 if(!is_dir($dirhere)) {
  $activatestyle ='模板目录不存在，请到<a target="_blank" href="'.fronturl($dmlink_home).'">官网下载更多模板</a>。';
 }

$classV='';
  if($curstyle==$pidnamecur)  $classV="cur";

 ?>
<li class="<?php echo $classV;?>">
<div class="img">
<?php 
  echo $kv;
 
?>
</div>
<h3><?php echo $title;?></h3>
<div class="cgray" style="padding:5px 0"><?php echo $pidnamecur;?></div>
<div  style="padding:5px 0">
 模板目录: <strong class="cblue"><?php echo $htmldir;?></strong></div>
<div style="height:30px">
<?php 
  echo $activatestyle; 
  ?>
</div>


<div style="height:30px">
排序号：<input type="text" name="<?php echo $tid;?>"  value="<?php echo $vcat['pos'];?>" size="5" />
</div>

<div class="edit"  style="height:30px">
 <?php 
  echo $edit; 

 

    ?>

</div>
</li>
<?php 
} 
?>
 </ul>
 <div class="c"></div>
<div class="tc" style="padding-bottom:22px"><input class="mysubmit" type="submit" name="Submit" value="排序" />
<br />
<?php echo $sortid_desc?></div>
</form>
<?php }?>

 


</div>
<div class="c"></div>

