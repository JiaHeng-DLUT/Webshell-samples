<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

?>


<?php 
 

if($act == "update"){

 
$ss = "update ".TABLE_PAGE." set album='$abc1',albumcssname='$abc2',albumposi='$abc3'  where id='$tid' $andlangbh limit 1";
  //echo $ss;exit;
iquery($ss); 

 jump($jumpv_back);
}



if($act=="edit"){ 
$album =  $row['album'];
$albumposi =  $row['albumposi'];
$albumcssname =  $row['albumcssname'];

    ?>
 
<form  onsubmit="javascript:return menupageadd(this)" action="<?php  echo $jumpv_file.'&act=update';?>" method="post" enctype="multipart/form-data">
<table class="formtab">

 

 <tr>
      <td class="tr">相册模板：</td>
      <td><select name="selxeal2abm">
    <?php select_from_arr($arr_album,$album,'');?>
     </select>
<br />
   <span class="cgray"> （后面表示所在文件的位置,在 component/effect 下面。）    </span>

   
        </td>
    </tr>
  
 
      <tr>
      <td width="22%" class="tr"><?php echo $text_cssname; ?></td>
      <td width="77%"> <input name="albumcssname" class="inputcss form-control"  type="text" value="<?php echo $albumcssname?>" />
      <?php echo $xz_maybe; ?> 
         <br />
      <span class="cgray">（参考：  gridbigimg ）  </span>
       
       
          </td>
    </tr>
   <tr>
      <td width="22%" class="tr">相册位置：</td>
      <td width="77%">
位于内容的下面：
<select name="albumposi">
    <?php select_from_arr($arr_yn,$albumposi,'');?>
     </select>
<br />
      <span class="cgray">(默认相册位于内容的下面，否则位于内容的上面。)
 
       </td>
    </tr>

 
  <tr>
    <td></td>
    <td> <input class="mysubmit" type="submit" name="Submit" value="提交">
 
  </td>
  </tr>
 </table>


</form>
    <?php
 
}
  
 ?> 

 