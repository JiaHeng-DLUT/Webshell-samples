<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['SET']['TEMPLATE_DEFAULT_COLORSTYLE']) {
	global $templatecolorstyle;
	switch ($_G['SET']['TEMPLATE_DEFAULT_COLORSTYLE']) {
		case '#12B7F5' :
			$color2 = '#12AAFF';
			break;
		case '#CC6666' :
			$color2 = '#EE9999';
			break;
		case '#FFCC66' :
			$color2 = '#FFCC99';
			break;
		case '#66CC66' :
			$color2 = '#66CC99';
			break;
		default :
			$color2 = '#666666';
			break;
	}
	$templatecolorstyle = "
			<style>
				.pk-btn-primary,.pk-background-color-primary{
					background-color:{$_G['SET']['TEMPLATE_DEFAULT_COLORSTYLE']} !important
				}
				.pk-nav.pk-nav-primary{
					background:linear-gradient(to top,{$_G['SET']['TEMPLATE_DEFAULT_COLORSTYLE']},{$color2}) !important
				}
				.pk-nav.pk-nav-primary ul li:hover,.pk-nav.pk-nav-primary .pk-active {
 					 background-color:#fff !important
				}
				.pk-nav.pk-nav-primary ul li.pk-active a {
					color:{$_G['SET']['TEMPLATE_DEFAULT_COLORSTYLE']} !important
				}
				.pk-nav.pk-nav-primary ul li a:hover {
					color:{$_G['SET']['TEMPLATE_DEFAULT_COLORSTYLE']} !important
				}
			</style>";
}
if ($_G['USER']['ID']) {
	$lv = (int)($_G['USER']['JIFEN'] / 100);
	$_G['TEMP']['HEADRIGHT'] = "<a href='index.php?c=user'><span class='pk-text-default'>{$_G['USER']['NICKNAME']}</span><span class='pk-text-primary'>Lv{$lv}</span>&nbsp;&nbsp;<span class='pk-text-danger'>{$_G['SET']['TIANDOUNAME']}:{$_G['USER']['TIANDOU']}</span></a>&nbsp;&nbsp;<a class='pk-text-danger' href='javascript:' onclick='pkalert(\"您确定要退出当前用户么？\",\"确认操作\",\"location.href=\\\"index.php?c=login&type=out\\\"\")'>退出登录</a>";
} else {
	$_G['TEMP']['HEADRIGHT'] = "<a href='" . ReWriteURL('login', '') . "'>登录/注册</a>";
}

$gpshtml = '';
switch ($_G['GET']['C']) {
	case 'list' :
		if ($_G['GET']['SORTID']) {
			$_sortid = $_G['GET']['SORTID'];
			for ($i = 0; $i < 99; $i++) {
				$sortdata = $_G['TABLE']['READSORT'] -> getData($_sortid);
				if ($sortdata) {
					$_sortid = $sortdata['pid'];
					$gpshtml = '&nbsp;&raquo;&nbsp;<a href="' . ReWriteURL('list', "sortid={$sortdata['id']}&page=1") . '">' . $sortdata['title'] . '</a>' . $gpshtml;
				} else {
					break;
				}
			}
			$gpshtml = '&nbsp;&raquo;&nbsp;<a href="' . ReWriteURL('forum', '') . '">版块列表</a>' . $gpshtml;
		}
		break;
	case 'forum' :
		if ($_G['GET']['ID']) {
			$_id = $_G['GET']['ID'];
			for ($i = 0; $i < 99; $i++) {
				$sortdata = $_G['TABLE']['READSORT'] -> getData($_id);
				if ($sortdata) {
					$_id = $sortdata['pid'];
					$gpshtml = '&nbsp;&raquo;&nbsp;<a href="' . ReWriteURL('forum', "id={$sortdata['id']}&page=1") . '">' . $sortdata['title'] . '</a>' . $gpshtml;
				} else {
					break;
				}
			}
		} else {
			$gpshtml .= '&nbsp;&raquo;&nbsp;<a href="javascript:">版块列表</a>';
			break;
		}
		break;
	case 'read' :
		$readdata = $_G['TABLE']['READ'] -> getData(Cnum($_G['GET']['ID']));
		if ($readdata) {
			global $sortid;
			$_sortid = $sortid = $readdata['sortid'];
			for ($i = 0; $i < 99; $i++) {
				$sortdata = $_G['TABLE']['READSORT'] -> getData($_sortid);
				if ($sortdata) {
					$_sortid = $sortdata['pid'];
					$gpshtml = '&nbsp;&raquo;&nbsp;<a href="' . ReWriteURL('list', "sortid={$sortdata['id']}&page=1") . '">' . $sortdata['title'] . '</a>' . $gpshtml;
				} else {
					break;
				}
			}
			$gpshtml .= '&nbsp;&raquo;&nbsp;<a href="javascript:">' . $readdata['title'] . '</a>';
		}
		break;
	case 'user' :
		$userdata = $_G['TABLE']['USER'] -> getData(Cnum($_G['GET']['ID']));
		if ($userdata) {
			$gpshtml .= '&nbsp;&raquo;&nbsp;<a href="' . ReWriteURL('user', "id={$userdata['id']}&page=1") . '">' . $userdata['nickname'] . '的个人信息</a>';
		}
		break;
	case 'app' :
		$gpshtml .= '&nbsp;&raquo;&nbsp;<a href="javascript:">应用</a>';
		break;
	default :
		break;
}
$_G['TEMP']['GPSHTML'] = $gpshtml;
