<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
  
*/
require_once '../config_a/common.inc2010.php';
//$andlangbh = '';// important,use for ifhasid function
if($tid<>'')    ifhasid_nolang(TABLE_LANG,$tid); //ifhasid(TABLE_LANG,$tid);
 
if($act <> "pos") zb_insert($_POST);
$title = '合并base目录下的css';


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
 
 


<div style="padding:100px">
 
功能：把DM-block\template\base\css合并成compress.css 
<br /><br /><br />




<?php
$compressV = '';
$roothere = TEMPLATEROOT.'base/css/';  //it is root ,not path
//echo $roothere;

//$arr_aggcss  -- in config.php
//pre($arr_aggcss);
foreach ($arr_aggcss as $v) {
    $v_file = $roothere.$v.'.css';
    //echo $v_file;
    if(is_file($v_file)) $compressV .= file_get_contents($v_file);

}
 

//echo $compressV;


//echo $compressV;
  //  $compressV = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $compressV);
 // $compressV = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $compressV);
 $compressV = str_replace(array("\r\n", "\r", "\n", "\t"), '', $compressV);


$compress = $roothere.'compress.css';

if(is_file($compress)) 
  {
    file_put_contents($compress,'/* generate: '.$dateall.' - 本模板由DM建站系统 www.demososo.com开发*/'.$compressV);

echo '<a href="'.TEMPLATEPATH.'base/css/compress.css" target="_blank">查看 已合并成compress.css文件 ></a>';

}
else echo '出错，'.$compress.'文件不存在。';


 


?>

</div>
</section>
<?php 


require_once HERE_ROOT.'mod_common/tpl_footer.php'; 
 
?>

 