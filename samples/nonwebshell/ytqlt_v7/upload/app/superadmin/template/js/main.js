var OData = '',
	nav_data = $('#app-superadmin-main').data('data') || [];
$(function() {
	//获取导航数据
	var data = nav_data;
	var _data = [];
	for(var i in data) {
		_data[i] = data[i];
	}
	data = _data;
	var h_n = '';
	if($(window).width() > 1000) {
		//通用大屏端，移除小屏端
		$('#app-superadmin-main').removeClass('pk-hide');
		$('#app-superadmin-main-sm').remove();
		//布局整理
		$('#app-superadmin-mainshow,#app-superadmin-main>.left .nav').css('height', $('#app-superadmin-main>.right').height() - $('#app-superadmin-main>.right>div:eq(0)').outerHeight() - $('#app-superadmin-main>.right .inav').outerHeight() + 'px');
		//写入导航数据
		for(var i = 0; i < data.length; i++) {
			if(data[i].icon) {
				var l = '<span class="fa fa-fw fa-' + data[i].icon + '"></span>&nbsp;';
			} else {
				var l = '';
			}
			h_n += '<li data-index="' + i + '" onclick="Head_Nav_Show(' + i + ',this)">' + l + data[i].title + '</li>';
		}
		$('#app-superadmin-main>.right .nav ul').append(h_n);
		//初始化btn
		$('#app-superadmin-main>.right .nav ul li:eq(' + ((parseInt($_GET('PIndex')) || 0) + 1) + ')').click();
		$('#app-superadmin-main>.left .nav ul li:eq(' + (parseInt($_GET('CIndex')) || 0) + ')').click();
	} else {
		//通用小屏端，移除大屏div
		$('#app-superadmin-main-sm').removeClass('pk-hide');
		$('#app-superadmin-main').remove();
		//写入导航数据
		h_n = '';
		for(var i = 0; i < data.length; i++) {
			h_n += '<option value="' + i + '">' + data[i].title + '</option>';
		}
		//导航绑定change事件
		$('#app-superadmin-main-sm>div:eq(0)>div:eq(0)>select').html(h_n).change(function() {
			var Index = parseInt($(this).val()) || 0,
				h_n = '<option value="false">请选择...</option>';
			for(var i = 0; i < nav_data[Index].data.length; i++) {
				h_n += '<option value="' + i + '">' + nav_data[Index].data[i].title + '</option>';
			}
			$('#app-superadmin-main-sm>div:eq(0)>div:eq(1)>select').html(h_n).change(function() {
				if($(this).val() == 'false') {
					return false;
				}
				//显示正在加载tip
				var pid = ppp({
					type: 4,
					shade: 1,
					content: "正在加载..."
				});
				var PIndex = parseInt($('#app-superadmin-main-sm>div:eq(0)>div:eq(0)>select').val()) || 0,
					Index = parseInt($(this).val()) || 0;
				var t = nav_data[PIndex].data[Index].t;
				if(t.indexOf('http://') !== 0 && t.indexOf('https://') !== 0 && t.indexOf('javascript:') !== 0) {
					t = 'index.php?c=app&a=superadmin:index&s=' + nav_data[PIndex].s + '&t=' + t;
				}
				if(!nav_data[PIndex].data[Index].target) {
					$('#app-superadmin-mainshow-sm iframe').attr('src', t).on('load', function() {
						pkpopup.close(pid);
					});
				} else {
					setTimeout(function() {
						pkpopup.close(pid);
					}, 1500);
					window.open(t, nav_data[PIndex].data[Index].target);
				}
			});
		});
		//初始化导航选项
		$('#app-superadmin-main-sm>div:eq(0)>div:eq(0)>select').val(parseInt($_GET('PIndex')) || 0).change();
		$('#app-superadmin-main-sm>div:eq(0)>div:eq(1)>select').val(parseInt($_GET('CIndex')) || 0).change();
	}
	//关闭启动界面
	$('.start-div').remove();
	//隐藏左边栏按钮
	$('#left-nav-sh').click(function() {
		var speed = 555;
		if($(this).find('span').hasClass('fa-chevron-left')) {
			$('#app-superadmin-main>.left:eq(0)').animate({
				"width": "0%"
			}, speed);
			$('#app-superadmin-main>.right:eq(0)').animate({
				"width": "100%"
			}, speed);
		} else {
			$('#app-superadmin-main>.left:eq(0)').animate({
				"width": "12%"
			}, speed);
			$('#app-superadmin-main>.right:eq(0)').animate({
				"width": "88%"
			}, speed);
		}
		$(this).find('span').toggleClass('fa-chevron-left fa-chevron-right');
	});
	//webtitle
	$('head title:eq(0)').html('后台控制面板 - ' + Code_Powered);
});

