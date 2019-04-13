<?php
/*
  power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}
//-------------

 if($act=="update"){
    
     if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

 

  $bscnt22 = '';
  if(count($_POST)>1){
          foreach ($_POST as  $k=>$v) {
            if(strtolower($k)=='submit') break;
            $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
             
          }
      }
       $bscnt22 = substr($bscnt22,0,-5);
      // echo $bscnt22;
      // exit;
      //$bscnt22 = "header_bgcolor:##$abc1==#==header_bgimg:##$abc2==#==header_color:##$abc3==#==header_color_a:##$abc4==#==header_color_ahover:##$abc5==#==footer_bgcolor:##$abc6==#==footer_color:##$abc7==#==footer_color_a:##$abc8==#==footer_color_ahover:##$abc9==#==sta_header_width:##$abc10";



   //$ss = "update ".TABLE_STYLE." set header_bgcolor='$abc1',header_bgimg='$abc2',header_color='$abc3',header_color_a='$abc4',header_color_ahover='$abc5',footer_bgcolor='$abc6',footer_bgimg='$abc7',footer_color='$abc8',footer_color_a='$abc9',footer_color_ahover='$abc10',sta_header_width='$abc11' where pidname='$pidname' $andlangbh limit 1";
  
  $ss = "update ".TABLE_STYLE." set  style_blockid='$bscnt22' where pidname='$pidname' $andlangbh limit 1";
//echo $bscnt22;

   iquery($ss);   
  $jumpv = $jumpv_pf.'&act=edit';
  jump($jumpv);
    
    
 }
else{ 
//echo $bsheaderlogo;
 //$bsheaderlogo = $bsheadertext = $bsheadersearch='';
//$bsbannertop=$bsbanner=$bsbannermob=$bsindex=$bsindexmob=$bsmenu=$bsheadertop=$bsheader=$bsfooterbegin=$bsfootercols=$bsfooterlinks=$bsfooter=$bsfooterlast=$bsfooternavmob=$bsblock404='';

 //$sta_narrowscreen = $sta_header_allwidth = $sta_menuright=$sta_menufix='n';
 
 

$sql = "SELECT * from ".TABLE_STYLE."  where  pidname='$pidname' $andlangbh   order by id limit 1";
$row = getrow($sql);

$style_blockid=$row['style_blockid'];
$bsheaderlogomobi='';

    $bscntarr = explode('==#==',$style_blockid); 

     if(count($bscntarr)>1){
        foreach ($bscntarr as   $bsvalue) {
           $bsvaluearr = explode(':##',$bsvalue);
           $bsccc = $bsvaluearr[0];
           $$bsccc=$bsvaluearr[1];
        }
    }
     


 $jumpv_insert = $jumpv_pf.'&act=update';


 ?>

 
<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert;?>" method="post">
  <table class="formtab">
 
 <tr>
    <td  colspan="2"   class="trbg"> 
 如果移动端没有值，就使用PC端。 
  </td>   
  </tr>
 <tr>
    <td  colspan="2" style="text-align:center">  
    <?php echo showblockid(); ?> 
  </td>   
  </tr>

 

<tr>
      <td  width="20%" class="tr">首页banner：
           
      </td>
      <td  width="70%"> 
       pc端：&nbsp;&nbsp;&nbsp;&nbsp;<input name="bsbanner" type="text"  value="<?php echo $bsbanner;?>" size="30" />
      <?php echo $xz_maybe;?>
        <?php echo check_blockid($bsbanner);?>
       
 <div class="c5"></div> 
       移动端：<input name="bsbannermob" type="text"  value="<?php echo $bsbannermob;?>" size="30" /> 
      
       <?php echo $xz_maybe;?>
        <?php echo check_blockid($bsbannermob);?>
     
 
  </td>
    </tr>
 
 <tr style="background:#fbfaf4">
      <td  width="20%" class="tr">头部最顶部内容：</td>
      <td  width="70%">  
  <input name="bsheadertop" type="text"  value="<?php echo $bsheadertop;?>" size="30" />
       <?php echo $xz_maybe;?>
        <?php echo check_blockid($bsheadertop);?> 
        
  </td>
    </tr>


    <tr style="background:#fbfaf4">
      <td  width="20%" class="tr">头部内容 ：</td>
      <td  width="70%"> 


 <div class="c5"></div> 
    
      pc端LOGO： <input name="bsheaderlogo" type="text"  value="<?php echo $bsheaderlogo;?>" size="30" />
       <?php echo $xz_must;?>
       <?php echo check_blockid($bsheaderlogo);?> 
 <div class="c5"></div> 
  移动端LOGO： <input name="bsheaderlogomobi" type="text"  value="<?php echo $bsheaderlogomobi;?>" size="30" />
       <?php echo $xz_maybe;?>
       <?php echo check_blockid($bsheaderlogomobi);?> 


       
  <div class="c5"></div>  
 
一段图文：
    <input name="bsheadertext" type="text"  value="<?php echo $bsheadertext;?>" size="30" />
       <?php echo $xz_maybe;?>
       <?php echo check_blockid($bsheadertext);?> 
 <div class="c5"></div> 

搜索框：&nbsp;&nbsp;&nbsp;&nbsp;
  <input name="bsheadersearch" type="text"  value="<?php echo $bsheadersearch;?>" size="30" />
       <?php echo $xz_maybe;?>
       <?php echo check_blockid($bsheadersearch);?> 
 <div class="c5"></div> 

  </td>
    </tr>

 


   <tr>
      <td  width="20%" class="tr">底部内容：</td>
      <td  width="70%"> 

pc端：<input name="bsfooter" type="text"  value="<?php echo $bsfooter;?>" size="30" />
       <?php echo check_blockid($bsfooter);?>  
 <div class="c5"></div>   

 移动端：<input name="bsfootermob" type="text"  value="<?php echo $bsfootermob;?>" size="30" />
       <?php echo $xz_maybe;?>
        <?php echo check_blockid($bsfootermob);?> 
  </td>
</tr>


  <tr style="background:#fbfaf4">
      <td  width="20%" class="tr">网站浮动部分(FooterLast)：</td>
      <td  width="70%"> 
 
  <input name="bsfooterlast" type="text"  value="<?php echo $bsfooterlast;?>" size="30" />
      <?php echo $xz_maybe;?>
   <?php echo check_blockid($bsfooterlast);?> 
    <br /> <span class="cgray">（比如浮窗咨询等）</span>
  </td>
    </tr>


<!-- <tr>
      <td  width="20%" class="tr">移动端底部导航：</td>
      <td  width="70%"> 
      <input name="bsfooternavmob" type="text"  value="<?php //echo $bsfooternavmob;?>" size="50" />
       <?php //echo check_blockid($bsfooternavmob);?>
      <?php //echo $xz_maybe;?>
      <span class="cgray">（试下： prog_footernavmob）</span>
  </td>
    </tr> -->
 <tr><td colspan="2" class="trbg">其他</td></tr>
<tr>
      <td  width="20%" class="tr">404区块的标识：</td>
      <td  width="70%"> 
      <input name="bsblock404" type="text"  value="<?php echo $bsblock404;?>" size="30" />
      <?php echo $xz_must;?>
       <?php echo check_blockid($bsblock404);?>
      
  </td>
    </tr>
 


  <tr>
      <td></td>
      <td>
      <input  class="mysubmit" type="submit" name="Submit" value="提交" /></td>
    </tr>
    </table>

 

<?php echo $inputmust;?>

</form>
<?php }
?>
<script>
function checkhere(thisForm) {
   
}

</script>
