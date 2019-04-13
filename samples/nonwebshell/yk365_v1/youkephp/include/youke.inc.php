<?php
$table = table('templates');
$cfg = get_options();
$Youke = new Youke();	
if ($_module == 'admin') {	
    $dirname = APP_PATH.$_module.'/view/';
	  $Youke->cache_lifetime = 0;
	  $Youke->caching = false;
    $Youke->template_dir = ROOT_PATH.$dirname;
    define('tpl',$dirname); //默认模板
} elseif($_module == 'member' || $_module == 'home'){
    $template_dir = THEME_DIR.'/'.'pc/'.$cfg['default_theme'].'/';
	  $dirname      = $_module;
    $Youke->caching = false;
	  $lifetime     = CACHE_LIFETIME;
    $Youke->template_dir = ROOT_PATH.$template_dir.$dirname.'/';
    define('tpl','/'.$template_dir); //默认模板
}elseif($_module == 'mobile'){
	$default_tpl  = $cfg['default_mobile_theme']; //默认主题
	$template_dir = THEME_DIR;  //主题目录
	$dirname      = $_module;
  $Youke->template_dir = ROOT_PATH.$template_dir.'/'.$dirname.'/'.$default_tpl.'';
	 define('tpl','/'.$template_dir.$dirname.'/'); //默认模板	
}



function template_exists($template) {
	global $Youke;
	if (!$Youke->templateExists($template)){
		exit('YOUKE365提醒："'.$template.'"模板不存在！');
	}
}


// $Youke->registerPlugin("block","tag", "tag");

//获得网站信息
function tag($params, $content, $Youke, &$repeat, $template){
	global $Db;
	$table= $params['table'];
	$name= !empty($params['name'])?$params['name']:'*';
	$field= !empty($params['field'])?$params['field']:'*';
	$where= !empty($params['where'])?$params['where']:'';
	$order= !empty($params['order'])?$params['order']:'';
	$limit= !empty($params['limit'])?$params['limit']:'10';
	// $field='*',$where='',$order='',$limit='10'
	  $where = "";
   if(!empty($where)){
     $where  .="where {$where} ";
     }
     $order ='';
     if(!empty($order)){
      $order  .="order {$order} ";
     }
     $limit ='';
       if(!empty($limit)){
      $limit  .="limit {$limit} ";
     }

   $sql  ="select {$field} from ".table($table)." {$where} {$order} {$limit}";
   $query = $Db->query($sql);
   $data = [];
   	while ($web = $Db->fetch_array($query)) {
   		$data[] = $web;
   	}
 //   	$html .="echo <{foreach from='data' item='".$name."'}>";
	// $html .= $content;
 //    $html .="echo <{/foreach}>";
    // print_r($data);
   	return $html;
}


//获得文章信息
//获得视频信息
//获得游戏信息


// function tag($table='',$field='*',$where='',$order='',$limit='10'){
// 	  $where = "";
//    if(!empty($where)){
//      $where  .="where {$where} ";
//      }
//      $order ='';
//      if(!empty($order)){
//       $order  .="order {$order} ";
//      }
//      $limit ='';
//        if(!empty($limit)){
//       $limit  .="limit {$limit} ";
//      }

//    $sql  ="select {$field} from {$table} {$where} {$order} {$limit}";

// }

