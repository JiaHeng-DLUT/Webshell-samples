<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

/*
//no need main lang in programme,will set in config.php
$sqlmain = "SELECT * from ".TABLE_LANG." where   sta_main='y' and pbh='".USERBH."' order by id limit 1";
 //echo $sqlmain;
		//echo getnum($sqlmain);
		if(getnum($sqlmain)==0){
		  $errortextlang = '提示：目前没有主语言，网站必须要有一个主语言，请在 “语言设置” 里选一个。';
		   alert($errortextlang);
		   echo '<p style="background:red;color:#fff">'.$errortextlang.'</p>';	
		}
		
*/		
	
?>
 
<form method=post action="<?php echo $jumpv;?>&act=pos">
 <table class="formtab">    
<tr class="tableheader">
<td   align="center">昵称/Email/手机号</td>

<td  align="center">修改</td>
 <td  align="center">状态</td>
 <td   align="center">重置密码</td>
 <td  align="center">删除</td>
 <td  align="center">时间</td>
</tr>
<?php
 $sql = "SELECT * from ".TABLE_AUTH." where  $noandlangbh  order by  id desc";
 //echo $sql;
$rowlist = getall($sql);
if($rowlist=='no') echo '暂无内容';
else{
foreach($rowlist as $v){
 
$tid=$v['id'];$pidname=$v['pidname'];
$nickname=$v['nickname'];
$email=$v['email'];
$telephone=$v['telephone'];
$dateedit=$v['dateedit'];
 
$sta_noaccess=$v['sta_noaccess']; 
 
 
$jsname = jsdelname($nickname);
 //menu_changesta($sta_visi_v,$jumpv,$tid,'sta');

 $lang = LANG;
 $edit  = '<a class="but1" href="'.$jumpvfaddedit.'&act=edit&tid='.$tid.'">修改</a>   ';
 
$del = " <a class='but2'  href='$jumpv&file=del&act=edit&tid=$tid'><i class='fa fa-trash-o'></i> 删除</a>";

 //$del= " <a href=javascript:delid('del','$tid','$jumpv','$jsname')  class=but2><i class='fa fa-trash-o'></i> 删除</a>";
 
 $editps  = '<a class="but1" href="'.$jumpv.'&file=editps&act=edit&tid='.$tid.'">重置密码</a>   ';
 ?>



 <tr >
 <td align="center">
 <?php 
 echo '昵称：'.$nickname.'  <span class="cgray">('.$pidname.')</span>';
 
 if($email<>'') echo '<br />Email：'.$email;
 if($telephone<>'') echo '<br />手机号：'.$telephone;
 ?>
 </td> 


  <td align="center"> <?php   echo $edit; ?> </td>

  <td align="center">
  <?php 
  if($sta_noaccess=='y') echo '<span class="cred">已阻止</span>';
  else echo '正常';
 
 ?>
 </td> 
 <td align="center">  <?php  echo $editps; ?> </td>
 <td align="center">  <?php  echo $del; ?> </td>
 <td align="center">
  <?php 
 echo $dateedit;
 ?>
 </td>
 
 
 </tr>
 <?php
}
}
?>
</table>

 
<br />
 
</form>
 

  