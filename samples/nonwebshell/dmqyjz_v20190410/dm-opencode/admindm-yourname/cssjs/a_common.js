//add..............
$(document).ready(function(){


tab();
//stopsubmit();
editmenuother();
fefilepreviewimg();
selectTOinput();
//popup();
/**/
$('.bgmask').click(function(event) {
	      //$('.bgmask').hide();
           // $('.popcontent').hide();
		     $(this).hide();//bgmask
             $(this).prev().hide();

});
$('.popclose,.popclosebelow').click(function(){

   $(this).closest('.popcontent').hide();
    $('.bgmask').hide();

});


	$('.formtabhovertr tr').hover(function(){
	   $(this).addClass('hovertr');
	},function(){
	    $(this).removeClass('hovertr');
	});

$('.needpopup').click(function(e) {
	 e.preventDefault();
	  //alert($(this).attr('href'));
	 popupneed($(this).attr('href'));
	 return false;
});



$('.clicknextshow').click(function(event) {
	 $(this).next().toggle();//slideToggle
});

if($('.iframeparentlink')){
var src = $(window.parent.document).find("#iframepage").attr('src');
$('.iframeparentlink').attr('href',src);
}

//---------end ready----------------------------------------
}); //end ready


function selectTOinput(){
	 $('.selectTOinput select').change(function(){
	       var optionv = $(this).children('option:selected').val();
		   //console.log(optionv);
		   $(this).parent().children('input').val(optionv);
	 });

}


function fefilepreviewimg(){
	 $('.fefilepreviewimg .img1').hover(function(){
	  $(this).next().show();
	},function(){
	   $(this).next().hide();
	});

}
function editmenuother(){
		   $(".editmenuother").click(function(){
			  $(".editmenuother_cnt").slideToggle();
			});
}

function stopsubmit(){
     $('input[type=submit]').click(function(){

       // alert(0);

     });
}//end func



function tab(){
$(".tab span").click(function(){
thisindex =$(this).index()+1;
$(".tab span").toggleClass('cur');
$(".tabarea>div").hide();
$(".tabarea .tab"+thisindex).show();


});
//
}//end func




function SeIframeHeight() {
		var iframeHeight = $("#iframepage").contents().find("body").height()+100;
        $("#iframepage").height(iframeHeight);
}

 function  confirmaction(action,ifdel,backurl,textv){
        if(ifdel=='del') var textv ='<span style="color:red"> '+title + '</span> <br />确定删除?不能恢复! ';
	    backurl = backurl+'&act='+action;
		popupconfirm(textv,backurl);

}

 

function  del(actgo2,pidname,backpage,title){
    //if (confirm("确定删除?不能恢复")){
      golink  = backpage+'&act='+actgo2+'&pidname='+pidname;
	var textv ='<span style="color:red"> '+title + '</span> <br />确定删除?不能恢复! ';
		popupconfirm(textv,golink);
}
function  del2(actgo2,pidname,pidname2,backpage){  //when del region sub
    //if (confirm("确定删除?不能恢复")){
      golink  = backpage+'&act='+actgo2+'&pidname='+pidname+'&pidname2='+pidname2;
	//alert(golink);
      // window.location=golink;
    //}
	var textv ='确定删除?不能恢复!';
		popupconfirm(textv,golink);
}
function  delid(actgo2,id,backpage,title){
    //if (confirm("确定删除?不能恢复")){
      golink  = backpage+'&act='+actgo2+'&tid='+id;
	//alert(golink);
      // window.location=golink;
    //}
	var textv ='<span style="color:red"> '+title + '</span> <br />确定删除?不能恢复! ';
		popupconfirm(textv,golink);

}

function  delimg(actgo2,tid,imgv,backpage){
    //if (confirm("确定删除?不能恢复")){
     golink  = backpage+'&act='+actgo2+'&tid='+tid+'&v='+imgv;//imgv no use
	//alert(golink);
      // window.location=golink;
   // }
	var textv ='确定删除?不能恢复!';
	 popupconfirm(textv,golink);

}




function  isnum(v){  //alert(v);
    if(!isNaN(v)){return true;
  			// alert("是数字");
		}
	else{return false;
		   //alert("不是数字");
		}

	/*
	    var pos=thisForm.pos.value;
    //正则表达式，需要注意的是这里并没有引号，而是用//
    var reg=/^[0-9]*$/;
    if(!reg.test(pos)){
	   alert("pos必须是数字");
		thisForm.pos.focus();
		return (false);

   }
   */

}

// gosele
function gosele(sobj,can,jumpv) {
	var thevalue =sobj.options[sobj.selectedIndex].value;
	if (thevalue != "") {
	//alert(docurl);
	var gov =  jumpv+can+'='+thevalue;
	//alert(gov);
	 location.href=gov;
	  // open(docurl,'_blank');
	  // sobj.selectedIndex=0;
	  // sobj.blur();
	}
}




function popupneed(iframeSrc){
	if(iframeSrc=='') var iframeSrc = '../mod_common/iframeblank.php';
	 $('#popiframe').attr('src',iframeSrc);
	 popup_go('need','.popcontent');
 }

 function popupconfirm(textv,linkv){
     $('.popcontentconfirm .popcontentinc p').html(textv);
	 $('.popcontentconfirm .link a').attr('href',linkv);

	 popup_go('confirm','.popcontentconfirm');

  //alert(opentext);
  //var opentext2 = '<div class="message popcontentconfirm"><span class="h3hd">确定操作吗？</span><p><span style="color:red"><i class="fa fa-exclamation-circle"></i> 如果取消</span>，请点击右上角关闭窗口。<span class="link"><a href="'+linkv+'" class="but2"><i class="fa fa-trash-o"></i> 确定删除</a></span></p></div>';
 // $.fancybox.open(opentext2);
  // $.fancybox.open('<div class="message"><h2>Hello!</h2><p>You are awesome!</p></div>');

 }


function popup_go(type,v){
   popupName = $(v);
 var _scrollHeight = $(document).scrollTop(),
     _windowH = $(document).height(),
     _windowW = $(window).width(),
     _popupH = popupName.height(),
     _popupW = popupName.width()+40;
     // _posiTop = (_windowH - _popupH)/2 + _scrollHeight;
	  _posiTop = _scrollHeight+50;

	 // console.log('_scrollHeight:'+_scrollHeight);
	 // console.log('_windowH:'+_windowH);
	 // console.log('_popupH:'+_popupH);
	 // console.log('_posiTop:'+_posiTop);

    // if(type=='confirm') _posiTop = _posiTop-150;

	//if(type=='confirm') _posiTop = 100;
	//else _posiTop = 50;



     _posiLeft = (_windowW - _popupW)/2+10;
 popupName.css({"left": _posiLeft + "px","top":_posiTop + "px"});

  bgH = $(document).height();
  $('.bgmask').css({height:bgH+'px'});

			if(type=='need')   {
					$('.bgmaskneed').show();
					$('.popcontentneed').show();
			}
			if(type=='confirm')   {
					$('.bgmaskconfirm').show();
					$('.popcontentconfirm').show();
			}



}
