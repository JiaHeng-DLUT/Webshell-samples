var PytEditor;
var PytWindow;
var PytContent;
var PytContentValue;

function LoadPytEditor() {
	//iframe可编辑化
	PytWindow = document.getElementById("PytMainContent").contentWindow;
	PytEditor = PytWindow.contentDocument || PytWindow.document;
	PytEditor.write('<!DOCTYPE html><html style="height:100%"><head><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta name="renderer" content="webkit"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"><title>puyuetianEditor</title><meta name="author" content="puyuetian qq632827168"><meta name="website" content="http://www.hadsky.com"><meta http-equiv="Cache-Control" content="no-siteapp"><link rel="stylesheet" href="template/puyuetianUI/css/font-awesome.min.css"><link rel="stylesheet" href="template/puyuetianUI/css/puyuetian.css"><link rel="stylesheet" href="app/puyuetianeditor/template/css/PytEditorContent.css"></head><body></body></html>');
	PytEditor.close();
	$(PytEditor.body).prop('spellcheck', false);
	PytEditor.body.contenteditable = true;
	if(PytEditor.designMode) {
		PytEditor.designMode = "on";
	}
	//表情驱动
	var emotionhtml = '';
	for(var $i = 1; $i < 33; $i++) {
		emotionhtml += '<img src="app/puyuetianeditor/template/img/emotion/' + $i + '.png" onclick="PytCmd(\'inserthtml\',false,\'<img width=\\\'32\\\' height=\\\'32\\\' src=\\\'app/puyuetianeditor/template/img/emotion/' + $i + '.png\\\' alt=\\\'emotion\\\'>\');PytSH(\'.PytDiv.Emotion\')">';
	}
	//自定义的表情列表
	for(var $i = 1; $i < 31; $i++) {
		emotionhtml += '<img src="app/puyuetianeditor/template/img/loveemotion/emoji-' + $i + '.png" onclick="PytCmd(\'inserthtml\',false,\'<img width=\\\'32\\\' height=\\\'32\\\' src=\\\'app/puyuetianeditor/template/img/loveemotion/emoji-' + $i + '.png\\\' alt=\\\'emotion\\\'>\');PytSH(\'.PytDiv.Emotion\')">';
	}
	$('.PytDiv.Emotion>div:eq(0)').html(emotionhtml);
	//读取配置，开始加载按钮
	if(PytConfig) {
		var PytConfigArray = PytConfig.split(',');
		for($i = 0; $i < PytConfigArray.length; $i++) {
			$('#PytToolbar').append($('#PytToolbarBtns #Pyt' + PytConfigArray[$i] + 'Btn').parent('div').html());
		}
	}
	$('#PytToolbarBtns').html('');
	//赋予工具按钮点击特效及工具图标处理
	var PytToolbarSpans = $('#PytToolbar span');
	for($i = 0; $i < PytToolbarSpans.length; $i++) {
		$(PytToolbarSpans[$i]).attr('onclick', $(PytToolbarSpans[$i]).attr('onclick') + ';SthisBtn(this)').css({
			"background-image": "url(app/puyuetianeditor/template/img/toolicons/" + $(PytToolbarSpans[$i]).attr("id").toString().replace(/Pyt|Btn/g, '').toLowerCase() + ".png)"
		});
	}
}

//基本命令驱动
function PytCmd($p1, $p2, $p3) {
	if($('#PytMainContent').css('display') == 'none') {
		$('#PytMainContent2').val($('#PytMainContent2').val() + $p3);
	} else {
		PytEditor.body.focus();
		if(((PytEditor.selection && (navigator.userAgent.indexOf('MSIE') >= 0) && (navigator.userAgent.indexOf('Opera') < 0)) || (!!window.ActiveXObject || "ActiveXObject" in window)) && $p1 == 'inserthtml') {
			PytEditor.body.innerHTML += $p3;
		} else {
			PytEditor.execCommand($p1, $p2, $p3);
		}
	}
}

