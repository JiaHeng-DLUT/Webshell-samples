<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?> 
<?php
if($act=="insert"){
  $ifwater=@htmlentitdm($_POST['water']);
  if($ifwater=='y') $up_water='y';
	 	else $up_water='n';
	//$sql = "SELECT id from $table_news_fj where pid='$pid' and pbh='".USERBH."' and lx='$catpid'  order by id desc";
     //   $num_rows = get_numrows($sql);
     //   if($num_rows>50){alert($chao_rec.'50');jump($jumptolist_fj);}
//----------------------
$i=1;
while($i<6){
/*********judge begin********************************************************************************/
$imgname=$_FILES["addr$i"]["name"] ;
 $imgsize=$_FILES["addr$i"]["size"] ;
if(!empty($imgname)){ //先judge if upload img ,if upload,then judge is update or add,if update,then delete old img.
/*******put initial value*************************************/
	$imgtype = gl_imgtype($imgname);

	 $up_w_s=$album_s_w; $up_h_s=$album_s_h;
	 if($up_w_s>600) $up_w_s=600;elseif($up_w_s<60) $up_w_s=60;
	 if($up_h_s>600) $up_h_s=600;elseif($up_h_s<60) $up_h_s=60;
	 
	$up_small='y';
  $up_add_s='y';
  $up_delbig='n';//$fo_bef,$fo_now is in top.

	 $imgsqlname =  '';
	//$up_water=p2030_waterjudge(); //$up_water should be judge in common.php
	require('../plugin/upload_img.php');

  /********************/
  $pidnamehere = 'salbum' . $bshou;
	$ss = "insert into ".TABLE_ALBUM." (pidname,pbh,pid,kvsm,size,type,lang) values ('$pidnamehere','$user2510','$pid','$return_v',$imgsize,'$type','".LANG."')";//no pos,because pos is auto,is to next and prev page
	iquery($ss);
		//echo $ss;exit;
}//end not empty
//else{alert('请选择图片');}
$i++;
}
//echo $jumpv;exit;
 jump($jumpvpid);



}//end insert
 
else{
?>
<form action="<?php echo $jumpv_file?>&act=insert" method="post" enctype="multipart/form-data">
    <table     border="0" align="left" cellpadding="6" cellspacing="10">

          <tr align="center">
            <td height="62" colspan="2"><strong>添加图片</strong></td>
          </tr>
          <tr>
            <td width="18%" align="right" > 图片1：</td>
            <td width=" " >
              <input name="addr1" type="file" id="addr1" class="form-control" /> &nbsp;（<font color="#0066FF">必填</font>）</td>
          </tr>
          <tr>
          <td width="10%" align="right" > 图片2：</td>
            <td  >  <input name="addr2" type="file" id="addr2" class="form-control" /> &nbsp;（<font color="#666">可不填</font>）</td>
          </tr>
          <tr>
          <td width="10%" align="right" > 图片3：</td>
            <td  >  <input name="addr3" type="file" id="addr3" class="form-control" /> </td>
          </tr>
          <tr>
          <td width="10%" align="right" > 图片4：</td>
            <td > <input name="addr4" type="file" id="addr4" class="form-control" /> </td>
          </tr>
          <tr>
          <td width="10%" align="right" > 图片5：</td>
            <td > <input name="addr5" type="file" id="addr5" class="form-control" /> &nbsp;</td>
          </tr>

           <tr>
            <td width="19" align="right"  > </td>
            <td >   <input type="checkbox" name="water" id="water"  value="y" checked="checked" size="10">
            <label for="water">加上水印</label>
             
            </td>
          </tr>


          <tr>
            <td height="33">&nbsp;</td>
            <td><p><br /><br />
                <input class="mysubmit" type="submit" name="Submit2" value="开始上传图片">
                <br>
                <br>
                <span class="cred">1、<?php echo $format_t;?><br>
                2、如果网速太慢，5张一起传，可能会慢点，这时可以两张或三张一起传。<br>
                 <br></span>
            </td>
          </tr>

      </table></form>
 

<?php }

?>

