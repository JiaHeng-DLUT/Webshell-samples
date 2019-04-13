<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
 

//

?> 
 
 
 <form method=post action="<?php echo $jumpv;?>&act=pos">
 
 
<?php
 $sql = "SELECT * from ".TABLE_COLUMN." where pid='$pid' and type='$type'   $andlangbh order by pos desc,id";
 
 $rowlist = getall($sql);
if($rowlist=='no') echo '暂无内容';
else{
foreach($rowlist as $v){
$pidname2=$v['pidname'];
$name=$v['name']; 
$tid=$v['id'];
$width=$v['width']; 
$floattype=$v['floattype']; 
$onlyposi=$v['onlyposi']; 

$floatV = select_return_string($arr_columnfloat,0,'',$floattype);
 

 if($floattype=='poa') $floattype='fl'; // admin not use poa

$sta_visi_v=$v['sta_visible']; 

menu_changesta($sta_visi_v,$jumpv,$tid,'sta');
 
 $jsname = jsdelname($v['name']);
 
$editlink='<a class=but1   href='.$jumpv.'&file=addedit&act=edit&tid='.$tid.'><i class="fa fa-pencil-square-o"></i> 配置</a> ';
//$editlink.='<a class=but1   href='.$jumpv.'&file=editcfg&act=edit&tid='.$tid.'>样式</a> ';
 
$del_text= " <a href=javascript:del('del','$pidname2','$jumpv','$jsname')  class=but2><i class='fa fa-trash-o'></i> 删除</a>";
  $movelink=' <a class=but3    href='.$jumpv.'&file=move&act=edit&tid='.$tid.'><i class="fa fa-files-o"></i> 复制</a>';
 
 
 if($floattype=='clear') 
  {
    ?>
    <div class="c adminclear"> 
    <div class="admincolinc">
   <div <?php echo $tr_hide;?>>
     <input type="text" name="<?php echo $tid;?>"  value="<?php echo $v['pos'];?>" size="3" />
 <strong class="cred">清除浮动</strong> 
 <div class="c5"></div>

  <?php 
   echo $editlink.$del_text; 
   ?> 
   <?php echo $sta_visible;?>

   </div> 
   </div>
    </div>
  <?php

}
 else {

  if($onlyposi=='y'){
    ?>
<div class="admincol <?php echo $floattype?> <?php echo $width?>">
<div class="admincolinc">
<div <?php echo $tr_hide;?>>
列名：<?php echo $name;?>

<div class="c5"></div>
 <input type="text" name="<?php echo $tid;?>"  value="<?php echo $v['pos'];?>" size="3" />
  
 <span class="cred" style="display: block;padding:10px">无内容，只占位置</span>  
  宽： <span class="cgreen"><?php echo $width;?></span>  | <span class="cblue"><?php echo $floatV;?></span>
<div class="c5"></div>
 <span class="cgray"><?php echo $pidname2;?> </span>

<div class="c5"></div>
 <?php echo $editlink.$del_text;?>


</div>
</div>
</div>

<?php
  }
  else {
 ?>


<div class="admincol <?php echo $floattype?> <?php echo $width?>">
<div class="admincolinc">
<div <?php echo $tr_hide;?>>
列名：<?php echo $name;?>

<div class="c5"></div>

 <input type="text" name="<?php echo $tid;?>"  value="<?php echo $v['pos'];?>" size="3" />
<div class="c5"></div>
<a class="but1"  href="<?php echo $jumpv?>&file=editcnt&pidname=<?php echo $pidname2?>"  style="font-weight: bold">[内容管理]</a>
<div class="c5"></div>
 宽： <span class="cgreen"><?php echo $width;?></span>  |  <span class="cblue"><?php echo $floatV;?></span>
<div class="c5"></div>
<span class="cgray"><?php echo $pidname2;?> </span>
<div class="c5"></div>
 <?php echo $editlink.$del_text;?>
<div class="c5"></div>
<?php echo $sta_visible;?>

</div>
</div>
</div>
    <?php
    }
     }
    ?>
 
 <?php 
}
}
?>
	
 <div class="c" style="height: 50px"> </div>
<div style="padding-bottom:22px;text-align:left">
<input class="mysubmit" type="submit" name="Submit" value="排序" />
<p><?php echo $sortid_asc?>
</p>
</div>
</form>