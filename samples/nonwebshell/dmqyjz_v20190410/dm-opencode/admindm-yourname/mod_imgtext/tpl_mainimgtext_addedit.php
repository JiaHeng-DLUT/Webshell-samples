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

    $ss = "update " . TABLE_IMGTEXT . " set title='$abc1',cssname='$abc2',fullwidth='$abc3',haswow='$abc4',effect='$abc5'   where pidname='$pidname'  $andlangbh limit 1";
        //echo $ss;exit;
        iquery($ss);
        jump($jumpvnopid.'&act=edit&pidname='.$pidname); 
   }
 


   if ($act == 'insert') { 
       $pidnamecur = 'imgtext' . $bshou;
       if ($abc1 == '')  { echo '请输入标题'; exit; }
 
   $ss = "insert into ".TABLE_IMGTEXT." (pid,pidname,pbh,lang,title,cssname,fullwidth,haswow,effect) values ('$pid','$pidnamecur','$user2510','".LANG."','$abc1','$abc2','$abc3','$abc4','$abc5')";
      // echo $ss;exit;
       iquery($ss);
         jump($jumpv);
   }




   if($act=='add'){

    $title=$kv=$despjj=$desp=$imgsmall2 =$effect=$cssname  ='';
    $fullwidth = $haswow = 'n';
    $jumpvinsert = $jumpv.'&act=insert';

    $titleh2 = '添加 ';


   }

 if($act=='edit'){
    $titleh2 = '修改 ';
 

    $rowsub = getrow($sqlsub);
    //pre($rowsub);
    $tid = $rowsub['id'];   $pidname = $rowsub['pidname']; $effect = $rowsub['effect'];
    $title = $rowsub['title'];   $cssname = $rowsub['cssname'];  
     $fullwidth = $rowsub['fullwidth']; $haswow = $rowsub['haswow'];

    
  $jumpvinsert = $jumpvnopid.'&act=update&pidname='.$pidname;
}

if($act=='add' || $act=='edit'){
 
 
?>

<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpvinsert; ?>" method="post" enctype="multipart/form-data">
<table class="formtab">
        <tr>
            <td width="12%" class="tr"> 标题：</td>
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
                <input name="cssname" type="text"  class="inputcss form-control" value="<?php echo $cssname; ?>"  /><?php echo $xz_maybe; ?>
                   
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
            <td   class="tr">开启wow动画</td>
            <td  > 
            <select name="haswow"> <?php select_from_arr($arr_yn,$haswow,'');?>
     </select>
              
            </td>
        </tr>

        <tr>
            <td width="12%" class="tr"> 效果文件：</td>
            <td width="88%">
                    <?php 
                   $filedir = BLOCKROOT.'imgtext/';
                    
                    if(is_dir($filedir))  {
                        $filearr = getFile($filedir);
                        if($filearr[0]=='')  $filearr = array('nofile'=>'无文件');
                    }
                    else $filearr = array('nofile'=>'无文件');
                      
                    echo  '<select name="effect">';
                    select_from_arr2($filearr,$effect,''); 
                    echo '</select>';
                    
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
