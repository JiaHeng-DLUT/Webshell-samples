function myEvent(obj, ev, fu){
	obj.attachEvent ? obj.attachEvent('on' + ev, fu) : obj.addEventListener(ev, fu, false);
}
window.onload = function(){
	var oBox = document.getElementById('ztbox');
	var oLeft = document.getElementById('left');
	var oRight = document.getElementById('right');
	var oConter = document.getElementById('conter');
	var oUl = oConter.getElementsByTagName('ul')[0];
	var oLi = oConter.getElementsByTagName('li');
	var oScroll = document.getElementById('scroll');
	var oSpan = oScroll.getElementsByTagName('span')[0];
	var i = 0;
	oUl.style.width = oLi.length * (oLi[0].offsetWidth + 4)+'px';
	//var iWidth = oScroll.offsetWidth/(oUl.offsetWidth / oConter.offsetWidth - 1)
	var iWidth=88;
	oLeft.onmouseover = oRight.onmouseover = function(){
		this.className = 'hover';
		//点击左侧按钮
		oLeft.onclick = function(){
			var butscroll = oSpan.offsetLeft - iWidth;
			oscroll(butscroll);
		};
		//点击右侧按钮
		oRight.onclick = function(){
			var butscroll = oSpan.offsetLeft + iWidth;
			oscroll(butscroll);
		};
	};
	//点击滚动条
	oScroll.onclick = function(e){
		var oEvent = e || event;
		var butscroll = oEvent.clientX - oBox.offsetLeft -43 - oSpan.offsetWidth / 2;
		oscroll(butscroll);
	};
	oSpan.onclick = function(e){
		var oEvent = e || event;
		oEvent.cancelBubble=true;
	}
	oLeft.onmouseout = oRight.onmouseout = function(){
		this.className = '';
	};
	//拖拽滚动条
	var iX = 0;
	oSpan.onmousedown = function(e){
		var oEvent = e || event;
		iX = oEvent.clientX - oSpan.offsetLeft;
		document.onmousemove = function(e){
			var oEvent = e || event;
			var l = oEvent.clientX - iX;
			td(l);
			return false;
		};
		document.onmouseup = function(){
			document.onmousemove = null;
			document.onmouseup = null;
		};
		return false;
	};
	//滚轮事件
	function fuScroll(e){
		var oEvent = e || event;
		var l = oSpan.offsetLeft;
		oEvent.wheelDelta ? (oEvent.wheelDelta > 0 ? l-=iWidth : l+=iWidth) : (oEvent.detail ? l+=iWidth : l-=iWidth);
		oscroll(l)
		if(oEvent.PreventDefault){
			oEvent.PreventDefault();
		}
	}
	myEvent(oConter, 'mousewheel', fuScroll);
	myEvent(oConter, 'DOMMouseScroll', fuScroll);
	//滚动事件
	function oscroll(l){
		if(l < 0){
			l = 0;
		}else if(l > oScroll.offsetWidth - oSpan.offsetWidth){
			l = oScroll.offsetWidth - oSpan.offsetWidth;
		}
		var scrol = l / (oScroll.offsetWidth - oSpan.offsetWidth);
		sMove(oSpan, 'left', Math.ceil(l));
		sMove(oUl, 'left', '-'+Math.ceil((oUl.offsetWidth - (oConter.offsetWidth)) * scrol));
	}

	function td(l){
		if(l < 0){
			l = 0;
		}else if(l > oScroll.offsetWidth - oSpan.offsetWidth){
			l = oScroll.offsetWidth - oSpan.offsetWidth;
		}
		var scrol = l / (oScroll.offsetWidth - oSpan.offsetWidth);
		oSpan.style.left = l+'px';
		oUl.style.left = '-'+(oUl.offsetWidth - (oConter.offsetWidth + 4)) * scrol +'px';
	}
};
//运动框架
function getStyle(obj, attr){
	return obj.currentStyle ? obj.currentStyle[attr] : getComputedStyle(obj, false)[attr];
}
function sMove(obj, attr, iT, onEnd){
	clearInterval(obj.timer);
	obj.timer = setInterval(function(){
		dMove(obj, attr, iT, onEnd);
	},30);
}
function dMove(obj, attr, iT, onEnd){
	var iCur = 0;
	attr == 'opacity' ? iCur = parseInt(parseFloat(getStyle(obj, attr)*88)) : iCur = parseInt(getStyle(obj, attr));
	var iS = (iT - iCur) / 6;
	iS = iS > 0 ? Math.ceil(iS) : Math.floor(iS);
	if(iCur == iT){
		clearInterval(obj.timer);
		if(onEnd){
			onEnd();
		}
	}else{
		if(attr == 'opacity'){
			obj.style.ficter = 'alpha(opacity:'+(iCur + iS)+')';
			obj.style.opacity = (iCur + iS) / 88;
		}else{
			obj.style[attr] = iCur + iS +'px';
		}
	}
}
//图片切换
function picCha(){
	var bsrc=$(this).attr('src');
	$('.bpic').attr('src',bsrc);
	var h2title=$(this).parent().find('.txt h2').text();
	var ptitle=$(this).parent().find('.txt p').text();
	$('.intro h2').text(h2title);
	$('.intro p').text(ptitle);
};
$(function(){
	$('.smallpic').bind('click',picCha);
	$('#conter li').click(function(){
		$(this).siblings().removeClass('on');
		$(this).addClass('on');
	});
	var num=$('ul li').length;
	$('.snum strong').text(num);
	$('ul li').each(function(){
		var fnum=$(this).index()+1;
		$(this).find('b').text(fnum);
	});
	$('.pre').click(function(){
		var h2title=$(this).parents('.box-163css').find('.on').prev('li').find('h2').text();
		var ptitle=$(this).parents('.box-163css').find('.on').prev('li').find('p').text();
		$('.intro h2').text(h2title);
		$('.intro p').text(ptitle);
		$(this).parents('.box-163css').find('.on').removeClass('on').prev().addClass('on');
		var qsrc=$('.on').find('img').attr('src');
		//alert(qsrc);
		var firstSrc=$('li').first().find('img').attr('src');
		//alert(firstSrc);
		$('.bpic').attr('src',qsrc);
		if(qsrc==firstSrc){
			alert('这是第一页');
			$('li:first').addClass('on');
			$('.bigpic').hover(function(){$('.pre').hide()});
		}else{
			$('.bigpic').hover(function(){$('.next').show()},function(){$('.next').hide()});
		};
		//tiaoCha();
	});
	$('.next').click(function(){
		    var h2title=$(this).parents('.box-163css').find('.on').next('li').find('h2').text();
			var ptitle=$(this).parents('.box-163css').find('.on').next('li').find('p').text();
			$('.intro h2').text(h2title);
			$('.intro p').text(ptitle);
			$(this).parents('.box-163css').find('.on').removeClass('on').next().addClass('on');
			var qsrc=$('.on').find('img').attr('src');
			var lastSrc=$('li').last().find('img').attr('src');
			//alert(lastSrc);
			$('.bpic').attr('src',qsrc);
			if(qsrc==lastSrc){
				alert('已经到最后一页');
				$('.bigpic').hover(function(){$('.next').hide()});
			}else{
				$('.bigpic').hover(function(){$('.pre').show()},function(){$('.pre').hide()});
			};
			
		});
	$('.bigpic').hover(function(){$('.btn').show()},function(){$('.btn').hide()});
	$('.bclose').click(function(){
		$('.intro').hide();
	});
	
})