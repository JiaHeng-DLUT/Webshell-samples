/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2010-1001 koyshe <koyshe@gmail.com>
 */
//$.ajaxSettings.async = false;
//常用正则规则
var rule_phone = /^1[0-9]{10}$/;
var rule_qq = /^[0-9]{5,15}$/;
var rule_email = /^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[a-z]{2,3}$/;
var rule_zh = /^[\u4e00-\u9fa5]+$/;

/* ====================== jq全局操作函数 ====================== */
//全选操作(修正版) by koyshe 2012-03-09
function pe_checkall(_this, inputname) {
	var checkname = $(_this).attr("name");
	if ($(_this).is(":checked")) {
		$("input[name='"+inputname+"[]']").add("input[name='"+checkname+"']").attr("checked","checked").change();
	}
	else {
		$("input[name='"+inputname+"[]']").add("input[name='"+checkname+"']").removeAttr("checked").change();
	}
} 
//带提醒批量操作(修正版) by koyshe 2012-03-09
function pe_cfall(_this, inputname, formid, show) {
	if ($("input[name='"+inputname+"[]']").filter(":checked").length == 0) {
		alert('请先勾选需要'+show+'的信息!');
		return false;
	}
	else if (confirm('您确认'+show+'吗?')) {
		$("#"+formid).attr("action", $(_this).attr("href")).submit();
	}
	return false;
}
//带提醒单个操作(修正版) by koyshe 2012-11-29
function pe_cfone(_this, show) {
	var _text = arguments[2] ? show : '您确认'+show+'吗?';
	if (confirm(_text)) {
		if ($(_this).is("a")) {
			return true;
		}
		else {
			if ($(_this).attr("target") == "_blank") {
				window.open($(_this).attr("href"));
				return false;
			}
			if (document.all) {  
				var referer_url = document.createElement('a');  
				referer_url.href = $(_this).attr("href");  
				document.body.appendChild(referer_url);  
				referer_url.click();  
			}
			else {
				window.location.href = $(_this).attr("href");
			}
		}
	}
	return false;
};
//批量操作 by koyshe 2012-03-09
function pe_doall(_this, formid) {
	$("#"+formid).attr("action", $(_this).attr("href")).submit();
}
//dialog函数 by koyshe 2011-11-12
function pe_artdialog(_this, title, width, height, id, lock) {
	art.dialog.open($(_this).attr("href"), {title:title, width: width, height: height, id: id, lock: lock});
	return false;
}

//dialog函数 by layer
function pe_dialog(_this, _title, width, height, id) {
	var url = (typeof(_this) == 'object') ? $(_this).attr("href") : _this;
	var layer_index = layer.open({
		type: 2,
		title: _title,
		area: [width+'px', height+'px'],
		fixed: false, //不固定
		shadeClose: true,
		shade: 0.5,
		content: url //iframe的url
	});
	if (width == 'max' && height == 'max') layer.full(layer_index);
	return false;
}

//验证码函数
function pe_yzm(_this) {
	var yzm_url = $(_this).attr("src");
	var yzm_time = new Date().getTime();
	if (yzm_url.indexOf("time") >= 0) {
		yzm_url = yzm_url.replace(/time=\d+/, 'time=' + yzm_time);
	}
	else {
		yzm_url += (yzm_url.indexOf("?") >= 0 ? '&' : '?') + 'time=' + yzm_time;
	}
	$(_this).attr("src", yzm_url);
}
//商品购买数量
function pe_numchange(inputname, type, limit) 
{
	var _input = $(":input[name='"+inputname+"']");
	var _input_val = parseInt(_input.val());
	var limit = parseInt(limit);
	if (type == '+') {
		if (_input_val < limit) _input.val(_input_val + 1)
	}
	else {
		if (_input_val > limit) _input.val(_input_val - 1)
	}
}

//数字处理
function pe_num(num, type, len, fix) {
	if (typeof(len) == 'undefined') len = 0;
	if (typeof(fix) == 'undefined') fix = false;
	var pow = Math.pow(10, len);	
	var num = parseFloat(num);
	if (isNaN(num)) num = 0;
	if (type == 'round') {
		num = Math.round(num * pow) / pow;
	}
	else if (type == 'ceil') {
		num = Math.ceil(num * pow) / pow;
	}
	else if (type == 'floor') {
		num = Math.floor(num * pow) / pow;
	}
	if (fix == true) {
		num = num.toFixed(len);
		/*var num_arr = String(num).split('.');
		num = String(num_arr[0]);
		if (typeof(num_arr[1]) != 'undefined') {
			num = num + '.' + String(num_arr[1]) + String(new Array(len - num_arr[1].length).join("0") + "0");
		}
		else {
			num = num + '.' + String(new Array(len).join("0") + "0");	
		}
		num = parseFloat(num);*/
	}
	return num;
}

