//add..............
$(document).ready(function(){
   
   if($('body').width()>800)  {
	   
  xiala_show(); 
  
   }
   else {
	    xiala_showmobile(); 
		
   }
   
	 
	 treearr_select();  
	 treearr_catelist();
	 treenodeeditcate();
	  
	 jscopytoalias();
//---------end ready----------------------------------------
}); //end ready


function xiala_show(){
$(".navblock").hover(
	  function () {  
		//$(".navlang ul").addClass("hover");
		$(this).children(".xialabox").show();
	  },
	  function () {
		//$(".navlang ul")removeClass("hover");
		$(this).children(".xialabox").hide();
	  }
	);
//
}//end func


function xiala_showmobile(){
	
$(".navdm_mob .navbar-toggle").click(function(){
  $(".navdm").slideToggle();
});

 
}//end func

function treearr_catelist(){
	
 $('.treearr_catelist div').hover(function(){ $(this).addClass('active');},function(){$(this).removeClass('active');});
 
 
}//end func



function treearr_select(){
	
$(".jstreearr_select span").click(function(){ 


//------------------- 
        var idv = $(this).attr('id');
		canclickname = true;
		//------hasmulticate---cureditparent--------- 
		if($('.hasmulticate').length){
				if($('.cureditparent').length){
				$('.cureditparent  span').each(function(){
					if($(this).attr('id')==idv)  {
						alert('出错，不能选择 当前级 或 子级 为 父级。');
						canclickname = false;
						return false;	
 						
					}
				  }); 
				}
		}		
		//---------------nomulticate-----
		if($('.nomulticate').length){			
			if($('.activecur').next().hasClass('tree')){
				alert('出错，当前级 还有子级，请先移走它的子级。');
				canclickname = false;
				return false;
			}
			if($(this).hasClass('level_2')) {
				alert('因为这是最后一级，所以不能选择它为父级。');
				canclickname = false;
				return false;
			}
		}
		//-----------------
		//alert(idv);
		//alert(canclickname);
	 if(canclickname){
		  $('.mysubmit').show();
		var namev = $(this).text();
		$('.treearr_select_input').val(idv);
		$('.treearr_select_input_catename span').text(namev);
	 }else { 
	    $('.mysubmit').hide();
	 }
	 
		 
});
//--------
$(".treearr_select_go").click(function(){  
         $(".treearr_select").slideToggle();
});
 
 
}//end func

//----------- 

function treenodeeditcate(){	
 
$(".treenodeeditcate input").click(function(){ 
   var parid =  $(this).data('parid');
   // console.log(parid);
   v = false; 
 $(this).parent().parent().siblings().find('input').each(function(){ 
		 if($(this).is(':checked')) v = true;		 
				 
	});
	 
	 
   if(!v) {
	     if($(this).is(':checked'))  treenodeeditcate2(parid,true);
		 else   treenodeeditcate2(parid,false); 
   }
});
     
 
 
}//end func

 


function treenodeeditcate2(curid,beal){ 
         
	 $(".treenodeeditcate input").each(function(){	
         	 
		 if($(this).val() == curid) {   //console.log(curid);
			  $(this).prop("checked", beal); 
				var parid =  $(this).data('parid');
				 treenodeeditcate2(parid,beal);
				
		 } 	
	});

 
}//end func

function jscopytoalias(){ 
	$('.jscopytoalias').click(function(){
		v = $('.copytoaliasfrom').text(); 
		$('.copytoaliasto').val(v);
	});
}//end func

