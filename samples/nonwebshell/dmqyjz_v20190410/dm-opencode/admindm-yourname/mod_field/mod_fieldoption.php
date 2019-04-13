<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
  
*/


require_once '../config_a/common.inc2010.php';
ifhave_lang(LANG);//TEST if have lang,if no ,then jump


if($type=='radio' or $type=='checkbox' or $type=='select'){}
else {echo '错误的类型!<br /><br />';echo $backlist;exit;}

if($pid <> "") ifhaspidname(TABLE_FIELD,$pid);

if($act <> "pos") zb_insert($_POST);
//----------------
 $sql223 = "SELECT name from ".TABLE_FIELD." where  pidname='$pid' $andlangbh order by pos desc,id";
 $row223 = getrow($sql223);
 if($row223=='no') {echo 'error...';}
 else{
 $title = $row223['name'];
 }
 //----------------
$jumpv='mod_fieldoption.php?lang='.LANG.'&pid='.$pid.'&type='.$type;
$jumpv_file=$jumpv.'&file='.$file;

//----------------

if($act == "sta")
{
     $ss = "update ".TABLE_FIELDOPTION." set sta_visible='$v' where id=$tid $andlangbh limit 1";
	// echo $ss;exit;
    iquery($ss);
    jump($jumpv);
}

if($act == "pos")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_FIELDOPTION." set  pos='$v' where id='$k'  $andlangbh  limit 1";
         iquery($ss);
        }
      jump($jumpv);
}
if($act == "del")
{  

ifcandel_field(TABLE_FIELDVALUE,'value',$pidname,'like','出错，有文章用到了这个选项！请先删除用了这个选项的文章！或者不用删除，直接隐藏这个选项。',$jumpv);
//ifcandel_field($table,$field,$value,$typelike,$back)
  
 ifsuredel_field(TABLE_FIELDOPTION,'pidname',$pidname,'',$jumpv);
 //ifsuredel_field($table,$field,$value,$typelike,$back)
//old way: ifsuredel(TABLE_FIELDOPTION,$pidname,$jumpv);
}


//-------------------
require_once HERE_ROOT.'mod_common/tpl_header_iframe.php';
 ?>

 <section class="content-header">
  
      <h1><span class="cred" style="font-size:22px"><?php echo $title;?></span> 的 字段选项管理 </h1>
</section>
  
<section class="content"> 
 
  <div class="contenttop">

  <a class="fr but2" target="_blank" href="<?php echo $jumpv; ?>">弹出链接</a>

  <a class="fr but1" target="_blank" href="<?php echo $adminurl;?>">后台首页</a>

 <?php
  if($file=='list'){?>
    <a href='<?php echo $jumpv.'&file=addedit&act=add';?>'><i class="fa fa-plus-circle"></i> 添加选项</a>  
<?php
  }
 
  if($file<>'list'){
    ?>
   <a href="<?php echo $jumpv; ?>"><i class="fa fa-arrow-left"></i>  返回字段选项管理</a>

  <?php 
  }
?>
</div>





<?php
require_once HERE_ROOT.'mod_field/tpl_fieldoption_'.$file.'.php'; 
?>
</section>
<?php
require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php';
?>