function pe_inputdefault(name, text) {
	var _this = $(":input[name='"+name+"']");
	if (_this.val() == '') _this.val(text);
	_this.focus(function(){
		if ($(this).val() == text) {
			$(this).val('');
		}
	})
	_this.blur(function(){
		if ($(this).val() == '') {
			$(this).val(text)
		}
	})
	_this.parent("form").submit(function(){
		if (_this.val() == text) {
			_this.val('');
		}
	})
}

function pe_countdown(id, etime) {
	setInterval(function(){
	    var obj = $("#" + id);
	    var endTime = new Date(parseInt(etime) * 1000);
	    var nowTime = new Date();
	    var nMS=endTime.getTime() - nowTime.getTime();
	    var myD=Math.floor(nMS/(1000 * 60 * 60 * 24));
	    var myH=Math.floor(nMS/(1000*60*60)) % 24;
	    var myM=Math.floor(nMS/(1000*60)) % 60;
	    var myS=Math.floor(nMS/1000) % 60;
	    var myMS=Math.floor(nMS/100) % 10;
	    if(myD>= 0){
			//var str = myD+"天"+myH+"小时"+myM+"分"+myS+"."+myMS+"秒";
			var str = myD+"天"+myH+"小时"+myM+"分"+myS+"秒";
	    }else{
			var str = "0天0小时0分0秒";
		}
		obj.html(str);
	}, 100);
}

function pe_jstime(obj, nowtime, type) {
	//var nowtime = parseInt(nowtime);
	var nowtime_arr = new Array();
	$(obj).each(function(index){
		nowtime_arr[index] = parseInt(nowtime);
		var _this = $(this);
		var endtime = parseInt(_this.attr("endtime"));	
		var waittime = 0.5;
		setInterval(function(){
			//console.log(nowtime_arr[index])
			nowtime_arr[index] += waittime;
			var all_s = parseInt(endtime - nowtime_arr[index]);
		    //var js_d = Math.floor(all_s/(60 * 60 * 24));
		    //var js_h = Math.floor(all_s/(60 * 60)) % 24;
		    var js_h = Math.floor(all_s/(60 * 60));
		    var js_m = Math.floor(all_s/60) % 60;
		    var js_s = Math.floor(all_s) % 60;
		    if (js_h < 10) js_h = '0' + js_h;
		    if (js_m < 10) js_m = '0' + js_m;
		    if (js_s < 10) js_s = '0' + js_s;
			if (typeof(type) != 'undefined' && type == 'html') {
			    if (all_s >= 0) {
					_this.html(js_h+'小时'+js_m+'分'+js_s+'秒');	
			    }
			    else{
					_this.html('0小时0分0秒');
				}
			}
			else {
			    if (all_s >= 0) {
					_this.find(".jstime_h").html(js_h);
					_this.find(".jstime_m").html(js_m);
					_this.find(".jstime_s").html(js_s);
			    }
			    else{
					_this.find(".jstime_h").html('00');
					_this.find(".jstime_m").html('00');
					_this.find(".jstime_s").html('00');
				}
			}
		}, waittime * 1000);	
	});
}

function pe_loadscript (url){
	$.get(url);
    /*var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = url;
    document.body.appendChild(script);*/
}

//js模板引擎赋值
function pe_jsontpl(id, json) {
	$("#"+id).html(template(id+'_tpl', json));
}

