/*
 * 名称：puyuetianUI前端框架 js驱动
 * 更新：2019-03-24
 * 作者：蒲乐天
 * 官网：http://www.hadsky.com
 */

//puyuetianJS 创建驱动框架
//puyuetianJS 创建驱动div
$(function() {
	$('body').append('<div id="pk-dd" class="pk-hide"></div><iframe id="pk-di" name="pk-di" class="pk-hide"></iframe>');
	//防止CSRF攻击
	var $forms = $('form');
	if($forms.length && typeof($_USER) != "undefined") {
		for(var i = 0; i < $forms.length; i++) {
			var $formaction = $($forms[i]).attr('action');
			if($formaction) {
				$formaction.indexOf('?') == -1 ? $formaction += '?' : $formaction += '&';
				$($forms[i]).attr('action', $formaction + 'chkcsrfval=' + $_USER['CHKCSRFVAL']).prepend('<input type="hidden" name="chkcsrfval" value="' + $_USER['CHKCSRFVAL'] + '">');
			}
		}
	}
	//加载图片
	ImageLaterLoading('img', '懒加载过来的图片^o^', 'this.src="template/default/img/imageloaderror.png";this.title="此图已被汪星人给吃了~汪呜汪呜~~~";this.onclick=""');
	ImageOnerrorClear('img');
});

//dom加载好后执行js语句或语句块
function pk(code) {
	setTimeout(function() {
		switch(typeof code) {
			case "function":
				return code();
				break;
			case "string":
				return eval(code);
				break;
			default:
				return false;
		}
	}, 0);
}

//javascript去掉空格函数
function trim($str) {
	return $str.replace(/(^\s*)|(\s*$)/g, "");
}

//添加收藏函数
function addfavor($title, $url) {
	if(!$title) $title = document.title;
	if(!$url) $url = document.URL;
	try {
		window.external.addFavorite($url, $title);
	} catch(e) {
		alert('添加收藏失败,请使用Ctrl+D进行添加');
	}
}

//按name全选或全不选
function choosecheckbox($name, $checked) {
	var $c = document.getElementsByTagName('input');
	for(i = 0; i < $c.length; i++) {
		if($c[i].name == $name) {
			$c[i].checked = $checked;
		}
	}
}

function showdivframe($id) {
	var $d = document.getElementById($id);
	var $w = window.screen.availWidth;
	var $h = window.screen.availHeight;
	var $t = parseInt(($h / 2) - (($d.offsetHeight) / 2));
	var $l = parseInt(($w / 2) - (($d.offsetWidth) / 2));
	//alert($t);
	$d.style.top = $t + 'px';
	$d.style.left = $l + 'px';
	$d.style.visibility = 'visible';
	//$d.style.display = '';
}

function hiddendivframe($id) {
	document.getElementById($id).style.visibility = 'hidden';
	//document.getElementById($id).style.display = 'none';
}

//获取get参数
function $_GET($paramname, $url) {
	var $a, $i;
	var $param = new Array();
	if(!$url) {
		$url = document.URL;
	}
	var $spos = $url.indexOf('?');
	if($spos != -1 && ($spos + 1) != $url.length) {
		var $params = $url.substring($spos + 1, $url.length).split('&');
		for($i = 0; $i < $params.length; $i++) {
			$a = $params[$i].split('=');
			if($a.length == 2) {
				$param[$a[0]] = $a[1];
			}
		}
		if($paramname) {
			return $param[$paramname];
		} else {
			return $param;
		}
	} else {
		return false;
	}
}

//文字闪闪闪
function TextSSS($id, $hm) {
	$id = document.getElementById($id) || $($id)[0];
	if(!$hm) $hm = 800;
	if($id) setInterval(function() {
		$id.style.opacity == 0 ? $id.style.opacity = 1 : $id.style.opacity = 0;
	}, $hm);
}

