<?php
/*	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';

ifhave_lang(LANG);//TEST if have lang,if no ,then jump

 
 if($pidname<>'') {ifhaspidname(TABLE_COLUMN,$pidname);}

 
if($pid=='') { echo 'must have pid'; exit; }



//if($pid<>'') {ifhasrecord(TABLE_COLUMN,$pid,'pidname','no pid');}

if(is_numeric($tid)) {   ifhasid(TABLE_COLUMN,$tid);}




 if($act <> "pos") zb_insert($_POST);

 
$filearr =  array("list", "addedit", "editcnt");  
if(!in_array($file,$filearr))   {echo 'file is error.';exit;}

$typearr =  array("region", "group");  
if(!in_array($type,$typearr))   {echo 'type is error.';exit;}


if($type=='region') {ifhaspidname(TABLE_REGION,$pid);}
if($type=='group') {ifhaspidname(TABLE_BLOCKGROUP,$pid);}

  $title = '列管理';
  $title2='';

if($act=='add') $title2 = ' - 添加列'; 
else if($act=='edit') $title2 = ' - 修改列'; 
 
 

 

$jumpv='../mod_column/mod_column.php?lang='.LANG.'&pid='.$pid.'&type='.$type;
 
$jumpvf=$jumpv.'&file='.$file;
$jumpvp=$jumpv.'&pidname='.$pidname;
$jumpvpf=$jumpvf.'&pidname='.$pidname;

 
 
//---
if($act == "sta")
{
     $ss = "update ".TABLE_COLUMN." set sta_visible='$v' where id=$tid $andlangbh limit 1";
	// echo $ss;exit;
    iquery($ss);
    jump($jumpv); 
}

//-------------
if($act == "pos")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_COLUMN." set  pos='$v' where id='$k' and pid='$pid' and type='$type' $andlangbh  limit 1";
        // echo $ss;exit;
         iquery($ss);
        }
      jump($jumpv);
}

 


//-----------------------
if($act == "del")
{ 

  $sqlsub = "SELECT id,pidname,blockimg from ".TABLE_BLOCK."  where pidcolumn='$pidname' $andlangbh order by id limit 1";
   //echo $sqledit;exit;
$rowsub = getrow($sqlsub);
if($rowsub<>'no'){
  
  $pidnameblock = $rowsub['pidname'];
  $blockimg = $rowsub['blockimg'];
   if($blockimg<>'')  p2030_delimg($blockimg,'y','n');
   ifsuredel_field(TABLE_BLOCK,'pidname',$pidnameblock,'eq','noback');
 
}
    
       ifsuredel(TABLE_COLUMN,$pidname,$jumpv);
	  
}






//-----------
 
  require_once HERE_ROOT.'mod_common/tpl_header.php'; 

 ?>

<section class="content-header">
     
     


           <?php 
if($type=='region'){
           $region= get_fieldarr(TABLE_REGION,$pid,'pidname');
           $subreg = $region['name'];
           $mainregid =  $region['pid'];
            $mainregname = get_field(TABLE_REGION,'name',$mainregid,'pidname');
          
   $titlePre = '<a style="font-size:18px;color:blue" href="../mod_region/mod_region.php?lang='.LANG.'&pid='.$mainregid.'">区域：'.$mainregname.'</a>'; 
   
  
           
}
elseif($type=='group'){

    $region= get_fieldarr(TABLE_BLOCKGROUP,$pid,'pidname');
           $subreg = $region['name'];
          // $mainregid =  $region['pid'];
            //$mainregname = get_field(TABLE_BLOCKGROUP,'name',$mainregid,'pidname');

  
   $titlePre = '<a style="font-size:18px;color:blue" href="../mod_blockgroup/mod_maingroup.php?lang='.LANG.'">组合区块</a>';
 

}
    ?> 
   
   <h1>
 <?php
 $titlelink=$title;
       if($file<>'list')  $titlelink='<a style="font-size:20px" href="'.$jumpv.'">'.$title.'</a>'; 
       
      echo  $titlePre.' - '.$titlelink.$title2.' - '.$subreg;
  
 ?> 
  </h1>

</section>
  
 
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

         
         // if($act<>'add') {
         //  if(ifhasrecord(TABLE_COLUMN,$pid,'pid',''))  require_once HERE_ROOT.'mod_column/tpl_column_'.$file.'.php';
         //   else echo '暂无内容，请添加';
        //  }
         // else 
            require_once HERE_ROOT.'mod_column/tpl_column_'.$file.'.php';
 
        ?>
 </section>
<?php
require_once HERE_ROOT.'mod_common/tpl_footer.php';
?>

