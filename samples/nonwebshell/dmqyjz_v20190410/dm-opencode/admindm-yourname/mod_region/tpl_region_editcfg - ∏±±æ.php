<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}



  if($act=='update')
 {

    if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

 
  $bscnt22 = '';
  if(count($_POST)>1){
          foreach ($_POST as  $k=>$v) {
            if(strtolower($k)=='submit') break;
            $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
             
          }
      }
       $bscnt22 = substr($bscnt22,0,-5);


//usr linkcss,not use linkstyle
 $ss = "update ".TABLE_REGION." set arr_cfg='$bscnt22'  where  pid='$pid' and  id='$tid' $andlangbh limit 1";
			iquery($ss); 	
     // echo $ss;exit;
			$jumpvp = $jumpvf.'&act=edit&tid='.$tid;		
			 jump($jumpvp);			
 }
 

 
else
 {
	$jumpv_insert = $jumpvf.'&act=update&tid='.$tid;
 
	$sql = "SELECT name,arr_cfg from ".TABLE_REGION."  where  pid='$pid' and id='$tid' $andlangbh order by id limit 1";
$row = getrow($sql);
 if($row=='no') {echo 'no record...';exit;}
$cssname=$cssstyle=$bgcolor=$bgimg=$bgeffect ='';
$sta_width_title='y';
$sta_width_cnt='n';
$sta_title='y';

$titlestyle=$titlestylesub=$titleimg='';

$titlelinelong=$titlelineshort=$titlelineawe=''; 

$linkurl=$linktitle=$linkcss=$linkposi=$linkradius ='';


$name=$row['name'];
$arr_cfg=$row['arr_cfg'];

$bscntarr = explode('==#==',$arr_cfg); 
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }
    



 
?>


<?php 
  require_once HERE_ROOT.'mod_region/tpl_region_inc_edittab.php';
  ?>

<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert;?>" method="post">
  <table class="formtab">
 
<tr>
<td colspan="2" class="trbg">
  区域盒子样式
</td></tr>

 <tr style="background:#fcf6ee">
      <td class="tr">  <?php echo $text_cssname; ?></td>
      <td>  <input name="cssname" type="text" value="<?php echo $cssname?>" class="inputcss form-control" />
<?php echo $xz_maybe;?>  

    <br />
    说明：定义好css名称后，可以使用css文件的样式。
<br />参考：<span class="cgray">绝对层:poa | 相对层:por | 左对齐:fl | 右对齐:fr  | 
清浮动:c  |
隐藏标题:hdhide | 仅pc端显示:pcshow | 仅移动端显示:mobshow | 
更多请参考当前模板的用到的css文件<br />
onlytext_p ,  bgboxcontent 
</span>
      </td>
      </tr>
 


	<tr style="background:#fff">
      <td class="tr">盒子样式 </td>
      <td> 
   
   
 盒子的样式：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="cssstyle" type="text" value="<?php echo $cssstyle?>"   size="35" /> <?php echo $xz_maybe;?> 
<span class="cgray">试下： margin-top:50px;</span>

    <div class="inputclear"> </div>


 盒子的背景色：&nbsp;&nbsp;&nbsp;
<input name="bgcolor" type="text" value="<?php echo $bgcolor?>"  size="35" /><?php echo $xz_maybe;?>  
          <?php spancolor($bgcolor);?>
           (<a target="_blank" href="<?php echo $dmlink_color;?>">配色方案</a>)
        <div class="inputclear"> </div>
         盒子的背景图片：<input name="bgimg" type="text" value="<?php echo $bgimg?>"  size="35" /><?php echo $xz_maybe;?>  
                <?php  //echo  check_blockid($bgimg); 
               echo p2030_imgyt($bgimg,'y','y');  
               ?>                
          <div class="inputclear"> </div>
           背景图片是否固定底部：<select name="bgimgattachment">
            <?php select_from_arr($arr_yn,$bgimgattachment,'');?>
     </select>
        <div class="inputclear"> </div>
           背景图片的位置：<input name="bgimgposition" type="text" value="<?php echo $bgimgposition?>" size="25" />
     <br /><span class="cgray">参考： center center </span>