function pkalert($content, $title, $jscode, $noautoclose) {
	if($content === false) {
		if(!$title) {
			$('.pk-alert,.pk-alert-bg').remove();
		} else {
			$('#pab-' + $title + ',#pa-' + $title).remove();
		}
	} else {
		var alertid = (Date.parse(new Date()) / 1000) + parseInt(Math.random() * 1000);
		if($content !== null) {
			if(!$noautoclose) {
				$autoclose = ';pkalert(false,' + alertid + ');';
			} else {
				$autoclose = '';
			}
			$('body').append('<div id="pab-' + alertid + '" class="pk-alert-bg"></div><div id="pa-' + alertid + '" class="pk-alert"><div class="pk-alert-box"><div class="pk-alert-head">提示</div><div class="pk-alert-body"></div><div class="pk-alert-foot"><a class="pk-btn pk-btn-primary pk-radius-2" onclick="pkalert(false,' + alertid + ')">确定</a><a class="pk-btn pk-btn-danger pk-radius-2" style="margin-left:15px;display:none;" onclick="pkalert(false,' + alertid + ')">取消</a></div></div></div>');
			$('#pa-' + alertid + ' .pk-alert-body').html($content);
			if($title) {
				if($title.substr(0, 3) == 'js:') {
					$('#pa-' + alertid + ' .pk-alert-foot a:eq(0)').attr('onclick', $title.substr(3) + $autoclose);
				} else {
					$('#pa-' + alertid + ' .pk-alert-head').html($title);
				}
			}
			if($jscode) {
				$('#pa-' + alertid + ' .pk-alert-foot a:eq(0)').attr('onclick', '');
				if(typeof $jscode == "function") {
					$('#pa-' + alertid + ' .pk-alert-foot a:eq(0)').bind('click', $jscode);
					if(!$noautoclose) {
						$('#pa-' + alertid + ' .pk-alert-foot a:eq(0)').bind('click', function() {
							pkalert(false, alertid);
						});
					}
				} else {
					$('#pa-' + alertid + ' .pk-alert-foot a:eq(0)').attr('onclick', $jscode + $autoclose);
				}
				$('#pa-' + alertid + ' .pk-alert-foot a:eq(1)').css('display', '');
			}
		}
		return alertid;
	}
}

function pktip($content, $type, $seconds, $func) {
	//动态效果毫秒时间
	var dts = 700;
	if($content === false) {
		//关闭tip
		if($type) {
			$('#pt-' + $type).animate({
				"opacity": 0
			}, dts);
			setTimeout(function() {
				$('#pt-' + $type).remove();
			}, dts);
		} else {
			$('.pk-tip').animate({
				"opacity": 0
			}, dts);
			setTimeout(function() {
				$('.pk-tip').remove();
			}, dts);
		}
		return false;
	}
	var alertid = (Date.parse(new Date()) / 1000) + parseInt(Math.random() * 1000);
	$('body').append('<div id="pt-' + alertid + '" class="pk-alert pk-tip" style="opacity:0"><div class="pk-alert-box pk-cursor-pointer pk-margin-0" style="width:100%;-webkit-box-shadow:0 0 15px 5px #777;box-shadow:0 0 15px 5px #777;border-radius:0" onclick="pktip(false,' + alertid + ')"><div class="pk-alert-body pk-text-center" style="padding:10px 0;margin:0;font-size:16px"></div></div></div>');
	//写入图标类型
	if($type) {
		switch($type) {
			case 'success':
				$content = '<span class="fa fa-fw fa-check-circle pk-text-success" style="font-size:18px"></span>' + $content;
				break;
			case 'fail':
				$content = '<span class="fa fa-fw fa-times-circle pk-text-danger" style="font-size:18px"></span>' + $content;
				break;
			case 'warning':
				$content = '<span class="fa fa-fw fa-exclamation-circle pk-text-warning" style="font-size:18px"></span>' + $content;
				break;
			case 'info':
				$content = '<span class="fa fa-fw fa-info-circle pk-text-secondary" style="font-size:18px"></span>' + $content;
				break;
			case 'loading':
				$content = '<span class="fa fa-fw fa-spin fa-spinner" style="font-size:18px"></span>' + $content;
				break;
			default:
				$content = $type + $content;
				break;
		}
	}
	$('#pt-' + alertid + ' .pk-alert-body').html($content);
	//整理tip的大小和位置
	$('#pt-' + alertid).css({
		"width": $('#pt-' + alertid + ' .pk-alert-box').width(),
		"height": $('#pt-' + alertid + ' .pk-alert-box').height(),
		"position": "fixed",
		"left": $(window).width() / 2 - $('#pt-' + alertid + ' .pk-alert-box').width() / 2,
		"top": $(window).height() / 2 - $('#pt-' + alertid + ' .pk-alert-box').height(),
		"z-index": 999999
	});
	//显示tip
	$('#pt-' + alertid).animate({
		"opacity": 1
	}, dts);

	if($seconds !== 0) {
		$seconds = parseInt($seconds) || 1700;
		setTimeout(function() {
			pktip(false, alertid);
			if($func) {
				if(typeof $func == "function") {
					$func();
				} else {
					eval($func);
				}
			}
		}, $seconds + dts);
	}
	return alertid;
}

