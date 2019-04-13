//技术支持 DM建站系统 www.demososo.com

$(function(){
 
 dmaddcart();
 ordernowclick();


if($('body').width()>1024)  {
	 
	}
else{
	
} 





//--------
});


function ordernowclick(){
	var hash = window.location.hash;
	if(hash == '#ordernow')  ordernowFUNC();

	$('.ordernowclick').click(function(){

		 ordernowFUNC();
	});
}


function ordernowFUNC(){
		 var topv=$('.ordertab').offset().top-100;
		 jQuery('body,html').animate({
                scrollTop: topv
            }, 500);
		 $('.nodetabhd span').removeClass('cur');
		$('.nodetabhd span.ordertab').addClass('cur');

		$('.nodetab .nodetabcntinc').hide();
		$('.nodetab .ordernowcnt').show();

}


//-----------------------------
function dmaddcart(){
	if($('.dmaddcart').length){
		$('.dmaddcart').click(function(){
			 var nodepidname = $('.dmaddcart').data('proid');
			 var pronum = $('.dmcartpronum').val();
			 
			 
				alert(nodepidname);
				var ajaxformurl =$('.dmaddcart').data('href');
				var failtext =  '加入购物车失败。';
				  jQuery.ajax({
				type: 'POST',
				url: ajaxformurl,
				dataType : "json",
				data: {pidpro : nodepidname,pronum:pronum},
				success: function(data){
					if(data.id=='fail') {
					  $.fancybox.open('<div style="text-align:center;color:red;padding:50px;font-size:14px">'+failtext+'</div>'); 
					 }
				   if(data.id=='yes'){ 
				           alert('ok');
							// window.location.href='member-info.html';						  
					 }					
				  }
			}); //end ajax
		
		});
		 
	}
	 
	
	
}



 