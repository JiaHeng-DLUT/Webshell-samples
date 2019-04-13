<?php
/*	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
$mod_previ = 'normal';//default is admin,and set in common.inc
$mod_previ_except = 'y';
require_once '../config_a/common.inc2010.php';
require_once HERE_ROOT.'config_a/func.previ.php';//when normal,require is here.


ifhave_lang(LANG);//TEST if have lang,if no ,then jump
if($act <> "pos") zb_insert($_POST);

//----------------------
if($act=='edit' || $act=='update'){
$sqlsub = "SELECT  *  from " . TABLE_IMGTEXT . "  where  pidname='$pidname'   $andlangbh order by id limit 1";
//echo $sqlsub;exit;
    if(getnum($sqlsub)>0){
      $rowsub = getrow($sqlsub);
      //pre($rowsub);
      $pid = $rowsub['pid'];
    }
    else {
      echo 'imgtext not exist...';
      exit;
      }
  }

$jumpv='mod_mainimgtext.php?lang='.LANG.'&pid='.$pid;
$jumpvnopid='mod_mainimgtext.php?lang='.LANG;//when back from insert
$jumpvsubgl='mod_imgtext.php?lang='.LANG;


//-----------

$pid4 = substr($pid,0,4);
if($pid=='common') {
  $backparentpage = '';
}else{
  if($pid4=='node') {
    $partid = get_field(TABLE_NODE,'id',$pid,'pidname');
    if($partid=='noid') {  echo 'parent : page id not exist';exit;}
    $partitle = get_field(TABLE_NODE,'title',$pid,'pidname');
    $linknode = '../mod_node/mod_node_edit.php?lang='.LANG.'&tid='.$partid.'&act=list&file=editdesp';
  $backparentpage = '<div style="padding:5px 0">父级： <a href="'.$linknode.'">'.$partitle.'</a></div>';

  }
  else if($pid4=='page') {
       $partid = get_field(TABLE_PAGE,'id',$pid,'pidname');
       if($partid=='noid') {  echo 'parent : page id not exist';exit;}
       $partitle = get_field(TABLE_PAGE,'name',$pid,'pidname');
     $backparentpage = '<div style="padding:5px 0">父级： <a href="../mod_page/mod_page_edit.php?lang='.LANG.'&tid='.$partid.'&file=edit_desp&act=edit">'.$partitle.'</a></div>';
  }
  else{
    echo 'error,pid is wrong';
    exit;
  }

}

//----------
if($act == "pos")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_IMGTEXT." set  pos='$v' where id='$k'  $andlangbh  limit 1";
         iquery($ss);
        }
      jump($jumpv);
}

if($act == "sta_block")
{
     $ss = "update ".TABLE_IMGTEXT." set sta_visible='$v' where id=$tid $andlangbh limit 1";
     iquery($ss);
    jump($jumpv);
}


if($act == "del_block")
{
 $ifdel1 =  ifcandel_field(TABLE_IMGTEXT,'pid',$pidname,'equal','出错，请先删除子记录！',$jumpv);
 ifsuredel_field(TABLE_IMGTEXT,'pidname',$pidname,'eq',$jumpv);

}



//-----------




$title=$title1='图文生成器管理';
  require_once HERE_ROOT.'mod_common/tpl_header.php';

?>

<section class="content-header">

     <h1>  <?php
$title2='';
if($act<>'list'){
  $title1='<a href="'.$jumpv.'" style="font-size:18px">图文生成器管理</a>';
   if($act=='add') $title2=' - 添加';
   else $title2=' - 修改';
   echo $title1.$title2;
}
else{
 echo $title1;
  echo  ' <a href="'.$jumpv.'&act=add"><i class="fa fa-plus-circle"></i> 添加</a>';
  echo $backparentpage;
}




     ?> </h1>
</section>

<section class="content" style="min-height:350px">





<?php

if($act=='' || $act=='list')  require_once HERE_ROOT.'mod_imgtext/tpl_mainimgtext_list.php';
else  require_once HERE_ROOT.'mod_imgtext/tpl_mainimgtext_addedit.php';
?>
<div class="c"></div>

</section>

<?php
if($act2=='headless'){
  require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php';
  }
  else
require_once HERE_ROOT.'mod_common/tpl_footer.php';

?>
