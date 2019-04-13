<?php
if (!defined('puyuetian'))
	exit('403');

global $hshtml, $zxwzhtml, $zxhfhtml, $jhwzhtml, $rmwzhtml, $xhyhtml, $bkhtml;
$hslc = Cnum($_G['SET']['TEMPLATE_DEFAULT_HOMESLIDERLISTCOUNT'], 5, TRUE, 1);
$halc = Cnum($_G['SET']['TEMPLATE_DEFAULT_HOMEARTICLELISTCOUNT'], 10, TRUE, 1);
$hflc = Cnum($_G['SET']['TEMPLATE_DEFAULT_HOMEFORUMLISTCOUNT'], 10, TRUE, 1);
$hshtml = $zxwzhtml = $zxhfhtml = $jhwzhtml = $rmwzhtml = $xhyhtml = $bkhtml = '';

//读取最新的图片
if (!$_G['SET']['TEMPLATE_DEFAULT_HOMESLIDERCODE']) {
	$sliderdatas = $_G['TABLE']['READ'] -> getDatas(0, 100, 'where `del`=false order by `id` desc');
	$i = 0;
	foreach ($sliderdatas as $sliderdata) {
		if (preg_match_all('#<img.*?src="(.*?)".*?alt="(.*?)".*?\>#', $sliderdata['content'], $match)) {
			$noimglist = 'emotion';
			foreach ($match[1] as $key => $value) {
				if (!InArray($noimglist, $match[2][$key])) {
					$i++;
					$hshtml .= '<li><a target="_blank" href="' . ReWriteURL('read', "id={$sliderdata['id']}&page=1") . '"><img src="' . $value . '" alt="Image"></a><p class="caption">' . $sliderdata['title'] . '</p></li>';
					if ($i >= $hslc) {
						break 2;
					}
					break;
				}
			}
		}
	}
} else {
	$hshtml = $_G['SET']['TEMPLATE_DEFAULT_HOMESLIDERCODE'];
}

//读取最新文章
$readdatas = $_G['TABLE']['READ'] -> getDatas(0, $halc, 'where `del`=false order by `id` desc');
foreach ($readdatas as $readdata) {
	$userdata = $_G['TABLE']['USER'] -> getData($readdata['uid']);
	$zxwzhtml .= '<div class="pk-row" style="border-bottom: solid 1px #CCCCCC;height:28px"><div class="pk-w-sm-9 pk-padding-0 pk-padding-top-5 pk-padding-bottom-5 pk-text-truncate"><a target="_blank" class="pk-hover-underline" href="' . ReWriteURL('read', "id={$readdata['id']}&page=1") . '" title="文章标题：' . $readdata['title'] . '&#10;文章作者：' . $userdata['username'] . '&#10;发布时间：' . date('Y-m-d H:i:s', $readdata['posttime']) . '&#10;浏览次数：' . $readdata['looknum'] . '&#10;回复次数：' . ($readdata['fs'] - 1) . '">&nbsp;&raquo;&nbsp;' . $readdata['title'] . '</a></div><div class="pk-w-sm-3 pk-padding-0 pk-padding-top-5 pk-padding-bottom-5 pk-text-truncate"><a target="_blank" class="pk-hover-underline pk-float-right" href="' . ReWriteURL('user', "id={$readdata['uid']}&page=1") . '">' . $userdata['nickname'] . '</a></div></div>';
}

//读取最新回复
$readdatas = $_G['TABLE']['READ'] -> getDatas(0, $halc, 'where `del`=false and `replyid`>0 order by `activetime` desc');
foreach ($readdatas as $readdata) {
	$replydata = $_G['TABLE']['REPLY'] -> getData($readdata['replyid']);
	$replyuserdata = $_G['TABLE']['USER'] -> getData($replydata['uid']);
	$userdata = $_G['TABLE']['USER'] -> getData($readdata['uid']);
	$zxhfhtml .= '<div class="pk-row" style="border-bottom: solid 1px #CCCCCC;height:28px"><div class="pk-w-sm-9 pk-padding-0 pk-padding-top-5 pk-padding-bottom-5 pk-text-truncate"><a target="_blank" class="pk-hover-underline" href="' . ReWriteURL('read', "id={$readdata['id']}&page=1") . '" title="文章标题：' . $readdata['title'] . '&#10;文章作者：' . $userdata['username'] . '&#10;发布时间：' . date('Y-m-d H:i:s', $readdata['posttime']) . '&#10;浏览次数：' . $readdata['looknum'] . '&#10;回复次数：' . ($readdata['fs'] - 1) . '">&nbsp;&raquo;&nbsp;' . $readdata['title'] . '</a></div><div class="pk-w-sm-3 pk-padding-0 pk-padding-top-5 pk-padding-bottom-5 pk-text-truncate"><a target="_blank" class="pk-hover-underline pk-float-right" href="' . ReWriteURL('user', "id={$readdata['uid']}&page=1") . '" title="最后回复">' . $userdata['nickname'] . '</a></div></div>';
}

