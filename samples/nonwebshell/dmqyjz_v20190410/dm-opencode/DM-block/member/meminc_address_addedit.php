<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
} 
 $name = $telephone = $address='';
 if($memact=='add') {
 	$sta_default = '';
 	$formaction = 'member-address-insert.html';
 }
 	
 if($memact=='edit'){
           	$sql = "SELECT * from ".TABLE_ADDRESS." where pid='$mempidname' and id = '$memtid' and  lang='". LANG ."'  order by id desc";
          // 	echo $sql;
	$num = getnum($sql);
	if($num>0){
		$row = getrow($sql);
		$name = $row['name']; 
		$telephone = $row['telephone'];
		$address = $row['address']; 

		$sta_default = $row['sta_default']; 

	}

	$sta_default = $sta_default=='y'?' checked = "checked" ':''; 
$formaction = 'member-address-update-'.$memtid.'.html';

 }
 ?>
<form   action="<?php echo $formaction ;?>" method="post">
<div   class="formblock   lineclear"> 
 
 		<div class="line">
			<div class="key" data-typeinput="text" data-error="error1">
			<span class="errorstar">*</span>
			<span class="label">姓名：</span>			 
			</div>
			<div class="valuediv">
			 <input type="text"    value="<?php  echo $name;?>" name="name" class="value form-control"><p class="error">不能为空</p> 
			</div>
			 </div>	
 	

 		<div class="line">
			<div class="key" data-typeinput="text" data-error="error2">
			<span class="errorstar">*</span>
			<span class="label">手机：</span>			 
			</div>
			<div class="valuediv">
			 <input type="text"   value="<?php  echo $telephone;?>" name="telephone" class="value form-control"><p class="error">手机号格式不对</p> 
			</div>
			 </div>	

		 <div class="line">
			<div class="key" data-typeinput="text" data-error="error1">
			<span class="errorstar">*</span> 			
			<span class="label">地址：</span>			 
			</div>
			<div class="valuediv">
			 <input type="text" value="<?php  echo $address;?>"   name="address" class="value form-control"><p class="error">不能为空</p> 
			</div>
			 </div>	

			 <div class="line">
			<div class="key" data-typeinput="text" data-error="error1">
		 			
			<span class="label">&nbsp; </span>			 
			</div>
			<div class="valuediv">
			
 
			<input name="sta_default" <?php echo $sta_default;?> id="defaultaddress" type="checkbox" > <label for="defaultaddress">设置为默认收货地址</label> 


			</div>
			 </div>	

			 
 
	 <div class="linesubmit">
	   <div class="dmbtn">   
			<input type="submit" class="more submit cp" value="提交">  
			<div class="submitloading dn"> </div> 
	   </div>
	</div><!--end submit-->
</div> 
 
 
</form>

<script>
$(function(){
    $('.formblock .submit').click(function() {
         
           $('.formblock .error').hide(); 
 
	 	var  errorhint = false; 

		var name = $.trim($("input[name='name']").val());
		  var telephone = $.trim($("input[name='telephone']").val());
		  var address = $.trim($("input[name='address']").val());

		  if(name=='') {
		     		$("input[name='name']").next().show();
		     		errorhint = true;
		     	} 
		 
		 if(!checkphone(telephone)) {
		     		$("input[name='telephone']").next().show();
		     		errorhint = true;
		     	}
		     

		   if(address=='') {
		     		$("input[name='address']").next().show();
		     		errorhint = true;
		     	}  
		  //var thiscnt = thiskey + thisvalue + '<br />';
		  //content = content+thiscnt;
 
		 
		  if(errorhint)  return false; 
    });


});

</script>