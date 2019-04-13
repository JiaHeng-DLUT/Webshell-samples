<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
 */
if (!defined('IN_DEMOSOSO')) {
    exit('this is wrong page,please back to homepage');
}
if ($act == 'update') {
  //pre($_POST);exit;
  if ($abc1 == '')  { echo '请输入标题'; exit; }
     if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

    $ss = "update " . TABLE_ALBUM . " set title='$abc1',cssname='$abc2',effect='$abc3',cus_columns='$abc4'  where pidname='$pidname'  $andlangbh limit 1";
        //echo $ss;exit;
        iquery($ss);
        jump($jumpvnopid.'&act=edit&pidname='.$pidname);
   }
 


   if ($act == 'insert') {
       $pidnamecur = 'album' . $bshou;

       if ($abc1 == '')  { echo '请输入标题'; exit; } 
   $ss = "insert into ".TABLE_ALBUM." (pid,pidname,pbh,lang,title,cssname,effect,cus_columns) values ('$pid','$pidnamecur','$user2510','".LANG."','$abc1','$abc2','$abc3','$abc4')";
     //  echo $ss;exit;
       iquery($ss);
         jump($jumpv);
   }




   if($act=='add'){

    $title=$kv=$despjj=$desp=$imgsmall2 =$effect=$cssname  ='';
    $cus_columns = 3;
    $jumpvinsert = $jumpv.'&act=insert';

    $titleh2 = '添加相册';


   }

 if($act=='edit'){
    $titleh2 = '修改相册'; 

    $rowsub = getrow($sqlsub);
    $tid = $rowsub['id'];
    $title = $rowsub['title'];  $jsname = jsdelname($title);
   $pidname = $rowsub['pidname'];$cus_columns = $rowsub['cus_columns'];

    $effect = $rowsub['effect']; $cssname = $rowsub['cssname'];

 
  $jumpvinsert = $jumpvnopid.'&act=update&pidname='.$pidname;
}

if($act=='add' || $act=='edit'){
 
?>

<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpvinsert; ?>" method="post" enctype="multipart/form-data">
<table class="formtab">
        <tr>
            <td width="12%" class="tr">相册标题：</td>
            <td width="88%">
                <input name="title" type="text"   value="<?php echo $title; ?>" class="form-control" /><?php echo $xz_must; ?>

  <?php
if($act=='edit')  {
     echo  adm_previewlink($pidname);
     echo ' 标识：'.admblockid($pidname);
}
?>

            </td>
        </tr>




        <tr>
            <td   class="tr"> <?php echo $text_cssname; ?> </td>
            <td  >
                <input name="cssname" type="text"   class="inputcss form-control" value="<?php echo $cssname; ?>"  /><?php echo $xz_maybe; ?>

                <br /><span class="cgray">（参考：  gridbigimg ）  </span>
            </td>
        </tr>


        <tr style="background:#dce8f4">
        <td class="tr fb">效果文件：</td>
        <td class="select--TOinput--">

  <?php

$filedir = BLOCKROOT.'album/';
echo ' <select name="effect">';
select_from_filearr($filedir,$effect);
echo '</select>';

 
if($effect<>'') {   
    $file =  BLOCKROOT.'album/'.$effect; 
     checkfile($file);
}

?>



</td>
    </tr>





    <tr>
    <td  class="tr">
</td>
    <td  >
    <br />
    <span class="cblue"><i class="fa fa-exclamation-triangle fa-2x"></i> 下面的参数是否在前台显示，取决于选择的效果文件</span>
    </td>
</tr>


 <tr>
            <td  class="tr">  参数设置 ：</td>
            <td  >
             <div class="c5"> </div>
             列数： <select name="cus_columns">
                    <?php select_from_arr($arr_columns,$cus_columns,'');?>
                  </select>



            </td>
        </tr>






        <tr>
            <td></td>
            <td>
                <input  class="mysubmit mysubmitbig" type="submit" name="Submit" value="<?php echo $titleh2;?>"></td>
        </tr>
    </table>







      <?php echo $inputmust;?>

</form>


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

<?php

}


?>
