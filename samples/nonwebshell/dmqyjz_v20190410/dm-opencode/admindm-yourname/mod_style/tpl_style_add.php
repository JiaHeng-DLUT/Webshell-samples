<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

 if($act=='insert')
 {
    if ($abc1 == '') {
      echo '请输入标题';  
      exit;
    }
    

 $sql = "SELECT id from ".TABLE_STYLE." where htmldir='$abc2' and pidname<>'$pidname'  limit 1";
   if(getnum($sql)>0){
      alert('出错，模板目录 '.$abc2.' 已使用。(包括其他语言)');
       jump($jumpv);

      exit;
   }  

 
  $htmldir = $abc2;
 
  $pidname='style'.$bshou;
   
   $ss = "insert into ".TABLE_STYLE." (pidname,pbh,pid,pidmenu,pidregion,title,lang,dateedit,htmldir,style_blockid,style_hf) values ('$pidname','$user2510','0','$abc3','$abc4','$abc1','".LANG."','$dateall','$htmldir','$arr_styleblockidV','$arr_style_hf')";//pidregion no use
 //echo $ss;exit;
   iquery($ss);
 
    jump($jumpv);
    
 }
  
 
 

 
 if($act=='add')
 {
 
 $jumpv_insert = $jumpv_f.'&act=insert';

?>
 
<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert;?>" method="post"  enctype="multipart/form-data">
  <table class="formtab">
    <tr>
      <td width="20%" class="tr">模板的标题：</td>
      <td  > <input name="name" type="text"  value="<?php echo $name;?>" class="form-control" />
      <?php echo $xz_must?>
 
   </td>
   </tr> 

    <tr>
      <td class="tr">模板目录：</td>
      <td> 
   <select name="selefolder" class="form-control">
         <option value="">请选择</option> 
<?php 
$arrtpltemplateroot = getDir(TEMPLATEROOT);
//pre($arrtpltemplateroot);
foreach ($arrtpltemplateroot as $k => $v) {
  if($v<>'base'){
    $htmldirv = '';
     
      $sql = "SELECT id from ".TABLE_STYLE." where   htmldir='$v' limit 1"; 
      if(getnum($sql)==0) echo '<option '.$htmldirv.' value="'.$v.'">'.$v.'</option>';
}
}
     ?>
</select>
  <p class="cgray">
请先在DM-template创建一个模板目录。
</p>
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
       // if($pidname22 == $pidmenu) $selected = ' selected ';
       // else  $selected = '';
        $selected = '';
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
      <td >       <input name="pidregion" type="text"  value="" class="form-control" />
      </td>
    </tr>




  <tr>
      <td></td>
      <td>
      <input  class="mysubmit" type="submit" name="Submit" value="添加"></td>
    </tr>
    </table>
</form>
 

<?php
}
?>

<script>
function checkhere(thisForm) {
   if (thisForm.name.value=="")
  {
    alert("请输入标题");
    thisForm.name.focus();
    return (false);
  } 
    if (thisForm.selefolder.value=="")
  {
    alert("请选择模板目录");
    thisForm.selefolder.focus();
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
