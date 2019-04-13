<?php
if (!defined('puyuetian'))
	exit('403');

switch ($_G['GET']['TABLE']) {
	case 'set' :
		//SET表的设置保存
		foreach ($_POST as $key => $value) {
			$getid = $_G['TABLE']['SET'] -> getId('setname', $key);
			if ($getid) {
				$array['id'] = $getid;
			} else {
				$array['id'] = 0;
				$array['setname'] = $key;
			}
			$array[($_G['GET']['SET_TYPE'] == 'loadset' ? 'noload' : 'setvalue')] = $value;
			$_G['TABLE']['SET'] -> newData($array);
			$array = array();
		}
		break;
	case 'plug' :
	case 'readsort' :
	case 'download' :
		//版块表的保存
		$readsorts = $_G['TABLE'][strtoupper($_G['GET']['TABLE'])] -> getColumns();
		foreach ($readsorts as $key => $value) {
			$fields .= ",{$value['Field']}";
		}
		$fields = substr($fields, 1);
		$fields = explode(',', $fields);
		foreach ($_POST as $key => $value) {
			if (in_array($key, $fields)) {
				$array[$key] = $value;
			}
		}
		$_G['TABLE'][strtoupper($_G['GET']['TABLE'])] -> newData($array);
		break;
	case 'user' :
		$userdata = $_G['TABLE']['USER'] -> getData($_G['GET']['ID']);
		$userarray = array();
		$userarray['id'] = $_G['GET']['ID'];
		$userfields = $_G['TABLE']['USER'] -> getColumns();
		foreach ($userfields as $key => $value) {
			$fields .= ",{$value['Field']}";
		}
		$fields = substr($fields, 1);
		foreach ($_POST as $key => $value) {
			//用户data处理
			if (substr($key, 0, 5) == 'data-') {
				$userdata['data'] = JsonData($userdata['data'], substr($key, 5), array($value));
			} else {
				if (InArray($fields, $key)) {
					if ($key == 'password') {
						if (Cstr($value, FALSE, FALSE, 5, 16)) {
							$userarray[$key] = md5($value);
						}
					} else {
						$userarray[$key] = $value;
					}
				}
			}
		}
		$userarray['data'] = $userdata['data'];
		$_G['TABLE']['USER'] -> newData($userarray);
		break;
	case 'usergroup' :
		$usergrouparray = array();
		/*
		 $usergroupdata = $_G['TABLE']['USERGROUP'] -> getData($_G['GET']['ID']);
		 if ($usergroupdata) {
		 $usergrouparray['id'] = $_G['GET']['ID'];
		 } else {
		 $usergrouparray['id'] = 0;
		 }
		 */
		$usergroupfields = $_G['TABLE']['USERGROUP'] -> getColumns();
		foreach ($usergroupfields as $key => $value) {
			$fields .= ",{$value['Field']}";
		}
		$fields = substr($fields, 1);
		foreach ($_POST as $key => $value) {
			//用户data处理
			if (substr($key, 0, 5) == 'data-') {
				$usergroupdata['data'] = JsonData($usergroupdata['data'], substr($key, 5), array($value));
			} else {
				if (InArray($fields, $key))
					$usergrouparray[$key] = $value;
			}
		}
		$usergrouparray['data'] = $usergroupdata['data'];
		$_G['TABLE']['USERGROUP'] -> newData($usergrouparray);
		break;
	case 'read' :
	case 'reply' :

	default :
		break;
}
if ($_G['GET']['JSON']) {
	if (mysql_error()) {
		ExitJson(mysql_error(), FALSE);
	} else {
		ExitJson('操作成功', TRUE);
	}
} else {
	header("Location:index.php?c=app&a=superadmin:index&s={$_G['GET']['OS']}&t={$_G['GET']['OT']}&id={$_G['GET']['ID']}&pkalert=show&alert=" . urlencode('操作成功！' . mysql_error()) . "&rnd={$_G['RND']}");
}
exit();
