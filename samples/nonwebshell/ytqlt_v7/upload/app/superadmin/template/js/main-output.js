if((!top.Code_Powered || top.Code_Powered.toLowerCase().replace('powe', 'h').replace('red by had', '').replace('sky', 's') != 'hs') && $_GET('s') != 'appdownload') {
	var x = document.getElementsByTagName("html")[0];
	x.remove(x.selectedIndex);
}
var submitReturn = false;
$(function() {
	//url事件处理
	var odata = decodeURIComponent($_GET('OData', top.location.href) || '');
	if(odata && top.OData != odata) {
		top.OData = odata;
		odata = JSON.parse(odata);
		var _url = odata.url;
		if(_url && !$_GET('urled')) {
			location.href = _url.indexOf('?') == -1 ? _url + '?urled=1' : _url + '&urled=1';
		}
	}
	//操作提示
	if($_GET('pkalert') == 'show') {
		top.ppp({
			type: 3,
			icon: 1,
			content: decodeURIComponent($_GET('alert'))
		});
	}
	//保存按钮事件
	$('#SubmitBtn').css('display', 'inline-block').click(function() {
		var This = $(this);
		var jsbefore = This.data('before');
		var jsafter = This.data('after');
		if(jsbefore) {
			try {
				if(typeof(jsbefore) == "function") {
					jsbefore();
				} else {
					eval(jsbefore);
				}
			} catch(e) {
				console.log(e);
			}
		}
		if(submitReturn) {
			return;
		}
		var obj = This.prop('disabled', true).html('<span class="fa fa-fw fa-spin fa-spinner"></span>处理中...').parents('form:eq(0)');
		var strings = FormDataPackaging(obj);
		var _action = $_GET('json', obj.attr('action')) ? obj.attr('action') : obj.attr('action') + (obj.attr('action').indexOf('?') == -1 ? '?' : '&') + 'json=yes';
		$.post(_action, strings, function(data) {
			if(data['state'] == 'ok') {
				//console.log(data);
				//安装应用，隐藏安装应用的初始设置
				var iframes = $('iframe.pk-hide[src*=":install"]');
				for(var i = 0; i < iframes.length; i++) {
					var _src = $(iframes[i]).attr('src');
					$.get(_src, function(data) {
						console.log('应用安装完成：' + _src);
						//console.log(data);
					});
				}
				ppp({
					type: 3,
					icon: 1,
					content: data['datas']['msg']
				});
			} else {
				ppp({
					icon: 2,
					content: (data['datas']['msg'] || '未知错误')
				});
			}
			This.prop('disabled', false).html('保存');
		}, 'json');
		//console.log(strings);
		if(jsafter) {
			try {
				if(typeof(jsafter) == "function") {
					jsafter();
				} else {
					eval(jsafter);
				}
			} catch(e) {
				console.log(e);
			}
		}
		if(submitReturn) {
			return;
		}
	});
	//保存按钮浮动
	var _obj = $('form[name="form_save"]>div:last').find('button');
	if(_obj.length > 0) {
		var l = _obj.offset().left;
		_obj.parent('div').css({
			position: 'fixed',
			bottom: 0,
			left: 0,
			textAlign: 'left',
			width: '100%',
			padding: '10px 15px 10px ' + l + 'px',
			borderTop: 'solid 1px #ccc',
			backgroundColor: '#eee',
			zIndex: 777
		});
		$('form[name="form_save"]').append('<div style="width:100%;height:' + _obj.parent('div').outerHeight() + 'px"></div>');
	}
	//select选择
	var $selects = $('select');
	for(var $i = 0; $i < $selects.length; $i++) {
		$('select[name="' + $($selects[$i]).attr('name') + '"] option[value="' + $($selects[$i]).data('value') + '"]').prop('selected', true);
	}
	//美化选择按钮
	(function() {
		var kqgb = '开启,关闭,启用,禁用,打开'.split(',');
		var kq = '开启,启用,打开';
		var gb = '关闭,禁用';
		for(var $i = 0; $i < $selects.length; $i++) {
			var _a = $($selects[$i]).find('option');
			//console.log(_a);
			if(_a.length == 2) {
				if(kqgb.indexOf($(_a[0]).html()) != -1 && kqgb.indexOf($(_a[1]).html()) != -1) {
					var _html = '<div id="pyt-toggle-' + $i + '" data-id="' + $($selects[$i]).attr('id') + '" data-name="' + $($selects[$i]).attr('name') + '"><i class="fa fa-toggle-on pk-hide" data-target="' + gb + '" style="color:#0c3"></i><i class="fa fa-toggle-off pk-hide" data-target="' + kq + '" style="color:#777"></i></div>';

					//写入pk-toggle
					$($selects[$i]).addClass('pk-hide').parent().append(_html);
					//pk-toggle大小设置
					var _w = $($selects[$i]).width(),
						_h = $($selects[$i]).height();
					$('#pyt-toggle-' + $i).css({
						'width': _w,
						'height': _h
					});
					$('#pyt-toggle-' + $i + '>i').css({
						'width': _h,
						'height': _h,
						'font-size': _h,
						'cursor': 'pointer'
					});
					//选择pk-toggle
					if(kq.indexOf($($selects[$i]).find('option:selected').html()) != -1) {
						$('#pyt-toggle-' + $i + '>i:eq(0)').removeClass('pk-hide');
					} else if(gb.indexOf($($selects[$i]).find('option:selected').html()) != -1) {
						$('#pyt-toggle-' + $i + '>i:eq(1)').removeClass('pk-hide');
					} else {
						if(kq.indexOf($($selects[$i]).find('option:eq(0)').html()) != -1) {
							$('#pyt-toggle-' + $i + '>i:eq(0)').removeClass('pk-hide');
						} else {
							$('#pyt-toggle-' + $i + '>i:eq(1)').removeClass('pk-hide');
						}
					}
					$('#pyt-toggle-' + $i + '>i').click(function() {
						var _p = $(this).parent(),
							_t = $(this).data('target').split(','),
							_s;
						if(_p.data('id') && _p.data('id') != 'undefined') {
							_s = $('#' + _p.data('id'));
						} else if(_p.data('name') && _p.data('name') != 'undefined') {
							_s = $('select[name="' + _p.data('name') + '"]');
						} else {
							_s = _p.parent().find('select:eq(0)');
						}
						//console.log(_s);
						for(var $_i = 0; $_i < 2; $_i++) {
							var _o = _s.find('option:eq(' + $_i + ')');
							if(_t.indexOf(_o.html()) != -1) {
								_o.prop('selected', true);
								_p.find('i[class*="pk-hide"]').removeClass('pk-hide');
								$(this).addClass('pk-hide');
								//alert(_s.val());
								return true;
							}
						}
					});
				}
			}
		}
	})();
	//添加返回按钮
	if(document.referrer && document.referrer != top.location.href && document.referrer != location.href && !$_GET('pkpopup')) {
		$('#app-superadmin-backbtn').removeClass('pk-hide');
	}
	//加载html可视模式编辑器
	_navinit();
	//加载codemirror
	var codeMirrorObjs = $('textarea._codemirrorbox'),
		codeMirrors = [];
	//console.log(codeMirrorObjs.length);
	for(var i = 0; i < codeMirrorObjs.length; i++) {
		codeMirrors[i] = CodeMirror.fromTextArea(codeMirrorObjs[i], {
			lineNumbers: true, //是否显示行号
			mode: "htmlmixed",
			smartIndent: true, // 是否智能缩进
			lineWrapping: true, //是否强制换行
		});
	}
	//自动同步数据
	setInterval(function() {
		for(var i = 0; i < codeMirrors.length; i++) {
			$(codeMirrorObjs[i]).val(codeMirrors[i].getValue());
		}
	}, 200);
	//加载标签编辑器
	var a = $('input._labelsbox[name!=""]');
	for(var i = 0; i < a.length; i++) {
		var v = $(a[i]).attr('type', 'hidden').val();
		$(a[i]).after('<div id="_labelsbox_' + a[i].name + '" class="_labelsbox"></div>');
		labelsinit(a[i].name);
	}
});