//打开新页面
function pe_open(url, time) {
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
var getmore_state = 0;
function pe_getlist(url, event, func) {
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
	$.getJSON(url + '&page=' + page + '&pageid=' + pageid, {}, function(json){
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
				pe_getlist(url);
			}
		})
	}
}
//ajax获取信息
function pe_getinfo(url, func) {
	$.getJSON(url, {}, function(json){
		if (typeof(json.show) != 'undefined' && json.show != '') {
			if (json.result == true) {
				pe_tip(json.show, 'success');
			}
			else if (json.result == false) {
				pe_tip(json.show, 'error');		
			}
			else {
				pe_tip(json.show);
			}
		} 
    	if (func && typeof(func) == "function") {
    		func(json);
    	}
	    else {
			$("#json_html").html(template('json_tpl', json));		    
	    }
	});
}
//ajax删除信息
function pe_delinfo(_this, show) {
	layer.open({
	    content: '您确认'+show+'吗?',
	    btn: ['确认', '取消'],
	    shadeClose: false,
	    yes: function(){
	    	$.getJSON($(_this).attr("href"), {}, function(json){
	    		layer.closeAll();
	    		pe_tip(json.show);
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
function pe_alert(show, func) {
	layer.open({
	    content: show,
	    btn: ['确认'],
	    yes: function(){
	    	layer.closeAll();
	    	if (func && typeof(func) == "function") {
				func();
			}
	    }
	});
};

//tip提示信息
function pe_tip(text, type) {
	if (typeof(type) != 'undefined') {
		switch (type) {
			case 'success':
				layer.msg(text, {icon: 1});
			break;
			case 'error':
			layer.msg(text, {icon: 2});
			break;			
		}
	}
	else {
		layer.msg(text);
	}
};
//tips解释信息
function pe_tips(_this, text) {
	layer.tips(text, _this, {
		tips : [2, '#3595CC'],
		time : 0
	});
	$(_this).mouseout(function(){
		layer.closeAll('tips');	
	})
}

//loading加载层
function pe_loading(text) {
	if (typeof(text) == 'undefined' || text == '') {
		text = '数据请求中';	
	}
	return layer.msg(text, {icon: 16, time:60000});
}

//确认提醒
function pe_confirm(show, func_url) {
	layer.open({
	    content: '您确认'+show+'吗?',
	    btn: ['确认', '取消'],
	    shadeClose: false,
	    yes: function(){
	    	if (func_url && typeof(func_url) == "function") {
				func_url();
			}
			else if (func_url) {
				pe_getinfo(func_url, function(json){
					if (json.result) {
						pe_open('reload', 1000);
					}
				})
			}
	    }, no: function(index){
	    	layer.closeAll();
	    }
	});
	//return false;
}

//ajax表单post提交
function pe_submit(url, func, id) {
	var form_id = typeof(id) == 'undefined' ? 'form' : id;
	$.post(url, $("#"+form_id).serialize(), function(json){
    	//if (json.show != '') pe_tip(json.show);
		if (typeof(json.show) != 'undefined' && json.show != '') {
			if (json.result == true) {
				pe_tip(json.show, 'success');
			}
			/*else if (json.result == false) {
				pe_tip(json.show, 'error');		
			}*/
			else {
				pe_tip(json.show);
			}
		}
    	if (func && typeof(func) == "function") {
    		func(json);
    	}
	}, "json");
}

//js模板赋值
function pe_jshtml(id, json){
	$("#"+id).html(template(id+'_tpl', json));	
};

//单选/多选美化版
function pe_select_radio(name, value, func) {
	$(":input[name='"+name+"']").live("change", function(){
		$(":input[name='"+name+"']").each(function(){
			if ($(this).is(":checked")) {
				$(this).parents("label").addClass("sel");
				if (func && typeof(func) == "function") {
    				func();
    			}		
			}
			else {
				$(this).parents("label").removeClass("sel");		
			}
		})		
	})
	if (typeof(value) != 'undefined') {
		$(":input[name='"+name+"'][value='"+value+"']").attr("checked", "checked").change();
	}
}
//单选/多选美化版
function pe_form_select(name, value, func) {
	$(":input[name='"+name+"']").live("change", function(){
		$(":input[name='"+name+"']").each(function(){
			if ($(this).is(":checked")) {
				$(this).parents("label").addClass("sel");
				if (func && typeof(func) == "function") {
    				func();
    			}		
			}
			else {
				$(this).parents("label").removeClass("sel");		
			}
		})		
	})
	if (typeof(value) != 'undefined') {
		$(":input[name='"+name+"'][value='"+value+"']").attr("checked", "checked").change();
	}
}
//发送短信验证码
var waittime = 0;
function pe_sendyzm(_this, name, func) {
	if ($(_this).attr("disabled") == "disabled") return false;	
	if (waittime == 0) {
		$(_this).attr("disabled", "disabled").html('发送中...');
		$.getJSON($(_this).attr("href") + "&value="+$(":input[name='"+name+"']").val(), function(json){
			typeof(app_tip) == 'undefined' ? pe_tip(json.show) : app_tip(json.show);
			if (json.result) {
				waittime = 60;
			    var timeout = setInterval(function() {
			    	waittime--;
			    	if (waittime > 0) {
			    		$(_this).attr("disabled", "disabled").html("重新发送(" + waittime + ")");
			    	}
				    else {
			    		clearTimeout(timeout);	 
			    		$(_this).removeAttr("disabled").html("获取验证码");
			    		waittime = 0;
				    }
			    },1000);			
				if (func && typeof(func) == "function") {
					func(json);	
				}
			}
			else {
				$(_this).removeAttr("disabled").html("获取验证码");
			}
		})
	}
}

//预加载loading
function page_loading() {
	$(document).ready(function(){
		// WAIT FOR EVERYTHING TO LOAD
		$(window).load(function(){
			$('#page_loading').remove();
		});		
	})
}
