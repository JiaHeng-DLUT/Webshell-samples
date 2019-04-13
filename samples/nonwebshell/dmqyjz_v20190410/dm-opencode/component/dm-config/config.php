<?php
$stadir='DM-static/';

 date_default_timezone_set('Asia/Shanghai'); //设置时区
 // echo date('d-m-Y H:i:s');

//$stapath=$baseurl.$stadir;
//define('STAPATH', $stapath);  //  all move to indexDM_load.php

$PHP_SELF=$_SERVER['PHP_SELF'];
define('HTTPS','http'); //use in admin common.php domain
//------------
$attach_type=array('jpg','gif','jpeg','png','rar','ico','zip','docx','xlsx','pptx');//限制上件文件的扩展名
$attach_size=630200;//限制上件文件的大小
$format_t=implode(' .',$attach_type);
$format_t=  '支持的格式：.'.$format_t.'  ，附件不能大于'.intval($attach_size/1024).'K。';

$album_s_w=280;
$album_s_h=280;
//------------
 
define('SHOPPINGBAG','n');
//---------

define('LANGICOSWITCH','n'); //多语方图片切换。
define('ENABLEMULTISITE','n');
define('SITEIDBYDOMAIN','n'); // hide / y / n/   use domain to judge site id.多站点或多语言时才选y


 
 //设置默认主语言
 $mainlang = 'cn'; //set main lang when multilang


$arr_lang=array(
   'wuliu'=>'物流网站',
   'fr'=>'法语',
   'trade'=>'外贸trade',
   'dmb101'=>'mb101',
   'dmb102'=>'mb102',
   'dmb103'=>'mb103',
   'dmbhill'=>'mbhill',

  );
//----------------------
$salt = '00';
$sespshou='5633da';//num geshu is important

$norr2='没有找到相关内容，请添加。';
$filenotexist='文件不存在，请检查填写是否正确。';
$var404='404.html';

$bshou=date("Ymd_His").rand(1000,9999);//is pidname
$dateall = date("Y-m-d H:i:s");
$dateday = date("Y-m-d");

define('MULTICATE','n');





?>
