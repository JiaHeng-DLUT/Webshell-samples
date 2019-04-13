<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
<?php
 
   $sql = "SELECT * from ".TABLE_IMGTEXT." where pid='$pid'   $andlangbh order by pos desc,id "; 
   if(getnum($sql)==0){ 
          echo '<br><br>没有找到相关内容。'; 
}
    else {
        $rowlisttext = getall($sql); 
 ?>
 
<div style="padding:5px;display:none">
  <form id="search_form" action="<?php echo  $jumpvpid;?>" method="post" accept-charset="UTF-8">         
  <input class="navsearch_input" type="text" name="searchword" value="请输入文章标题" style="width:350px;padding:5px;" onfocus="javascript:this.value='';" /> 
  <input type="submit" name="Submit" value="搜索" class="searchgo" style="padding:5px 10px;cursor:pointer" />
  </form> 
  </div>
  
<form method=post action="<?php echo $jumpvpid;?>&act=pos">
  <table class="formtab formtabhovertr">
  <tr style="font-weight:bold;background:#eeefff">
  <td   align="center">排序号</td>
    <td   align="center">标题</td>
   <td   align="center">图片</td>
  
    <td  align="center">操作</td>

    <td   align="center">状态</td>
  
  </tr>
  <?php

        foreach($rowlisttext as $v){
		//echo print_r($rowlist,1);
		
            $tid = $v['id'];
            $jsname = jsdelname($v['title']);
			$name = '<strong>'.$v['title'].'</strong>';
		 
		 
      $desptext = $v['desptext'];$desp = $v['desp']; 
    
        $despv = $desptext<>''?$desptext:$desp;
       
			$pid = $v['pid'];
			$pidname = $v['pidname'];
      
      $kv = $v['kv'];  
 
      $arr_can = $v['arr_can'];
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

      

 menu_changesta($v['sta_visible'],$jumpvpid,$tid,'sta_node');
 
$edit_text= "<a class='but1' href='$jumpv&file=edit&tid=$tid&act=edit'><i class='fa fa-pencil-square-o'></i> 修改</a>";
 
 
$del_text= " <a href=javascript:del('delnode','$pidname','$jumpvpid','$jsname')  class=but2><i class='fa fa-trash-o'></i> 删除</a>";

?>
  <tr <?php echo $tr_hide?>>
  <td align="center"><input type="text" name="<?php echo $tid;?>"  value="<?php echo $v['pos'];?>" size="5" /></td>


    <td align="left">

 <?php echo $name;?> <br />

  <?php
 
  if($despv<>'') echo '内容：'.substr($despv,0,200).'<br />';
  
  ?>
 
 </td>


<td align="center"  class="tc">
<div class="imgbg1">
<?php 
echo  p2030_imgyt($kv,'y','n');


?>
</div>

<p><a class="needpopup but4 pad8lr" style="width:auto"  href="../mod_module/mod_uploadkv.php?lang=<?php echo LANG?>&pidname=<?php echo $pidname?>&type=imgtextkv">修改kv图</a></p>
 </td>

 

  <td align="center"><?php echo $edit_text.$del_text;?></td>

    <td> <?php   echo $sta_visible;?></td>
    
  </tr>
<?php

    } ?>
</table>


<div style="padding-bottom:22px"><input class="mysubmit" type="submit" name="Submit" value="修改排序" />
<?php echo $sortid_asc;?></div>
</form>

<?php 
}
?>
 
 