var _VNEB = [];

function _navinit(name1, value1, query) {
	if(name1) {
		var a = $('textarea[name="' + name1 + '"]');
		var b = true;
	} else {
		var a = $('textarea._visualnaveditbox[name!=""]');
		var b = false;
	}
	for(var i = 0; i < a.length; i++) {
		var html = '';
		if(!name1) {
			var name = a[i].name;
			var value = a[i].value;
			query = $(a[i]).data('query') || '>a';
			html += '<div id="vneb_' + name + '" data-name="' + name + '" class="naveditbox">';
			html += '<div class="_toolbtns" style="padding-bottom:5px"><button type="button" class="pk-btn pk-btn-xs pk-btn-success" style="border-top-right-radius:0;border-bottom-right-radius:0">可视模式</button><button type="button" class="pk-btn pk-btn-xs pk-btn-danger" style="border-top-left-radius:0;border-bottom-left-radius:0" disabled>源码模式</button></div>';
			html += '<div class="_source"><textarea class="pk-textarea" rows="7" name="' + name + '"></textarea></div>';
			html += '<div class="_visual pk-hide">';
			html += '<table class="pk-table pk-table-bordered">';
			html += '<thead><tr><th>名称</th><th class="pk-hide-sm" style="width:90px;text-align:center">打开方式</th><th class="pk-hide-sm" style="width:360px">链接地址</th><th style="width:180px;text-align:center">操作</th></tr></thead>';
			html += '<tbody></tbody>';
			html += '<tfoot><tr><td colspan="99" style="text-align:right"><button type="button" class="pk-btn pk-btn-xs pk-btn-white" onclick="_navaddoredit(\'' + name + '\',false,\'' + query + '\')">添加</button></td></tr></tfoot>';
			html += '</table>';
			html += '</div>';
			html += '</div>';
			$(a[i]).before(html).remove();
			//切换按钮query
			$('#vneb_' + name + ' ._toolbtns button').data('query', query);
			//赋值
			$('#vneb_' + name).find('textarea[name="' + name + '"]').val(value);
			//切换事件
			$('#vneb_' + name).find('._toolbtns button').on('click', function() {
				var obj = $(this).parents('div.naveditbox:eq(0)');
				var name = obj.data('name');
				var query = $(this).data('query');
				if(obj.find('._visual').hasClass('pk-hide')) {
					var value = $('#vneb_' + name + ' textarea[name="' + name + '"]').val();
					var nv = value.replace(/<[^<>]+>/g, ""),
						_nv = '';
					var cs = $('<div>' + value + '</div>').find(query);
					for(var _i = 0; _i < cs.length; _i++) {
						_nv += $(cs[_i]).text();
					}
					if(nv.replace(/[\r\n\t\s]/g, "") != _nv.replace(/[\r\n\t\s]/g, "")) {
						ppp({
							type: 3,
							icon: 2,
							content: "<p>源代码语法有误，无法完成可视化转换</p>" + nv + "<p>" + _nv + "</p>"
						});
						return false;
					}
					_VNEB[name] = $('<div>' + value + '</div>');
					_navinit(name, value, query);
				}
				obj.find('._toolbtns button').prop('disabled', false);
				$(this).prop('disabled', true);
				obj.find('._visual,._source').toggleClass('pk-hide');
			});
			$('#vneb_' + name).find('._toolbtns button:eq(0)').click();
		} else {
			if(!query) {
				query = '>a';
			}
			var name = name1;
			var value = value1;
			var _a = $('<div>' + value + '</div>').find(query);
			for(var _i = 0; _i < _a.length; _i++) {
				html += '<tr>';
				html += '<td>' + $(_a[_i]).html() + '</td>';
				html += '<td class="pk-hide-sm" style="text-align:center">' + ($(_a[_i]).attr('target') ? '新窗口' : '默认') + '</td>';
				html += '<td class="pk-hide-sm pk-word-break-all"><a class="pk-text-primary pk-hover-underline" target="_blank" href="' + $(_a[_i]).attr('href') + '">' + $(_a[_i]).attr('href') + '</a></td>';
				html += '<td style="text-align:center"><button type="button" class="pk-btn pk-btn-xs pk-btn-secondary" onclick="_navupordown(\'' + name + '\',\'up\',' + _i + ',\'' + query + '\')" style="border-radius:0;border-top-left-radius:2px;border-bottom-left-radius:2px">上移</button><button type="button" class="pk-btn pk-btn-xs pk-btn-secondary" onclick="_navupordown(\'' + name + '\',\'down\',' + _i + ',\'' + query + '\')" style="border-radius:0">下移</button><button type="button" class="pk-btn pk-btn-xs pk-btn-success" onclick="_navaddoredit(\'' + name + '\', ' + _i + ',\'' + query + '\')" style="border-radius:0">编辑</button><button type="button" class="pk-btn pk-btn-xs pk-btn-danger" onclick="_navdel(\'' + name + '\', ' + _i + ',\'' + query + '\')" style="border-radius:0;border-top-right-radius:2px;border-bottom-right-radius:2px">删除</button></td>';
				html += '</tr>';
			}
			$('#vneb_' + name + ' tbody').html(html);
			$('#vneb_' + name + ' textarea[name="' + name + '"]').val(value);
		}
	}
}

