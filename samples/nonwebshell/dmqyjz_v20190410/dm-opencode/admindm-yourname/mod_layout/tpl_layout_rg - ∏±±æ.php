<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
//-------------
 if($act=="update"){
   // pre($_POST);
     if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

    // $bannertext = zbdesp_onlyinsert($_POST['bannertext']);
 
   // $arrcanexcerpt =  array("bannertext");  //move top line
    

    $bscnt22 = '';
    if(count($_POST)>1){
            foreach ($_POST as  $k=>$v) {
               if(strtolower($k)=='submit') break;
              //if(in_array($k,$arrcanexcerpt))   continue;
  
              $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
               
            }
        }
         $bscnt22 = substr($bscnt22,0,-5);

//--------------------------

  		 $ss = "update ".TABLE_LAYOUT." set layoutcan='$bscnt22' where id='$tid' and type='$type' and pid='$pid' and pidstylebh='$curstyle' $andlangbh limit 1";
		     // echo $ss;exit;
			 iquery($ss);   
       $jumpv = 	$jumpv.'&type='.$type.'&pid='.$pid.'&catid='.$catid;
			 jump($jumpv);
	 	
		
 }
 
 


else{ 
  
 $jumpv_update_buju = $jumpv.'&act=update&type='.$type.'&pid='.$pid.'&catid='.$catid.'&tid='.$tid;
 
 
 ?>

 
<div><?php 
echo $title2;
if($pid<>'common'){ //only csub can del fg...
  $jsname = jsdelname($title2);
  $jumpv2 = $jumpv.'&pid='.$pid.'&catid='.$catid.'&type='.$type;
  $del_text= " <a href=javascript:del('del','$pid','$jumpv2','$jsname')  class=but2><i class='fa fa-trash-o'></i> 删除布局</a>";
  echo $del_text;
  }

?></div>
 
<form   action="<?php  echo $jumpv_update_buju;?>"   method="post" enctype="multipart/form-data">
<table class="formtab">

 <tr>
    <td width="20%" class="tr"><b>banner</b></td>
    <td>
    <strong>banner的css名称：</strong> <input  name="bannercssname" type="text" value="<?php echo $bannercssname?>" size="30" />
     <?php echo $xz_maybe; ?>

     <span class="cgray">试下：  bannerhgshort 或 bannerhgtall 或 container (窄屏)</span> 

    <div class="c5"> </div> 
    
    <strong>标识： </strong> <input  name="banner" type="text" value="<?php echo $banner?>" size="30" />
     <?php echo $xz_maybe;
   
    echo check_blockid($banner);?>



<div class="c5"> </div> 
    <strong>banner的效果文件：</strong>
<?php
    $filedir = BLOCKROOT.'banner/'; 
  echo '<select name="bannereffect">';
   select_from_filearr($filedir,$bannereffect); 
  echo '</select>';

   $filename =  'banner/'.$bannereffect;    
  $file = BLOCKROOT.$filename;
  echo '<br />效果文件：';
  admcheckfile($file,$filename);

?>


<div style="padding:10px;background:#e9f0f7">
<strong>以下内容仅在效果文件为 banner_bg.php时 才会在前台起作用。</strong>
<div class="c5"> </div>
<strong>banner说明：</strong>  <span class="cgray">(支持style)</span>
 <textarea  class="form-control" row="10" name="bannertext" ><?php echo $bannertext?></textarea> 
     <?php echo $xz_maybe; ?>
 
     <div class="c5"> </div>
<strong>banner说明的样式：</strong> 
<input  name="bannertextstyle" type="text" value="<?php echo $bannertextstyle?>" size="30" />
     <?php echo $xz_maybe; ?> <span class="cgray">(试下： color:red )</span>


<div class="c5"> </div>
<strong>banner背景色：</strong> 
<input  name="bannerbg" type="text" value="<?php echo $bannerbg?>" size="30" />
     <?php echo $xz_maybe; ?> <?php spancolor($bannerbg);?>
 
</div>

    </td>

  </tr>
 






 <tr>
    <td  class="tc" style="background:#2480C4;color:#fff" colspan="2"> 下面的选项会采用继承</td>

  </tr>


  <tr>
    <td  class="tr">面包屑：</td>
    <td  style="background:#DBF2FF">

  <strong>  面包屑的位置： </strong> 
<select name="breadposi">
	  <?php select_from_arr($arr_bread,$breadposi,'plsno');?>
     </select>
       
     <div style="margin:6px 0;border-bottom:1px solid #999"></div>
<strong>自定义面包屑：</strong>
<br /><textarea class="form-control" row="10" name="breadtext">
<?php echo $breadtext;?>
</textarea>
     <br /> <?php echo $xz_maybe;?>
 

      </td>
  </tr>
  
   <tr> 
    <td   class="tr">设置侧边栏菜单：</td>
    <td   style="background:#fff">
 
<select name="sidebarposi">
    <?php select_from_arr($arr_column,$sidebarposi,'plsno');?>
     </select>  
 
      </td>
  </tr>



 <tr> 
    <td   class="tr">侧边栏标识：</td>
    <td   style="background:#fff">
 
	 
<strong>侧边栏标识--上面：</strong>
 <input name="sidebartop" type="text" value="<?php echo $sidebartop;?>" size="30" />
      <?php echo $xz_maybe;?> <?php echo check_blockid($sidebartop);?>
<div class="c5"></div>
   
<strong>默认侧边栏菜单：</strong>&nbsp;&nbsp;&nbsp;
<input name="sidebar" type="text" value="<?php echo $sidebar?>" size="30" />
      <?php echo $xz_maybe;?>
     <span class="cgray"> (默认有侧边栏,若要隐藏请填：hide) </span>
      <?php echo check_blockid($sidebar);?>
<div class="c5"></div>

<strong>侧边栏标识--下面：</strong> <input name="sidebarbot" type="text" value="<?php echo $sidebarbot;?>" size="30" />
      <?php echo $xz_maybe;?> <?php echo check_blockid($sidebarbot);?>
 


      </td>
  </tr>

<tr>
    <td   class="tr">内容区标识：</td>
    <td   style="background:#d5e5f6">

  <strong>内容导航标题的标识：</strong>&nbsp;&nbsp;<input name="contentheader" type="text"  value="<?php echo $contentheader;?>" size="30" /> <?php echo $xz_maybe;?>
  <br /><span class="cgray"> (默认是文字，如果隐藏，用 hide ， 如果是图片，请用名称附件。)</span>

<br /><br />
   
   <strong>内容区标识--上面：  </strong><input name="contenttop" type="text"  value="<?php echo $contenttop;?>" size="30" /> <?php echo $xz_maybe;?> &nbsp; &nbsp;  <?php echo check_blockid($contenttop);?>

<div class="c15"></div>

<strong>默认内容：</strong> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="content" type="text"  value="<?php echo $content;?>" size="30" /> <?php echo $xz_maybe;?>
 <span class="cgray">(默认为列表和详细内容。 若要隐藏请填：hide) </span> 
 <?php echo check_blockid($content);?>

<div class="c15"></div>
 <strong>内容区标识--下面：</strong><input name="contentbot" type="text"  value="<?php echo $contentbot;?>" size="30" /> <?php echo $xz_maybe;?> <?php echo check_blockid($contentbot);?>

      </td>
  </tr>
  
  
   <tr>
    <td   class="tr">其他标识：</td>
    <td   style="background:#DBF2FF">
<strong>页面上部：</strong> <input name="pagetop" type="text"  value="<?php echo $pagetop;?>" size="30" /> <?php echo $xz_maybe;?> &nbsp;
<?php echo check_blockid($pagetop);?>

<div class="c15"></div>
<strong>页面底部：</strong> <input name="pagebot" type="text"  value="<?php echo $pagebot;?>" size="30" /> <?php echo $xz_maybe;?> &nbsp;
 <?php echo check_blockid($pagebot);?>

  </td>
  </tr>

  <tr>
    <td   class="tr">模板文件：</td>
    <td >
 
 <p class="cgray">位于当前模板目录<?php echo HTMLDIR;?>/tpl/page(如果没有，则请创建)，用于取代默认前台显示的模板</p>
 <?php


$filedir = TPLCURROOTADMIN.'tpl/page/'; 
if(is_dir($filedir))  {
  $filearr = getFile($filedir);

//$filedir = BLOCKROOT.$type.'/';
//$filedirself = TPLCURROOTADMIN.'mbblock/'.$type.'/';
echo  '<select name="pagetemplate">';
select_from_arr2($filearr,$pagetemplate,'pls');
//select_from_filearr($filedir,$template);
//select_from_filearr2($filedir,$filedirself,$template);
echo '</select>';


}
else {
  echo  '<p>暂无文件。</p>';

}



if($pagetemplate<>'') {
  $filename =  HTMLDIR.'/tpl/page/'.$pagetemplate;
  $file = TEMPLATEROOT.$filename;
  echo '<br />';
  admcheckfile($file,$filename);
}



?>

  </td>
  </tr>

  <tr>
    <td></td>
    <td> <input class="mysubmit mysubmitbig" type="submit" name="Submit" value="提交">
  
  </td>
  </tr>
 </table>

   <?php echo $inputmust;?>

</form>
 

<?php } 
?>