(function(document, window, $) {
      'use strict';
      
    	  $("input").iCheck({checkboxClass:"icheckbox_flat-grey",radioClass:"iradio_flat-grey"});
	   $("#menu").on("click",function(){
		   $(this).toggleClass("navbar-menubar-opne");
		   $("html").toggleClass("html-hidden")
		   })
	   var skinnum = 0; 
	   $(".page-skin-btn").on("click", function(){
		   if(skinnum == 4){
			$(".page-header").removeClass("page-skin-"+skinnum);
			skinnum = 0; 
			   }else{
			var nextnum = skinnum + 1;
			$(".page-header").removeClass("page-skin-"+skinnum).addClass("page-skin-"+nextnum);
			skinnum ++ ;
			   }
			});
	   

		
	   
    })(document, window, jQuery);


//限制运费只能数字
function IsSubmit(e) {
    if(e.length > 0){
    	var $emal_val = $("input[name='email']").val();
    	var $price_val = $("input[name='price']").val();
    	var $freight_val = $("input[name='freight']").val();
    	var emalReg=/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
    	var numReg= /^\+?[1-9][0-9]*$/;
    	var i = 0, messages ="";
    	 if(emalReg.test($emal_val)){
    		i+=1;
    	 }else{
    		 messages ="您邮箱格式不正确，请输入正确的邮箱"
    	 }
    	 if(numReg.test($price_val)){
    		 i+=1;
    	 }else{
    		 messages ="货物价值只能输入数字";
    	 }
    	 if(numReg.test($freight_val)){
    		 i+=1;
    	 }else{
    		 messages ="运费只能输入数字";
    	 }
    	 if(i ==3 ){
    		 return true;
    	 }else{
    		// shake($("#error"), messages);
    		 setTimeout(function(){
 	              $("#error").removeClass("hidden").text(messages);
 	    	  },200); 
    	 }
    //	 return  (i == 3) || false
    }else{
    	
    	return true;
    }
	
} 

//错误提示动画
 function shake(selector, message){
	 if(selector.hasClass("hidden")){
		 selector.removeClass("hidden").text(message);
	 }else{
		 
	var length = 6;
	selector.css('position', 'relative').text(message);
    for (var i = 1; i <= length; i++)
    {
    	if (i % 2 == 0)
    	{
        	if (i == length)
        	{
        		selector.animate({ 'left': 0 }, 50);
        	}
        	else
        	{
        		selector.animate({ 'left': 10 }, 50);
        	}
    	}
    	else
    	{
    		selector.animate({ 'left': -10 }, 50);
    		//alert("2");
    	}
    }
    
	 }
}
