// qTip - CSS Tool Tips - by Craig Erskine
// http://qrayg.com
//
// Multi-tag support by James Crooke
// http://www.cj-design.com
//
// Inspired by code from Travis Beckham
// http://www.squidfingers.com | http://www.podlob.com
//
// Copyright (c) 2006 Craig Erskine
// Permission is granted to copy, distribute and/or modify this document
// under the terms of the GNU Free Documentation License, Version 1.3
// or any later version published by the Free Software Foundation;
// with no Invariant Sections, no Front-Cover Texts, and no Back-Cover Texts.
// A copy of the license is included in the section entitled "GNU
// Free Documentation License".

var wptdb_qTipTag = "a"; //Which tag do you want to qTip-ize? Keep it lowercase!//
var wptdb_qTipX = 0; //This is qTip's X offset//
var wptdb_qTipY = 15; //This is qTip's Y offset//
var wptdb_tooltip_at_btm = false;

//There's No need to edit anything below this line//
wptdb_tooltip = {
  name : "wptdb_qTip",
  offsetX : wptdb_qTipX,
  offsetY : wptdb_qTipY,
  tip : null
}

wptdb_tooltip.init = function () {
	var tipNameSpaceURI = "http://www.w3.org/1999/xhtml";
	if(!tipContainerID){ var tipContainerID = "wptdb_qTip";}
	var tipContainer = document.getElementById(tipContainerID);

	if(!tipContainer) {
	  tipContainer = document.createElementNS ? document.createElementNS(tipNameSpaceURI, "div") : document.createElement("div");
		tipContainer.setAttribute("id", tipContainerID);
	  document.getElementsByTagName("body").item(0).appendChild(tipContainer);
	}

	if (!document.getElementById) return;
	this.tip = document.getElementById (this.name);
	if (this.tip) document.onmousemove = function (evt) {wptdb_tooltip.move (evt)};

	var a, sTitle, elements;
	
	var elementList = wptdb_qTipTag.split(",");
	for(var j = 0; j < elementList.length; j++)
	{	
		elements = document.getElementsByTagName(elementList[j]);
		if(elements)
		{
			for (var i = 0; i < elements.length; i ++)
			{
				a = elements[i];
				sTitle = a.getAttribute("title");		
        sClassName = a.className;
				if(sTitle && sClassName=='wptdb_qtip')
				{
					a.setAttribute("tiptitle", sTitle);
					a.removeAttribute("title");
					a.removeAttribute("alt");
					a.onmouseover = function() {wptdb_tooltip.show(this.getAttribute('tiptitle'))};
					a.onmouseout = function() {wptdb_tooltip.hide()};
				}
			}
		}
	}
	
try {
  var wptdb_get_demobar_pos = document.getElementById('wpthemedemobar_pos_teller').innerHTML;
  if (wptdb_get_demobar_pos == 'bottom') {
    wptdb_tooltip_at_btm = true;
  }
} catch (e) {}

}

wptdb_tooltip.move = function (evt) {
	var x=0, y=0;
	if (document.all) {//IE
		x = (document.documentElement && document.documentElement.scrollLeft) ? document.documentElement.scrollLeft : document.body.scrollLeft;
		y = (document.documentElement && document.documentElement.scrollTop) ? document.documentElement.scrollTop : document.body.scrollTop;
		x += window.event.clientX;
		y += window.event.clientY;
		
	} else {//Good Browsers
		x = evt.pageX;
		y = evt.pageY;
	}
	this.tip.style.left = (x + this.offsetX) + "px";
	if (!wptdb_tooltip_at_btm) {
	 this.tip.style.top =  "30px";
	} else {
	 this.tip.style.top =  "30px";
  }
}

wptdb_tooltip.show = function (text) {
	if (!this.tip) return;
	this.tip.innerHTML = text;
	this.tip.style.display = "block";
	
}

wptdb_tooltip.hide = function () {
	if (!this.tip) return;
	this.tip.innerHTML = "";
	this.tip.style.display = "none";
}

function wptdb_qtip_addLoadEvent(func) {
    var oldonload = window.onload;
    if (typeof window.onload != 'function') {
        window.onload = func;
    } else {
        window.onload = function() {
            if (oldonload) {
                oldonload();
            }
            func();
        }
    }
}

function wptdb_qtip_init() {
wptdb_tooltip.init ();
}

wptdb_qtip_addLoadEvent(wptdb_qtip_init);

$(document).ready(function(e) {
  if (top.location != self.location)top.location=self.location;   
$('#gbds_thmemesbar').parent('.wptdb_left').parent('.wpthemedemobar_wrapper').parent('#wpthemedemobar').append("<a href='http://www.themepark.com.cn/' id='ad_thmemesbar' title='更多主题请进入官网查看' class='wptdb_qtip'>更多主题请进入官网查看>> </a>")	
$('#gbds_thmemesbar').click(function() {
$('#gbds_thmemesbar').parent('.wptdb_left').parent('.wpthemedemobar_wrapper').parent('#wpthemedemobar').after("<div title='打开工具条' id='openthemesbar'></div>")	
$(this).parent('.wptdb_left').parent('.wpthemedemobar_wrapper').parent('#wpthemedemobar').fadeOut(300);
$('html').animate({"padding-top" : "0"},300);

$('#openthemesbar').click(function() {
	
$(this).prev('#wpthemedemobar').fadeIn(300);
$('html').animate({"padding-top" : "44px"},300);
$(this).fadeOut(100);
	});

	});

	
	
});
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?beb81ff34188afd6b682932418aa9ef0";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
