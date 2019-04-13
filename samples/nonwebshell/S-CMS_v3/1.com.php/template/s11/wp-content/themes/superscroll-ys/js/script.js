$(document).ready(function(){  

 $(".main").children(".page").css("height",$(window).height());
$('#nav .menu_nav li').not(".sub-menu li").append('<div class="hover"><\/div>');
$('#nav .menu_nav li .sub-menu li').children("ul").addClass("block")
$('#nav .menu_nav li').hover(
function() {
$(this).children(".sub-menu").not(".block").stop(true, true).fadeIn('200');},
function() {
$(this).children(".sub-menu").not(".block").stop(true, true).fadeOut('1000');
	}
)
$('#nav .menu_nav li').not(".current-menu-item,.current-menu-ancestor,.current-category-ancestor").hover(
function() {
$(this).children('.hover').stop(true, true).fadeIn('200');
},
function() {
$(this).children('.hover').stop(true, true).fadeOut('1000');

});
	$("#pic,#enter_xz").stop().mouseenter(function() {$(this).children("a.prve").animate({"left":"0"},600,'easeOutElastic');});
    $("#pic,#enter_xz").stop().mouseleave(function(){$(this).children("a.prve").animate({"left":"-100px"},600);});
	$("#pic,#enter_xz").stop().mouseenter(function() {$(this).children("a.next").animate({"right":"0"},600,'easeOutElastic');});
    $("#pic,#enter_xz").stop().mouseleave(function(){$(this).children("a.next").animate({"right":"-100px"},600);});
	$(".news_loop_01 li#fist .news_001_pic").mouseenter(function() {$(this).children("img").animate({"width":"150px","height":"150px","left":"-10px","top":"-10px"},400);});
    $(".news_loop_01 li#fist .news_001_pic").mouseleave(function(){$(this).children("img").animate({"width":"130px","height":"130px","left":"0","top":"0"},400);});
    $("#cat_news ul li#smoll a,#cat_news ul li.firest a").mouseenter(function() {$(this).children("img").animate({"width":"111px","height":"111px","left":"-10px","top":"-10px"},400);});
    $("#cat_news ul li#smoll a,#cat_news ul li.firest a").mouseleave(function(){$(this).children("img").animate({"width":"91px","height":"91px","left":"0","top":"0"},400);});
    $(".news_loop_01 li#ohter .news_001_pic").mouseenter(function() {$(this).children("img").animate({"width":"108px","height":"108px","left":"-10px","top":"-10px"},400);});
    $(".news_loop_01 li#ohter .news_001_pic").mouseleave(function(){$(this).children("img").animate({"width":"88px","height":"88px","left":"0","top":"0"},400);});

	$(".gonggao .steti").stop().mouseenter(function() {$(this).animate({"height":"250px","bottom":"100px"},200,'easeOutQuad');});
    $(".gonggao .steti").stop().mouseleave(function(){$(this).animate({"height":"150px","bottom":"0"},200,'easeOutQuad');});
	$(".gonggao .steti").stop().mouseenter(function() {$(this).animate({"height":"250px","bottom":"100px"},200,'easeOutQuad');});
    $(".gonggao .steti").stop().mouseleave(function(){$(this).animate({"height":"150px","bottom":"0"},200,'easeOutQuad');});
	$("#content .case_pic ul li a").mouseenter(function() {$(this).children("div").animate({"top":"0px"},400);});
    $("#content .case_pic ul li a").mouseleave(function(){$(this).children("div").animate({"top":"190"},400);});

	$(".sercive_ul li ").stop().mouseenter(function() {$(this).children("div").children("span").animate({"top":"0"},600,'easeInOutBack');});
    $(".sercive_ul li").stop().mouseleave(function(){$(this).children("div").children("span").animate({"top":"190px"},600,'easeInOutBack');});
	
    $(".vedio ").click(function() {$(this).next(".play").fadeIn(500)});
	$(".closed ").click(function() {$(this).parent(".play").fadeOut(500)});
   

$(".lsit_hover ul.list-h li a").stop().mouseover(function() {     

$(".product_pic img").attr("src",$(this).attr("rel"));
if($(".product_pic img").load){$(".product_pic .loading").fadeOut(); }else{$(".product_pic .loading").fadeIn();}

if($(this).attr("rel") ==  $(".product_pic img").attr("src")){
	$(".lsit_hover ul.list-h li").removeClass("bodee");
	$(this).parent("li").addClass("bodee");
	}

});

var sumWidth =0;
$(".lsit_hover").children("ul").each(function(){
         $(this).css("width", 194*$(this).children("li").length+"px");
});


$(".list .next").click(function() {
	
if($(".lsit_hover").children("ul").width() >=582){
	$(this).prev(".lsit_hover").children("ul").animate({"margin-left":"-582px"},600,'easeInOutQuint')
}
});
	$(".list .prve").click(function() {
		
if($(".lsit_hover").children("ul").width() >=582){
	$(this).next(".lsit_hover").children("ul").animate({"margin-left":0},600,'easeInOutQuint')
}
	});


$.fn.scrolld=function () {
var href = $(this).attr("rel");
var gotopos = $(href).offset().top;
$("html,body").animate({scrollTop:gotopos},1000,'easeInQuart');
return false;
};
$(".nav_bottom_in").children("b").append('<div class="hover"><\/div>');
$(".nav_bottom_in").children("b").not(".hereis").mouseenter(function() {$(this).children(".hover").animate({"top":"5px"},200,'easeInOutBack');});
$(".nav_bottom_in").children("b").not(".hereis").mouseleave(function() {$(this).children(".hover").animate({"top":"-10px"},200,'easeInOutBack');});

/* sercive */
$.extend({sercive_work:function(){
	$.fn.gotobig=function () { 
	$(this).animate({"width":"190px","height":"190px","left":"0px","top":"0px"},600);	
	}

	
     var Timer = 800;
     $(".sercive_title_out").delay(800).animate({"top":"539px"},1500,'easeInOutBack');
	 $(".nav_bottom_in").children("b").removeClass("hereis");
	 $("#Service").addClass("hereis");
	 $(".sercive_hold").delay(2800).hide(0);
    $(".sercive_ul li div").each(function() {
	    Timer+=200;
        $(this).delay(Timer).gotobig();
		if(Timer >=2800){return false;};
});
   
      }});

$.extend({sercive_close:function(){	
	$(".sercive_title_out").animate({"top":"1106px"},800,"easeInOutBack");
    $(".sercive_ul li").children("div").animate({"width":"0","height":"0","left":"159.5px","top":"95px"});
	 $(".sercive_hold").delay(2800).show(0);
	}});
/* sercive */

/* about */

$.extend({about_work:function(){
		$.fn.rigtgo=function () { 	
	$(this).animate({"left":"20px",opacity:1},1000,'easeInOutBack');	
	}
	  var Timer = 0;
	   $(".nav_bottom_in").children("b").removeClass("hereis");
	 $("#about").addClass("hereis");
    $(".about").animate({"top":"30%"},2000,'easeInOutBack');
	$(".about_in b").delay(Timer+1500).rigtgo();
	$(".about_in em").delay(Timer+1900).rigtgo();
	$(".about_in p").delay(Timer+2300).rigtgo();
	$(".about_in a").delay(Timer+2700).rigtgo();
	$(".about_in .vedio").delay(Timer+3100).animate({"top":"-40px",opacity:1},1000,'easeInOutBack');
	$(".about_in .shadow_1").delay(Timer+3500).animate({"top":"100px",opacity:1},1000,'easeInOutBack');
	}});
$.extend({about_close:function(){
		$.fn.rigtgo=function () { 
	$(this).animate({"left":"-20px",opacity:0},1000,'easeOutElastic');	
	}
	$(".about_in b").rigtgo();
	$(".about_in em").rigtgo();
	$(".about_in p").rigtgo();
	$(".about_in a").rigtgo();
	$(".about_in .vedio").animate({"top":"140px",opacity:0},600,'easeOutQuart');
	$(".about_in .shadow_1").animate({"top":"-100px",opacity:0},1000,'easeOutQuart');
     $(".about").animate({"top":"140%"},1000,'easeInOutBack');
	}});
/* about */

/* case */
$.extend({case_work:function(){
	 var Timer = 0;
	  $(".nav_bottom_in").children("b").removeClass("hereis");
	 $("#case").addClass("hereis");
     $(".case_title").delay(Timer+500).animate({"top":"100px"},1000,'easeInOutBack');
     $(".loop_big_caj_nav").delay(Timer+500).animate({"top":"500px"},1000,'easeInOutBack');
	}});
$.extend({case_close:function(){
	$(".case_title").animate({"top":"-400px"},600,'easeInOutBack');

    $(".loop_big_caj_nav").animate({"top":"-99px"},1000,'easeInOutBack');

	}});
	
/* case */
/* news */
$.extend({news_work:function(){
	
	$.fn.gotoleft=function () { $(this).animate({"margin-left":"0px"},1000,'easeInOutBack');	};
    $.fn.gotoright=function () { $(this).animate({"margin-left":"0px"},1000,'easeInOutBack');	};

     var Timer = 500;
   $(".nav_bottom_in").children("b").removeClass("hereis");
	 $("#news").addClass("hereis");
    $(".news_left ul li div").each(function() {
	    Timer+=200;
        $(this).delay(Timer).gotoleft();
		if(Timer >=2000){return false;};
	
});

$(".news_right ul li div").each(function() {
	    Timer+=200;
        $(this).delay(Timer).gotoright();
		if(Timer >=2000){return false;};
	
});
   
      }});

$.extend({news_close:function(){
	
	 $(".news_left ul li").children("div").animate({"margin-left":"-650px"},600,'easeInOutBack');
	 $(".news_right ul li").children("div").animate({"margin-left":"320px"},600,'easeInOutBack');

	}});

/* news */
/* band */
$.extend({band_work:function(){
	  Timer=800;
	   $(".nav_bottom_in").children("b").removeClass("hereis");
	 $("#band").addClass("hereis");
	$(".band").delay(Timer).animate({"top":"25%"},1000,'easeInOutBack');	

      }});

$.extend({band_close:function(){
	
	$(".band").animate({"top":"-40%"},1000,'easeInOutBack');	

	

	}});

/* band */



/* contact*/
$.extend({contact_work:function(){
	  Timer=800;
	   $(".nav_bottom_in").children("b").removeClass("hereis");
	 $("#contact").addClass("hereis");
	$(".contact_left").delay(Timer).animate({"margin-left":"0px"},600,'easeOutQuad');
	$(".contact_right").delay(Timer).animate({"margin-right":"0px"},600,'easeOutQuad');

      }});

$.extend({contact_close:function(){
	
	$(".contact_left").delay(Timer).animate({"margin-left":"-580px"},600,'easeOutQuad');
	$(".contact_right").delay(Timer).animate({"margin-right":"-368px"},600,'easeOutQuad');

	

	}});

/* contact*/



});