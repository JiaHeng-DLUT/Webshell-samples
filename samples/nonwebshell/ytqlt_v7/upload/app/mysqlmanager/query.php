<?php
if (!defined('puyuetian'))
	exit('Not Found puyuetian!Please contact QQ632827168');
isset($_GET['table']) ? $table = strtolower(Cstr($_GET['table'], '', TRUE, 1, 255)) : $table = '';
$type = $_G['GET']['TYPE'];
$page = Cnum($_G['GET']['PAGE'], 1, TRUE, 1);
$id = Cnum($_G['GET']['ID']);

if ($_G['USER']['ID'] == 1) {
	if ($table) {
		if (!in_array($table, $_G['TABLES'])) {
			$_G['HTMLCODE']['TIP'] = '不存在的表！';
			$_G['HTMLCODE']['OUTPUT'] = template('tip', true);
		} else {
			$table = strtoupper($table);
			if ($type == 'save') {
				$keys = (array)$_POST['keys'];
				$values = (array)$_POST['values'];
				$array = array_combine($keys, $values);
				$r = $_G['TABLE'][$table] -> newData($array);
				if ($r) {
					$_G['HTMLCODE']['TIP'] = 'MySQL相关保存操作完成！';
				} else {
					$_G['HTMLCODE']['TIP'] = mysql_error();
				}
				$_G['HTMLCODE']['TIPJS'] = "location.href='?c=app&a=mysqlmanager:index&table=$table&type=look'";
			} elseif ($type == 'del') {
				$ids = (array)$_POST['ids'];
				foreach ($ids as $value) {
					$_G['TABLE'][$table] -> delData($value);
				}
				$_G['HTMLCODE']['TIP'] = 'MySQL相关删除操作完成！';
				$_G['HTMLCODE']['TIPJS'] = "location.href='?c=app&a=mysqlmanager:index&table=$table&type=look'";
			} else {
				$_G['HTMLCODE']['TIP'] = '无效的参数！';
			}
			$_G['HTMLCODE']['OUTPUT'] = template('tip', true);

		};
	} else {
		$_G['HTMLCODE']['TIP'] = '参数错误！';
		$_G['HTMLCODE']['OUTPUT'] = template('tip', true);
	}
} else {
	$_G['HTMLCODE']['TIP'] = '您无权操作！';
	$_G['HTMLCODE']['OUTPUT'] = template('tip', true);
}
