<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

 
 if($act=='insert')
 {
   zb_insert($_POST);//move here.because  Warning: addslashes() because checkbox.
  if($abc1<>''){

       $sql = "SELECT * from ".TABLE_USER."  where email='$abc1'  order by id limit 1";
       if(getnum($sql)>0) {alert('管理员已存在！');jump($jumpv);}

  }
 

  if($abc1 == '') $abc1 = '请输入标题';
			$ss = "insert into ".TABLE_USER." (email,bh,ps,userdir,lang,dateedit) values ('$abc1','".USERBH."','ps','userdir','".LANG."','$dateall')";
		  //echo $ss;exit;
			iquery($ss);
			//alert("添加成功,然后点击左边来修改");
			//jump($jumpv.'&file=mainedit&act=edit&pidname='.$pidname);
      jump($jumpv.'&file=list');
			
 
 }
 
 else {
 
 
 $jumpv_insert = $jumpvf.'&act=insert';
 
?>
 
 

<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert?>" method="post">
  <table class="formtab">
    <tr>
      <td width="22%" class="tr">管理员名称：</td>
      <td width="77%"> <input name="name" type="text" value="" class="form-control"><?php echo $xz_must; ?> 
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
function checkhere(thisForm) {
   if (thisForm.name.value=="")
	{
		alert("请输入名称。");
		thisForm.name.focus();
		return (false);
	}
  
   /* var sm_w = parseInt(thisForm.sm_w.value);
  var sm_h = parseInt(thisForm.sm_h.value);
  if(sm_w<20){
      alert("必须大于20。");
    thisForm.sm_w.focus();
    return (false)
      
  }
    if(sm_h<20){
      alert("必须大于20。");
    thisForm.sm_h.focus();
    return (false)
      
  }
  

   if (!isnum(thisForm.sm_w.value))
  {
    alert("必须为数字。");
    thisForm.sm_w.focus();
    return (false);
  }
  
   if (!isnum(thisForm.sm_h.value))
  {
    alert("必须为数字。");
    thisForm.sm_h.focus();
    return (false);
  }
  */

   // return;

}
 

</script>
