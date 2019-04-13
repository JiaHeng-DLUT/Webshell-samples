<?php
if (!defined('puyuetian'))
	exit('403');

$_G['TEMP']['BODY'] = '';
$datas = $_G['TABLE']['SET'] -> getDatas(0, 0);
$_G['TEMP']['JZX'] = $_G['TEMP']['ZX'] = $_G['TEMP']['JZXZYNC'] = 0;
foreach ($datas as $value) {
	$_G['TEMP']['ZX']++;
	!$value['noload'] && $_G['TEMP']['JZX']++;
	$_zync = (strlen($value['setname']) + strlen($value['setvalue'])) / 1024;
	$_G['TEMP']['JZXZYNC'] += $_zync;
	$_G['TEMP']['BODY'] .= '
<tr class="settr">
	<td class="pk-text-left">' . $value['id'] . '</td>
	<td class="pk-text-left">' . $value['setname'] . '</td>
	<td class="pk-text-center">' . round($_zync, 2) . 'Kb</td>
	<td class="pk-text-center" data-id="' . $value['id'] . '" data-name="' . $value['setname'] . '">
		<textarea class="pk-hide">' . htmlspecialchars($value['setvalue'], ENT_QUOTES) . '</textarea>
		<a class="set-load ' . ($value['noload'] ? 'set-yesload' : 'set-noload') . '" href="javascript:">' . ($value['noload'] ? '预加载' : '禁止预载') . '</a>
		<a class="set-edit" href="javascript:">编辑</a>
		<a class="set-del" href="javascript:">删除</a>
	</td>
</tr>
<tr>
	<td class="set-desc pk-text-xs" data-name="' . $value['setname'] . '" colspan="99">说明：正在获取...</td>
</tr>
';
}

$_G['TEMP']['JZXZYNC'] = round($_G['TEMP']['JZXZYNC'], 2);
/*/计算预加载项占用的内存
 $_a = memory_get_usage();
 $_b = array();
 foreach ($_G['SET'] as $key => $value) {
 $_b[$key] = $value;
 }
 $_G['TEMP']['JZXZYNC'] = round((memory_get_usage() - $_a) / 1024);
 */
