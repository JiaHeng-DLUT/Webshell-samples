<?php
/*
	欢迎使用DM建站系统，网址：www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}



  if($act=='update')
 {

if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

 $despjj=zbdesp_onlyinsert($_POST['despjj']);

 //$despcontent = zbdesp_onlyinsert($_POST['despcontent']);

 //$despjj=zbdespadd2($abc2);

 $template = zbdesp_onlyinsert($_POST['template']);


  $arrcanexcerpt =  array("name", "despjj","blockid","template");  //move top line

 $bscnt22 = '';
 if(count($_POST)>1){
         foreach ($_POST as  $k=>$v) {
           if(strtolower($k)=='submit') break;
           if(in_array($k,$arrcanexcerpt))   continue;
           $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';

         }
     }
      $bscnt22 = substr($bscnt22,0,-5);



//usr linkcss,not use linkstyle
 $ss = "update ".TABLE_REGION." set name='$abc1',despjj='$despjj',blockid='$abc6',template='$template',arr_cfg='$bscnt22' where pid='$pid' and id='$tid' $andlangbh limit 1";
 //echo $ss;exit;
			iquery($ss);
			$jumpvp = $jumpvf.'&act=edit&tid='.$tid;
			 jump($jumpvp);
 }



else
 {
	$jumpv_insert = $jumpvf.'&act=update&tid='.$tid;

	$sql = "SELECT * from ".TABLE_REGION."  where pid='$pid' and id='$tid' $andlangbh order by id limit 1";
$row = getrow($sql);
if($row=='no') {echo 'no record...';exit;}

$name=$row['name'];


$bgcolor=$bgimg=$cssstyle='';
$bgrepeat= 'no-repeat';
$bgposi= 'center center';
$bgsize= 'cover';
$bgattach = '';
$reganchor = '';

$arr_cfg=$row['arr_cfg'];   //echo $arr_cfg;
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



$template=$row['template'];
$pidnamehere=$row['pidname'];
$blockid=$row['blockid'];

$despjj=zbdesp_imgpath($row['despjj']);
//$desp=zbdesp_imgpath($row['desp']);
//$desptext=zbdesp_imgpath($row['desptext']);


?>

<?php
 // require_once HERE_ROOT.'mod_region/tpl_region_inc_edittab.php';
  ?>


<div class="layoutsidebar fl col-xs-12 col-sm-12  col-md-2">
<?php
require_once HERE_ROOT.'mod_region/plugin_region_sidebar.php';
?>

</div><!--end left-->

<div class="fl col-xs-12 col-sm-12  col-md-10">
<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert;?>" method="post">
  <table class="formtab">
    <tr>
      <td width="20%" class="tr">标题：</td>
      <td width="78%"> <input name="name" type="text" value="<?php echo $name?>" class="form-control" />
<?php echo $xz_must;?>
        </td>
    </tr>
    <tr>
      <td width="20%" class="tr">锚点：</td>
      <td width="78%"> <input name="reganchor" type="text" value="<?php echo $reganchor?>" size="35" />
<?php echo $xz_maybe;?>(主要用于单页面功能)
        </td>
    </tr>
  <tr style="background:#fcf6ee">
      <td class="tr">  <?php echo $text_cssname; ?></td>
      <td>  <input name="cssname" type="text" value="<?php echo $cssname?>" class="inputcss form-control" />
<?php echo $xz_maybe;?>
      </td>
      </tr>
 <tr style="background:#fff">
      <td class="tr">样式 </td>
      <td>
<input name="cssstyle" type="text" value="<?php echo $cssstyle?>"   size="35" /> <?php echo $xz_maybe;?>
<span class="cgray">试下： margin-top:50px;</span>
  </td>
  </tr>


 <tr>
      <td width="20%" class="tr">副标题的内容：</td>
      <td width="78%">
      <textarea name="despjj" class="form-control" rows="3"><?php echo $despjj?></textarea>

<?php echo $xz_maybe;?>
        </td>
    </tr>



   <tr>
      <td class="tr" valign="top">标识：<br />
      <?php echo showblockid(); ?>
      </td>
      <td>
<input name="blockid" type="text" value="<?php echo $blockid?>"  size="30" />
<?php echo $xz_maybe;?>
<?php
 echo check_blockid($blockid);

 ?>
<p><a target="_blank" href="../mod_block/mod_block.php?lang=<?php echo LANG?>&ppid=<?php echo $dmregdir;?>" >它的区块</a></p>
</td>
    </tr>



    <tr style="background:#dce8f4">
        <td class="tr fb">效果文件：</td>
        <td class="select--TOinput--">


  <?php


$filedir = BLOCKROOT.'region/';
$filearr = getFile($filedir);

$filedirself = TPLCURROOTADMIN.'selfblock/region/';
//echo $filedirself;
if(is_dir($filedirself)) {
$filearr2 = getFile($filedirself);
$filearr = array_merge($filearr,$filearr2);
 }

echo '<select name="template">';
 select_from_arr2($filearr,$template,'');
//select_from_filearr2($filedir,$filedirself,$template);
echo '</select>';
echo '</div>';




if($template<>'') {
    $type='region';
    if(substr($template,0,5)=='self_')   $file =  TPLCURROOT.'selfblock/'.$type.'/'.$template;
    else  $file =  BLOCKROOT.'region/'.$template; 

    checkfile($file);

}

?>
<br />
<span class="cblue"><i class="fa fa-exclamation-triangle fa-2x"></i> 下面的参数是否在前台显示，取决于选择的效果文件</span>

</td>
    </tr>



<?php
require_once HERE_ROOT.'mod_region/tpl_region_editcfg.php';
?>
<tr>
<td colspan="2" class="trbg">其他 </td></tr>

<?php
 
require_once HERE_ROOT.'mod_region/tpl_region_editbg.php';
?>


<tr>
      <td></td>
      <td>
      <input  class="mysubmit" type="submit" name="Submit" value="提交"></td>
    </tr>
  </table>

    <?php echo $inputmust;?>

</form>
 </div><!--end right-->
 <div class="c"></div>
<?php
}
?>

<script>
function checkhere(thisForm) {
   if (thisForm.name.value==""){
		alert("请输入标题。");
		thisForm.name.focus();
		return (false);
	}





   // return;

}


</script>
