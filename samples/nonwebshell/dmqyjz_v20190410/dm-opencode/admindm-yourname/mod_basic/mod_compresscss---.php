<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
  
*/
require_once '../config_a/common.inc2010.php';
//$andlangbh = '';// important,use for ifhasid function
if($tid<>'')    ifhasid_nolang(TABLE_LANG,$tid); //ifhasid(TABLE_LANG,$tid);
 
if($act <> "pos") zb_insert($_POST);
$title = '合并css';


$submenu='basic';

//$jumpv ='pro-lang.php.'?lang='.LANG; //HERE IS NO LANG
$jumpv ='mod_aggbasecss.php?lang='.LANG;//use ?lang="",is for &,not ?
$jumpv_file =$jumpv.'&file='.$file;

/*************************************************/

 
require_once HERE_ROOT.'mod_common/tpl_header.php';
 
 

?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        网站设置
        <small> <?php echo $title?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="mod_lang.php?lang=<?php echo LANG?>"><i class="fa fa-dashboard"></i> 网站设置 </a></li>
        <li class="active"><?php echo $title?> </li>
      </ol>
    </section>
 
    <section class="content">
 
 
<?php 
 $arr_aggcss=array(
  'DMblock',
  'DMcommon',
 'responsive',
  
 );
 
 ?>

<div style="padding:100px">
 说明：
 本文件会把 

 DM-template/base/assets/css下的<br />

 <?php
 foreach ($arr_aggcss as $v){
    echo  $v.'.css <br />';
 }
 ?>
 
 <strong>合并成DMmini.css，请不要直接编辑DMmini.css</strong>

 
<br /><br /><br />




<?php
$compressV = '';
$roothere = TEMPLATEROOT.'base/assets/css/';  //it is root ,not path
// echo $roothere;

 $arr_aggcss=array(
  'DMblock',
  'DMcommon',
 'responsive',
  
 );

//$arr_aggcss  -- in config.php
//pre($arr_aggcss);
foreach ($arr_aggcss as $v) {
    $v_file = $roothere.$v.'.css';
   //  echo $v_file;
    if(is_file($v_file)) $compressV .= file_get_contents($v_file);

}
 

//echo $compressV;


//echo $compressV;
  //  $compressV = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $compressV);
 // $compressV = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $compressV);
 $compressV = str_replace(array("\r\n", "\r", "\n", "\t"), '', $compressV);


$dmminifile = $roothere.'DMmini.css';

if(is_file($dmminifile)) 
  {
    file_put_contents($dmminifile,'@charset "UTF-8";/* generate: '.$dateall.' - 本模板由DM建站系统 www.demososo.com开发 20180510  - 请不要直接修改本文件，具体请看后台的站点管理->资源管理 */ '.$compressV);

    echo '<a href="'.TEMPLATEPATH.'base/assets/css/DMmini.css" target="_blank">查看 已合并成 DMmini.css文件 ></a>';
    
}
else echo '出错，'.$dmminifile.'文件不存在。';


 


?>

</div>
</section>
<?php 


require_once HERE_ROOT.'mod_common/tpl_footer.php'; 
 
?>

 