
 
    <tr>
    <td class="tr">列表：</td>
    <td>
   效果文件：


  <?php 
 
 $filedir = BLOCKROOT.'list/';
 $filearr = getFile($filedir);

 $filedirself = TPLCURROOT.'selfblock/list/';
 //echo $filedirself;
 if(is_dir($filedirself)) {
 $filearr2 = getFile($filedirself);
 $filearr = array_merge($filearr,$filearr2);
  }
 
echo  '<select name="template">';
select_from_arr2($filearr,$template,''); 
echo '</select>';
 
 
  
  
  if($template<>'') {
     
    if(substr($template,0,5)=='self_')   $file  =  TPLCURROOT.'selfblock/list/'.$template;
       else  $file =  BLOCKROOT.'list/'.$template;  
       
      checkfile($file);
       
  } 
  
    ?>
 

 <?php echo $xz_must;?>

 
            <br>  
            <span class="cblue"><i class="fa fa-exclamation-triangle fa-2x"></i> 下面的参数是否在前台显示，取决于选择的效果文件</span>
  
     <div class="c5"></div>

  
<?php echo $text_cssname;?> 
  <input name="cssname" class="form-control"   type="text" value="<?php echo $cssname; ?>"  /><?php echo $xz_maybe; ?>

   <div class="c5"></div>

    每页记录数maxline：

    <input name="maxline" type="text"  value="<?php echo $maxline; ?>" size="10">
   <span class="cgray">(为数字，且要大于0，仅作用于前台)</span>

<div class="c5"> ></div>


   列数：<select name="cus_columns">
                          <?php 
                         
                          select_from_arr($arr_columns,$cus_columns,'');?>
                     </select>
     <?php 
          if($cus_columns>$maxline) echo '<span class="cred">提示：列数大于允许的记录数。</span>';
          ?> 
              <div class="c5"> </div>
                摘要的内容长度：
                <input name="cus_substrnum" type="text"   value="<?php echo $cus_substrnum; ?>"  size="10" />
                (为整数，如果为0，则不显示摘要)

                  <div class="c5"> </div>

           显示更多的字样：   <input name="nodebtnmore" type="text"  value="<?php echo $nodebtnmore; ?>"  size="30" /><?php echo $xz_maybe; ?>  
       

     </td>
  </tr>
 
 
 
 
 <tr>
      <td class="tr"><br />  详情页效果文件：</td>
      <td>           
      <br /> 
      <?php 
 
$filedir = BLOCKROOT.'detail/';
$filearr = getFile($filedir);

$filedirself = TPLCURROOT.'selfblock/detail/';
//echo $filedirself;
if(is_dir($filedirself)) {
$filearr2 = getFile($filedirself);
$filearr = array_merge($filearr,$filearr2);
 }
 

echo ' <select name="detailfg">';
select_from_arr2($filearr,$detailfg,'');
// select_from_filearr($filedir,$detailfg);
echo '</select>';


if($detailfg<>'') {
 
  if(substr($detailfg,0,5)=='self_')   $file =  TPLCURROOT.'selfblock/detail/'.$detailfg;
  else  $file =  BLOCKROOT.'detail/'.$detailfg;   
   
    checkfile($file);
     
}
 
?> 

 <?php echo $xz_must;?>  
   
 


        </td>
    </tr>

	 
 <tr>
      <td class="tr"><br />  相册效果文件：</td>
      <td>           
      <br /> 
      <?php 
  
 $filedir = BLOCKROOT.'album/';
$filearr = getFile($filedir);

$filedirself = TPLCURROOT.'selfblock/album/';
//echo $filedirself;
if(is_dir($filedirself)) {
$filearr2 = getFile($filedirself);
$filearr = array_merge($filearr,$filearr2);
 }
 


echo ' <select name="albumfg">';
select_from_arr2($filearr,$albumfg,''); 
echo '</select>';
 
if($albumfg<>'') {
    if(substr($albumfg,0,5)=='self_')   $file =  TPLCURROOT.'selfblock/album/'.$albumfg;
  else  $file =  BLOCKROOT.'album/'.$albumfg;   
   
    checkfile($file);
  
     
}
 
?> 

 <?php echo $xz_must;?>  
    
<p class="cgray">提示： 相册效果如果在详情页的模板文件没有定义，则在这里选择。</p>

相册列数：<select name="cus_columns_album">
                          <?php 
                         
                          select_from_arr($arr_columns,$cus_columns_album,'');?>
                     </select> <span class="cgray"> (仅适合个别效果文件)</span>

        </td>
    </tr>

    <tr>
      <td class="tr"><br />  音乐效果文件：</td>
      <td>           
      <br /> 
      <?php 
 
$filedir = BLOCKROOT.'music/';
$filearr = getFile($filedir);
 
echo ' <select name="musicfg">';
select_from_arr2($filearr,$musicfg,''); 
echo '</select>'; 
if($musicfg<>'') {
   $file =  BLOCKROOT.'music/'.$musicfg;   
    checkfile($file);     
} 
?> 
 <?php echo $xz_must;?>     
  </td>
  </tr>

	
	