<?php
if($act=='update'){

 if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

 $jump_back = $jumpv_pf.'&act=edit';
 
  //  $cssdir = ASSETSROOT.$abc2;
     // if(!is_dir($cssdir)) {alert('出错，模板目录 '.$abc2.'不存在！');  jump($jump_back); }

    //$htmldir = WEB_ROOT.'component/html/'.$abc3;
    //  if(!is_dir($htmldir)) {alert('出错，html目录 '.$abc3.'不存在！');  jump($jump_back); }

   $sql = "SELECT id from ".TABLE_STYLE." where htmldir='$abc2' and pidname<>'$pidname'  limit 1";
   if(getnum($sql)>0){
      alert('出错，模板目录 '.$abc2.' 已使用。(包括其他语言)');
       jump($jump_back);

      exit;
   }  





   $sql = "SELECT kv from ".TABLE_STYLE." where pidname='$pidname'  $andlangbh   limit 1";
                           $row = getrow($sql);
                           $imgsqlname =$row['kv'];  
       
       $delimg = zbdesp_onlyinsert($_POST['delimg']);                            
    if($delimg=='y'){
        if($imgsqlname<>'') p2030_delimg($imgsqlname,'y','y');
        $kv_v = ",kv = ''";
    }
    else{

         $imgname = $_FILES["addr"]["name"];
       $imgsize = $_FILES["addr"]["size"];
       if (!empty($imgname)) {
           $imgtype = gl_imgtype($imgname);
           $up_small = 'n';
           $up_delbig = 'n';
           $up_water = 'n';           
           $i = '';
           require_once('../plugin/upload_img.php'); //need get the return value,then upimg part turn to easy.
           $kv_v = ",kv = '$return_v'";
       }
       else  $kv_v = "";
    
    }

    $header_pc =  htmlentitdm(@$_POST['header_pc']);
    $header_mobile =  htmlentitdm(@$_POST['header_mobile']);
    $skincss =  htmlentitdm(@$_POST['skincss']);
    //$addDMcssjs =  htmlentitdm(@$_POST['addDMcssjs']); --no use
    $addcss =  htmlentitdm(@$_POST['addcss']);
    $addcss=str_replace("\\","/",$addcss);
    $addcss=str_replace(chr(13),"|",$addcss);
    $addcss=str_replace(chr(32),"",$addcss);
 
    $addjs =  htmlentitdm(@$_POST['addjs']);
    $addjs=str_replace("\\","/",$addjs);
    $addjs=str_replace(chr(13),"|",$addjs);
    $addjs=str_replace(chr(32),"",$addjs);

  $ss = "update ".TABLE_STYLE." set title='$abc1',htmldir='$abc2',pidmenu='$abc3',pidregion='$abc4',pidregionmobile='$abc5',addcss='$addcss',addjs='$addjs',header_pc='$header_pc',header_mobile='$header_mobile',skincss='$skincss' $kv_v where pidname='$pidname' $andlangbh limit 1";
   //echo $ss;exit;    
   iquery($ss);  

  
   jump($jump_back);


}
else{
  $sql = "SELECT * from ".TABLE_STYLE."  where  pidname='$pidname' $andlangbh   order by id limit 1";
$row = getrow($sql);
//pre($row);
$title=$row['title'];$htmldir=$row['htmldir']; 
$kv=$row['kv'];  
$pidmenu=$row['pidmenu'];
$pidregionmobile=$row['pidregionmobile'];
$pidregion=$row['pidregion'];
$header_pc=$row['header_pc'];
$header_mobile=$row['header_mobile'];
$skincss=$row['skincss'];
 //$imgsmall2 = p2030_imgyt($kv, 'y', 'n');
$imgsmall2 = '<img src='.get_img($kv, '', '').' alt=""  height="200" />';

 
$addcss=$row['addcss'];
$addcss=str_replace("|",chr(13),$addcss);
$addjs=$row['addjs'];
$addjs=str_replace("|",chr(13),$addjs);


$jsname = jsdelname($title);

$jumpv_insert = $jumpv_pf.'&act=update';

?>

 
<?php if($curstyle<>$pidname){?>
<div class="contenttop">
<a href="javascript:del('del','<?php echo $pidname;?>','mod_style.php?lang=<?php echo LANG;?>','<?php echo $jsname;?>')" class="fr but2"><i class="fa fa-trash-o"></i> 删除</a>
</div>
<?php } ?>


<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert;?>" method="post" enctype="multipart/form-data">
  <table class="formtab">

      <tr>
      <td width="20%"  class="tr">模板标题：</td>
      <td > <input name="name" type="text"  value="<?php echo $title;?>" class="form-control" /> </td>
    </tr>

   <tr>
      <td class="tr">模板目录：</td>
      <td> 
   <select name="selemb" class="form-control">
         <option value="">请选择</option> 
<?php 
$arrtpltemplateroot = getDir(TEMPLATEROOT);
//pre($arrtpltemplateroot);
foreach ($arrtpltemplateroot as $k => $v) {
  if($v<>'base'){
   
    $sql = "SELECT id from ".TABLE_STYLE." where  pidname<>'$pidname' and  htmldir='$v' limit 1"; 
    if(getnum($sql)==0) {
      $htmldirv = '';
      if($v==$htmldir) $htmldirv ='selected="selected"';
      echo '<option '.$htmldirv.' value="'.$v.'">'.$v.'</option>';
       
    }
    
  
}
}
     ?>
</select>
        </td>
    </tr>
 
  


     <tr>
      <td   class="tr">选择菜单：</td>
      <td >
      <select name="selemenu" class="form-control">
         <option value="">请选择</option>
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
      <td   class="tr">
   
      在 页面区域 选择一个 <br />
      做为本模板的首页内容
      </td>
      <td >
    
      pc端：<input name="pidregion" type="text"  value="<?php echo $pidregion;?>" size="35" />
     <?php 
      echo check_blockid($pidregion);
      ?>
<div class="c5"></div>
移动端：<input name="pidregionmobile" type="text"  value="<?php echo $pidregionmobile;?>" size="35" />
     <?php 
      echo check_blockid($pidregionmobile);
      ?>

      </td>
    </tr> 
    <tr>
      <td   class="tr"> 添加css：
      </td>
      <td >
    <textarea class="form-control" rows="5" name="addcss"><?php echo $addcss; ?></textarea> <?php echo $xz_maybe; ?>
    <p class="cgray">参考：  assets/vendor/singlecss/font-awesome.css  <br />
    assets/vendor/singlecss/animate.css  <br />
    assets/vendor/bt3/bt3.css  
    </p>
    </td>
    </tr>

    <tr>
      <td   class="tr"> 添加js：  </td>
      <td >
    <textarea class="form-control" rows="5" name="addjs"><?php echo $addjs; ?></textarea> <?php echo $xz_maybe; ?>
    </td>
    </tr>
 
    <tr>
      <td   class="tr"> 头部：  </td>
      <td style="padding: 20px 5px">
      pc端：
      <?php 
      //not use select_from_arr2($filearrnew1,$header_pc,'');...
      $select1 = $select2 ='';
      $select1 = $header_pc == 'usercurmb'?' selected= "selected" ':'';
         $filedir = BLOCKROOT.'tpl/header_pc/'; 
        echo '<select name="header_pc">';
        select_from_filearr($filedir,$header_pc); 
        echo '<option '.$select1.' value="usercurmb">使用当前模板下的tpl/header_self_pc.php</option>';
         
        echo '</select>'; 
    ?>
   
<div class="c15"></div>
移动端：
<?php 
 
  $select1 = $header_mobile == 'userpc'?' selected= "selected" ':'';
  $select2 = $header_mobile == 'usercurmb'?' selected= "selected" ':'';

         $filedir = BLOCKROOT.'tpl/header_mobile/';  
        echo '<select name="header_mobile">';
        select_from_filearr($filedir,$header_mobile); 
        echo '<option '.$select1.' value="userpc">不选，使用pc端(则pc的头部 要支持响应式)</option>';
        echo '<option '.$select2.' value="usercurmb">使用当前模板下的tpl/header_self_mobile.php</option>';
        
        echo '</select>'; 
    ?>
 </td>
    </tr>
 
  
    <tr>
      <td   class="tr"> 皮肤css：  </td>
      <td style="padding:20px 5px">
      <?php 
        
          $select1 = $skincss == ''?' selected= "selected" ':'';

         $filedir = STAROOT.'assets/skincss/';  
        echo '<select name="skincss">';       
         select_from_filearr($filedir,$skincss); 
         echo '<option '.$select1.'  value="">不选，在当前模板的css里写。</option>';
        echo '</select>'; 
    ?>
      </td>
    </tr>
 


    <tr>
            <td   class="tr">图片：</td>
            <td style="padding-top:25px"> <input name="addr" type="file" id="addr"  /><?php echo $xz_maybe;?>  
<?php
echo '<br /><span class="cred">' . $format_t . '</span><br />';
// echo gl_showsmallimg($fo_bef,$imgsmall,'y');
   if($kv<>'')    echo $imgsmall2;
?>
             
    <?php  if($kv<>'')    {
              ?>
          <span class="cred"> <br />是否要删除图片？ </span> 
          <select name="delimg">
    <?php select_from_arr($arr_yn,'n','');?>
     </select>
          <?php } 
          else{ //use for : Undefined index: delimg 
              ?>          
          <select name="delimg" style="display:none" class="form-control">
              <option value=""></option>
     </select>
          <?php
          }?>
              
              <br />  <br />  
</td></tr>


    
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
   if (thisForm.name.value=="")
  {
    alert("请输入标题。");
    thisForm.name.focus();
    return (false);
  } 
  
     if (thisForm.selemb.value=="")
  {
    alert("请选择模板目录。");
    thisForm.selemb.focus();
    return (false);
  } 

   if (thisForm.selemenu.value=="")
  {
    alert("请选择菜单。");
    thisForm.selemenu.focus();
    return (false);
  } 

   if (thisForm.pidregion.value=="")
  {
    alert("请输入页面区域。");
    thisForm.pidregion.focus();
    return (false);
  } 



}

</script>
