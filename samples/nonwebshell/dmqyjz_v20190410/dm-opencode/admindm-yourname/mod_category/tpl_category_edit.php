<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

 

 
	
	if($act=='update'){ 
       if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}


        if($abc1=="") $abc1='pls input title'; 
        
   
   
        $arrcanexcerpt =  array("name", "alias_jump","sta_noaccess");  //move top 
        
    $bscnt22 = '';
    if(count($_POST)>1){
            foreach ($_POST as  $k=>$v) {
               if(strtolower($k)=='submit') break;
              if(in_array($k,$arrcanexcerpt))   continue;
  
              $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
               
            }
        }
         $bscnt22 = substr($bscnt22,0,-5);


    $ss = "update ".TABLE_CATE." set name='$abc1',alias_jump='$abc2',sta_noaccess='$abc3',list_can='$bscnt22'  where pidname='$catid' $andlangbh limit 1";
   
// echo $ss;exit;
			iquery($ss); 	

		 jump($jumpvedit);

	 

	
	}
	
else	{
 
  
     $tit_v='修改主类';
     //$sta_modtype=$row['modtype'];
      $pidname=$row['pidname']; 
     $sta_noaccess=$row['sta_noaccess'];  
    $name=$row['name']; 
    $seo1=$row['seo1']; 
    $seo2=$row['seo2']; 
    $seo3=$row['seo3']; 
  
    $cssname=$template=$detailfg=$nodebtnmore=$albumfg=$videofg=$musicfg='';
    $maxline=20;
    $cus_columns=$cus_columns_album=4;
    $cus_substrnum=30;
   $sm_w=$sm_h=300;
   $listfg='vblock20170919_1202408332';

    $arr_can = $row['list_can'];
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

   
    $jump_insertupdatesub = $jumpvcatidf.'&act=update';
  

?>	
 
 <div class="contenttop">

    <a class="needpopup" href="../mod_seo/mod_seo_edit.php?lang=<?php echo LANG;?>&act=edit&pidname=<?php echo $pidname;?>&type=cate"><i class="fa fa-pencil-square-o"></i> 修改SEO</a>

&nbsp;&nbsp;&nbsp;&nbsp;
  <a class="needpopup" href="../mod_seo/mod_alias_edit.php?lang=<?php echo LANG;?>&act=edit&pidname=<?php echo $pidname;?>&type=cate"><i class="fa fa-pencil-square-o"></i> 修改别名</a> 
  <?php 
  $alias= alias($pidname,'cate');
  if($alias<>'') echo '( '.spangray($alias).' )';
  ?> 

</div>

<form  onsubmit="javascript:return checkhere(this)" action="<?php  echo $jump_insertupdatesub;?>" method="post" enctype="multipart/form-data">
<table class="formtab">

  <tr>
    <td width="18%" class="tr">主类名称：</td>
    <td width="75%"><input name="name" type="text" id="name" value="<?php echo $name?>" class="form-control" />

     </td>
  </tr>
  
  
	  <tr>
    <td class="tr">链接跳转：</td>
    <td><input name="alias_jump" type="text"  value="<?php echo $row['alias_jump']?>" class="form-control" />
<?php echo $aliasjumptext.$xz_maybe;?>
      <?php if($row['alias_jump']<>'') { echo $text_jump;
      }?>
     </td>
  </tr>
  <tr>
      <td class="tr">禁止访问：</td>
      <td><select name="sta_noaccess">
	  <?php select_from_arr($arr_yn,$sta_noaccess,'');?>
     </select>
	 
	 <?php
	 if($sta_noaccess=='y') echo '<span style="color:red">禁止访问</span>';
	 ?>
        </td>
    </tr>


 
    <tr>
    <td class="tr">缩略图片：</td>
    <td>
  
  <br />	
	宽：<input name="sm_w" type="text"  value="<?php echo $sm_w;?>" size="10"> <br />
  <div class="c5"> </div>
	高：<input name="sm_h" type="text"  value="<?php echo $sm_h;?>" size="10"> <br />
	<?php echo $text_sm_wh;?>
	</td>
	</tr>
 
 
  
  <?php        
        require_once HERE_ROOT.'mod_category/plugin_catelist_can.php';
        ?>
       




     


  
  <tr>
    <td></td>
    <td style="padding:30px 10px">

     <input class="mysubmit" type="submit" name="Submit" value="<?php echo $tit_v;?>"></td>
  </tr>
 </table>
  <?php echo $inputmust;?>
</form>
<?php
}
?>
<script>
function  checkhere(thisForm){
		if (thisForm.name.value==""){
		alert("请输入名称");
		thisForm.name.focus();
		return (false);
        }
	 
		 
}
 </script>
 