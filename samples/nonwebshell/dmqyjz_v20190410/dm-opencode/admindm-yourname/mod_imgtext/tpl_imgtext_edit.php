<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
 */
if (!defined('IN_DEMOSOSO')) {
    exit('this is wrong page,please back to homepage');
}
if ($act == 'update') {

 
    if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}
 
     
   if($abc1=="") {
       echo 'pls input title'; 
        exit;
}


    $desp = zbdesp_onlyinsert($_POST['despcontent']); //note: desp and addr not use variable abc1.
    $desptext = zbdesp_onlyinsert($_POST['editor1text']);
  
  
    $arrcanexcerpt =  array("title","cssname","fullwidth", "despjj","desptext","editor1text","despcontent"); 
    $bscnt22 = '';
if(count($_POST)>1){
        foreach ($_POST as  $k=>$v) {
           if(strtolower($k)=='submit') break;
          if(in_array($k,$arrcanexcerpt))   continue;

          $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
           
        }
    }
     $bscnt22 = substr($bscnt22,0,-5);



    $ss = "update " . TABLE_IMGTEXT . " set title='$abc1',cssname='$abc2',fullwidth='$abc4',arr_can='$bscnt22',desptext='$desptext',desp='$desp'  where id='$tid' $andlangbh limit 1";
    // echo $ss;exit;
    iquery($ss);
    //alert("修改成功");
    $jump_insertimg = $jumpv.'&file=edit&act=edit&tid=' . $tid;
    jump($jump_insertimg);
}



if ($act == 'edit') {

 
    $titleh2 = '修改';
  
    //pre($rowsub);
  
    $title = $rowsub['title'];    $fullwidth = $rowsub['fullwidth'];$cssname = $rowsub['cssname'];  
     $pidnamehere = $rowsub['pidname'];
       
     $linkdhtitle = $linkdhurl = $cssstyle =  '';//if add,need give null value for update.
    $titlefg = 'notitle';
     $kv = $rowsub['kv'];
    
    $desp = zbdesp_imgpath($rowsub['desp']);
    $desptext = zbdesp_imgpath($rowsub['desptext']);
     

    $linkdhtitle = $linkdhurl = $blockid = '';//if add,need give null value for update.
    $format = 'imgtop'; 
 


    $jump_insertimg = $jumpv . '&file=edit&act=update&tid=' . $tid;
   
 

?>

<div class="layoutsidebar fl col-xs-12 col-sm-12  col-md-2">
<?php 
 require_once('plugin_imgtext_edit_sidebar.php');

 // put here .avoid confict by sidebar
 $bscntarr = explode('==#==',$arr_can_edit);  //avoid confict by sidebar
 //pre($bscntarr);
 if(count($bscntarr)>1){
   foreach ($bscntarr as   $bsvalue) {
    if(strpos($bsvalue, ':##')){
      $bsvaluearr = explode(':##',$bsvalue);
      $bsccc = $bsvaluearr[0];
      $$bsccc=$bsvaluearr[1];
    }
  }
 }
 
?>
</div><!--end sidebar-->
<div class="fl col-xs-12 col-sm-12  col-md-10">
 

<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jump_insertimg; ?>" method="post" enctype="multipart/form-data">
    <table class="formtab">
      

        <tr>
            <td width="12%" class="tr">标题：</td>
            <td width="88%"> 
                <input name="title" type="text"   value="<?php echo $title; ?>" class="form-control" /><?php echo $xz_must; ?> 
 
            </td>
        </tr>
        <tr>
            <td   class="tr"> <?php echo $text_cssname; ?> </td>
            <td  > 
                <input name="cssname" type="text"  class="inputcss form-control" value="<?php echo $cssname; ?>"  /><?php echo $xz_maybe; ?>
                   
            </td>
        </tr>

 <tr style="background:#fff">
      <td class="tr">样式 </td>
      <td>
<input name="cssstyle" type="text" value="<?php echo $cssstyle?>"   size="35" /> <?php echo $xz_maybe;?>
<span class="cgray">试下： margin-top:50px;</span>
  </td>
  </tr>


        <tr>
            <td   class="tr">是否全宽</td>
            <td  > 
            <select name="fullwidth"> <?php select_from_arr($arr_yn,$fullwidth,'');?>
     </select>
              
            </td>
        </tr>
        <tr>
            <td width="12%" class="tr"> 标题格式：</td>
            <td width="88%">
                        <select name="titlefg">
                        <?php                                
                        select_from_arr($arr_imgtext_title,$titlefg,'');?>
                        </select> 
            </td>
        </tr>
        <tr>
            <td width="12%" class="tr"> <strong>内容格式：</strong></td>
            <td width="88%">
                        <select name="format">
                        <?php
                      
                                        
                        select_from_arr($arr_imgtext,$format,'');?>
                        </select> 
            </td>
        </tr>


       
        <tr style="background: #DCE8F4">
            <td width="12%" class="tr">链接：</td>
            <td width="88%">
            链接字样：       
    <input name="linkdhtitle" type="text" value="<?php echo $linkdhtitle?>"  size="30" />
<?php echo $xz_maybe;?> 
<div class="c5"></div>

     链接网址：       
    <input name="linkdhurl" type="text" value="<?php echo $linkdhurl?>"  class="form-control" />
<?php echo $xz_maybe;?> 

 
            </td>
        </tr>
  



        <tr>
            <td width="12%" class="tr">kv图片：</td>
            <td width="88%"> 
              <?php 
                echo  p2030_imgyt($kv,'y','n');
                ?>
                <p><a class="needpopup but4 pad8lr" style="width:auto"  href="../mod_module/mod_uploadkv.php?lang=<?php echo LANG?>&pidname=<?php echo $pidnamehere?>&type=imgtextkv">修改kv图</a></p>

            <?php 
            if(substr($format,0,2)=='bs') echo '<p style="color:red">提示：由于内容格式有标识，所以这里的图片不会在前台显示</p>';
            ?>
               
   </td>
 </tr>

 <tr>
            <td width="12%" class="tr">标识：</td>
            <td width="88%"> 
                <input name="blockid" type="text"   value="<?php echo $blockid; ?>"  size="35" /> 
                <?php
                  if($blockid<>'') echo check_blockid($blockid);
                ?>
            </td>
        </tr>

  <tr>
    <td class="tr">内容： </td>
  <td>  
    <p>     
  <!--
    <a href="../mod_imgfj/mod_imgfj.php?pid=<?php //echo $pidnamehere;?>&lang=<?php //echo LANG;?>" target="_blank">私有编辑器附件管理(<?php //echo num_imgfj($pidnamehere);?>)</a>
|
-->
 <?php echo $text_imgfjlink_bjq;?>
   </p>

<?php require_once('../plugin/editor_textarea.php'); //textarea is in this file ?>

            </td> 
        </tr>


  <tr>
            <td></td>
            <td>
                <input  class="mysubmit mysubmitbig" type="submit" name="Submit" value="<?php echo $titleh2; ?>"></td>
        </tr>
    </table>

     <?php echo $inputmust;?>

</form>


</div><!--end right-->


<div class="c"> </div>





<?php } ?>


<script>
    function checkhere(thisForm) {
        if (thisForm.title.value == "")
        {
            alert("请输入标题。");
            thisForm.title.focus();
            return (false);
        }

    
    
        // return;

    }


</script>
