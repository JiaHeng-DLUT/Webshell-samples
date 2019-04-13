<?php
/****************优客365网址导航系统 开源版********************/
/*                                                            */
/*  Youke365.site (C)2017 Youke365 Inc.                       */
/*  This is NOT a freeware, use is subject to license terms   */
/*  优客365网址导航开源版 个人用户可免费使用  请保留底部版权  */
/*  2018.4                                                    */
/*  官方网址：http://www.youke365.site                        */
/*  官方论坛：http://bbs.youke365.site                        */                           
/**************************************************************/
if (!defined('IN_YOUKE365')) exit('Access Denied');
include APP_PATH.__MODULE__.'/base.php';
$pagename = '意见反馈';
$pageurl  = url('feedback');
$tempfile = 'feedback.html';

$Youke->caching = false;
	
if (!$Youke->isCached($tempfile)) {	
	$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
	$Youke->assign('site_keywords', '意见反馈，问题反馈，用户反馈，意见与建议');
	$Youke->assign('site_description', '您的意见和建议，将帮助我们改进产品和服务，欢迎您提出宝贵建议和意见！');
	$Youke->assign('pagename', $pagename);
	
	if (I('post.action') == 'send') {
		$fb_nick    = I('post.nick','','addslashes');
		$fb_email   = I('post.email','','addslashes');
		$fb_content = I('post.content','','addslashes');
		$check_code =  addslashes(I('post.checkcode','','strtolower'));
		
		$fb_date = time();
		if (empty($fb_nick)) {
			msgbox('请输入昵称！');
		}
		
		if (empty($fb_email)) {
			msgbox('请输入电子邮件！');
		} else {
			if (!is_valid_email($fb_email)) {
				msgbox('请输入正确的电子邮件地址！');
			}
		}
		
		if (empty($fb_content) || strlen($fb_content) < 20) {
			msgbox('请输入意见内容，且长度不能小于20个字符！');
		}
		
		if (empty($check_code) || $check_code != $_SESSION['code']) {
			unset($_SESSION['code']);
			msgbox('您输入的验证码不正确，请重新输入！');	
		}
			
		$data = array(
			'fb_nick'    => $fb_nick,
			'fb_email'   => $fb_email,
			'fb_content' => $fb_content,
			'fb_date'    => $fb_date,
		);
		
		$Db->insert(table('feedback'), $data);
		unset($_SESSION['code']);
				
		msgbox('您的意见已经提交，谢谢您对我们的支持！', './');
	}
}
		
Youke_display($tempfile);
