<?php
if (!defined('puyuetian'))
	exit('403');

$type = $_G['GET']['TYPE'];
$verifycode = Cstr($_POST['verifycode'], FALSE, TRUE, 1, 255);
$r = FALSE;
for ($rf = 0; $rf < 1; $rf++) {
	if ($type != 'read' && $type != 'reply') {
		$r = '参数错误';
		break;
	}
	if (time() - Cnum($_G['USER']['REGTIME']) < (Cnum($_G['SET']['NOVICETRAINEETIME']) * 60)) {
		$r = '新人见习期，见习时长' . Cnum($_G['SET']['NOVICETRAINEETIME']) . '分钟';
		break;
	}
	if (!chkVerifycode($verifycode, 'post' . $type)) {
		$r = '验证码错误';
		break;
	}
	$ss = time() - Cnum(JsonData($_G['USER']['DATA'], 'lasttime' . $type . 'posttime')) - Cnum($_G['SET']['POSTINGTIMEINTERVAL']);
	if ($ss < 0 && !InArray(getUserQX(), 'nopostingtimeinterval')) {
		$r = '您单身太久了，手速太快了，请等待 ' . (0 - $ss) . '秒 后再发布';
		break;
	}
	if ($_G['SET']['POST' . strtoupper($type) . 'CHECK'] && !InArray(getUserQX(), 'nopost' . $type . 'check') && !$postarray['del']) {
		$postarray['del'] = 2;
	}
	$r = Post($postarray, $type);
	break;
}

if (!Cnum($r)) {
	if ($_G['GET']['RETURN'] == 'json') {
		exit(json_encode(array('state' => 'no', 'msg' => $r)));
	} else {
		PkPopup('{
			content:"' . $r . '",
			icon:2,
			hideclose:true,
			shade:true,
			submit:function(){
				location.href="index.php?c=list"
			}
		}');
	}
}
//记录最后一次发布时间
$array['id'] = $_G['USER']['ID'];
$array['data'] = JsonData($_G['USER']['DATA'], 'lasttime' . $type . 'posttime', time());
$_G['TABLE']['USER'] -> newData($array);
if ($postarray['del'] < 2) {
	if ($_G['GET']['RETURN'] == 'json') {
		exit(json_encode(array('state' => 'ok', 'msg' => '发表成功', 'rid' => $r)));
	} else {
		header("Location:index.php?c=read&id={$r}&page=1&cache=refresh");
		exit();
	}
} else {
	if ($_G['GET']['RETURN'] == 'json') {
		exit(json_encode(array('state' => 'ok', 'msg' => '发表成功请等待审核通过', 'rid' => $r, 'check' => TRUE)));
	} else {
		PkPopup('{
			content:"发表成功请等待审核通过",
			icon:2,
			hideclose:true,
			shade:true
		}');
	}
}
