<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
 */

if (!defined('IN_DEMOSOSO')) {
    exit('this is wrong page,please back to homepage');
}
 //echo $curstyle;;
 

$bgcolor=$bgimg=$cssstyle=$nodebtnmore='';
$bgrepeat= 'no-repeat';
$bgposi= 'center center';
$bgsize= 'cover';
$bgattach = '';

$arrcanexcerpt =  array("name", "pidcate","template","despjj");  



if ($act == 'update') {
  //pre($_POST);exit;
  if ($abc1 == '')  { echo '请输入标题'; exit; }
     if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;} 
 
   // $desp = zbdesp_onlyinsert($_POST['despcontent']); //note: desp and addr not use variable abc1.
    //$desptext = zbdesp_onlyinsert($_POST['editor1text']);

    $template = zbdesp_onlyinsert($_POST['template']);    
    $despjj = zbdesp_onlyinsert($_POST['despjj']);
 
 
    //-----------------
    //$arrcanexcerpt =  array("name", "pidcate","template","templatecur","despjj","pidstylebh");  //move top line
    

        $bscnt22 = '';
      if(count($_POST)>1){
              foreach ($_POST as  $k=>$v) {
                 if(strtolower($k)=='submit') break;
                if(in_array($k,$arrcanexcerpt))   continue;
    
                $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
                 
              }
          }
           $bscnt22 = substr($bscnt22,0,-5);
            //--------------
            $pidstylebhv = ",pidstylebh = '$ppid'";
//-----------------
if($type=='bkblockdh') $pidcate = '';
else {
$pidcate =  htmlentitdm(@$_POST['pidcate']);
$pidcate=str_replace("\\","/",$pidcate);
$pidcate=str_replace(chr(13),"|",$pidcate);
$pidcate=str_replace(chr(32),"",$pidcate);
}

  //--------------------------
    $ss = "update " . TABLE_BLOCK . " set name='$abc1',pidcate='$pidcate',template='$template',despjj='$despjj' $pidstylebhv,blockcan='$bscnt22'  where pid='$type' and pidname='$pidname' $andlangbh limit 1"; 
        //echo $ss;exit;
        iquery($ss);  
      jump($jumpvp.'&act=edit'); 
}


if ($act == 'insert') {
 
    $pidnamecur = 'vblock' . $bshou; 
 
    if ($abc1 == '')  { echo '请输入标题'; exit; }


     if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}
    //$desp = zbdesp_onlyinsert($_POST['despcontent']); //note: desp and addr not use variable abc1.
   // $desptext = zbdesp_onlyinsert($_POST['editor1text']);
   $template = zbdesp_onlyinsert($_POST['template']); 
   $despjj = zbdesp_onlyinsert($_POST['despjj']);
 
   
    //-----------------
    //$arrcanexcerpt =  array("name", "pidcate","template","templatecur","despjj","pidstylebh");  //move top line
    

    $bscnt22 = '';
    if(count($_POST)>1){
            foreach ($_POST as  $k=>$v) {
               if(strtolower($k)=='submit') break;
              if(in_array($k,$arrcanexcerpt))   continue;
  
              $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
               
            }
        }
         $bscnt22 = substr($bscnt22,0,-5);

//--------------------------
//$tempself = substr($template,0,5);
//$pidstylebhv = 'common';
//if($tempself=='self_') $pidstylebhv = $curstyle;
$pidstylebhv = $ppid;
if($type=='bkblockdh') $pidcate = '';
else  $pidcate =  htmlentitdm(@$_POST['pidcate']);
      $ss = "insert into ".TABLE_BLOCK." (pid,pidname,pbh,lang,name,pidcate,template,despjj,pidstylebh,blockcan) values ('$type','$pidnamecur','$user2510','".LANG."','$abc1','$pidcate','$template','$despjj','$pidstylebhv','$bscnt22')";  
      // echo $ss;exit;

    iquery($ss);
    jump($jumpvppid);
}

 