function _navaddoredit(name, index, query) {
	if(!query) {
		query = '>a';
	}
	index = Cnum(index, false, true, 0);
	var obj = $('#vneb_' + name);
	var ds = 'height:38px;line-height:38px;position:relative;padding-left:100px;margin-bottom:10px',
		ss = 'position:absolute;top:0;left:0;width:90px;height:38px;line-height:38px;text-align:right';
	var html = '<div style="' + ds + '"><span style="' + ss + '">名称</span><input type="text" class="pk-textbox _title" placeholder="必填"></div>';
	html += '<div style="' + ds + '"><span style="' + ss + '">链接</span><input type="text" class="pk-textbox _href"></div>';
	html += '<div style="' + ds + '"><span style="' + ss + '">打开方式</span><select class="pk-textbox _target"><option value="">默认</option><option value="_blank">新窗口</option></select></div>';
	html += '<div style="' + ds + '"><span style="' + ss + '">class</span><input type="text" class="pk-textbox _class" placeholder="选填"></div>';
	html += '<div style="' + ds + '"><span style="' + ss + '">onclick</span><textarea class="pk-textarea _onclick" placeholder="选填" style="max-width:100%;line-height:18px" rows="4"></textarea></div>';
	ppp({
		type: 1,
		title: index === false ? '添加' : '编辑',
		area: $(window).width() < 1000 ? ['100%', '100%'] : ['600px', '400px'],
		content: html,
		shade: 1,
		submit: function(id) {
			var o = $('#pkpopup_' + id + ' .pk-popup-body');
			if(index === false) {
				var rnd = '_' + randomString(7);
				$('body').append('<a id="' + rnd + '"></a>');
				$('#' + rnd).attr({
					href: o.find('._href').val(),
					class: o.find('._class').val(),
					target: o.find('._target').val(),
					onclick: o.find('._onclick').val()
				}).html(o.find('._title').val());
				var _v = $('#' + rnd)[0].outerHTML;
				$('#' + rnd).remove();
				var _v1 = '',
					_v2 = '';
				_v = _v.replace(' id="' + rnd + '"', '');
				_q = trim(query.replace(/>/g, ' '));
				if(_q != 'a') {
					_q = _q.split(' ');
					for(var i = 0; i < _q.length; i++) {
						if(_q[i] == 'a') {
							continue;
						}
						_v1 = '<' + _q[i] + '>';
						_v2 = '</' + _q[i] + '>';
					}
				}
				_VNEB[name].append(_v1 + _v + _v2);
			} else {
				_VNEB[name].find(query + ':eq(' + index + ')').attr({
					href: o.find('._href').val(),
					class: o.find('._class').val(),
					target: o.find('._target').val(),
					onclick: o.find('._onclick').val()
				}).html(o.find('._title').val());
			}
			_navinit(name, _VNEB[name].html(), query);
		},
		complete: function(id) {
			var o = $('#pkpopup_' + id + ' .pk-popup-body');
			if(index !== false) {
				var _o = _VNEB[name].find(query + ':eq(' + index + ')');
				o.find('._href').val(_o.attr('href'));
				o.find('._class').val(_o.attr('class'));
				o.find('._target').val(_o.attr('target'));
				o.find('._onclick').val(_o.attr('onclick'));
				o.find('._title').val(_o.html());
			}
		}
	});
}

