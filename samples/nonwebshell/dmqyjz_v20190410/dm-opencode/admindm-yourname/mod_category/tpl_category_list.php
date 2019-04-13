<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>

 <div class="contenttop">
  <a href="<?php echo $jumpv?>&file=add&act=add"><i class="fa fa-plus-circle"></i> 添加主类 </a>
</div>


<div class="box">

<div class="boxcontent">
<?php
$k = 'node';
$sql = "SELECT * from ".TABLE_CATE." where   modtype='$k' and pid='0'   $andlangbh  order by pos desc,id";
$rowlist = getall($sql);
 if($rowlist=='no') echo $norr2;
 else{

?>
<form method=post action="<?php echo $jumpv;?>&act=pos">
<table class="formtab formtabhovertr">
<tr class="trheader">
<td align="center"  width="10%">排序</td>
 <td >名称</td>
<td align="center" >管理内容</td>
<td align="center">操作</td>

</tr>
<?php
	foreach($rowlist as $v){
	$tidmain = $v['id'];
	$pidnamemain = $v['pidname'];
	$name = decode($v['name']);
	$jsname = jsdelname($name);
	//$alias = alias($pidnamemain ,'cate');
	//if($alias=='') echo $alias='<br />请修改别名'.$pidnamemain;

		if($catid==$pidnamemain)
			$cat_cur='class="cur" ';
		else  $cat_cur='';
 
$link= admlink($v);

$editmain = '<a class="but1"  href="'.$jumpv.'&catid='.$pidnamemain.'&file=edit&act=edit"><span><i class="fa fa-pencil-square-o"></i> 修改</span></a>';
$delmain =  "<a class='but2'  href=javascript:del('delmaincate','$pidnamemain','$jumpv','$jsname')><span><i class='fa fa-trash-o'></i> 删除</span></a>";

$glnode= '<a class="but3" target="_blank"  href="../mod_node/mod_node.php?lang='.LANG.'&catpid='.$pidnamemain.'&page=0"><span><i class="fa fa-folder"></i> 内容</span></a>';



 ?>

<tr>
<td align="center"><input type="text" name="<?php echo $tidmain;?>"  value="<?php echo $v['pos'];?>" size="3" /></td>
 <td>
<?php
	echo '<a '.$cat_cur.' href="mod_subcate.php?lang='.LANG.'&catid='.$pidnamemain.'"><strong style="font-size:18px">'.$name.'</strong></a><br />标识:'.$pidnamemain.'<br /> ';

	if($k<>'blockdh') echo $link;
?>
  </td>
   <td  align="center"><?php echo $glnode;?></td>
  <td  align="center"><?php echo $editmain.$delmain;?></td>

</tr>

<?php
}
?>
</table>

<div style="padding-bottom:22px">
<input class="mysubmit" type="submit" name="Submit" value="排序" />
<br />
<?php echo $sortid_asc?></div>
</form>
<?php }?>

</div>
</div>  <!--end box-->
