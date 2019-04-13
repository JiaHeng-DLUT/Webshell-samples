<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

?>

 
<?php 
 

	 $sql = "SELECT * from ".TABLE_MENU." where  ppid='0'   $andlangbh  order by pos desc,id desc";
	 //ECHO $sql;
	 $rowlist = getall($sql);
    if($rowlist == 'no')  echo '<p style="padding:55px;background:#eee">没有菜单，请添加。</p>';
    else {
	?>
 
<form method=post action="<?php echo $jumpv;?>&act=pos">
<table class="formtab" style="width:100%">
  <tr style="font-weight:bold;background:#eeefff">
  <td   align="center">排序号</td>
  
    <td   align="left">标题</td>
     <td    align="center">操作</td>
    
  
  </tr> 
  <?php
      foreach($rowlist as $v){
            $tid = $v['id'];
            $pidname = $v['pidname'];
            $name = $v['name']; $jsname = jsdelname($v['name']);
            $sta_cusmenu = $v['sta_cusmenu'];
          
            
 $edit_desp='<a class="but1"   href='.$jumpvedit.'&tid='.$tid.'><i class="fa fa-pencil-square-o"></i> 修改</a>';

 if($sta_cusmenu=='y')  $gl_desp= $name. '<span class="cred">(提示：已启动自定义菜单)</span>';
 else  $gl_desp='<a  style="font-size:16px"  href="mod_menu.php?ppid='.$pidname.'&lang='.LANG.'"><strong>'.$name.'</strong></a>';
          
 $delmenu= " <a class='but2'  href=javascript:del('del','$pidname','$jumpv','$jsname')> <i class='fa fa-trash-o'></i> 删除</a>";
 //if($pidname == $pidmenu)  $delmenu='';

 $sqlll =  "SELECT id from ".TABLE_MENU." where  ppid='$pidname'   $andlangbh  order by pos desc,id";
 if(getnum($sqlll)>0)  $delmenu='';
  

$tr_hide ='';

    ?>
  <tr  <?php echo $tr_hide;?> style="border-top:2px solid #999">
  <td align="center"><input type="text" name="<?php echo $tid;?>"  value="<?php echo $v['pos'];?>" size="5" /></td> 

    <td align="left">
<?php  echo $gl_desp?>
<br />
    标识： <?php echo $pidname;?>
    <?php
      if($pidname == $pidmenu) {echo '<br /><span class="cred">正在使用</span>';}
    ?>
    </td>
 
    <td align="center"><?php  echo $edit_desp.$delmenu?></td>
  
     
  </tr>
<?php
    
    } ?>
</table>
<div style="padding-bottom:22px"><input class="mysubmit" type="submit" name="Submit" value="排序" />
<br />
<?php echo $sortid_desc?></div>
</form>
 


<?php 
}