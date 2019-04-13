<?php
/*	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
$mod_previ = 'normal';//default is admin,and set in common.inc
require_once '../config_a/common.inc2010.php';
$menu_content = 'y';
//

ifhave_lang(LANG);//TEST if have lang,if no ,then jump
if($act <> "pos") zb_insert($_POST);
//-----------------------------
$jumpv='mod_node_edit.php?lang='.LANG.'&tid='.$tid;
$jumpv_file=$jumpv.'&file='.$file;

  
//-----------
 $sql="select * from ".TABLE_NODE." where id='$tid' $andlangbh order by id limit 1";
$row=getrow($sql);
if($row=='no'){
  echo '出错，没有此内容！';
  echo '<a href="../mod_common/mod_index.php?lang='.LANG.'">返回后台首页></a>';
  exit;
}
else{ 

$title=$row['title'];$titlestyle=$row['titlestyle'];
$pid=$row['pid'];   
$pidmulti=$row['pidmulti'];  
$catpid=$row['ppid']; 
$pidname=$row['pidname'];$alias_jump=$row['alias_jump'];
$kv=$row['kv'];$kvsm=$row['kvsm'];$kvsm2=$row['kvsm2'];

// if(strlen($pidarr)>30){
//      $pidarr2 = explode("-",$pidarr);
//       $pid = $pidarr2[0];
// }
// else  $pid = $pidarr;

 
//ifhaspidname(TABLE_CATE,$pid); //not use it.if cate wrong,then change node cate
 
 
$date=$row['dateedit'];
if($date=='') $date= date("Y-m-d");
//---
 $sqlcatmain="select * from ".TABLE_CATE." where pidname='$catpid' $andlangbh order by id limit 1";
$rowcatmain=getrow($sqlcatmain);
 
$mainarr_can=$rowcatmain['arr_can'];
//$mainarr_can = get_field(TABLE_CATE,'arr_can',$catpid,'pidname');
//get sta_field from cate arr_can
$bscntarr = explode('==#==',$mainarr_can); 
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }



//------
}
//---
require_once HERE_ROOT.'config_a/func.previ.php';//when normal,require is here.bec need catpid

/********************************************************/


$maincate = get_field(TABLE_CATE,'name',$catpid,'pidname');
$subcate = get_field(TABLE_CATE,'name',$pid,'pidname');


   
//-------------------------    

$title= '内容修改 - '.$title;
 
/****************************/
//
//$fo_bef='upp/';$fo_now=$imgfo_abm;--put to imgprotect.php
/**
*
*****************************************/


if($act == "sta_node")
{
     $ss = "update ".TABLE_NODE." set sta_visible='$v' where id='$tid' and ppid='$catpid' $andlangbh limit 1";
    iquery($ss);
    jump($jumpv_catid);
}

if($act == "pos")
{
   foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_NODE." set  pos='$v' where id='$k' and ppid='$catpid' $andlangbh limit 1";
         iquery($ss);
        }
    jump($jumpv_catid);
}

/**/
if($act == "delnode") 
{ 
  //no here
 
}



if($act == "delvideo")
{ 
  
   //update videoid in page table
   $ss = "update " . TABLE_NODE . " set videoid=''  where id='$tid'  $andlangbh limit 1"; 
    iquery($ss); 

    //del video
    //$pidname use value from above ,in selec from page...,so use pid=page pidname
    $sqlsub = "SELECT * from ".TABLE_VIDEO."  where pid='$pidname' and type='node' $andlangbh order by id limit 1";
     //echo $sqlsub;exit;
    $rowsub = getrow($sqlsub);
    $imgsqlname = $rowsub['kv'];
    $pidname = $rowsub['pidname'];
 
       
      if($imgsqlname<>'')  p2030_delimg($imgsqlname,'y','n');
        ifsuredel_field(TABLE_VIDEO,'pidname',$pidname,'eq',$jumpv_file);
     

 }



/*****
****
***
*********************/
 
require_once HERE_ROOT.'mod_common/tpl_header.php'; //tpl_header_img
 
?>

<section class="content-header">
     
      <ol class="breadcrumb">
        <li><?php echo $breadfaicon?>         
        内容修改 </li>
        <li class="active">
        <a href="../mod_node/mod_node.php?lang=<?php echo LANG;?>&catpid=<?php echo $catpid?>&page=0"><?php echo $maincate;?></a>
        </li>

        <?php 
          if($pid<>$catpid) {
        ?>
         <li class="active">
        <a href="../mod_node/mod_node.php?lang=<?php echo LANG;?>&catpid=<?php echo $catpid?>&catid=<?php echo $pid?>&page=0"><?php echo $subcate;?></a>
        </li>
       <?php 
        }
       ?>

      </ol>
      <h1><?php echo $title?></h1>
</section>
  
 
 <section class="content">       
        <?php   
        require_once HERE_ROOT.'mod_node/tpl_node_tab.php';      
       
  if($file=='editprocan'){
        
        $framesrc='mod_pop_nodetext.php?pid='.$pidname.'&lang='.LANG.'&type=node&type2=nodeprocan&act=edit';
         
        iframenormal($framesrc,1000);
   }
elseif($file=='editotherinfo'){
      
      $framesrc='mod_pop_nodetext.php?pid='.$pidname.'&lang='.LANG.'&type=node&type2=nodeotherinfo&act=edit'; 
      iframenormal($framesrc,1000);
   }
 
 elseif($file=='editfield--'){
     $framesrc='../mod_field/mod_fieldvalue.php?pid='.$pidname.'&catpid='.$catpid.'&lang='.LANG.'&type=cate';
     iframepage($framesrc);
  }

   elseif($file=='edittag'){
     $framesrc='../mod_tag/mod_tagnode.php?file=addnode&pid='.$pidname.'&catpid='.$catpid.'&lang='.LANG.'&type=cate';
     iframepage($framesrc);
  }

  elseif($file=='editalbum'){
     //$framesrc='mod_pop_album_other.php?type=album&pid='.$pidname.'&lang='.LANG;
     //iframepage($framesrc);
       $num = num_subnode(TABLE_ALBUM,'pid',$pidname);
        $link = '../mod_album/mod_album.php?lang='.LANG.'&pid='.$pidname.'&type=node';
      echo  "<p style='padding:50px;text-align:left'><a class='needpopup'  href='$link'>管理图片</a> ($num)<p>";
   
  
  }
  elseif($file=='editvideo'){
    //$framesrc='mod_pop_album_other.php?type=album&pid='.$pidname.'&lang='.LANG;
    //iframepage($framesrc);
     // $num = num_subnode(TABLE_VIDEO,'pid',$pidname);
    //   $link = '../mod_album/mod_album.php?lang='.LANG.'&pid='.$pidname.'&type=node';
    // echo  "<p style='padding:50px;text-align:left'><a class='needpopup'  href='$link'>管理图片</a> ($num)<p>";
  
 
 }
  else{
     require_once HERE_ROOT.'mod_node/tpl_node_'.$file.'.php';
   }
   

        ?>
 </section>
<?php


require_once HERE_ROOT.'mod_common/tpl_footer.php';
 
?>