function _navupordown(name, ud, index, query) {
	if(!query) {
		var q = '>a';
	} else {
		var q = trim(query.replace(/>/g, ' ')).split(' ');
		q = '>' + q[0];
	}
	var o = _VNEB[name].find(q + ':eq(' + index + ')');
	var h = o[0].outerHTML;
	if(ud == 'up') {
		if(index == 0) {
			return false;
		}
		o.prev().before(h);
	} else {
		if(index == _VNEB[name].find(q).length - 1) {
			return false;
		}
		o.next().after(h);
	}
	o.remove();
	_navinit(name, _VNEB[name].html(), query);
}

function _navdel(name, index, query) {
	ppp({
		type: 1,
		icon: 3,
		content: "确认删除该项[" + index + "]?",
		submit: function() {
			if(!query) {
				var q = '>a';
			} else {
				var q = trim(query.replace(/>/g, ' ')).split(' ');
				q = '>' + q[0];
			}
			_VNEB[name].find(q + ':eq(' + index + ')').remove();
			_navinit(name, _VNEB[name].html(), query);
		}
	});
}

function labelsinit(name) {
	var v = $('input._labelsbox[name="' + name + '"]').val();
	var tip = $('input._labelsbox[name="' + name + '"]').attr('placeholder') || '添加';
	var vs = v.split(',');
	//去重
	var temp = []; //一个新的临时数组
	for(var i = 0; i < vs.length; i++) {
		if(temp.indexOf(vs[i]) == -1) {
			temp.push(vs[i]);
		}
	}
	if(temp != vs) {
		vs = temp;
		v = '';
		for(var i = 0; i < vs.length; i++) {
			v += ',' + vs[i];
		}
		v = v.substr(1);
		$('input._labelsbox[name="' + name + '"]').val(v);
	}
	var o = $('#_labelsbox_' + name);
	o.html('');
	for(var i = 0; i < vs.length; i++) {
		//去空
		if(!vs[i]) {
			continue;
		}
		o.append('<div data-name="' + name + '" data-index="' + i + '"><i data-ud="up" title="前移" class="pk-text-success">&lang;</i><span title="编辑">' + vs[i] + '</span><i class="pk-text-danger" title="删除"><i class="fa fa-trash-o"></i></i><i data-ud="down" title="前移" class="pk-text-success">&rang;</i></div>');
		var _o = o.find('>div:last');
		//移动事件
		_o.find('>i:eq(0),>i:last').on('click', function() {
			var name = $(this).parent().data('name');
			var index = $(this).parent().data('index');
			var v = $('input._labelsbox[name="' + name + '"]').val();
			var vs = v.split(',');
			if($(this).data('ud') == 'up') {
				if(index == 0) {
					return false;
				}
				vs[index] = vs.splice(index - 1, 1, vs[index])[0];
			} else {
				if(index == vs.length - 1) {
					return false;
				}
				vs[index] = vs.splice(index + 1, 1, vs[index])[0];
			}
			v = '';
			for(var i = 0; i < vs.length; i++) {
				v += ',' + vs[i];
			}
			$('input._labelsbox[name="' + name + '"]').val(v.substr(1));
			labelsinit(name);
		});
		//删除事件
		_o.find('>i:eq(1)').on('click', function() {
			var name = $(this).parent().data('name');
			var index = $(this).parent().data('index');
			var v = $('input._labelsbox[name="' + name + '"]').val();
			var vs = v.split(',');
			vs.splice(index, 1);
			v = '';
			for(var i = 0; i < vs.length; i++) {
				v += ',' + vs[i];
			}
			$('input._labelsbox[name="' + name + '"]').val(v.substr(1));
			labelsinit(name);
		});
		//编辑事件
		_o.find('>span:eq(0)').on('click', function() {
			var name = $(this).parent().data('name');
			var index = $(this).parent().data('index');
			var v = $('input._labelsbox[name="' + name + '"]').val();
			var _v = $(this).parent().find('span').html();
			var vs = v.split(',');
			ppp({
				type: 2,
				title: "编辑",
				noclose: 1,
				submit: function(id, value) {
					if(!trim(value)) {
						$('#pkpopup_' + id + ' .pk-popup-input').focus();
						return false;
					}
					vs[index] = value.replace(/,/g, '，');
					v = '';
					for(var i = 0; i < vs.length; i++) {
						v += ',' + vs[i];
					}
					$('input._labelsbox[name="' + name + '"]').val(v.substr(1));
					labelsinit(name);
					pkpopup.close(id);
				},
				complete: function(id) {
					$('#pkpopup_' + id + ' .pk-popup-input').val(vs[index]);
				}
			});
		});
	}
	//添加事件
	o.append('<div data-name="' + name + '">新添加</div>');
	o.find('>div:last').on('click', function() {
		var name = $(this).data('name');
		var v = $('input._labelsbox[name="' + name + '"]').val();
		console.log(v);
		ppp({
			type: 2,
			title: tip,
			noclose: 1,
			submit: function(id, value) {
				if(!trim(value)) {
					$('#pkpopup_' + id + ' .pk-popup-input').focus();
					return false;
				}
				v += ',' + value.replace(/,/g, '，');
				if(v.substr(0, 1) == ',') {
					v = v.substr(1);
				}
				$('input._labelsbox[name="' + name + '"]').val(v);
				labelsinit(name);
				pkpopup.close(id);
			}
		});
	});
}

