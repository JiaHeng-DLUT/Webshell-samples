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

    $ss = "update " . TABLE_MUSIC . " set title='$abc1',cssname='$abc2',effect='$abc3'  where pidname='$pidname'  $andlangbh limit 1";
        //echo $ss;exit;
        iquery($ss);
        jump($jumpv.'&act=edit&pidname='.$pidname);


   }




   if ($act == 'insert') {


       $pidnamecur = 'music' . $bshou;

       if ($abc1 == '')  { echo '请输入标题'; exit; }

     $type='block';
     $ss = "insert into ".TABLE_MUSIC." (pid,pidname,pbh,lang,title,cssname,effect) values ('$pid','$pidnamecur','$user2510','".LANG."','$abc1','$abc2','$abc3')";
      // echo $ss;exit;
       iquery($ss);
         jump($jumpv);
   }




   if($act=='add'){

    $title=$kv=$despjj=$desp=$imgsmall2 =$effect=$cssname  ='';
    $cus_columns = 3;
    $jumpvinsert = $jumpv.'&act=insert';

    $titleh2 = '添加音乐';


   }

 if($act=='edit'){
    $titleh2 = '修改音乐';
 

    $rowsub = getrow($sqlsub);
    $tid = $rowsub['id'];
    $title = $rowsub['title'];  $jsname = jsdelname($title);
   $pidname = $rowsub['pidname'];$cus_columns = $rowsub['cus_columns'];

    $effect = $rowsub['effect']; $cssname = $rowsub['cssname'];

 
  $jumpvinsert = $jumpv.'&act=update&pidname='.$pidname;
}

if($act=='add' || $act=='edit'){
 // echo '<p>'.$pidname.'</p>';
 

?>

<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpvinsert; ?>" method="post" enctype="multipart/form-data">
<table class="formtab">
        <tr>
            <td width="12%" class="tr">音乐标题：</td>
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

$filedir = BLOCKROOT.'music/';
echo ' <select name="effect">';
select_from_filearr($filedir,$effect);
echo '</select>';


if($effect<>'') {
    $file =  BLOCKROOT.'music/'.$effect; 
    checkfile($file);
}

?>



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
