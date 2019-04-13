/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2010-1001 koyshe <koyshe@gmail.com>
 */

/* ====================== wap全局操作函数 ====================== */
var getmore_state = 0;
$.toast.prototype.defaults.duration = 1300;
function pem_cfone(_this, show) {
	var result = false;
	layer.open({
	    content: '您确认'+show+'吗?',
	    btn: ['确认', '取消'],
	    shadeClose: false,
	    yes: function(){
			window.location.href = $(_this).attr("href");
			return true;
	    }, no: function(index){
	    	layer.closeAll();
	        //layer.open({content: '你选择了取消', time: 1});
	    }
	});
	return false;
};

//打开新页面
function app_open(url, time) {
	if (typeof(time) == 'undefined') time = 1;
	setTimeout(function(){
		if (url == 'back') {
			window.history.go(-1);
		}
		else if (url == 'reload') {
			window.location.reload();
		}
		else if (url == 'dialog') {
			top.location.reload();
		}
		else {
			window.location.href = url;		
		}
	}, time);
}

//ajax获取列表
function app_getlist(url, event, func) {
	if (getmore_state != 0) return;
	getmore_state = 1;
	var page = parseInt($("#getmore_jindu").attr("page"));
	var page = isNaN(page) ? 1 : page + 1;
	var pageid = parseInt($(".pageid").length);
	var pageid = isNaN(pageid) ? 0 : pageid;
	var sleep = 0;
	$("#getmore_jindu").html('<div id="getmore_load">正在加载...</div>').show();
	if (pageid >= 10) {
		//$("#getmore_jindu").show();
		sleep = 800;
	}
	var app_info = '&city=' + app_pageval('city') + '&location=' + app_getval('location');
	$.getJSON(url + '&page=' + page + '&pageid=' + pageid + app_info, {}, function(json){
		setTimeout(function(){
	    	if (func && typeof(func) == "function") {
	    		func(json);
	    	}
			if (json.result) {
		    	//克隆模板并显示信息
				$("#json_html").clone().insertBefore("#json_html").attr("id", "json_html_" + page).find("#json_tpl").attr("id", "json_tpl_" + page);
		    	$("#json_html_" + page).html(template('json_tpl_' + page, json));
		    	$("#getmore_jindu").attr("page", page);
				$("#getmore_jindu").hide();
				getmore_state = 0;
			}
			else {
				getmore_state = -1;
				if (pageid >= 10) {
					$("#getmore_jindu").html('已加载全部数据');
				}
				else {
					$("#getmore_jindu").hide();
				}
				/*setTimeout(function(){
					$("#getmore_jindu").slideUp("fast");
				}, 1000)*/		
			}
		}, sleep);
	});
	if (event == 'down') {
		//监听下拉刷新
		var start_height = 36; //距下边界长度px
		var total_height = 0;
		$(window).scroll(function(){
			total_height = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
			if (($(document).height() - start_height) <= total_height) {
				app_getlist(url);
			}
		})
	}
}
//ajax获取信息
function app_getinfo(url, func) {
	var app_info = '&city=' + app_pageval('city') + '&location=' + app_getval('location');
	$.getJSON(url + app_info, {}, function(json){
		if (typeof(json.show) != 'undefined' && json.show != '') app_tip(json.show);
    	if (func && typeof(func) == "function") {
    		func(json);
    	}
	    else {
			$("#json_html").html(template('json_tpl', json));		    
	    }
	});
}
//ajax删除信息
function app_delinfo(_this, show) {
	layer.open({
	    content: '您确认'+show+'吗?',
	    btn: ['确认', '取消'],
	    shadeClose: false,
	    yes: function(){
	    	$.getJSON($(_this).attr("href"), {}, function(json){
	    		layer.closeAll();
	    		app_tip(json.show);
				if (json.result) {
					$(_this).parents(".pageid").slideUp().remove();	
				}
			})
	    }, no: function(index){
	    	layer.closeAll();
	    }
	});
	return false;
}
//弹出提醒框
function app_alert(show, func) {
	$.alert(show, '', function() {
    	if (func && typeof(func) == "function") {
			func();
		}
	});
};

//tip提示信息
function app_tip(show, type) {
	if (typeof(type) != 'undefined') {
		switch (type) {
			case 'success':
				$.toast(show);
			break;
			case 'error':
				$.toast(show, 'cancel');
			break;			
		}
	}
	else {
		$.toast(show, "text");
	}
};

//开启loading加载层
function app_loading(text, time) {
	app_loading_close();
	$.showLoading(text);
	if (typeof(time) == 'undefined') time = 10000;
	setTimeout(function(){
		app_loading_close();		
	}, time)
}
//关闭loading加载层
function app_loading_close() {
	$.hideLoading();
}

//确认提醒
function app_confirm(show, func_url) {
	$.confirm({
		title: '温馨提示',
		text: '您确认'+show+'吗?',
		onOK: function () {
	    //	layer.closeAll();
	    	if (func_url && typeof(func_url) == "function") {
				func_url();
			}
			else if (func_url) {
				app_getinfo(func_url, function(json){
					if (json.result) {
						app_open('reload', 1000);
					}
				})
			}
		}
	});
}

//ajax表单post提交
function app_submit(url, func, id) {
	app_loading('数据提交中');
	var form_id = typeof(id) == 'undefined' ? 'form' : id;
	$.post(url, $("#"+form_id).serialize(), function(json){
		app_loading_close();
		if (typeof(json.show) != 'undefined' && json.show != '') {
			if (json.result == true) {
				app_tip(json.show, 'success');
			}
			else {
				app_tip(json.show);
			}
		}
    	if (func && typeof(func) == "function") {
    		func(json);
    	}
	}, "json");
}

