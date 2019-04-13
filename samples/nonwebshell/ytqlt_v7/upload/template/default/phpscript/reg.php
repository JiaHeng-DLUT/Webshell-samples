<?php
if (!defined('puyuetian'))
	exit('403');

$_G['TEMPLATE']['BODY'] = 'reg';
if ($_G['SET']['USERNAMEEVERYCHARS']) {
	$_G['TEMP']['HANZI'] = '由汉字、字母、数字及下划线组成，不能为纯数字，最多8个汉字';
} else {
	$_G['TEMP']['HANZI'] = '由字母、数字及下划线组成，不能为纯数字，3-24位';
}
