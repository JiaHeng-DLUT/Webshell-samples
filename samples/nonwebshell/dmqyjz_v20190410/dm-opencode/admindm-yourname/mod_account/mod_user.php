<?php
/*	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';
//
 //if($act <> "pos") zb_insert($_POST);//will error of Warning: addslashes() because checkbox.
 
//if($pidname<>'') {ifhaspidname(TABLE_USER,$pidname);}
if($tid<>'') {ifhasid_nolang(TABLE_USER,$tid);}

/*
if (!in_array($type,$arr_group_type))
  {
  echo "error,type:".$type.' not exist...... in array:arr_group_type' ;
  exit;
  }
*/

 
//ifhaspidname(TABLE_NODE,$pid);
//ifhaspidname(TABLE_CATE,$catpid);
ifhave_lang(LANG);//TEST if have lang,if no ,then jump

$jumpv='mod_user.php?lang='.LANG;
$jumpvf=$jumpv.'&file='.$file;
$jumpv_add = $jumpv.'&file=add&act=add';

 
$title = '普通管理员';
/*-----------
*/

if($file=='add') $title = '添加管理员';
if($file=='edit') $title = '修改管理员'; 
//---


//----------
if($act == "pos")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_USER." set  pos='$v' where id='$k'   limit 1";
         iquery($ss);
        }
      jump($jumpv);
} 
 
if($act == "deluser")
{ 
  $ss2 = "delete from ".TABLE_USER."  where id= '$tid' and type='normal' limit 1"; 
  //echo $ss2;exit; 
      iquery($ss2); 
     alert('删除成功');
      jump($jumpv);
	 
}
//---------

 

//-----------

require_once HERE_ROOT.'mod_common/tpl_header.php';

?>

<section class="content-header">
     
      <ol class="breadcrumb">
        <li><?php echo $breadfaicon?>         
        <a href="../mod_account/mod_user.php?lang=<?php echo LANG?>">普通管理员</a> </li>
        

      </ol>
      <h1><?php echo $title?></h1>
</section>


 <section class="content">  

<?php
  if($file=='list'){
?>
  <div class="contenttop">
  <a href="<?php echo $jumpv_add?>"><i class="fa fa-plus-circle"></i> 添加</a>
</div>
<?php
  }
?>


        <?php   
           
        require_once HERE_ROOT.'mod_account/tpl_user_'.$file.'.php';
        ?>
 </section>


 

<?php
 
require_once HERE_ROOT.'mod_common/tpl_footer.php';



?>