<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

?>

 
<?php 
 
 
   $sql_22 = "SELECT * from ".TABLE_PAGE." where  pid='0' $andlangbh  order by pos desc,id";
   //ECHO $sql;
   $rowlist_22 = getall($sql_22);
    if($rowlist_22 == 'no')  echo '<p style="padding:55px;background:#eee">没有菜单，请添加。</p>';
    else {
  ?>
 
 <strong>单页面管理：</strong><br />
  <?php
   echo '<ul class="sidebarnew">';
      foreach($rowlist_22 as $v_22){
            $tidhere = $v_22['id'];
             $pidname_22 = $v_22['pidname'];
            $name_22 = decode($v_22['name']);  

            $sta_visi_v = $v_22['sta_visible']; 
    
            $sta_visi_v2 = $sta_visi_v=='y'?'':'&nbsp;&nbsp;&nbsp;<span class="cgray">[隐藏]</span>';
       
            $styleV = '';
            if($tidhere==$tid) {
                 $styleV=' class="active" ';
            }

   $linkedit = 'mod_page_edit.php?lang='.LANG.'&file='.$file.'&act=edit&tid='.$tidhere;

//echo $linkedit;

 $edittext_22='<a href="'.$linkedit.'">'.$name_22.'</a>'; 
   
 echo '<li '.$styleV.'><i class="fa fa-angle-right"></i> '.$edittext_22.$sta_visi_v2.'</li>';
}

echo '</ul>';
}

?>
 