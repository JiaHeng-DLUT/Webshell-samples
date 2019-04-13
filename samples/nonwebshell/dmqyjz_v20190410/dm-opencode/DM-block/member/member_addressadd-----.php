<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
} 

 ?>

 <div class="membersidebar col_1f3"> 
 <?php  
 require(TPLBASEROOT.'member/membersidebar.php');
  ?>
 </div>
 <div class="membercnt col_2f3"> 
 
 
 <div class="bodyheader"><h3> 收货地址</h3></div> 
 
 <div   class="formblock memberlogin lineclear"> 
 
 		<div class="line">
			<div class="key" data-typeinput="text" data-error="error1">
			<span class="errorstar">*</span>
			<span class="label">姓名：</span>			 
			</div>
			<div class="valuediv">
			 <input type="text" placeholder="姓名"  value="" name="name" class="value form-control"><p class="error">不能为空</p> 
			</div>
			 </div>	
 	

 		<div class="line">
			<div class="key" data-typeinput="text" data-error="error2">
			<span class="errorstar">*</span>
			<span class="label">手机：</span>			 
			</div>
			<div class="valuediv">
			 <input type="text" placeholder="手机"  value="" name="telephone" class="value form-control"><p class="error">手机号格式不对</p> 
			</div>
			 </div>	

		 <div class="line">
			<div class="key" data-typeinput="text" data-error="error1">
			<span class="errorstar">*</span> 			
			<span class="label">地址：</span>			 
			</div>
			<div class="valuediv">
			 <input type="text" value="" placeholder="地址"  name="address" class="value form-control"><p class="error">不能为空</p> 
			</div>
			 </div>	
			 
 
	 <div class="linesubmit">
	   <div class="dmbtn">   
			<input type="submit" class="more submit cp" value="添加地址">  
			<div class="submitloading dn"> </div> 
	   </div>
	</div><!--end submit-->
</div> 
 
 

 </div> 
</div> 
<div class="c"> </div> 


<script>
 
var ajaxformurl = '<?php echo BASEURL?>dmpostform.php?type=memaddressadd&lang=<?php echo LANGPATH?>';
 
 
$(function(){
    $('.formblock .submit').click(function() {
         form_ajax(ajaxformurl);        
    });


});




/*begin form js*/
function form_ajax(ajaxformurl){
  $('.formblock .error').hide();

     $('.formblock .submitloading').show();
 
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

  
 
  if(errorhint)  return;
 
 
 //-----------------------
        jQuery.ajax({
            type: 'POST',
            url: ajaxformurl,
            dataType : "json",
            data: {name : name,telephone : telephone,address : address},
            success: function(data){

		        if(data.id=='fail') {
		          $.fancybox.open('<div style="text-align:center;color:red;padding:50px;font-size:14px">添加失败。</div>'); 

		         }
		       if(data.id=='yes'){ 
		       			 window.location.href='member-address.html';
		              
		         }
		        $('.formblock .submitloading').hide();
		      }
        }); //end ajax

 //--------------------------

}

 
 
 
/*end form js*/



</script>



