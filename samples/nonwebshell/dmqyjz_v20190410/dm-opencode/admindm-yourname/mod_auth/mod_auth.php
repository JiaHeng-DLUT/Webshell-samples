<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
  
*/
require_once '../config_a/common.inc2010.php';
 
//$andlangbh = '';// important,use for ifhasid function
if($tid<>'')    ifhasid_nolang(TABLE_AUTH,$tid); //ifhasid(TABLE_LANG,$tid);
 
if($act <> "pos") zb_insert($_POST);

 

$jumpvnolang ='mod_auth.php';
$jumpv ='mod_auth.php?lang='.LANG;//use ?lang="",is for &,not ?
$jumpvf =$jumpv.'&file='.$file; 
$jumpvfaddedit =$jumpv.'&file=addedit'; 

$title = '会员管理';
if($act=="add") $title2 = '<a class="breadtitle" href="'.$jumpv.'">会员管理</a> - 添加';
else if($act=='edit') $title2 = '<a  class="breadtitle"  href="'.$jumpv.'">会员管理</a> - 修改';
else $title2 = '会员管理';

/*************************************************/


if($act == "sta")
{
     $ss = "update ".TABLE_LANG." set sta_visible='$v' where id=$tid   limit 1";//$andlangbh
    iquery($ss);
    jump($jumpv);
}
 
 

if($act == "pos")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_LANG." set  pos='$v' where id='$k'   limit 1";
         iquery($ss);
        }
      jump($jumpv);
}

 
if($act == "del")
{
     echo 'del user.......';
     exit;
}


/*************************************************/
require_once HERE_ROOT.'mod_common/tpl_header.php';

?>
 
    <!-- Content Header (Page header) -->
    <section class="content-header">
 
      <h1>
       <?php echo $title2;?> 
      </h1>
  
    </section>
 
    <section class="content">
<?php 
if($act=='list'){
?>
 
      <div class="contenttop">
      
      <a href="<?php echo $jumpvfaddedit?>&act=add"><i class="fa fa-plus-circle"></i> 添加会员</a>
      </div>
<?php 
}
?>  
        <?php
         $file = HERE_ROOT.'mod_auth/tpl_auth_'.$file.'.php';
         if(checkfile($file)) require $file; 
        ?>

 </section>

<?php
require_once HERE_ROOT.'mod_common/tpl_footer.php'; 


?>

 