 
 <?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}


 if($act=='update'){
  //pre($_POST);


   if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}



  if($abc1=='') $abc1 = 'pls input title';
 
   $despcan = zbdesp_onlyinsert($_POST['despcontent']); //note: desp and addr not use variable abc1.
   
 
$ss = "update ".TABLE_NODE." set despcan='$despcan' where id='$tid' $andlangbh limit 1";
		//  echo $ss;exit;
	  	iquery($ss);
  
	 jump($jumpv_file);
 
 
 }
 else
 {
  $desp=zbdesp_imgpath($row['despcan']);
 
  ?>
 
 <section class="content-header">
   <h1>
      产品参数：
      </h1>
  
    </section>

  <form  action="<?php echo $jumpv_file; ?>&act=update" method="post" enctype="multipart/form-data">

 <table class="formtab" >
   <tr>
      <td >
   <?php 
     if($editor == 'ck') require_once('../plugin/editor_ck.php');
     else if($editor == 'simditor')	require_once('../plugin/editor_simditor.php');
     else if($editor == 'baidu')	require_once('../plugin/editor_baidu.php');
     else if($editor == 'kind') require_once('../plugin/editor_kind.php');
     ?>
      </td>
    
    </tr>
  

</table>
 
 
<div class="c tc"> 
 
 <input class="mysubmit"     type="submit" name="Submit" value="提交" /> 
     
 <?php echo $inputmust;?>

 </div>

 </form>
<?php
  }
  ?>
  