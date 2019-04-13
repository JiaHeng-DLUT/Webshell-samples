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

 
 <div class="bodyheader"><h3> 注册</h3></div> 
 
 <div   class="formblock memberlogin lineclear"> 
 
 		<div class="line">
			<div class="key" data-typeinput="text" data-error="error1">
			<span class="errorstar">*</span>
			<span class="label">昵称：</span>			 
			</div>
			<div class="valuediv">
			 <input type="text" placeholder="昵称"  value="" name="nickname" class="value form-control"><p class="error">不能为空</p> 
			</div>
			 </div>	

	 <div class="line">
			<div class="key" data-typeinput="text" data-error="error3">
			<span class="errorstar">*</span>
			<span class="label">Email：</span>			 
			</div>
			<div class="valuediv">
			 <input type="text" placeholder="Email"  value="" name="email" class="value form-control"><p class="error">E-mail格式不对</p> 
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
			<span class="label">密码：</span>			 
			</div>
			<div class="valuediv">
			 <input type="password" value="" placeholder="密码"  name="ps" class="value form-control"><p class="error">不能为空</p> 
			</div>
			 </div>	
			  <div class="line">
			<div class="key" data-typeinput="text" data-error="error1">
			<span class="errorstar">*</span> 			
			<span class="label">确认密码：</span>			 
			</div>
			<div class="valuediv">
			 <input type="password" value="" placeholder="确认密码"  name="checkps" class="value form-control"><p class="error">不能为空</p> 
			 <p class="errorps dn cred">两次密码不一致</p> 
			</div>
			 </div>	
 
 
	 <div class="linesubmit">
	   <div class="dmbtn">   
			<input type="submit" class="more submit cp" value="注册">  
			<div class="submitloading dn"> </div> 
	   </div>
	</div><!--end submit-->
</div> 
 


<?php  
//$inquerytooken = 'inq_'.date("Ymd_His_").rand(1111,9999);
 $tokenhour = 'inq_'.date("Ymd_H");//minute

 ?>
 <div    data-tokenhour="<?php echo $tokenhour?>"  class="contactpostnonce" style="display:none"> </div>
<!--end homeliuyan-->

<script>
 
var ajaxformurl = '<?php echo BASEURL?>dmpostform.php?type=memregister&lang=<?php echo LANGPATH?>';
 
 
$(function(){
    $('.formblock .submit').click(function() {
         form_ajax(ajaxformurl);        
    });


});






/*begin form js*/
function form_ajax(ajaxformurl){
  $('.formblock .error').hide();

     $('.formblock .submitloading').show();
     var tokenhour = jQuery('.contactpostnonce').data('tokenhour');
   // var content = '表单标题：'+formtitle+'<br />';
	 var thisvalue = '';
	 var  errorhint = false;



     var nickname = $.trim($("input[name='nickname']").val());
     var email = $.trim($("input[name='email']").val());
     var telephone = $.trim($("input[name='telephone']").val()); 
     
     var ps = $.trim($("input[name='ps']").val());
     var checkps = $.trim($("input[name='checkps']").val());


	$('.formblock .line').each(function(){
		var thiskey = $(this).find('.key span').text();
		var thistype = $(this).find('.key').data('typeinput');
		var thiserror = $(this).find('.key').data('error');

  if(thistype=='text' || thistype=='textarea')  {
      thisvalue = $.trim($(this).find('.value').val());

      if(thiserror=='error1' && thisvalue==''){
          $(this).find('.error').show();
          errorhint = true;
      }

      if(thiserror=='error2' && !checkphone(thisvalue)){
          $(this).find('.error').show();
          errorhint = true;
      }

      if(thiserror=='error3' && !checkemail(thisvalue)){
          $(this).find('.error').show();
          errorhint = true;
      }
      if(thiserror=='error4' && !checknumber(thisvalue)){
          $(this).find('.error').show();
          errorhint = true;
      }




  }
  if(thistype=='checkbox'){
    thisvalue = '';
    $(this).find('input:checkbox:checked').each(function(){
          thisvalue = thisvalue+$(this).val()+',';
    });

    if($(this).find('input:checkbox:checked').length==0){
        $(this).find('.error').show();
          errorhint = true;
    }
  }
   if(thistype=='radio')   {
    thisvalue = $(this).find('input:radio:checked').val();
    if($(this).find('input:radio:checked').length==0){
        $(this).find('.error').show();
          errorhint = true;
    }

  }
   if(thistype=='select')  {
     thisvalue = $(this).find('select').val();
       if(thisvalue==''){
        $(this).find('.error').show();
          errorhint = true;
      }
  }

  //var thiscnt = thiskey + thisvalue + '<br />';
  //content = content+thiscnt;

 
});
 
 
 	 if(ps!=checkps) { 
		$('.errorps').show();
	  	errorhint = true;
	  	 }  else  $('.errorps').hide();
 	 
  
 if(errorhint)  return;
  
 //-----------------------
        jQuery.ajax({
            type: 'POST',
            url: ajaxformurl,
            dataType : "json",
            data: {nickname : nickname,email : email,telephone : telephone,ps : ps,tokenhour: tokenhour},
            success: function(data){

		        if(data.id=='norepeat') {
		          $.fancybox.open('<div style="text-align:center;color:red;padding:50px;font-size:14px">不要重复注册</div>'); 
		         }
		        if(data.id=='repeat_nickname') {
		          $.fancybox.open('<div style="text-align:center;color:red;padding:50px;font-size:14px">昵称已存在</div>'); 
		         }
		         if(data.id=='repeat_email') {
		          $.fancybox.open('<div style="text-align:center;color:red;padding:50px;font-size:14px">Email已存在</div>'); 
		         }
		         if(data.id=='repeat_telephone') {
		          $.fancybox.open('<div style="text-align:center;color:red;padding:50px;font-size:14px">手机已存在</div>'); 
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