function app_setval(key, val) {
	localStorage.setItem(key, val);
}

function app_getval(key) {
	var value = localStorage.getItem(key);
	if (value == null) value = '';
	return value;
}

function app_pageval(name) {  
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");  
    var r = window.location.search.substr(1).match(reg);  
    if (r != null) return unescape(r[2]);  
    return null;  
}  

function app_getplace() {
	var options = {
		enableHighAccuracy:true, 
		maximumAge:1000
	}
	//浏览器支持geolocation
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(
			function(position) {
				//经度
				var lng =position.coords.longitude;
				//纬度
				var lat = position.coords.latitude;
				//创建地图实例  
				var map = new BMap.Map("container");
				//创建一个坐标
				var ggpoint = new BMap.Point(lng,lat);
			    var convertor = new BMap.Convertor();
			    var pointArr = [];
			    pointArr.push(ggpoint);
			    convertor.translate(pointArr, 3, 5, function(data){
			    	app_setval('location', data.points[0].lng + '_' + data.points[0].lat);
			    	//set_cookie('lng', data.points[0].lng, 365);
			    	//set_cookie('lat', data.points[0].lat, 365);    	
			    	//alert(data.points[0].lng + '---' + data.points[0].lat)
			    	//$(":input[name='shop_zuobiao']").val(data.points[0].lng + ',' + data.points[0].lat)
			    })
			},
			function(error){
				switch(error.code){
					case 1:
						//alert("位置服务被拒绝");
					break;
					case 2:
						//alert("暂时获取不到位置信息");
					break;
					case 3:
						//alert("获取信息超时");
					break;
					case 4:
						//alert("未知错误");
					break;
			   	}
			}, options
		);
	}
	else {
       //浏览器不支持geolocation
	}
}

//余额支付弹出支付密码
function app_paypw(url, func) {
	var arr = new Array();
	var paypw = window.prompt("请输入支付密码","");
	if (paypw == '') {
		alert('请输入支付密码!');
		arr['result'] = false;	
		return arr;
	}
	if (paypw == null) {
		arr['result'] = false;	
		return arr;
	}
	arr['result'] = true;
	arr['value'] = paypw;
	return arr;
}

//余额支付未设置密码提示
function app_paypw_setting() {
	layer.open({
	    content: '您尚未设置支付密码',
	    btn: ['去设置', '换其他支付'],
	    shadeClose: false,
	    yes: function(){
	    	layer.closeAll();
	    	app_open('user.php?mod=setting&act=paypw&fromto=pay');
	    }, no: function(index){
	    	layer.closeAll();
	    }
	});
	return false;
}

function app_confirm_login(url) {
	layer.open({
	    content: '您还未登录哦',
	    btn: ['去登录', '取消'],
	    shadeClose: false,
	    yes: function(){
	    	layer.closeAll();
	    	app_open(url);
	    }, no: function(index){
	    	layer.closeAll();
	    }
	});
	return false;
}

//加载侧栏iframe层
function app_iframe(url) {
	//$("body").css({"overflow-y":"hidden"});
	var width = window.innerWidth + 'px';
	var height = window.innerHeight + 'px';
	//var html = '<div id="app_iframe" style="position:fixed;top:0;left:0;width:0;height:100%;margin-left:'+width+';z-index:999999;overflow:hidden"><iframe src="'+url+'" style="width:100%;height:100%;border:0"></iframe></div>';
	var html = '<div id="app_iframe" style="height:'+height+';width:'+width+';display:none"><iframe src="'+url+'" style="width:100%;height:100%;border:0"></iframe></div>';
	if (!$("#app_iframe_hide").is("div")) $("body").wrapInner('<div id="app_iframe_hide"></div>');
	$("body").append(html);
	$("#app_iframe_hide").hide();
	$("#app_iframe").fadeIn();
	//$("#app_iframe").animate({"margin-left":"0px", "width":width}, 100)
}

//关闭侧栏iframe层
function app_iframe_close(reload, time) {
	if (typeof(time) == 'undefined') time = 1;
	setTimeout(function(){
		if (reload == true) {
			window.parent.location.reload();
		}
		else {
			//$(window.parent.document).find("body").css({"overflow-y":"auto"});
			$(window.parent.document).find("#app_iframe_hide").children().unwrap();
			$(window.parent.document).find("#app_iframe").remove();
		} 
	}, time);
}

//打开底部弹出页
function app_page(id, func) {
	$("body").css("overflow-y", "hidden");
	$("#"+id).wrap('<div class="app_page" style="position:relative; z-index:99;"></div>');
	var _height = $("#"+id).height() > window.innerHeight ? window.innerHeight : $("#"+id).height();
	$("#"+id).css({"position":"fixed", "width":"100%", "height":_height, "z-index":100, "bottom": 0, "left":0, "background-color":"#fff", "overflow-y":"auto"}).fadeIn(400).addClass("app_pagemain");
	$("#"+id).before('<div class="app_pagehide" style="position:fixed; background-color:rgba(0, 0, 0, 0.7); width:100%; height:100%; z-index:99;top:0;left:0" onclick="app_page_close()"></div>');
	if (func && typeof(func) == "function") {
		func();
	}
	return;
	var html = $("#"+id).html();
	$("#"+id).remove();
	layer.open({
		type: 1
		,content: html
		,anim: 'up'
		,style: 'position:fixed; bottom:0; left:0; width: 100%; padding:0; border:none; background:#f8f8f8'
	});
}
//关闭底部弹出页
function app_page_close(time) {
	$("body").css("overflow-y", "auto");
	$(".app_pagemain").unwrap(".app_page").slideUp().removeClass("app_pagemain");
	$(".app_pagehide").remove();		
	return;
	layer.closeAll();
}