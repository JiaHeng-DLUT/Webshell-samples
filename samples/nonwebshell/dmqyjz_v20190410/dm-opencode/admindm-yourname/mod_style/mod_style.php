<?php
/*	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);
 
 if($pidname<>'') {
  ifhaspidname(TABLE_STYLE,$pidname);
 
}

 
//ifhaspidname(TABLE_NODE,$pid);
//ifhaspidname(TABLE_CATE,$catpid);
ifhave_lang(LANG);//TEST if have lang,if no ,then jump



$jumpv='mod_style.php?lang='.LANG;
$jumpv_p=$jumpv.'&pidname='.$pidname;
$jumpv_f=$jumpv.'&file='.$file;
$jumpv_pf=$jumpv_p.'&file='.$file;
$jumpv_pf2=$jumpv_p.'&file='.$file.'&file2='.$file2;

//----
$submenu='basic';
$title = '模板管理';

$edit_cur =$editdaoin_cur =$editdaoout_cur =$editcss_cur=$editblockid_cur=$editlayout_cur=$editcssdesp_cur=$editcsssql_cur=$editcssactive_cur='';
$editcustomcss_cur=$editcssfile_cur='';
$title2='';
 $mbname = '';
 if(substr($file,0,4)=='edit') $mbname = get_field(TABLE_STYLE,'title',$pidname,'pidname');
 

if($file=='add') { $title2=' - 添加模板';}
if($file=='edit_can') { $title2 =' - 修改模板 ('.$mbname.') ';$edit_cur ='active';}
if($file=='edit_blockid') { $title2=' - 修改标识 ('.$mbname.') ';$editblockid_cur ='active';}
if($file=='edit_newcustomcss') { $title2=' - 修改样式 ('.$mbname.') ';  $editcustomcss_cur ='active';}
if($file=='edit_newcssfile') { $title2=' - 样式文件 ('.$mbname.') ';  $editcssfile_cur ='active';}

/*


if($file=='edit_cssdesp') { $title='修改自定义样式';$editcss_cur =$editcssdesp_cur ='active';}
if($file=='edit_csssql') { $title='修改数据库样式';$editcss_cur =$editcsssql_cur ='active';}
if($file=='edit_cssactive') { $title='开启数据库样式';$editcss_cur =$editcssactive_cur ='active';}



if($file=='edit_layout') { $title='修改公共布局';$editlayout_cur ='active';}
if($file=='edit_daoin') { $title='导入';$editdaoin_cur ='active';}
if($file=='edit_daoout') { $title='导出';$editdaoout_cur ='active';}
 */




 if($act == "pos")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_STYLE." set  pos='$v' where id='$k'  $andlangbh  limit 1";
         iquery($ss);
        }
      jump($jumpv);
}

if($act == "sta")
{ 
     $ss = "update ".TABLE_STYLE." set sta_visible='$v' where id=$tid $andlangbh limit 1";   
     iquery($ss);
    jump($jumpv); 
}


if($act=='activatestyle'){

  $ss = "update ".TABLE_LANG." set curstyle='$pidname' where lang='".LANG."' limit 1";
 
    iquery($ss);

//alert('启动成功，请到前台去查看效果。');
jump($jumpv);
}


if($act == "del")
{ 
 
$stylearr = get_fieldarr(TABLE_STYLE,$pidname,'pidname');
 
$kv = $stylearr['kv'];
 
 
  //$cssfile = ASSETSROOT.$cssdir .'/css/'.$pidname.'.css';
  //$cssfilesql = ASSETSROOT.$cssdir .'/css/sql_'.$pidname.'.css';
  $kvimg = UPLOADROOTIMAGE.$kv;
 
 // if(is_file($cssfile))  unlink($cssfile);
//if(is_file($cssfilesql))  unlink($cssfilesql);

//if(is_file($kvimg))  unlink($kvimg);
 
  //temp notdel layout
  $delss = "delete from ".TABLE_LAYOUT." where pidstylebh='$pidname' $andlangbh";  
 // iquery($delss); ---no real del kv and layout data.

   //del style:
  ifsuredel_field(TABLE_STYLE,'pidname',$pidname,'eq',$jumpv);

   
}

//-----------

require_once HERE_ROOT.'mod_common/tpl_header.php'; 

?>


<!-- Content Header (Page header) -->
<section class="content-header">
    
       
        <h1><?php 

   $titlelink=$title;
   if($pidname==$curstyle)  $title2=$title2.'<span class="cred">[前台正在使用这个模板]</span>';
       if($file<>'list')  $titlelink='<a style="font-size:20px" href="'.$jumpv.'">'.$title.'</a>'; 
       
      echo  $titlelink.$title2; 
        ?>
          
        </h1>

</section>

  <?php   
 if($act=='edit')    require_once HERE_ROOT.'mod_style/tpl_style_tab.php';
    ?>

 <section class="content">       
        <?php   
        if($file=='edit_cssdesp' || $file=='edit_csssql' || $file=='edit_cssactive')      
            require_once HERE_ROOT.'mod_style/tpl_style_edit_cssPAGE.php';
          else  require_once HERE_ROOT.'mod_style/tpl_style_'.$file.'.php';
        ?>
 </section>
<?php
require_once HERE_ROOT.'mod_common/tpl_footer.php';

?>
