<?php
/****************优客365网址导航系统 开源版********************/
/*                                                            */
/*  Youke365.site (C)2018 Youke365 Inc.                       */
/*  This is NOT a freeware, use is subject to license terms   */
/*  优客365网址导航开源版 个人用户可免费使用  请保留底部版权  */
/*  2018.4                                                    */
/*  官方网址：http://www.youke365.site                        */
/*  官方论坛：http://bbs.youke365.site                        */                           
/**************************************************************/

if (!defined('IN_YOUKE365')) exit('Access Denied');

$pagename = '网站认领';
$pageurl  = url('claim');
$tplfile  = 'claim.html';
$table    = table('website');

$url    = I('get.url','','addslashes');
$action = I('get.act','one','addslashes');
$do     = I('post.do','','addslashes');

//判断是否登陆
$userinfo = is_login();


$Youke->assign('action', $action); 
$Youke->assign('url', $url);

if (!$Youke->isCached($tplfile)) {
	$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
	if ($do == 'next') {
		$domain = addslashes(I('post.domain','','strtolower'));
		
		if (empty($domain)) {
		    	msgbox('请输入要认领的域名！');
		} else {
			if (!is_valid_domain($domain)) {
				msgbox('请输入正确的网站域名！');
			}
		}
		
    	$query = $Db->query("SELECT web_id FROM $table WHERE web_url='$domain'");
    	if (!count($query)) {
        	msgbox('该网站还未被提交！',url('website',['act'=>'add']));
    	}
		
		$Youke->assign('action', 'two'); 
		$Youke->assign('domain', $domain);
		$Youke->assign('siteurl', format_url($domain));
		$Youke->assign('token', random(32));
		
	} elseif ($do == 'verify') {
		$vtype  = I('post.vtype','','addslashes');
		$domain = addslashes(I('post.domain','','strtolower'));
		$token  = I('post.token','','addslashes');
		
		if (empty($vtype)) {
			msgbox('请选择验证类型！');
		}
		
		if (empty($domain)) {
			msgbox('请输入要认领的域名！');
		} else {
			if (!is_valid_domain($domain)) {
				msgbox('请输入正确的网站域名！');
			}
		}
		
    	$query = $Db->query("SELECT web_id FROM $table WHERE web_url='$domain'");
    	if (!count($query)) {
        	msgbox('该网站还未被提交！');
    	}
		if(empty($userinfo['user_qq'])){
           msgbox('请在详细资料里面填写QQ');
		}
		$siteurl = format_url($domain);
		if ($vtype == 'file') {
			$content = get_url_content($siteurl.'site-verification.html');
			if ($content == $token) {
				$data = array('user_id' => $userinfo['user_id'],'web_qq'=>$userinfo['user_qq']);
				$Db->update($table,$data,"web_url = '$domain'");
				msgbox('网站认领成功！',url('website'));
			} else {
				msgbox('网站验证失败！');
			}
		}
		
		if ($vtype == 'meta') {
			$content = get_url_content($siteurl);
			if (preg_match('/<meta\s+name=\"site-verification\"\s+content=\"(.*?)\"/si', $content, $matches)) {
				if ($matches[1] == $token) {
					$Db->update($table, array('user_id' => $userinfo['user_id']), array('web_url' => $domain));
					msgbox('网站认领成功！',url('website'));					
				} else {
					msgbox('网站验证失败！');
				}
			} else {
				msgbox('您还未向首页添加元标记！');
			}
		}
	}
}

Youke_display($tplfile);
