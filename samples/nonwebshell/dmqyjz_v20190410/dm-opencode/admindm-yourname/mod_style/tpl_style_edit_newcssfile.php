<?php 

/*----------仅限pc端样式 only pc style---------*/
//@media (min-width: 801px) {

//}
/*----------仅限mobile端样式 only mobile style---------*/
//@media (max-width: 800px) {
//}

$sql = "SELECT htmldir from ".TABLE_STYLE."  where  pidname='$pidname' $andlangbh   order by id limit 1";
$row = getrow($sql);
$htmldir=$row['htmldir'];

 
$cssfilename = $htmldir .'/cssjs/'.$htmldir.'.css';
$cssfile = TEMPLATEROOT.$cssfilename;

$cssbak = WEB_ROOT .'cache/cssbak/'.$htmldir.'--'.date("Ymd-His").'.css';
//echo $cssbak;

 
if(!is_file($cssfile)) {
  echo '出错：模板目录下的'.$cssfilename.' 不存在，如果需要这个css，请创建。不需要，就不用理会此功能。';
}
else{
  $desp=file_get_contents($cssfile); 
 

//---------------------
if($act=='update'){

   if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

 

   $despv = $_POST['desp'];
 
   $jumpv = $jumpv_pf2.'&act=edit';


      if(strlen($despv)<10){
        alert('字符不够。');
        jump($jumpv);
      }
      else{
        file_put_contents($cssfile,$despv); 

        if(!is_file($cssbak)) fopen($cssbak, "w");
        file_put_contents($cssbak,$despv); 

        jump($jumpv);
      }



}
else{

   
 
$jumpv_insert = $jumpv_pf2.'&act=update'; 
?>

<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert;?>" method="post">
  <table class="formtab">
   
    <tr style="background:#2480C4;color:#fff">
  <td > </td>
      <td   class="tl"><strong>css文件，来自于 模板目录下的 <?php echo $cssfilename;?></strong>
   
      
      </td>
    </tr>

    <tr>
      <td  width="20%"  class="tr"> css文件：
  
      
      </td>
      <td > 
      <br/>
   

  <textarea  style="height:650px" name = "desp"  class="form-control"><?php echo $desp;?></textarea>
 
  </td>
    </tr>

 
  <tr>
      <td></td>
      <td>
      <p class="cgray">提示：这里的每次提交，都会在cache/cssbak目录下产生备份文件。<br /></p>
    
      <input  class="mysubmit" type="submit" name="Submit" value="提交" />
      
    </td>
    </tr>
  

    </table>

    <?php echo $inputmust;?>
    
</form>
<?php }
?>
<script>
function checkhere(thisForm) {
  
}

</script>

<?php
}

?>
