<?php
/*  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
$mod_previ = 'normal';
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);


ifhave_lang(LANG);//TEST if have lang,if no ,then jump

$jumpv = '../mod_module/mod_uploadkvsm.php?lang='.LANG.'&pidname='.$pidname.'&type='.$type;

$title='上传kvsm图片';
if($type=='nodekvsm'){
   $table = TABLE_NODE; 
   $field = 'kvsm'; 
} 
elseif($type=='nodekvsm2'){
  $table = TABLE_NODE; 
  $field = 'kvsm2'; 
  $title='上传kvsm2图片';
} 
else{
  echo 'type error';
  exit;
}
$sm_w=$sm_h=300;
 
$imgsqlname = $imgv2 = $delimg = '';    
$sql = "SELECT $field,sta_orignimg,ppid from " . $table . "  where pidname='$pidname' $andlangbh order by id limit 1";
 
$row =getrow($sql);
if($row<>'no'){
      $imgsqlname  = $row[$field];  
      $ppid  = $row['ppid'];   
      $sta_orignimg  = $row['sta_orignimg']; 
        
      if($imgsqlname<>''){
          $imgv2 = p2030_imgyt($imgsqlname,'y','n'); //p2030_imgyt($addr,$w_h='y',$linkbig='n')
        //del(actgo2,pidname,backpage,title)
      $delimg= "<br /> <a href=javascript:del('delimg','$pidname','$jumpv','')  class='but2'>删除图片</a><br /> <br /> ";
      }

if($ppid<>'blockdh'){ //blocksh no sm,use default set at top.
    
$sql2="select list_can from ".TABLE_CATE." where pidname='$ppid' $andlangbh order by id limit 1";
 
      $row2=getrow($sql2);
 if($row2<>'no'){
      
  $arr_can = $row2['list_can'];
   // echo $arr_can;
    $bscntarr = explode('==#==',$arr_can); 
    if(count($bscntarr)>1){
      foreach ($bscntarr as   $bsvalue) {
       if(strpos($bsvalue, ':##')){
         $bsvaluearr = explode(':##',$bsvalue);
         $bsccc = $bsvaluearr[0];
         $$bsccc=$bsvaluearr[1];
       }
     }
   }
  }
  //------------
}


      $up_w_s=$sm_w;
      $up_h_s=$sm_h;
 

      if($up_w_s>600) $up_w_s=600;elseif($up_w_s<60) $up_w_s=60;
      if($up_h_s>600) $up_h_s=600;elseif($up_h_s<60) $up_h_s=60;
 


}
else {
  echo 'record error';
  exit;
}




if($act=="update"){

    //-----------
$ifwater=@htmlentitdm($_POST['water']);
if($ifwater=='y') $up_water='y';
else $up_water='n';
//-------------

  $imgname=$_FILES["addr"]["name"] ;
  $imgsize=$_FILES["addr"]["size"] ;
 
 if(!empty($imgname)){
   $imgtype = gl_imgtype($imgname);	
   
   //upload img    
   $up_add_s='n';//also in common.inc  
   $up_small='y';
   if($abc1=='y') $up_small='n';
   $up_delbig='n'; 
   $i='';
  
 
  require('../plugin/upload_img.php');//need get the return value,then upimg part turn to easy.
  $updateimgaddr=", $field='$return_v_s'";
  
          $ss = "update ".$table." set   sta_orignimg='$abc1' $updateimgaddr   where pidname='$pidname'  $andlangbh limit 1"; 
          // echo $ss;      
           iquery($ss);
           
  }//empty($imgname)
  else{
    alert('没有上传图片。');
  }
 
    jump($jumpv);

}
else if($act=='delimg'){		
    
       if($imgsqlname<>'') p2030_delimg($imgsqlname,'y','n');//p2030_delimg($addr,$delbig,$delsmall)	
     
       $ss = "update ".$table." set  $field=''   where pidname='$pidname' $andlangbh limit 1";     
      iquery($ss);
      jump($jumpv);
    } 

  else{
//-----------

require_once HERE_ROOT.'mod_common/tpl_header_iframe.php';

?>




<form   action="<?php echo $jumpv; ?>&act=update" method="post" enctype="multipart/form-data">
  <table class="formtab">
  <tr>
<td class="tr">使用原图：
<br /><span class="cgray">使用原图，则不改变图片的尺寸。</span>
 </td>
<td><select name="sta_orignimg">
      <?php select_from_arr($arr_yn,$sta_orignimg,'');?>
      
  </select>
  <br />
  缩略图： (宽：<?php echo $up_w_s;?>像素 | 高：<?php echo $up_h_s;?>像素 )
  </td>
</tr>

<tr><td class="tr" >

<?php
echo $title;
 
echo  '<br />'.$delimg;
 
?>

</td>
      <td>
      <input name="addr" type="file" class="form-control"  />
      <br />
      <?php
       echo '<br /><span class="cred">'.$format_t.'</span><br />'; 
       echo $imgv2;
      ?>
      </td>
    </tr>
  
<tr>
      <td> </td>
      <td> 
         <input type="checkbox" name="water" id="water"  value="y"   size="10"> <label for="water">加上水印</label>
       <div class="c5"> </div>
</td>
</tr> 

<tr>
      <td></td>
      <td>
      <input class="mysubmit" type="submit" name="Submit" value="提交" /></td>
    </tr> 
   
  

  </table>
</form>





 <?php
require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php';

?>

<?php 
  }
?>