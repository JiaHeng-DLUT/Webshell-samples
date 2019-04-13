<?php
/*	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
$mod_previ = 'normal';//default is admin,and set in common.inc
$mod_previ_except = 'y';
require_once '../config_a/common.inc2010.php';
require_once HERE_ROOT.'config_a/func.previ.php';//when normal,require is here.
 
 

ifhave_lang(LANG);//TEST if have lang,if no ,then jump
if($act <> "pos") zb_insert($_POST);
//

//if($type=='node') { ifhaspidname(TABLE_NODE,$pid); }
 //else if($type=='block') {
   //     if($pid<>'0')  { echo 'type is block,then pid must be 0.';exit; }
  //} 
  //else { echo 'type is error...';exit;}

  //-----------
//----------------------
if($act=='edit' || $act=='update'){
  $sqlsub = "SELECT  *  from " . TABLE_VIDEO . "  where  pidname='$pidname'   $andlangbh order by id limit 1";
   //echo $sqlsub;exit;
      if(getnum($sqlsub)>0){
        $rowsub = getrow($sqlsub); 
        $pid = $rowsub['pid'];
      }
      else {
        echo 'video not exist...';
        exit;
        }
    }
  //------------------
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

 //------------------

$jumpv='mod_video.php?lang='.LANG.'&pid='.$pid;
$jumpvnopid='mod_video.php?lang='.LANG;//when back from insert
$jumpv_file=$jumpv.'&file='.$file;
$addlink = '<a href="'.$jumpv.'&act=add"><i class="fa fa-plus-circle"></i> 添加视频区块</a>';

 

//----------
if($act == "pos")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_VIDEO." set  pos='$v' where id='$k'  $andlangbh  limit 1";
         iquery($ss);
        }
      jump($jumpv);
}

if($act == "sta_block")
{
     $ss = "update ".TABLE_VIDEO." set sta_visible='$v' where id=$tid $andlangbh limit 1";
     iquery($ss);
    jump($jumpv);
}


if($act == "delvideo")
{
  
     $sqlsub = "SELECT * from ".TABLE_VIDEO."  where  id='$tid'  $andlangbh order by id limit 1";
   // echo $sqlsub;exit;
$rowsub = getrow($sqlsub);
$imgsqlname = $rowsub['kv'];
$pidname = $rowsub['pidname'];

   // $ifdel1 = ifcandel_field(TABLE_IMGFJ,'pid',$pidname,'eq','编辑器里有图片。请先删除。',$jumpvpage);
   //bec editor img is common...
    //if($ifdel1){
     if($imgsqlname<>'')  p2030_delimg($imgsqlname,'y','n');

 $ss = "delete from ".TABLE_VIDEO."  where  id='$tid'   $andlangbh order by id limit 1";
 iquery($ss);

 jump($jumpv);
      //  ifsuredel_field(TABLE_VIDEO,'pidname',$pidname,'eq',$jumpv);
    //}

}
 
 

$title=$title1='视频区块管理';
$title2='';

  require_once HERE_ROOT.'mod_common/tpl_header.php';

?> 

 

<section class="content-header">

     <h1>  <?php
$title2='';
if($act<>'list'){
  $title1='<a href="'.$jumpv.'" style="font-size:18px">视频区块管理</a>';
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
      if($act=='list'){
      ?>
      <div class=" ">
        <div class="fl col-md-8">    
       <?php
              //echo $addlink;
            ?>

      </div>
      <!--下面的不显示，暂不用-->
     <div class="fl col-md-4" style="display:none">
      <form onsubmit="javascript:return checksearch(this)" id="search_form" action="<?php echo $jumpv;?>" method="post" accept-charset="UTF-8">
          搜索： <input class="navsearch_input" type="text" name="searchword" value="请输入标题" style="width:250px;padding:5px;" onfocus="javascript:this.value='';" />
            <input type="submit" name="Submit" value="搜索" class="searchgo" style="padding:5px 10px;cursor:pointer" />
            </form>

      </div>


      </div>
    <?php
    }
    ?>


 

<?php

if($act=='' || $act=='list') {
  require_once HERE_ROOT.'mod_video/tpl_video_list.php';
}
else  require_once HERE_ROOT.'mod_video/tpl_video_addedit.php';
?>
<div class="c"></div>

</section>

<?php
 require_once HERE_ROOT.'mod_common/tpl_footer.php';

?>

 <script>
    function checksearch(thisForm) {
        if (thisForm.searchword.value == "" || thisForm.searchword.value == "请输入标题" )
        {
            alert("请输入标题。");
            thisForm.searchword.focus();
            return (false);
        }
        // return;
    }
</script>
