<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

 
//echo $stylename; 
?>

  
  <a href="<?php echo $jumpv?>&file=addedit&act=add"><i class="fa fa-plus-circle"></i> 添加</a>
<br />
 
 <?php 

 

 if($ppid=='') $ppid='common';
 //ppid is pidstylebh
 $curv1 = $curv2 = $curv3 = '';
if($ppid=='common')  $curv1 ='style="background:red;color:#fff"';
elseif($ppid=='dmregion')  $curv3 ='style="background:red;color:#fff"';
else $curv2 ='style="background:red;color:#fff"';

  echo '<a '.$curv1.' href="'.$jumpv2.'&ppid=common">公共区域</a> &nbsp;| &nbsp;';
  echo '<a '.$curv2.' href="'.$jumpv2.'&ppid='.$curstyle.'">当前模板区域</a> &nbsp;| &nbsp;';
  echo '<a '.$curv3.' href="'.$jumpv2.'&ppid=dmregion">酷模板</a> ';
 
 //$dmregarr = getDir(REGIONROOT);
 //pre($dmregarr);
 
 //foreach($dmregarr as $v){
  // $curv = $ppid==$v?' style="background:red;color:#fff"':'';
 
  // echo '<a '.$curv.' href="'.$jumpv.'&ppid='.$v.'">'.$v.'</a> &nbsp;| &nbsp;';
 
 //}
 ?>
 

<div class=" " style="margin-top:10px">
 
<form method=post action="<?php echo $jumpv;?>&act=posmain">
<table class="formtab formtabhovertr">
<tr style="background:#B3C0E0">
<td>排序</td>
<td>标题</td> 
 
<td align="center">操作</td>
 <td align="center"> 状态</td>  
 </tr>


<?php
 //if($type=='style') $wherev = " and  pidstylebh='$curstyle'  and type='style' ";
 //else    $wherev = "   and  type='page' ";
$sql = "SELECT * from ".TABLE_REGION." where pid = '0' and  pidstylebh='$ppid'   $andlangbh order by pos desc,id desc";
//and  (pidstylebh='y' or pidstylebh='$curstyle')  
  // echo $sql;
if(getnum($sql)>0){
$rowlist = getall($sql);
    foreach($rowlist as $vcat){
       $tidmain=$vcat['id']; //tidmain ,not use tid,for conflict in subedit.php
      $name=$vcat['name']; $dmregdir=$vcat['dmregdir'];
    
       $pidname=$vcat['pidname'];  
       
      menu_changesta($vcat['sta_visible'],$jumpv,$tidmain,'sta');


 $jsname = jsdelname($name);

$numsubnode = num_subnode(TABLE_REGION,'pid',$pidname);


$edit =  '<a class="but1"  href="'.$jumpvedit.'&tid='.$tidmain.'"><span><i class="fa fa-pencil-square-o"></i> 修改</span></a>';
  $del ="   <a class='but2'  href=javascript:del('delregion','$pidname','$jumpv','$jsname')><span><i class='fa fa-trash-o'></i> 删除</span></a>";
if($numsubnode>0)   $del ='';
 
 
$namecopy ='确定要复制页面区域：'.$jsname;
$js_back = $jumpv.'&pidname='.$pidname;
 //$movelink=  " <a class=but3  href=javascript:confirmaction('move','notdel','$js_back','$namecopy')><i class='fa  fa-files-o'></i> 复制</a>"; 

 if($numsubnode==0)   $movelink ='';
 
  
 $stylev=' style="color:blue;font-size:16px" ';
 if($pidname == $pidregion)  { 
  $stylev=' style="color:red;font-size:16px" ';
}




$gl =  '<a  '.$stylev.'   href="mod_region.php?lang='.LANG.'&pid='.$pidname.'">'.$name.'</a> <span class="cred">('.$numsubnode.')</span>'; 


//-----------------------------
$showrecord = 'y';

//if($pidstylebh<>''){   -- no use...
  // if($pidstylebh<>$curstyle) $showrecord = 'n';
//}
 
//if(SHOWREGIONVIP<>'y'){  
  // if($pidstylebh<>'') $showrecord = 'n';
 ///}


 
 
 if($showrecord=='y'){

     ?>
     <tr <?php echo $tr_hide;?>>
    <td align="center"><input type="text" name="<?php echo $tidmain;?>"  value="<?php echo $vcat['pos'];?>" size="5" /></td>
     <td> 
        <strong><?php echo $gl;?></strong>
      

        <?php 
          if($pidname == $pidregion) {
            echo '<p class="cred">当前模板的首页 正在使用此区域</p>';
          }
         
      
       
          if($ppid=='dmregion') {
            $dir22 = REGIONROOT.$dmregdir; 
             if($dmregdir=='')   echo '  <span style="color:red">酷模板目录不能为空</span>';
             elseif(!is_dir($dir22))  echo '   <span style="color:red">'.$dmregdir.' 目录不存在</span>';
          }

            
                $linkview = fronturl('dmlink-blockview-'.$pidname.'-1.html');
                echo ' <a  class="but4" target="_blank" href="'.$linkview.'"><span><i class="fa fa-link"></i> 预览</span></a>';
        
  
        
        
     //  echo  adm_previewlink($pidname);
        ?>
        <br />
        标识: <?php echo $pidname;    ?>
       
        
  </td>
 
  
 
<td align="center">  <?php echo $edit.$del?></td>
 
  <td  align="center"> <?php echo $sta_visible;?></td>

    </tr>
    <?php 
    }
    } 
    ?>
  

    <?php }
    else echo '<tr><td></td><td>暂无内容，请添加。<td><tr>';



//----------------
//}
//---------------



?>
</table>
  <div style="padding-bottom:22px"><input class="mysubmit" type="submit" name="Submit" value="排序" />
  <?php echo $sortid_desc?></div>
  </form>

</div> 



 
 
<div class="c"></div>
<p class="cred ptb10"><?php echo $text_adminhide2;?></p>

