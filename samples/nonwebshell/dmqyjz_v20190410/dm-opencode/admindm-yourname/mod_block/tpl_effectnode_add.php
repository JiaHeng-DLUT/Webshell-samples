<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

/************************************************/

 
if($act=='insert')
{
 
$pidname = 'dhnode'.$bshou;
//need modtype is blockdh, grid.php need it............
$arr_can = 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##==#==';

//sta_search  -- must have, use for search condition.
$ss = "insert into ".TABLE_NODE." (ppid,pid,pidname,pbh,modtype,title,lang,sta_noaccess,sta_search,kv,kvsm,kvsm2,arr_can,despjj) values ('blockdh','$pid','$pidname','$user2510','blockdh','$abc1','".LANG."','n','n','','','','$arr_can','')";
 //echo $ss;exit;
iquery($ss);
//alert("添加成功");
 
jump($jumpvpid);
}
else{
  
?>


<form  onsubmit="javascript:return checkformself(this)" action="<?php echo $jumpv_file.'&act=insert'; ?>" method="post">
  <table class="formtab">
    <tr>
      <td width="12%" class="tr">标题：</td>
      <td width="88%"> <input name="name" type="text" value="" class="form-control" />
        <?php echo $xz_must;?>
        </td>
    </tr>


 
<tr>
      <td></td>
      <td> <br />
      <input class="mysubmit" type="submit" name="Submit" value="添加">
      <br /><br /><?php echo $note_addafter;?>
      </td>
    </tr>
  </table>
</form>
<script>
function  checkformself(thisForm)
{if (thisForm.name.value==""){
    alert("请输入标题");
    thisForm.name.focus();
    return (false);
        }
       
}
    </script>

<?php 
}
?>