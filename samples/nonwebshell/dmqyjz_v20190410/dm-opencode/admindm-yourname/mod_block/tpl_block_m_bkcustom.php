<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
 */
if (!defined('IN_DEMOSOSO')) {
    exit('this is wrong page,please back to homepage');
}

$bgcolor=$bgimg=$cssstyle='';
$bgrepeat= 'no-repeat';
$bgposi= 'center center';
$bgsize= 'cover';
$bgattach = '';

$arrcanexcerpt =  array("name", "pidcate","template","despjj","despcontent","editor1text");


if ($act == 'update') {
  //pre($_POST);exit;
  if ($abc1 == '')  { echo '请输入标题'; exit; }
     if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

 
    $desp = zbdesp_onlyinsert($_POST['despcontent']); //note: desp and addr not use variable abc1.
    $desptext = zbdesp_onlyinsert($_POST['editor1text']);

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
   //$tempself = substr($template,0,5);
   //$pidstylebhv = ",pidstylebh = 'common'";
  // if($tempself=='self_') $pidstylebhv = ",pidstylebh = '$curstyle'";

  
   $pidstylebhv = ",pidstylebh = '$ppid' ";
//--------------------------
        $ss = "update " . TABLE_BLOCK . " set name='$abc1',template='$template',despjj='$despjj'  $pidstylebhv,blockcan='$bscnt22',desp='$desp',desptext='$desptext' where   pidname='$pidname' $andlangbh limit 1";
      // echo $ss;exit;
       //echo $jumpvp;exit;
        iquery($ss);

        jump($jumpvp.'&act=edit');



}

if ($act == 'insert') {

    $pidnamecur = 'vblock' . $bshou;

    if ($abc1 == '')  { echo '请输入标题'; exit; }


     if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}
    $desp = zbdesp_onlyinsert($_POST['despcontent']); //note: desp and addr not use variable abc1.
    $desptext = zbdesp_onlyinsert($_POST['editor1text']);

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
//--------------------------

      $ss = "insert into ".TABLE_BLOCK." (pid,pidname,pbh,lang,name,template,despjj,pidstylebh,blockcan,desp,desptext) values ('$type','$pidnamecur','$user2510','".LANG."','$abc1','$template','$despjj','$pidstylebhv','$bscnt22','$desp','$desptext')";
      // echo $ss;exit;

    iquery($ss);
     jump($jumpvppid);
}



if($act=='add'){
   $name=$cssname=$template=$desp=$desptext =$namefront=$despjj =$template=$bgcolor=$blockimg=$linktitle=$linkurl='';
   $blockimg='';
   $jumpvinsert = $jumpvpt.'&act=insert';
  
}

 if($act=='edit'){
    $titleh2 = '修改';
  
    $name = $rowsub['name'];
    $blockimg = $rowsub['blockimg'];
    $template = $rowsub['template'];
   
 $despjj = zbdesp_imgpath($rowsub['despjj']);
    $desp = zbdesp_imgpath($rowsub['desp']);
    $desptext = zbdesp_imgpath($rowsub['desptext']);

    $arr_can = $rowsub['blockcan']; //echo $arr_can;
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
 
 
	$jumpvinsert = $jumpv.'&act=update&pidname='.$pidname;
}

if($act=='add' || $act=='edit'){
?>

<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpvinsert; ?>" method="post" enctype="multipart/form-data">
    <table class="formtab">
        <tr>
            <td width="12%" class="tr">标题：</td>
            <td width="88%">
                <input name="name" type="text"   value="<?php echo $name; ?>" class="form-control" />
                <div class="c5"></div>
                <?php echo $xz_must; ?>
 <?php
if($act=='edit')  { 
    if($ppid4<>'dmre') echo  adm_previewlink($pidname);
    echo  admblockid($pidname); 
}
?>

            </td>
        </tr>




         <tr>
            <td   class="tr"> <?php echo $text_cssname; ?> </td>
            <td  >
                <input name="cssname" type="text"   class="inputcss form-control" value="<?php echo $cssname; ?>"  /><?php echo $xz_maybe; ?>

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
        require_once HERE_ROOT.'mod_block/plugin_block_inc_template.php';
        ?>


    <tr>
            <td  class="tr"> </td>
            <td  >
            <br />
            <span class="cblue"><i class="fa fa-exclamation-triangle fa-2x"></i> 下面的参数是否在前台显示，取决于选择的效果文件</span>
            </td>
        </tr>
 <tr>




 <tr>
            <td  class="tr">  参数：</td>
            <td  >
      
            前台标题： <input name="namefront" type="text"  value="<?php echo $namefront; ?>"  size="30" /><?php echo $xz_maybe; ?>  
              <div class="c5"> </div>
             前台副标题：<br />
             <textarea class="form-control" rows="3" name="despjj"><?php echo $despjj; ?></textarea> <?php echo $xz_maybe; ?>
             <div class="c5"> </div>
             <?php 
  if($act=='edit'){
  ?>

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
        require_once HERE_ROOT.'mod_region/tpl_region_editbg.php';
        ?>

        <tr>
            <td class="tr">内容： </td>
            <td> <p>
 <a class="needpopup" href="../mod_imgfj/mod_imgfj.php?pid=common&lang=<?php echo LANG; ?>" target="_blank">公共编辑器附件管理</a>

                </p>



<?php require_once('../plugin/editor_textarea.php'); //textarea is in this file ?>

            </td>
        </tr>



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
