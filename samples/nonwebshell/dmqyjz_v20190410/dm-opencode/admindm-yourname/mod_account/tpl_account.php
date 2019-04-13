<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

?>
 <?php
	//$testps='111111';
  // $salt = 'cm';
	//$pssold222= crypt($testps, $salt);
	//echo $pssold222.'====<br>';
 
 //---------------------
 
  //echo 'aa'.$useremail;//from common.php

 
 if($act=="editps"){
  $psold= crypt($abc1, $salt);
  $psnew= htmlentitdm(crypt($abc2, $salt));

 
  $ss="select id from  ".TABLE_USER."  where email='$useremail' and ps='$psold' and type='admin'";
 // echo $ss;exit;
       if(getnum($ss)){	
				
				 if(strlen($abc2)<6)
					{
						alert('密码不能少于6个字符');    jump($jumpv);
					}
					
				if($abc2<>$abc3)
				{
					alert('两次密码不一样。'); 
					jump($jumpv);
				}
				else{
					  $sql="update   ".TABLE_USER."  set ps='$psnew'   where email='$useremail'  and type='admin' limit 1";
					 iquery($sql);
				   alert('密码修改成功，请重新登录。');				
				}	   
	   }
	   else{
		  alert('原密码不对。');
          jump($jumpv);
	   }
	   
	   
}	   
          

 
 
 ?>

<div class="contenttop">帐号管理  -- 只有一个超级管理员 </div>

<?php 
//echo  '<a href="../mod_account/mod_user.php?lang='.LANG.'&file=list">添加管理员</a>';
 


?>
<form name="form1" method="post" action="<?php echo $jumpv.'&act=editps' ?>">

 
 <table class="formtab">    
<tr class="formtitle--">
<td width="30%" align="right">超级管理员的原密码：</td>
<td   align="left"> <input name="psold" type="password"  class="form-control" /> </td>
</tr>
 
 <tr>
<td   align="right">新密码：</td>
<td   align="left"> <input name="ps1" type="password" class="form-control"  />（英文或数字，且不能少于6个字符） </td>
</tr>

 <tr>
<td  align="right">确定新密码：</td>
<td  align="left"> <input name="ps2" type="password"  class="form-control" /> </td>
</tr>

 <tr>
<td  align="center"> </td>
<td   align="left"><input class="mysubmit" type="submit" name="Submit" value="提交"></td>
</tr>



</table>
 
  </form>

 