function TextboxAndCheckbox($textbox, $checkbox) {
	var $regqxs = $($textbox).val();
	var $regarray = new Array();
	$regarray = $regqxs.split(",");
	for(var $i = 0; $i < $regarray.length; $i++) {
		$($checkbox + "[value='" + $regarray[$i] + "']").attr('checked', 'true');
	}
	$($checkbox).click(function() {
		var $regqxs = $($textbox).val();
		var $regarray = new Array();
		$regarray = $regqxs.split(",");
		if(this.checked) {
			//写进注册权限值
			if($regqxs.length > 0) {
				$regqxs += ',' + this.value;
			} else {
				$regqxs = this.value;
			}
			$($textbox).val($regqxs);
		} else {
			//移除注册权限值
			if($regqxs.length > 1) {
				$regqxs = '[hadsky.com]'; //临时填充字符
				for(var $i = 0; $i < $regarray.length; $i++) {
					if($regarray[$i] != this.value) {
						$regqxs += (',' + $regarray[$i]);
					}
				}
				//去掉临时填充的字符
				$regqxs = $regqxs.replace('[hadsky.com],', '');
				$regqxs = $regqxs.replace('[hadsky.com]', '');
			} else {
				$regqxs = $regqxs.replace(this.value, '');
			}
			$($textbox).val($regqxs);
		}
	});
}

//图片延迟加载
function ImageLaterLoading($id, $title, $error) {
	var imageloadings = $($id);
	for(var $i = 0; $i < imageloadings.length; $i++) {
		if($(imageloadings[$i]).data('status') != 'complete' && $(imageloadings[$i]).data('src') && $(imageloadings[$i]).data('src') != imageloadings[$i].src) {
			$(imageloadings[$i]).attr('src', $(imageloadings[$i]).data('src'));
			$(imageloadings[$i]).attr('data-status', 'complete');
			if(!imageloadings[$i].title && $title) {
				$(imageloadings[$i]).attr('title', $title);
			}
			if(!imageloadings[$i].onerror && $error) {
				$(imageloadings[$i]).on('error', function() {
					if(typeof($error) == "undefined") {
						return false;
					} else if(typeof($error) == "string") {
						eval($error);
					} else {
						$error();
					}
				});
			}
		}
	}
}

function ImageOnerrorClear($id, $js) {
	var images = $($id);
	if(!$js) {
		$js = ";this.onerror=''";
	} else {
		$js = ";" + $js;
	}
	for(var $i = 0; $i < images.length; $i++) {
		$(images[$i]).on('error', function() {
			try {
				if(typeof($js) == "undefined") {
					return false;
				} else if(typeof($js) == "string") {
					eval($js);
				} else {
					$js();
				}
			} catch(e) {
				//console.log();
			}
		});
	}
}

function getLocalTime(nS, format) {
	if(nS) {
		var $date = new Date(parseInt(nS) * 1000);
	} else {
		var $date = new Date();
	}
	var $y = $date.getFullYear();
	var $m = $date.getMonth() + 1;
	if($m < 10) {
		$m = '0' + $m;
	}
	var $d = $date.getDate();
	if($d < 10) {
		$d = '0' + $d;
	}
	var $h = $date.getHours();
	if($h < 10) {
		$h = '0' + $h;
	}
	var $i = $date.getMinutes();
	if($i < 10) {
		$i = '0' + $i;
	}
	var $s = $date.getSeconds();
	if($s < 10) {
		$s = '0' + $s;
	}
	if(format) {
		var format2 = '';
		format2 = format.replace('y', $y);
		format2 = format2.replace('m', $m);
		format2 = format2.replace('d', $d);
		format2 = format2.replace('h', $h);
		format2 = format2.replace('i', $i);
		format2 = format2.replace('s', $s);
		return format2;
	} else {
		return $y + '-' + $m + '-' + $d + ' ' + $h + ':' + $i + ':' + $s;
	}
}

function strip_tags($str) {
	return str.replace(/<[^>]+>/g, "");
}

function ImageToBase64(url, w, h) {
	var img, base64data, tw, th, ow, oh;
	tw = 0;
	th = 0;
	var $div = 'pk-div-rnd-' + parseInt(Math.random() * 10000);
	$('body').append('<div class="pk-hide" id="' + $div + '"></div>');
	$('#' + $div).html('<canvas id="pk-canvas-object"></canvas>');
	var canvas = $('#' + $div + ' #pk-canvas-object')[0];
	var ctx = canvas.getContext('2d');
	img = url;
	ow = $(img).width();
	oh = $(img).height();
	$(img).width('');
	$(img).height('');
	if(w) {
		if(w.substr(0, 4) == 'max:') {
			tw = w.substr(4);
			if(tw > img.width) {
				tw = img.width;
			}
		} else if(w.substr(0, 4) == 'min:') {
			tw = w.substr(4);
			if(tw < img.width) {
				tw = img.width;
			}
		} else {
			tw = w;
		}
	}
	if(h) {
		if(h.substr(0, 4) == 'max:') {
			th = h.substr(4);
			if(th > img.height) {
				th = img.height;
			}
		} else if(h.substr(0, 4) == 'min:') {
			th = h.substr(4);
			if(th < img.height) {
				th = img.height;
			}
		} else {
			th = h;
		}
	}
	if(tw || th) {
		if(!tw) {
			tw = (th / img.height) * img.width;
		}
		if(!th) {
			th = (tw / img.width) * img.height;
		}
		canvas.width = tw;
		canvas.height = th;
		ctx.drawImage(img, 0, 0, tw, th);
	} else {
		canvas.width = img.width;
		canvas.height = img.height;
		ctx.drawImage(img, 0, 0);
	}
	base64data = canvas.toDataURL('image/png');
	$('#' + $div).remove();
	$(img).width(ow);
	$(img).height(oh);
	return base64data;
}

