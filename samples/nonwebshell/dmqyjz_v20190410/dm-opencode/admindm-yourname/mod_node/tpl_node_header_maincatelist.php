<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
 ?>
  <div class="contenttop-" style="padding:10px 0">
 
   <strong> 内容管理：</strong>

  
  <?php 
  if($usertype<>'normal'){ 
  $sql = "SELECT pidname,name from ".TABLE_CATE." where   modtype='node' and pid='0'   $andlangbh  order by pos desc,id desc";
  $rowlist = getall($sql);
  if($rowlist=='no') echo $norr2;
  else{
  
     foreach($rowlist as $v){
    
     $pidnamemain = $v['pidname']; 
     $name = decode($v['name']); 
  
  $styleSubVTop = $styleSubVTopread='';
         if($pidnamemain==$catpid) {
           if($type=='read') $styleSubVTopread=' style="background:red;color:#fff" ';
           else  $styleSubVTop=' style="background:red;color:#fff" ';
         }
       
  
      $laylist = ' <a '.$styleSubVTop.' href="../mod_node/mod_node.php?lang='.LANG.'&catpid='.$pidnamemain.'&page=0">'.$name.'</a> ';
      echo $laylist.'&nbsp; | &nbsp;';
  
  
  
  }
  }

}
  
  
  ?>
  

 </div>

