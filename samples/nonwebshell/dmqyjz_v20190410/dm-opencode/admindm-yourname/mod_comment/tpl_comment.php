 
<section class="content-header">

<?php
if($catid<>'formblock'){
?>

<div class="contenttop">
  <a href="mod_comm_contact.php?lang=<?php echo LANG?>&catid=contact"><i class="fa fa-angle-right"></i> 留言管理</a>
 &nbsp;&nbsp;&nbsp;&nbsp;
 <a href="mod_comm_contact.php?lang=<?php echo LANG?>&catid=ordernow"><i class="fa fa-angle-right"></i> 订单(询盘)管理</a>
 </div>
 <?php 
}
 ?>
    
<h1>
<?php 
if($catid=='formblock') {
   //mod_form/mod_form.php?lang=cn&pid=block&type=block&file=addedit&act=edit&pidname=form20181219_1421366828
   $linkv = '../mod_form/mod_form.php?lang='.LANG.'&pid=block&type=block&file=addedit&act=edit&pidname='.$catpid;
  
  echo '表单提交结果 - <a class="breadtitle" href="'.$linkv.'"  >'.$title.'</a>';

}
 else  echo $title?></h1>
</section>

<section class="content" style="padding:0 50px">

<?php

$keyV = 'and type=contact';
$sqltextlist = "SELECT * from ".TABLE_COMMENT." where $noandlangbh  " .$wheretype. " order by pos desc,id desc";
 //echo $sqltextlist;
//$rowlist = getall($sql);
   $num_rows = get_numrows($sqltextlist);        
 if($num_rows==0) {
  echo $norr2;
 $page_total= 1;
 }
else{    
       $offset=5;
       $maxline = 20; 
       $key='';
        $page_total=ceil($num_rows/$maxline);  

        if (!isset($page)||($page<=0)) $page=1;
        if($page>$page_total) $page=$page_total;
        $start=($page-1)*$maxline;
        $sqltextlist2="$sqltextlist  limit $start,$maxline";  
        //echo $sqltextlist2;
        $rowlist = getall($sqltextlist2);
        
        //echo $maxline;

 foreach($rowlist as $v){
    $tid=$v['id'];
   $ip=$v['ip']; $jsname = '删除留言';
   $desp=$v['desp'];   
   $nodepidname=$v['nodepidname']; 

   $dateedit=$v['dateedit'];   
   $del_text= " <a href=javascript:delid('del','$tid','$jumpv&page=$page','$jsname')  class=but2>删除</a>";
$nodecnt='';
 
  if($nodepidname<>''){   
    if(substr($nodepidname,0,4)=='page'){
          $nodearr = get_fieldarr(TABLE_PAGE,$nodepidname,'pidname'); 
          $nodetitle= $nodearr['name'];  
           
    }else{
        $nodearr = get_fieldarr(TABLE_NODE,$nodepidname,'pidname'); 
        $nodetitle= $nodearr['title'];  
       
    }
   
    $urlname = admlink($nodearr); 
   $nodecnt = '来自：'.$nodetitle.' |  '.$urlname.'<br />';
 }
 
echo '<div class="contactlist">IP:'.$ip.' 发布时间:'.$dateedit. $del_text.'<br />'.$nodecnt.'内容：<span class="cgray">(下面为发送email的内容)</span><div style="background:#e2edf9;padding:5px">'.web_despdecode($desp).'</div></div>';
 }
 ?>


<div class="c"></div>
<?php 
require_once HERE_ROOT.'plugin/page_2010.php';
 
}
?>
</section>

 