function getLocalFileUrl(sourceId) {
	var url, obj;
	if(typeof sourceId == 'object') {
		obj = sourceId;
	} else {
		obj = $(sourceId)[0];
	}
	url = window.URL.createObjectURL(obj.files[0]);
	return url;
}

function LookImage($obj) {
	var $url;
	if(typeof $obj == 'object') {
		$url = $obj.src;
		if($obj.alt == 'emotion') {
			return false;
		}
	} else {
		$url = $obj;
	}
	var $lh = $(window).height();
	$('body').append('<div class="pk-alert-bg"></div><div class="pk-alert pk-padding-15 pk-text-center" style="line-height:' + $lh + 'px;overflow:auto" onclick="pkalert(false)"><img id="pk-lookimage" src="' + $url + '" style="width:auto;height:auto;max-width:none;"></div>');
}

function isJson(obj) {
	var isjson = typeof(obj) == "object" && Object.prototype.toString.call(obj).toLowerCase() == "[object object]" && !obj.length;
	return isjson;
}

function FormDataPackaging($selector) {
	if(typeof $selector == "object") {
		var forminputs = $($selector).find(' :input');
	} else {
		var forminputs = $($selector + ' :input');
	}
	var formstring = '_webos=HadSky';
	for(var i = 0; i < forminputs.length; i++) {
		if($(forminputs[i]).attr('name')) {
			if($(forminputs[i]).attr('type') == 'checkbox' && !$(forminputs[i]).prop('checked')) {
				formstring += '&' + $(forminputs[i]).attr('name') + '=';
			} else {
				formstring += '&' + $(forminputs[i]).attr('name') + '=' + encodeURIComponent(($(forminputs[i]).val() || ''));
			}
		}
	}
	return formstring;
}

function randomString(len, chars) {
	len = len || 16;
	var $chars = !chars ? 'qwertyuiopasdfghjklzxcvbnm0123456789' : chars;
	var maxPos = $chars.length;
	var pwd = '';
	for(i = 0; i < len; i++) {
		pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
	}
	return pwd;
}

//name名称，value值，exptime多少秒后过期，默认1天
function setCookie(name, value, exptime) {
	exptime = parseInt(exptime) || 0;
	if(exptime < 1) {
		exptime = 86400;
	}
	exptime *= 1000;
	var exp = new Date();
	exp.setTime(exp.getTime() + exptime);
	document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
}

function getCookie(name) {
	var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
	if(arr = document.cookie.match(reg))
		return unescape(arr[2]);
	else
		return null;
}

//默认模板公用函数
function postmessagediv($uid) {
	if($uid == $_USER['ID']) {
		pkalert('不能自己给自己发消息');
	} else if(!$uid) {
		pkalert('请登录后再操作');
	} else {
		var $html = '<form name="form_message" target="pk-di" method="post" action="index.php?c=postmessage&uid=' + $uid + '"><div class="pk-row pk-margin-top-10"><div class="pk-w-sm-12 pk-padding-0"><textarea name="content" class="pk-textarea pk-textbox-noshadow pk-radius-4 pk-width-all" maxlength="255" rows="7"></textarea></div></div></form>';
		pkalert($html, '发消息', function() {
			if(trim(form_message.content.value)) {
				var strings = FormDataPackaging('form[name="form_message"]:eq(0)');
				$.post('index.php?c=postmessage&uid=' + $uid, strings, function(data) {
					if(data['state'] == 'ok') {
						pkalert(false);
						pkalert('发送成功');
					} else {
						pkalert(data['msg'] || '未知错误');
					}
				}, 'json');
			} else {
				form_message.content.focus()
			}
		}, true);
		form_message.content.focus();
	}
}

function addfriend($uid) {
	if($_USER['ID'] > 0 && $_USER['ID'] != $uid) {
		window.open('index.php?c=friends&uid=' + $uid + '&type=add', 'pk-di');
		pkalert('添加好友成功！');
	} else {
		if(!($_USER['ID'] > 0)) {
			pkalert('请登录后再操作');
		} else {
			pkalert('不能自己添加自己');
		}
	}
}