function labelStrSwitch(o, s, t, b, a) {
	var str = $(o).val();
	if(t) {
		str = str.replace(/,/g, s);
		if(b && str) {
			str = b + str;
		}
		if(a && str) {
			str = str + a;
		}
	} else {
		if(b) {
			if(str.indexOf(b) === 0) {
				str = str.substr(b.length);
			}
		}
		if(a) {
			if(str.lastIndexOf(a) === str.length - a.length) {
				str = str.substr(0, str.length - a.length);
			}
		}
		var re = new RegExp(s, "g");
		str = str.replace(re, ',');
		str = str.replace(/[,]+/g, ',');
		if(str[0] == ',') {
			str = str.substr(1);
		}
		if(str[str.length - 1] == ',') {
			str = str.substr(0, str.length - 1);
		}
	}
	$(o).val(str);
}

function apiUrl(url, nocache) {
	return "index.php?c=app&a=superadmin:index&s=api&url=" + encodeURIComponent(url) + '&nocache=' + (nocache ? 1 : 0);
}

function openIframe(url, title) {
	var _tmpstyle_h = $('html').css('overflow-y');
	var _tmpstyle_b = $('body').css('overflow-y');
	ppp({
		title: title,
		content: '<iframe src="' + url + '&pkpopup=1" style="width:100%;height:100%;border:0;overflow-y:scroll"></iframe>',
		area: ['100%', '100%', '0', '0', '0', '0'],
		nomove: 1,
		complete: function(id) {
			$('#pkpopup_' + id + ' .pk-popup-body,body').css('overflow-y', 'hidden');
			$('#pkpopup_' + id).css({
				paddingBottom: 0
			}).find('.pk-popup-foot').addClass('pk-hide');
			$('#pkpopup_' + id + ' .pk-popup-body').css({
				maxHeight: ''
			});
		},
		close: function() {
			$('html').css('overflow-y', _tmpstyle_h);
			$('body').css('overflow-y', _tmpstyle_b);
		}
	});
}

var localdata = false,
	clouddata = false,
	pagecount = 1;

