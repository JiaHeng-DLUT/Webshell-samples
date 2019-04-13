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
$tempfile = 'option.html';
$table = table('options');
$op = I('post.opt');
$option = I('get.opt',$op);
$action = isset($_POST['act'])?htmlspecialchars($_POST['act']):'';


$option =!empty($option)?$option:'basic';
$fileurl = url('option',['opt'=>$option]);

if (in_array($option, array('basic','module','template','reward','comment','misc', 'user', 'link', 'qq', 'mail'))) {
	switch ($option) {
		case 'basic' :
			$pagetitle = '站点信息';
			break;
		case 'module' :
			$pagetitle = '模块开发';
			break;
		case 'misc' :
			$pagetitle = '功能配置';
			break;
		case 'template' :
			$pagetitle = '模板配置';
			break;
		case 'user' :
			$pagetitle = '注册设置';
			break;
		case 'qq' :
			$pagetitle = 'QQ登陆';
			break;
		case 'comment' :
			$pagetitle = '评论设置';
		break;
		case 'link' :
			$pagetitle = '链接设置';
			break;
		case 'mail' :
			$pagetitle = '邮件设置';
			break;
		case 'reward' :
			$pagetitle = '打赏设置';
			break;

		default :
			$pagetitle = '站点信息';
			break;
	}


$cfg = get_options();

// print_r($cfg);
// 获得所有PC模板
$template_path = ROOT_PATH."themes/pc";

if(is_dir($template_path)){
	//自动加载公共函数资源
	$common_list = glob($template_path.'/*');

    $themes = [];
	foreach($common_list as $k=>$v){

		if(is_dir($v)){

// echo $v.'/skin.xml';
		  $themes[$k]['name']  =  file_get_contents($v.'/theme.xml');
	      $themes[$k]['dir']   = str_replace([$template_path,'/'],'',$v);
		}
		
	}

	$Youke->assign('themes', $themes);
}


// 获得所有手机主题
$template_path = ROOT_PATH."themes/mobile";

if(is_dir($template_path)){
	//自动加载公共函数资源
	$common_list = glob($template_path.'/*');
	;
    $mobile_themes = [];
	foreach($common_list as $k=>$v){
		 if(is_dir($v)){
		  $mobile_themes[$k]['name']  = file_get_contents($v.'/theme.xml');
	      $mobile_themes[$k]['dir']   = str_replace([$template_path,'/'],'',$v);
	    }
	}

	$Youke->assign('mobile_themes', $mobile_themes);
}


	$configs = stripslashes_deep($options);
	$configs['site_root'] = str_replace('\\', '/', dirname($site_root));
	
	$Youke->assign('pagetitle', $pagetitle);
	$Youke->assign('option', $option);
	$Youke->assign('cfg', $configs);
	unset($configs);
	 
	if ($action == 'update') {
		foreach ($_POST['cfg'] as $cname => $cval) {
			//if ($cname == 'site_url' && !empty($cval)) $cval .= (substr($cval, -1) != '/') ? '/' : '';
			if ($cname == 'data_update_cycle' && $cval <= 0) $cval = 3;
			if ($cname == 'filter_words') {
				$cval = str_replace('，', ',', $cval);
				$cval = str_replace(',,', ',', $cval);
				if (substr($cval, -1) == ',') {
					$cval = substr($cval, 0, strlen($cval) - 1);
				}


			 }

		if(!empty($_FILES['site_logo']['name'])){
		  //上传logo
		     
			 $Upload = new FileUpload;
			 $Upload->set('maxsize','1000000');
			 $Upload->set('israndname',false);		
			 
			 $Upload->set('path',ROOT_PATH.'public/images/');

			 $Upload->upload('site_logo');
			 if(!$Upload->getFileName()){
		         msgbox($Upload->getErrorMsg()); 
			 }else{
			         $site_logo = '/public/images/'.$Upload->getFileName();
			   		 rename(trim(ROOT_PATH,'/').$site_logo,trim(ROOT_PATH,'/').'/public/images/logo.png');
                     $site_logo = '/public/images/logo.png';
			        if($Upload->getFileName()){
				     $Db->query("SELECT option_name FROM $table WHERE option_name = 'site_logo'",'Row') ? 
					 $Db->update($table, 
					 	array('option_value' => $site_logo),
					 	"option_name = 'site_logo'") : $Db->insert($table,array('option_name' => 'site_logo', 'option_value' => $site_logo));
		           }
			 }
         }


         if(!empty($_FILES['qcode_alipay']['name'])){
		  //上传支付宝二维码
		     
			 $Upload2 = new FileUpload;
			 $Upload2->set('maxsize','1000000');
			 $Upload2->set('israndname',false);		
			 
			 $Upload2->set('path',ROOT_PATH.$options['upload_dir'].'/images/');

			 $Upload2->upload('qcode_alipay');
			 if(!$Upload2->getFileName()){
		         msgbox($Upload2->getErrorMsg()); 
			 }else{
			         $qcode_alipay = '/'.$options['upload_dir'].'/images/'.$Upload2->getFileName();
			   		 // rename(ROOT_PATH.$qcode_alipay,ROOT_PATH.$options['upload_dir'].'/images/qcode_alipay.png');
                     // $qcode_alipay = '/'.$options['upload_dir'].'/images/qcode_alipay.png';
			        if($Upload2->getFileName()){
				     $Db->query("SELECT option_name FROM $table WHERE option_name = 'qcode_alipay'",'Row') ? 
					 $Db->update($table, array('option_value' => $qcode_alipay),
					 	"option_name = 'qcode_alipay'") : 
					 $Db->insert($table,array('option_name' =>'qcode_alipay', 'option_value' => $qcode_alipay));
		           }
			 }

         }

         if(!empty($_FILES['qcode_weixin']['name'])){
		  //上传微信二维码
		     
			 $Upload3 = new FileUpload;
			 $Upload3->set('maxsize','1000000');
			 $Upload3->set('israndname',false);		
			 
			 $Upload3->set('path',ROOT_PATH.$options['upload_dir'].'/images/');

			 $Upload3->upload('qcode_weixin');
			 if(!$Upload3->getFileName()){
		         msgbox($Upload->getErrorMsg()); 
			 }else{
			         $qcode_weixin = '/'.$options['upload_dir'].'/images/'.$Upload3->getFileName();
			        if($Upload3->getFileName()){
				     $Db->query("SELECT option_name FROM $table WHERE option_name = 'qcode_weixin'",'Row') ? 
					 $Db->update($table, array('option_value' => $qcode_weixin),
					 	"option_name = 'qcode_weixin'") : $Db->insert($table,array('option_name' =>'qcode_weixin', 'option_value' =>$qcode_weixin));
		           }
			 }

		

         }

			  if (!get_magic_quotes_gpc()) { 
	
			     $cval = addslashes($cval); 
		      }
			$udata = array('option_value' => $cval);

	
			$uwhere = "option_name = '$cname'";
			$idata = array('option_name' => $cname, 'option_value' => $cval);
			
			$Db->query("SELECT option_name FROM $table WHERE option_name = '$cname'",'Row') ? 
			$Db->update($table, $udata, $uwhere) : $Db->insert($table, $idata);
		}
		update_cache('options');
		
		msgbox('更新系统配置成功！', $fileurl);
	}
}



Youke_display($tempfile);
