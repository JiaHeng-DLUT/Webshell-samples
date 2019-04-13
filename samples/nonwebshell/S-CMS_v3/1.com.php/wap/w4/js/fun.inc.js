/*宽度调整*/
function widthtz(){
	if(document.documentElement.clientWidth>800){
		$(".metcont").width(340);
	}
	$(".footerbox").width($(".metcont").width());
	$(".footerboxnav").width($(".metcont").width());
	$(".footerlist").width($(".metcont").width());
}
widthtz();
$(window).on('resize', function(e) {
	widthtz();
});
//等高
function metHeight(group){
	tallest=0;
	group.each(function(){
		thisHeight=$(this).height();
		if(thisHeight>tallest){
			tallest=thisHeight;
		}
	});
	group.height(tallest);
}
//图片延迟加载---------------------------------------------------------
function metmobile_imgloading(dom){
	dom.each(function(){
		var imgurl = $(this).attr('src');
		$(this).after("<div class=\"ui-imglazyload\" data-url='"+imgurl+"'></div>");
		$(this).remove();
	});
	$('.ui-imglazyload').imglazyload({
		container: $('.metcont')
	});
}
metmobile_imgloading($(".flexslider img,.sidebar img"));
$.fn.imglazyload.detect();
//over
//右上角功能----------------------------------------------------------
function topmorebox(tboxjq,dom){
	var dok = dom.css('display');
	$(".topmorebox").hide();
	$(".top-right li").removeClass('now');
	if(dok=='none'){
		dom.show();
		tboxjq.addClass('now');
	}
}
//首页搜索框
var indexW = $(".metcont").width() - 20,seachK = $(".index_seach .submit").width();
var seachTxT = indexW - seachK - 11;
$(".index_seach .text").width(seachTxT);

//站内搜索框
var swd = $('.seachbox').width() - 30 - ($('.seachbox input.submit').width() + 15);
$(".seachbox input.text").width(swd);
//搜索框宽度
function seachboxwd(){
	var swd = $('.seachbox_box').width() - 30 - ($('.seachbox input.submit').width() + 20);
	$(".seachbox input.text").width(swd);
	var ls = $(".top-right li.tlist").size();
	var wd = 11;
	if(ls==2)wd = 46 + 11;
	if(ls==3)wd = 46 + 46 + 11;
	$(".seachbox_box i").css("right",wd+'px');
}
$(window).on('resize', function(e) {
	seachboxwd();
});
//搜索
var ser = $(".top-right .seach");
if(ser.size()>0){
	var serdom = ser;
	serdom.click(function(){
		topmorebox(ser,$(".seachbox"));
		seachboxwd();
	});
}
//语言
var ler = $(".top-right .lang");
if(ler.size()>0){
	var lerdom = ler;
	lerdom.click(function(){
		topmorebox(ler,$(".langlist"));
	});
}
//栏目下拉菜单
var cer = $(".top-right .column");
if(cer.size()>0){
	cer.on('click',function(){
		topmorebox(cer,$(".type3"));
	});
}

