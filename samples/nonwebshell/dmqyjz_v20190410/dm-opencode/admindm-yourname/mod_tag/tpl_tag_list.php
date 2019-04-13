<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

?>
 
<form method=post action="<?php echo $jumpv;?>&act=pos">
 <table class="formtab formtabhovertr">    
<tr>
<td   align="center">排序号</td>
<td  align="center">标题</td>
 <td  align="center">
<?php 
 echo  '<a href="'.$jumpv.'&file=viewnode">查看所有</a>';
  ?>
 </td>
 <td  align="center">权重</td>

 
<td  align="center">操作</td>
 <td  align="center">状态</td>
</tr>
<?php
 $sql = "SELECT * from ".TABLE_TAG." where  $noandlangbh  order by pos desc,id";
$rowlist = getall($sql);
if($rowlist=='no') echo '暂无内容';
else{
foreach($rowlist as $v){
 
$tid=$v['id'];
$name=$v['name']; 
$weight=$v['weight']; $pid=$v['pidname'];
$sta_visi_v=$v['sta_visible']; 

$jsname = jsdelname($v['name']);
 
 
 $edit_text= "<a class='but1'   href='$jumpv&tid=$tid&file=addedit&act=edit'><i class='fa fa-pencil-square-o'></i> 修改</a>";
 
 
$del_text= " <a href=javascript:del('del_tag','$pid','$jumpv','$jsname')  class=but2><i class='fa fa-trash-o'></i> 删除</a>";


 menu_changesta($sta_visi_v,$jumpv,$tid,'sta');

 
  $ss="select id from  ".TABLE_TAGNODE."  where tag='$pid'   $andlangbh";
$ssnum = getnum($ss);

 $view = '<a href="'.$jumpv.'&file=viewnode&pid='.$pid.'">查看('.$ssnum.')</a>';

 ?>



 <tr <?php echo $tr_hide;?>>
 <td align="center">
 <input type="text" name="<?php echo $tid;?>"  value="<?php echo $v['pos'];?>" size="5" />
 </td> 
  <td align="center"> <?php  echo $name;   ?>

  <a class="needpopup" href="../mod_seo/mod_seo_edit.php?lang=<?php echo LANG?>&act=edit&pidname=<?php echo $pid?>&amp;type=tag">修改SEO</a>

 </td> 
  <td align="center"><?php echo $view;?></td>
 <td align="center"><?php echo $weight;?></td>
 <td align="center"><?php echo $edit_text.$del_text;?></td>
  <td align="center"><?php echo $sta_visible;?></td>

 </tr>
 <?php
}
}
?>
</table>

<div style="padding-bottom:22px"><input class="mysubmit" type="submit" name="Submit" value="排序" />
<br />
<?php echo $sortid_asc?></div>
</form>
 

 

 

 

 