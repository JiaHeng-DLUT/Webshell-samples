<?php
if (!defined('puyuetian'))
	exit('403');

$page = Cnum($_G['GET']['PAGE'], 1, TRUE, 1);
$num = 20;
$spos = ($page - 1) * $num;

if ($_G['GET']['TYPE'] && !InArray('dynamic', $_G['GET']['TYPE']) && !$_G['USER']['ID']) {
	ExitJson('请登录后再操作');
}

switch ($_G['GET']['TYPE']) {
	case 'dynamic' :
		//读取动态及资料
		$_G['TEMPUSER'] = $_G['TABLE']['USER'] -> getData($_G['GET']['UID']);
		if (!$_G['TEMPUSER']) {
			ExitJson('不存在的用户');
		}
		standardArray($_G['TEMPUSER']);
		$query = mysql_query("select `id`,`posttime`,`title` as `t_r`,'read' as `table` from `{$_G['MYSQL']['PREFIX']}read` where `uid`={$_G['TEMPUSER']['ID']} and `del`=0 union all select `id`,`posttime`,`rid` as `t_r`,'reply' as `table` from `{$_G['MYSQL']['PREFIX']}reply` where `uid`={$_G['TEMPUSER']['ID']} and `del`=0 order by `posttime` desc limit {$spos},{$num}");
		$array = array();
		$index = 0;
		while ($_array = mysql_fetch_array($query, MYSQL_ASSOC)) {
			if ($_array['table'] == 'reply') {
				$_data = $_G['TABLE']['READ'] -> getData(array('id' => $_array['t_r'], 'del' => 0));
				if (!$_data) {
					continue;
				}
				$_array['title'] = $_data['title'];
				$_array['rid'] = $_data['id'];
			} else {
				$_array['title'] = $_array['t_r'];
				$_array['rid'] = $_array['id'];
			}
			$array[$index] = $_array;
			$index++;
		}
		ExitJson($array, TRUE);
		break;
	case 'idol' :
		if (!$_G['USER']['IDOL']) {
			ExitJson('404', TRUE);
		}
		$idoluids = explode('__', substr($_G['USER']['IDOL'], 1, strlen($_G['USER']['IDOL']) - 2));
		$array = array();
		$sql = '';
		$nns = array();
		foreach ($idoluids as $value) {
			if (Cnum($value, FALSE, TRUE, 1)) {
				$userdata = $_G['TABLE']['USER'] -> getData($value);
				if ($userdata) {
					$sql .= "`uid`='{$value}' or ";
					$nns[$value] = $userdata['nickname'];
				}
			}
		}
		if (!$sql) {
			ExitJson('404', TRUE);
		}
		$sql = '(' . substr($sql, 0, strlen($sql) - 4) . ')';
		$data = $_G['TABLE']['READ'] -> getDatas($spos, $num, "where {$sql} and del=0 order by `posttime` desc", FALSE, 'id,uid,title,posttime');
		foreach ($data as $key => $value) {
			$value['nickname'] = $nns[$value['uid']];
			$array[] = $value;
		}
		ExitJson($array, TRUE);
		break;
	case 'message' :
		$_data = $_G['TABLE']['USER_MESSAGE'] -> getDatas($spos, $num, "where `uid`={$_G['USER']['ID']} order by `addtime` desc");
		$array = array();
		foreach ($_data as $value) {
			if (!$value['fid']) {
				$value['username'] = '系统消息';
				$value['nickname'] = '系统消息';
			} else {
				$ud = $_G['TABLE']['USER'] -> getData($value['fid']);
				$value['username'] = $ud['username'];
				$value['nickname'] = $ud['nickname'];
			}
			$array[] = $value;
		}
		ExitJson($array, TRUE);
		break;
	case 'readmessage' :
		mysql_query("update `{$_G['MYSQL']['PREFIX']}user_message` set `islook`=1 where `uid`={$_G['USER']['ID']}");
		ExitJson('ok', TRUE);
	case 'friend' :
		$frienduids = explode('__', substr($_G['USER']['FRIENDS'], 1, strlen($_G['USER']['FRIENDS']) - 2));
		$array = array();
		foreach ($frienduids as $value) {
			$userdata = $_G['TABLE']['USER'] -> getData(Cnum($value, 0, TRUE, 1));
			if (!$userdata) {
				continue;
			}
			$array[] = array('uid' => $userdata['id'], 'username' => $userdata['username'], 'nickname' => $userdata['nickname'], 'sign' => $userdata['sign']);
		}
		ExitJson($array, TRUE);
		break;
	case 'collect' :
		$readids = explode('__', substr($_G['USER']['COLLECT'], 1, strlen($_G['USER']['COLLECT']) - 2));
		$array = array();
		foreach ($readids as $value) {
			$readdata = $_G['TABLE']['READ'] -> getData(Cnum($value, 0, TRUE, 1));
			if (!$readdata) {
				continue;
			}
			$array[] = array('id' => $readdata['id'], 'title' => $readdata['title'], 'posttime' => $readdata['posttime']);
		}
		ExitJson($array, TRUE);
		break;
	case 'addidol' :
		$userdata = $_G['TABLE']['USER'] -> getData(Cnum($_G['GET']['UID'], 0, TRUE, 1));
		if (!$userdata) {
			ExitJson('关注的用户不存在');
		}
		if ($_G['USER']['ID'] == $_G['GET']['UID']) {
			ExitJson('自己不能关注自己');
		}
		if (strpos($_G['USER']['IDOL'], "_{$_G['GET']['UID']}_") !== FALSE) {
			ExitJson('你已经关注过Ta了');
		}
		$_G['TABLE']['USER'] -> newData(array('id' => $_G['USER']['ID'], 'idol' => $_G['USER']['IDOL'] . "_{$_G['GET']['UID']}_"));
		$_G['TABLE']['USER'] -> newData(array('id' => $_G['GET']['UID'], 'fans' => $userdata['fans'] . "_{$_G['USER']['ID']}_"));
		ExitJson('关注成功', TRUE);
		break;
	case 'delidol' :
		if (strpos($_G['USER']['IDOL'], "_{$_G['GET']['UID']}_") === FALSE) {
			ExitJson('你未关注该用户');
		}
		$_G['TABLE']['USER'] -> newData(array('id' => $_G['USER']['ID'], 'idol' => str_replace("_{$_G['GET']['UID']}_", '', $_G['USER']['IDOL'])));
		$userdata = $_G['TABLE']['USER'] -> getData(Cnum($_G['GET']['UID'], 0, TRUE, 1));
		if ($userdata) {
			$_G['TABLE']['USER'] -> newData(array('id' => $_G['GET']['UID'], 'fans' => str_replace("_{$_G['USER']['ID']}_", '', $userdata['fans'])));
		}
		ExitJson('取关成功', TRUE);
		break;
	case 'addfriend' :
		if (!$_G['TABLE']['USER'] -> getData(Cnum($_G['GET']['UID'], 0, TRUE, 1))) {
			ExitJson('添加的用户不存在');
		}
		if ($_G['USER']['ID'] == $_G['GET']['UID']) {
			ExitJson('自己不能添加自己');
		}
		if (strpos($_G['USER']['FRIENDS'], "_{$_G['GET']['UID']}_") !== FALSE) {
			ExitJson('你已经添加过Ta了');
		}
		$_G['TABLE']['USER'] -> newData(array('id' => $_G['USER']['ID'], 'friends' => $_G['USER']['FRIENDS'] . "_{$_G['GET']['UID']}_"));
		ExitJson('添加成功', TRUE);
		break;
	case 'delfriend' :
		if (strpos($_G['USER']['FRIENDS'], "_{$_G['GET']['UID']}_") === FALSE) {
			ExitJson('你未添加该用户');
		}
		$_G['TABLE']['USER'] -> newData(array('id' => $_G['USER']['ID'], 'friends' => str_replace("_{$_G['GET']['UID']}_", '', $_G['USER']['FRIENDS'])));
		ExitJson('删除成功', TRUE);
		break;
	case 'addcollect' :
		//收藏这里的uid为文章的id
		$readdata = $_G['TABLE']['READ'] -> getData(Cnum($_G['GET']['UID'], 0, TRUE, 1));
		if (!$readdata) {
			ExitJson('收藏的文章不存在');
		}
		if (strpos($_G['USER']['COLLECT'], "_{$_G['GET']['UID']}_") !== FALSE) {
			ExitJson('你已经收藏过该文章了');
		}
		$_G['TABLE']['USER'] -> newData(array('id' => $_G['USER']['ID'], 'collect' => $_G['USER']['COLLECT'] . "_{$_G['GET']['UID']}_"));
		ExitJson('收藏成功', TRUE);
		break;
	case 'delcollect' :
		if (strpos($_G['USER']['COLLECT'], "_{$_G['GET']['UID']}_") === FALSE) {
			ExitJson('你未收藏该文章');
		}
		$_G['TABLE']['USER'] -> newData(array('id' => $_G['USER']['ID'], 'COLLECT' => str_replace("_{$_G['GET']['UID']}_", '', $_G['USER']['COLLECT'])));
		ExitJson('取消成功', TRUE);
		break;
	case 'submit' :
		$nickname = Cstr(htmlspecialchars(trim(strip_tags($_POST['nickname'])), ENT_QUOTES), FALSE, FALSE, 1, 25);
		$sex = Cstr($_POST['sex'], FALSE, 'gbs', 1, 1);
		$sign = Cstr(htmlspecialchars(trim(strip_tags($_POST['sign']), ''), ENT_QUOTES), FALSE, FALSE, 1, 255);
		//$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
		$qq = Cstr($_POST['qq'], FALSE, $_G['STRING']['NUMERICAL'], 5, 10);
		$phone = Cstr($_POST['phone'], FALSE, $_G['STRING']['NUMERICAL'], 11, 11);
		$data_privacysettings = Cnum($_POST['data-privacysettings']);
		$oldpassword = Cstr($_POST['oldpassword'], FALSE, FALSE, 5, 16);
		$password = Cstr($_POST['password'], FALSE, FALSE, 5, 16);
		$password2 = Cstr($_POST['password2'], FALSE, FALSE, 5, 16);
		$birthday = Cnum($_POST['birthday'], date('Ymd'), TRUE, 10000000, 99999999);
		$userhead = substr($_POST['userhead'], 22);
		if (strlen($userhead) > Cnum($_G['SET']['UPLOADHEADSIZE'], 512, TRUE, 0) * 1000) {
			$userhead = FALSE;
		}
		if ($_POST['_submittype'] == 1) {
			$id = Cnum($_POST['id'], 0, TRUE, 0);
			if ($_G['USER']['ID'] != $id && $_G['USER']['ID'] != 1 && !InArray(getUserQX(), 'superman')) {
				ExitJson('无权操作');
			}
			if (!$id) {
				ExitJson('修改资料的目标UID错误');
			}
			if (!$nickname) {
				ExitJson('昵称：不能为空且最多8个汉字');
			}
			if (!$sex) {
				ExitJson('性别数据不合法');
			}
			//检测用户信息是否包含违禁词
			$wjcs = $_G['SET']['BANREGWORDS'];
			if ($wjcs) {
				$wjcs = explode(',', $wjcs);
				foreach ($wjcs as $w) {
					if ($w) {
						if (strpos(str_replace(array("\n", "\r", "\r\n", "\t", " "), '', $sign), $w) !== FALSE || strpos(str_replace(array("\n", "\r", "\r\n", "\t", " "), '', $nickname), $w) !== FALSE) {
							ExitJson('昵称或签名包含违禁词，请修改后再保存');
						}
					}
				}
			}
			$userarray['id'] = $id;
			$userarray['nickname'] = $nickname;
			$userarray['sex'] = $sex;
			$userarray['sign'] = $sign;
			$userarray['qq'] = $qq;
			$userarray['phone'] = $phone;
			$userarray['birthday'] = $birthday;
			$userarray['adress'] = Cstr(htmlspecialchars(strip_tags($_POST['adress']), ENT_QUOTES), '', FALSE, 1, 999);
			if ($userhead && InArray(getUserQX($id), 'uploadhead')) {
				file_put_contents("{$_G['SYSTEM']['PATH']}/userhead/{$id}.png", base64_decode($userhead));
			}
		} elseif ($_POST['_submittype'] == 2) {
			$id = $_G['USER']['ID'];
			if ($oldpassword) {
				if (md5($oldpassword) != $_G['USER']['PASSWORD']) {
					ExitJson('原密码错误');
				}
				if (!$password) {
					ExitJson('请输入新密码，5-16位');
				}
				if ($password != $password2) {
					ExitJson('两次输入的密码不一致');
				}
				$userarray['password'] = md5($password);
			}
			$userarray['id'] = $id;
			$userarray['data'] = JsonData($_G['USER']['DATA'], 'privacysettings', $data_privacysettings);
		} else {
			ExitJson('提交参数非法');
		}
		if (!$_G['TABLE']['USER'] -> newData($userarray)) {
			ExitJson('出错：' . mysql_error());
		}
		ExitJson('保存成功', TRUE);
		break;
	default :
		if ($_G['GET']['TYPE']) {
			ExitJson('无效的参数');
		}
		break;
}

