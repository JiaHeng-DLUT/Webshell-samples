
<form  onsubmit="javascript:return checkhere(this)" action="<?php  echo $jump_insertupdatesub;?>" method="post" enctype="multipart/form-data">
<table class="formtab">


 <tr   style="background:#fbfaf4">
    <td class="tr">产品详情页显示价格等信息：
    </td>
    <td>
    <select name="shop_price">
    <?php  
    select_from_arr($arr_yn,$shop_price,'');?>
     </select>

     </td>
  </tr>

    <tr>
      <td class="tr">表单区块：</td>
      <td>  <input name="formblockid" type="text"  value="<?php echo $formblockid;?>" size="30" />
 <?php 
 if($formblockid<>'')  echo check_blockid($formblockid);
 ?>
     </td>
    </tr>



  <tr>
    <td class="tr">发布信息：
    <?php echo $xz_maybe;
 
    ?>
    </td>
    <td>
  作者： <input name="authorcate" type="text"  value="<?php echo $authorcate;?>" size="30" /> 
 <div class="c5"> </div>
  发布来源：<input name="authorcompanycate" type="text"  value="<?php echo $authorcompanycate;?>" size="30" />
   <div class="c5"> </div>
  发布日期：<input name="authordatecate" type="text"  value="<?php echo $authordatecate;?>" size="30" />
   <div class="c5"> </div>
  阅读数：<input name="authorhitcate" type="text"  value="<?php echo $authorhitcate;?>" size="30" />
<br /><span class="cgray">发布信息的值为hide，则在前台不显示</span>
     </td>
  </tr>


      <tr>
    <td class="tr">一些值：
    <?php echo $xz_maybe;?>
    </td>
    <td>
  

    内容标题的字样:<input name="news_title" type="text"  value="<?php echo $news_title;?>" size="30"> 
   <div class="c5"> </div>
   内容参数标题的字样:<input name="can_title" type="text"  value="<?php echo $can_title;?>" size="30"> 
   <div class="c5"> </div>
    资料下载的字样:<input name="download_title" type="text"  value="<?php echo $download_title;?>" size="30"> 
    <div class="c5"> </div>
    查看全文的字样:<input name="news_moretitle" type="text"  value="<?php echo $news_moretitle;?>" size="30"> 

 <div class="c5"> </div>
    显示字体增减:
     <select name="sta_fontsize">
    <?php select_from_arr($arr_yn,$sta_fontsize,'');?>
     </select>

     <div class="c5"> </div>
    显示社交分享按钮:
   <select name="sta_sharebtn">
    <?php select_from_arr($arr_yn,$sta_sharebtn,'');?>
     </select>
     </td>
  </tr>

 

  <tr>
      <td class="tr">开启标签：</td>
      <td><select name="sta_tag">
    <?php 
 
    select_from_arr($arr_yn,$sta_tag,'');?>
     </select>
     <br />

    <span class="cgray">标签其他设置在 网站设置</span>

        </td>
    </tr>

    <tr>
      <td class="tr">上一页/下一页：</td>
      <td> 
    
    
    <?php
// $nextprev='';
$filedir = BLOCKROOT.'/nextprev/'; 
$filearr = getFile($filedir);

$filedirself = TPLCURROOT.'selfblock/nextprev';
//echo $filedirself;
if(is_dir($filedirself)) {
$filearr2 = getFile($filedirself);
$filearr = array_merge($filearr,$filearr2);
 }
 

echo ' <select name="nextprev">';
select_from_arr2($filearr,$nextprev,''); 
echo '</select>';
 
    
if(substr($nextprev,0,5)=='self_')   $file =  TPLCURROOT.'selfblock/nextprev/'.$nextprev;
else  $file =  BLOCKROOT.'nextprev/'.$nextprev;   
 
  checkfile($file);
 
 
 
?>


        </td>
    </tr>



  <tr>
      <td class="tr">相关文章：</td>
      <td> 
      字样：
      <input name="relativetitle" type="text"  value="<?php echo $relativetitle;?>" size="30">    
     
     <div class="c5"></div>
   效果：
  <?php
 // $relative='';
$filedir = BLOCKROOT.'/relative/'; 
$filearr = getFile($filedir);

$filedirself = TPLCURROOT.'selfblock/relative';
//echo $filedirself;
if(is_dir($filedirself)) {
$filearr2 = getFile($filedirself);
$filearr = array_merge($filearr,$filearr2);
 }
 

echo ' <select name="relativefg">';
select_from_arr2($filearr,$relativefg,''); 
echo '</select>';
 
    
if(substr($relativefg,0,5)=='self_')   $file =  TPLCURROOT.'selfblock/relative/'.$relativefg;
else  $file =  BLOCKROOT.'relative/'.$relativefg;   
 
  checkfile($file);
 


?>
      <div class="c5"></div>   记录数：
      <input name="relamaxline" type="text"  value="<?php echo $relamaxline;?>" size="10"> 
      <span class="cgray">必须为数字。</span>
      <div class="c5"></div>   
  基于主类：
      <select name="relapid">
    <?php  
    select_from_arr($arr_yn,$relapid,'');?>
     </select>   
<span class="cgray">如果不基于主类，则基于当前分类。</span>
        </td>
    </tr>


    <tr>
      <td class="tr">自定义菜单的标识：</td>
      <td> 
      <input name="cateofpagemenu" type="text"  value="<?php echo $cateofpagemenu;?>" size="30">    
     <?php 
     if($cateofpagemenu<>''){
        if(!ifhaspidname2(TABLE_MENU,$cateofpagemenu)) echo '<span class="cred">出错：菜单里不存在 '.$cateofpagemenu.'</span>';
     }
     
     ?>
 </td>
 </tr>
 
  
  
  <tr>
    <td></td>
    <td style="padding:10px"> <input class="mysubmit" type="submit" name="Submit" value="提交"></td>
  </tr>
 </table>
  <?php echo $inputmust;?>
</form>