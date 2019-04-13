<?php
if (!defined('puyuetian'))
	exit('403');

if (!$_G['GET']['T']) {
	$_G['GET']['T'] = 'search';
}
if ($_G['GET']['T'] == 'search') {
	$type = Cstr($_POST['type'], FALSE, TRUE, 1, 255);
	$value = $_POST['value'];
	if ($type && $value)
		$sql = array($type => $value);
	else
		$sql = 'order by `id` desc';
	$page = Cnum($_G['GET']['PAGE'], 1, TRUE, 1);
	$spos = ($page - 1) * 100;
	$userdatas = $_G['TABLE']['USER'] -> getDatas($spos, 100, $sql);
	if ($userdatas) {
		foreach ($userdatas as $userdata) {
			$usergroupdata = $_G['TABLE']['USERGROUP'] -> getData($userdata['groupid']);
			if (!$usergroupdata)
				$usergroupdata['usergroupname'] = '无';
			$userlist .= "
<tr>
	<td style='text-align:center'>{$userdata['id']}</td>
	<td style='text-align:center'>{$usergroupdata['usergroupname']}</td>
	<td style='text-align:center'>{$userdata['username']}</td>
	<td class='pk-hide-sm' style='text-align:center'>{$userdata['nickname']}</td>
	<td class='pk-hide-sm' style='text-align:center'>{$userdata['jifen']}</td>
	<td class='pk-hide-sm' style='text-align:center'>{$userdata['tiandou']}</td>
	<td class='pk-hide-sm' style='text-align:center'>" . date('Y-m-d H:i:s', $userdata['regtime']) . "</td>
	<td style='text-align:center'>
		<a class='pk-btn pk-btn-xs pk-btn-secondary' target='_blank' href='index.php?c=center&id={$userdata['id']}' title='查看'><i class='fa fa-fw fa-eye'></i></a>
		<a class='pk-btn pk-btn-xs pk-btn-success' href='javascript:' onclick='_superedituser({$userdata['id']})' title='编辑'><i class='fa fa-fw fa-edit'></i></a>
		<a class='pk-btn pk-btn-xs pk-btn-danger' href='javascript:' onclick='_superdeluser({$userdata['id']},this)' title='删除'><i class='fa fa-fw fa-trash-o'></i></a>
		<a target='_blank' class='pk-btn pk-btn-xs pk-btn-warning' href='index.php?c=app&a=mysqlmanager:index&id={$userdata['id']}&table=USER&type=edit' title='用数据库插件编辑该用户'><i class='fa fa-fw fa-database'></i></a>
		<a target='_blank' class='pk-btn pk-btn-xs pk-btn-primary' href='index.php?c=app&a=filesmanager:index&path=" . urlencode(str_replace('\\', '/', $_G['SYSTEM']['PATH']) . "/uploadfiles/files/{$userdata['id']}") . "' title='管理该用户的文件'><i class='fa fa-fw fa-folder-o'></i></a>
	</td>
</tr>";
		}
	}
} elseif ($_G['GET']['T'] == 'seniormanagement') {
	$userdata = $_G['TABLE']['USER'] -> getData($_G['GET']['ID']);
	if ($userdata) {
		$userdata['data'] = JsonData($userdata['data']);
	} else {
		$userdata['groupid'] = $_G['SET']['REGUSERGROUPID'];
		$userdata['quanxian'] = $_G['SET']['REGUSERQUANXIAN'];
	}
} elseif ($_G['GET']['T'] == 'group') {
	$usergroupdata = $_G['TABLE']['USERGROUP'] -> getData($_G['GET']['ID']);
	if ($usergroupdata) {
		$usergroupdata['data'] = JsonData($usergroupdata['data']);
	}
}
$_G['TEMP']['UGS'] = '';
$ugds = $_G['TABLE']['USERGROUP'] -> getDatas(0, 0);
foreach ($ugds as $value88) {
	$_G['TEMP']['UGS'] .= '<option value="' . $value88['id'] . '">' . htmlspecialchars($value88['usergroupname']) . '（ID:' . $value88['id'] . '）</option>';
}
$contenthtml = template('superadmin:user-' . $_G['GET']['T'], TRUE);