function delfriend($uid) {
	pkalert('您确定删除该好友么？', '提示', 'window.open("index.php?c=friends&uid=' + $uid + '&type=del","pk-di");if($_GET("c")=="friends"){$("#message-uid-' + $uid + '").remove();lookmessage(0);}else{pkalert("删除成功！");}');
}

function delread($id, $type, $func) {
	$.getJSON('index.php', {
		c: 'delete',
		table: $type,
		id: $id,
		chkcsrfval: $_USER['CHKCSRFVAL'],
		json: 'yes'
	}, function(data) {
		if(data['state'] == 'ok') {
			if($func) {
				if(typeof $func == "function") {
					$func();
				} else {
					eval($func);
				}
			}
		} else {
			pkalert(data['datas']['msg'] || '未知错误');
		}
	}).error(function(e) {
		console.log(e);
	});
}

function InArray($array, $needle, $_fgf) {
	if(typeof($array) != "object") {
		$array = $array.toString();
		if(!$_fgf) {
			$_fgf = ',';
		}
		$array = $array.split($_fgf);
	}
	$needle = $needle.toString();
	for(i in $array) {
		if($array[i].toString() == $needle) {
			return true;
		}
	}
	return false;
}

//新提示框
var pkpopup = {
	pid: 0,
	speed: 300,
	popup: function(data) {
		this.pid++;
		var _id = "pkpopup_" + this.pid;
		var html = '';
		var btnshtml = '';
		//简单的提示框
		if(typeof(data) == "string" || typeof(data) == "number") {
			data = {
				content: data
			}
		}
		//判断数据是否合法
		if(typeof(data) != "object") {
			return false;
		}
		//判断提示框的类型
		if(typeof(data.type) != "string" && typeof(data.type) != "number") {
			data['type'] = 0;
		}
		if(InArray('alert,0', data.type)) {
			btnshtml = '<a class="pk-popup-submit" href="javascript:">确定</a>';
		} else if(InArray('confirm,input,1,2', data.type)) {
			if(InArray('input,2', data.type)) {
				if(typeof(data.content) == "undefined") {
					data['content'] = '';
				}
				if(data.inputtype == 'textarea') {
					data.content = '<textarea class="pk-popup-input" style="height:136px;border-radius:2px;resize:none">' + data.content + '</textarea>';
				} else {
					data.content = '<input type="text" class="pk-popup-input" value="' + data.content + '">';
				}
			}
			btnshtml = '<a class="pk-popup-submit" href="javascript:">确定</a>&nbsp;&nbsp;<a class="pk-popup-cancel" href="javascript:">取消</a>';
		} else if(InArray('tip,load,3,4', data.type)) {
			btnshtml = '';
		} else {
			btnshtml = data.btnshtml;
		}

		//是否存在遮挡布
		if(data.shade) {
			html += '<div id="' + _id + '_shade" class="pk-popup-shade"></div>';
		}
		//是否存在提交回调函数
		if(typeof(data.submit) == "function") {
			this.func['submit_' + this.pid] = data.submit;
		}
		//是否存在关闭回调函数
		if(typeof(data.close) == "function") {
			this.func['close_' + this.pid] = data.close;
		}
		//是否存在取消回调函数
		if(typeof(data.cancel) == "function") {
			this.func['cancel_' + this.pid] = data.cancel;
		}
		//是否存在加载完成事件函数
		if(typeof(data.complete) == "function") {
			this.func['complete_' + this.pid] = data.complete;
		}
		//加载弹出层
		html += '<div id="' + _id + '" class="pk-popup' + (data.extclass ? (' ' + data.extclass) : '') + '"><div class="pk-popup-head">' + (data.title ? data.title : '提示') + (data.hideclose ? '' : '<i class="pk-popup-close"></i>') + '</div><div class="pk-popup-body pk-popup-icon-' + data.icon + '">' + data.content + '</div><div class="pk-popup-foot">' + btnshtml + '</div></div>';
		$('body:eq(0)').append(html);
		var _pid = this.pid;
		var _data = data;
		//绑定取消事件
		$('#' + _id + ' .pk-popup-cancel').on('click', function() {
			pkpopup.cancel(_pid);
		});
		//绑定关闭事件
		$('#' + _id + ' .pk-popup-close').on('click', function() {
			pkpopup.close(_pid);
		});
		//绑定确认事件，仅确认和输入模式有效
		$('#' + _id + ' .pk-popup-submit').on('click', function() {
			var _value = InArray('input,2', _data.type) ? $('#' + _id + ' .pk-popup-input:eq(0)').val() : false;
			pkpopup.submit(_pid, _value, _data.noclose);
		});
		//load tip层处理
		if(InArray('tip,load,3,4', data.type)) {
			$('#' + _id).css({
				paddingTop: '5px',
				paddingBottom: '5px'
			}).find('.pk-popup-head,.pk-popup-foot').remove();
			if(InArray('load,4', data.type)) {
				$('#' + _id + ' .pk-popup-body').html('<div style="float:left;width:40px;height:40px"><i class="pk-popup-loading"></i></div><div style="float:left;height:40px;line-height:40px">' + (data.content || '正在处理，请稍后...') + '</div>');
			} else {
				if(typeof(data.icon) != "number") {
					$('#' + _id + ' .pk-popup-body').css('min-height', '0');
				}
				if(typeof(data.times) != "number") {
					data.times = 2000;
				}
				if(data.times > 0) {
					setTimeout(function() {
						pkpopup.close(_pid);
					}, data.times);
				}
			}
		}
		//自动屏幕中心
		function _area_func(cs) {
			var _id = cs.id;
			if(!$('#' + _id).length) {
				return false;
			}
			var _w = $(window).outerWidth();
			var _h = $(window).outerHeight();
			var _w2 = $('#' + _id).outerWidth();
			var _h2 = $('#' + _id).outerHeight();
			//内容高度自适应
			var _temp_height = _h2 - $('#' + _id + ' .pk-popup-head').outerHeight() - $('#' + _id + ' .pk-popup-foot').outerHeight() - 2;
			var _temp_height2 = $('#' + _id + ' .pk-popup-body').outerHeight();
			if(cs.minH) {
				$('#' + _id + ' .pk-popup-body').css({
					minHeight: _temp_height + 'px'
				});
			} else {
				if(_temp_height > _temp_height2) {
					$('#' + _id + ' .pk-popup-body').css({
						maxHeight: _temp_height + 'px',
						height: _temp_height + 'px'
					});
				} else {
					$('#' + _id + ' .pk-popup-body').css({
						maxHeight: (_h - _h2 + _temp_height2) + 'px'
					});
				}
			}
			if(!cs.noAuto) {
				_h2 = $('#' + _id).outerHeight();
				$('#' + _id).css({
					top: Cnum((_h - _h2) / 2, 0, false, 0) + 'px',
					left: Cnum((_w - _w2) / 2, 0, false, 0) + 'px'
				});
			}
		}
		//自定义的面积及位置
		var _cs = {
			id: _id
		};
		if(typeof(data.area) == "object") {
			$('#' + _id).css({
				width: data.area[0],
				height: data.area[1],
				top: data.area[2],
				right: data.area[3],
				bottom: data.area[4],
				left: data.area[5]
			});
			if(!data.area[2]) {
				_cs['noAuto'] = false;
				_cs['minH'] = true;
			} else {
				_cs['noAuto'] = true;
			}
		}
		_area_func(_cs);
		//检测窗口变化
		$(window).on('resize', function() {
			_area_func(_cs);
		});
		//拖动事件
		if(!data.nomove) {
			$('#' + _id + ' .pk-popup-head').on('mousedown', function(ev) {
				var This = $(this).parents('div.pk-popup:eq(0)')[0];
				var oevent = ev || event;
				var distanceX = oevent.clientX - This.offsetLeft;
				var distanceY = oevent.clientY - This.offsetTop;
				$(this).on('mousemove', function(ev) {
					var oevent = ev || event;
					var t = oevent.clientY - distanceY;
					var l = oevent.clientX - distanceX;
					var mt = $(window).outerHeight() - $('#' + _id).outerHeight();
					var ml = $(window).outerWidth() - $('#' + _id).outerWidth();
					if(!data.nofixedmove) {
						if(t < 0) {
							t = 0;
						}
						if(t > mt) {
							t = mt;
						}
						if(l < 0) {
							l = 0;
						}
						if(l > ml) {
							l = ml;
						}
					}
					$(This).css({
						top: t,
						left: l
					});
				});
				$(this).on('mouseup', function() {
					$(this).unbind('mousemove mouseup');
				});
			}).css('cursor', 'move');
		}
		//动画，渐渐显示
		$('#' + _id).animate({
			opacity: 1
		}, this.speed);
		//如果输入框，或得焦点
		if(InArray('input,2', data.type)) {
			$('#' + _id + ' .pk-popup-body .pk-popup-input').focus();
		}
		//加载完成调用完成函数
		pkpopup.complete(_pid);
		return this.pid;
	},
	cancel: function(_id) {
		if(typeof(this.func['cancel_' + _id]) == "function") {
			this.func['cancel_' + _id](_id);
		}
		pkpopup.close(_id);
	},
	close: function(_id, _nofunc) {
		if(typeof(_id) == "string" || typeof(_id) == "number") {
			if($('#pkpopup_' + _id + ' .pk-popup-foot .pk-popup-close').hasClass('disabled')) {
				return false;
			}
			$('#pkpopup_' + _id).animate({
				opacity: 0
			}, this.speed);
			var This = this;
			setTimeout(function() {
				$('#pkpopup_' + _id + '_shade,#pkpopup_' + _id).remove();
				if(typeof(This.func['close_' + _id]) == "function" && !_nofunc) {
					This.func['close_' + _id](_id);
				}
			}, this.speed);
		} else if(typeof(_id) == "object") {
			var _t = $(_id).parents('.pk-popup:eq(0)').attr('id');
			if(_t) {
				pkpopup.close(_t.split('_')[1]);
			} else {
				pkpopup.close();
			}
		} else {
			$('.pk-popup,.pk-popup-shade').remove();
		}
	},
	submit: function(_id, _value, _noclose) {
		if($('#pkpopup_' + _id + ' .pk-popup-foot .pk-popup-submit').hasClass('disabled')) {
			return false;
		}
		if(this.func['submit_' + _id]) {
			this.func['submit_' + _id](_id, _value);
		}
		if(!_noclose) {
			pkpopup.close(_id);
		}
	},
	complete: function(_id) {
		if(typeof(_id) == "string" || typeof(_id) == "number") {
			if(typeof(this.func['complete_' + _id]) == "function") {
				this.func['complete_' + _id](_id);
			}
		}
	},
	func: []
}
//弹出精简调用函数
function ppp(data) {
	return pkpopup.popup(data);
}

