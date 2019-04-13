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
 

	ifsuredel_field(TABLE_AUTH,'id',$tid,'eq',$jumpv);

}   

 

if($act=="edit"){
	$sql = "SELECT * from ".TABLE_AUTH." where id = '$tid' and  lang='". LANG ."'  order by id desc";
	$num = getnum($sql);
	if($num>0){
		$row = getrow($sql);
		$nickname = $row['nickname'];
		$telephone = $row['email'];
		$telephone = $row['telephone']; 
	}

	//$jump_insert = $jumpv.'&file=editps&act=update&tid='.$tid;
}  


if($act=='edit'){ 
	
	echo '昵称：'.$nickname;
	echo '<br />Email：'.$telephone;
	echo '<br />手机号：'.$telephone;
	
	$del = " <a  href='$jumpv&file=del&act=update&tid=$tid'>  确定删除</a>";

?> 
<br />
<p style="padding:20px;font-size:20px">确定删除吗？与其相关的订单等信息也会被删除。</p>

<?php echo $del;?>


<br /><br />
 <a class='but1' href="<?php echo $jumpv;?>">取消删除，返回会员管理。</a>
	
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