function PytSH($id, This) {
	if($($id).css('display') == 'none') {
		$('.PytDiv').css('display', 'none');
		$($id).css('display', 'block');
	} else {
		$($id).css('display', 'none');
	}
	var $ls = 'Link,Emotion,Image,Video,Music,File,Myfiles,Replylook,Code,Table';
	$ls = $ls.split(',');
	for(var i = 0; i < $ls.length; i++) {
		$('#PytToolbar #Pyt' + $ls[i] + 'Btn').removeClass('pk-active');
	}
	if(!This) {
		return false;
	}
	var _t = ($(window).outerHeight() - $($id).outerHeight()) / 2;
	var _l = ($(window).outerWidth() - $($id).outerWidth()) / 2;
	if(_t < 0) {
		_t = 0;
	}
	if(_l < 0) {
		_l = 0;
	}
	$('.PytDiv').css({
		'position': 'fixed',
		'left': _l,
		'top': _t
	});
}

//查看html源码
function PytLookHtml() {
	if($('#PytMainContent2').css('display') == 'none') {
		$('#PytMainContent2').val(PytEditor.body.innerHTML);
		$('#PytMainContent').css('display', 'none');
		PytEditor.body.innerHTML = '';
		$('#PytMainContent2').css('display', '');
	} else {
		PytEditor.body.innerHTML = $('#PytMainContent2').val();
		$('#PytMainContent').css('display', '');
		$('#PytMainContent2').css('display', 'none');
		$('#PytMainContent2').val('');
	}
}

function PytInsertLink() {
	var url = trim($('#PytLinkUrl').val());
	var text = trim($('#PytLinkText').val());
	if(!url || InArray('http://,https://,//', url)) {
		ppp({
			type: 3,
			icon: 0,
			content: "链接不能为空"
		});
		return false;
	}
	if(!text) {
		text = url;
	}
	PytCmd('inserthtml', false, '<a target="_blank" href="' + url + '">' + text + '</a>');
	$('#PytLinkUrl,#PytLinkText').val('');
	PytSH('.PytDiv.Link');
}

function PytInsertImage() {
	var urls = $('#PytImagesBox>div>img.pk-active');
	var w = parseInt($('#PytImageWidth').val());
	var h = parseInt($('#PytImageHeight').val());
	if(!urls.length) {
		ppp({
			type: 3,
			icon: 0,
			content: "请选择要插入的图片后再点击"
		});
		return false;
	}
	if(!w) {
		w = '';
	} else {
		w = ' width="' + w + '"';
	}
	if(!h) {
		h = '';
	} else {
		h = ' height="' + h + '"';
	}
	for(var i = 0; i < urls.length; i++) {
		$(urls[i]).removeClass('pk-active').next('i').removeClass('pk-active');
		PytCmd('inserthtml', false, '<img src="' + $(urls[i]).attr('src') + '" alt="Image"' + w + h + ' />');
	}
	PytSH('.PytDiv.Image');
}

function PytAddRemoteImage() {
	ppp({
		type: 2,
		title: "请输入远程图片的地址链接，多个用回车分开",
		noclose: true,
		inputtype: 'textarea',
		submit: function(id, value) {
			if(!value || InArray('http://,//,https://', value)) {
				$('#pkpopup_' + id + ' .pk-popup-body textarea').focus();
				return false;
			}
			PytAddImageInbox(value);
			pkpopup.close(id);
		}
	});
}

