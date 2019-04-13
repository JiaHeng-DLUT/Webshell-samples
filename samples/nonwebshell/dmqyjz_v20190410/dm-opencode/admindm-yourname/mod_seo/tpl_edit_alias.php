<?php
/*
  power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}


  
 if($act=='update'){


//pre($_POST);
 
 
   if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}
 
   if($abc1==''){

     $sql = "SELECT id from ".TABLE_ALIAS."  where   pid = '$pidname'     $andlangbh   order by id limit 1";
    if(getnum($sql)>0) { 

     //alert('别名不能为空。如果要删除别名，请到别名管理里操作。'); 
     alert('别名为空。即将删除别名。'); 
     $sql = "delete from ".TABLE_ALIAS."  where  pid='$pidname'     $andlangbh   order by id limit 1";
     iquery($sql);  
     jump($jumpv.'&act=edit');
   }
   else {
    alert('别名不能为空。'); 
    jump($jumpv.'&act=edit');
   } 
 }

  // $abc1 = str_replace(" ", "_", $abc1);
  // $abc1 = str_replace("-", "_", $abc1);

//$arr = array(" ", "-");
$arr = array("     ","    ","   ","  "); 
 $abc1 = str_replace($arr, " ", $abc1);
 $abc1 = str_replace(" ", "-", $abc1);
 $abc1 = str_replace("\'", "", $abc1);  
 $abc1 = str_replace('\"','', $abc1);
 $abc1 = str_replace('\&quot;','', $abc1);

 

 $sql = "SELECT id from ".TABLE_ALIAS."  where   name = '$abc1'  and pid<>'$pidname' $andlangbh   order by id limit 1";
 //only where need name.
 
          if(getnum($sql)>0) {
              alert('出错，别名已存在');
              jump($jumpv.'&act=edit');
            }



$sqlalias = "SELECT id from ".TABLE_ALIAS."  where  pid='$pidname'   $andlangbh   order by id limit 1";
if(getnum($sqlalias)>0)   $ss = "update ".TABLE_ALIAS." set name='$abc1' where pid='$pidname'   $andlangbh limit 1";
else  $ss = "insert into ".TABLE_ALIAS." (pid,pbh,lang,name) values ('$pidname','$user2510','".LANG."','$abc1')"; 
 // echo $ss;exit;
 
   iquery($ss);   
   jump($jumpv.'&act=edit');
 }


 else
 {
 

 $sql = "SELECT * from ".TABLE_ALIAS."  where  pid='$pidname' $andlangbh   order by id limit 1";
    if(getnum($sql)>0) {
           $row = getrow($sql);
          $namealias = $row['name'];
    }
    else{ 
         $namealias = ''; //not alias,then insert.
         //echo '没有找到别名, 来自：'.$pidname;exit;
    }
  
 //------------
$pid4 = substr($pidname,0,4);
$pid3 = substr($pidname,0,3);
if($pid3=='tag') $pid4='tagg';
if($pid4=='page') $table = TABLE_PAGE;
elseif($pid4=='cate' || $pid4=='csub') $table = TABLE_CATE;
elseif($pid4=='node') $table = TABLE_NODE;
elseif($pid4=='tagg') $table = TABLE_TAG;


$sql = "SELECT * from ".$table."  where  pidname='$pidname' $andlangbh   order by id limit 1";
$row = getrow($sql);
if($row=='no') { echo '没有记录，来自：'.$table.' - '.$pidname;exit; }

//$url = get_url($row);
if($pid4=='page') {
  $name=decode($row['name']);  
  $title2 = ' (单页面：'.$name.')';
}
elseif($pid4=='cate' || $pid4=='csub') {
  $name=decode($row['name']);
  $title2 = ' (分类：'.$name.')';
}
elseif($pid4=='node') {
  $name=decode($row['title']);
  $title2 = ' (文章：'.$name.')';
}
elseif($pid4=='tagg') {
  $name=decode($row['name']);
  $title2 = ' (标签'.$name.')';
}
?>

 <div style="background:#e2e2e2;padding:10px;">
 <a style="font-size:16px;font-weight:bold" target="_blank" href="../mod_seo/mod_alias.php?lang=<?php echo LANG;?>">别名管理</a>  </div> 
 

<form onsubmit="return formvalidate()"   action="<?php echo $jumpv; ?>&act=update"   method="post" enctype="multipart/form-data">
<table class="formtab">


<tr>
    <td width="12%" class="tr">标题：</td>
    <td width="88%"><span class="copytoaliasfrom"><?php echo $name;?></span>  
       <a href="javascript:void(0)" title="仅适用于英文标题" class="jscopytoalias  but2">复制到别名</a>
       <p><?php 
         echo admlink($row);
        ?></p>
    </td>
    </tr>
  <tr>
    <td width="12%" class="tr">别名：</td>
    <td width="88%">
    <?php 
$disv = $disvdesp = '';
if($namealias=='index'){

    $disv = ' disabled = "disabled"';
    $disvdesp = '<p class="cred">index是首页的别名，不能修改。</p>';

}

?>


    <br /><input name="alias" <?php echo $disv;?> type="text"  value="<?php echo $namealias;?>" class="copytoaliasto form-control" />
  <?php echo $disvdesp;?>
  
  <p class="hintbox">提示：<br>
    只能用英文或数字或一杠或下划线，不能有空格，引号，否则修改时，会自动替换为一杠。   <br />
    多个字符，请用一杠连接)    <br />
   (<strong>主分类必须要有别名</strong>，其他子分类或菜单等没有的话可以不填。)
 
  </p>
  

  </td>
  </tr>

 
 </table>


<div class="c tc"> 
 
 <input class="mysubmit"     type="submit" name="Submit" value="提交" /> 
     
<?php echo $inputmust;?>
 </div>

 </form>
<?php
  }
  ?>
  
 
  <script>
function formvalidate(){
   // var valias = $.trim($('.formtab input[name=alias]').val());
    // if(valias=='') {
    //  alert('别名不能为空。如果要删除别名，请到别名管理里操作。'); 
     // $('.formtab input[name=alias]').focus();
      //  return false;
    //  }

   // var v = '=='+valias;
   // var indexv = v.indexOf('-');
   // if(indexv!=-1)  {alert('别名不能有杠，可以有下划线。'); return false;}

   //  var indexv = v.indexOf(' ');
   // if(indexv!=-1)  {alert('别名不能空格，可以有下划线。'); return false;}



}

 </script>