function loadAppstoreInit() {
	if(!localdata || !clouddata) {
		localdata = $('#appTable').data('local') || [];
		clouddata = $('#appTable').data('cloud') || [];
		if(clouddata.state != 'ok') {
			$('#appTable tbody').html('<tr><td colspan="99" class="pk-text-center">' + clouddata.data + '</td></tr>');
			return false;
		}
		pagecount = Cnum(clouddata.pagecount, 1, true, 1);
		clouddata = clouddata.data;
	}
	var html = '';
	var apps = [];
	//console.log(clouddata);
	for(var i in clouddata) {
		var _d = clouddata[i];
		apps.push(_d['dir']);
		var btns = '';
		if(_d.downloaded) {
			btns += ' 已下载 ';
		} else {
			btns += '<a class="pk-text-danger pk-hover-underline' + (_d.purchased ? ' pk-hide' : '') + '" href="javascript:" data-v="purchase"> 购买 </a>';
			btns += '<a class="pk-text-primary pk-hover-underline' + (_d.purchased ? '' : ' pk-hide') + '" href="javascript:" data-v="download"> 下载 </a>';
		}
		html += '<tr id="_app_' + _d['dir'] + '" data-key="' + i + '"><td><div class="_title" style="background-image:url(' + _d['iconbase64'] + ');padding-left:25px">' + _d['title'] + '</div></td><td class="pk-hide-sm pk-text-center">' + _d['version'] + '</td><td class="pk-hide-sm">' + _d['description'] + '</td><td class="pk-text-center">' + _d['mprice'] + '<br>' + _d['yprice'] + '<br>' + _d['lprice'] + '</td><td class="pk-hide-sm pk-text-center"><a class="pk-text-primary pk-hover-underline" href="javascript:" onclick="var uid=' + _d['uid'] + ';if(uid!=1){window.open(\'https://www.hadsky.com/center-\'+uid+\'.html\')}">' + _d['source'] + '</a></td><td class="pk-text-center _btns" data-dir="' + _d['dir'] + '" data-version="' + _d['version'] + '">' + btns + '</td></tr>';
		$('#appTable tbody').html(html);
		$('#appTable ._btns a').on('click', function() {
			var v = $(this).data('v');
			var p = $(this).parent();
			var dir = p.data('dir');
			var version = p.data('version');
			var title = $(this).parents('tr').find('._title').text();
			var key = $(this).parents('tr').data('key');
			switch(v) {
				case 'download':
					appDownload(dir, version);
					break;
				case 'purchase':
					appPurchaseBox(dir);
					break;
			}
		});
	}
}

function loadAT() {
	if(!localdata || !clouddata) {
		localdata = $('#appTable').data('local') || [];
		clouddata = $('#appTable').data('cloud') || [];
	}
	var html = '',
		type = $_URI['TYPE'],
		apps = [];
	//console.log(localdata);
	for(var i in localdata) {
		var _d = localdata[i];
		apps.push(_d['dir']);
		var btns = '';
		if(_d.install) {
			btns += '<a class="pk-text-success pk-hover-underline" href="javascript:" data-v="install"> 安装 </a>';
		} else {
			if(_d.setting) {
				btns += '<a class="pk-text-primary pk-hover-underline" href="javascript:" data-v="setting"> 设置 </a>';
			}
			btns += '<a class="pk-text-danger pk-hover-underline" href="javascript:" data-v="uninstall"> 卸载 </a>';
		}
		html += '<tr id="_app_' + _d['dir'] + '" data-key="' + i + '"><td><div class="_title" style="background-image:url(' + type + '/' + _d['dir'] + '/logo.png);padding-left:25px">' + _d['title'] + '</div></td><td class="pk-hide-sm pk-text-center">' + _d['version'] + '</td><td class="pk-hide-sm">' + _d['description'] + '<a target="_blank" class="pk-text-success pk-hover-underline" href="https://www.hadsky.com/gethelp.html?dir=' + _d['dir'] + '">[获取帮助&raquo;]</a></td><td class="pk-hide-sm pk-text-center _exptime">免费</td><td class="pk-hide-sm pk-text-center">' + _d['status'] + '</td><td class="pk-text-center _btns" data-dir="' + _d['dir'] + '">' + btns + '</td></tr>';
	}
	$('#appTable tbody').html(html);
	$('#appTable ._btns a').on('click', function() {
		var v = $(this).data('v');
		var p = $(this).parent();
		var dir = p.data('dir');
		var title = $(this).parents('tr').find('._title').text();
		var key = $(this).parents('tr').data('key');
		switch(v) {
			case 'install':
				var pid = ppp({
					type: 4,
					shade: 1,
					content: "正在安装..."
				});
				$.getJSON('index.php', {
					c: "app",
					a: "superadmin:index",
					s: "app",
					type: type,
					t: dir,
					ml: "install"
				}, function(data) {
					pkpopup.close(pid);
					if(data['state'] == 'ok') {
						localdata[key]['install'] = false;
						ppp({
							type: 3,
							icon: 1,
							content: "安装成功",
							complete: function() {
								loadATInit();
							}
						});
					} else {
						ppp({
							icon: 2,
							content: data['datas']['msg']
						});
					}
				});
				break;
			case 'uninstall':
				ppp({
					type: 1,
					icon: 3,
					content: "确认卸载该应用么？数据将会被一并删除（包括表）",
					submit: function() {
						var pid = ppp({
							type: 4,
							shade: 1,
							content: "正在卸载..."
						});
						$.getJSON('index.php', {
							c: "app",
							a: "superadmin:index",
							s: "app",
							type: type,
							t: dir,
							ml: "uninstall"
						}, function(data) {
							pkpopup.close(pid);
							if(data['state'] == 'ok') {
								localdata[key]['install'] = true;
								ppp({
									type: 3,
									icon: 1,
									content: "卸载成功",
									complete: function() {
										loadATInit();
									}
								});
							} else {
								ppp({
									icon: 2,
									content: data['datas']['msg']
								});
							}
						});
					}
				});
				break;
			case 'setting':
				openIframe('index.php?c=app&a=superadmin:index&s=app&type=' + type + '&ml=setting&t=' + dir, title);
				break;
			default:
				break;
		}
	});
	return apps;
}

