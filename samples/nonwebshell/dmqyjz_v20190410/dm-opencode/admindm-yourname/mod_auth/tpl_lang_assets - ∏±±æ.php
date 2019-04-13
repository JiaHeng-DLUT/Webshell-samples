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
      <td width="22%"  class="tr">前台图片使用七牛CDN加速：

        <br />  
        <a href="http://www.demososo.com/dmcdn.html" target="_blank">查看使用教程></a>

      </td>
      <td > 
       七牛域名：<input  type="text" name="cdn" value="<?php echo $cdn;?>" class="form-control" ><?php echo $xz_maybe;?>

       <?php 
       if($cdn<>''){
        if(!is_int(strpos($cdn,'://'))) echo '<br /><span class="cred">出错，必须以http或https开头。</span><br />';
      }

      ?>
      <br />
      <span class="cgray">比如：  http://7xoo1b.com1.z0.glb.clouddn.com</span>
      
      <div style="border-top: 1px solid #ccc;padding:10px 0">
        开启CDN ：
        <select name="sta_cdn" class="form-control">
         <?php select_from_arr($arr_yn,$sta_cdn,'');?>
       </select>

       <br /><span class="cgray">当后台上传新的图片时，要先关闭CDN，不然前台看不到效果。等新图片同步到七牛后，再开启。</span>
     </div>
     
   </td>
 </tr>
 
 


 <tr>
  <td class="tr">CDN缓存：
 <br />可以在下面网址找：<br />
 http://www.bootcdn.cn/

  </td>
  <td>
   jquery ：<input name="jquery" type="text"  value="<?php echo $jquery;?>" class="form-control" > <?php echo $xz_maybe;?>
   <div class="c5"></div>
 

   <div class="c5"></div>
   bootstrap.js ：<input name="bootstrapjs" type="text"  value="<?php echo $bootstrapjs;?>" class="form-control" > <?php echo $xz_maybe;?>
   <div class="c5"></div>
   bootstrap.css ：<input name="bootstrapcss" type="text"  value="<?php echo $bootstrapcss;?>" class="form-control" > <?php echo $xz_maybe;?>
   <div class="c5"></div>




   

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