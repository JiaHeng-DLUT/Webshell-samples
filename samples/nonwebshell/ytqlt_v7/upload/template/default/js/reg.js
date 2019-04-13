$(function() {
	$('#hadsky-regbox input').keydown(function(e) {
		if(e.keyCode == 13 && !$('#regbtn').prop('disabled')) {
			$('#regbtn').click();
		}
	});

	//自动头像
	var b_base64 = 'data:image/png;base64,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';
	var g_base64 = 'data:image/png;base64,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';
	if(_autohead) {
		$('#sexSelect').on('change', function() {
			var _base64 = b_base64;
			if(this.value == 'g') {
				_base64 = g_base64;
			}
			$('#uploaduserheadbox').attr('src', _base64);
			$('input[name="userhead"]').val(_base64);
		}).change();
	}

	$('#regbtn').click(function() {
		if(!trim(form_reg.username.value)) {
			ppp({
				type: 3,
				content: "请填写用户名",
				icon: 0,
				close: function() {
					form_reg.username.focus();
				}
			});
			return false;
		}
		if(!trim(form_reg.email.value)) {
			ppp({
				type: 3,
				content: "请填写邮箱",
				icon: 0,
				close: function() {
					form_reg.email.focus();
				}
			});
			return false;
		}
		if(!trim(form_reg.password.value)) {
			ppp({
				type: 3,
				content: "请填写密码",
				icon: 0,
				close: function() {
					form_reg.password.focus();
				}
			});
			return false;
		}
		$(this).prop('disabled', true).html('注册中...');
		var formstring = FormDataPackaging('form[name="form_reg"]:eq(0)');
		$.post($('form[name="form_reg"]:eq(0)').attr('action'), formstring, function(data) {
			if(data['state'] == 'ok') {
				ppp({
					type: 4,
					content: "注册成功，即将跳转至个人中心",
					complete: function() {
						location.href = "index.php?c=user";
					}
				});
			} else {
				$('form[name="form_reg"] input[name="verifycode"]').val('');
				$('#verifycodeimageobject').click();
				ppp({
					content: (data['msg'] || '未知错误'),
					icon: 2,
					complete: function() {
						$('#regbtn').prop('disabled', false).html('立即注册');
					}
				});
			}
		}, 'json').error(function() {
			$('form[name="form_reg"]').attr('action', $('form[name="form_reg"]').attr('action').replace('&return=json', ''));
			form_reg.submit();
		});
	});
	$('#uploaduserheadbox').on({
		click: function() {
			var id = '_tmp_' + randomString(7);
			$('body').append('<div class="pk-hide" id="div' + id + '"></div>');
			$('#div' + id).append('<input type="file" id="file' + id + '" accept="image/*">');
			$('#file' + id).on('change', function() {
				$('#uploaduserheadbox').on('load', function() {
					$('#sexSelect').unbind('change');
					var _b = ImageToBase64($('#uploaduserheadbox')[0], '150', '150');
					$(form_reg.userhead).val(_b);
					$('#div' + id).remove();
				}).attr('src', getLocalFileUrl(this));
			}).click();
		},
		mouseover: function() {
			$('#uploaduserheadbox_bg').removeClass('pk-hide');
		}
	}).after('<div id="uploaduserheadbox_bg" class="pk-hide" title="上传自定义头像" style="background-color:#000;opacity:.7;background-image:url(\'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABsAAAAYCAYAAAALQIb7AAACFklEQVRIS7WWy23bQBCGZyAeuLpYugjY2UPcQZQKIndgV2C5gigVxB2EHUTqwB1Y7oDpwD5wF9BFyoUSIAETjME1FqTEhyDzRHDJ/eax/z9EAADn3JSZ7+X+My5EXGit57herwfb7Xb9GZBwT6XUEJ1zE2Z+Zua/xpjxpaFZlqWI+BURbz5gAPBCRJMQ5py7juN4MxwON+cGYa1dAsD3Wpi1dg4Avo9LpdTdOdBGWHFg/gDAGzNvpAwAsCCiadcMG2HW2gQAfkjqcRynxQGqlPkU2Fp7K2tE9NQGNgOA38wszZV+SS9bZear4g9cI0yi8i8V0b8opW6behaU/18URZPRaJS2ghViv+71egP5qKlXx0Bh0I1Hvwng10+BOsNEa6ITrfXiGLwO1Am2Wq3G+/3+GREHzDw3xjyURC+eKhL56FE5oFY9C0F+A0R8EEMNzLsW1CqzEmgRRVFyOBzEdq4EKJucyqgwdgnilYh+FpodR1E0q3hjGeRdQ557YJFppXQCyvNcyv5u6OXSV2DWWhHx1TERB0DwOvIlLoP88xB4DCblSolIXKRyyaa73W6gtX4NF7Mse0TEXxKkGLg4iKz78aK1XtaOmLY6k/eKXk2JKLHWsowscZ08z2f9fj8R9wmHZ2qM+dYFUGPE77DyfLzYbwERoYf7zCqwQDOPAPDl3Mxaw84FdC7jpUGFaySI+CQnMNz/Pz8bBn43541aAAAAAElFTkSuQmCC\');background-repeat:no-repeat;background-position:center center;position:absolute;height:80px;width:80px;top:0;border-radius:50%;cursor:pointer"></div>');
	$('#uploaduserheadbox_bg').css({
		left: ($('#uploaduserheadbox_bg').parent().outerWidth() - $('#uploaduserheadbox_bg').outerWidth()) / 2
	}).on({
		click: function() {
			$('#uploaduserheadbox').click();
		},
		mouseout: function() {
			$(this).addClass('pk-hide');
		}
	});
});

function regagreement() {
	var _txt = $('#regagreement_txt').html();
	_txts = _txt.split(/\n/g);
	_txt = '';
	for(var i = 0; i < _txts.length; i++) {
		if(_txts[i][0] != '<') {
			_txt += '<p style="text-indent:2em">' + _txts[i] + '</p>';
		} else {
			_txt += _txts[i];
		}
	}
	ppp({
		type: 0,
		shade: true,
		nomove: true,
		hideclose: true,
		title: "用户注册协议",
		area: $(window).width() < 1000 ? ['100%', '100%'] : ['600px', '80%'],
		content: _txt
	});
}