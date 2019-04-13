<?php
if (!defined('puyuetian'))
	exit('403');

$table = $_G['GET']['TABLE'];
$r = '操作成功';
switch ($table) {
	case 'set' :
		//set表删除
		$_G['TABLE']['SET'] -> delData(Cnum($_G['GET']['ID'], 0, TRUE, 0));
		break;
	case 'plug' :
	case 'readsort' :
	case 'upload' :
	case 'download' :
	case 'user' :
		if ($table == 'upload' || $table == 'download') {
			$fileinfo = $_G['TABLE'][strtoupper($table)] -> getData($id);
			if ($fileinfo) {
				$uid = $fileinfo['uid'];
				$filename = $fileinfo['filename'];
				@unlink("{$_G['SYSTEM']['PATH']}/uploadfiles/{$uid}/{$filename}");
			}
		}
		/*
		 * 删除版块
		 */
		if ($table == 'readsort') {
			//判断该版块下是否还有自版块
			$childbk = $_G['TABLE']['READSORT'] -> getData(array('pid' => $_G['GET']['ID']));
			if (!$childbk) {
				$readdatas = $_G['TABLE']['READ'] -> getDatas(array('sortid' => $_G['GET']['ID']));
				if ($readdatas) {
					//删除文章下的回复
					foreach ($readdatas as $value) {
						//进回收站
						mysql_query("update `{$_G['MYSQL']['PREFIX']}reply` set `del`=1 where `rid`={$value['id']}");
						//直接删除
						//$_G['TABLE']['REPLY'] -> delData(array('rid' => $value['id']));
					}
				}
				//删除文章
				//进回收站
				mysql_query("update `{$_G['MYSQL']['PREFIX']}read` set `del`=1 where `sortid`={$_G['GET']['ID']}");
				//直接删除
				//$_G['TABLE']['READ'] -> delData(array('sortid' => $_G['GET']['ID']));

				$_G['TABLE'][strtoupper($table)] -> delData($_G['GET']['ID']);
			} else {
				$r = '请先删除该板块下的子版块';
			}
		}
		//删除用户
		if ($table == 'user') {
			if (!$_G['GET']['ID'] || $_G['GET']['ID'] == 1) {
				$r = '错误的用户ID或无法删除创始人';
			} else {
				$_G['TABLE']['USER'] -> delData($_G['GET']['ID']);
			}
		}
		break;
	case 'read' :
	case 'reply' :
		$ids = (array)$_POST['ids'];
		/*delcmd 0:正常 1:移动至回收站 2:移动至审核区 del:删除*/
		foreach ($ids as $id) {
			$id = Cnum($id);
			if ($id) {
				if ($_POST['delcmd'] == 'del') {
					$_G['TABLE'][strtoupper($table)] -> delData($id);
					if ($table == 'read') {
						$_G['TABLE']['REPLY'] -> delData(array('rid' => $id));
					}
				} else {
					$array = array();
					$array['id'] = $id;
					$array['del'] = Cnum($_POST['delcmd']);
					$_G['TABLE'][strtoupper($table)] -> newData($array);
					//还原或审核通过加分给指定用户
					if (!$array['del']) {
						$lsdata = $_G['TABLE'][strtoupper($table)] -> getData($array['id']);
						if ($lsdata['uid']) {
							UserDataChange(array('jifen' => Cnum($_G['SET']['POST' . strtoupper($table) . 'JIFEN']), 'tiandou' => Cnum($_G['SET']['POST' . strtoupper($table) . 'TIANDOU'])), $lsdata['uid']);
						}
					}
				}
			}
		}
		break;
	case 'usergroup' :
		$_G['TABLE']['USERGROUP'] -> delData(Cnum($_G['GET']['ID']));
		break;
	default :
		break;
}
if ($_G['GET']['JSON']) {
	ExitJson($r, $r == '操作成功' ? TRUE : FALSE);
}
ExitGourl("index.php?c=app&a=superadmin:index&s={$_G['GET']['OS']}&t={$_G['GET']['OT']}&table={$_G['GET']['TABLE']}&sortid={$_G['GET']['SORTID']}&uid={$_G['GET']['UID']}&date1={$_G['GET']['DATE1']}&date2={$_G['GET']['DATE2']}&pkalert=show&alert=" . urlencode($r) . "&rnd={$_G['RND']}");
