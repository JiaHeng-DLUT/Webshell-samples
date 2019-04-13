/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2010-1001 koyshe <koyshe@gmail.com>
 */
(function($){
//计算中文长度
function js_length(str) {
    return str.replace(/[^\x00-\xff]/g,"aaa").length;
};
//定制常用正则
//var rule_phone = /^((1[0-9]{10})|([0-9-]{7,12}))$/;
var rule_phone = /^1[0-9]{10}$/;
var rule_qq = /^[0-9]{5,15}$/;
var rule_email = /^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[a-z]{2,3}$/;
var rule_zh = /^[\u4e00-\u9fa5]+$/;
var rule_idcard = /^([1-9][0-9]{14})|([1-9][0-9]{17})$/;
function _success(_this, show_id, show_icon) {
	_this.attr("pe_result", "true");
	_this.css("background-color","#fff")
	if (typeof(show_icon) == 'undefined') {
		$("#" + show_id).empty();
	}
	else {
		$("#" + show_id).html('<img src="http://www.phpshe.com/include/image/result1.gif" />');
	}
}
function _error(_this, show_id, show_text) {
	_this.attr("pe_result", "false");
	_this.css("background-color","#ffdbdb");
	$("#" + show_id).html('<span style="color:#e3051c;">'+show_text+'</span>');
}
//比较数字大小或比较字符串长短（内部调用）
function _maxmin (_config, _val, type) {
	var _this = $(":input[name='"+_config.name+"']");
	var _limit = _config.arg.split('|');
	if (type == 'num') {
		if (!isNaN(_val) && _val != '') {
			var numtype = true;
		}
		else {
			var numtype = false;
		}
	}
	else {
		var numtype = true;		
	}
	if (_limit[0] && _limit[1] === '') {
		if ((numtype && _val >= parseFloat(_limit[0])) || (_val == '' && _config.must == false)) {
			_success(_this, _config.show_id, _config.icon);
		}
		else {
			_error(_this, _config.show_id, _config.show_error);
		}
	}
	else if (_limit[1] && _limit[0] === '') {
		if ((numtype && _val <= parseFloat(_limit[1])) || (_val == '' && _config.must == false)) {
			_success(_this, _config.show_id, _config.icon);
		}
		else {
			_error(_this, _config.show_id, _config.show_error);
		}
	}
	else if (_limit[0] && _limit[1]) {
		if ((numtype && _val >= parseFloat(_limit[0]) && _val <= parseFloat(_limit[1])) || (_val == '' && _config.must == false)) {
			_success(_this, _config.show_id, _config.icon);
		}
		else {
			_error(_this, _config.show_id, _config.show_error);
		}
	}
	else {
		if ((_val && _config.must == true) || (_val == '' && _config.must == false)) {
			_success(_this, _config.show_id, _config.icon);
		}
		else {
			_error(_this, _config.show_id, _config.show_error);
		}
	}
}
//验证核心操作（内部调用）
function _core(my_config) {
	var pe_config = {
		name : '',
		mod : '',
		act : 'blur',
		arg : '',
		show_id : '',
		show_error : 'error',
		must : true
	};
	var _config = $.extend(pe_config, my_config);
	var _this = $(":input[name='"+_config.name+"']");
	var _val = _this.val();
	if (_this.attr('pe_result') == 'false') return;
	var disabled = true;
	_this.each(function(){
		if ($(this).attr("disabled") != "disabled") disabled = false;
	})
	if (disabled == true) return;
	switch (_config.mod) {
		case 'match':
			if (_config.arg == 'email' || _config.arg == 'phone' || _config.arg == 'qq' || _config.arg == 'idcard' || _config.arg == 'zh') {
				var _rule = eval('rule_'+_config.arg);
			}
			else {
				var _rule = config.arg;
			}
			if (_rule.test(_val) || (_val == '' && _config.must == false)) {
			_success(_this, _config.show_id, _config.icon);
			}
			else {
				_error(_this, _config.show_id, _config.show_error);
			}
		break;
		case 'str':
			_maxmin(_config, js_length(_val), 'str');
		break;
		case 'num':
			_maxmin(_config, _val, 'num');
		break;
		case 'equal':
			if (typeof(_config.arg) == 'object') _config.arg = _config.arg.val();
			if (_val == _config.arg || (_val == '' && _config.must == false)) {
			_success(_this, _config.show_id, _config.icon);
			}
			else {
				_error(_this, _config.show_id, _config.show_error);
			}
		break;
		case 'ajax':
			if (_val == '' && _config.must == false) {
			_success(_this, _config.show_id, _config.icon);
			}
			else {
				$.ajaxSettings.async = false;//同步方式执行AJAX($.ajaxSetup({async: false});)
				var _ajax_data = _config.arg();
				$.getJSON(_ajax_data.url, _ajax_data.data, function(json){
					if (_ajax_data.tf != false) _ajax_data.tf = true;
				  	if (json.result == _ajax_data.tf) {
						_success(_this, _config.show_id, _config.icon);
					}
					else {
						_error(_this, _config.show_id, _config.show_error);
					}
				});
			}
		break;
		case 'func':
			if (_config.arg() || (_val == '' && _config.must == false)) {
				_success(_this, _config.show_id, _config.icon);
			}
			else {
				_error(_this, _config.show_id, _config.show_error);
			}
		break;
	}
}
$.fn.pe_submit = function(my_config, form_id) {
	//绑定提交按钮验证
	var _this = this;
	_this.bind('click', function(){
		var submit_result = true;
		var k;
		for (k in my_config) {
			$(":input[name='"+my_config[k].name+"']").removeAttr('pe_result');
		}
		for (k in my_config) {
			_core(my_config[k]);
			if ($(":input[name='"+my_config[k].name+"']").attr('pe_result') == 'false') {
				submit_result = false;
			}
		}
		if (typeof(form_id) == "function") {
			if (submit_result == true) form_id();
			return false;
		}
		//如果是submit
		if (_this.attr("type") == 'submit') {
			return submit_result;
		}
		//如果是button
		else {
			if (submit_result == true) {
				$("#"+form_id).submit();
			}
		}
	})
	//绑定每个表单验证
	var k;
	for (k in my_config) {
		var _config = my_config[k];
		$(":input[name='"+_config.name+"']").bind('change', function() {
			$(this).removeAttr("pe_result");
		});
		$(":input[name='"+_config.name+"']").bind(_config.act, {'_config':_config}, function(event) {
			_core(event.data._config);
		})
	}
}
})(jQuery);