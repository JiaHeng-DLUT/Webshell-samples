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
 
 $sql_22 = "SELECT * from ".TABLE_NODE." where pid='$pid'  $andlangbh order by pos desc,id"; 
  
 $rowlist_22 = getall($sql_22);
    if($rowlist_22 == 'no')  echo '无内容';
    else {
  ?>

<style>
.menu_list_edit a{color:blue;}
</style>
<ul>


  <?php
      foreach($rowlist_22 as $v_22){
            $title22 = $v_22['title'];
             $tidhere22 = $v_22['id'];  
              $sta_visi_v = $v_22['sta_visible'];

 
 if($tid==$tidhere22) $bgv = 'style="background:red;color:#fff;display:inline-block;padding:0 10px"';
     else $bgv = 'style=" display:inline-block;padding:0 10px"';

	 $stavisible = $sta_visi_v<>'y'?'[隐藏]':'';
  //mod_blockdh.php?lang=cn&catpid=cate20160707_0437114782&catid=csub20160707_0904417537&page=0&file=edit&tid=148&act=edit
      $linkedit = $jumpv.'&file=edit&tid='.$tidhere22.'&act=edit';
 $edittext_22='<a '.$bgv.' href="'.$linkedit.'">'.$title22.'</a>';



    ?>
 
  <li><i class="fa fa-angle-right"></i>
<?php echo $edittext_22.$stavisible;?>
</li>

 <?php
     
 
    } ?>
</ul>


 <?php
     
 
    } ?>