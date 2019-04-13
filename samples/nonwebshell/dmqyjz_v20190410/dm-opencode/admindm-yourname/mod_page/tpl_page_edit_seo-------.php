<?php

echo 'no use -- move to 模块-- seo 管理';
exit;
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}


 if($act=='update'){


//pre($_POST);
 
 
   if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}
 
 

  $ss = "update ".TABLE_PAGE." set seo1='$abc1',seo2='$abc2',seo3='$abc3'  where id='$tid' $andlangbh limit 1";

	 // echo $ss;exit;
	 	iquery($ss);
  
	jump($jumpv_back);
 }
 else
 {

 
  $sql = "SELECT * from ".TABLE_PAGE."  where  id='$tid' $andlangbh   order by id limit 1";
$row = getrow($sql);
 
$seo1=$row['seo1'];
$seo2=$row['seo2'];
$seo3=$row['seo3'];

 
?>

<form  action="<?php echo $jumpv_file; ?>&act=update" method="post" enctype="multipart/form-data">

<div style="background:#e2e2e2;padding:10px;font-size:16px;font-weight:bold">修改SEO：</div> 
 
  <table class="formtab" >
 
 


 <tr>
    <td width="12%" class="tr">搜索引擎优化：</td>
    <td width="88%"> SEO标题：<input name="seocus1" type="text" id="page_seo1" value="<?php echo $seo1;?>" class="form-control" />
      <?php echo $xz_maybe;?>
     <div class="c5"></div>SEO关键字：
      <input name="seocus2" type="text" id="page_seo2" value="<?php echo $seo2;?>" class="form-control" />
      <?php echo $xz_maybe;?><br />多个关键字，请以空格隔开。
      <div class="c5"></div>
SEO描述：
<textarea  name="seocus3" class="form-control" rows="3" ><?php echo $seo3 ;?></textarea>
      <?php echo $xz_maybe;?>
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
  
 