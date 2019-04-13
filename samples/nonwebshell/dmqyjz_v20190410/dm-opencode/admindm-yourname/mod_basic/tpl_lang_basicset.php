<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}
?>
<?php
$jump_back = $jumpv_file.'&act=edit&tid='.$tid;

if($act=="update"){  


    if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

  //pre($_POST); exit;

  //  $imgfolder = UPLOADROOTIMAGE.$abc2;
   
  // if(!is_dir($imgfolder)) {
    
  //   alert('出错，图片目录 '.$imgfolder.'不存在！');  jump($jump_back);  
  //   }




$arrcanexcerpt =  array("sitename", "water","imgfolder");  

    $bscnt22 = '';
  if(count($_POST)>1){
          foreach ($_POST as  $k=>$v) {
             if(strtolower($k)=='submit') break;
            if(in_array($k,$arrcanexcerpt))   continue;

            $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
             
          }
      }
       $bscnt22 = substr($bscnt22,0,-5);

  
  $ss = "update ".TABLE_LANG." set sitename='$abc1',water='$abc2',arr_basicset='$bscnt22' where id='$tid' limit 1";
  // echo $ss;exit;
iquery($ss);
 //alert("修改成功");

 jump($jump_back);                      
}
   
 
if($act=='edit') {  
 $sql = "SELECT sitename,water,arr_basicset from ".TABLE_LANG."  where  id='$tid' and pbh='".USERBH."'    order by id limit 1"; 
$row = getrow($sql); 

$arr_can = $row['arr_basicset'];
$sitename = $row['sitename'];
$water = $row['water'];
$cdnurl=$searcherror = '';
$waterposi='y';
$waterpercent = 30;
$tagmaxline = 20;

 
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



$jump_update=$jumpv_file.'&act=update&tid='.$tid;
     
     
?>
 
 
 <form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jump_update;?>" method="post">
  <table class="formtab">
  

 <tr>
      <td class="tr">网站名称：</td>
      <td> 
      
       <input  type="text"  class="form-control"  name="sitename" value="<?php echo $sitename;?>"  ><?php echo $xz_must;?>
        </td>
    </tr>

  

  <tr>
      <td class="tr"> 水印图片：</td>
      <td>  <input  type="text" name="water"   size="30" value="<?php echo $water;?>"  /><?php echo $xz_maybe;?>
         <br /> (请输入名称附件，水印图片不需要透明，代码会自动产生半透明效果。)
       <br />
       <?php 
          if($water<>'')  echo  check_blockid($water);      
      ?>
       
       <div class="c5"> </div>
       水印位置是否居中：
       <select name="waterposi">
    <?php      
    select_from_arr($arr_yn,$waterposi,'');?>
     </select>

       <span  class="cgray">如果不居中，则位于右下角。</span>
       <div class="c5"> </div>
      水印透明度： <input  type="text" name="waterpercent"   size="10" value="<?php echo $waterpercent;?>"  >
      <span  class="cgray">1-100间的数字，默认为30</span>

        </td>
    </tr>
    
    
  <tr>
      <td class="tr">请选择编辑器：</td>
      <td> 
      <select name="editor" class="form-control">
    <?php select_from_arr($arr_editor,$editor,'');?>
     </select>
          <br /><span class="cgray">如果选择其他编辑器，需要下载相关文件，
<?php 
        echo admlink('',$dmlink_editor,'具体请看教程');
     ?>
           
 </td>
    </tr>



    <tr>
      <td class="tr">CDN网址：</td>
      <td>  <input  type="text" name="cdnurl"  size="30"    value="<?php echo $cdnurl;?>" ><?php echo $xz_maybe;?>
    <?php 
    if($cdnurl<>'') echo '<br />'.$cdnurl;
    ?>
   </td>
    </tr>

    <tr>
      <td class="tr">ico图片：</td>
      <td>  <input  type="text" name="ico"  size="30"    value="<?php echo $ico;?>" ><?php echo $xz_must;?>
     <?php 
     if($ico<>'')  echo  check_blockid($ico);
      
     ?>
   </td>
    </tr> 
      <tr>
      <td class="tr">前台是否开启编辑功能：</td>
      <td>  <select name="sta_frontedit" class="form-control">
    <?php select_from_arr($arr_yn,$sta_frontedit,'');?>
     </select>
       <?php 
        echo admlink('',$dmlink_frontedit,'什么是前台编辑');
     ?>
       
   </td>
    </tr> 
      <tr>
      <td class="tr">样式缓存：</td>
      <td>  <input  type="text" name="cssversion" size="30"     value="<?php echo $cssversion;?>" >
        <br /><span class="cgray">随便填个数字，和上一次不一样即可。
<br />
如果设置为0，则前台不加缓存版本号。当开发测试css或js时，可能要按ctrl+f5清缓存。
        </span>
   </td>
    </tr> 


 
  <tr>
      <td class="tr">开启标签：
      <br />
      <span class="cgray">在相关的分类里 开启 标签功能</span>
      </td>
      <td> 

     
    <div class="c5"> </div>
     字样：<input name="tag_title" type="text"  value="<?php echo $tag_title;?>" size="20">
    
   <div class="c5"> </div>
   效果： 

  <?php

$filedir = BLOCKROOT.'/tag/';

$filearr = getFile($filedir);

$filedirself = TPLCURROOT.'selfblock/tag/';
//echo $filedirself;
if(is_dir($filedirself)) {
$filearr2 = getFile($filedirself);
$filearr = array_merge($filearr,$filearr2);
 }

echo ' <select name="tag_fg">'; 
select_from_arr2($filearr,$tag_fg,'');
echo '</select>';
 
  //---------
  if(substr($tag_fg,0,5)=='self_')   $file =  TPLCURROOT.'selfblock/tag/'.$tag_fg;
  else  $file =  BLOCKROOT.'tag/'.$tag_fg;

// echo '<br />效果文件：';
 checkfile($file) ;

 
 
 
?>
 


 <div class="c5"> </div>
   显示个数：<select name="sta_tag_shownum">
    <?php  
    select_from_arr($arr_yn,$sta_tag_shownum,'');?>
     </select>
     <div class="c5"> </div>
 每页记录数：<input name="tagmaxline" type="text"  value="<?php echo (int)$tagmaxline;?>" size="10">
    

        </td>
    </tr>
 

  <tr>
    <td class="tr">前台关闭移动端自适应功能：</td>
    <td> 
   <select name="sta_colseresponsive">
  <?php   
  select_from_arr($arr_yn,$sta_colseresponsive,'');?>
   </select>
<?php 
if($sta_colseresponsive=='y') {
echo '<span class="cred">已关闭</span><br/>';
}

?>
 <div class="c5"> </div>
<span class="cgray">如果关闭，则前台不支持移动端。 </span>
  </td>
  </tr>



  <tr>
      <td class="tr"> 移动端网址：</td>
      <td>  
<input name="linkofmobile" type="text"   value="<?php echo $linkofmobile;?>" size="35">
  <br /> <span class="cgray">必须以 http开头，比如http://m.sohu.com。如果没有，请留空。 </span>


        </td>
    </tr>

    <tr>
      <td class="tr"> 搜索框的文字：</td>
      <td>  
      提示报错文字：<input name="searcherror" type="text"  value="<?php echo $searcherror;?>" size="35">
      <div class="c5"> </div>
     默认关键字：<input name="searchtext" type="text"  value="<?php echo $searchtext;?>" size="35">

        </td>
    </tr>
   
<tr>
      <td></td>
      <td>
      <br /> <br />
      <input  class="mysubmit" type="submit" name="Submit" value="提交">
       <br />

        <br />
        </td>
    </tr>
  </table>

  <?php echo $inputmust;?>

</form>
 
  
<?php } ?>
 
<script>
function  checkhere(thisForm){
   
    if ($.trim(thisForm.sitename.value)==""){
    alert("请输入网站名称");
    thisForm.sitename.focus();
    return (false);
        } 
    
    
}

</script>