if (Cnum($_G['GET']['UID'], FALSE, TRUE, 1) && $_G['GET']['UID'] != $_G['USER']['ID']) {
	if (!InArray(getUserQX(), 'lookuser')) {
		if ($_G['USER']['ID']) {
			PkPopup('{title:"警告",content:"你无权浏览用户资料",icon:2,close:function(){location.href="index.php"},hideclose:true,shade:true}');
		} else {
			ExitGourl('index.php?c=login');
		}
	}
	$_G['TEMPUSER'] = $_G['TABLE']['USER'] -> getData($_G['GET']['UID']);
	if (!$_G['TEMPUSER']) {
		PkPopup('{content:"不存在的用户",icon:0,close:function(){location.href="index.php"},hideclose:true,shade:true}');
	}
	standardArray($_G['TEMPUSER']);
} else {
	if ($_G['USER']['ID']) {
		$_G['TEMPUSER'] = $_G['USER'];
	} else {
		ExitGourl('index.php?c=login');
	}
}

switch ($_G['TEMPUSER']['SEX']) {
	case 'g' :
		$_G['TEMPUSER']['SEX'] = '女';
		break;
	case 'b' :
		$_G['TEMPUSER']['SEX'] = '男';
		break;
	default :
		$_G['TEMPUSER']['SEX'] = '保密';
		break;
}
if ($_G['TEMPUSER']['BIRTHDAY']) {
	$_G['TEMPUSER']['BIRTHDAY'] = substr($_G['TEMPUSER']['BIRTHDAY'], 0, 4) . '年' . substr($_G['TEMPUSER']['BIRTHDAY'], 4, 2) . '月' . substr($_G['TEMPUSER']['BIRTHDAY'], 6) . '日';
}

