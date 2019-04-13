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
$sqlsub = "SELECT  *  from " . TABLE_ALBUM . "  where  pidname='$pidname'   $andlangbh order by id limit 1";
 //echo $sqlsub;exit;
    if(getnum($sqlsub)>0){
      $rowsub = getrow($sqlsub); 
      $pid = $rowsub['pid'];
    }
    else {
      echo 'album not exist...';
      exit;
      }
  }
 
$jumpv='mod_mainalbum.php?lang='.LANG.'&pid='.$pid;
$jumpvnopid='mod_mainalbum.php?lang='.LANG;//when back from insert
$jumpvsubgl='mod_album.php?lang='.LANG;


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
         $ss = "update ".TABLE_ALBUM." set  pos='$v' where id='$k'  $andlangbh  limit 1";
         iquery($ss);
        }
      jump($jumpv);
}

if($act == "sta_block")
{
     $ss = "update ".TABLE_ALBUM." set sta_visible='$v' where id=$tid $andlangbh limit 1";
     iquery($ss);
    jump($jumpv);
}


if($act == "del_block")
{

  $ifdel1 =  ifcandel_field(TABLE_ALBUM,'pid',$pidname,'equal','出错，相册里还有图片，请先删除图片！',$jumpv);


   ifsuredel_field(TABLE_ALBUM,'pidname',$pidname,'eq',$jumpv);


}



//-----------



$title=$title1='相册区块管理';
$title2='';
 

if($act2=='headless'){
require_once HERE_ROOT.'mod_common/tpl_header_iframe.php';
}
else  require_once HERE_ROOT.'mod_common/tpl_header.php';

?>



<section class="content-header">

     <h1>  <?php
$title2='';
if($act<>'list'){
  $title1='<a href="'.$jumpv.'" style="font-size:18px">相册区块管理</a>';
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
 if($act2=='headless'){
   ?>
   <a class="fr but2 iframeparentlink" target="_blank" href="#">弹出链接</a>

  <a class="fr but1" target="_blank" href="<?php echo $adminurl;?>">后台首页</a>



   <?php
 }
 ?>

<?php

if($act=='' || $act=='list')  require_once HERE_ROOT.'mod_album/tpl_mainalbum_list.php';
else  require_once HERE_ROOT.'mod_album/tpl_mainalbum_addedit.php';
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
