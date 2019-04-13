<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

?>
<?php

if($act=="insert"){


		$sql = "SELECT nickname from ".TABLE_AUTH." where nickname = '$abc1' and  lang='". LANG ."'  order by id desc";
		$num1 = getnum($sql);

		$sql = "SELECT email from ".TABLE_AUTH." where email = '$abc2' and  lang='". LANG ."'  order by id desc";
		$num2 = getnum($sql);

		$sql = "SELECT telephone from ".TABLE_AUTH." where telephone = '$abc3' and  lang='". LANG ."'  order by id desc";
		$num3 = getnum($sql);

		if($num1>0 && $abc1<>'')
		{

			alert('出错，昵称重复-'.$abc1);
			jump($jumpvfaddedit.'&act=add');
		}
		else if($num2>0 && $abc2<>'')
		{

			alert('出错， Email重复'.$abc2);
			jump($jumpvfaddedit.'&act=add');
		}
		else if($num3>0 && $abc3<>'')
		{

			alert('出错， 手机号重复'.$abc3);
			jump($jumpvfaddedit.'&act=add');
		}
		else{

          $ps= htmlentitdm(crypt($abc5, $salt));
		  $pidname = 'mem' . $bshou.'t'.rand(11111,99999);
			$ss = "insert into ".TABLE_AUTH." (lang,pbh,pidname,nickname,email,telephone,sta_noaccess,ps,dateedit) values ('".LANG."','$user2510','$pidname','$abc1','$abc2','$abc3','$abc4','$ps','$dateall')";
		 	// echo $ss;exit;
		    iquery($ss);
		    alert("添加成功。");
		    jump($jumpv);

		}




}
if($act=="update"){

	$sql = "SELECT nickname from ".TABLE_AUTH." where nickname = '$abc1' and id<> '$tid' and  lang='". LANG ."'  order by id desc";
	$num1 = getnum($sql);

	$sql = "SELECT email from ".TABLE_AUTH." where email = '$abc2'  and id<> '$tid' and     lang='". LANG ."'  order by id desc";
	$num2 = getnum($sql);

	$sql = "SELECT telephone from ".TABLE_AUTH." where telephone = '$abc3'  and id<> '$tid' and  lang='". LANG ."'  order by id desc";
	$num3 = getnum($sql);

	if($num1>0 && $abc1<>'')
	{

		alert('出错，昵称重复-'.$abc1);
		jump($jumpvfaddedit.'&act=edit&tid='.$tid);
	}
	else if($num2>0 && $abc2<>'')
	{

		alert('出错， Email重复'.$abc2);
		jump($jumpvfaddedit.'&act=edit&tid='.$tid);
	}
	else if($num3>0 && $abc3<>'')
	{

		alert('出错， 手机号重复'.$abc3);
		jump($jumpvfaddedit.'&act=edit&tid='.$tid);
	}
	else{


		$ss = "update ".TABLE_AUTH." set nickname='$abc1',email='$abc2',telephone='$abc3',sta_noaccess='$abc4' where id='$tid' limit 1";
	  // echo $ss;exit;
		iquery($ss);
		//alert("添加成功。");
		jump($jumpvfaddedit.'&act=edit&tid='.$tid);

	}









}

if($act=="add"){
	$nickname = $email = $telephone =  $ps='';
	$sta_noaccess = 'n';
	$jump_insert = $jumpvfaddedit.'&act=insert';
}

if($act=="edit"){
	$sql = "SELECT * from ".TABLE_AUTH." where id = '$tid' and  lang='". LANG ."'  order by id desc";
	$num = getnum($sql);
	if($num>0){
		$row = getrow($sql);
		$nickname = $row['nickname'];
		$email = $row['email'];
		$telephone = $row['telephone'];
		$sta_noaccess = $row['sta_noaccess'];

	}

	$jump_insert = $jumpvfaddedit.'&act=update&tid='.$tid;
}


if($act=="add" || $act=='edit'){
?>




<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jump_insert;?>" method="post">
  <table class="formtab">


    <tr>
      <td width="20%" class="tr">昵称:</td>
      <td width="78%">
	  <input  type="text"  class="form-control"  name="nickname" value="<?php echo $nickname;?>"  ><?php echo $xz_must;?>
        </td>
    </tr>


	<tr>
	<td width="20%" class="tr">Email:</td>
	<td width="78%">
	<input  type="text"  class="form-control"  name="email" value="<?php echo $email;?>"  >
	  </td>
  </tr>
  <tr>
	<td width="20%" class="tr">手机号:</td>
	<td width="78%">
	<input  type="text"  class="form-control"  name="telephone" value="<?php echo $telephone;?>"  >
	  </td>
  </tr>
  <tr>
      <td class="tr">阻止帐号：</td>
      <td>  <select name="sta_noaccess" class="form-control">
    <?php select_from_arr($arr_yn,$sta_noaccess,'');?>
     </select>

   </td>
    </tr>


<?php
if($act=='add'){
?>
  <tr>
	<td width="20%" class="tr">密码:</td>
	<td width="78%">
	<input  type="text"  class="form-control"  name="ps" value="<?php echo $ps;?>"  >
	  </td>
  </tr>
<?php
}
?>


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

		if (thisForm.nickname.value==""){
		alert("昵称不能为空");
		thisForm.nickname.focus();
		return (false);
        }


}

</script>
