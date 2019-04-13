var forumData = [],
	forumBoxId = false;

function showForumChild(id) {
	if($('div.forumList ._' + id).length > 0) {
		$('#forumChild_' + id + '>i').toggleClass('fa-caret-down fa-caret-up').attr('onclick', 'hideForumChild(' + id + ')');
		$('div.forumList ._' + id).removeClass('pk-hide');
		return true;
	}
	var html = '';
	for(var i = 0; i < forumData.length; i++) {
		_d = forumData[i];
		if(_d.pid == id) {
			_c = false;
			for(var j = 0; j < forumData.length; j++) {
				if(forumData[j].pid == _d.id) {
					_c = true;
					break;
				}
			}
			html += '<div id="forumChild_' + _d.id + '" class="li"' + (_d.logourl ? ' style="background-image:url(' + _d.logourl + ')"' : '') + '><a href="javascript:" onclick="choseForum(' + _d.id + ',this)"><span>' + _d.title + '</span><i class="fa fa-fw fa-check pk-hide"></i></a>' + (_c ? '<i class="fa fa-fw fa-caret-down" onclick="showForumChild(' + _d.id + ')"></i>' : '') + '</div>';
		}
	}
	if(id == 0) {
		$('div.forumList').html(html);
		return true;
	}
	html = '<div data-pid="' + id + '" class="_' + id + ' _pl">' + html + '</div>';
	$('#forumChild_' + id + '>i').toggleClass('fa-caret-down fa-caret-up').attr('onclick', 'hideForumChild(' + id + ')').parent().after(html);
}

function hideForumChild(id) {
	$('#forumChild_' + id + '>i').toggleClass('fa-caret-down fa-caret-up').attr('onclick', 'showForumChild(' + id + ')');
	$('div.forumList ._' + id).addClass('pk-hide');
}

