
<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

?>

<div class="blocklist">
<?php 
  
  foreach($arr_block as $k=>$v){
    $typecur=$k;  //typecur not affect $type value
    echo '<h3>'.$v.'</h3>';


    $sql_22 = "SELECT * from ".TABLE_BLOCK." where   $noandlangbh  and pidstylebh='$ppid' and pid='$typecur' and typecolumn<>'column'  order by  pos desc,id desc"; //pos desc,id desc
   
   $rowlist_22 = getall($sql_22);
    if($rowlist_22 == 'no')  echo '<p style="padding:15px;background:#eee">没有内容，请添加。</p>';
    else {
  ?>
<ul class="sidebarnew">
 
  <?php
      foreach($rowlist_22 as $v_22){
            $tidhere = $v_22['id'];
            $pidname_22 = $v_22['pidname'];
            $template = $v_22['template'];
            $name_22 = decode($v_22['name']);  

            $sta_visi_v = $v_22['sta_visible']; 
    
            if($pidname==$pidname_22) $classv = 'class="active"';
            else $classv = ' ';

            $vnoexist ='';
   if($template<>'') { 

    if($ppid=='common')  $file22 =  BLOCKROOT.$typecur.'/'.$template;
    if($ppid4=='styl')  $file22 =  TPLCURROOT.'/selfblock/'.$typecur.'/'.$template;
    if($ppid4=='dmre')  $file22 = REGIONROOT.$ppid.'/'.$typecur.'/'.$template;
     
            $vnoexist =  is_file($file22)?'':' <span class="cblue">(文件不存在)</span>';
           
         }

 
//--------------
 
$vhide = $sta_visi_v<>'y'?' [隐藏]':'';
  // mod_block/mod_block.php?lang=qing&type=bdcustom&pidname=vblock20151217_0448227671&act=edit
  $linkedit = $jumpv.'&pidname='.$pidname_22.'&act=edit';
$edittext_22='<a  href="'.$linkedit.'"><i class="fa fa-angle-right"></i> '.$name_22.'</a>'.$vhide.$vnoexist;



    ?>

<li <?php echo $classv;?>>
<?php echo $edittext_22;?>
</li>
 

<?php 
}
 
?>
 
 </ul>

 <?php 
}

  }
 
?>
 </div>

