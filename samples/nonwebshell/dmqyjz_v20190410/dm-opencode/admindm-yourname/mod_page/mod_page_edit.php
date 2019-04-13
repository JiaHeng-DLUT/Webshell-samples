<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
  
*/

require_once '../config_a/common.inc2010.php';
$menu_content = 'y';
ifhave_lang(LANG);//TEST if have lang,if no ,then jump
if($tid<>'' || $tid==0) {ifhasid(TABLE_PAGE,$tid);}

if($act <> "pos") zb_insert($_POST);
/********************************************/
$jumpvpage='mod_page.php?lang='.LANG;

$jumpv='mod_page_edit.php?lang='.LANG.'&tid='.$tid;
$jumpv_file=$jumpv.'&file='.$file; 
$jumpv_back = $jumpv_file.'&act=edit'; 
/************************/

//------------------------
 
 $ss = "select * from ".TABLE_PAGE." where id='$tid' $andlangbh limit 1"; 
  $row = getrow($ss);
  if($row=='no'){alert('出错,不存在的ID!');echo $backlist;exit;   } 
  $name=$row['name'];    $jsname = jsdelname($name);
  $pidname=$row['pidname'];   
  $pageurl=admlink($row);
  $regionid =$row['regionid'];
  //pre($row);

 $name=decode($name);//seo_decode
 $title = '单页面修改 - ' .$name;
 

//-------
 $sslay = "select * from ".TABLE_LAYOUT." where pid='$pidname' and pidstylebh='$curstyle'  $andlangbh limit 1"; 
 //echo $sslay;
 $rowlay = getrow($sslay); 
 
if($rowlay=='no') {$content = $contenttop = $contentbot = '';}
else {
	$layoutcan = $rowlay['layoutcan'];
  $bscntarr = explode('==#==',$layoutcan); 
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
  

  //---
  $text_1='修改成功后，请在单页面管理 刷新后可看到效果。';
 $vtext_intro='<br />(中英文参考代码:<input type="text" style="background:#ccc;padding:3px;border:1px solid #666" value="<span>关于我们</span><span class=en>About us</span>" size="58" />) ';

//----
if($act == "delpage")
{ 
// $ss = "select id from ".TABLE_CATE." where pidname='$pidname' $andlangbh limit 1"; 
 //if(getnum($ss)>0) {alert('出错，不能在这里删除分类菜单');jump($jumpvmenu);}
  
  //$ifdel1 = ifcandel(TABLE_PAGE,$pidname,'出错，有子菜单，请删除它的子菜单！',$jumpvmenu);// back is fail 

  $ifdel1 = ifcandel(TABLE_ALBUM,$pidname,'出错，有相册。请先删除。！',$jumpvpage);// back is fail 
  $ifdel2 = ifcandel(TABLE_IMGFJ,$pidname,'出错，编辑器附件里有图片。请先删除。！',$jumpvpage);// back is fail 
  $ifdel3 =  ifcandel_field(TABLE_MUSIC,'pid',$pidname,'equal','出错， 请先删除音乐 ！',$jumpvpage);
  $ifdel4 =  ifcandel_field(TABLE_IMGTEXT,'pid',$pidname,'equal','出错， 请先删除图片文本生成器 ！',$jumpvpage);

if($ifdel1 && $ifdel2 && $ifdel3 && $ifdel4)  {
  ifsuredel(TABLE_PAGE,$pidname,'noback');
  ifsuredel_fieldmore(TABLE_VIDEO,'pid',$pidname,'equal','noback');
	ifsuredel_field(TABLE_ALIAS,'pid',$pidname,'eq','noback');
	ifsuredel_field(TABLE_LAYOUT,'pid',$pidname,'eq',$jumpvpage);
	//ifcandel_bypid(TABLE_ALIAS,$pidname,'noback');	
	//ifcandel_bypid(TABLE_LAYOUT,$pidname,$jumpvpage);
 }
 	  
}





 //----
 require_once HERE_ROOT.'mod_common/tpl_header.php';

 $title2 = '<a class="breadtitle" href="../mod_page/mod_page.php?lang='.LANG.'">单页面管理</a> - ' .$name;
?>


<section class="content-header">
  
      <h1><?php echo $title2?></h1>
</section>
  
<div class="layoutsidebar fl col-xs-12 col-sm-12  col-md-2">
 
     <?php  require_once HERE_ROOT.'mod_page/plugin_page_sidebar.php'; ?>

</div>

 <div class="fl col-xs-12 col-sm-12  col-md-10">
 


 <?php 
 
 if($regionid<>''){
  echo '<p class="f14bgred"> 本页面 由内容标识决定</p>'; 
  
 }else{
    if($content<>''){      
      echo '<p class="f14bgred">由于本页面 布局的默认内容 调用了'.check_blockid($content).'（请到布局里检查。），所以这里的内容不会在前台显示。</p>';
    }
 }
 
   ?>



 <section class="content">  
     <div class="contenttoptop">
     	 <?php   
            require_once HERE_ROOT.'mod_page/tpl_page_tab.php';
        ?>
     </div>

     <?php 

  require_once HERE_ROOT.'mod_page/tpl_page_'.$file.'.php';

?>

 </section>
 </div>
 <div class="c"></div>
<?php
require_once HERE_ROOT.'mod_common/tpl_footer.php';
?>