function choseForum(id, This) {
	//判断是否有权限发帖
	forumData = $('#showForumBtn').data('data') || [];
	var fd = false;
	for(var i = 0; i < forumData.length; i++) {
		if(forumData[i].id == id) {
			fd = forumData[i];
			break;
		}
	}
	if(!fd) {
		return false;
	}
	if(Cnum(fd.postlevel) > Cnum($_USER['READLEVEL']) || !!Cnum(fd.banpostread)) {
		$(This).parent().find('>i').click();
		return false;
	}
	//选择该板块
	$('div.forumList .li a>i.fa-check').addClass('pk-hide');
	$(This).find('>i.fa-check').removeClass('pk-hide');
	$('#showForumText').data('id', id).html('已选择“' + $(This).find('span').html() + '”版块');
}
$(function() {
	//版块初始化
	forumData = $('#showForumBtn').data('data') || [];
	var html = '<div class="forumList"></div>';
	forumBoxId = ppp({
		type: 1,
		title: "请选择版块",
		area: ($(window).width() < 1000 ? ['80%', '80%'] : ['600px', '700px']),
		content: html,
		noclose: true,
		submit: function(id) {
			var sortid = $('#showForumText').data('id');
			if(!sortid) {
				ppp({
					type: 3,
					icon: 0,
					content: "请选择版块后再操作"
				});
				return false;
			}
			var fd = false;
			for(var i = 0; i < forumData.length; i++) {
				if(forumData[i].id == sortid) {
					fd = forumData[i];
					break;
				}
			}
			if(!fd) {
				ppp({
					type: 3,
					icon: 2,
					content: "不存在的版块"
				});
				return false;
			}
			if(Cnum(fd.postlevel) > Cnum($_USER['READLEVEL'])) {
				ppp({
					type: 3,
					icon: 2,
					content: "您的阅读权限太低无法在该版块发帖"
				});
				return false;
			}
			if(!!Cnum(fd.banpostread)) {
				ppp({
					type: 3,
					icon: 2,
					content: "该板块禁止发帖，请重新选择"
				});
				return false;
			}
			$('form[name="form_post"] input[name="sortid"]').val(fd.id);
			$('#showForumBtn').html(fd.title);
			$('#pkpopup_' + id).addClass('pk-hide');
			var html = '';
			if(fd.label) {
				var $label = fd.label.split(',');
				for(var i = 0; i < $label.length; i++) {
					html += '<a href="javascript:" onclick="$(this).toggleClass(\'pk-active\')">' + $label[i] + '</a>';
				}
				html = '<span>帖子标签：</span>' + html;
			}
			$('#forumlabel').html(html);
		},
		complete: function(id) {
			$('#pkpopup_' + id).addClass('pk-hide');
			$('#pkpopup_' + id + ' .pk-popup-foot').prepend('<span id="showForumText">请选择要发布至的版块</span>').find('a:eq(1)').remove();
			$('#pkpopup_' + id + ' .pk-popup-head .pk-popup-close').unbind().on('click', function() {
				$('#pkpopup_' + id).addClass('pk-hide');
			});
			//初始化所有子版块
			setTimeout(function() {
				var sortid = Cnum(_sortid);
				var labels = _labels;
				for(var i = 0; i < 9999; i++) {
					var _o = $('div.forumList .li>i.fa-caret-down');
					if(!_o.length) {
						break;
					}
					for(j = 0; j < _o.length; j++) {
						_o[j].click();
					}
				}
				for(var i = 0; i < 9999; i++) {
					var _o = $('div.forumList .li>i.fa-caret-up');
					if(!_o.length) {
						break;
					}
					for(j = 0; j < _o.length; j++) {
						_o[j].click();
					}
				}
				//是否存在sortid
				if(sortid) {
					var _ps = $('#forumChild_' + sortid).parents();
					for(var i = 0; i < _ps.length; i++) {
						if($(_ps[i]).hasClass('forumList')) {
							break;
						}
						if(Cnum($(_ps[i]).data('pid'))) {
							$('#forumChild_' + $(_ps[i]).data('pid') + '>i.fa-caret-down').click();
						}
					}
					$('#forumChild_' + sortid + '>a').click();
					$('#pkpopup_' + id + ' .pk-popup-foot a:eq(0)').click();
					if(labels != "") {
						var $clabel = labels;
						$clabel = $clabel.split(',');
						var $clabels = $('#forumlabel>a');
						for(var i = 0; i < $clabel.length; i++) {
							for(var i2 = 0; i2 < $clabels.length; i2++) {
								if($($clabels[i2]).html() == $clabel[i]) {
									$($clabels[i2]).addClass('pk-active');
								}
							}
						}
					}
				}
			}, 200);
		}
	});
	$('#showForumBtn').on('click', function() {
		$('#pkpopup_' + forumBoxId).removeClass('pk-hide');
	});
	showForumChild(0);

	//发帖及其他
	if($(window).width() < 1000) {
		$(form_post.content).css({
			height: '222px'
		});
	}
	//标题颜色
	$('._title_colorbar').click(function() {
		var rgb1 = $('input[name="titlecolor"]').val() || '#000000';
		rgb1 = rgb1.toUpperCase();
		var _pid = ppp({
			type: 1,
			title: "标题颜色",
			noclose: true,
			content: "<div class='pk-row'><div class='pk-w-sm-6 pk-padding-0'><input type='color' class='pk-textbox pk-textbox-noshadow pk-float-right' style='width:86px;border-right:0' value='" + rgb1 + "'></div><div class='pk-w-sm-6 pk-padding-0'><select class='pk-textbox pk-textbox-noshadow pk-float-left' style='width:86px' onchange='$(this).parent().prev().find(\"input\").val($(this).val())' value='" + rgb1 + "'><option value='#000000'>默认</option><option value='#808080'>灰色</option><option value='#FF0000'>红色</option><option value='#FFFF00'>黄色</option><option value='#008000'>绿色</option><option value='#0000FF'>蓝色</option><option value='#800080'>紫色</option><option value='#FFC0CB'>粉色</option><option value='#FFA500'>橙色</option></select></div></div>",
			submit: function(id, value) {
				var rgb = $('#pkpopup_' + id + ' .pk-popup-body input[type=color]').val();
				if(rgb[0] != '#' || rgb.length != 7) {
					ppp({
						icon: 2,
						type: 3,
						content: "颜色参数不正确，请重新输入或选择"
					});
					return false;
				}
				rgb = rgb.toUpperCase();
				$('input[name="titlecolor"]').val(rgb);
				pkpopup.close(id);
			},
			complete: function(id) {
				$('#pkpopup_' + id + ' .pk-popup-body select option[value="' + rgb1 + '"]:eq(0)').prop('selected', true);
			}
		});
	});

	var $showadminbtn = false,
		$userqx = $_USER['QUANXIAN'];
	$userqx = $userqx.split(',');
	for(var $i = 0; $i < $userqx.length; $i++) {
		if($userqx[$i] == 'admin' || $userqx[$i] == 'superadmin') {
			$showadminbtn = true;
			break;
		}
	}
	if($showadminbtn || Cnum($_USER['ID']) == 1) {
		$('input[name="top"],input[name="high"],input[name="locked"]').parent('span').removeClass('pk-hide');
	}

	var postreadtitlecolorusergroup = _postreadtitlecolorusergroup.split(',');
	if(!parseInt(postreadtitlecolorusergroup[0]) || postreadtitlecolorusergroup.indexOf($_USER['GROUPID']) > -1) {
		$('._title_colorbar').removeClass('pk-hide');
	}

	if(form_post.title.value.substr(0, 31) == '<font class="pk-hadsky" color="') {
		var titlecolor = form_post.title.value.substr(31, 7);
		$('input[name="titlecolor"]').val(titlecolor);
		form_post.title.value = form_post.title.value.substr(40, form_post.title.value.length - 47);
	}

	if(Cnum(_high) == 1) {
		$('input[name="high"]').prop('checked', true);
	}
	if(Cnum(_top) == 1) {
		$('input[name="top"]').prop('checked', true);
	}
	if(Cnum(_locked) == 1) {
		$('input[name="locked"]').prop('checked', true);
	}
	if(Cnum(_replyafterlook) == 1) {
		$('input[name="replyafterlook"]').prop('checked', true);
	}
	$('#postbtn').click(function() {
		if(trim(form_post.title.value).length == 0) {
			ppp({
				content: '请输入标题后再操作',
				icon: 0,
				type: 3,
				complete: function(id) {
					$("body").scrollTop(0);
					form_post.title.focus();
				}
			});
			return false;
		}
		if(trim(form_post.content.value).length == 0) {
			ppp({
				content: '请输入内容后再操作',
				icon: 0,
				type: 3,
				complete: function(id) {
					$("body").scrollTop(0);
					if(typeof(PytEditor) != "undefined") {
						if($('#PytMainContent').css('display') == "none" || $('#PytMainContent').hasClass('pk-hide')) {
							form_post.content.focus();
						} else {
							PytEditor.body.focus();
						}
					} else {
						form_post.content.focus();
					}
				}
			});
			return false;
		}
		if(form_post.sortid.value == 0 && $_URI['TYPE'] == "read") {
			ppp({
				content: '请选择版块后再操作',
				icon: 0,
				type: 3,
				complete: function(id) {
					$("body").scrollTop(0);
					$("#showforum").click();
				}
			});
			return false;
		}
		var $label = $('#forumlabel a.pk-active'),
			$labelhtml = '';
		for(var i = 0; i < $label.length; i++) {
			$labelhtml += ',' + $($label[i]).html();
		}
		if($labelhtml) {
			$labelhtml = $labelhtml.substr(1);
			form_post.label.value = $labelhtml;
		}
		form_post.content.value = form_post.content.value.replace(/\<div/g, '<p');
		form_post.content.value = form_post.content.value.replace(/\<\/div\>/g, '</p>');
		$(this).prop('disabled', true).html('发布中...');
		//数据打包
		var formstring = FormDataPackaging('form[name="form_post"]:eq(0)');
		$.post($('form[name="form_post"]:eq(0)').attr('action'), formstring, function(data) {
			if(data['state'] == 'ok') {
				//清除保存进度
				$('body').append('<div id="app_puyuetianeditor_editcontent_autosave" class="pk-hide">no</div>');
				setCookie('app_puyuetianeditor_editcontent', '', 1);
				ppp({
					icon: 1,
					type: 3,
					shade: true,
					content: data['msg'],
					times: 0,
					complete: function(id) {
						//关闭或取消后调用的函数
						setTimeout(function() {
							if(data['check']) {
								location.href = "index.php?c=list";
							} else {
								location.href = "index.php?c=read&id=" + data['rid'] + "&page=1&cache=refresh";
							}
						}, 1500);
					}
				});
			} else {
				$('form[name="form_post"] input[name="verifycode"]').val('');
				$('#verifycodeimageobject').click();
				ppp({
					content: data['msg'] || '未知错误',
					icon: 2
				});
				$('#postbtn').prop('disabled', false).html('发布');
			}
		}, 'json').error(function() {
			$('#postbtn').prop('disabled', false).html('发布');
			$('form[name="form_post"]:eq(0)').attr('action', $('form[name="form_post"]:eq(0)').attr('action').replace('&return=json', ''));
			form_post.submit();
		});
	});

	//预览
	$('#previewbtn').click(function() {
		if(trim(form_post.title.value).length == 0) {
			ppp({
				content: '请输入标题后再操作',
				icon: 0,
				type: 3,
				complete: function(id) {
					$("body").scrollTop(0);
					form_post.title.focus();
				}
			});
			return false;
		}
		if(trim(form_post.content.value).length == 0) {
			ppp({
				content: '请输入内容后再操作',
				icon: 0,
				type: 3,
				complete: function(id) {
					$("body").scrollTop(0);
					if(typeof(PytEditor) != "undefined") {
						if($('#PytMainContent').css('display') == "none" || $('#PytMainContent').hasClass('pk-hide')) {
							form_post.content.focus();
						} else {
							PytEditor.body.focus();
						}
					} else {
						form_post.content.focus();
					}
				}
			});
			return false;
		}
		if(form_post.sortid.value == 0 && $_URI['TYPE'] == "read") {
			ppp({
				content: '请选择版块后再操作',
				icon: 0,
				type: 3,
				complete: function(id) {
					$("body").scrollTop(0);
					$("#showforum").click();
				}
			});
			return false;
		}
		var $label = $('#forumlabel a.pk-active'),
			$labelhtml = '';
		for(var i = 0; i < $label.length; i++) {
			$labelhtml += ',' + $($label[i]).html();
		}
		if($labelhtml) {
			$labelhtml = $labelhtml.substr(1);
			form_post.label.value = $labelhtml;
		}
		form_post.content.value = form_post.content.value.replace(/\<div/g, '<p');
		form_post.content.value = form_post.content.value.replace(/\<\/div\>/g, '</p>');
		//创建iframe框架
		var _tmpstyle_h = $('html').css('overflow-y');
		var _tmpstyle_b = $('body').css('overflow-y');
		var _pid = ppp({
			type: 1,
			title: "文章预览",
			content: '<iframe name="previewiframe" src="" style="width:100%;height:100%;border:0;overflow-y:scroll"></iframe>',
			area: ['100%', '100%', '0', 'auto', 'auto', '0'],
			submit: function(id, value) {
				$('#postbtn').click();
			},
			close: function(id) {
				$('html').css('overflow-y', _tmpstyle_h);
				$('body').css('overflow-y', _tmpstyle_b);
			}
		});
		$('#pkpopup_' + _pid + ' .pk-popup-body,body').css('overflow-y', 'hidden');
		$('#pkpopup_' + _pid + ' .pk-popup-foot>a:eq(0)').html('确认发布');
		//创建临时form
		if($('form[name="form_preview"]').length == 0) {
			$('body').append('<form class="pk-hide" target="previewiframe" name="form_preview" method="post" action="index.php?c=preview"><input type="hidden" name="sortid"><input type="hidden" name="label"><input type="hidden" name="title"><input type="hidden" name="content"></form>');
		}
		form_preview.sortid.value = form_post.sortid.value;
		form_preview.label.value = form_post.label.value;
		form_preview.title.value = form_post.title.value;
		form_preview.content.value = form_post.content.value;
		form_preview.submit();
	});
});