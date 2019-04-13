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
header('Content-type:text/json');  //json输出


//或皮肤
$theme = !empty($_GET['theme'])?htmlspecialchars($_GET['theme']):'';
if(empty($theme)){
  echo error_json('请求错误');
  exit;
}
$cfg = get_options();
// 获得所有皮肤
$template_path = ROOT_PATH."themes/pc/".$theme."/skin/";

if(is_dir($template_path)){
	//自动加载公共函数资源
	$common_list = glob($template_path.'/*');
    $skins = [];
	foreach($common_list as $k=>$v){
		if(is_dir($v)){
		  $skins[$k]['name']  = xml_to_array(file_get_contents($v.'/skin.xml'))['name'];
	      $skins[$k]['dir'] = str_replace([$template_path,'/'],'',$v);
		}

	}
}
$html ='<option value="">请选择</option>';
if(empty($skins)){ 
  echo error_json('<option value="">没有默认皮肤</option>');
  exit;
}

foreach($skins as $k=>$v){
	if($cfg['default_skin'] == $v['dir']){
        $selected = ' selected ';
	}else{
		 $selected = '';
	}
	$html .='<option '.$selected.'  value="'.$v["dir"].'">'.$v["name"].'</option>';
}

echo success_json('成功',$html);
exit;
