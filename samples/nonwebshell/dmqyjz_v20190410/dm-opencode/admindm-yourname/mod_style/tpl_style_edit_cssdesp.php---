<?php
      
  $sql = "SELECT htmldir,sta_sqlcss from ".TABLE_STYLE."  where pidname='$pidname' $andlangbh   order by id limit 1";
$row = getrow($sql);

$sta_sqlcss = $row['sta_sqlcss'];
$htmldir = $row['htmldir'];
 
  $cssfilename = '/'.$htmldir .'/css/'.$htmldir.'.css';
 $cssfileroot = TEMPLATEROOT.$cssfilename;
 $cssfilepath = TEMPLATEPATH.$cssfilename;

   $cssfilebak =  WEB_ROOT.'cache/customcss/'.$htmldir.'_bak_'.$bshou.'.css';
  
if(is_file($cssfileroot)){ 

if($act=='update'){
   if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}
   //$ss = "update ".TABLE_STYLE." set desp='$abc1' where pidname='$pidname' $andlangbh limit 1";
   // echo $ss;exit;    
  // iquery($ss);  

$despv = $_POST['desp'];

  // $despv=str_replace("[uploadpath]",UPLOADPATHIMAGE,$abc1);

 
        if (!copy($cssfileroot,$cssfilebak)) {
        echo  '<p style="padding:20px;font-size:16px;color:red">对不起，'.$cssfilename.'备份不成功。failed to copy $cssfile...</p>';
        }
  

file_put_contents($cssfileroot,$despv);

 $jumpv = $jumpv_pf.'&act=edit';
 jump($jumpv);

}
else{


$desp=file_get_contents($cssfileroot);  
  
 // $sql = "SELECT * from ".TABLE_STYLE."  where pidname='$pidname' $andlangbh   order by id limit 1";
//$row = getrow($sql);
 

//$desp=$row['desp'];
 $jumpv_insert = $jumpv_pf.'&act=update';

 

?>
 
 
 

<p>提示：这里的样式来自 css文件：<a href="<?php echo $cssfilepath;?>" target="_blank"> 模板目录下的<?php echo $cssfilename;?></a>，所以你也可以直接编辑这个css文件。
  <br />这里的内容修改后即生效。 同时会在cache/customcss目录创建一个备份文件。

   
</p>

<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert;?>" method="post">
  <table class="formtab"> 

    <tr>      
      <td> 
          <textarea  style="font-size:16px" name="desp" class="form-control" rows="35"><?php echo $desp;?></textarea> 
      </td>
    </tr>
    
  <tr>   
      <td>
      <input  class="mysubmit mysubmitbig" type="submit" name="Submit" value="提交" /></td>
    </tr>
    </table>
    <?php 
     //<p class="hintbox">使用上传的图片的方法：[uploadpath]1/****.jpg</p>
?>
    <?php echo $inputmust;?>
    
</form>
 
<?php
 }
}
else  {
 echo '模板目录下的 '.$htmldir .$cssfilename.' 不存在。';

}
?>

 
