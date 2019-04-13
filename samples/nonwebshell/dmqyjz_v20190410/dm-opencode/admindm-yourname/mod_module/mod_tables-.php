<?php
/*  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
 
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);

  exit;
 echo $mysql_database;
 
 $tablearr = array('zzz_user',
              'zzz_album',
              'zzz_video',
              'zzz_block',
              'zzz_blockgroup',
              'zzz_column',
              'zzz_comment',
              'zzz_region',
              'zzz_layout',
              'zzz_imgfj',
              'zzz_alias',
              'zzz_cate',
              'zzz_lang',
              'zzz_menu',
              'zzz_page',
              'zzz_node',
              'zzz_tag',
              'zzz_tagnode',
              'zzz_field',
              'zzz_fieldoption',
              'zzz_fieldvalue',
              'zzz_style', 
            );
 
            pre($tablearr);
foreach($tablearr as $v) {

  echo $v.'<br />';

  // id not in （1，2，3）
   //$ss = "delete from zzz_node  where lang not in ('cn','en')";
  //iquehy($ss);


 $ss = "delete from $v  where lang not in ('cn','en')";
    //iquery($ss);







}
 //$result = mysql_list_tables($mysql_database);  can not use in php7
 
    
