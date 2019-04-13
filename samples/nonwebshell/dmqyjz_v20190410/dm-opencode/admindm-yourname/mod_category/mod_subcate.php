<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
  
*/

require_once '../config_a/common.inc2010.php';
$menu_content = 'y';
ifhave_lang(LANG);//TEST if have lang,if no ,then jump

 
if($catid <> "")  ifhaspidname(TABLE_CATE,$catid);
if($pidname <> "")  {  
  ifhaspidname(TABLE_CATE,$pidname);
  $subpid = get_field(TABLE_CATE,'pid',$pidname,'pidname');
}
 
if($act <> "pos") zb_insert($_POST);

//$catarr = get_fieldarr(TABLE_CATE,$catid,'pidname');
//$catname = $catarr['name']; 

$title = '分类管理';
$catname = get_field(TABLE_CATE,'name',$catid,'pidname');

 if($pidname<>'') {
$ss = "select * from ".TABLE_CATE." where pidname= '$pidname' $andlangbh limit 1";
$row = getrow($ss);
if($row=='no'){alert($text_edit_nothisid);exit;}


 $catname=decode($row['name']);
 $cateofpagemenu = $download_title = $showkvdetail=$cus_columns_album='';//if add,then give null.
 
 $sta_listcan_inherit=$row['sta_listcan_inherit'];
 $arr_can=$row['arr_can'];
 $bscntarr = explode('==#==',$arr_can); 
 //pre($bscntarr);
 if(count($bscntarr)>1){
   foreach ($bscntarr as   $bsvalue) {
   if(strpos($bsvalue, ':##')){
     $bsvaluearr = explode(':##',$bsvalue);
     $bsccc = $bsvaluearr[0];
     $$bsccc=$bsvaluearr[1];
   }
 }
 }
 
//----------
}


/************************/

$jumpv='mod_subcate.php?lang='.LANG.'&catid='.$catid; 
$jumpvf=$jumpv.'&file='.$file;
 
$jumpvfp=$jumpvf.'&pidname='.$pidname;
$jumpvedit=$jumpvfp.'&act=edit';
 

$jumpvaddcatepop1='mod_pop_catesubadd.php?lang='.LANG.'&act=add&catpid='.$catid.'&catid='.$catid;
 
    //-----------------

if($act == "sta_catesub")
{
     $ss = "update ".TABLE_CATE." set sta_visible='$v' where id=$tid $andlangbh limit 1";
	// echo $ss;exit;
    iquery($ss);
    jump($jumpv);
}



if($act == "subpos")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_CATE." set  pos='$v' where id='$k'  $andlangbh  limit 1";
         iquery($ss);
        }
       jump($jumpv);
}
 



if($act == "delsubcate")
{ 

 $ifdel1 = ifcandel(TABLE_CATE,$pidname,'出错，有子分类不能删除，请先删除它的子分类！',$jumpv);// back is fail 
 $ifdel2 = ifcandel(TABLE_NODE,$pidname,'分类里有文章，请先在内容管理里删除文章！',$jumpv);

  ifsuredel_field(TABLE_LAYOUT,'pid',$pidname,'eq','noback');
   ifsuredel_field(TABLE_ALIAS,'pid',$pidname,'eq','noback');

 if($ifdel1 and $ifdel2 ) ifsuredel(TABLE_CATE,$pidname,$jumpv);	

}


//-------------------

require_once HERE_ROOT.'mod_common/tpl_header.php';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    

       <h1>  <?php 
//if($file<>'list') $catname='<a style="font-size:20px;" href="'.$jumpv.'">'.$catname.'</a>';
//else $title='<a style="font-size:20px;" href="mod_category.php?lang='.LANG.'">'.$title.'</a>';

$titlelink = '<a style="font-size:18px" href="mod_category.php?lang='.LANG.'">'.$title.'</a>';
$catemainlink =   ' &nbsp;&nbsp;<a style="font-size:14px"  href="mod_subcate.php?lang='.LANG.'&catid='.$catid.'"><i class="fa fa-caret-right"></i>返回子分类列表</a>';
$catemainedit=   ' &nbsp;&nbsp;<a style="font-size:14px"  href="mod_category.php?lang='.LANG.'&catid='.$catid.'&file=edit&act=edit"><i class="fa fa-caret-right"></i>主类修改</a> ';
   
//if($act=='list') $catemainlink ='';

$cntlink = ' &nbsp;&nbsp;<a href="../mod_node/mod_node.php?lang='.LANG.'&catpid='.$catid.'&page=0"><i class="fa fa-reorder"></i>内容管理</a>';

echo $titlelink.' - '.$catname.$catemainedit.$cntlink;
       ?>  </h1>

<?php 
if($act=='add' || $act=='edit')   echo  $catemainlink;

?>

</section> 

<section class="content">
    <?php 
        require_once HERE_ROOT.'mod_category/tpl_subcate.php'; 
    ?>
 

 </section>


<?php 

require_once HERE_ROOT.'mod_common/tpl_footer.php';

?>