function Head_Nav_Show(Index, This) {
	if($(This).hasClass('pk-active')) {
		return false;
	}
	$('#app-superadmin-main>.right .nav ul li').removeClass('pk-active');
	$(This).addClass('pk-active');
	var h_n = '';
	for(var i = 0; i < nav_data[Index].data.length; i++) {
		if(nav_data[Index].data[i].icon) {
			var l = '<span class="fa fa-fw fa-' + nav_data[Index].data[i].icon + '"></span>&nbsp;';
		} else {
			var l = '';
		}
		h_n += '<li data-pindex="' + Index + '" data-index="' + i + '" onclick="Left_Nav_Show(' + Index + ',' + i + ',this)">' + l + nav_data[Index].data[i].title + '</li>';
	}
	$('#app-superadmin-main>.left .nav ul').html(h_n);
}

function Left_Nav_Show(PIndex, Index, This) {
	if($(This).hasClass('pk-active') || $(This).hasClass('on-times')) {
		return false;
	}
	var iobj = $('#app-superadmin-mainshow #app-superadmin-iframe-' + PIndex + '-' + Index) || false;
	var inobj = $('#app-superadmin-main>.right .inav ul');
	if(iobj.attr('src')) {
		//隐藏及显示交互
		$('#app-superadmin-main>.left .nav ul li,#app-superadmin-main>.right .inav ul li').removeClass('pk-active');
		$(This).addClass('pk-active');
		$('#app-superadmin-mainshow iframe').addClass('pk-hide');
		//显示选中项
		$('#app-superadmin-main>.left .nav ul li[data-pindex="' + PIndex + '"][data-index="' + Index + '"]').addClass('pk-active');
		inobj.find('#app-superadmin-inav-' + PIndex + '-' + Index).addClass('pk-active');
		iobj.removeClass('pk-hide');
	} else {
		var t = nav_data[PIndex].data[Index].t;
		if(t.indexOf('http://') !== 0 && t.indexOf('https://') !== 0 && t.indexOf('javascript:') !== 0) {
			t = 'index.php?c=app&a=superadmin:index&s=' + nav_data[PIndex].s + '&t=' + t;
		}
		if(!nav_data[PIndex].data[Index].target) {
			//隐藏及显示交互
			$('#app-superadmin-main>.left .nav ul li,#app-superadmin-main>.right .inav ul li').removeClass('pk-active');
			$(This).addClass('pk-active');
			$('#app-superadmin-mainshow iframe').addClass('pk-hide');
			//显示正在加载tip
			//pktip('<span class="fa fa-fw fa-spin fa-spinner"></span>正在加载...', '', 1000);
			//创建新iframe及导航按钮
			$('#app-superadmin-mainshow').css('background-image', 'url(app/superadmin/template/img/loading.gif)');
			inobj.append('<li class="pk-active" data-pindex="' + PIndex + '" data-index="' + Index + '" id="app-superadmin-inav-' + PIndex + '-' + Index + '" onclick="Left_Nav_Show(' + PIndex + ',' + Index + ',this)"><i class="fa fa-fw fa-' + nav_data[PIndex].data[Index].icon + '"></i>&nbsp;' + nav_data[PIndex].data[Index].title + '<span class="fa fa-fw fa-times" onclick="Close_Nav(' + PIndex + ',' + Index + ',this)" onmouseover="$(this).parent().addClass(\'on-times\')" onmouseout="$(this).parent().removeClass(\'on-times\')"></span></li>');
			$('#app-superadmin-mainshow').append('<iframe id="app-superadmin-iframe-' + PIndex + '-' + Index + '" src="' + t + '"></iframe>');
		} else {
			window.open(t, nav_data[PIndex].data[Index].target);
		}
	}
}

function Close_Nav(PIndex, Index, This) {
	$('#app-superadmin-mainshow').css('background-image', 'url(app/superadmin/template/img/mainshow.png)');
	if($(This).parent().hasClass('pk-active')) {
		//显示他的上一个标签或下一个标签
		var _a = $(This).parent().prev('li');
		if(_a.attr('id')) {
			_a.click();
		} else {
			_a = $(This).parent().next('li');
			if(_a.attr('id')) {
				_a.click();
			}
		}
	}
	$(This).parent().remove();
	$('#app-superadmin-mainshow #app-superadmin-iframe-' + PIndex + '-' + Index).remove();
}

function Close_Nav_All() {
	ppp({
		type: 1,
		content: "确认关闭所有已开启的标签吗？",
		icon: 3,
		submit: function(id) {
			$('#app-superadmin-main>.right .inav ul li').addClass('on-times').find('span[class*="fa-times"]').click();
		}
	});
}

function openIframe(url, title) {
	var _tmpstyle_h = $('html').css('overflow-y');
	var _tmpstyle_b = $('body').css('overflow-y');
	ppp({
		title: title,
		content: '<iframe src="' + url + '" style="width:100%;height:100%;border:0;overflow-y:scroll"></iframe>',
		area: ['100%', '100%', '0', '0', '0', '0'],
		complete: function(id) {
			$('#pkpopup_' + id + ' .pk-popup-body,body').css('overflow-y', 'hidden');
			$('#pkpopup_' + id + ' .pk-popup-foot a:eq(0)').html('取消');
		},
		close: function() {
			$('html').css('overflow-y', _tmpstyle_h);
			$('body').css('overflow-y', _tmpstyle_b);
		}
	});
}