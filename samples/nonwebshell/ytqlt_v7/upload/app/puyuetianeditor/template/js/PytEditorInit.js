$(function() {
	InitPuyuetianEditor("textarea[name=content]", function() {
		$("#PytTiandouName").html($_SET['TIANDOUNAME']);
		$("#PytJifenName").html($_SET['JIFENNAME']);
		if((PytEditorHeight == '0' || !PytEditorHeight) && !(!!window.ActiveXObject || "ActiveXObject" in window) && $_URI['C'] == 'edit') {
			//自动增高模式
			var _h = $('#PytMainContent').outerHeight();
			var _th = _h;
			var _jl = $('#PytToolbar').offset().top;
			var _postjl = $('#postbtn').offset().top;
			var _wh = $(window).outerHeight();
			//增加浮动发布按钮
			$('body').append('<a id="_kjfban" class="pk-hadsky" href="javascript:" onclick="$(\'#postbtn\').click()" style="position:fixed;left:' + _jl + 'px;bottom:10px;border-radius:50%;color:white;background-color:#5FB878;text-align:center;width:48px;height:48px;line-height:48px;padding:0">发布</a>');
			$('#PytToolbar').css({
				top: 0,
				left: $('#PytToolbar').offset().left,
				width: $('#PytEditorFrame').outerWidth() - 2,
				'z-index': 999
			});
			setInterval(function() {
				//计算编辑器的实际高度
				var n = $(PytEditor.body).find('>*'),
					h = 0;
				for(var i = 0; i < n.length; i++) {
					h += parseInt($(n[i]).outerHeight());
				}
				if(h + 100 > parseInt(_h) && h != _th) {
					h += 100;
					_th = h;
					$('#PytMainContent,#PytMainContent2').outerHeight(h);
				}
				//工具框是否悬浮
				var jl = _jl - $("body").scrollTop();
				if(jl <= 0) {
					$('#PytToolbar').css({
						position: 'fixed'
					});
				} else {
					$('#PytToolbar').css({
						position: ''
					});
				}
				//发布按钮是否隐藏
				_postjl = $('#postbtn').offset().top;
				if(_postjl > _wh + $("body").scrollTop() - $('#postbtn').outerHeight() / 2) {
					$('#_kjfban').removeClass('pk-hide');
				} else {
					$('#_kjfban').addClass('pk-hide');
				}
			}, 200);
		}
	});
});