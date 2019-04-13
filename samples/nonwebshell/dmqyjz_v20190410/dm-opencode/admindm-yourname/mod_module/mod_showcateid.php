<?php
/*  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);


ifhave_lang(LANG);//TEST if have lang,if no ,then jump

$title='查看分类标识';




//-----------

require_once HERE_ROOT.'mod_common/tpl_header_iframe.php';

?>

<?php
 $sqlmain = "SELECT * from ".TABLE_CATE." where  pid='0' and modtype='node' $andlangbh order by pos desc,id";
 $rowlistmain = getall($sqlmain);
 if($rowlistmain=='no') {
  echo '<p>&nbsp;&nbsp;还没有分类，请添加...</p>';
  }
  else{

  echo '<ul class="seolist ">';
   foreach($rowlistmain as $vmain){
        $pidnamemain=$vmain['pidname'];
        $namemain='<strong>'.decode($vmain['name']).'</strong>';


        echo '<li>';
        echo '<h3>'.$namemain.' - <span class="cgray">'.$pidnamemain.' </span></h3>';

 $sqlsub = "SELECT * from ".TABLE_CATE." where  pid='$pidnamemain' $andlangbh order by pos desc,id";
 $rowlistsub = getall($sqlsub);
 if($rowlistsub=='no') {
  echo '<p>&nbsp;&nbsp;还没有子分类，请添加...</p>';
  }
  else{
  ?>

 <?php
 echo '<ul class="seolist seolistcate">';
   foreach($rowlistsub as $vsub){

       $pidname=$vsub['pidname'];
       $name='<strong>'.decode($vsub['name']).'</strong>';


       echo '<li>';
        echo '<h3> '.$name .' - <span class="cgray">'.$pidname.' </span></h3>';


//----if sub sub cat------------------------
         $sqlsub_sub = "SELECT  *  from ".TABLE_CATE." where  pid='$pidname' $andlangbh order by pos desc,id";
         $row_sub = getall($sqlsub_sub);

      //----if sub sub cat------------------------
         if($row_sub<>'no'){
           echo '<ul>';
              foreach($row_sub as $v2_sub){
           $nameSub=decode($v2_sub['name']);
           $subpidname=$v2_sub['pidname'];

          echo '<li>';
          echo '<h3> '.$nameSub.' - <span class="cgray">'.$subpidname.' </span></h3>';
          echo '</li>';

        }
         echo '</ul>';

  }
  echo '</li>';
  }
  echo '</ul>';
}
//--------------
echo '</li>';
}
echo '</ul>';
}

?>



 <?php
require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php';

?>
