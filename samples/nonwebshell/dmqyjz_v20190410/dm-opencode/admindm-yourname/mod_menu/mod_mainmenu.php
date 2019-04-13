<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
  
*/

require_once '../config_a/common.inc2010.php';
$menu_content = 'y';
ifhave_lang(LANG);//TEST if have lang,if no ,then jump

if($act <> "pos") zb_insert($_POST);
/********************************************/

if(is_numeric($tid)) {   ifhasid(TABLE_MENU,$tid);}


if($file=='') $file='list';
$filearr =  array("list", "addedit");  
if(!in_array($file,$filearr))   {echo 'file is error.';exit;}
//
/************************/
//$sql = "SELECT id from ".TABLE_MENU." where pbh='".USERBH."'  order by id desc";
 // $num = getnum($sql);
 // $limitnum='菜单限制数：'.$num_menu.' / 已用数：'.$num;
 
$jumpv='mod_mainmenu.php?lang='.LANG;
$jumpvf='mod_mainmenu.php?lang='.LANG.'&file='.$file;
$jumpvadd='mod_mainmenu.php?lang='.LANG.'&file=addedit&act=add'; 
$jumpvinsert='mod_mainmenu.php?lang='.LANG.'&file=addedit&act=insert'; 

$jumpvedit='mod_mainmenu.php?lang='.LANG.'&file=addedit&act=edit'; 
$jumpvupdate='mod_mainmenu.php?lang='.LANG.'&file=addedit&act=update'; 

 
 $title = '菜单管理';
 if($act=="add") $title2 = '<a class="breadtitle" href="'.$jumpv.'">返回菜单管理</a> - 添加';
 else if($act=='edit') $title2 = '<a  class="breadtitle"  href="'.$jumpv.'">返回菜单管理</a> - 修改';
 else $title2 = '菜单管理';
 
if($act == "sta_menu")
{ 
     $ss = "update ".TABLE_MENU." set sta_visible='$v' where id=$tid $andlangbh limit 1";	 
     iquery($ss);
    jump($jumpv);
}
if($act == "pos")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_MENU." set  pos='$v' where id='$k'  $andlangbh limit 1";
         iquery($ss);
        }
      jump($jumpv);
}
//-------------------
if($act == "del")
{ 
   $ss = "select id from ".TABLE_MENU." where ppid='$pidname'   $andlangbh limit 1"; 
    $row = getrow($ss);
    if($row=='no'){
         $ss2 = "delete from ".TABLE_MENU."  where pidname='$pidname'   $andlangbh limit 1";
     //echo $ss2.'<br />'; 
      iquery($ss2); 
      }
      else {alert('出错，该菜单组 里 有菜单！');jump($jumpv); }

 
}

 

require_once HERE_ROOT.'mod_common/tpl_header.php';

?>

<section class="content-header"> 
      <h1><?php echo $title2?></h1> 
</section>
  
 
 <section class="content">  

<?php
  if($file=='list'){
?>
  <div class="contenttop">
  <a href="<?php echo $jumpvadd?>"><i class="fa fa-plus-circle"></i> 添加菜单组</a>
</div>
<?php
  }
?>


        <?php   
           
       require_once HERE_ROOT.'mod_menu/tpl_mainmenu_'.$file.'.php';

        ?>
 </section>
<?php
require_once HERE_ROOT.'mod_common/tpl_footer.php';
?>



