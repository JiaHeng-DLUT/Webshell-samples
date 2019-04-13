<?php
function getTopDomainhuo(){

		$host=$_SERVER['HTTP_HOST'];

		$host=strtolower($host);

		if(strpos($host,'/')!==false){

			$parse = @parse_url($host);

			$host = $parse['host'];
		}
		$topleveldomaindb=array('site','com','edu','gov','int','mil','net','org','biz','info','pro','name','museum','coop','aero','xxx','idv','mobi','cc','me');
		$str='';
		foreach($topleveldomaindb as $v){

			$str.=($str ? '|' : '').$v;
		}
		$matchstr="[^\.]+\.(?:(".$str.")|\w{2}|((".$str.")\.\w{2}))$";

		if(preg_match("/".$matchstr."/ies",$host,$matchs)){

			$domain=$matchs['0'];
		}else{

			$domain=$host;

		}
		return $domain;
}

// $domain=getTopDomainhuo();

// $real_domain = 'test.com'; //本地检查时 用户的授权域名 和时间

// $check_host= YOUKE365_UPDATE_URL.'?a=client_check&u='.$domain;

// $check_info= @file_get_contents($check_host);

// $check_info  = intval($check_info);
// if($check_info =='0'){
//    echo '域名未授权';
//    die;
// }elseif($check_info=='-1'){
//    echo '授权已经到期';
//    die;
// }

// if($check_info !== '1'){ // 远程检查失败的时候 本地检查
//    if($domain !== $real_domain){
//       exit('域名未授权 QQ: '.youke365_auth_qq);
//    }
// }
unset($domain);
