<?php
/*
  power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

$jumpv_insert = $jumpv.'&act=insert';
//-----------

if($act=='insert'){
  $imgname=$_FILES["addr"]["name"] ;
   $imgsize=$_FILES["addr"]["size"] ;

    $pidname = 'smusic'.date("Ymd_His"); //music address...
  
  $return_v = '';

  if(empty($imgname) && $abc2==''){
     alert('请输入音乐地址或上传音乐。');
     jump($jumpv_file.'&act=add');
  }

  if(!empty($imgname)){

      $filedir = STAROOT.'upload/music/';
      $imgtype = gl_imgtype($imgname);
      if($imgtype=='mp3'){

       $return_v = date("Ymd_His").'_'.rand(1000,9999).'.'.$imgtype;  
   
            $kv_v = $filedir.$return_v; 
        move_uploaded_file($_FILES["addr"]["tmp_name"],$kv_v);
       
      }
      else{
        alert('文件扩展名必须是mp3');
        jump($jumpv_file.'&act=add');
      }
     

  }//end not empty
    
  $ss = "insert into ".TABLE_MUSIC." (pidname,pbh,pid,type,lang,title,kv,kvlink,size) values ('$pidname','$user2510','$pid','$type','".LANG."','$abc1','$return_v','$abc2',$imgsize)";
      //echo $ss;exit;
    iquery($ss);
    //alert("添加成功");

   jump($jumpvpid);  


}//end insert
 
if($act=='update'){

     if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}


   $sql = "SELECT kv from ".TABLE_MUSIC." where  pid='$pid' and type='$type' and id='$tid' $andlangbh   limit 1";
        $row = getrow($sql);
        $kv =$row['kv'];  


  $filedir = STAROOT.'upload/music/';

     $delimg = zbdesp_onlyinsert($_POST['delimg']);                            
    if($delimg=='y'){
        $filevvv = $filedir.$kv;
        unlinkdm($filevvv);
        
        $sqleditkv = ",kv = '' ";

    }
    else{


     $imgname=$_FILES["addr"]["name"] ;
   $imgsize=$_FILES["addr"]["size"] ;

    $pidname = 'muadr'.date("Ymd_His"); //music address...
  
 
    $sqleditkv ='';
  if(!empty($imgname)){

      
      $imgtype = gl_imgtype($imgname);
      if($imgtype=='mp3'){

       $return_v = date("Ymd_His").'_'.rand(1000,9999).'.'.$imgtype;  
   
            $kv_v = $filedir.$return_v; 
        move_uploaded_file($_FILES["addr"]["tmp_name"],$kv_v);

        $sqleditkv = ",kv = '$return_v' ";
       
      }
      else{
        alert('文件扩展名必须是mp3');
        jump($jumpv_file.'&act=edit&tid='.$tid);
      }
     

  }//end not empty
}
    
     $ss = "update " . TABLE_MUSIC . " set title='$abc1',kvlink='$abc2'$sqleditkv where pid='$pid' and type='$type' and id='$tid' $andlangbh limit 1";  
     // echo $ss;exit;
    iquery($ss);    
     jump($jumpv_file.'&act=edit&tid='.$tid);
}

if($act=='add'){
  
 $title = '';
 $kv = '';
 $kvlink = '';
 $subtitle ='添加';
 $submitv = $jumpv_file.'&act=insert';

}


if($act=='edit'){

    $title = $rowsub['title'];
    $kv = $rowsub['kv'];
    $kvlink = $rowsub['kvlink'];
 

  $subtitle ='修改';
  $submitv = $jumpv_file.'&tid='.$tid.'&act=update';
 
 
                 
}



?>

<?php 
if($act=='add' || $act=='edit')
{

?>
 
 <form  onsubmit="javascript:return checkhere(this)" action="<?php echo $submitv; ?>" method="post" enctype="multipart/form-data">
    <table class="formtab">
        <tr>
            <td width="12%" class="tr">标题：</td>
            <td width="88%"> <input type="text"   name="title"  value="<?php echo $title;?>" size="50" /> 
            </td>
         </tr>

    <tr>
            <td   class="tr">输入地址：
 
            </td>
            <td> <input type="text"   name="kvlink"  value="<?php echo $kvlink;?>" size="50" /> 


            <?php 
             $musicaddr = STAPATH.'upload/music/';

              if(substr($kvlink,0,4)=='http') $kvlinkv = $kvlink;
              else $kvlinkv = $musicaddr.$kvlink;

              echo '<p><a href="'.$kvlinkv.'" target="_blank">'.$kvlink.'</a></p>';

?>
      
      <p style="color:#999">
            可以是外链,如： http://dream.demososo.com/music.mp3
<br />
            或者ftp上传，如果是ftp上传 ，必须在 <a class="needpopup"  href="../mod_module/mod_showfile_music.php?lang=<?php echo LANG?>">DM-static/upload/music目录下 </a>。

             </p>

            </td>
         </tr>

        <tr>
            <td   class="tr">上传音乐：
 
  
 </td>
            <td>
             <input type="file"  id="addr" name="addr"   />
           
           <?php  if($kv<>'')   {
               
        
         $musicaroot = STAROOT.'upload/music/'.$kv;
           if(!is_file($musicaroot))  echo '<p class="cred">音乐文件 '.$kv.' 不存在。</p>'; 
           else echo '<p><a href="'.$musicaddr.$kv.'" target="_blank">'.$kv.'</a></p>';
        
          ?>
           <span class="cred"> <br />是否要删除音乐？ </span>
                  
                  <select name="delimg">
                    <?php select_from_arr($arr_yn,'n','');?>
                </select>
          <?php
        }
          else{ //use for : Undefined index: delimg 
              ?>          
                 <select name="delimg" style="display:none">
                      <option value=""></option>
                </select>
          <?php
          }
       
          ?>

 

            <p style="color:#999">
             提示： 如果上面输入地址有值，则这里上传的音乐在前台不起作用。
             </p>

            </td>
         </tr> 


 <tr>
            <td   class="tr"> </td>
            <td>
            <br /><br /> 
              <input class="mysubmit" type="submit" name="Submit" value="<?php echo $subtitle;?>" />
            </td>
         </tr> 

    <?php echo $inputmust;?>

</table>
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


 
<?php  } ?>



 
