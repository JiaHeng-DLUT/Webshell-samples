<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
 */
if (!defined('IN_DEMOSOSO')) {
    exit('this is wrong page,please back to homepage');
}
if ($act == 'update') {
  // pre($_POST);exit;
  if ($abc1 == '')  { echo '请输入标题'; exit; }
  if ($abc5 == '' &&  $abc6 == '')  { 
    alert('请在 iframe 或 mp4 框内输入视频地址。');
   
    jump($jumpvnopid.'&act=edit&pidname='.$pidname);

 }

 
     if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;} 
 
 //$despjj = zbdespadd2($abc5);   


       $sql = "SELECT kv from ".TABLE_VIDEO." where  pidname='$pidname' $andlangbh   limit 1";
        $row = getrow($sql);
        $imgsqlname =$row['kv'];  
                       
     $delimg = zbdesp_onlyinsert($_POST['delimg']);                            
    if($delimg=='y'){
        if($imgsqlname<>'') p2030_delimg($imgsqlname,'y','y');
        $kv_v = ",kv = ''";
    }
    else{
         $imgname = $_FILES["addr"]["name"];
       $imgsize = $_FILES["addr"]["size"];
       if (!empty($imgname)) {
      
            $up_small = 'n';           
           $imgtype = gl_imgtype($imgname);
          // $up_small = 'y';
           $up_delbig = 'n';//not del,just override
           $up_water = 'n';           
           $i = '';
           require_once('../plugin/upload_img.php'); //need get the return value,then upimg part turn to easy.
           $kv_v = ",kv = '$return_v'";
       }
       else  $kv_v = "";
     }






    $desp = zbdesp_onlyinsert($_POST['desp']); //note: desp and addr not use variable abc1.
    $despjj = zbdesp_onlyinsert($_POST['despjj']); 
   
  
        $ss = "update " . TABLE_VIDEO . " set title='$abc1',cssname='$abc2'  $kv_v,effect='$abc3',video='$abc6',desp='$desp',despjj='$despjj' where pidname = '$pidname'  $andlangbh limit 1"; 
        //echo $ss;exit;
        iquery($ss);  
       jump($jumpvnopid.'&act=edit&pidname='.$pidname);
   
 
   }


   if ($act == 'insert') {
 
       $pidnamecur = 'video' . $bshou; 
    
       if ($abc1 == '')  { echo '请输入标题'; exit; }

          
       if ($abc5 == '' &&  $abc6 == '')  { 
           alert('请在 iframe 或 mp4 框内输入视频地址。');
          
           $jumpv2 = $jumpv.'&tid='.$tid.'&act=add';
           jump($jumpv2);

        }
   
   
        if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}
       $desp = zbdesp_onlyinsert($_POST['desp']); //note: desp and addr not use variable abc1.
      // $desptext = zbdesp_onlyinsert($_POST['editor1text']);
   
       $despjj = zbdesp_onlyinsert($_POST['despjj']); 
   
   
     $imgname = $_FILES["addr"]["name"];
          $imgsize = $_FILES["addr"]["size"];
          if (!empty($imgname)) {
              //make thumb
             //  $sql = "SELECT sm_w,sm_h from ".TABLE_BLOCK." where pidname='$pidname'  $andlangbh   limit 1";
              //                $row = getrow($sql);
              //                $up_w_s =$row['sm_w'];$up_h_s =$row['sm_h'];   
                           //  echo $up_w_s.'-'.$up_h_s;
             // if( $up_w_s==0 ||  $up_h_s == 0) $up_small = 'n';
              //else $up_small = 'y';  
               
               $up_small = 'n';    
               $imgsqlname='';       
              $imgtype = gl_imgtype($imgname);
             // $up_small = 'y';
              $up_delbig = 'n';//not del,just override
              $up_water = 'n';           
              $i = '';
              require_once('../plugin/upload_img.php'); //need get the return value,then upimg part turn to easy.
              $kv_v = "$return_v";
          }
          else  $kv_v = "";
   
   
    
   /*
   Array
   (
       [title] => 
       [iscommon] => n
       [delimg] => 
       [videoaddress] => 
       [desp] => 
       [template] => default
       [Submit] => 提交
       [inputmust] => inputmust
   )
   */
   
   
   
   //pre($_POST);
   
         $ss = "insert into ".TABLE_VIDEO." (pid,type,pidname,pbh,lang,title,cssname,effect,kv,desp,despjj,video) values ('$pid','$type','$pidnamecur','$user2510','".LANG."','$abc1','$abc2','$abc3','$kv_v','$desp','$despjj','$abc6')";  
       // echo $ss;exit;
   
       iquery($ss);
   
        jump($jumpv);
  
   }

   


   if($act=='add'){
       
    $title=$kv=$despjj=$desp=$imgsmall2 =$effect=$cssname =$video ='';
   
    $jumpvinsert = $jumpv.'&act=insert';

    $titleh2 = '添加视频';


   }

 if($act=='edit'){
    $titleh2 = '修改视频';

 
    $tid = $rowsub['id'];
    $title = $rowsub['title'];  $jsname = jsdelname($title);
    $kv = $rowsub['kv'];$pidname = $rowsub['pidname'];
 
    $effect = $rowsub['effect']; $cssname = $rowsub['cssname']; 
    $video = $rowsub['video']; 
 
    $desp = zbdesp_imgpath($rowsub['desp']);
    $despjj = zbdesp_imgpath($rowsub['despjj']);
 
     $imgsmall2 = p2030_imgyt($kv, 'y', 'n'); 

  

  $jumpvinsert = $jumpvnopid.'&act=update&pidname='.$pidname;

 

}

