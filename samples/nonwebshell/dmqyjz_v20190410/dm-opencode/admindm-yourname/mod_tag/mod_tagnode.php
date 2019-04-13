<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
  
*/
require_once '../config_a/common.inc2010.php';
//$andlangbh = '';// important,use for ifhasid function
if($tid<>'')    ifhasid_nolang(TABLE_TAG,$tid); //ifhasid(TABLE_TAG,$tid);
 if($pid<>'')    ifhaspidname(TABLE_NODE,$pid); //ifhasid(TABLE_TAG,$tid);
 
if($act <> "pos") zb_insert($_POST);

 

$jumpvnolang ='mod_tagnode.php';
$jumpv ='mod_tagnode.php?lang='.LANG;//use ?lang="",is for &,not ?
$jumpv_file =$jumpv.'&file='.$file;
$jumpv_add =$jumpv.'&file=addedit&act=add';

 
if($act=='add') $title = '添加';
else if($act=='edit') $title = '修改';
else  $title = '添加标签';


$arr_tag = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');



/*************************************************/


if($act == "sta")
{
     $ss = "update ".TABLE_TAG." set sta_visible='$v' where id=$tid   limit 1";//$andlangbh
    iquery($ss);
    jump($jumpv);
}
 


 

if($act == "pos")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_TAG." set  pos='$v' where id='$k'   limit 1";
         iquery($ss);
        }
      jump($jumpv);
}

 if($act == "del_tag")
{ 
  
        ifsuredel_field(TABLE_TAG,'id',$tid,'eq',$jumpv);
    
  
}



/*************************************************/
require_once HERE_ROOT.'mod_common/tpl_header_iframe.php';

?>



    <!-- Content Header (Page header) -->
    <section class="content-header">

        <ol class="breadcrumb">
        <li><a target="_blank" href="mod_tag.php?lang=<?php echo LANG?>"><i class="fa fa-dashboard"></i> 标签管理</a></li>
        <li class="active"><?php echo $title?> </li>
      </ol>

      <h1>
       <?php echo $title?> 
      </h1>
  
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
         
         require_once HERE_ROOT.'mod_tag/tpl_tagnode_'.$file.'.php';
         
        ?>

 </section>

<?php
require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php'; 


?>

 