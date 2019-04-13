//技术支持 DM建站系统 www.demososo.com

$(function(){

	//console.log($(document).scrollTop());

dmfull_height();
dmnodetab();

makeimg100();
counter();
jstabhover();
backtotop();
menusimple();

 //alert($(document).width());

if($('body').width()>1024)  {
	superfish(); 
	 dmedit();
	}
else{
	dmmobjs();
 $(".dmmenumobi").click(function () {
				$(".dmmenumobi").toggleClass("opennavmenu");
				if($(".menu").hasClass('show'))  $(".menu").hide().removeClass('show');
				else $(".menu").show().addClass('show');
			});
	//--------
	 $('.menu').height(0);
	//-----
}

$('.topsearchbox button').click(function(){
	//var v = $(this).closest('.topsearchbox').find('input').attr('placeholder');
	var errorv = $(this).closest('.topsearchbox').find('input').data('error');
	var val = $(this).closest('.topsearchbox').find('input').val();
	val = $.trim(val);
	//if(val==v || val=='') {
    if(val=='') {
		alert(errorv);
		return false;
	}
	 
	
});
$('.detailfontsize a').click(function(){
			var indexv = $(this).index();

			if(indexv==0){
				 var sizev = $('.detailfontsize').data('size');
				 if(sizev>12) sizev = sizev - 4 ;
			}
			else{
				 var sizev = $('.detailfontsize').data('size');
				if(sizev<36)  sizev = sizev + 4 ;
			}

			$('.detailfontsize').data('size',sizev);
			 if(sizev<20) lhv = '25px' ;
	 		  else lhv = '50px';
		  $('.content_desp p,.content_desp').css({'font-size':sizev,'line-height':lhv});
		// $('.content_desp p,.content_desp').css({'font-size':sizev});
		// if(sizev>20) $('.content_desp p,.content_desp').css({'line-height':lhv});

	});

/*-----newstab toggledesp----------*/
$(".toggledesp .despjj").eq(0).show();
  $(".toggledesp li").hover(function(){
        $(this).siblings().find(".despjj").hide();
         $(this).find(".despjj").show();
        },function(){

        });
//-----------------



if($('.homenoticejs .cnt').length>0){
	 popcookie = dmgetCookie('popcookie');
	 if(!popcookie){
	 	  $.fancybox.open({
				src  : '#homenoticedesp',
			})
		}
	dmsetCookie('popcookie',true);
}



onlineqq();


 tabs_js();

 headersearchrg();
 clicknextshow();
//change video width and height
$('.videodesp iframe,.videodesp embed').attr('style','');
 $('.videodesp iframe,.videodesp embed').attr('width','100%').attr('height','100%');

 //--------end ready---

});



 function menusimple(){
	   if($('.menusimple').length>0)	{
		   
		   
		   $('.menusimpletoggle').click(function(){
			   if($(this).hasClass('on')) {
				   $(this).removeClass('on'); $('.menusimpletext').hide();
			   }
			   else {
				   $(this).addClass('on');$('.menusimpletext').show();
			   }
		   });		  
	   }	     	 
}




 function clicknextshow(){
	 $('.clicknextshow').click(function(event) {
		 $(this).next().toggle();//slideToggle
	});
}


 function headersearchrg(){	  
	 	$('.headersearchrg').click(function(){
	 		 $(".topsearchbox").slideToggle();
	 	});
 	}

 function dmedit(){
	$('.block').hover(function(){
	        $(this).find('.dmedit').show();
		},function(){
		      $(this).find('.dmedit').hide();
		});
	$('.regionbox').hover(function(){
	        $(this).find('.dmeditregion').show();
		},function(){
		      $(this).find('.dmeditregion').hide();
		});

	$('.contentwrap,.pageregionwrap').hover(function(){
	        $(this).find('.dmeditnode').show();
		},function(){
		      $(this).find('.dmeditnode').hide();
		});



 }

 function makeimg100(){  //cancel ...
 	var cntwidth =$('body').width()-10;
 	//alert(cntwidth);
	// $('.content_desp img,.albumupdown img,.caseright img,.perimgwrap img').each(function(){

   $('body img').each(function(){
	  // console.log(cntwidth);

	 	   if($(this).width()>cntwidth) {
	 	     	$(this).attr('style','');
				$(this).addClass('perimgmax100');

	 	   			//$(this).attr('max-width','98%');
	 	   			//alert(cntwidth);
	 	   		}

	 });

}




