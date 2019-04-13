function _center_searchbox(This) {
	var _p = $(This).parents('ul:eq(0)');
	var _n = _p.find('>li');
	var _v = trim($(This).val());
	if(_v) {
		for(var i = 1; i < _n.length; i++) {
			console.log(_v + '   ' + $(_n[i]).text() + '   ' + $(_n[i]).text().indexOf(_v));
			if($(_n[i]).text().indexOf(_v) == -1) {
				$(_n[i]).addClass('pk-hide');
			} else {
				$(_n[i]).removeClass('pk-hide');
			}
		}
	} else {
		_n.removeClass('pk-hide');
	}
}
$(function() {
	//个人中心导航驱动
	$('#center_nav>li').on('click', function() {
		var This = $(this);
		var _v = This.data('v');
		if(This.hasClass('pk-active')) {
			return false;
		}
		$('#center_nav>li').removeClass('pk-active');
		This.addClass('pk-active');
		$('.center-body-dom').addClass('pk-hide');
		$('#center_body_' + _v).removeClass('pk-hide');
	});
	//动态加载事件
	$('#center_body_dynamic>ul>li>a:eq(0)').on('click', function() {
		var This = $(this);
		var page = This.data('page');
		if(This.hasClass('disabled')) {
			return false;
		}
		This.addClass('disabled').html('正在加载...');
		$.getJSON('index.php?c=center&type=dynamic', {
			page: page,
			uid: (parseInt($_URI['UID']) || $_USER['ID']),
			chkcsrfval: $_USER['CHKCSRFVAL']
		}, function(data) {
			if(data['state'] == 'ok') {
				if(data['datas'].length == 0) {
					This.html('已无更多内容');
				} else {
					for(var i in data['datas']) {
						var dt = getLocalTime(data['datas'][i]['posttime']);
						//console.log(dt);
						var _d = dt.split(' ')[0];
						var _t = dt.split(' ')[1];
						var _html = '<time>' + _t + '</time> ' + (data['datas'][i]['table'] == 'read' ? '<font style="color:#FF5722">发表</font>' : '<font style="color:#FFB800">回复</font>') + '了文章《<a target="_blank" href="index.php?c=read&id=' + data['datas'][i]['rid'] + '&page=1">' + data['datas'][i]['title'] + '</a>》<br>';
						var _obj = $('#center_body_dynamic>ul>li[date="' + _d + '"]');
						if(!_obj.attr('date')) {
							This.parent().before('<li date="' + _d + '"><h2>' + _d.replace('-', '年').replace('-', '月') + '日</h2><p></p></li>');
						}
						$('#center_body_dynamic>ul>li[date="' + _d + '"]>p:eq(0)').append(_html);
					}
					page++;
					This.data('page', page);
					This.removeClass('disabled').html('加载更多');
				}
			} else {
				ppp({
					title: "出错",
					content: data['datas']['msg'],
					icon: 2
				});
			}
			//console.log(data);
		});
	});
	//消息加载事件
	$('#center_body_message>ul>li>a:eq(0)').on('click', function() {
		var This = $(this);
		var page = This.data('page');
		if(This.hasClass('disabled')) {
			return false;
		}
		This.addClass('disabled').html('正在加载...');
		$.getJSON('index.php?c=center&type=message&page=' + page, function(data) {
			if(data['state'] == 'ok') {
				if(data['datas'].length == 0) {
					This.html('已无更多内容');
				} else {
					var _html = '';
					for(var i in data['datas']) {
						var dt = getLocalTime(data['datas'][i]['addtime']);
						//console.log(dt);
						_html += '<li><h2><img src="userhead/' + data['datas'][i]['fid'] + '.png" onerror="this.src=\'userhead/0.png\'" alt="" /><a target="_blank" href="' + (data['datas'][i]['fid'] != "0" ? 'index.php?c=center&uid=' + data['datas'][i]['fid'] : 'javascript:') + '">' + data['datas'][i]['nickname'] + '</a><i' + (data['datas'][i]['islook'] == "1" ? '>' : ' style="color:red">New ') + dt + '</i></h2><p>' + data['datas'][i]['content'] + (data['datas'][i]['fid'] != "0" ? '&nbsp;&nbsp;[<a href="javascript:" onclick="PostMessageBox({uid:' + data['datas'][i]['fid'] + ',username:\'' + data['datas'][i]['username'] + '\'})">回复Ta</a>]' : '') + '</p></li>';
					}
					This.parent().before(_html);
					page++;
					This.data('page', page);
					This.removeClass('disabled').html('加载更多');
				}
			} else {
				ppp({
					title: "出错",
					content: data['datas']['msg'],
					icon: 2
				});
			}
			//console.log(data);
		});
	});
	//关注加载事件
	$('#center_body_idol>ul>li>a:eq(0)').on('click', function() {
		var This = $(this);
		var page = This.data('page');
		if(This.hasClass('disabled')) {
			return false;
		}
		This.addClass('disabled').html('正在加载...');
		$.getJSON('index.php?c=center&type=idol&page=' + page, function(data) {
			if(data['state'] == 'ok') {
				if(data['datas'].length == 0) {
					This.html('已无更多内容');
				} else if(data['datas']['msg'] == '404') {
					This.html('你未关注任何人');
				} else {
					for(var i in data['datas']) {
						var dt = getLocalTime(data['datas'][i]['posttime']);
						//console.log(dt);
						var _d = dt.split(' ')[0];
						var _t = dt.split(' ')[1];
						var _html = '<time>' + _t + '</time> <a target="_blank" href="index.php?c=center&uid=' + data['datas'][i]['uid'] + '">' + data['datas'][i]['nickname'] + '</a>发表了文章《<a target="_blank" href="index.php?c=read&id=' + data['datas'][i]['id'] + '&page=1">' + data['datas'][i]['title'] + '</a>》<br>';
						var _obj = $('#center_body_idol>ul>li[date="' + _d + '"]');
						if(!_obj.attr('date')) {
							This.parent().before('<li date="' + _d + '"><h2>' + _d.replace('-', '年').replace('-', '月') + '日</h2><p></p></li>');
						}
						$('#center_body_idol>ul>li[date="' + _d + '"]>p:eq(0)').append(_html);
					}
					page++;
					This.data('page', page);
					This.removeClass('disabled').html('加载更多');
				}
			} else {
				ppp({
					title: "出错",
					content: data['datas']['msg'],
					icon: 2
				});
			}
			//console.log(data);
		});
	});
	//显示未读消息
	if($_USER['MESSAGE_UNREADCOUNT']) {
		$('#center_nav>li.message').append('<i></i>');
		//绑定清除消息未读提示
		$('#center_nav>li.message').on('click', function() {
			if($_USER['MESSAGE_UNREADCOUNT']) {
				$.getJSON('index.php?c=center&type=readmessage', function(data) {
					if(data['state'] == 'ok') {
						$('#center_nav>li>i').remove();
						$_USER['MESSAGE_UNREADCOUNT'] = 0;
					}
				});
			}
		});
	}
	//初始化动态及消息的加载
	$('#center_body_dynamic>ul>li>a:eq(0)').click();
	if((!Cnum($_URI['UID'], false, true, 1) || $_URI['UID'] == $_USER['ID']) && Cnum($_USER['ID'], false, true, 1)) {
		//退出登录按钮
		$('#logoutbtn').removeClass('pk-hide').on('click', function() {
			ppp({
				type: 1,
				content: "你确认要退出当前用户么？",
				icon: 3,
				submit: function() {
					$.getJSON('index.php?c=login&type=out&json=1', function(data) {
						if(data['state'] == 'ok') {
							ppp({
								type: 3,
								icon: 1,
								content: "退出成功",
								close: function() {
									location.href = 'index.php?from=loginout';
								}
							});
						}
					});
				}
			});
		});
		//好友、收藏加载事件
		(function() {
			$.getJSON('index.php?c=center&type=friend', function(data) {
				if(data['state'] == 'ok') {
					var _html = '';
					for(var i in data['datas']) {
						_html += '<li><img src="userhead/' + data['datas'][i]['uid'] + '.png" onerror="this.src=\'userhead/0.png\'"><p><a target="_blank" href="index.php?c=center&uid=' + data['datas'][i]['uid'] + '">' + data['datas'][i]['nickname'] + '（用户名：' + data['datas'][i]['username'] + '）' + '</a><span>[<a class="pk-text-primary pk-hover-underline" href="javascript:" onclick="PostMessageBox({uid:' + data['datas'][i]['uid'] + '})">发消息</a>]&nbsp;签名：' + data['datas'][i]['sign'] + '</span></p></li>';
					}
					$('#center_body_friend').html(_html == '' ? '<p class="pk-text-center">暂无添加任何好友</p>' : '<ul class="center-friends"><li><input type="search" class="center-searchbox" placeholder="请输入要搜索的内容" oninput="_center_searchbox(this)"></li>' + _html + '</ul>');
				} else {
					$('#center_body_friend').html(data['datas']['msg']);
				}
			});
			$.getJSON('index.php?c=center&type=collect', function(data) {
				if(data['state'] == 'ok') {
					var _html = '';
					for(var i in data['datas']) {
						_html += '<li>《<a target="_blank" href="index.php?c=read&id=' + data['datas'][i]['id'] + '&page=1">' + data['datas'][i]['title'] + '</a>》发表于<date>' + getLocalTime(data['datas'][i]['posttime']) + '</date>&nbsp;&nbsp;&nbsp;[<a href="javascript:" onclick="Interactive(\'delcollect\',' + data['datas'][i]['id'] + ', this);$(this).parent().remove()">取消收藏</a>]</li>';
					}
					$('#center_body_heart').html(_html == '' ? '<p class="pk-text-center">暂未收藏任何文章</p>' : '<ul class="center-heartbox"><li><input type="search" class="center-searchbox" placeholder="请输入要搜索的内容" oninput="_center_searchbox(this)"></li>' + _html + '</ul>');
				} else {
					$('#center_body_heart').html(data['datas']['msg']);
				}
			});
		})();
		$('#center_body_message>ul>li>a:eq(0),#center_body_idol>ul>li>a:eq(0)').click();
		$('#center_nav>li').removeClass('pk-hide');
		if(location.hash) {
			$('#center_nav>li[data-v="' + location.hash.substr(1) + '"]').click();
		}
	} else if(Cnum($_USER['ID'], false, true, 1)) {
		if($_USER['FRIENDS'] && $_USER['FRIENDS'].indexOf('_' + $_URI['UID'] + '_') != -1) {
			$('#userinteractivebtns .friendbtn').attr('onclick', $('#userinteractivebtns .friendbtn').attr('onclick').replace("Interactive('addfriend'", "Interactive('delfriend'")).css('background-color', '#F4606C').html('<i class="fa fa-fw fa-trash-o"></i>删除好友');
		}
		if($_USER['IDOL'] && $_USER['IDOL'].indexOf('_' + $_URI['UID'] + '_') != -1) {
			$('#userinteractivebtns .idolbtn').attr('onclick', $('#userinteractivebtns .idolbtn').attr('onclick').replace("Interactive('addidol'", "Interactive('delidol'")).css('background-color', '#F4606C').html('<i class="fa fa-fw fa-unlink"></i>取消关注');
		}
		$('#center-main .userheadbar>div').removeClass('pk-hide');
	}
	//输入框ie9及以下不显示
	if(/MSIE\s/.test(navigator.userAgent) && parseFloat(navigator.appVersion.split("MSIE")[1]) < 10) {
		$('head').append('<style>.center-searchbox{display:none}</style>');
	}
	//上传你头像
	var _tx = '#center-main #center-body .center-mybox img.userhead';
	$(_tx).on('click', function() {
		var $uid = parseInt($_USER['ID']);
		if($uid && (parseInt($_URI['ID']) == $uid || !$_URI['ID'] || $uid == 1)) {
			$('#pk-dd').html('<input type="file" id="pk-file-object" value="" onchange="$(\'' + _tx + '\')[0].src=getLocalFileUrl(this);$(\'' + _tx + '\')[0].onload=function(){$(\'#center_body_my p[data-name=userhead] input[name=userhead]\').val(ImageToBase64($(\'' + _tx + '\')[0],\'150\',\'150\'));ppp({content:\'点击保存后，设置的头像才会生效哦~\',icon:0})}" accept="image/*">');
			var file = $('#pk-file-object')[0];
			file.click();
		} else {
			LookImage($(_tx)[0]);
		}
	});
	//资料更改初始化
	if(((!Cnum($_URI['UID'], false, true, 1) || $_URI['UID'] == $_USER['ID']) && Cnum($_USER['ID'], false, true, 1)) || Cnum($_USER['ID']) == 1) {
		var inputs = $('#center_body_my p');
		for(var i = 0; i < inputs.length; i++) {
			var _is = $(inputs[i]);
			var _dn = _is.data('name');
			if(!_dn) {
				continue;
			}
			if(_dn == 'userhead') {
				_is.append('<input type="hidden" name="userhead">');
			} else if(_dn == 'sex') {
				var _h = _is.html();
				_is.css({
					paddingTop: "7px",
					paddingBottom: "7px"
				}).html('<select name="sex"><option value="s">保密</option><option value="b">男</option><option value="g">女</option></select>');
				$('select[name="sex"] option:contains("' + _h + '"):eq(0)').prop('selected', true);
			} else if(_dn == 'birthday') {
				_is.html('<span>' + _is.html() + '</span>&nbsp;&nbsp;<a id="_birthday_xzbtn" class="pk-text-primary pk-hover-underline" href="javascript:">选择日期</a><input type="hidden" name="birthday"value="' + _is.html().replace(/[年月日]+/g, '') + '">');
				$('#_birthday_xzbtn').on('click', function() {
					var _yh = '';
					for(var _y = 1918; _y < (new Date()).getFullYear(); _y++) {
						_yh = '<option value="' + _y + '">' + _y + '年</option>' + _yh;
					}
					var _mh = '';
					for(var _m = 1; _m < 13; _m++) {
						var __m = _m < 10 ? '0' + _m : _m;
						_mh += '<option value="' + __m + '">' + __m + '月</option>';
					}
					var _dh = '';
					for(var _d = 1; _d < 32; _d++) {
						var __d = _d < 10 ? '0' + _d : _d;
						_dh += '<option value="' + __d + '">' + __d + '日</option>';
					}
					var _pid = ppp({
						type: 1,
						title: "请选择生日日期",
						content: '<div class="pk-row"><div class="pk-w-sm-4 pk-padding-0"><select class="pk-textbox">' + _yh + '</select></div><div class="pk-w-sm-4 pk-padding-0"><select class="pk-textbox">' + _mh + '</select></div><div class="pk-w-sm-4 pk-padding-0"><select class="pk-textbox">' + _dh + '</select></div></div>',
						submit: function(id) {
							var _obj = $('#pkpopup_' + id + ' .pk-popup-body');
							$('input[name="birthday"]').val(_obj.find('select:eq(0)').val() + '' + _obj.find('select:eq(1)').val() + '' + _obj.find('select:eq(2)').val());
							$('#center_body_my p[data-name="birthday"]>span:eq(0)').html(_obj.find('select:eq(0)').val() + '年' + _obj.find('select:eq(1)').val() + '月' + _obj.find('select:eq(2)').val() + '日');
						}
					});
					var _h = $('input[name="birthday"]').val();
					if(_h.length == 8) {
						var _t = $('#pkpopup_' + _pid + ' .pk-popup-body');
						_t.find('select:eq(0)').val(_h.substr(0, 4));
						_t.find('select:eq(1)').val(_h.substr(4, 2));
						_t.find('select:eq(2)').val(_h.substr(6));
					}
				});
			} else if(_dn == 'phone') {
				if($_SET['APP_HADSKYCLOUDSERVER_SMS_OPEN'] && parseInt($_USER['ID']) != 1) {
					_is.append('&nbsp;&nbsp;<a class="pk-text-primary pk-hover-underline" target="_blank" href="index.php?c=app&a=hadskycloudserver:index&s=sms_changephone">修改</a>');
				} else {
					_is.css({
						paddingTop: "7px",
						paddingBottom: "7px"
					}).html('<input type="text" name="phone" value="' + _is.html().replace(/"/g, '&quot;') + '">');
				}
			} else {
				_is.css({
					paddingTop: "7px",
					paddingBottom: "7px"
				}).html('<input type="text" name="' + _dn + '" value="' + _is.html().replace(/"/g, '&quot;') + '"' + ((_dn == 'sign' || _dn == 'adress') ? ' style="width:100%"' : '') + (_dn == 'adress' ? ' placeholder="xx省xx市xx县xx小区"' : '') + '>');
			}
		}
		//隐私设置
		$('#center-body select[name="data-privacysettings"] option[value="' + $('#center-body select[name="data-privacysettings"]').data('value') + '"]').prop('selected', true);
		//添加保存按钮
		$('#center-main #center-body ul.center-mybox').append('<li><p></p><p><a href="javascript:" class="_savebtn" onclick="center_submit(this)">保存</a></p></li>');
	}
});

function center_submit(This) {
	if($(This).hasClass('disabled')) {
		return false;
	}
	var strings = FormDataPackaging($(This).parents('ul:eq(0)'));
	$(This).addClass('disabled').html('提交中...');
	$.post('index.php?c=center&type=submit', strings, function(data) {
		if(data['state'] == 'ok') {
			ppp({
				type: 3,
				content: data['datas']['msg'],
				icon: 1
			});
		} else {
			ppp({
				type: 0,
				content: data['datas']['msg'],
				icon: 2
			});
		}
		$(This).removeClass('disabled').html('保存');
	}, 'json');
}