//读取精华文章
$readdatas = $_G['TABLE']['READ'] -> getDatas(0, $halc, 'where `del`=false and `high`=true order by `id` desc');
foreach ($readdatas as $readdata) {
	$userdata = $_G['TABLE']['USER'] -> getData($readdata['uid']);
	$jhwzhtml .= '<div class="pk-row" style="border-bottom: solid 1px #CCCCCC;height:28px"><div class="pk-w-sm-9 pk-padding-0 pk-padding-top-5 pk-padding-bottom-5 pk-text-truncate"><a target="_blank" class="pk-hover-underline" href="' . ReWriteURL('read', "id={$readdata['id']}&page=1") . '" title="文章标题：' . $readdata['title'] . '&#10;文章作者：' . $userdata['username'] . '&#10;发布时间：' . date('Y-m-d H:i:s', $readdata['posttime']) . '&#10;浏览次数：' . $readdata['looknum'] . '&#10;回复次数：' . ($readdata['fs'] - 1) . '">&nbsp;&raquo;&nbsp;' . $readdata['title'] . '</a></div><div class="pk-w-sm-3 pk-padding-0 pk-padding-top-5 pk-padding-bottom-5 pk-text-truncate"><a target="_blank" class="pk-hover-underline pk-float-right" href="' . ReWriteURL('user', "id={$readdata['uid']}&page=1") . '">' . $userdata['nickname'] . '</a></div></div>';
}

//读取热门文章
$readdatas = $_G['TABLE']['READ'] -> getDatas(0, $halc, 'where `del`=false order by `fs` desc');
foreach ($readdatas as $readdata) {
	$userdata = $_G['TABLE']['USER'] -> getData($readdata['uid']);
	$rmwzhtml .= '<div class="pk-row" style="border-bottom: solid 1px #CCCCCC;height:28px"><div class="pk-w-sm-9 pk-padding-0 pk-padding-top-5 pk-padding-bottom-5 pk-text-truncate"><a target="_blank" class="pk-hover-underline" href="' . ReWriteURL('read', "id={$readdata['id']}&page=1") . '" title="文章标题：' . $readdata['title'] . '&#10;文章作者：' . $userdata['username'] . '&#10;发布时间：' . date('Y-m-d H:i:s', $readdata['posttime']) . '&#10;浏览次数：' . $readdata['looknum'] . '&#10;回复次数：' . ($readdata['fs'] - 1) . '">&nbsp;&raquo;&nbsp;' . $readdata['title'] . '</a></div><div class="pk-w-sm-3 pk-padding-0 pk-padding-top-5 pk-padding-bottom-5 pk-text-truncate"><a target="_blank" class="pk-hover-underline pk-float-right" href="' . ReWriteURL('user', "id={$readdata['uid']}&page=1") . '">' . $userdata['nickname'] . '</a></div></div>';
}

//读取最新会员
$userdatas = $_G['TABLE']['USER'] -> getDatas(0, 14, 'order by `id` desc');
foreach ($userdatas as $userdata) {
	$xhyhtml .= '<div class="pk-float-left pk-padding-10 pk-padding-right-5 pk-text-center" style="width:63px"><img class="pk-cursor-pointer" onclick="window.open(\'' . ReWriteURL('user', "id={$userdata['id']}&page=1") . '\',\'_blank\')" title="注册时间：' . date('Y-m-d H:i:s', $userdata['regtime']) . '" src="userhead/' . $userdata['id'] . '.png" onerror="this.src=\'template/default/img/randhead/' . rand(1, Cnum($_G['SET']['TEMPLATE_DEFAULT_RANDHEADCOUNT'], 24)) . '.png\'" class="pk-radius-4 pk-display-block" style="border:solid 1px #fff;width:48px;height:48px;box-shadow: 0 0 2px #999;"><a target="_blank" class="pk-hover-underline pk-text-nowrap pk-display-block pk-width-all pk-text-xs pk-overflow-hidden" href="' . ReWriteURL('user', "id={$userdata['id']}&page=1") . '" style="padding-top: 2px;" title="' . $userdata['nickname'] . '">' . $userdata['nickname'] . '</a></div>';
}

