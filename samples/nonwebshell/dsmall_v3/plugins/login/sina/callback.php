<?php
//判断是否已经登录
if(session('slast_key'))
{
	header("Location:".HOME_SITE_URL);
	exit;	
}
include_once(PLUGINS_PATH .DS. 'login'.DS . 'sina'.DS.'config.php');
include_once(PLUGINS_PATH .DS. 'login'.DS . 'sina'.DS.'saetv2.ex.class.php' );
$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY);
///////////code需要传递////////////
if (isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken( 'code', $keys ) ;
	} catch (OAuthException $e) {
	}
}

if ($token) {
	session('slast_key', $token);
	cookie( 'weibojs_'.$o->client_id, http_build_query($token) );
	//转到注册登录页面
	@header('location: '.HOME_SITE_URL.DS.'Connectsina');
	exit;
} else { echo "授权失败。"; }