/*-counter--*/
 function counter(){
   if($('.counteritem').length>0)	{	
			 $('.counteritem i').counterUp({
				delay: 10,
				time: 1000
			});
		}	
	}	

//-----------------------------
function superfish(){
	jQuery('.needsuperfish ul.m').superfish({
				//useClick: true
			});

}
//-----------------
function dmmobjs(){
	$(".menu").find("li ul.sub").each(function() {
			$(this).parent().prepend('<span class="sub-nav-toggle plus"></span>')
		});
	$('.sub-nav-toggle').click(function(){
	      $(this).toggleClass("plus");
		  //if($(this).siblings("ul.sub").hasClass('show'))  $(this).siblings("ul.sub").removeClass('show');
		 // else $(this).siblings("ul.sub").addClass('show');
		// $(this).siblings("ul.sub").toggleClass('show');
		 if($(this).siblings("ul.sub").css("display") == "none")  {$(this).siblings("ul.sub").slideDown(500);}
		  else $(this).siblings("ul.sub").slideUp(500);
	});

//------------
}
//-----------------------------
function onlineqq(){
	$('.onlineopen').click(function(){
			 $(this).hide();
				 $('.onlinecontent').show(); $('.onlineclose').show();
	});
	$('.onlineclose').click(function(){
			 $(this).hide();
				 $('.onlinecontent').hide(); $('.onlineopen').show();
	});

	 $('.sitecolorchange .onlineclosecolor').click(function(){
			$('.sitecolorchange').hide();
	});


}


function tabs_js(){
      $('.tabs_js .tabs_header li').click(function(){
		var curVal = $(this).index();
		if(!$(this).hasClass('active')){
		//	$('.tabs_js .tabs_header li').removeClass('active');
			$(this).closest(".tabs_header").find('li').removeClass('active');

			$(this).addClass('active');

			$(this).closest(".tabs_js").find('.tabs_content').hide();
			$(this).closest(".tabs_js").find('.tabs_content').eq(curVal).fadeIn();
			//$('.tabs_js .tabs_content').hide();
		//	$('.tabs_js .tabs_content').eq(curVal).fadeIn();
			return false;
		}

	});

}
 

//----------------------
function backtotop(){
	if($('#backtotop').length){
        jQuery('#backtotop a').click(function () {
            jQuery('body,html').animate({
                scrollTop: 0
            }, 500);
            return false;
        });
	}		
}	
/*----------scrollscroll-------------------------------*/
$(window).scroll(function(){
  //var scrolldistance = $(document).scrollTop();
    if ($('.stickytop').length) { stickyfunc('.stickytop');	}
	//-----
	if ($(this).scrollTop() > 150) {
                $('#backtotop').fadeIn();
            } else {
                $('#backtotop').fadeOut();
            }
   //-------------

 });


 function stickyfunc(v){
  var strickyScrollPos = 25;
   var strickyScrollPos2 = 100;
 if($('body').width()>800) {
 	var strickyScrollPos = 50;
 	var strickyScrollPos2 = 300;
 }

			if($(window).scrollTop() > strickyScrollPos2) {  //avoid pingfan scroll
				//$(v).removeClass('fadeIn animated');
				$(v).addClass('stricky-fixed');
				//$(v).css{'position','absolute'}
			}
			else if($(this).scrollTop() <= strickyScrollPos) {
				$(v).removeClass('stricky-fixed');
				//$(v).addClass('slideIn animated');
			}
 }

function dmfull_height(){
	 var windowhg = $(window).height();//window.innerHeight;

	 $('.dmfull_height').css('height', windowhg);

			$('.dmfull_height li').css('height', windowhg);

			 $(window).resize(function(){
				$('.dmfull_height li').css('height', windowhg);
			 });

}

