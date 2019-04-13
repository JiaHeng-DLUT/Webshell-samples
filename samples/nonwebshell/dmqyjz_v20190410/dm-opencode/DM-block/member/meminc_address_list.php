<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}  
 ?>
 <?php 
echo ' <p><a href="member-address-add.html">添加地址</a></p>';

  $sql = "SELECT * from ".TABLE_ADDRESS." where  $noandlangbh and pid='$mempidname'  order by sta_default desc, id desc";
 //echo $sql;
$rowlist = getall($sql);
if($rowlist=='no'){ echo '<p>暂无内容,请添加。</p>';
}
else{
?> 
 <table class="formtab">    
<tr class="tableheader"> 
<td  align="center">姓名</td>
 <td  align="center">手机</td>
 <td   align="center">地址</td>
 <td  align="center">编辑</td>
 <td  align="center">删除</td>
 
</tr>
 <?php  
    foreach ($rowlist as $v) {
    	$tid=$v['id'];
    	$name=$v['name'];
		$telephone=$v['telephone'];
		$address=$v['address'];
		$sta_default=$v['sta_default'];
		$edit = '<a href="member-address-edit-'.$tid.'.html">编辑</a>';
		$del = '<a href="member-address-del-'.$tid.'.html">删除</a>';

		 $sta_default = $sta_default=='y'?'<span class="cred">[默认]</span>':'';

		?>
 <tr >
 <td align="center"><?php echo $name; ?></td> 
  <td align="center"><?php echo $telephone; ?></td> 
   <td align="center"><?php echo $sta_default.$address; ?></td> 
   <td align="center"><?php echo $edit; ?></td>
   <td align="center"><?php echo $del; ?></td>
     
 </tr>
<?php 
}
 ?>
 </table>
 <?php
 }
 ?>
