<?php
/*	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';

ifhave_lang(LANG);//TEST if have lang,if no ,then jump

 
if($pidname<>'') {ifhaspidname(TABLE_BLOCKGROUP,$pidname);}
if(is_numeric($tid)) {   ifhasid(TABLE_BLOCKGROUP,$tid);}
if($file=='') $file='list';
$filearr =  array("list", "addedit");  
if(!in_array($file,$filearr))   {echo 'file is error.';exit;}


 if($act <> "pos") zb_insert($_POST);
 
 
 //if($pidname<>'') {ifhaspidname(TABLE_BLOCK,$pidname);}
 
//ifhaspidname(TABLE_NODE,$pid);
//ifhaspidname(TABLE_CATE,$catpid);
// if($pidname==''){
//         if($stylebh=='') $stylebh = $curstylebh;
// }
// else $stylebh = get_field(TABLE_BLOCKGROUP,'stylebh',$pidname,'pidname');

 

$jumpv='mod_maingroup.php?lang='.LANG;
 
$jumpvf=$jumpv.'&file='.$file;
$jumpvp=$jumpv.'&pidname='.$pidname;
$jumpvpf=$jumpvf.'&pidname='.$pidname;
 

 
 $title = '组合区块管理'; 
 $title2 = '';
 if($act=='add') $title2 = ' - 添加'; 
else if($act=='edit') $title2 = ' - 修改'; 
 

 
//---
if($act == "sta")
{
     $ss = "update ".TABLE_BLOCKGROUP." set sta_visible='$v' where id=$tid $andlangbh limit 1";
	// echo $ss;exit;
    iquery($ss);
    jump($jumpvpf); 
}

//-------------
if($act == "posmain")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_BLOCKGROUP." set  pos='$v' where id='$k' and pid='0'  $andlangbh  limit 1";
         iquery($ss);
        }
      jump($jumpvpf);
}

 
//-----------------------
if($act == "delregion")
{ 
 $ifdel1 = ifcandel(TABLE_BLOCKGROUP,$pidname,'对不起，有记录，请先删除。',$jumpv);// back is fail 
 if($ifdel1) ifsuredel(TABLE_BLOCKGROUP,$pidname,$jumpv);
	  
}

if($act == "delsub")
{ 

ifsuredel(TABLE_BLOCKGROUP,$pidname2,$jumpvp.'&file=list');

}



//-----------
 
require_once HERE_ROOT.'mod_common/tpl_header.php'; 
 
 ?>


<section class="content-header">
 
      <h1>
      <?php 
      $titlelink=$title;
       if($file<>'list')  $titlelink='<a style="font-size:20px" href="'.$jumpv.'">'.$title.'</a>'; 
       
      echo  $titlelink.$title2;
      ?></h1>
</section>
  
 <div style="padding-left:10px">
 <?php 
   //echo $stylename;
?>
</div>

 <section class="content">  

<?php
  if($file=='list'){
?>
  <div class="contenttop">
  <a href="<?php echo $jumpv?>&file=addedit&act=add"><i class="fa fa-plus-circle"></i> 添加</a>
</div>
<?php
  }
?>
 
        <?php   
           
         require_once HERE_ROOT.'mod_blockgroup/tpl_maingroup_'.$file.'.php';
 
        ?>
 </section>
<?php
require_once HERE_ROOT.'mod_common/tpl_footer.php';
?>