function PytAddImageInbox($array) {
	if(typeof($array) == "string") {
		$array = $array.split("\n");
	}
	if(typeof($array) != "object") {
		return false;
	}
	for(var i = 0; i < $array.length; i++) {
		if(!$array[i] || InArray('http://,//,https://', $array[i])) {
			continue;
		}
		var url = $array[i].replace(/"/g, '&quot;');
		$('#PytImagesBox').append('<div class="pk-w-sm-3 pk-margin-bottom-10"><i class="fa fa-trash-o" onclick="PytDelImage(this)"></i><img src="' + url + '" alt="' + url + '" class="pk-active"><i class="fa fa-check pk-active" onclick="PytChoseImage(this)"></i></div>');
	}
}

function PytDelImage(This) {
	ppp({
		type: 1,
		icon: 3,
		content: "确认从列表移除该图片吗？",
		submit: function() {
			$(This).parent().remove();
		}
	});
}

function PytChoseImage(This) {
	$(This).toggleClass('pk-active').parent().find('img').toggleClass('pk-active');
}

function PytInsertMusic() {
	var url = trim($('#PytMusicUrl').val());
	if(!url || InArray('http://,//,https://', url)) {
		ppp({
			type: 3,
			icon: 0,
			content: "音频URL不能为空"
		});
		return false;
	}
	var cs = '';
	if($('input[name="PytMusicAutoplay"]').prop('checked')) {
		cs += ' autoplay';
	}
	if($('input[name="PytMusicLoop"]').prop('checked')) {
		cs += ' loop';
	}
	var suffix = url.split('.')[url.split('.').length - 1];
	if(suffix.length > 5) {
		suffix = 'mp3';
	}
	PytCmd('inserthtml', false, '<p><audio src="' + url + '" controls' + cs + '><source src="' + url + '" type="audio/' + suffix + '" /><embed src="' + url + '" /></audio></p><p><br></p>');
	$('#PytMusicUrl').val('');
	PytSH('.PytDiv.Music');
}

function PytRemoveMarks() {
	var st = '';
	try {
		if(PytWindow.getSelection) {
			st = PytWindow.getSelection().getRangeAt(0).cloneContents();
			var testDiv = document.createElement("div");
			testDiv.appendChild(st);
			st = testDiv.innerHTML;
		} else {
			st = PytWindow.selection.createRange().htmlText;
		}
	} catch(e) {
		ppp({
			type: 3,
			icon: 2,
			content: "未选中任何内容或浏览器不支持"
		});
		return false;
	}
	st = st.toString();
	if(st == "") {
		ppp({
			type: 3,
			icon: 0,
			content: "请先选中需要清除格式的内容"
		});
		return false;
	}
	st = st.replace(/<(?!\/?br\/?.+?>|\/?img.+?>)[^<>]*>/gi, "");
	ppp({
		type: 1,
		title: "清除格式",
		content: "确认清除选中的内容HTML格式吗？",
		submit: function(id) {
			PytCmd('inserthtml', false, st);
		}
	});
}

function SthisBtn(me) {
	var $nos = 'PytUnlinkBtn,PytRemovemarksBtn,PytUndoBtn,PytRedoBtn';
	$nos = $nos.split(',');
	if($nos.indexOf($(me).attr('id')) > -1) {
		return false;
	}
	if($(me).hasClass('pk-active')) {
		$(me).removeClass('pk-active');
	} else {
		//$('#PytToolbar span').removeClass('pk-active');
		$(me).addClass('pk-active');
	}
}

function PytInsertFile() {
	var turl;
	var url = trim($('#PytFileUrl').val());
	var name = trim($('#PytFileName').val());
	var tiandou = parseInt($('#PytFileTiandou').val());
	var jifen = parseInt($('#PytFileJifen').val());
	if(!url || InArray('http://,//,https://', url)) {
		ppp({
			type: 3,
			icon: 0,
			content: "文件URL不能为空"
		});
		return false;
	}
	if(!name) {
		name = url;
	}
	if(!tiandou) {
		tiandou = 0;
	}
	if(!jifen) {
		jifen = 0;
	}
	name = name.replace(/[\<\>]/g, '');
	url.indexOf('?') < 0 ? turl = url + '?' : turl = url + '&';
	turl += 'tiandou=' + tiandou + '&jifen=' + jifen + '&name=' + encodeURIComponent(name);
	PytCmd('inserthtml', false, '<a class="pk-text-primary pk-hover-underline" target="_blank" href="' + turl + '" title="点击进入下载"><span class="fa fa-download fa-fw"></span>' + name + '</a>');
	$('#PytFileUrl,#PytFileName,#PytFileTiandou,#PytFileJifen').val('');
	PytSH('.PytDiv.File');
}

function PytInsertTable() {
	var $r = Cnum($('#PytTableRow').val(), false, true, 1),
		$c = Cnum($('#PytTableCol').val(), false, true, 1),
		$b = Cnum($('#PytTableBorder').val()) || false,
		$w = Cnum($('#PytTableWidth').val()) || false,
		$h = '';
	if(!$r || !$c) {
		ppp({
			type: 3,
			icon: 2,
			content: "行或列不能小于1"
		});
		return false;
	}
	for(var i = 0; i < $r; i++) {
		$h += '<tr>';
		for(var j = 0; j < $c; j++) {
			$h += '<td>' + ($b ? '' : (j + 1)) + '</td>';
		}
		$h += '</tr>';
	}
	PytCmd('inserthtml', false, '<table class="pk-table' + ($b ? ' pk-table-bordered' : '') + ($w ? ' pk-width-all' : '') + '">' + $h + '</table><p><br></p>');
	//绑定删除事件
	$(PytEditor).find('table:last').on('dblclick', function(e) {
		if(e.which == 1) {
			var This = $(this);
			ppp({
				type: 1,
				icon: 3,
				content: "是否删除当前表格？",
				submit: function() {
					This.remove();
				}
			});
		}
	});
	$('#PytTableRow,#PytTableCol').val(3);
	PytSH('.PytDiv.Table');
}

function PytInsertCode() {
	var $code = $('#PytCodeTextarea').val();
	if($code) {
		var div = document.createElement('div');
		div.appendChild(document.createTextNode($code));
		$code = div.innerHTML;
		PytCmd('inserthtml', false, '<pre>' + $code + '</pre><br>');
		$('#PytCodeTextarea').val('');
		PytSH('.PytDiv.Code');
	} else {
		$('#PytCodeTextarea').focus();
	}
}

function PytInsertRemoteFile() {
	ppp({
		title: "请输入远程文件的链接地址",
		type: 2,
		noclose: true,
		submit: function(id, url) {
			if(!url || InArray('http://,//,https://', url)) {
				ppp({
					type: 3,
					icon: 0,
					content: "地址不能为空"
				});
				return false;
			}
			$('#pkpopup_' + id + ' .pk-popup-foot>a:eq(0)').html('正在处理...').addClass('disabled');
			$.getJSON('index.php?c=app&a=puyuetianeditor:index&s=remotelink', {
				"url": url,
				"chkcsrfval": $_USER['CHKCSRFVAL']
			}, function(data) {
				if(data['state'] == 'ok') {
					$('#PytFileUrl').val("index.php?c=app&a=puyuetianeditor:index&s=showfile&id=" + data['datas']['msg']);
					ppp({
						type: 3,
						icon: 1,
						content: "远程链接添加成功"
					});
				} else {
					ppp({
						type: 0,
						icon: 2,
						content: data['datas']['msg']
					});
				}
				pkpopup.close(id);
			});
		}
	});
}

function PytInsertReplylook() {
	var $code = $('#PytReplylookTextarea').val();
	if($code) {
		var div = document.createElement('div');
		div.appendChild(document.createTextNode($code));
		$code = div.innerHTML;
		PytCmd('inserthtml', false, '<br><p class="PytReplylook">' + $code + '</p><br>');
		$('#PytReplylookTextarea').val('');
		PytSH('.PytDiv.Replylook');
	} else {
		$('#PytReplylookTextarea').focus();
	}
}

function PytInsertVideo() {
	var $code = $('#PytVideoUrl').val(),
		html = '',
		bdbox = '<p><br></p>[CONTENT]<p><br></p>';
	if($code) {
		if($code.indexOf('<') == -1) {
			var cs = '';
			if($('input[name="PytVideoAutoplay"]').prop('checked')) {
				cs += ' autoplay';
			}
			if($('input[name="PytVideoWidth"]').val()) {
				cs += ' width="' + $('input[name="PytVideoWidth"]').val() + '"';
			}
			if($('input[name="PytVideoHeight"]').val()) {
				cs += ' height="' + $('input[name="PytVideoHeight"]').val() + '"';
			}
			var suffix = $code.split('.')[$code.split('.').length - 1];
			if(suffix.length > 5) {
				suffix = 'mp4';
			}
			html = '<video src="' + $code + '" controls' + cs + ' style="max-width:100%"><source src="' + $code + '" type="video/' + suffix + '" /><embed src="' + $code + '" /></video>';
		} else {
			html = $code;
		}
		if($('input[name="PytVideoBorder"]').prop('checked')) {
			bdbox = '<p style="width:100%;border:2px solid #eee;margin:5px 0"></p>';
			bdbox += '<p style="text-align:center">[CONTENT]</p>';
			bdbox += '<p style="width:100%;border:2px solid #eee;margin:5px 0"></p>';
			bdbox += '<p><br></p>';
		}
		PytCmd('inserthtml', false, bdbox.replace(/\[CONTENT\]/g, html));
		$('#PytVideoUrl').val('');
		PytSH('.PytDiv.Video');
	} else {
		$('#PytVideoUrl').focus();
	}
}

function PytSubmit() {
	if(!PytContent.val()) {
		pkalert('请先输入内容后再点击');
		return false;
	}
}

function InitPuyuetianEditor($id, $flashcode) {
	//编辑器初始化
	PytContent = $($id);
	PytContentValue = PytContent.val();
	var $parent = PytContent.parent();
	var $parentform = $($id).parents('form');
	if($parentform) {
		//$parentform.attr('onsubmit', 'return PytSubmit()');
		$parentform.attr('novalidate', true);
		if($parent) {
			$h = PytContent.height();
			if(typeof(PytEditorHeight) != "undefined") {
				if((PytEditorHeight != '0' && PytEditorHeight) && !(!!window.ActiveXObject || "ActiveXObject" in window) && $_URI['C'] == 'edit') {
					$h = PytEditorHeight;
				}
			}
			PytContent.css('display', 'none');
			//PytContent.prop('required', false);
			$parent.append('<div id="PytEditorDriveDiv"></div>');
			$('#PytEditorDriveDiv').load('app/puyuetianeditor/template/PytEditorHtml.html', function(r, s, x) {
				if(s == 'success') {
					LoadPytEditor();
					$('#PytMainContent,#PytMainContent2').outerHeight($h);
					//原有内容的载入
					if((PytEditor.selection && (navigator.userAgent.indexOf('MSIE') >= 0) && (navigator.userAgent.indexOf('Opera') < 0)) || (!!window.ActiveXObject || "ActiveXObject" in window)) {
						setTimeout(function() {
							//IE就TM讨厌，还TM得延迟上，CNM
							$("#PytToolbar").append('<span id="PytIEoutBtn" class="fa fa-internet-explorer" title="更佳的体验" onclick="ppp(\'建议您使用非IE浏览器获取更佳体验^o^\')" style="display:inline-block;color:#CC6666"></span> ');
							PytEditor.body.focus();
							PytCmd('inserthtml', false, PytContentValue);
						}, 1000);
					} else {
						if(PytContentValue)
							PytCmd('inserthtml', false, PytContentValue);
					}
					//加载完成后执行
					if($flashcode) {
						$flashcode();
					}
					//动态实时更新内容
					setInterval(function() {
						var html = $(PytEditor.body).html();
						var text = $('#PytMainContent2').val();
						if(html) {
							PytContent.val(html);
						} else {
							PytContent.val(text);
						}
						//保存当前编辑进度
						if($('#app_puyuetianeditor_editcontent_autosave').text() != 'no' && PytContent.val() && !Cnum($_URI['ID']) && $_URI['C'] == 'edit') {
							setCookie('app_puyuetianeditor_editcontent', PytContent.val());
						}
					}, 200);
					//是否存在进度
					if(!Cnum($_URI['ID']) && $_URI['C'] == 'edit') {
						var _a = getCookie('app_puyuetianeditor_editcontent');
						if(_a) {
							ppp({
								type: 1,
								icon: 3,
								content: "是否恢复上次编辑的内容？",
								submit: function() {
									PytCmd('inserthtml', false, _a);
								},
								cancel: function() {
									setCookie('app_puyuetianeditor_editcontent', '', 1);
								}
							});
						}
					}
				}
			});
		}
	}
}