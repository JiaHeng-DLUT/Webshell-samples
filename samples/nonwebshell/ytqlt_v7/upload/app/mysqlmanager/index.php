<?php
if (!defined('puyuetian'))
	exit('Not Found puyuetian!Please contact QQ632827168');

$rnum = 50;
$table = strtolower(Cstr($_GET['table'], '', TRUE, 1, 255));
$type = $_G['GET']['TYPE'];
$page = Cnum($_G['GET']['PAGE'], 1, TRUE, 1);
$id = Cnum($_G['GET']['ID']);

if ($_G['USER']['ID'] != 1) {
	PkPopup('{content:"无权此操作",shade:1,hideclose:1,submit:function(){location.href="index.php"}}');
}

foreach ($_G['TABLE'] as $key => $value) {
	$key = strtolower($key);
	$_G['TABLES'][] = $key;
}

if ($table) {
	if (!in_array($table, $_G['TABLES'])) {
		PkPopup('{content:"不存在的表",shade:1,hideclose:1}');
	} else {
		$table = strtoupper($table);
	};
}

foreach ($_G['TABLE'] as $key => $value) {
	$key = strtolower($key);
	$tablelist .= "<a class='pk-btn pk-btn-primary pk-btn-sm pk-margin-right-5 pk-margin-bottom-5' id='mysql_{$key}' title='$key' href='index.php?c=app&a=mysqlmanager:index&table=$key&type=look'>{$key}</a>";
}

if ($table && $type == 'look') {
	$pos = ($page - 1) * $rnum;
	$syy = $page - 1;
	$xyy = $page + 1;
	$array = $_G['TABLE'][$table] -> getDatas($pos, $rnum, "order by `id`");
	$tablecontent = "
		<form name='form_del' method='post' action='index.php?c=app&a=mysqlmanager:query&type=del&table={$table}'>
		<div class='pk-padding-15'>
			<input type='checkbox' onclick='checkall(this.checked)'>全选
			<input type='button' class='pk-btn pk-btn-sm' value='删除所选项' onclick=if(confirm('确认删除所选项目？'))form_del.submit();>
			<input type='button' class='pk-btn pk-btn-sm' value='添加新记录' onclick=location.href='index.php?c=app&a=mysqlmanager:index&type=new&table={$table}'>
		</div>
		<table class='table'>
		";
	foreach ($array as $key => $array2) {
		if ($key == 0) {
			$array_keys = array_keys($array2);
			$tablecontent .= "<tr><th></th>";
			foreach ($array_keys as $name) {
				$tablecontent .= "<th><a target='_blank' href='http://www.hadsky.com/index.php?c=search&word=" . urlencode($name) . "' title='查看与此字段相关的使用文档'>$name</a></th>";
			}
			$tablecontent .= "</tr>";
		}
		$tablecontent .= "
			<tr class='onclick' title='点击编辑此记录'>
			<td><input name='ids[]' type='checkbox' value='{$array2['id']}'></td>
			";
		foreach ($array2 as $value) {
			$tablecontent .= "<td class='onlyoneline' onclick=\"location.href='index.php?c=app&a=mysqlmanager:index&id={$array2['id']}&table={$table}&type=edit'\">" . substr(htmlspecialchars($value), 0, 255) . "</td>";
		}
		$tablecontent .= "</tr>";
	}
	$tablecontent .= "</table></form>";

} elseif ($table && $type == 'edit' && $id) {
	$array = $_G['TABLE'][$table] -> getData($id);
	$tablecontent = "
		<form name='mysql_form' method='post' action='index.php?c=app&a=mysqlmanager:query&table={$table}&type=save&id=$id'>
		<table class='table2'>
		";
	$_i = 0;
	foreach ($array as $key => $value) {
		$_i++;
		$_column = $_G['TABLE'][$table] -> getColumns($key);
		$_column = current($_column);
		$tablecontent .= "
			<tr><td>
			<div class='text-left'>
				<input type='text' name='keys[]' value='$key' style='font-weight:bold' readonly>
				<input type='text' value='数据类型：{$_column['Type']}' readonly>
				<input type='text' id='_Null{$_i}' value='是否为空：{$_column['Null']}' readonly>
				<input type='text' id='_Default{$_i}' value='默认值：{$_column['Default']}' readonly>
				<input type='text' value='说明：{$_column['Comment']}' readonly>
				<input type='text' id='_Must{$_i}' value='此值必填' style='color:red;display:none' readonly>
				<script>
					var _v1{$_i}=document.getElementById('_Null{$_i}').value;
					var _v2{$_i}=document.getElementById('_Default{$_i}').value;
					if(_v1{$_i}=='是否为空：NO'&&_v2{$_i}=='默认值：'){
						document.getElementById('_Must{$_i}').style.display='';
					}		
				</script>
			</div>
			<textarea name='values[]'>" . htmlspecialchars($value) . "</textarea>
			</td></tr>
			";
	}
	$tablecontent .= "
		<tr><td class='am-text-center'>
			<input type='submit' class='pk-btn pk-btn-primary' value='保存'>
		</td></tr>
		</table>
		</form>
		";
} elseif ($table && $type == 'new' && !$id) {
	$array = $_G['TABLE'][$table] -> getColumns();
	$tablecontent = "
		<form name='mysql_form' method='post' action='index.php?c=app&a=mysqlmanager:query&table={$table}&type=save'>
		<table class='table2'>
		";
	$_i = 0;
	foreach ($array as $value) {
		$_i++;
		$_column = $_G['TABLE'][$table] -> getColumns($value['Field']);
		$_column = current($_column);
		if ($value['Field'] == 'id') {
			$btx = ' readonly placeholder="此值不填！"';
		} else {
			$btx = '';
		}
		$tablecontent .= "
			<tr><td>
			<div class='text-left'>
				<input type='text' name='keys[]' value='{$value['Field']}' readonly>
				<input type='text' value='数据类型：{$_column['Type']}' readonly>
				<input type='text' id='_Null{$_i}' value='是否为空：{$_column['Null']}' readonly>
				<input type='text' id='_Default{$_i}' value='默认值：{$_column['Default']}' readonly>
				<input type='text' value='说明：{$_column['Comment']}' readonly>
				<input type='text' id='_Must{$_i}' value='此值必填' style='color:red;display:none' readonly>
				<script>
					var _v1{$_i}=document.getElementById('_Null{$_i}').value;
					var _v2{$_i}=document.getElementById('_Default{$_i}').value;
					if({$_i}!=1&&_v1{$_i}=='是否为空：NO'&&_v2{$_i}=='默认值：'){
						document.getElementById('_Must{$_i}').style.display='';
					}		
				</script>
			</div>
			<textarea name='values[]'{$btx}></textarea>
			</td></tr>
			";
	}
	$tablecontent .= "
		<tr><td class='am-text-center'>
			<input type='submit' class='pk-btn pk-btn-primary' value='保存'>
		</td></tr>
		</table>
		</form>
		";
} else {
	$tablecontent = "
		<div class='am-text-center am-padding'>
			请选择相应的表进行操作,每页显示{$rnum}条记录
		</div>
		";
}
if (!isset($_POST['keys']) && !isset($_POST['values'])) {
	$_G['HTMLCODE']['OUTPUT'] = template('mysqlmanager:index', true);
}
