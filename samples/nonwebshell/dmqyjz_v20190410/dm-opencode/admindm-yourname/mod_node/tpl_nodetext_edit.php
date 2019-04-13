<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

if($act=='insert'){ 
  
$pidname = 'ndtext'.$bshou; 
 

$sql="select * from ".TABLE_NODETEXT." where pid='$pid' and type='$type' and type2='$type2' $andlangbh order by id";
if(getnum($sql)){
  echo '不能创建，已经存在。';exit;
}


 $ss = "insert into ".TABLE_NODETEXT." (pid,pidname,pbh,type,type2,lang) values ('$pid','$pidname','$user2510','$type','$type2','".LANG."')";
 
 iquery($ss);

 $jumpv_file='../mod_node/mod_pop_nodetext.php?pid='.$pid.'&lang='.LANG.'&type='.$type.'&type2='.$type2.'&act=edit'; 
 jump($jumpv_file);
   
}


if($act == "del")
{
  $jumpv_file='../mod_node/mod_pop_nodetext.php?pid='.$pid.'&lang='.LANG.'&type='.$type.'&type2='.$type2.'&act=edit'; 
   
  ifsuredel_field(TABLE_NODETEXT,'id',$tid,'equal',$jumpv_file);
  jump($jumpv_file);

}



 if($act=='update'){
  //pre($_POST);


   if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

 
//  $despjj = zbdesp_onlyinsert($_POST['despjj']); 
   $desp = zbdesp_onlyinsert($_POST['despcontent']); //note: desp and addr not use variable abc1.
    $desptext = zbdesp_onlyinsert($_POST['editor1text']);
 
$ss = "update ".TABLE_NODETEXT." set  desptext='$desptext',desp='$desp'  where id='$tid' $andlangbh limit 1";
		//  echo $ss;exit;
  iquery($ss);

  $jumpv_file='../mod_node/mod_pop_nodetext.php?pid='.$pid.'&lang='.LANG.'&type='.$type.'&type2='.$type2.'&act=edit'; 
  jump($jumpv_file);
 
 
 }
 if($act=='edit'){
 

//---
$sql="select * from ".TABLE_NODETEXT." where pid='$pid' and type='$type' and type2 = '$type2'  $andlangbh order by id limit 1";
//echo $sql;
$row=getrow($sql);
 if($row=='no') {
    echo '没有记录 ';
    echo '<a href="'.$jumpv.'&act=insert'.'">点击创建</a>';
 }
 
else{

  $tid=$row['id'];
  $desp=zbdesp_imgpath($row['desp']);
   $desptext=zbdesp_imgpath($row['desptext']);
  
  $jumpv_file='../mod_node/mod_pop_nodetext.php?tid='.$tid.'&pid='.$pid.'&lang='.LANG.'&type='.$type.'&type2='.$type2.'&act=edit'; 
  
  $jsname = '';

  $del_text= " <a href=javascript:delid('del','$tid','$jumpv','$jsname')  class=but2><i class='fa fa-trash-o'></i> 删除</a>";
  

  echo  $del_text;
  
 ?>
   <section class="content-header">
   <h1> <?php 
   if($type2=='nodeprocan') echo '产品参数';
   else echo '其他信息';
   ?>  </h1>
</section>
 
  <form  action="<?php echo $jumpv_file; ?>&act=update" method="post" enctype="multipart/form-data">


 
  <table class="formtab" >
 
 
   <tr>
  
      <td>
 
      <?php 
      require_once('../plugin/editor_textarea.php');//textarea is in this file
      ?>

        </td>
    </tr>
 



  </table>
 

 

<div class="c tc"> 
 
 <input class="mysubmit mysubmitbig"     type="submit" name="Submit" value="提交" /> 
     
 <?php echo $inputmust;?>

 </div>

 </form>

   <?php 
   //require_once('../plugin/editor_imgintroduce.php'); 
   ?>


<?php
  }
}
  ?>
 
 
 