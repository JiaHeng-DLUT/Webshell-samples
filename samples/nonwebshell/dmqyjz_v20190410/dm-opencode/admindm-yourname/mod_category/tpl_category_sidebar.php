<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

?>


<?php

 $sql = "SELECT * from ".TABLE_CATE." where   modtype='node' and pid='0'   $andlangbh  order by pos desc,id";
 $rowlist = getall($sql);
  if($rowlist=='no') echo $norr2;
  else{

  ?>
  <strong>主类：</strong><br />

  <?php

     echo '<ul class="sidebarnew">';
       foreach($rowlist as $v ){

        $catename = decode($v['name']);
        $pidnamehere = $v['pidname'];
        // $jsname = jsdelname($v['name']);

        $styleV = '';
        if($pidnamehere==$catid) {
             $styleV=' class="active" ';
        }

     //mod_category/mod_category.php?lang=cn&catid=cate20150805_1125344029&file=edit&act=edit
  $linkedit='   <a   href="'.$jumpv.'&catid='.$pidnamehere.'&file='.$file.'&act=edit">'.$catename.'</a>';

//echo $linkedit;

 echo '<li '.$styleV.'><i class="fa fa-angle-right"></i> '.$linkedit.'</li>';
    }

 echo '</ul>';
}

?>