if($act=='add' || $act=='edit'){
 // echo '<p>'.$pidname.'</p>';

?>
 
<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpvinsert; ?>" method="post" enctype="multipart/form-data">
<table class="formtab">
        <tr>
            <td width="12%" class="tr">视频标题：</td>
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

                <br />
                <span class="cgray">默认会给封面图片加上箭头，如果不需要，则可以加上 novideoarrow</span>
                 
            </td>
        </tr>


  <tr style="background:#dce8f4">
        <td class="tr fb">效果文件：</td>
        <td class="select--TOinput--">  
   
   
  
        <?php

$filedir = BLOCKROOT.'video/';
echo ' <select name="effect">';
select_from_filearr($filedir,$effect);
echo '</select>';
 

if($effect<>'') {
    $file =  BLOCKROOT.'video/'.$effect;      
     checkfile($file);
}
 
?>
 
</td>
    </tr>
 

 <tr>
    <td  class="tr">视频说明：</td>
    <td> 
  <textarea name="despjj" class="form-control" rows="3"><?php echo $despjj?></textarea><?php echo $xz_maybe;?>
   </td>
 </tr>


  

 <tr bgcolor="#DBF2FF">
            <td  class="tr">视频地址 - ifame形式：</td>
            <td  > 
  <textarea name="desp" class="form-control" rows="3"><?php echo $desp?></textarea><?php echo $xz_maybe;?>
  
<br />用ctrl+c复制 iframe测试代码：
<textarea class="form-control" rows="1" disabled="disabled"><iframe frameborder="0" width="640" height="498" src="https://v.qq.com/iframe/player.html?vid=b0537w8vdfu&tiny=0&auto=1" allowfullscreen></iframe>
</textarea>
<br /> 
   </td>
        </tr>


 <tr bgcolor="#DBF2FF">
            <td  class="tr">视频地址 - mp4形式：

            <p class="cred">(如果使用mp4，<br />则iframe形式在前台不起使用) </p>
            </td>
            <td  > 
            <input name="video" type="text"  class="form-control" value="<?php echo $video; ?>"  /> 

 
        <?php 
           if($video<>''){ 

                if(substr($video,0,4)=='http')  {
                    echo $video;
                }
                else {
                    $videoroot = STAROOT.'upload/video/'.$video;                    
                    if(!is_file($videoroot)){
                         echo '<br /><span class="cred"> DM-static/upload/video 目录不存在这个视频文件: '.$video.'</span>';
                        }
                }

           } 
         ?> 
   <p class="cgray" style="padding:30px 0">    
 mp4文件必须放在 <a class="needpopup"  href="../mod_module/mod_showfile_video.php?lang=<?php echo LANG?>"> DM-static/upload/video </a>目录下，然后这里只要输入文件名即可，比如 videoname.mp4 
 <br />或者使用远程的视频地址。
    </p> 
   </td>
  </tr>



        
        <tr>
            <td   class="tr">上传视频封面图图片：

            <br /> 
           <span class="cgray"> 默认是 DM-static/img/video.jpg </span>
            </td>
            <td  > <input name="addr" type="file" id="addr" class="form-control" /><?php echo $xz_maybe;?>  
<?php
echo '<br /><span class="cred">' . $format_t . '</span><br />';
// echo gl_showsmallimg($fo_bef,$imgsmall,'y');
echo $imgsmall2;
?>
             
          <?php  if($kv<>'') 
        {
              ?>
          <span class="cred"> <br />是否要删除图片？ </span>
          
          <select name="delimg">
          <?php select_from_arr($arr_yn,'n','');?>
          </select>
          <?php } 
          else{ //use for : Undefined index: delimg 
              ?>          
         <select name="delimg" style="display:none">
            <option value=""></option>
        </select>
          <?php
          }?>
                   
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