<?php
/*  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);
 
 if($pidname<>'') {ifhaspidname(TABLE_NODE,$pidname);}

if($pid<>'') {ifhaspidname(TABLE_BLOCK,$pid);}

if($file=='list') ifhaspidname(TABLE_BLOCK,$pid);

if($tid<>'') {ifhasid(TABLE_NODE,$tid);}

 //if($pid<>'') {ifhasid(TABLE_BLOCK,$pid);} 
 
/*
if (!in_array($type,$arr_group_type))
  {
  echo "error,type:".$type.' not exist...... in array:arr_group_type' ;
  exit;
  }
*/
if($file=='edit'){
	
	  $sqlsub = "SELECT * from " . TABLE_NODE . "  where id='$tid' $andlangbh order by id limit 1";
    //echo $sqledit;exit;
    $rowsub = getrow($sqlsub);
	
	if($rowsub=='no'){  echo 'effect node id not exist.';exit; }
	else $pid = $rowsub['pid'];
}


 
ifhave_lang(LANG);//TEST if have lang,if no ,then jump
 
$jumpv='mod_effectnode.php?lang='.LANG;
$jumpvp=$jumpv.'&pidname='.$pidname;
$jumpvpid=$jumpv.'&pid='.$pid; 
 
$jumpv_file = $jumpvpid.'&file='.$file; 


 $title = '效果区块内容管理';


/* 
if($type=='bkcustom')  $title2 = '自定义区块';
else if($type=='bknode')  $title2 = '内容区块';
else if($type=='bkblockdh')  $title2 = '效果区块';
else { echo 'type is error.';exit;}
 */ 
 
if($file<>'list')  $title2 = '<a class="breadtitle" href="'.$jumpvpid.'">返回列表</a>';
 else {
	
	 $titlepid = '<a class="breadtitle" href="mod_block.php?lang='.LANG.'&pidname='.$pid.'&act=edit">'.get_field(TABLE_BLOCK,'name',$pid,'pidname').'</a>';
	 $title2=$title.'- '.$titlepid;
	 
 } 
 
//----------
if($act == "pos")
{
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_NODE." set  pos='$v' where id='$k'  $andlangbh  limit 1";
         iquery($ss);
        }
      jump($jumpvpid);
}
 
if($act == "sta_node")
{ 
     $ss = "update ".TABLE_NODE." set sta_visible='$v' where id=$tid $andlangbh limit 1";   
     iquery($ss);
    jump($jumpvpid); 
}

 

if($act == "delnode")
{

$nodearr = get_fieldarr(TABLE_NODE,$pidname,'pidname');
$kv = $nodearr['kv'];
$kvsm = $nodearr['kvsm'];
$kvsm2 = $nodearr['kvsm2'];
p2030_delimg($kv,'y','n');//p2030_delimg($addr,$delbig,$delsmall);
p2030_delimg($kvsm,'y','n');
p2030_delimg($kvsm2,'y','n');

//pre($nodearr);
 ifsuredel_field(TABLE_NODE,'pidname',$pidname,'equal',$jumpvpid);

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
  if($file=='list'){
?>
  <div class="cred mb10">(每个记录可以上传三张图片，如果模板只显示一张图片，则会用kv大图。)</div>
  <div class="contenttop">
  <a href="<?php echo $jumpvpid?>&file=add&act=add"><i class="fa fa-plus-circle"></i> 添加</a>
</div>
<?php
  }
?>


<?php 
  require_once HERE_ROOT.'mod_block/tpl_effectnode_'.$file.'.php';
   ?>
  
 </section>
<?php
require_once HERE_ROOT.'mod_common/tpl_footer.php';
?>

 