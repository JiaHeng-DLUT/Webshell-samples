<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

?>
<?php
 
if($act=="update"){
 
	$ps= htmlentitdm(crypt($abc1, $salt));
		$ss = "update ".TABLE_AUTH." set  ps='$ps' where id='$tid' limit 1";
	  // echo $ss;exit;
		iquery($ss);
		//alert("添加成功。");
		echo '<p style="padding:20px;text-align:center">密码已重置为：'.$abc1;
		echo '<br /><br /><a href="'.$jumpv.'">返回会员管理</a></p>';
	//	jump($jumpv.'file=editps&act=edit&tid='.$tid); 

 


}   

 

if($act=="edit"){
	$sql = "SELECT * from ".TABLE_AUTH." where id = '$tid' and  lang='". LANG ."'  order by id desc";
	$num = getnum($sql);
	if($num>0){
		$row = getrow($sql);
		$nickname = $row['nickname'];
		$email = $row['email'];
		$telephone = $row['telephone']; 
	}

	$jump_insert = $jumpv.'&file=editps&act=update&tid='.$tid;
}  


if($act=='edit'){ 	
?> 




<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jump_insert;?>" method="post">
  <table class="formtab">
 
	
    <tr>
      <td width="20%" class="tr">昵称:</td>
      <td width="78%">
	  <?php echo $nickname;?>
	  </td>
    </tr>
 
  
	<tr>
	<td width="20%" class="tr">Email:</td>
	<td width="78%">
	<?php echo $email;?>
	 </td>
  </tr>
  <tr>
	<td width="20%" class="tr">手机号:</td>
	<td width="78%">
	<?php echo $telephone;?>
	 </td>
  </tr>

  <tr>
	<td width="20%" class="tr">重置密码:</td>
	<td width="78%">
	<input  type="text"  class="form-control"  name="editps" value=""  ><?php echo $xz_must;?>	    
       
	 </td>
  </tr>
	 
<tr>
      <td></td>
      <td>
      <input  class="mysubmit" type="submit" name="Submit" value="提交"></td>
    </tr>
  </table>
</form>
 
	
<?php } ?>
 
<script>
function  checkhere(thisForm){
	 
		if (thisForm.editps.value==""){
		alert("密码不能为空");
		thisForm.editps.focus();
		return (false);
        } 
	  
		
}

</script>


