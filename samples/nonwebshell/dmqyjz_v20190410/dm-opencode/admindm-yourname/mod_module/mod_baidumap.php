<?php
/*	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);
 
 if($pidname<>'') {ifhaspidname(TABLE_BLOCK,$pidname);}
 
//ifhaspidname(TABLE_NODE,$pid);
//ifhaspidname(TABLE_CATE,$catpid);
ifhave_lang(LANG);//TEST if have lang,if no ,then jump

$jumpv='mod_baidumap.php?lang='.LANG;
$jumpv_pidname=$jumpv.'&pidname='.$pidname;
$jumpv_file=$jumpv.'&file='.$file;
$jumpv_pidnamefile=$jumpv_pidname.'&file='.$file;


//----
$submenu='module';
$title = '百度地图参数 ';

 
//-----------

require_once HERE_ROOT.'mod_common/tpl_header.php'; 



$jumpv_insert = $jumpv.'&act=update';

if($act=='update'){



   if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

  $bscnt22 = '';
  if(count($_POST)>1){
          foreach ($_POST as  $k=>$v) {
            if(strtolower($k)=='submit') break;
            $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
             
          }
      }
       $bscnt22 = substr($bscnt22,0,-5);



	 $ss = "update ".TABLE_LANG." set arr_map='$bscnt22' where lang='".LANG."' limit 1";
	 iquery($ss); 	

  jump($jumpv);

}
else{


  $sql = "SELECT arr_map from ".TABLE_LANG."  where lang='".LANG."' order by id limit 1";
//echo $sql;//exit;

$row22 = getrow($sql);
$arr_map=$row22['arr_map'];

$map_w='100%';
$map_h="350px";

$bscntarr = explode('==#==',$arr_map); 
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

<section class="content-header">
     
    
      <h1><?php echo $title?></h1>
</section>

<p>
 纬度是代表x坐标,标识东西方向。经度是代表y坐标,标识南北方向。
<br /><br />
  <?php 

  $type = 'prog_baidumap';
    echo  adm_previewlink($type); 
   echo  admblockid($type);
  ?>
 
 </p>
<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert;?>" method="post">
  <table class="formtab">
    <tr>
      <td width="12%" class="tr">地图的标题：</td>
      <td width="88%"> <input name="map_title" type="text"  value="<?php echo $map_title;?>" class="form-control" />
      </td>
    </tr>
	  <tr>
      <td   class="tr">地图的内容：</td>
      <td  > <input name="map_desp" type="text"  value="<?php echo $map_desp;?>" class="form-control" />
      <p class="cgray">以百分比或px结尾，比如：100%  或    600px</p>
      </td>
    </tr>
     <tr>
      <td   class="tr">地图的显示尺寸：
       <p class="cgray">以百分比或px结尾，比如：100%  或    600px</p>
       </td>
      <td  > 
      宽度：<input name="map_w" type="text"  value="<?php echo $map_w;?>" size="20" />
       <div class="c5"></div>
       高度：<input name="map_h" type="text"  value="<?php echo $map_h;?>" size="20" />

     
      </td>
    </tr>
  

      <tr>
      <td   class="tr">地图的纬度：
      <br />
      latitude
      </td>
      <td  > <input name="map_x_wei" type="text"  value="<?php echo $map_x_wei;?>" class="form-control" />
       <a href="<?php echo $dmlink_baidumap;?>" target="_blank">具体请查看教程</a> 
      </td>
    </tr>
     <tr>
      <td   class="tr">地图的经度：
      <br />
      longitude</td>
      <td  > <input name="map_y_jing" type="text"  value="<?php echo $map_y_jing;?>"  class="form-control" />
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

require_once HERE_ROOT.'mod_common/tpl_footer.php';

?>