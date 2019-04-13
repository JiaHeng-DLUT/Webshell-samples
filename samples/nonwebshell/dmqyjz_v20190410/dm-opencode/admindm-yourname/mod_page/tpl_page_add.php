<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
//---------------------
if($act == "insert")
{
      if(strlen(trim($abc1))<2){
        alert('名称不能为空或字太少');
        jump($jumpv);
    }
	$pidname='page'.$bshou;
	//date("YmdHis").'_'.rand(1000,9999);
	$arr_can='sta_noaccess:##n==#==pagelayout:##noallwidth==#==downloadurl:##==#==seocus1:##==#==seocus2:##==#==seocus3:##';
		$ss = "insert into ".TABLE_PAGE." (pid,pidname,pbh,lang,name,arr_can) values ('0','$pidname','$user2510','".LANG."','$abc1','$arr_can')";		
		iquery($ss);		 
		//alert('添加成功!');
		jump($jumpv);
	
} 
 

else {
?>
 
<form  method="post"  onsubmit="javascript:return checkhereadd(this)" action="<?php echo $jumpv_insert;?>">
<table class="formtab">
  <tr>
    <td width="20%" class="tr">名称：</td>
    <td > <input name="name" type="text" id="name" value="" class="form-control" />
      (如 关于我们或公司简介等 ) <?php echo $xz_must;?></td>
  </tr>




  <tr>
    <td> </td>
    <td>
 <br /> <br />
	<input class="mysubmit" type="submit" name="Submit" value="添加" /> <br />
</td>
  </tr>
 </table>
</form>


 
<?php
}
?>
 
 
 <script>
function  checkhereadd(thisForm){
		if (thisForm.name.value==""){
		alert("请输入名称");
		thisForm.name.focus();
		return (false);
        } 
}

</script>


