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
    <td width="20%" class="tr">头部风格：</td>
    <td style="padding: 5px">
       
      <?php 

$filedir = BLOCKROOT.'header/';
$filearr = getFile($filedir);

$filedirself = TPLCURROOT.'selfblock/header/';
//echo $filedirself;
if(is_dir($filedirself)) {
$filearr2 = getFile($filedirself);
$filearr = array_merge($filearr,$filearr2);
 }
//pre($filearr);
 
      //not use select_from_arr2($filearrnew1,$header_pc,'');...
      $selectjcgg = $header_pc == 'jcgg'?' selected= "selected" ':'';
      //$select1 = $select2 ='';
     // $select1 = $header_pc == 'usercurmb'?' selected= "selected" ':'';
        // $filedir = BLOCKROOT.'tpl/header/'; 
        echo '<select name="header_pc">';
        if($pid<>'common') echo ' <option '.$selectjcgg.' value="jcgg">继承公共布局的选择</option>';
        //select_from_filearr($filearr,$header_pc); 
        select_from_arr2($filearr,$header_pc,'');
      //  echo '<option '.$select1.' value="usercurmb">使用当前模板下的tpl/header_self.php</option>';
         
        echo '</select>'; 
    ?>
  <p style="color:gray">提示：菜单文件的输出 在头部文件代码里定义</p>
 </td>
    </tr>

 
  
    <tr>
      <td   class="tr"> 皮肤css：  </td>
      <td style="padding:5px">
      <?php 
          $selectjcgg = $skincss == 'jcgg'?' selected= "selected" ':'';
         
          $filedir =  STAROOT.'assets/skincss/';  
          $filearr = getFile($filedir);
          
          $filedirself = TPLCURROOT.'skincss/';
          //echo $filedirself;
          if(is_dir($filedirself)) {
          $filearr2 = getFile($filedirself);
          $filearr = array_merge($filearr,$filearr2);
           }
             
        echo '<select name="skincss">';   
        if($pid<>'common') echo ' <option '.$selectjcgg.' value="jcgg">继承公共布局的选择</option>';    
        // select_from_filearr($filedir,$skincss); 
        select_from_arr2($filearr,$skincss,'');
       //  echo '<option '.$select1.'  value="">不选 (则要在当前模板的样式文件里写相关皮肤css)</option>';
        echo '</select>'; 
    ?>
      </td>
    </tr>
 
    <tr>
      <td   class="tr">选择菜单：</td>
      <td style="padding:5px">
      <select name="pidmenu" class="form-control">
         <?php 
         $selectjcgg = $pidmenu == 'jcgg'?' selected= "selected" ':'';
         if($pid<>'common') echo ' <option '.$selectjcgg.'  value="jcgg">继承公共布局的选择</option>';
         ?>
        
          <?php
   $sqltextlist = "SELECT * from ".TABLE_MENU." where   $noandlangbh and ppid='0'  and sta_visible='y'   order by pos desc, id ";
   if(getnum($sqltextlist)>0){
     $res = getall($sqltextlist);

       foreach($res as $v){
        $pidname22 = $v['pidname'];
        if($pidname22 == $pidmenu) $selected = ' selected ';
        else  $selected = '';
         echo '<option '.$selected.' value="'.$pidname22.'">'.$v['name'].'</option>';

       }
      }


     ?>
     </select>
      </td>
    </tr>

 <tr>
    <td width="20%" class="tr"><strong>banner</strong></td>
    <td>
    <strong>banner的css名称：</strong> <input  name="bannercssname" type="text" value="<?php echo $bannercssname?>" size="30" />
     <?php echo $xz_maybe; ?>

     <span class="cgray">试下：  bannerhgshort 或 bannerhgtall 或 container (窄屏)</span>

    <div class="c5"> </div>

    <div style="border-top:1px solid #ccc;border-bottom:1px solid #ccc;padding:3px;margin:3px;">
    <strong>标识： </strong>

 <div class="c5"> </div>
     pc端：<input  name="banner" type="text" value="<?php echo $banner?>" size="30" />
     <?php echo $xz_maybe;
    echo check_blockid($banner);
    ?>

  <div class="c5"> </div>
    移动端： <input  name="bannermobi" type="text" value="<?php echo $bannermobi?>" size="30" />
     <?php echo $xz_maybe;
    echo check_blockid($bannermobi);
    ?>


  </div>




<div class="c5"> </div>
    <strong>banner的效果文件：</strong>
<?php

$type = 'banner';
$filedir = BLOCKROOT.$type.'/';
$filearr = getFile($filedir);

$filedirself = TPLCURROOT.'selfblock/'.$type.'/';
//echo $filedirself;
if(is_dir($filedirself)) {
$filearr2 = getFile($filedirself);
$filearr = array_merge($filearr,$filearr2);
 }

echo  '<select name="bannereffect">';
select_from_arr2($filearr,$bannereffect,'');

echo '</select>';



?>


<div style="padding:10px;background:#e9f0f7">
<strong>以下内容仅在效果文件为 banner_bg.php时 才会在前台起作用。</strong>
<div class="c5"> </div>
<strong>banner文字：</strong>  <span class="cgray">(支持style)</span>
 <textarea  class="form-control" row="10" name="bannertext" ><?php echo $bannertext?></textarea>
     <?php echo $xz_maybe; ?>

     <div class="c5"> </div>
<strong>banner文学的样式：</strong>
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
    <?php 
    if($sidebarposi=='') $sidebarposi = 'l';
     select_from_arr($arr_column,$sidebarposi,'plsno');?>
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
  <br /><?php echo check_blockid($contentheader);?>
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
<input name="pagetemplate" type="text"  value="<?php echo $pagetemplate;?>" size="30" /> <?php echo $xz_maybe;?>
<p class="cgray">位于当前模板 <?php echo HTMLDIR?>/tpl/page或位于DM-block/tpl/page目录下</p>
 <?php


if($pagetemplate<>'') {
  $file =  TPLCURROOT.'tpl/page/'.$pagetemplate.'.php';
  if(!is_file($file))  $file = BLOCKROOT.'tpl/page/'.$pagetemplate.'.php';
  if(checkfile($file)) echo '文件：......'.substr($file,12);
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