function loadATInit() {
	$.getJSON(apiUrl('getappsversion&apps=' + encodeURIComponent(JSON.stringify(loadAT())), true), function(data) {
		if(data['state'] == 'ok') {
			var d = data['datas'];
			//console.log(d);
			for(var i in d) {
				var nowtime = Cnum((new Date()).getTime() / 1000);
				var exptime = Cnum(d[i].exptime);
				var lifetime = Cnum(d[i].lifetime);
				if(exptime < nowtime && !lifetime) {
					$('#_app_' + i + ' td:last a:not(:contains("卸载"))').addClass('pk-hide');
					$('#_app_' + i + ' td:last').prepend('<a class="pk-text-warning pk-hover-underline _xvfei" href="javascript:" data-dir="' + i + '"> 续费 </a>');
					$('#_app_' + i + ' td:last ._xvfei').on('click', function() {
						appPurchaseBox($(this).data('dir'));
					});
					$('#_app_' + i + ' td._exptime').html('<font class="pk-text-danger">已过期</font>');
					continue;
				}
				if(lifetime) {
					$('#_app_' + i + ' td._exptime').html('<font class="pk-text-success">终身</font>');
				} else {
					$('#_app_' + i + ' td._exptime').html(getLocalTime(exptime, 'y-m-d'));
					$('#_app_' + i + ' td:last').prepend('<a class="pk-text-warning pk-hover-underline _xvfei" href="javascript:" data-dir="' + i + '"> 续费 </a>');
					$('#_app_' + i + ' td:last ._xvfei').on('click', function() {
						appPurchaseBox($(this).data('dir'));
					});
				}
				if(localdata[i].version != d[i].version) {
					$('#_app_' + i + ' td:last').prepend('<a class="pk-text-success pk-hover-underline _update" href="javascript:" data-key="' + $('#_app_' + i).data('key') + '" data-dir="' + i + '" data-version="' + d[i].version + '"> 更新 </a>');
					$('#_app_' + i + ' td:last ._update').on('click', function() {
						var dir = $(this).data('dir');
						var version = $(this).data('version');
						ppp({
							type: 1,
							icon: 3,
							content: "确认更新该插件至" + version + "版本吗？",
							submit: function() {
								appDownload(dir, version, '正在更新...');
							}
						});
					});
				}
			}
		}
	});
}

function appDownload(dir, version, text) {
	if(!text) {
		text = '正在下载...';
	}
	var pid = ppp({
		type: 4,
		content: text,
		shade: 1
	});
	$.getJSON('index.php?c=app&a=superadmin:index&s=appdownload', {
		c: 'app',
		a: 'superadmin:index',
		s: 'appdownload',
		dir: dir,
		type: $_URI['TYPE']
	}, function(data) {
		pkpopup.close(pid);
		if(data['state'] == 'ok') {
			var obj = $('#_app_' + dir);
			obj.find('td._version').html(version);
			obj.find('td:last a:contains("下载")').attr({
				class: ''
			}).unbind('click').html('已下载');
			obj.find('td:last a:contains("更新")').remove();
			ppp({
				type: 3,
				icon: 1,
				content: (!text ? '下载成功' : '操作成功')
			});
		} else {
			ppp({
				icon: 2,
				content: data['datas']['msg']
			});
		}
	});
}

