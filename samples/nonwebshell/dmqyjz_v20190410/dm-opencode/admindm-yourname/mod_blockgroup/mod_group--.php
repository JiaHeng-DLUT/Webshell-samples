<?php
/*  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';

ifhave_lang(LANG);//TEST if have lang,if no ,then jump

 
if($pidname<>'') {ifhaspidname(TABLE_BLOCKGROUP,$pidname);}
 

if($pid<>'') {ifhasrecord(TABLE_BLOCKGROUP,$pid,'pidname','no pid');}
else{echo 'need pid';exit;}

if(is_numeric($tid)) {   ifhasid(TABLE_BLOCKGROUP,$tid);}




 if($act <> "pos") zb_insert($_POST);



if($file=='') $file='list';
$filearr =  array("list", "addedit");  
if(!in_array($file,$filearr))   {echo 'file is error.';exit;}

$title = '组合区块管理'; 
 
 

$jumpv='mod_group.php?lang='.LANG.'&pid='.$pid;
 
$jumpvf=$jumpv.'&file='.$file;
$jumpvp=$jumpv.'&pidname='.$pidname;
$jumpvpf=$jumpvf.'&pidname='.$pidname;


//------------------
 
    $nameparent = get_field(TABLE_BLOCKGROUP,'name',$pid,'pidname');
 
    $nameparentLink ='<a href="'.$jumpv.'">'.$nameparent.'</a>';

if($tid<>'') $tidname = get_field(TABLE_BLOCKGROUP,'name',$tid,'id');

 if($file=='addedit')  {
      if($act=='add')  $title ='添加';
      if($act=='edit')   $title ='修改 - '.$tidname;

 } 
 
 else  $title =$nameparent;


   // if($file=='list') $title=$title.' - <a style="float:none;color:#0066CA" href="mod_mainregion.php?lang='.LANG.'">< 返回页面区域</a>';
 
 
//---
if($act == "sta")
{
     $ss = "update ".TABLE_BLOCKGROUP." set sta_visible='$v' where id=$tid $andlangbh limit 1";
  // echo $ss;exit;
    iquery($ss);
    jump($jumpv); 
}

//-------------
if($act == "pos")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_BLOCKGROUP." set  pos='$v' where id='$k' and pid='$pid'  $andlangbh  limit 1";
         iquery($ss);
        }
      jump($jumpv);
}

 
 

if($act == "delsub")
{ 
  ifsuredel(TABLE_BLOCKGROUP,$pidname2,$jumpv);
  
}



//-----------
 
  require_once HERE_ROOT.'mod_common/tpl_header.php'; 
 
?>
<section class="content-header">
     
      <ol class="breadcrumb">
        <li><?php echo $breadfaicon?>         
       <a href="../mod_blockgroup/mod_maingroup.php?lang=<?php echo LANG?>">组合区块管理</a>
       <li><?php echo $nameparentLink ;?></li>

      </ol>
      <h1><?php echo $title?></h1>
</section>
  
 
 <section class="content">  

<?php
  if($file=='list'){
?>
  <div class="contenttop">
   <span  class="fr"><?php echo adm_previewlink($pid);?></span>
  
 
  <a href="<?php echo $jumpv?>&file=addedit&act=add"><i class="fa fa-plus-circle"></i> 添加</a>
</div>
<?php
  }
?>
 
        <?php   
           
            require_once HERE_ROOT.'mod_blockgroup/tpl_group_'.$file.'.php';
  
 
        ?>
 </section>
<?php
require_once HERE_ROOT.'mod_common/tpl_footer.php';
?>
