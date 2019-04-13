<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
  
*/

require_once '../config_a/common.inc2010.php';
$menu_content = 'y';
ifhave_lang(LANG);//TEST if have lang,if no ,then jump

if($act <> "pos") zb_insert($_POST);
/********************************************/
$title = '单页面管理';
if($file=='add') $title="添加";
//
/************************/
//$sql = "SELECT id from ".TABLE_PAGE." where pbh='".USERBH."'  order by id desc";
 // $num = getnum($sql);
 // $limitnum='菜单限制数：'.$num_menu.' / 已用数：'.$num;
 
 
$jumpv='mod_page.php?lang='.LANG;
$jumpv_file='mod_page.php?lang='.LANG.'&file='.$file;


$jumpv_add=$PHP_SELF.'?lang='.LANG.'&file=add&act=add';
$jumpv_add_cate=$PHP_SELF.'?lang='.LANG.'&file=add_cate&act=add';
$jumpv_insert=$PHP_SELF.'?lang='.LANG.'&file=add&act=insert';
$jumpv_insert_cate=$PHP_SELF.'?lang='.LANG.'&file=add_cate&act=insert';

$jumpv_edit_custom=$PHP_SELF.'?lang='.LANG.'&file=edit_custom&act=edit';
$jumpv_update_custom=$PHP_SELF.'?lang='.LANG.'&file=edit_custom&act=update';

 
$jumpv_edit='mod_page_edit.php?lang='.LANG;//use for list link
 
if($act == "sta_menu")
{ 
     $ss = "update ".TABLE_PAGE." set sta_visible='$v' where id=$tid $andlangbh limit 1";	 
     iquery($ss);
    jump($jumpv);
}
if($act == "pos")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_PAGE." set  pos='$v' where id='$k'  $andlangbh limit 1";
         iquery($ss);
        }
      jump($jumpv);
}
//-------------------
if($act == "delpage")
{ 
// $ss = "select id from ".TABLE_CATE." where pidname='$pidname' $andlangbh limit 1"; 
 //if(getnum($ss)>0) {alert('出错，不能在这里删除分类菜单');jump($jumpvmenu);}
  
  //$ifdel1 = ifcandel(TABLE_PAGE,$pidname,'出错，有子菜单，请删除它的子菜单！',$jumpvmenu);// back is fail 

  $ifdel1 = ifcandel(TABLE_ALBUM,$pidname,'出错，有相册。请先删除。！',$jumpv);// back is fail 
  $ifdel2 = ifcandel(TABLE_IMGFJ,$pidname,'出错，编辑器附件里有图片。请先删除。！',$jumpv);// back is fail 
 if($ifdel1 and $ifdel2) {
  ifsuredel(TABLE_PAGE,$pidname,'noback');
  ifsuredel_field(TABLE_ALIAS,'pid',$pidname,'eq','noback');
  ifsuredel_field(TABLE_LAYOUT,'pid',$pidname,'eq',$jumpv);
  //ifcandel_bypid(TABLE_ALIAS,$pidname,'noback');  
  //ifcandel_bypid(TABLE_LAYOUT,$pidname,$jumpvpage);
 }
    
}

 

require_once HERE_ROOT.'mod_common/tpl_header.php';
?>
 

<section class="content-header">
 
      <h1><?php echo $title?></h1>
</section>
  
 
 <section class="content">  

<?php
  if($file<>'add'){
?>
  <div class="contenttop">
  <a href="<?php echo $jumpv_add?>"><i class="fa fa-plus-circle"></i> 添加</a>
</div>
<?php
  }
?>


        <?php   
           
        require_once HERE_ROOT.'mod_page/tpl_page_'.$file.'.php';
        ?>
 </section>
<?php
require_once HERE_ROOT.'mod_common/tpl_footer.php';
?>