//over
//图片轮播----------------------------------------------------------
if($('.iflash_slides li').size()>1){//首页Banner
	$('.iflash_slides').slider({loop:true,interval:4000});
	$(".iflash_slides .ui-imglazyload").css({ 'width':'100%','height':falsh_y+'px' });
}
if($('.flash_slides li').size()>1){//Banner
	$('.flash_slides').slider({loop:true,interval:4000,dots:false});
	$(".flash_slides .ui-imglazyload").css({ 'width':'100%','height':falsh_y+'px' });
}
if($('.imgtxtshow_slides1 li').size()>1){//首页产品展示图一
	$('.imgtxtshow_slides1').slider({loop:true,autoPlay:show1narrow,arrow:false,dots:true});
}
if($('.showproduct_slides li').size()>1){//产品详情页大图
	$('.showproduct_slides').slider({loop:true,interval:4000,dots:false});
	$(".showproduct_slides .ui-imglazyload").css({ 'width':'100%','height':promaximgY+'px' });
}
if($('.showimg_slides li').size()>1){//图片模块详情页大图
	$('.showimg_slides').slider({loop:true,interval:4000,dots:false});
	$(".showimg_slides .ui-imglazyload").css({ 'width':'100%','height':imgmaximgY+'px' });
}
//over
//内页分类导航面板----------------------------------------------------------
if($('#sidebar').size()>0){
	var myScroll2 = new iScroll('wrapper_sidebar'); 
}
$('.sidebar_jsbox').height($(window).height());
$(function ($) {
	if($('#sidebar').size()>0){
		$('#sidebar').panel({
			contentWrap: $('.sidebar_jsbox'),
			scrollMode: 'fix'
		});
		$('#sidebar').on('close',function(){
			$('#sidebar').hide();
			$('.sidebar_jsbox').hide();
		});
		$('.moresidebar').click(function () {
			$('.sidebar_jsbox').show();
			$('#sidebar').panel('toggle','overlay');
		});
		$('#sidebar h3.title').on('click', function () {
			$('#sidebar').panel('close');
		});
	}
}(Zepto));
//over
//加载更多----------------------------------------------------------
var flip = $("#flip");
if(flip.size()>0){
	var flipdom = flip[0];
	flip.on('click', function(e){
		var class1=flip.attr('class1');
		var class2=flip.attr('class2');
		var class3=flip.attr('class3');
		var page=parseInt(flip.attr('page'))+1;
		var pageall=parseInt(flip.attr('pageall'));
		var searchword=flip.attr('searchword');
		var wtype = flip.attr('wtype');
			wtype = wtype?wtype:'index';
		var urls = wtype+'.php?lang='+lang+'&ajaxlist=1&class1='+class1+'&class2='+class2+'&class3='+class3+'&page='+page;
	    if(wtype)urls+='&ktype='+wtype;
	    if(searchword)urls+='&searchword='+searchword;
		flip.html(fliptext2);
		$.ajax({
			url: urls,
			type: "GET",
			success: function(data) {
				$(".ajaxlist ul").append(data);
				metmobile_imgloading($(".ajaxlist .li_"+page+" img"));
				flip.attr('page',page);
				flip.html(fliptext1);
				if(page>=pageall)flip.remove();
				$.fn.imglazyload.detect();
			}
		});
	});
}
$("#navnow1_"+classnow).addClass("now");
//over
//内页选项卡----------------------------------------------------------
var tags = $(".Tabtitle div.l");
if(tags.size()>1){
	tags.each(function(i){
		tagsdom = tags[i];
		tags.eq(i).on('click', function(e){
			$(".mb_Tabbox").hide();
			tags.removeClass('now');
			$(".mb_Tabbox_"+i).show();
			$(this).addClass("now");
		});
	});
}
//over
//百度地图----------------------------------------------------------
var header_ok = $("header").data("value");		//判断头部开关
var footnum = $("#footnum").data("value");		//判断底部开关
headok = header_ok==1?"0":"46";
if(footnum==1){									//判断底部开关后是什么展示方式
	footHeight = foot_oks==1?"0":"45";
}else{
	footHeight=0;
}
if($('#allmap').size()>0){
$('#allmap').height($(window).height()-headok-footHeight);
}
$(window).on('resize', function(e) {
	if($('#allmap').size()>0)$('#allmap').height($(window).height()-headok-footHeight);
});
//over
//当前栏目----------------------------------------------------------
var csnow=$("#sidebar").attr('data-csnow'),class3=$("#sidebar").attr('data-class3');
var part2=$('#part2_'+csnow);
var part3=$('#part3_'+class3);
if(part2)part2.addClass('on');
if(part3)part3.addClass('on');
//over
//手机键盘弹出时底部导航隐藏----------------------------------------------------------
var wht = $(window).height();
var wdt = document.documentElement.clientWidth;
$(window).on('orientationchange', function(e) {
        _landscape2 = !!(window.orientation & 2);
}).on('resize', function(e) {
	if($(window).height()<wht&&document.documentElement.clientWidth==wdt){
		$("#footer").hide();
	}else{
		$("#footer").show();
	}
});
//over
//详情页表格横向滚动----------------------------------------------------------
var tables = $(".editor table");
if(tables.size()>0){
	tables.wrap('<div class="wrapper_table"><div class="scroller_table" style="overflow:scroll;"></div></div>');
}
//over

//tabs选项卡设置----------------------------------------------------------
    $(".tabs_ul li").first().addClass("tabs_now");
    $(".tabs_box>div").first().addClass("tabs_box1");
	$(".tabs_ul li").each(function(index){

	     $(this).on('click',function(){
			 $(this).addClass("tabs_now").siblings().removeClass("tabs_now");
		     $(".tabs_box>div").eq(index).addClass("tabs_box1").siblings().removeClass("tabs_box1");
	     });
		 
	});
	/*平均宽度*/
	var tabsSize = $('.section').data('value');
	if(tabsSize == 1){
	     $('.navnow>li').css('width','100%');
	}else if(tabsSize == 2){
	     $('.navnow>li').css('width','50%');
	}else if(tabsSize == 3){
	     $('.navnow>li').css('width','33.3%');
	}else{
	     $('.navnow>li').css('width','25%');
	}
	/*平均高度*/
	$(".tabs_box1 ul li").addClass("lidg");
	tallest=0;
    $(".lidg").each(function(){
		 thisHeight=$(this).height();
		    if(thisHeight>tallest){
			    tallest=thisHeight;
		    }
	});
	$(".lidg").height(tallest);



	
//over

//右下角弹出图标----------------------------------------------------------
        window.addEventListener("DOMContentLoaded", function () {
            btn = document.getElementById("info-nr-btn");
            btn.onclick = function () {
                var divs = document.getElementById("info-nr-phone").querySelectorAll("div");
                var className = className = this.checked ? "on" : "";
                for (i = 0; i < divs.length; i++) {
                    divs[i].className = className;
                }
                document.getElementById("jisou-info").style.display = "on" == className ? "block" : "none";
            }
        }, false);
        $(function () {
            new Swipe(document.getElementById('jisou-banner'), {
                speed: 500,
                auto: 3000,
                callback: function () {
                    var lis = $(this.element).next("ol").children();
                    lis.removeClass("on").eq(this.index).addClass("on");
                }
            });
        });
//over