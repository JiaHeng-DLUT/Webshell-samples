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

 
     $videoid =  htmlentitdm(@$_POST['videoid']);
    $videoid=str_replace("\\","/",$videoid);
    $videoid=str_replace(chr(13),"|",$videoid);
    $videoid=str_replace(chr(32),"",$videoid);

//echo $bscnt22;exit;
     $ss = "update ".TABLE_NODE." set videoid='$videoid'   where id='$tid' $andlangbh limit 1";
    //  echo $ss;exit;
      iquery($ss);
  
     jump($jumpv_file);
 
 
 }
 else
 {
 

$sql = "SELECT * from ".TABLE_NODE."  where  id='$tid' $andlangbh   order by id limit 1";
$row = getrow($sql); 
$videoid=$row['videoid']; 
 
$videoid=str_replace("|",chr(13),$videoid);

 ?>
 
 <section class="content-header">
   <h1> 视频管理：  </h1>
  
    </section>

  <form  action="<?php echo $jumpv_file; ?>&act=update" method="post" enctype="multipart/form-data">

 <table class="formtab" >


   <tr>
      <td class="tr">
    视频标识：
      </td>
      <td>  
       <textarea class="form-control" rows="5" name="videoid"><?php echo $videoid; ?></textarea> <?php echo $xz_maybe; ?>
     

  <?php 


 //if($videoid<>'') echo check_blockid($videoid);
 ?>
    <div class="c5"></div>

 
        </td>
    </tr>
    <tr>
      <td class="tr">
    创建视频：
    <p class="cgray">上面的标识优先于这里的创建</p>
      </td>
      <td> 
    
      <?php 
   
   $wherev = "type='node' and pid='$pidname' ";
    
   $sqlsub = "SELECT  *  from " . TABLE_VIDEO . "  where    $wherev  $andlangbh order by id limit 1";
   //  echo $sqlsub;exit;
     if(getnum($sqlsub)==0){
       
       $link= '../mod_video/mod_video.php?lang='.LANG.'&page=0&pid='.$pidname.'&type=node&act=add';
       echo '还没有这个内容的视频, <a class="needpopup" href="'.$link.'">点击创建 > </a>';
     }
     else {
       $row = getrow($sqlsub);
       $videopidname = $row['pidname'];
      $link= '../mod_video/mod_video.php?lang='.LANG.'&page=0&pid='.$pidname.'&type=node&act=edit';
      echo '  <a class="needpopup" href="'.$link.'">编辑视频 > </a> ';
      echo admblockid($videopidname);
      echo adm_previewlink($videopidname);
      
     }
 ?>
      </td>
    </tr>

 
<?php 
//require_once HERE_ROOT.'mod_page/plugin_page_inc_can.php';
?>
 
 

</table>

 
 
<div class="c tc"> 
 
 <input class="mysubmit"     type="submit" name="Submit" value="提交" /> 
     
 <?php echo $inputmust;?>

 </div>

 </form>
<?php
  }
  ?>
 
 <script>
 $(function(){

    $('.mysubmitnew').click(function(){


 var titlev =  $("input[name='title']").val().trim();
    if(titlev=='') {
      alert('请输入标题');
      $("input[name='title']").focus();
      return false;

    }

  
  //-------------
}

      );

 });
 
 </script>
 