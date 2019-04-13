var djs, $app_puyuetian_sms_verifycode = '';
$('#app-puyuetian_sms #getverifycode').click(function() {
	if(form_sms.phone.value.length != 11) {
		//pkalert('请输入正确的手机号码', 'js:form_sms.phone.focus()');
		pktip('请输入正确的手机号码', 'warning', 1500, function() {
			$('form[name="form_sms"] input[name="phone"]').focus();
		});
		return false;
	}
	if($xyyzm == "1") {
		pkalert('<div class="pk-row"><div class="pk-w-sm-12 pk-margin-bottom-5"><input id="sms-verifycode" class="pk-textbox" type="text" autocomplete="off" placeholder="请输入下方的验证码"></div><div class="pk-w-sm-12"><img class="pk-max-width-all pk-cursor-pointer" alt="验证码" src="index.php?c=app&a=verifycode:index&type=sms&rnd=' + Math.random() + '" onclick="this.src=\'index.php?c=app&a=verifycode:index&type=sms&rnd=\'+Math.random()" title="点击刷新"></div></div>', '身份验证', function() {
			if($('#sms-verifycode').val()) {
				$app_puyuetian_sms_verifycode = $('#sms-verifycode').val();
				sendsms();
				pkalert(false);
			} else {
				$('#sms-verifycode').focus();
			}
		}, true);
	} else {
		sendsms();
	}
});

function sendsms() {
	$.getJSON('index.php?c=app&a=hadskycloudserver:index&s=sms_send', {
		'phonenumber': form_sms.phone.value,
		'verifycode': $app_puyuetian_sms_verifycode,
		'chkcsrfval': $_USER['CHKCSRFVAL']
	}, function(data) {
		if(data['state'] == 'ok') {
			$('#app-puyuetian_sms #getverifycode').prop('disabled', true);
			$('#app-puyuetian_sms #getverifycode span:eq(0)').html('(');
			$('#app-puyuetian_sms #getverifycode span:eq(1)').html('60');
			$('#app-puyuetian_sms #getverifycode span:eq(2)').html('s)');
			djs = setInterval(function() {
				var sj = parseInt($('#app-puyuetian_sms #getverifycode span:eq(1)').html()) || 0;
				if(sj <= 0) {
					clearInterval(djs);
					$('#app-puyuetian_sms #getverifycode').prop('disabled', false);
					$('#app-puyuetian_sms #getverifycode span:eq(0)').html('');
					$('#app-puyuetian_sms #getverifycode span:eq(1)').html('');
					$('#app-puyuetian_sms #getverifycode span:eq(2)').html('');
				} else {
					sj--;
					$('#app-puyuetian_sms #getverifycode span:eq(1)').html(sj);
				}
			}, 1000);
		} else {
			pkalert((data['msg'] || '未知错误'));
		}
	});
}