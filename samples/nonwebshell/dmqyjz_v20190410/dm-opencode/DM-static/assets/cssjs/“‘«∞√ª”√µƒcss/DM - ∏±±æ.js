//技术支持 DM建站系统 www.demososo.com

$(function(){

	//console.log($(document).scrollTop());

dmfull_height();
dmnodetab();
ordernowclick();
makeimg100();
counter();
jstabclick();

 //alert($(document).width());

if($('body').width()>800)  {
	superfish();

	sidermenutop();
	}
else{
	dmmobjs();
 $(".jsnavbutton").click(function () {
				$(".jsnavbutton").toggleClass("opennavmenu");
				if($(".menu").hasClass('show'))  $(".menu").hide().removeClass('show');
				else $(".menu").show().addClass('show');
			});
	//--------
	 $('.menu').height(0);
	//-----
}

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
	 popcookie = getCookie('popcookie');
	 if(!popcookie){
	 	  $.fancybox.open({
				src  : '#homenoticedesp',
			})
		}
	setCookie('popcookie',true);
}



onlineqq();

 dmedit();
 tabs_js();

 headermobsearch();
 clicknextshow();
//change video width and height
$('.videodesp iframe,.videodesp embed').attr('style','');
 $('.videodesp iframe,.videodesp embed').attr('width','100%').attr('height','100%');

 //--------end ready---

});
//-----------------------------


 function clicknextshow(){
	 $('.clicknextshow').click(function(event) {
		 $(this).next().toggle();//slideToggle
	});
}

 function headermobsearch(){
	 	$('.headermobsearch').click(function(){
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
	$(".needmenumob").find("li ul.sub").each(function() {
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
//-------------
function sidermenutop(){
     if($('.sidermenutop').length>0){
	    //$('.sidermenutop .subcatemenu').hide();
		//------------------

		 $('.sidermenutop .maincatemenu').hover(function(){
				$(this).find('.subcatemenu').show();
			},function(){
				//$(this).find('.subcatemenu').hide();
		});



		//------------------
	 }

}

//-------------


 //JS操作cookies方法!
//写cookies
function setCookie(name,value)
{
	var Days = 1;
	var exp = new Date();
	exp.setTime(exp.getTime() + Days*24*60*60*1000);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}

function getCookie(name)
{
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
	return unescape(arr[2]);
	else
	return null;
}
function delCookie(name)
{
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval=getCookie(name);
	if(cval!=null)
	document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}

/*----------scrollscroll-------------------------------*/
$(window).scroll(function(){
  //var scrolldistance = $(document).scrollTop();
    if ($('.stickyPcMobi').length) {stickyfunc('.stickyPcMobi');	}
	if($('body').width()>800)  {
		if ($('.stickyPc').length) {stickyfunc('.stickyPc');	}
	}
	else{
		if ($('.stickyMobi').length) {stickyfunc('.stickyMobi');	}
	}


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

function jstabclick(){

	 if($('body').width()<800)  {
	 		 $('.jstabclick').click(function(){
			     	$('.jstabclick').removeClass('active');
			     	$(this).addClass('active');
			     	var datav = $(this).data('tab');
			     	var indexv = $(this).index();

			     	  $('.'+datav+'>div').hide().eq(indexv).show();
			     	  return false;
			     	 
			     	//alert(indexv);
			     });

	 }
else {

     $('.jstabclick').hover(function(){
     	$('.jstabclick').removeClass('active');
     	$(this).addClass('active');
     	var datav = $(this).data('tab');
     	var indexv = $(this).index();

     	  $('.'+datav+'>div').hide().eq(indexv).show();
     	 
     	//alert(indexv);
     },function(){

     });

  }

}
 

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


/*begin form js*/
function form_ajax(formtitle,ajaxformurl,ajaxsendemailurl,nodepidname,formpidname,formSumbitHave,formSumbitOk,formSumbitRepeat){
  $('.formblock .error').hide();

     $('.formblock .submitloading').show();
     var tokenhour = jQuery('.contactpostnonce').data('tokenhour');
     var content = '表单标题：'+formtitle+'<br />';
	 var thisvalue = '';
	 var  errorhint = false;

	$('.formblock .jsline').each(function(){
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

if(errorhint)  return;

//var content = '昵称：'+$('.homeliuyan .inp_name').val()+'<br />电子邮箱：'+$('.homeliuyan .inp_email').val()+'<br />手机：'+$('.homeliuyan .inp_phone').val()+'<br />内容：'+$('.homeliuyan .inp_content').val();
       jQuery.ajax({
            type: 'POST',
            url: ajaxformurl,
            dataType : "json",
            data: {content : content,nodepidname : nodepidname,tokenhour: tokenhour,pid: formpidname},
            success: function(data){

        if(data.id=='norepeat') {
          $.fancybox.open('<div style="text-align:center;color:red;padding:50px;font-size:14px">'+formSumbitRepeat+'</div>');

          $('.formblock .submit').val(formSumbitHave).unbind().css('cursor','default');


         }
       if(data.id=='yes'){ fromajax_success(formSumbitHave,formSumbitOk);
              dmsendemail(content);
         }
        $('.formblock .submitloading').hide();
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



function fromajax_success(){ 
$.fancybox.open('<div style="text-align:center;padding:50px;font-size:14px">'+formSumbitOk+'</div>');
//------------
$('.formblock .submit').val(formSumbitHave).unbind().css('cursor','default');
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
