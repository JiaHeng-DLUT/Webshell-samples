<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
 
<?php
 
if($act=="update"){
 // pre($_POST); 

  $ifwater=@htmlentitdm($_POST['water']);
  if($ifwater=='y') $up_water='y';
     else $up_water='n';
     
	$imgname=$_FILES["addr"]["name"] ;
	 $imgsize=$_FILES["addr"]["size"] ;
  
   $kv_v = '';

   //echo $up_water;exit;

	if(!empty($imgname)){
		$sql = "SELECT kvsm from ".TABLE_ALBUM." where pid='$pid' and type='$type' and id='$tid' $andlangbh   limit 1";
		$rowss = getrow($sql);
		$imgsqlname = 	$rowss['kvsm'];
		$imgtype = gl_imgtype($imgname);
		
		 $up_w_s=$album_s_w; $up_h_s=$album_s_h;
	 if($up_w_s>600) $up_w_s=600;elseif($up_w_s<60) $up_w_s=60;
	 if($up_h_s>600) $up_h_s=600;elseif($up_h_s<60) $up_h_s=60;
	 
		$up_small='y';
		$up_add_s='y';
		$up_delbig='n'; 
     $i='';

   
		require_once('../plugin/upload_img.php');//need get the return value,then upimg part turn to easy.
		
    $kv_v = ",kvsm = '$return_v'";

	}//end not empty		
				
  

 $desp=zbdesp_onlyinsert($_POST['desp']); 
 
			$ss = "update ".TABLE_ALBUM." set title='$abc1'$kv_v,desp='$desp' where pid='$pid' and type='$type' and id='$tid' $andlangbh  limit 1";
			 //echo $ss;exit;
			iquery($ss); 	
	// $jumpv_back = $jumpv_file.'&act=edit&tid='.$tid;
      //echo $jumpv_back;exit;
      $link =  $jumpv_file.'&tid='.$tid.'&act=edit';
		  jump($link);

}
else{
  $sql="select * from  ".TABLE_ALBUM."  where  pid='$pid' and type='$type' and id='$tid' $andlangbh order by id limit 1";
  //echo $sql;exit;
   $row = getrow($sql);
   
       $imgsqlname = $row['kvsm'];
	  // echo $imgsqlname;
$imgsmall = p2030_imgyt($imgsqlname,'n','y') ;
$formlink =  $jumpv_file.'&act=update&tid='.$tid;
 
   ?>
<div class="layoutsidebar fl col-xs-12 col-sm-12  col-md-2">
<?php 
 require_once HERE_ROOT.'mod_album/tpl_album_edit_sidebar.php';
 ?>
</div><!--end sidebar-->
<div class="fl col-xs-12 col-sm-12  col-md-10">
<form   action="<?php echo $formlink;?>" method="post" enctype="multipart/form-data">
  <table class="formtab">
    <tr>
      <td width="12%" align="right">图片名称(可不填)：</td>
      <td width="88%"> <input name="name" type="text" id="name" value="<?php echo $row['title']?>" class="form-control" />
      </td>
    </tr>
          <tr>
      <td align="right">图片说明内容（可不填）：</td>
      <td>
<textarea  class="form-control"  rows="8"  name="desp">
<?php  
echo  zbdespedit($row['desp']);
?>
</textarea>
</td>
    </tr>

  <tr>
      <td align="right">图片：</td>
      <td><input name="addr" type="file" class="form-control" />

      <?php
 echo '<br /><span class="cred">要修改的图片的扩展名必须一致。否则缩略图不会变化！<br />'.$format_t.'</span><br />';
   echo $imgsmall;
      ?>
      </td>
    </tr>

    <tr>
            <td   align="right"  >添加水印：</td>
            <td > 
            <input type="checkbox" name="water" id="water" value="y" checked="checked" size="10">
            <label for="water">加上水印</label>
             
            </td>
          </tr>

          <tr>
      <td></td>
      <td>
      <input class="mysubmit"  type="submit" name="Submit" value="修改" />
      </td>
    </tr>

  </table>
</form>

</div>
<div class="c"></div>

<?php }

?> 