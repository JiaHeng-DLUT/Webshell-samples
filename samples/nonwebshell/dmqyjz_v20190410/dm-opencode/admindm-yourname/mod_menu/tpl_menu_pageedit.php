<?php
/*
  power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}


 if($act=='update'){
// pre($_POST);

  if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}


 
     $ss = "update ".TABLE_MENU." set  pid='$abc1' where ppid='$ppid' and id='$tid' $andlangbh limit 1";
   // echo $ss;exit;
    iquery($ss);  
  jump($jumpv);
 }

 else
 {
 $ss = "select * from ".TABLE_MENU." where id='$tid' $andlangbh limit 1"; 
 $row = getrow($ss);
 
 ?>
  <form  action="<?php echo $jumpvf; ?>&act=update&tid=<?php echo $tid?>" method="post" enctype="multipart/form-data">

 
  <table class="formtab" >
  

 <tr>
    <td width="20%" class="tr">选择上一级菜单：</td>
    <td  >
  <select name="pcla"><option value='0'>主菜单</option>
  <?php
     $pid=$row['pid'];
      
     $sql = "select * from ".TABLE_MENU." where id<>'$tid' and ppid='$ppid' and  pid='0'  $andlangbh order by pos desc,id";
     //echo $sql;
     //only show page, if cate menu want have page,then do it by give sub cate a filed.
     if(getnum($sql)>0) {
       $rowall = getall($sql);
   
        foreach ($rowall as $v){
             $sta_visi = $v['sta_visible'];
         $sta_visi_v = string_stavisi($sta_visi); 
         $pagename = $v['name'];
         $pidname = $v['pidname'];
          $type = $v['type'];
          $stringfour = substr($type,0,4);
               
        
             // if($vcla['pidname'] == intval($pid)) $selected2=' selected=selected';else $selected2='';
           if($pidname ==$pid) $selected2=' selected=selected';else $selected2='';
   
          if($stringfour=='page')  $pagename = get_field(TABLE_PAGE,'name',$type,'pidname');
          if($stringfour<>'cate')      echo '<option '.$selected2.' value='.$pidname.'>&nbsp;&nbsp;├ '.decode($pagename).$sta_visi_v.'</option>';
         }
        }  
      
  
  // select_cate_menu($row_menu_degree,$tid,$table);
    ?>
</select>
 </td>
  </tr>

   <tr>     
       <td  class="tr"></td>
      <td> 
        <input class="mysubmit"  type="submit" name="Submit" value="提交" /> 
 </td>
</tr>


</table>


  
 
 
<div class="c tc"> 
 
  
<?php echo $inputmust;?>
 </div>

 </form>
<?php
  }
  ?>
 
 