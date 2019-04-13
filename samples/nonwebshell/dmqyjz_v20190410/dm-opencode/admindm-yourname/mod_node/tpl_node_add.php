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


 ifhaspidname(TABLE_CATE,$abc2);
 
$pidname = 'node'.$bshou;

 
 
 $sta_noaccess='n';
 if($user_stanoaccess=='y' && $usertype=='normal')  $sta_noaccess='y';



$ss = "insert into ".TABLE_NODE." (ppid,pid,pidname,pbh,title,lang,arr_can,sta_noaccess,dateedit) values ('$catpid','$abc2','$pidname','$user2510','$abc1','".LANG."','$arr_nodeV','$sta_noaccess','$dateedit')";
//echo $ss;exit;
iquery($ss);
//alert("添加成功");
 $jump_back = $jumpv.'&catid='.$abc2;
 
jump($jump_back);
}
else{

  $jumpv_insert= $jumpv_catid.'&file=add&act=insert';

?>
 
<form  onsubmit="javascript:return checkformself(this)" action="<?php echo $jumpv_insert; ?>" method="post">
  <table class="formtab">
    <tr>
      <td width="12%" class="tr">标题：</td>
      <td width="88%"> <input name="name" type="text" value="" class="form-control" />
        </td>
    </tr>
  <tr>
      <td  class="tr">分类：</td>
      <td>
<?php  
 //------------
 $sqlcatlist = "SELECT * from ".TABLE_CATE." where  pid='$catpid' $andlangbh order by pos desc,id";
  //echo $sqlcatlist;
$rowcatlist= getall($sqlcatlist);
 
    select_cate($rowcatlist,'分类',$catid);//in list left menu php
   ?>
</td></tr>
 
<tr>
      <td></td>
      <td> <br />
      <input class="mysubmit" type="submit" name="Submit" value="添加">
      <br /><br /><?php echo $note_addafter;?>
      </td>
    </tr>
  </table>
</form>

<?php
}
?>
<script>
function  checkformself(thisForm)
{if (thisForm.name.value==""){
		alert("请输入名称或标题");
		thisForm.name.focus();
		return (false);
        }
        if (thisForm.pid.value==""){
		alert("请选择分类");
		thisForm.pid.focus();
		return (false);
        }
}
    </script>

