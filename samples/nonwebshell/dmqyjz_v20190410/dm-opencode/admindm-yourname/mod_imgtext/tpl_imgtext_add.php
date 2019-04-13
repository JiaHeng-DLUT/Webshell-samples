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

$pidname = 'simgtext'.$bshou;
$arr_can = 'cssname:##==#==cssstyle:##==#==fullwidth:##n==#==titlefg:##notitle==#==format:##imgtop==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##';

$ss = "insert into ".TABLE_IMGTEXT." (pid,pidname,pbh,title,arr_can,lang) values ('$pid','$pidname','$user2510','$abc1','$arr_can','".LANG."')";
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