//版块显示
$forumids = $_G['SET']['TEMPLATE_DEFAULT_HOMEFORUMIDS'];
if ($forumids) {
	$forumids = explode(',', $forumids);
	$i = 0;
	foreach ($forumids as $forumid) {
		$i++;
		$forumdata = $_G['TABLE']['READSORT'] -> getData($forumid);
		$readdatas = $_G['TABLE']['READ'] -> getDatas(0, $hflc, 'where `del`=false and `sortid`=' . $forumid . ' order by `id` desc');
		if ($i % 3 == 1) {
			$bdiv = true;
			$bkhtml .= '<div class="pk-row">';
		}
		$bkhtml .= '
		<div class="pk-w-md-4 pk-w-sm-12 pk-padding-10 pk-padding-left-sm-0 pk-padding-right-sm-0">
				<div style="box-shadow: 0 1px 2px 1px #CCCCCC;">
					<div class="pk-row pk-background-color-white pk-overflow-hidden pk-text-nowrap pk-padding-10 pk-text-sm" style="border-bottom: solid 2px #CCCCCC;"><div class="pk-w-sm-8 pk-padding-0">' . $forumdata['title'] . '</div><div class="pk-w-sm-4 pk-padding-0 pk-text-right"><a target="_blank" class="pk-hover-underline" href="' . ReWriteURL('list', "sortid={$forumid}&page=1") . '">更多&nbsp;&raquo;</a></div></div>
		';
		foreach ($readdatas as $readdata) {
			$userdata = $_G['TABLE']['USER'] -> getData($readdata['uid']);
			if (date('Y-m-d', $readdata['posttime']) == date('Y-m-d', time())) {
				$newred = ' pk-text-danger';
			} else {
				$newred = '';
			}
			$bkhtml .= '
					<div class="pk-row pk-text-xs pk-padding-5">
						<a target="_blank" class="pk-w-sm-8 pk-hover-underline pk-text-truncate pk-padding-0" href="' . ReWriteURL('read', "id={$readdata['id']}&page=1") . '" title="文章标题：' . $readdata['title'] . '&#10;文章作者：' . $userdata['username'] . '&#10;发布时间：' . date('Y-m-d H:i:s', $readdata['posttime']) . '&#10;浏览次数：' . $readdata['looknum'] . '&#10;回复次数：' . ($readdata['fs'] - 1) . '">&raquo;&nbsp;' . $readdata['title'] . '</a>
						<span class="pk-w-sm-4 pk-text-right pk-text-nowrap pk-padding-0' . $newred . '">' . date('Y-m-d', $readdata['posttime']) . '</span>
					</div>
			';
		}
		$bkhtml .= '
				</div>
		</div>
		';
		if ($i % 3 == 0) {
			$bdiv = false;
			$bkhtml .= '</div>';
		}
	}
	if ($bdiv) {
		$bkhtml .= '</div>';
	}
}

//论坛信息
$_G['SET']['SUMPOSTRR'] = $_G['TABLE']['READ'] -> getCount(array('del' => 0)) + $_G['TABLE']['REPLY'] -> getCount(array('del' => 0));
$_G['SET']['YESTODAYPOSTRR'] = $_G['TABLE']['READ'] -> getCount('where `del`=0 and `posttime`>' . (strtotime(date('Y-m-d 00:00:00', time())) - 86400) . ' and `posttime`<' . (strtotime(date('Y-m-d 23:59:59', time())) - 86400)) + $_G['TABLE']['REPLY'] -> getCount('where `del`=0 and `posttime`>' . (strtotime(date('Y-m-d 00:00:00', time())) - 86400) . ' and `posttime`<' . (strtotime(date('Y-m-d 23:59:59', time())) - 86400));
$_G['SET']['TODAYPOSTRR'] = $_G['TABLE']['READ'] -> getCount('where `del`=0 and `posttime`>' . strtotime(date('Y-m-d 00:00:00', time())) . ' and `posttime`<' . strtotime(date('Y-m-d 23:59:59', time()))) + $_G['TABLE']['REPLY'] -> getCount('where `del`=0 and `posttime`>' . strtotime(date('Y-m-d 00:00:00', time())) . ' and `posttime`<' . strtotime(date('Y-m-d 23:59:59', time())));
$_G['SET']['MEMBERCOUNT'] = $_G['TABLE']['USER'] -> getCount();
