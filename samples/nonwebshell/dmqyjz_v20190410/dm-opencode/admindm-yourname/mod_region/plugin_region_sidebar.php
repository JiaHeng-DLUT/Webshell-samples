
<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

?>


<?php 
  
   $sql_22 = "SELECT * from ".TABLE_REGION." where  pid='$pid' $andlangbh  order by pos desc,id";
   // echo $sql_22;
   $rowlist_22 = getall($sql_22);
    if($rowlist_22 == 'no')  echo '<p style="padding:55px;background:#eee">没有内容，请添加。</p>';
    else {
  ?>
<ul class="sidebarnew">
 
  <?php
      foreach($rowlist_22 as $v_22){
            $tidhere = $v_22['id'];
             $pidname_22 = $v_22['pidname'];
            $name_22 = decode($v_22['name']);  
            $blockid22 = $v_22['blockid'];

            $sta_visi_v = $v_22['sta_visible']; 
    
           // menu_changesta($sta_visi_v,$jumpv,$tid);//trbg and tr_hide is in here
      // menu_changesta($sta_visi_v,$jumpv,$tid,'sta_menu');


      $numsubnode = num_subnode(TABLE_COLUMN,'pid',$pidname_22);


      $sta_visi_v2 = $sta_visi_v=='y'?'':' [隐藏]'; 

   if($tid==$tidhere) $classv = 'class="active"';
   else $classv = ' ';

  // mod_region.php?lang=qing&pid=region20160921_0600333032&file=editcan&tid=752
  $linkedit = 'mod_region.php?lang='.LANG.'&pid='.$pid.'&file=editcan&tid='.$tidhere;
$edittext_22='<a  href="'.$linkedit.'">'.$name_22.'</a>';

 
if($blockid22=='')  $columnv =  ' | <strong><a   href="../mod_column/mod_column.php?lang='.LANG.'&pid='.$pidname_22.'&type=region">列管理</a></strong><span class="cblue">('.$numsubnode.')</span>'; 
else $columnv = ''; 


    ?>

<li <?php echo $classv;?>><i class="fa fa-angle-right"></i> 
<?php echo $edittext_22.$columnv.$sta_visi_v2;?>
</li>
 

<?php 
}
 
?>
 
 </ul>

 <?php 
}
 
?>
 