function Cnum(str, r, i, min, max) {
	if(typeof(r) == "undefined") {
		r = 0;
	}
	if(i) {
		str = parseInt(str);
		if(!str && str !== 0) {
			str = r;
		}
	} else {
		str = parseFloat(str);
		if(!str && str !== 0) {
			str = r;
		}
	}
	if(str < min) {
		str = r;
	}
	if(str > max) {
		str = r;
	}
	return str;
}

function PostMessageBox(data) {
	if(typeof(data) == "number" || typeof(data) == "string") {
		data['uid'] = data;
	}
	if(!Cnum(data.uid, false)) {
		ppp({
			content: '无效的发送目标',
			icon: 2
		});
		return false;
	}
	if(!data.username) {
		data['username'] = 'UID:' + data.uid;
	}
	var _pid = ppp({
		type: 2,
		title: '发送消息给<a class="pk-text-primary pk-hover-underline" target="_blank" href="index.php?c=center&uid=' + data.uid + '">' + data.username + '</a>',
		noclose: true,
		inputtype: 'textarea',
		submit: function(id, v) {
			console.log(v);
			if(!v) {
				ppp({
					type: 3,
					content: "请输入消息的内容",
					icon: 0,
					close: function() {
						$('#pkpopup_' + _pid + ' textarea').focus();
					}
				});
				return false;
			}
			$('#pkpopup_' + id + ' .pk-popup-foot .pk-popup-submit').addClass('disabled').html('正在发送...');
			$.post('index.php?c=postmessage&uid=' + data.uid, {
				content: v,
				chkcsrfval: $_USER['CHKCSRFVAL']
			}, function(data2) {
				if(data2['state'] == 'ok') {
					pkpopup.close(id);
					ppp({
						type: 3,
						content: "发送成功",
						icon: 1
					});
				} else {
					$('#pkpopup_' + id + ' .pk-popup-foot .pk-popup-submit').removeClass('disabled').html('确定');
					ppp({
						type: 3,
						content: data2['msg'],
						icon: 2
					});
				}
			}, 'json');
		}
	});
}

