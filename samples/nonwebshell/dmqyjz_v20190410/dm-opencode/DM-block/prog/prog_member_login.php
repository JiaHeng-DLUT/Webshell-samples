<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
} 

if (isset($_SESSION['mempidname'])){
       jump('member-info.html');
}


?>


<a href="login.html">登录</a> | <a href="register.html">注册</a>

 
 <div class="bodyheader"><h3> 登录</h3></div> 
 
 <div   class="formblock memberlogin lineclear">
   
 		<div class="line">
			<div class="key" data-typeinput="text" data-error="error1">
			<span class="errorstar">*</span>
			<span class="label">Email或手机：</span>			 
			</div>
			<div class="valuediv">
			 <input type="text" placeholder="Email或手机"  value="" name="email" class="value form-control"><p class="error">不能为空</p> 
			</div>
			 </div>	

		 <div class="line">
			<div class="key" data-typeinput="text" data-error="error1">
			<span class="errorstar">*</span> 			
			<span class="label">密码：</span>			 
			</div>
			<div class="valuediv">
			 <input type="password" value="" placeholder="密码"  name="ps" class="value form-control"><p class="error">不能为空</p> 
			</div>
			 </div>	
 
 
	 <div class="linesubmit">
	   <div class="dmbtn">   
			<input type="submit" class="more submit cp" value="登录">  
			<div class="submitloading dn"> </div> 
	   </div>
	</div><!--end submit-->
</div> 
 
 
<script>
 
var ajaxformurl = '<?php echo BASEURL?>dmpostform.php?type=memlogin&lang=<?php echo LANGPATH?>';
 
 
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



     var email = $.trim($("input[name='email']").val());
     
     var ps = $.trim($("input[name='ps']").val());
     //alert(email.indexOf("@"));
     if(email.indexOf("@")==-1){
     	///alert(checkphone(email));
     	if(!checkphone(email)) {
     		$("input[name='email']").next().show().text('手机格式不对');
     		errorhint = true;
     	}
          var text = '手机';
     }
     else{
     	if(!checkemail(email)) {
     		$("input[name='email']").next().show().text('Email格式不对');
     		errorhint = true;
     	}
             var text = 'Email';
     }

   if(ps=='') {
     		$("input[name='ps']").next().show();
     		errorhint = true;
     	}  
  //var thiscnt = thiskey + thisvalue + '<br />';
  //content = content+thiscnt;

  
 
  if(errorhint)  return;
 
var failtext = text+'或密码不对。';
 //-----------------------
        jQuery.ajax({
            type: 'POST',
            url: ajaxformurl,
            dataType : "json",
            data: {email : email,ps : ps},
            success: function(data){

		        if(data.id=='fail') {
		          $.fancybox.open('<div style="text-align:center;color:red;padding:50px;font-size:14px">'+failtext+'</div>'); 

		         }
		       if(data.id=='yes'){ 
		       			 window.location.href='member-info.html';
		              
		         }
		        $('.formblock .submitloading').hide();
		      }
        }); //end ajax

 //--------------------------

}

 
 
 
/*end form js*/



</script>

