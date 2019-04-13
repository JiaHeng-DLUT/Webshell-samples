
<?php 
// kvimg and thumb,for pop up



?>

<div style="text-align:center;border:1px solid #ccc;padding:8px;margin-bottom:20px">
<?php 
echo  p2030_imgyt($kv,'y','n');


?>

<p><a class="needpopup but1 pad8lr" style="width:auto"  href="../mod_module/mod_uploadkv.php?lang=<?php echo LANG?>&pidname=<?php echo $pidname?>&type=nodekv">修改kv图片</a></p>

</div>





<div style="text-align:center;border:1px solid #ccc;padding:8px;margin-bottom:20px">
<?php 
if($kvsm<>'')
//echo   get_thumb($kvsm,'','div');
	echo  p2030_imgyt($kvsm,'y','n');
//echo    '<img style="width:120px" src="'.get_img($kvsm,$title,'nodiv').'" >';
?>
<p>
 
<a class="needpopup but1 pad8lr" style="width:auto" href="../mod_module/mod_uploadkvsm.php?lang=<?php echo LANG?>&pidname=<?php echo $pidname?>&type=nodekvsm">修改缩略图片</a>
 
</p>
 

</div>





<div style="text-align:center;border:1px solid #ccc;padding:8px;margin-bottom:20px">
<?php 
if($kvsm2<>'')
echo  p2030_imgyt($kvsm2,'y','n');
//echo    '<img style="width:120px" src="'.get_img($kvsm2,$title,'nodiv').'" >';

?>
<p><a class="needpopup but1 pad8lr" style="width:auto"  href="../mod_module/mod_uploadkvsm.php?lang=<?php echo LANG?>&pidname=<?php echo $pidname?>&type=nodekvsm2">修改缩略图片(张二张)</a></p>
<p class="cgray">第二张很少用，只适用于个别的效果模板</p>
</div>

