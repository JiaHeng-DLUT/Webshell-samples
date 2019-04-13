<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
 
 
?> 
 
 
 <?php 

 $sql = "SELECT * from ".TABLE_BLOCKGROUP." where pid='$pid'  $andlangbh order by pos desc,id";
 $rowlist = getall($sql);
if($rowlist=='no') echo '暂无内容';
else{

            ?>
 <form method=post action="<?php echo $jumpv;?>&act=pos">
 <table class="formtab formtabhovertr">    
<tr style="background:#B3C0E0">
<td   align="center">排序号</td>
<td  >标题</td>
 
<td  align="center">操作/td>
<td align="center">状态</td> 

</tr>
<?php

foreach($rowlist as $v){
$pidname2=$v['pidname'];
$name=$v['name'];$namebz=$v['namebz'];
$tid=$v['id'];
$blockid=$v['blockid']; 
$cssname=$v['cssname'];  

$sta_visi_v=$v['sta_visible']; 

menu_changesta($sta_visi_v,$jumpvpf,$tid,'sta');
 
 if(substr($blockid,0,3)=='reg')  $sta_sub ='<span class="cred">[调区域]</span>';
 else $sta_sub ='';

 
$editlink='<a class=but1   href='.$jumpv.'&file=addedit&act=edit&tid='.$tid.'><i class="fa fa-pencil-square-o"></i>  修改</a> ';
 
$del_text= "<a href=javascript:del2('delsub','$pid','$pidname2','$jumpv')  class=but2><i class='fa fa-trash-o'></i> 删除</a>";
 
$namebz2 ='';
if($namebz<>'') $namebz2 = '<br /><span class="cyel">说明：'.$namebz.'</span>';
?>

<tr <?php echo $tr_hide;?>>
 <td align="center"><input type="text" name="<?php echo $tid;?>"  value="<?php echo $v['pos'];?>" size="5" /></td> 


<td>
<strong><?php echo $name;?></strong>

<div class="mobhide cgray"><?php echo $pidname2;?></div>

<div>是否显示标题：<?php echo $v['sta_name'];?> </div>
 
 <?php 
if($cssname<>'')  echo 'css名称：'.$cssname.'<br />';
?> 
 <?php echo check_blockid($blockid);?> 
</td> 

 


<td align="center"><?php echo $editlink.$del_text;?></td>
<td align="center"><?php echo $sta_visible;?></td>

 </tr> 
 <?php
}
 ?>
	
	</table>
<div style="padding-bottom:22px;text-align:left">
<input class="mysubmit" type="submit" name="Submit" value="排序" />
<p><?php echo $sort_ads?>
</p>
</div>
</form>
<?php }
?>