if($act=='add'){
  $maxline=8;
  $cus_columns=3;
  $cus_substrnum=300;
  $pidcatemulti='';
   $name=$cssname=$template=$desp=$desptext=$pidcate=$namefront=$despjj =$template=$bgcolor=$blockimg=$linktitle=$linkurl=$blockimg=''; 
   $jumpvinsert = $jumpvpt.'&act=insert';
 
}

 if($act=='edit'){
    $titleh2 = '修改';
 
    $name = $rowsub['name'];
  
    $blockimg = $rowsub['blockimg']; 
    $pidcate = $rowsub['pidcate']; 
    $pidcatemulti=str_replace("|",chr(13),$pidcate);
  
    $despjj = $rowsub['despjj'];
    $template = $rowsub['template']; 
 
    $maxline=8;$cus_columns=3;$cus_substrnum=30;
    $arr_can = $rowsub['blockcan'];
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

   $maxline = intval($maxline);
   $cus_columns = intval($cus_columns);

   if($type=='bknode') $cus_substrnum = intval($cus_substrnum);
    //$desp = zbdesp_imgpath($rowsub['desp']);
    //$desptext = zbdesp_imgpath($rowsub['desptext']);

 
  $jumpvinsert = $jumpvpt.'&act=update&pidname='.$pidname;
}

