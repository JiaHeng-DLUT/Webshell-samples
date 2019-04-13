<?php
if (!defined('puyuetian'))
	exit('403');

if (!$_G['GET']['APIUID'] || !$_G['GET']['APICODE']) {
	ExitJson('API未设置，请联系管理检查API设置');
}

if ($_G['GET']['APIUID'] != $_G['SET']['APP_JVHUO_APIUID'] || $_G['GET']['APICODE'] != $_G['SET']['APP_JVHUO_APICODE']) {
	ExitJson('API接口校验失败，请联系管理检查API设置');
}

LoadAppScript($_G['GET']['S'], '', 'apiphpscript');
