<?php
/*
  power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}
$pid4 = substr($pidname,0,4);
$pid3 = substr($pidname,0,3);
if($pid3=='tag')  $pid4 = 'tagg';;
 
 if($pid4=='page') $table = TABLE_PAGE;
 elseif($pid4=='cate'  || $pid4=='csub') $table = TABLE_CATE;
  elseif($pid4=='node') $table = TABLE_NODE;
  elseif($pid4=='tagg') $table = TABLE_TAG;
 

 if($act=='update'){ 
//pre($_POST);
  
 
   if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;} 

  $ss = "update ".$table." set seo1='$abc1',seo3='$abc2',seo2='$abc3'  where pidname='$pidname' $andlangbh limit 1";

   // echo $ss;exit;
    iquery($ss);
  
  jump($jumpv.'&act=edit');
 }
 else
 {



  $sql = "SELECT * from ".$table."  where  pidname='$pidname' $andlangbh   order by id limit 1";
$row = getrow($sql);
 
$seo1=$row['seo1'];
$seo2=$row['seo2'];
$seo3=$row['seo3'];
if($pid4=='page') {
  $name=decode($row['name']);
  $title2 = ' 单页面：';
}
elseif($pid4=='cate' || $pid4=='csub') {
  $name=decode($row['name']);
  $title2 = ' 分类：';
}
elseif($pid4=='node') {
  $name=decode($row['title']);
  $title2 = '文章：';
}
elseif($pid4=='tagg') {
  $name=decode($row['name']);
  $title2 = '标签';
}
?>

<form  action="<?php echo $jumpv; ?>&act=update" method="post" enctype="multipart/form-data">

<div style="background:#e2e2e2;padding:10px;font-size:16px;font-weight:bold">修改SEO </div> 
 
  <table class="formtab" >
 
 
  <tr>
    <td width="12%" class="tr"><?php echo $title2;?></td>
    <td width="88%">  <?php echo $name;?>
    <p><?php
     echo admlink($row);
      ?></p>
    </td>
    </tr> 

 <tr>
    <td width="12%" class="tr">搜索引擎优化：</td>
    <td width="88%"> SEO标题：&nbsp; &nbsp; <input name="seocus1" type="text" id="page_seo1" value="<?php echo $seo1;?>" class="form-control form-controldi" />
      <?php echo $xz_maybe;?>

      <div class="c5"></div>
SEO描述：&nbsp;  &nbsp; 
<textarea  name="seocus3" class="form-control form-controldi" rows="3" ><?php echo $seo3 ;?></textarea>
      <?php echo $xz_maybe;?>

           <div class="c5"></div>SEO关键字：
      <input name="seocus2" type="text" id="page_seo2" value="<?php echo $seo2;?>" class="form-control form-controldi" />
      <?php echo $xz_maybe;?><p class="cgray">多个关键字，请以空格隔开。</p>


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
  
 