if($act=='add' || $act=='edit'){
?>
 
<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpvinsert; ?>" method="post" enctype="multipart/form-data">
    <table class="formtab">
        <tr>
            <td width="12%" class="tr">标题：</td>
            <td width="88%"> 
                <input name="name" type="text"   value="<?php echo $name; ?>" class="form-control" />
               <div class="c5"> </div>
                <?php echo $xz_must; ?>  
 
 <?php
if($act=='edit')  {
    if($ppid4<>'dmre') echo  adm_previewlink($pidname);
echo  admblockid($pidname); 
}
//--------------


if($type=='bkblockdh') {
    $num= num_subnode(TABLE_NODE,'pid',$pidname);

    // echo ' <a target="_blank" href="../mod_node/mod_blockdh.php?lang='.LANG.'&pid='.$pidcate.'">[管理]</a>';
    echo '<p> <a class="but1" target="_blank" href="mod_effectnode.php?lang='.LANG.'&pid='.$pidname.'">效果区块内容管理('.$num.')</a></p>';
 }
 
?> 
    </td>
  </tr> 

         <tr>
            <td   class="tr"> <?php echo $text_cssname; ?> </td>
            <td  > 
                <input name="cssname" type="text"  class="inputcss form-control" value="<?php echo $cssname; ?>"  /><?php echo $xz_maybe; ?>
                   
            </td>
        </tr>
  <tr style="background:#fff">
      <td class="tr">样式 </td>
      <td>
<input name="cssstyle" type="text" value="<?php echo $cssstyle?>"   size="35" /> <?php echo $xz_maybe;?>
<span class="cgray">试下： margin-top:50px;</span>
  </td>
  </tr>


   <?php
 if($type=='bknode'){
 ?>  
 <tr style="background:#dce8f4">
            <td  class="tr">  分类标识：</td>
            <td  class="selectTOinput">    

 <?php
 if($type=='bknode'){
 ?>
 <textarea class="form-control" rows="6" name="pidcate"><?php echo $pidcatemulti; ?></textarea> 
 <?php
 }
 else{
 ?>
 <input name="pidcate" type="text"  value="<?php echo $pidcate; ?>" class="form-control" /> 
 <?php } ?>
 <?php echo $xz_must; ?>  

<?php 
if($type=='bknode' && MULTICATE<>'y')   echo ' <a class="needpopup" href="../mod_module/mod_showcateid.php?lang='.LANG.'">查看分类标识></a> '; 
if($type=='bkblockdh')   echo '<a class="needpopup" href="../mod_module/mod_showcateidEffect.php?lang='.LANG.'">查看效果区块内容标识></a> ';
  
?>
 <br />
<?php

 
if($pidcate<>''){
    if(!is_int(strpos($pidcate,'|'))){
        $catname = get_field(TABLE_CATE,'name',$pidcate,'pidname');
        if($catname=='noid') echo '<span style="color:red">分类标识不对</span>';
        else {
             echo spanred($catname);
            

        }
    }
}



?>



   </td>
  </tr>
 
  <?php
}
 ?>
 
        <?php   
      
         
        require_once HERE_ROOT.'mod_block/plugin_block_inc_template.php';
        ?>
       

   <tr>
            <td  class="tr">  </td>
            <td  > 
            <br />  
            <span class="cblue"><i class="fa fa-exclamation-triangle fa-2x"></i> 下面的参数是否在前台显示，取决于选择的效果文件</span>
            </td>
        </tr>
 <tr>
            <td  class="tr">  参数：</td>
            <td  >  
            记录数：
            <input name="maxline" type="text"  value="<?php echo $maxline; ?>"  size="10" /><?php echo $xz_must; ?>  
            <div class="c5"> </div>
                  列数：<select name="cus_columns">
                          <?php select_from_arr($arr_columns,$cus_columns,'');?>
                     </select>
       <?php 

          if($cus_columns>$maxline) echo '<span class="cred">提示：列数大于允许的记录数。</span>';
          ?>  
              <div class="c5"> </div>
           
              <?php 
              if($type=='bknode'){ //摘要长度仅作用于文章区块。
              ?>              
              摘要的内容长度：
                <input name="cus_substrnum" type="text"   value="<?php echo $cus_substrnum; ?>"  size="10" />
                (为整数，如果为0，则不显示摘要)               
                  <div class="c5"> </div>
                  <?php 
                  }
                  ?>

                 
<div class="c5"> </div>
前台标题： <input name="namefront" type="text"  value="<?php echo $namefront; ?>"  size="30" /><?php echo $xz_maybe; ?>  

                  <div class="c5"> </div>
 前台副标题：<br />
 <textarea class="form-control" rows="3" name="despjj"><?php echo $despjj; ?></textarea> <?php echo $xz_maybe; ?>
  <?php 
  if($act=='edit'){
  ?>
 <div class="c5"> </div>
可能用到的图片：
<?php 
echo  p2030_imgyt($blockimg,'y','n'); 
?>

<p><a class="needpopup but1 pad8lr" style="width:auto"  href="../mod_module/mod_uploadkv.php?lang=<?php echo LANG?>&pidname=<?php echo $pidname?>&type=blockimg">修改图片</a></p>

<?php 
}
?>

      </td>
   </tr>

   <?php 
if($type=='bknode'){
?>
   <tr>
            <td  class="tr">   显示更多的字样：</td>
            <td  >  <input name="nodebtnmore" type="text"  value="<?php echo $nodebtnmore; ?>"  size="30" /><?php echo $xz_maybe; ?>  
                   
           </td>
        </tr>
        <?php 
}
?>
        <?php  
        require_once HERE_ROOT.'mod_region/tpl_region_editbg.php';
        ?>




 
 

        <tr>
            <td></td>
            <td>
                <input  class="mysubmit mysubmitbig" type="submit" name="Submit" value="提交"></td>
        </tr>
    </table>

      <?php echo $inputmust;?>

</form>

<script>
    function checkhere(thisForm) {
        if (thisForm.name.value == "")
        {
            alert("请输入标题。");
            thisForm.name.focus();
            return (false);
        }

          if (thisForm.pidcate.value == "")
        {
            alert("请输入分类标识。");
            thisForm.pidcate.focus();
            return (false);
        }
        if (thisForm.maxline.value == "")
        {
            alert("请输入记录数。");
            thisForm.maxline.focus();
            return (false);
        }
        if (thisForm.template.value == "")
        {
            alert("请输入效果文件。");
            thisForm.template.focus();
            return (false);
        }

        // return;

    }

   


</script>

<?php 

}
 
 
?>

  
