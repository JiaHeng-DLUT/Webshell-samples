
<form  onsubmit="return formvalidate()"  action="<?php  echo $jumpv.'&act=search';?>"   method="post" enctype="multipart/form-data">
<table class="formtab">


  <tr>
   
    <td width="88%"><strong>搜索别名： </strong>
  
  <br /><input name="alias"   type="text"  value="" class="form-control" />
  <br />
 <input class="mysubmit" type="submit" name="Submit" value="搜索别名">
  </td>
  </tr>

  
 </table>
</form>
   
 
<hr><br />
 
<?php 
 if($act=='search') $where = "where  name like '%$abc1%' $andlangbh ";
 else $where=" where $noandlangbh ";
$sql = "SELECT * from ".TABLE_ALIAS." $where order by id desc"; 
 // echo $sql;exit;
 $num_rows = getnum($sql);

     if($num_rows>0){
 
        $offset=5;
        $maxline=20;
        $page_total=ceil($num_rows/$maxline);  

        if (!isset($page)||($page<=0)) $page=1;
        if($page>$page_total) $page=$page_total;
        $start=($page-1)*$maxline;
        $sql2="$sql  limit $start,$maxline"; 
        $rowlist = getall($sql2);   


       ?>

     

 <table class="formtab formtabhovertr">

<tr class="formtitle">
  <td>别名</td> 
    <td>标识</td> 
    <td>标题</td> 
    
    <td align="center">操作</td>
     
  </tr> 

<?php
      foreach($rowlist as $v){
       //$type = $v['type'];  //no use type...
        $pid = $v['pid'];  
          $tid = $v['id']; 
$pid4 = substr($pid,0,4); $pid3 = substr($pid,0,3);
if($pid3=='tag')  $pid4 = 'tagg';

if($pid4=='node') {
  $arr = get_fieldarr(TABLE_NODE,$pid,'pidname');
  $title = '文章：'.$arr['title']; 
} 
elseif($pid4=='page'){
  $arr = get_fieldarr(TABLE_PAGE,$pid,'pidname');
  $title = '页面：'.$arr['name'];
}  
elseif($pid4=='cate' || $pid4=='csub'){
  $arr = get_fieldarr(TABLE_CATE,$pid,'pidname');
  $title = '分类：'.$arr['name'];

}  
elseif($pid4=='tagg'){
  $arr = get_fieldarr(TABLE_TAG,$pid,'pidname');
  $title = '标签：'.$arr['name'];
}  

 $jsname = '删除别名：'.jsdelname($title);

//mod_seo/mod_alias_edit.php?lang=cn&act=edit&pidname=page20160307_1115284044&type=page
$editlink='<a class="but1 needpopup" href="mod_alias_edit.php?lang='.LANG.'&pidname='.$pid.'&act=edit"><span><i class="fa fa-pencil-square-o"></i> 修改</span></a>';
$del_text= " <a  class='but2' href=javascript:delid('del','$tid','$jumpv','$jsname') ><span><i class='fa fa-trash-o'></i> 删除</span></a>";
 
?>

  <tr>
         <td>
            别名：<span class="cred"><?php echo $v['name'];?></span> <br />
             
        </td>
        <td>
           <?php echo $pid;?>    
        </td>

        <td>
          <?php echo $title.'   '.admlink($arr);?> 
        </td>
     
       <td align="center"><?php echo $editlink.$del_text;?></td>   
    
  </tr>
<?php } ?>
  
 </table>
 <?php
   
 

require_once HERE_ROOT.'plugin/page_2010.php';
 
if($act=='search') echo '<p><a href="'.$jumpv.'">返回列表</a></p>';

  } 

else {echo '没有找到相关的别名。<a href="'.$jumpv.'">返回列表</a>';
   
}   


  ?>
 
 

 
  <script>
function formvalidate(){
    var valias = $.trim($('.formtab input[name=alias]').val());
     if(valias=='') {alert('别名不能为空。'); 
          $('.formtab input[name=alias]').focus();
         return false;}


}

 </script>