function dmnodetab(){
	$('.nodetabhd span').click(function(){
		var index= $(this).index();
		$('.nodetabhd span').removeClass('cur');
		$('.nodetabhd span').eq(index).addClass('cur');

		$('.nodetab .nodetabcntinc').hide();
		$('.nodetab .nodetabcntinc').eq(index).show();

	});
}

function jstabhover(){
 
     $('.jstabhoverwrap .jstabhover').hover(function(){
		 var indexv = $(this).index();
		 console.log(indexv);
		  $(this).closest('.jstabhoverwrap').find('.jstabhover').removeClass('active').eq(indexv).addClass('active');
		 $(this).closest('.jstabhoverwrap').find('.jstabhovercnt').hide().eq(indexv).show();
     },function(){
		 
     });
 

} 


/*begin form js*/
function dmformvalid(parentv){
	
  //$('.formblock .error').hide();

   
   parentv.find('.error').hide();   
   
    var content = '';
	 var thisvalue = '';
	 var  errorhint = false;

	//$('.formblock .jsline').each(function(){
		 parentv.find('.jsline').each(function(){
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

			  var thiscnt = thiskey + thisvalue + '<br />';
			  content = content+thiscnt;




});
//alert(errorhint);
if(errorhint) return false;
  return content;
 

}



function dmformajax(parentv,contentv,formdatajson){

  parentv.find('.submitloading').show();  
  
  formSumbitHave = formdatajson.formSumbitHave;
  formSumbitOk = formdatajson.formSumbitOk;
  formSumbitRepeat = formdatajson.formSumbitRepeat;
  
   contentv = '表单标题：'+formdatajson.formtitle+'<br />'+contentv;
  //return false;
        //var content = '昵称：'+$('.homeliuyan .inp_name').val()+'<br />电子邮箱：'+$('.homeliuyan .inp_email').val()+'<br />手机：'+$('.homeliuyan .inp_phone').val()+'<br />内容：'+$('.homeliuyan .inp_content').val();
       jQuery.ajax({
            type: 'POST',
            url: formdatajson.ajaxformurl,
            dataType : "json",
            data: {content : contentv,nodepidname : formdatajson.nodepidname,tokenhour: formdatajson.tokenhour,pid: formdatajson.formpidname},
            success: function(data){

        if(data.id=='norepeat') {
          $.fancybox.open('<div style="text-align:center;color:red;padding:50px;font-size:14px">'+formSumbitRepeat+'</div>');

          parentv.find('.submit').val(formSumbitHave).unbind().css('cursor','default');


         }
       if(data.id=='yes'){ fromajax_success(parentv,formSumbitHave,formSumbitOk);
              dmsendemail(contentv,formdatajson.ajaxsendemailurl);
         }
          parentv.find('.submitloading').hide();
      }
        });
 

  }


function dmsendemail(contentv,ajaxsendemailurl){
         jQuery.ajax({
            type: 'POST',
            url: ajaxsendemailurl,
            dataType : "json",
            data: {content : contentv},
            success: function(data){
                }
        });
  }



function fromajax_success(parentv,formSumbitHave,formSumbitOk){ 
$.fancybox.open('<div style="text-align:center;padding:50px;font-size:14px">'+formSumbitOk+'</div>');
//------------
parentv.find('.submit').val(formSumbitHave).unbind().css('cursor','default');
//-------------
}


function checkphone(v){
    var mobilePattern = /^(1[3568][0-9]{1})(-)?([0-9]{8})$/;
    return mobilePattern.test(v);
}
function checkemail(v){
    var emailPattern = /^([.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
    return emailPattern.test(v);
}
function checknumber(v){
    var  Pattern = /^[0-9]+.?[0-9]*/;
    return Pattern.test(v);
}

/*end form js*/

//-----begin cookie-----------
function dmsetCookie(name,value)
{
	var Days = 1;
	var exp = new Date();
	exp.setTime(exp.getTime() + Days*24*60*60*1000);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}

function dmgetCookie(name)
{
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
	return unescape(arr[2]);
	else
	return null;
}
function dmdelCookie(name)
{
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval=dmgetCookie(name);
	if(cval!=null)
	document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
//---------end cookie----
