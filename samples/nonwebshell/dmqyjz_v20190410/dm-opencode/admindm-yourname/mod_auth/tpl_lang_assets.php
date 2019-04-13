<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
  if(!defined('IN_DEMOSOSO')) {
    exit('this is wrong page,please back to homepage');
  }
  
 

  if($act=='update'){

    
   if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

   $bscnt22 = '';
   if(count($_POST)>1){
    foreach ($_POST as  $k=>$v) {
      if(strtolower($k)=='submit') break;
      $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
      
    }
  }
  $bscnt22 = substr($bscnt22,0,-5);
  


  $ss = "update ".TABLE_LANG." set arr_assets='$bscnt22'  where lang='".LANG."' order by id";
  iquery($ss);   

  $jump_back = $jumpv_file.'&act=edit&tid='.$tid;
  

  jump($jump_back);

}
else{

  $sql = "SELECT arr_assets from ".TABLE_LANG." where lang='".LANG."' order by id";
  $row22 = getrow($sql);
  $arr_can=$row22['arr_assets'];
 //pre($arr_can);

  $bscntarr = explode('==#==',$arr_can); 
  if(count($bscntarr)>1){
    foreach ($bscntarr as   $bsvalue) {
     if(strpos($bsvalue, ':##')){
       $bsvaluearr = explode(':##',$bsvalue);
       $bsccc = $bsvaluearr[0];
       $$bsccc=$bsvaluearr[1];
     }
   }
 }
 
 $jumpv_insert = $jumpv_file.'&act=update&tid='.$tid;


 ?>





 <form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert;?>" method="post">
  <table class="formtab">

  <tr>
  <td class="tr">CDN缓存：</td>

  <td  >  <br />可以在下面网址找：<br /> http://www.bootcdn.cn/
  </td>
</tr>

<tr>
  <td class="tr">jQuery：</td>

  <td  >  
  <input name="jquery" type="text"  value="<?php echo $jquery;?>" class="form-control" > <?php echo $xz_maybe;?>
  </td>
</tr>

<tr>
  <td class="tr">是否合并 css：</td>

  <td  >  
  <select name="compresscss" class="form-control">
    <?php select_from_arr($arr_yn,$compresscss,'');?>
     </select>

<div class="c5"></div>
<a href="mod_compresscss.php?lang=<?php echo LANG;?>" target="_blank">如果选择合并css，请先点击这里进行合并动作。</a>
<br />
每次修改css后，也要在这里点一下。生成合并后的文件才有效。
  </td>
</tr>




<tr>
  <td></td>
  <td>
    <input  class="mysubmit" type="submit" name="Submit" value="提交"></td>
  </tr>
</table>

<?php echo $inputmust;?>

</form>



<?php
}


?>