function appPurchaseBox(dir) {
	var pid = ppp({
		type: 4,
		content: "获取价格中...",
		shade: 1
	});
	$.getJSON(apiUrl('getappprice&dir=' + dir, true), function(data) {
		pkpopup.close(pid);
		if(data['state'] == 'ok') {
			var d = data['datas'];
			//console.log(d);
			var html = '<div style="height:38px;line-height:38px">应用名称：' + d.title + '</div>';
			html += '<div style="height:38px;line-height:38px"><span style="float:left;height:38px;line-height:38px">购买时长：</span><input class="pk-textbox" name="n" type="number" style="width:77px;float:left" value="1"><select name="yml" class="pk-textbox" style="width:56px;float:left"><option value="yprice">年</option><option value="mprice">月</option><option value="lprice">终身</option></select></div>';
			html += '<div style="height:38px;line-height:38px">应用售价：<b class="_price">' + (d['yprice'] / 100) + '元';
			if(Cnum(d['tdtrade'])) {
				html += '/' + (d['yprice'] / 10) + '天豆';
			}
			html += '</b></div>';
			html += '<div style="height:38px;line-height:38px">账户余额：' + d['rmb'] + '元</div>';
			if(Cnum(d['tdtrade'])) {
				html += '<div style="height:38px;line-height:38px">天豆数量：' + d['tiandou'] + '颗</div>';
				html += '<div style="height:38px;line-height:38px"><span style="float:left;height:38px;line-height:38px">付款方式：</span><select name="paytype" class="pk-textbox" style="width:133px;float:left"><option value="rmb">账户余额</option><option value="tiandou">天豆</option></select></div>';
			}
			ppp({
				type: 1,
				title: "购买/续费应用",
				content: html,
				noclose: 1,
				submit: function(_id) {
					var pid2 = ppp({
						type: 4,
						content: "处理中...",
						shade: 1
					});
					var n = $('#pkpopup_' + _id + ' .pk-popup-body [name="n"]').val();
					var yml = $('#pkpopup_' + _id + ' .pk-popup-body [name="yml"]').val();
					var paytype = $('#pkpopup_' + _id + ' .pk-popup-body [name="paytype"]').val();
					$.getJSON(apiUrl('apppurchase&dir=' + dir + '&n=' + n + '&yml=' + yml + '&paytype=' + paytype, true), function(data2) {
						pkpopup.close(pid2);
						if(data2['state'] == 'ok') {
							if(data2['datas']['msg'] == '终身') {
								$('#_app_' + dir + ' td:last').find('a:contains("续费")').remove();
							}
							$('#_app_' + dir + ' td:last').find('a:contains("购买")').remove();
							$('#_app_' + dir + ' td:last a').removeClass('pk-hide');
							$('#_app_' + dir + ' td._exptime').html(data2['datas']['msg']);
							pkpopup.close(_id);
							ppp({
								type: 3,
								icon: 1,
								content: '购买成功'
							});
						} else {
							ppp({
								icon: 2,
								content: data2['datas']['msg']
							});
						}
					});
				},
				complete: function(_id) {
					$('#pkpopup_' + _id + ' .pk-popup-foot .pk-popup-submit').html('购买');
					$('#pkpopup_' + _id + ' .pk-popup-body').find('[name="n"],[name="yml"]').on('input change', function() {
						if($(this).attr('name') == 'n') {
							$(this).val(Cnum($(this).val(), 1, true, 1));
						}
						var n = $('#pkpopup_' + _id + ' .pk-popup-body [name="n"]').val();
						var yml = $('#pkpopup_' + _id + ' .pk-popup-body [name="yml"]').val();
						if(yml == "lprice") {
							n = 1;
							$('#pkpopup_' + _id + ' .pk-popup-body [name="n"]').val(1);
						}
						var rmb = ((n * d[yml]) / 100) + '元';
						if(Cnum(d['tdtrade'])) {
							rmb += '/' + ((n * d[yml]) / 10) + '天豆';
						}
						$('#pkpopup_' + _id + ' .pk-popup-body ._price').html(rmb);
					});
				}
			});
		} else {

		}
	});
}

function zhanzhangLogin(url) {
	window.open('index.php?c=app&a=superadmin:index&s=zhanzhanglogin&url=' + encodeURIComponent(url || ''), '_blank');
}

function jvhuoLogin(url) {
	window.open('index.php?c=app&a=superadmin:index&s=jvhuologin&url=' + encodeURIComponent(url || ''), '_blank');
}

function chkUpdateHs(nowversion) {
	var pid = ppp({
		type: 4,
		shade: 1,
		content: "正在检测更新..."
	});
	$.getJSON(apiUrl('chkupdate&nowversion=' + nowversion, true), function(data) {
		pkpopup.close(pid);
		if(data['state'] == 'ok') {
			var d = data['datas'];
			ppp({
				type: 1,
				title: 'v' + d.version + '[' + d.filesize + 'KB]',
				content: d.content,
				submit: function() {
					updateHs();
				},
				complete: function(_id) {
					$('#pkpopup_' + _id + ' .pk-popup-foot .pk-popup-submit').html('更新');
				}
			});
		} else {
			ppp({
				icon: 2,
				content: data['datas']['msg']
			});
		}
	});
}

function updateHs() {
	var pid = ppp({
		type: 4,
		shade: 1,
		content: "正在更新..."
	});
	$.getJSON('index.php', {
		c: "app",
		a: "superadmin:index",
		s: "update",
		do: "update"
	}, function(data) {
		pkpopup.close(pid);
		if(data['state'] == 'ok') {
			var _pid = ppp({
				type: 4,
				shade: 1,
				content: "更新成功，正在刷新系统..."
			});
			$.get('index.php', function() {
				location.reload();
			});
		} else {
			ppp({
				icon: 2,
				content: data['datas']['msg']
			});
		}
	});
}

function daShangZuoZhe() {
	ppp({
		title: "打赏作者",
		content: '<div class="pk-text-center"><img src="app/superadmin/template/img/wx.jpg" style="width:360px;height:488px;object-fit:cover;max-width:100%"></div>',
		shade: 1,
		nomove: 1,
		complete: function(_id) {
			var obj = $('#pkpopup_' + _id + ' .pk-popup-foot');
			obj.css({
				textAlign: 'center'
			}).html('<a href="javascript:" class="pk-background-color-success" onclick="$(this).parent().prev().find(\'img\').attr({src:\'app/superadmin/template/img/wx.jpg\'})">微信</a>&nbsp;<a href="javascript:" class="pk-background-color-secondary" onclick="$(this).parent().prev().find(\'img\').attr({src:\'app/superadmin/template/img/zfb.jpg\'})">支付宝</a>');

		}
	})
}