$_G['TEMPUSER']['JIFEN'] = $_G['TEMPUSER']['JIFEN'] . '&nbsp;（Lv' . Cnum($_G['TEMPUSER']['JIFEN'] / 100) . '）';

//用户组
$_G['TEMPUSERGROUP'] = $_G['TABLE']['USERGROUP'] -> getData($_G['TEMPUSER']['GROUPID']);
standardArray($_G['TEMPUSERGROUP']);
if (!$_G['TEMPUSERGROUP']) {
	$_G['TEMPUSERGROUP']['USERGROUPNAME'] = '无';
} else {
	$_G['TEMPUSER']['READLEVEL'] = $_G['TEMPUSERGROUP']['READLEVEL'];
}
//隐私设置
if (JsonData($_G['TEMPUSER']['DATA'], 'privacysettings') && $_G['USER']['ID'] != $_G['TEMPUSER']['ID'] && $_G['USER']['ID'] != 1 && !InArray(getUserQX(), 'superman')) {
	$_G['TEMPUSER']['BIRTHDAY'] = $_G['TEMPUSER']['PHONE'] = $_G['TEMPUSER']['QQ'] = $_G['TEMPUSER']['EMAIL'] = $_G['TEMPUSER']['TIANDOU']= $_G['TEMPUSER']['ADDRESS']= $_G['TEMPUSER']['READLEVEL'] = '保密';
}

