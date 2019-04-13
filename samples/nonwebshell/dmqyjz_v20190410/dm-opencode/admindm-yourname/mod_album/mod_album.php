<?php
/*	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
$mod_previ = 'normal';//default is admin,and set in common.inc
$mod_previ_except = 'y';
$smimgwater = 'dy';
require_once '../config_a/common.inc2010.php';
require_once HERE_ROOT.'config_a/func.previ.php';//when normal,require is here.
//

 if($act=='list') ifhaspidname(TABLE_ALBUM,$pid);


ifhave_lang(LANG);//TEST if have lang,if no ,then jump
if($act <> "pos") zb_insert($_POST);


$pid_pid = get_field(TABLE_ALBUM,'pid',$pid,'pidname');
$linkback='mod_mainalbum.php?lang='.LANG.'&pid='.$pid_pid;


//----
$titleedit = '';
if($file=='edit'){

  $sqlsub = "SELECT * from " . TABLE_ALBUM . "  where id='$tid' $andlangbh order by id limit 1";
  //echo $sqledit;exit;
  $rowsub = getrow($sqlsub);

if($rowsub=='no'){  echo 'album id not exist.';exit; }
else {
  $pid = $rowsub['pid'];
  
  $titleedit =  '<div style="padding:8px 0"><span style="font-size:18px">'.get_field(TABLE_ALBUM,'title',$pid,'pidname').'</span>'.adm_previewlink($pid).'<span class="cgray">'.admblockid($pid).'</span></div>';
 
}
//sidebar need pid...
}


//
$jumpv='mod_album.php?lang='.LANG;
$jumpvpid='mod_album.php?lang='.LANG.'&pid='.$pid;
$jumpv_file=$jumpvpid.'&file='.$file;

 if($act=="pos"){
    foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_ALBUM." set  pos='$v' where id='$k'  $andlangbh  limit 1";
         iquery($ss);
        }
      jump($jumpvpid);
}

if($act == "sta_sub")
{
     $ss = "update ".TABLE_ALBUM." set sta_visible='$v' where id=$tid $andlangbh limit 1";
	// echo $ss;exit;
    iquery($ss);
    jump($jumpvpid);
}



if($act=="delimg"){
p2030_delimg($v,'y','y');//p2030_delimg($addr,$delbig,$delsmall)
	$ss = "delete from ".TABLE_ALBUM."  where id=$tid $andlangbh limit 1";
	//echo $ss;exit;
	iquery($ss);
jump($jumpvpid);
}


//-----------

//$albumtitle =  get_field(TABLE_ALBUM,'title',$ppid,'pidname').$linkbackedit;

 $title='图片管理'; 
 
 $title2=' <a  style="font-size:18px"  href="'.$jumpvpid.'">'.$title.'</a>';


  require_once HERE_ROOT.'mod_common/tpl_header.php';
 
?>

<section class="content-header">
<h1>  <?php
          if($file=='list') {

            echo '<span style="font-size:18px">'.$title.'</span> <a href="'.$linkback.'">返回</a> ';
            echo  adm_previewlink($pid);

            echo '<br />';
            echo '<span style="font-size:18px">'.get_field(TABLE_ALBUM,'title',$pid,'pidname').'</span>';
            $linkvvv = '../mod_album/mod_mainalbum.php?lang='.LANG.'&pidname='.$pid.'&act=edit';
            echo ' <a href="'.$linkvvv.'">编辑</a>';

            echo '<span class="cgray">'.admblockid($pid).'</span>';
         }
         else if($file=='edit') echo  $title2.$titleedit;
          else echo $title2;
     ?> </h1>

</section>

 <section class="content">
 
 
 <?php
  if($file=='list'){
    ?>
 <div class="contenttop">
  <a href="<?php echo $jumpvpid; ?>&file=add"><i class="fa fa-plus-circle"></i> 添加图片</a>
  </div>
<?php
  }
?>


<?php
  require_once HERE_ROOT.'mod_album/tpl_album_'.$file.'.php';
?>
<div class="c"></div>

</section>



<?php
 
require_once HERE_ROOT.'mod_common/tpl_footer.php';

?>