function Interactive(type, uid, This, text) {
	if($(This).hasClass('disabled')) {
		return false;
	}
	$(This).addClass('disabled');
	$.getJSON('index.php?c=center', {
		type: type,
		uid: uid,
		chkcsrfval: $_USER['CHKCSRFVAL']
	}, function(data) {
		if(data['state'] == 'ok') {
			if(type == 'addidol') {
				if($(This).hasClass('_Interactive_btn')) {
					$(This).css('background-color', '#F4606C');
				}
				var h = '';
				if($(This).find('>i').hasClass('fa')) {
					h += '<i class="fa fa-fw fa-unlink"></i>';
				}
				h += (typeof(text) == "undefined" ? '取消关注' : text);
				if($(This).attr('onclick')) {
					$(This).attr('onclick', $(This).attr('onclick').replace("Interactive('addidol'", "Interactive('delidol'"));
				}
				$(This).html(h);
			} else if(type == 'delidol') {
				if($(This).hasClass('_Interactive_btn')) {
					$(This).css('background-color', '#19CAAD');
				}
				var h = '';
				if($(This).find('>i').hasClass('fa')) {
					h += '<i class="fa fa-fw fa-heart"></i>';
				}
				h += (typeof(text) == "undefined" ? '加关注' : text);
				if($(This).attr('onclick')) {
					$(This).attr('onclick', $(This).attr('onclick').replace("Interactive('delidol'", "Interactive('addidol'"));
				}
				$(This).html(h);
			} else if(type == 'addfriend') {
				if($(This).hasClass('_Interactive_btn')) {
					$(This).css('background-color', '#F4606C');
				}
				var h = '';
				if($(This).find('>i').hasClass('fa')) {
					h += '<i class="fa fa-fw fa-trash-o"></i>';
				}
				h += (typeof(text) == "undefined" ? '删除好友' : text);
				if($(This).attr('onclick')) {
					$(This).attr('onclick', $(This).attr('onclick').replace("Interactive('addfriend'", "Interactive('delfriend'"));
				}
				$(This).html(h);
			} else if(type == 'delfriend') {
				if($(This).hasClass('_Interactive_btn')) {
					$(This).css('background-color', '#19CAAD');
				}
				var h = '';
				if($(This).find('>i').hasClass('fa')) {
					h += '<i class="fa fa-fw fa-group"></i>';
				}
				h += (typeof(text) == "undefined" ? '加好友' : text);
				if($(This).attr('onclick')) {
					$(This).attr('onclick', $(This).attr('onclick').replace("Interactive('delfriend'", "Interactive('addfriend'"));
				}
				$(This).html(h);
			} else if(type == 'addcollect') {
				if($(This).hasClass('_Interactive_btn')) {
					$(This).css('background-color', '#F4606C');
				}
				var h = '';
				if($(This).find('>i').hasClass('fa')) {
					h += '<i class="fa fa-fw fa-star-o"></i>';
				}
				h += (typeof(text) == "undefined" ? '取消收藏' : text);
				if($(This).attr('onclick')) {
					$(This).attr('onclick', $(This).attr('onclick').replace("Interactive('addcollect'", "Interactive('delcollect'"));
				}
				$(This).html(h);
			} else if(type == 'delcollect') {
				if($(This).hasClass('_Interactive_btn')) {
					$(This).css('background-color', '#19CAAD');
				}
				var h = '';
				if($(This).find('>i').hasClass('fa')) {
					h += '<i class="fa fa-fw fa-star"></i>';
				}
				h += (typeof(text) == "undefined" ? '收藏文章' : text);
				if($(This).attr('onclick')) {
					$(This).attr('onclick', $(This).attr('onclick').replace("Interactive('delcollect'", "Interactive('addcollect'"));
				}
				$(This).html(h);
			}
		}
		ppp({
			type: 3,
			content: data['datas']['msg'],
			icon: (data['state'] == 'ok' ? 1 : 2)
		});
		$(This).removeClass('disabled');
	}).error(function(e) {
		console.log(e);
	});
}

