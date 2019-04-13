<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['USER']['ID']) {
	if (isset($_G['GET']['UID'])) {
		$_G['GET']['UID'] = Cnum($_G['GET']['UID'], 0, TRUE, 0);
		$array = array();
		$array['id'] = $_G['USER']['ID'];
		if ($_G['GET']['TYPE'] == 'add') {
			if ($_G['GET']['UID'] && $_G['GET']['UID'] != $_G['USER']['ID']) {
				$array['friends'] = str_replace("_{$_G['GET']['UID']}_", '', $_G['USER']['FRIENDS']);
				$array['friends'] .= "_{$_G['GET']['UID']}_";
				NewMessage($_G['GET']['UID'], '<a class="pk-text-bold" target="_blank" href="index.php?c=user&id=' . $_G['USER']['ID'] . '">' . $_G['USER']['NICKNAME'] . '</a>把您添加为好友了，以后常联系~', 0, 2);
				$_G['TABLE']['USER'] -> newData($array);
				exit('ok');
			} else {
				exit('fail');
			}
		} elseif ($_G['GET']['TYPE'] == 'del') {
			$array['friends'] = str_replace("_{$_G['GET']['UID']}_", '', $_G['USER']['FRIENDS']);
			$_G['TABLE']['USER'] -> newData($array);
			exit('ok');
		} else {
			//$msgdatas = $_G['TABLE']['USER_MESSAGE'] -> getDatas(0, Cnum($_G['SET']['SHOWMESSAGECOUNT'], 50), "where (`uid`={$_G['USER']['ID']} and `fid`={$_G['GET']['UID']}) or (`uid`={$_G['GET']['UID']} and `fid`={$_G['USER']['ID']}) order by `id` desc");
			//更新数据库消息查看记录
			mysql_query("update `{$_G['MYSQL']['PREFIX']}user_message` set `islook`=1 where `uid`={$_G['USER']['ID']} and `fid`={$_G['GET']['UID']}");
			//header('Content-Type: application/json');
			//exit(json_encode($msgdatas));
			exit('ok');
		}
	} else {
		//朋友数据
		$friends = explode('__', substr($_G['USER']['FRIENDS'], 1, strlen($_G['USER']['FRIENDS']) - 2));
		$friends = array_unique($friends);
		$friendsarray = $messagearray = array();
		$array['uid'] = 0;
		$array['username'] = 'system message';
		$array['nickname'] = '系统消息';
		$array['sign'] = '系统消息';
		$array['sex'] = 's';
		$array['messagecount'] = $_G['TABLE']['USER_MESSAGE'] -> getCount(array('fid' => 0, 'uid' => $_G['USER']['ID'], 'islook' => FALSE));
		$friendsarray[] = $array;
		foreach ($friends as $value) {
			$frienddata = $_G['TABLE']['USER'] -> getData($value);
			if ($frienddata) {
				$array = array();
				if (strpos($frienddata['friends'], '_' . $_G['USER']['ID'] . '_') !== FALSE) {
					$array['isfriend'] = 1;
				} else {
					$array['isfriend'] = 0;
				}
				$array['uid'] = $frienddata['id'];
				$array['username'] = $frienddata['username'];
				$array['nickname'] = $frienddata['nickname'];
				$array['sign'] = $frienddata['sign'];
				$array['sex'] = $frienddata['sex'];
				$array['messagecount'] = $_G['TABLE']['USER_MESSAGE'] -> getCount(array('fid' => $array['uid'], 'uid' => $_G['USER']['ID'], 'islook' => FALSE));
				$friendsarray[] = $array;
			}
		}
		if ($friendsarray) {
			$isfriendsarray = 1;
			$friendsarray = json_encode($friendsarray);
		} else {
			$isfriendsarray = $friendsarray = '';
		}
		//消息数据
		$messagearray = $_G['TABLE']['USER_MESSAGE'] -> getDatas(0, 0, "where (`uid`={$_G['USER']['ID']} or `fid`={$_G['USER']['ID']}) order by `id` desc");
		if ($messagearray) {
			$ismessagearray = 1;
			$messagearray = json_encode($messagearray);
		} else {
			$ismessagearray = $messagearray = '';
		}
	}
	$_G['HTMLCODE']['OUTPUT'] .= template('friends', TRUE);
} else {
	header('Location:index.php?c=login');
	//$_G['HTMLCODE']['TIP'] = '请登录后再操作';
	//$_G['HTMLCODE']['TIPJS'] = 'location.href="index.php"';
	//$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
}
