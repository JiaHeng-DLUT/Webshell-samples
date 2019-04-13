<?php
if (!defined('puyuetian'))
	exit('403');

$_G['TEMPLATE']['BODY'] = 'output';
$_G['SET']['SUMPOSTRR'] = $_G['TABLE']['READ'] -> getCount(array('del' => 0)) + $_G['TABLE']['REPLY'] -> getCount(array('del' => 0));
$_G['SET']['YESTODAYPOSTRR'] = $_G['TABLE']['READ'] -> getCount('where `del`=0 and `posttime`>' . (strtotime(date('Y-m-d 00:00:00', time())) - 86400) . ' and `posttime`<' . (strtotime(date('Y-m-d 23:59:59', time())) - 86400)) + $_G['TABLE']['REPLY'] -> getCount('where `del`=0 and `posttime`>' . (strtotime(date('Y-m-d 00:00:00', time())) - 86400) . ' and `posttime`<' . (strtotime(date('Y-m-d 23:59:59', time())) - 86400));
$_G['SET']['TODAYPOSTRR'] = $_G['TABLE']['READ'] -> getCount('where `del`=0 and `posttime`>' . strtotime(date('Y-m-d 00:00:00', time())) . ' and `posttime`<' . strtotime(date('Y-m-d 23:59:59', time()))) + $_G['TABLE']['REPLY'] -> getCount('where `del`=0 and `posttime`>' . strtotime(date('Y-m-d 00:00:00', time())) . ' and `posttime`<' . strtotime(date('Y-m-d 23:59:59', time())));
$_G['SET']['MEMBERCOUNT'] = $_G['TABLE']['USER'] -> getCount();
