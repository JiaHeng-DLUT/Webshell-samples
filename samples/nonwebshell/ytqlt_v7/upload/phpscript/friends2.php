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
				NewMessage($_G['GET']['UID'], '<a class="pk-text-blod" target="_blank" href="index.php?c=user&id=' . $_G['USER']['ID'] . '">' . $_G['USER']['NICKNAME'] . '</a>把您添加为好友了，以后常联系~', 0, 2);
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
			$msgdatas = $_G['TABLE']['USER_MESSAGE'] -> getDatas(0, Cnum($_G['SET']['SHOWMESSAGECOUNT'], 50), "where (`uid`={$_G['USER']['ID']} and `fid`={$_G['GET']['UID']}) or (`uid`={$_G['GET']['UID']} and `fid`={$_G['USER']['ID']}) order by `id` desc");
			//更新数据库消息查看记录
			mysql_query("update `{$_G['MYSQL']['PREFIX']}user_message` set `islook`=1 where `uid`={$_G['USER']['ID']} and `fid`={$_G['GET']['UID']}");
			header('Content-Type: application/json');
			exit(json_encode($msgdatas));
		}
	} else {
		$friends = explode('__', substr($_G['USER']['FRIENDS'], 1, strlen($_G['USER']['FRIENDS']) - 2));
		$friendsarray = array();
		if ($friends) {
			$nmdatas = $_G['TABLE']['USER_MESSAGE'] -> getDatas(0, 0, array('islook' => 0, 'uid' => $_G['USER']['ID']));
			if ($nmdatas) {
				$nmfids = '';
				foreach ($nmdatas as $nmdata) {
					$nmfids .= ',' . $nmdata['fid'];
				}
				$nmfids2 = array_unique(explode(',', substr($nmfids, 1)));
				$nmfids = '';
				foreach ($nmfids2 as $value) {
					$nmfids .= ',' . $value;
				}
				$nmfids = substr($nmfids, 1);
			}
			foreach ($friends as $value) {
				$frienddata = $_G['TABLE']['USER'] -> getData($value);
				$array = array();
				$array['uid'] = $frienddata['id'];
				$array['username'] = $frienddata['username'];
				$array['nickname'] = $frienddata['nickname'];
				$array['sign'] = $frienddata['sign'];
				$array['sex'] = $frienddata['sex'];
				$friendsarray[] = $array;
			}
		}
		$friendsarray = json_encode($friendsarray);
		$_G['HTMLCODE']['OUTPUT'] .= template('friends', TRUE);
	}
} else {
	header('Location:index.php?c=login');
	//$_G['HTMLCODE']['TIP'] = '请登录后再操作';
	//$_G['HTMLCODE']['TIPJS'] = 'location.href="index.php"';
	//$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
}
