<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
$arrcanexcerpt =  array("name","despjj","pidstylebh","despcontent","editor1text");


if($pidname=='') { echo 'sorry, no pidname ;';exit; }


 $sql = "SELECT id,pidname from ".TABLE_BLOCK." where pidcolumn='$pidname' and typecolumn='column'   $andlangbh order by id limit 1";
 if(getnum($sql)==0){
    //then insert into block
 $pidnamecur = 'vblock' . $bshou;
 //pid is type, is custom or node or blockdh or video

 


//pid is type... blockdh or node or custom or column
   $ss = "insert into " . TABLE_BLOCK . " (pbh,pid,pidcolumn,pidname,lang,name,typecolumn,dateday,template,blockcan) values ('$user2510','column','$pidname','$pidnamecur','" . LANG . "','namecolumn','column','$dateday','default_column','$arr_blockcan')"; 
   //use template is default_column.tpl.php
  //echo $ss;exit;
    iquery($ss);
    
    jump($jumpvpf);
 }
 else{
   //then update
  $row22 = getrow($sql); 
  $pidnamecur = $row22['pidname'];
 
?>




<?php

if ($act == 'update') {
   

     if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

  
  // pre($_POST); exit;
 
 
 $desp = zbdesp_onlyinsert($_POST['despcontent']); //note: desp and addr not use variable abc1.
 $desptext = zbdesp_onlyinsert($_POST['editor1text']);

//$arrcanexcerpt  in top line

 $bscnt22 = '';
 if(count($_POST)>1){
         foreach ($_POST as  $k=>$v) {
            if(strtolower($k)=='submit') break;
           if(in_array($k,$arrcanexcerpt))   continue;

           $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';

         }
     }
      $bscnt22 = substr($bscnt22,0,-5);

$postv = "blockcan='$bscnt22',template='default_column',desptext='$desptext',desp='$desp'"; 

   $ss = "update " . TABLE_BLOCK . " set  ".$postv." where typecolumn='column' and pidname='$pidnamecur' $andlangbh limit 1";
   
     // echo $ss;exit;
   //pre($_POST);

   iquery($ss);
   jump($jumpvpf);
}



else{
    $titleh2 = '修改';
    $sqlsub = "SELECT * from " . TABLE_BLOCK . "  where  pidcolumn='$pidname' and typecolumn='column' $andlangbh order by id limit 1";
    if(getnum($sqlsub)>0){
    //echo $sqledit;exit;
    $rowsub = getrow($sqlsub);

    $blockid='';
    $arr_can = $rowsub['blockcan'];
    $bscntarr = explode('==#==',$arr_can); //pre($bscntarr);
    if(count($bscntarr)>1){
      foreach ($bscntarr as   $bsvalue) {
       if(strpos($bsvalue, ':##')){
         $bsvaluearr = explode(':##',$bsvalue);
         $bsccc = $bsvaluearr[0];
         $$bsccc=$bsvaluearr[1];
       }
     }
   }

   
   // pre($rowsub);
  //no name, only namefront,name use  column name.
   $template = $rowsub['template'];     
  
//$titlestyle = $rowsub['titlestyle']; 
//$titlestylesub = $rowsub['titlestylesub']; 
 
    // $despjj = zbdespedit($rowsub['despjj']);
    $pidnamehere = $rowsub['pidname'];
    $blockimg = $rowsub['blockimg'];
 
//$despjj = $rowsub['despjj'];
    $desp = zbdesp_imgpath($rowsub['desp']);
    $desptext = zbdesp_imgpath($rowsub['desptext']);
    
    $jump_insertimg = $jumpvpf . '&act=update';
    


   
?>
 <div class="layoutsidebar fl col-xs-12 col-sm-12  col-md-2">
<?php 
 require_once('plugin_column_edit_sidebar.php');
?>
</div><!--end sidebar-->
<div class="fl col-xs-12 col-sm-12  col-md-10">




<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jump_insertimg; ?>" method="post" enctype="multipart/form-data">
    <table class="formtab">

 <tr>
            <td width="12%" class="tr"> </td>
            <td width="88%"> 
                <?php echo $pidnamecur?> 
 <?php echo  adm_previewlink($pidnamecur);?>  


            </td>
        </tr>
        <tr>
            <td width="12%" class="tr">前台标题：</td>
            <td width="88%"> 
               <input name="namefront" type="text"   value="<?php echo $namefront; ?>" size="30"  /><?php echo $xz_maybe; ?>  
          <div class="inputclear"> </div>

            </td>
        </tr>


          <tr>
            <td height="60" class="tr"><strong>调用标识：</strong></td>
            <td  > 
<input name="blockid" type="text" value="<?php echo $blockid;?>"  size="30" />
<?php echo $xz_maybe;?> 
<?php 
echo  check_blockid($blockid);

$texterr = '如果有标识，则下面所有的选项不起使用。会被标识的内容替换。';
if($blockid=='') echo '<p style="color:blue;padding:10px">提示：'.$texterr.'</p>';
else echo '<p style="background:red;color:#fff;padding:10px;font-size:14px">'.$texterr.'</p>';
?>



 </td>
        </tr>




         <tr>
            <td   class="tr"> <?php echo $text_cssname; ?> </td>
            <td  > 
                <input name="cssname" type="text"  class="inputcss form-control" value="<?php echo $cssname; ?>"  /><?php echo $xz_maybe; ?>
                <p class="cgray">参考： tl, tr,  tc ，boxcolnopad ，boxcolnomag</p>  
            </td>
        </tr>

          
     

     <tr style="background: #DCE8F4">
            <td  class="tr">链接字样：</td>
            <td  > 
      <input name="linktitle" type="text"    value="<?php echo $linktitle; ?>" size="30"  /><?php echo $xz_maybe; ?> 
 
 
 </td>
        </tr>


        <tr style="background: #DCE8F4">
            <td  class="tr">链接网址：</td>
            <td  >  
     <input name="linkurl" type="text"  class="inputcss form-control"  value="<?php echo $linkurl; ?>"    /><?php echo $xz_maybe; ?> 
 
 </td>
        </tr>
 
        
        <tr>
            <td   class="tr"> 图片：
         
            </td>
            <td  >
            <div class="c5"> </div>
            <?php 
          
            echo  p2030_imgyt($blockimg,'y','n'); 
            ?>
            
            <p><a class="needpopup but1 pad8lr" style="width:auto"  href="../mod_module/mod_uploadkv.php?lang=<?php echo LANG?>&pidname=<?php echo $pidnamehere?>&type=blockimg">修改图片</a></p>
            
                   
            </td>
        </tr>
 
  

        <tr>
            <td class="tr">内容： </td>
            <td> <p>
 <a class="needpopup" href="../mod_imgfj/mod_imgfj.php?pid=common&lang=<?php echo LANG; ?>" target="_blank">公共编辑器附件管理</a>

                </p>



<?php require_once('../plugin/editor_textarea.php'); //textarea is in this file ?>

            </td> 
        </tr>

 

        <tr>
            <td></td>
            <td>
                <input  class="mysubmit mysubmitbig" type="submit" name="Submit" value="提交"></td>
        </tr>
    </table>

      <?php echo $inputmust;?>

</form>
</div><!--end right-->
<div class="c"> </div>

<?php 

} 
else{echo '区块不存在 ';}

}

?>



<script>
    function checkhere(thisForm) {
        if (thisForm.title.value == "")
        {
            //alert("请输入标题。");
           // thisForm.title.focus();
           // return (false);
        }

        // return;

    }

   


</script>





<?php 

 }  // then update block content of the column

 ?>


 