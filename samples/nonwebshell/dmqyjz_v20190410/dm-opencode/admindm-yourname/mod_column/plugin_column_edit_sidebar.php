<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

?>


<?php

 //mod_blockdh.php?lang=cn&catpid=cate20160707_0437114782&page=0&catid=csub20160707_0904417537
 $sql_22 = "SELECT * from ".TABLE_COLUMN." where pid='$pid' and type='$type'   $andlangbh order by pos desc,id";


 $rowlist_22 = getall($sql_22);
    if($rowlist_22 == 'no')  echo '无内容';
    else {
  ?>
 
<ul class="sidebarnew">

  <?php
      foreach($rowlist_22 as $v){

$pidname2=$v['pidname'];
$name=$v['name'];
$tid=$v['id'];
$width=$v['width'];
$floattype=$v['floattype'];
$onlyposi=$v['onlyposi'];



$jumpv='';

            // menu_changesta($sta_visi_v,$jumpv,$tidhere22,'sta_menu');

 if($pidname==$pidname2) $classv = 'class="active"';
     else $classv = ' ';

  //mod_column.php?lang=cn&pid=group20160509_1200413359&type=group&file=editcnt&pidname=colu20170914_1755204518
      $linkedit = 'mod_column.php?lang='.LANG.'&pid='.$pid.'&type='.$type.'&file='.$file.'&pidname='.$pidname2;
 $edittext_22='<a  href="'.$linkedit.'">列名：'.$name.'</a>';

if($floattype=='clear') $edittext_22='清浮动';
if($onlyposi=='y') $edittext_22='无内容，只占位置';

    ?>

<li <?php echo $classv;?>><i class="fa fa-angle-right"></i> 
<?php echo $edittext_22;?>
</li>

 <?php


    } ?>
</ul>


 <?php


    } ?>