$(function() {
	//会返回弹出框的识别id，=pid
	/*
		var pid = ppp({
			type: false, //alert|0提示框（默认），confirm|1确认框，input|2输入框，tip|3提示框，load|4加载框，pk521|5自定义
			title: false, //提示框的标题，默认值为“提示”
			content: '你好世界', //提示框的内容
			area: false, //面积及位置，格式举例["100%","500px","20%","0","0","35%"]，[宽,高,上,右,下,左]，默认自适应
			extclass: false, //自定义的class样式，字符串类型，默认无
			shade: false, //是否显示遮挡层，false不显示（默认），true显示
			noclose: false, //点击确认后是否自动关闭提示框，true不关闭，false关闭（默认）
			nomove:false, //是关闭拖动，true关闭，false开启（默认）
			nofixedmove:false, //是否关闭限制拖动范围，true关闭，false开启（默认）
			inputtype: false, //input单行（默认），textarea多行
			hideclose: false, //是否隐藏右上方的关闭按钮，true隐藏，false不隐藏（默认）
			times: false, //提示框显示的时间，毫秒，默认值2000，0为不自动关闭
			icon: false, //提示框和确认框是否显示图标，默认不显示，0信息，1成功，2失败，3疑问
			btnshtml: false, //自定义的按钮，仅在type为自定义时有用，举例：<a href="#">按钮</a>
			submit: function(id, value) {
				//id为弹出框的id编号，为数字，若id=1，则弹出框的id="pkpopup_1"，遮挡层id="pkpopup_1_shade"
				//仅下方type起作用
				//confirm框，确认后回调的函数
				//input框，输入后回调的函数，value为输入的值
			},
			cancel: function(id) {
				//关闭或取消后调用的函数
			},
			close: function(id) {
				//关闭或取消后调用的函数
			},
			complete: function(id) {
				//提示框弹出后调用的函数，一般用于自定义按钮的事件定义
			}
		});
		//关闭已开的弹出框，未指定id则关闭所有
		//pkpopup.close(id)
	*/
});