</div>
        </td>
    </tr>

  
   <tr  style="background:#fff">
      <td  class="tr"> 盒子宽度：</td>
      <td >   
      标题是否全宽：  
<select name="sta_width_title"> <?php select_from_arr($arr_yn,$sta_width_title,'');?>
     </select>
       <div class="c5"> </div>
      内容是否全宽： 
        
<select name="sta_width_cnt"> <?php select_from_arr($arr_yn,$sta_width_cnt,'');?>
     </select>
     
        </td>
    </tr> 
 
  


<tr>
<td colspan="2" class="trbg">
  标题盒子样式
</td></tr>


 <tr  style="background:#fff">
      <td  class="tr">显示标题：</td>
     <td >     
       
<select name="sta_title"> <?php select_from_arr($arr_yn,$sta_title,'');?>
     </select>
  <?php 
if($sta_title<>'y') echo '<p class="hintbox">提示：标题已设置为不显示</p>';
  ?> 
        </td>
    </tr>

 

 <tr  style="background:#fff">
      <td  class="tr">标题用图片代替：</td>
     <td >     
     <input name="titleimg" type="text" value="<?php echo $titleimg?>"  size="35" /> <?php echo $xz_maybe;?>  
 <?php echo  p2030_imgyt($titleimg,'y','y');
 ?> 
        </td>
    </tr>


 <tr  style="background:#fff">
      <td  class="tr">标题的样式：</td>
     <td >     
     <input name="titlestyle" type="text" value="<?php echo $titlestyle?>"  size="35"  /> <?php echo $xz_maybe;?>  
 
 <span class="cgray">试下： color:red </span>
        </td>
    </tr>

 <tr  style="background:#fff">
      <td  class="tr">副标题的样式：</td>
     <td >     
     <input name="titlestylesub" type="text" value="<?php echo $titlestylesub?>"  size="35"  /> <?php echo $xz_maybe;?>  
 
  <span class="cgray">试下： color:red </span>
        </td>
    </tr>


     <tr>
      <td  class="tr">标题下划线的颜色  -- 长：</td>
      <td >      
          <input   name="titlelinelong" type="text" value="<?php echo $titlelinelong?>"   size="35"  /> <?php echo $xz_maybe;?>   
          <?php 
          if($titlelinelong<>'')  spancolor($titlelinelong); 
          ?><br />
        <span class="cgray">默认会有颜色，如果为none则无颜色，如果为hide则隐藏长短下划线。 </span>
        <br /> (<a target="_blank" href="<?php echo $dmlink_color;?>">配色方案</a>)
   </td>
    </tr> 

 <tr>
      <td  class="tr">标题下划线的颜色  -- 短：</td>
      <td >  
      <input  name="titlelineshort" type="text" value="<?php echo $titlelineshort?>"   size="35" /> <?php echo $xz_maybe;?>  
 
<?php 
          if($titlelineshort<>'')  spancolor($titlelineshort); 
          ?><br />
        <span class="cgray">默认会有颜色，如果为none则无颜色 </span>

        </td>
    </tr> 

   

 


<tr>
<td colspan="2" class="trbg">
  链接的样式 
  
</td></tr>





<tr style="background:#fcf6ee">
<td  class="tr">链接：

</td>
 <td width="78%">

     <?php 
 //require_once HERE_ROOT.'plugin/tpl_linkmore.php';
 ?>

 
 字样： <input name="linktitle" type="text" value="<?php echo $linktitle?>"  size="30" />
<?php echo $xz_maybe;?>  
 <div class="inputclear"> </div>

   网址：  <input name="linkurl" type="text" value="<?php echo $linkurl?>"  class="form-control" />
<?php echo $xz_maybe;?>  



 </td>
</tr>


 
<tr>
      <td></td>
      <td>
      <input  class="mysubmit" type="submit" name="Submit" value="提交"></td>
    </tr>
  </table>

    <?php echo $inputmust;?>

</form>
 
 <?php 
}
?>

 
<script>
function checkhere(thisForm) {
   

 
   // return;

}
 

</script>

