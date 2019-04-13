<?php
if (!defined('puyuetian'))
	exit('403');

/*
 * 用户登录检测，若登录用户信息保存在$_G['USER']数组内
 * $_G['USER']['ID']为$LoginUserId的简写
 * $_G['USER']为$LoginUserArray的简写
 */

//user auto login
//用户身份验证
$_G['USER'] = UIA();

//读取用户组数据
if ($_G['USER']['ID'] && $_G['USER']['GROUPID']) {
	$_G['USERGROUP'] = $_G['TABLE']['USERGROUP'] -> getData($_G['USER']['GROUPID']);
	if ($_G['USERGROUP']) {
		standardArray($_G['USERGROUP']);
		$_G['USER']['USERGROUPNAME'] = $_G['USERGROUP']['USERGROUPNAME'];
		$_G['USER']['READLEVEL'] = $_G['USERGROUP']['READLEVEL'];
		$_G['USER']['USERGROUPQUANXIAN'] = $_G['USERGROUP']['QUANXIAN'];
		$data = json_decode($_G['USERGROUP']['DATA'], TRUE);
		foreach ($data as $key => $value) {
			$_G['USER']['DATA'] = JsonData($_G['USER']['DATA'], $key, $value);
		}
	}
} else {
	$_G['USERGROUP'] = FALSE;
}

//当前用户未读消息数
if ($_G['USER']['ID']) {
	$_G['USERMESSAGE']['UNREADCOUNT'] = $_G['TABLE']['USER_MESSAGE'] -> getCount(array('islook' => 0, 'uid' => $_G['USER']['ID']));
} else {
	$_G['USER']['ID'] = 0;
	$_G['USERMESSAGE']['UNREADCOUNT'] = 0;
}

//防止csrf攻击
$_G['CHKCSRFVAL'] = md5(key_endecode(md5($_G['USER']['SESSION_TOKEN'])));

//用户数据前端化
$showstrs = explode(',', 'id,groupid,username,sex,nickname,tiandou,jifen,readlevel,quanxian,birthday,email,qq,phone,sign,friends,idol,fans,collect,usergroupname,usergroupquanxian');
$_ud = $_G['USER'];
foreach ($_ud as $key => $value) {
	if (!InArray($showstrs, strtolower($key))) {
		unset($_ud[$key]);
	}
}
$_ud['CHKCSRFVAL'] = $_G['CHKCSRFVAL'];
$_ud['MESSAGE_UNREADCOUNT'] = $_G['USERMESSAGE']['UNREADCOUNT'];
$_ud['C'] = $_G['GET']['C'];
//设置数据前端化
$showstrs = explode(',', 'quotes,templatename,webdescription,webkeywords,weblogo,readlistnum,replylistnum,logotext,uploadfiletypes,uploadfilesize,postreadjifen,postreadtiandou,postreplyjifen,postreplytiandou,defaultpage,rewriteurl,phonetemplatename,jifenname,tiandouname,regjifen,regtiandou,postingtimeinterval,postaudit,newuserpostwaittime,beianhao,bbcodeattrs,readtitlemin,readtitlemax,readcontentmin,readcontentmax,replycontentmin,replycontentmax,replyorder,readtopnum,webtitle,defaulttemplates,novicetraineetime,postreadcheck,postreplycheck,changeuserinfoverify,readlistorder,readlistshowbks,readlisthiddenbks,showmessagecount,regreadlevel,uploadheadsize,phonedomains,ifpccomephonego,usernameeverychars,phonedefaulttemplates,phonedefaultpage,activetopreadids,postmessagemaxnum,app_hadskycloudserver_sms_open');
$_set = $_G['SET'];
foreach ($_set as $key => $value) {
	if (!InArray($showstrs, strtolower($key))) {
		unset($_set[$key]);
	}
}
$_G['SET']['EMBED_HEADMARKS'] .= '<script>var $_USER=' . json_encode($_ud) . ',$_SET=' . json_encode($_set) . ',$_URI=' . json_encode($_G['GET']) . ';if($_URI===null){$_URI=[]}</script>';

unset($showstrs, $_set, $_ud, $key, $value);
