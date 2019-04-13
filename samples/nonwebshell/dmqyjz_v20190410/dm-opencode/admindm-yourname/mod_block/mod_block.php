<?php
/*  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);
 
if($pidname<>'') {ifhaspidname(TABLE_BLOCK,$pidname);}

if($tid<>'') {ifhasid(TABLE_BLOCK,$tid);}

if($act=='add') {

    if($ppid=='') {
      echo 'must have ppid.';exit;
    }
    
   $typearr =  array("bkcustom", "bknode", "bkblockdh");   
     if(!in_array($type,$typearr))   {echo 'type is error.';exit;}
   
}

if($act=='edit' || $act=='update'){
  $sqlsub = "SELECT * from ".TABLE_BLOCK."  where pidname='$pidname' $andlangbh order by id limit 1";
   //echo $sqlsub;exit;
$rowsub = getrow($sqlsub);
if($rowsub=='no')  { echo 'no block id by pidname'; exit; }
else{
   $ppid = $rowsub['pidstylebh'];
   $type = $rowsub['pid'];

}

}



$ppid4 = substr($ppid,0,4);

/*
if (!in_array($type,$arr_group_type))
  {
  echo "error,type:".$type.' not exist...... in array:arr_group_type' ;
  exit;
  }
*/

 
//ifhaspidname(TABLE_NODE,$pid);
//ifhaspidname(TABLE_CATE,$catpid);
ifhave_lang(LANG);//TEST if have lang,if no ,then jump
 
$jumpv='mod_block.php?lang='.LANG;
$jumpvp=$jumpv.'&pidname='.$pidname;
$jumpvppid=$jumpv.'&ppid='.$ppid; 
$jumpvpt=$jumpvppid.'&type='.$type;  
 

 $title = '区块管理';

$title2= $title ;

/* 
if($type=='bkcustom')  $title2 = '自定义区块';
else if($type=='bknode')  $title2 = '内容区块';
else if($type=='bkblockdh')  $title2 = '效果区块';
else { echo 'type is error.';exit;}
 */ 

if($act=='add' || $act=='edit')  $title2 = '<a class="breadtitle" href="'.$jumpvppid.'">返回区块列表</a>';
 
if($act=='edit') $title2 = $title2.' - '.$ppid;
//----------
if($act == "pos")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_BLOCK." set  pos='$v' where id='$k'  $andlangbh  limit 1";
         iquery($ss);
        }
      jump($jumpvppid);
}
 
if($act == "sta_block")
{ 
     $ss = "update ".TABLE_BLOCK." set sta_visible='$v' where id=$tid $andlangbh limit 1";   
     iquery($ss);
    jump($jumpvppid); 
}

 
if($act == "sta_block")
{ 
     $ss = "update ".TABLE_BLOCK." set sta_visible='$v' where id=$tid $andlangbh limit 1";   
     iquery($ss);
    jump($jumpvppid); 
}

 
if($act == "movecommon")
{ 
     $ss = "update ".TABLE_BLOCK." set pidstylebh='common' where pidname='$pidname' $andlangbh limit 1";   
     iquery($ss);
    jump($jumpv.'&ppid=common'); 
}
if($act == "move")
{ 
     $ss = "update ".TABLE_BLOCK." set pidstylebh='$curstyle' where  pidname='$pidname' $andlangbh limit 1";   
     // echo $ss;exit;
     iquery($ss); 
     jump($jumpv.'&ppid='.$curstyle); 
}


if($act == "del_block")
{ 
  


  $sqlsub = "SELECT * from ".TABLE_BLOCK."  where id='$tid' $andlangbh order by id limit 1";
  // echo $sqlsub;exit;
$rowsub = getrow($sqlsub); 
$blockimg = $rowsub['blockimg'];
$pidname = $rowsub['pidname'];

$ifdel1 =  ifcandel_field(TABLE_NODE,'pid',$pidname,'equal','出错，有效果区块内容，请先删除！',$jumpvppid);

if($ifdel1 ){
    if($blockimg<>'')  p2030_delimg($blockimg,'y','y');
    ifsuredel_field(TABLE_BLOCK,'pidname',$pidname,'eq',$jumpvppid);
}
     
     
 
  
}

//-----------

require_once HERE_ROOT.'mod_common/tpl_header.php';
 
?>

 
<section class="content-header">
<?php
 //echo $stylename; //in common.inc
?>
      <h1><?php echo $title2;?> 
     
     </h1>
</section>
  <div style="padding-left:10px">
 <?php 
//echo $stylename;
?>
</div>
 <section class="content">  
 

<?php 
 
 
if($type=='bkcustom') $file = 'bkcustom';
else $file = 'bknode';

if($ppid=='coolmb') {
  require_once HERE_ROOT.'mod_block/tpl_block_coolmb.php';
}
else {
  if($act=='list')  require_once HERE_ROOT.'mod_block/tpl_block_list.php'; 
    else if($act=='edit')   {
    echo '<div class="layoutsidebar fl col-xs-12 col-sm-12  col-md-2">';
    require_once HERE_ROOT.'mod_block/plugin_block_sidebar.php';
    echo  '</div><!--end left-->';
    echo  '<div class="fl col-xs-12 col-sm-12  col-md-10">';
    require_once HERE_ROOT.'mod_block/tpl_block_m_'.$file.'.php';
    echo  '</div><!--end right-->';
    echo  '<div class="c"></div>';
  }
  else require_once HERE_ROOT.'mod_block/tpl_block_m_'.$file.'.php'; // when add.
}
   ?>
  
 </section>
<?php
require_once HERE_ROOT.'mod_common/tpl_footer.php';
?>

 