if ($_G['TEMPUSER']['FANS']) {
	$_G['TEMPUSER']['FANSCOUNT'] = count(explode('__', substr($_G['TEMPUSER']['FANS'], 1, strlen($_G['TEMPUSER']['FANS']) - 2)));
} else {
	$_G['TEMPUSER']['FANSCOUNT'] = 0;
}

$_G['TEMPUSER']['READCOUNT'] = $_G['TABLE']['READ'] -> getCount(array('uid' => $_G['TEMPUSER']['ID'], 'del' => 0));
$_G['TEMPUSER']['REPLYCOUNT'] = $_G['TABLE']['REPLY'] -> getCount(array('uid' => $_G['TEMPUSER']['ID'], 'del' => 0));

//seo优化
$_G['SET']['WEBKEYWORDS'] = "{$_G['TEMPUSER']['NICKNAME']}的个人主页,{$_G['TEMPUSER']['USERNAME']}";
$_G['SET']['WEBDESCRIPTION'] = "{$_G['TEMPUSER']['NICKNAME']}的个人资料，{$_G['TEMPUSER']['SIGN']}，{$_G['SET']['WEBADDEDWORDS']}";
$_G['SET']['WEBTITLE'] = "{$_G['TEMPUSER']['NICKNAME']}的个人主页" . ($page != 1 ? " - 第{$page}页" : '') . " - {$_G['SET']['WEBADDEDWORDS']}";

$_G['TEMPLATE']['BODY'] = 'center';
