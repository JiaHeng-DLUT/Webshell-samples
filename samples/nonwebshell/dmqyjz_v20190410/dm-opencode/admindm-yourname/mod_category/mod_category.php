<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
  
*/

require_once '../config_a/common.inc2010.php';
$menu_content = 'y';
ifhave_lang(LANG);//TEST if have lang,if no ,then jump


 
if($act == "edit" || $act=='editcan')  ifhaspidname(TABLE_CATE,$catid);

if($act <> "pos") zb_insert($_POST);
 
 
 //----------
 $catname= '';
 if($catid<>''){
  ifhaspidname(TABLE_CATE,$catid);

      //$catname = get_field(TABLE_CATE,'name',$catid,'pidname');
      $ss = "select * from ".TABLE_CATE." where pidname= '$catid' $andlangbh limit 1";
      $row = getrow($ss);
      $catname=decode($row['name']);
      $cateofpagemenu = $download_title = $showkvdetail='';//if add,then give null.
      $relamaxline = 20;
      $relapid = 'y';
     

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
 }



/************************/
//$sql = "SELECT id from ".TABLE_MENU." where pbh='".USERBH."'  order by id desc";
 // $num = getnum($sql);
 // $limitnum='菜单限制数：'.$num_menu.' / 已用数：'.$num;
$jumpv='mod_category.php?lang='.LANG;
$jumpv_file=$jumpv.'&file=add';
$jumpvcatid=$jumpv.'&catid='.$catid;
$jumpvcatidf=$jumpvcatid.'&file='.$file;
 $jumpvedit=$jumpvcatid.'&file=edit&act=edit';
 $jumpveditcan=$jumpvcatid.'&file=can&act=editcan';


 



$title = '分类管理';

 //-----------------


if($act == "pos")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_CATE." set  pos='$v' where id='$k'  $andlangbh  limit 1";
         iquery($ss);
        }
      jump($jumpv);
}
 




if($act == "delmaincate")
{ 
 $ifdel1 = ifcandel(TABLE_CATE,$pidname,'出错，有子分类不能删除，请先删除它的子分类！',$jumpv);// back is fail 
 //$ifdel2 = ifcandel(TABLE_FIELD,$pidname,'分类里有字段！请先在字段管理里删除字段！',$jumpv);
 $ifdel3 = ifcandel(TABLE_NODE,$pidname,'分类里有内容，请先在内容管理里删除内容！',$jumpv);
 //$ifdel4 = ifcandel(TABLE_MENU,$pidname,'此分类有子菜单，请先在菜单管理 里删除。！',$jumpv);

 if($ifdel1   and $ifdel3) {

  ifsuredel_field(TABLE_LAYOUT,'pid',$pidname,'eq','noback');
   ifsuredel_field(TABLE_ALIAS,'pid',$pidname,'eq','noback');
	//ifcandel_bypid(TABLE_LAYOUT,$pidname,'noback');
	//ifcandel_bypid(TABLE_ALIAS,$pidname,'noback');

	ifsuredel(TABLE_MENU,$pidname,'noback'); //DEF IS BY PIDNAME
	ifsuredel(TABLE_CATE,$pidname,$jumpv);
 }
	
}


//-------------------

require_once HERE_ROOT.'mod_common/tpl_header.php';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
     
     
       <h1>  <?php 


$titlelink = '<a style="font-size:18px" href="mod_category.php?lang='.LANG.'">'.$title.'</a>';
 $catemainlink =   ' &nbsp;&nbsp;<a style="font-size:14px"  href="mod_subcate.php?lang='.LANG.'&catid='.$catid.'"><i class="fa fa-caret-right"></i>子分类列表</a>';
 
 $cntlink = ' &nbsp;&nbsp;<a href="../mod_node/mod_node.php?lang='.LANG.'&catpid='.$catid.'&page=0"><i class="fa fa-reorder"></i>内容管理</a>';

 if($catid<>'')  echo $titlelink.' - '.$catname.$catemainlink.$cntlink;
 else echo $titlelink;


?>  </h1>


</section>
 
 <section class="content">
 
<?php

 require_once HERE_ROOT.'mod_category/tpl_category.php';

?> 
       

       

 </section>


<?php 

require_once HERE_ROOT.'mod_common/tpl_footer.php';

?>
