<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

?>

 
<?php 
 

	 $sql = "SELECT * from ".TABLE_PAGE." where  pid='0'  $andlangbh  order by pos desc,id";
	 //ECHO $sql;
	 $rowlist = getall($sql);
    if($rowlist == 'no')  echo '<p style="padding:55px;background:#eee">没有菜单，请添加。</p>';
    else {
	?>
 
<form method=post action="<?php echo $jumpv;?>&act=pos">
<table class="formtab formtabhovertr" style="width:100%">
  <tr style="font-weight:bold;background:#eeefff">
  <td align="center">排序号</td>
    <td>名称</td>
    
    <td   align="center">修改</td>
   
    <td  align="center">状态</td>
  

  </tr> 
  <?php
      foreach($rowlist as $v){
            $tid = $v['id'];
            $pidname = $v['pidname'];
            $name = decode($v['name']);
             $jsname = jsdelname($name);
			   $arr_can = $v['arr_can'];
          
           $sta_noaccess = $v['sta_noaccess'];
            $sta_visi_v = $v['sta_visible']; 


//------------
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
    
    //-----------------

 			 			
            //
        $sta_noaccess_v = string_staaccess($sta_noaccess);
           // menu_changesta($sta_visi_v,$jumpv,$tid);//trbg and tr_hide is in here
			 menu_changesta($sta_visi_v,$jumpv,$tid,'sta_menu');
			  
			 
  
               
   $pageurl=admlink($v);

 
				 
   $edit_desp='<a class="but1"   href='.$jumpv_edit.'&file=edit_desp&act=edit&tid='.$tid.'><i class="fa fa-pencil-square-o"></i> 修改</a>';
			 

  //$del_text= "<a href=javascript:del('delpage','$pidname','$jumpv','$jsname')  class=but2><i class='fa fa-trash-o'></i> 删除</a>";
            


    ?>
  <tr  <?php echo $tr_hide;?> style="border-top:2px solid #999">
  <td align="center"><input type="text" name="<?php echo $tid;?>"  value="<?php echo $v['pos'];?>" size="5" /></td> 

    <td align="left">
	<strong><?php echo $name;?></strong> 
		<br /><?php echo $pidname;?>
		<br /><?php echo  $pageurl;?> </i>

	</td>
  
    <td align="center"><?php  echo $edit_desp;?></td>
    <td align="center"> <?php   echo $sta_visible.$sta_noaccess_v;?></td>
    
  </tr>
<?php 
}
?>

</table>
<div style="padding-bottom:22px"><input class="mysubmit" type="submit" name="Submit" value="排序" />
<br />
<?php echo $sortid_asc?></div>
</form>
 


<?php 
}
?>
<p class="cred ptb10"><?php echo $text_adminhide2;?></p>
