<?php
if (!defined('puyuetian'))
	exit('403');

global $_G;
/*
 $_G['TEMP']['PLUG']['CHILDS'] = -1;
 function foundchildforum2($pid) {
 global $_G;
 $data = $_G['TABLE']['READSORT'] -> getDatas(0, 0, "where `pid`={$pid} order by `rank`");
 if ($data) {
 $_G['TEMP']['PLUG']['CHILDS']++;
 foreach ($data as $array) {
 $fgf = $sqx = $disabled = '';
 for ($i = 0; $i < $_G['TEMP']['PLUG']['CHILDS']; $i++) {
 $fgf .= "&raquo;&nbsp;&nbsp;";
 }
 $_G['TEMP']['PLUG']['BKLIST'] .= "
 <div class='pk-row pk-padding-top-15 pk-padding-bottom-15' style='border-bottom:solid 1px #eee'>
 <label class='pk-w-sm-3 pk-text-right' style='padding-top:2px'>
 <img src='{$array['logourl']}' style='width:48px;height:48px' onerror=\"this.src='app/superadmin/template/img/forum.png'\">
 </label>
 <div class='pk-w-sm-8 pk-text-default pk-text-sm'>
 <div class='pk-text-nowrap pk-text-bold'>{$fgf}" . htmlspecialchars($array['title']) . "（ID：{$array['id']}）</div>
 <div class='pk-text-xs pk-text-truncate'>" . EqualReturn(htmlspecialchars($array['content']), '', '无简介') . "</div>
 <div class='pk-text-xs pk-text-nowrap'>
 <a class='pk-text-success pk-hover-opacity' href='index.php?c=app&a=superadmin:index&s=forum&t=edit&id={$array['id']}'>编辑</a>
 <a class='pk-text-danger pk-hover-opacity' href='javascript:' onclick=\"pkalert('确认删除该版块？ID:{$array['id']}<br>将会一并删除该版块下的子版块及所有文章和回复','提示','location.href=\'index.php?c=app&a=superadmin:index&s=delete&os=forum&ot=list&table=readsort&id={$array['id']}&chkcsrfval={$_G['CHKCSRFVAL']}\'')\">删除</a>
 </div>
 </div>
 </div>
 ";
 foundchildforum2($array['id']);
 if ($pid == 0) {
 $_G['TEMP']['PLUG']['CHILDS'] = 0;
 }
 }
 }
 }

 foundchildforum2(0);
 */

$bkdatas = $_G['TABLE']['READSORT'] -> getDatas(0, 0, 'order by `rank`');
$_G['TEMP']['BKDATAS'] = json_encode($bkdatas);
