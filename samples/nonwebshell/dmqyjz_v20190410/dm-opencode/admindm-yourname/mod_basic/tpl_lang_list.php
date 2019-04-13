<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

/*
//no need main lang in programme,will set in config.php
$sqlmain = "SELECT * from ".TABLE_LANG." where   sta_main='y' and pbh='".USERBH."' order by id limit 1";
 //echo $sqlmain;
		//echo getnum($sqlmain);
		if(getnum($sqlmain)==0){
		  $errortextlang = '提示：目前没有主语言，网站必须要有一个主语言，请在 “语言设置” 里选一个。';
		   alert($errortextlang);
		   echo '<p style="background:red;color:#fff">'.$errortextlang.'</p>';
		}

*/

?>

<form method=post action="<?php echo $jumpv;?>&act=pos">
 <table class="formtab">
<tr>
<td   align="center">排序号</td>
<td  align="left">站点(语言)说明</td>
<td  align="center">操作</td>

<td  align="center">管理</td>
 <td  align="center">状态</td>
 <td  align="center">删除</td>
</tr>
<?php
 $sql = "SELECT * from ".TABLE_LANG." where pbh='".USERBH."' order by pos desc,id";
$rowlist = getall($sql);
if($rowlist=='no') echo '暂无内容';
else{
foreach($rowlist as $v){

$tid=$v['id'];
$lang=$v['lang'];
$langpath=$v['langpath'];
$domain=$v['domain'];
$langfile=$v['langfile'];
$sta_visi_v=$v['sta_visible'];

$sta_main=$v['sta_main'];
$sitename=$v['sitename'];


 menu_changesta($sta_visi_v,$jumpv,$tid,'sta');

 $edit_desp = '<a class="but1" href="'.$jumpvnolang.'?lang='.$lang.'&file=basicset&act=edit&tid='.$tid.'">修改</a>   ';
 $edit_desp2 ='';

//   $edit_desp2 = '<a class="but2" href="'.$jumpvnolang.'?lang='.$lang.'&file=edit&act=edit&tid='.$tid.'">语言设置</a>';
 //$edit_desp3 = '<a class="but3" href="'.$jumpvnolang.'?lang='.$lang.'&file=assets&act=edit&tid='.$tid.'">资源设置</a>   ';

 $del = " <a class='but2'  href='$jumpv&file=del&type=$lang'><i class='fa fa-trash-o'></i> 删除</a>";


 ?>



 <tr <?php echo $tr_hide;?>>
 <td align="center">
 <input type="text" name="<?php echo $tid;?>"  value="<?php echo $v['pos'];?>" size="5" />
 </td>
  <td align="left">
  <?php
  //echo select_return_string($arr_lang,0,'',$lang);

$imgpath = STAPATH.'img/langimg/'.$lang.'.gif';
$imgroot = STAROOT.'img/langimg/'.$lang.'.gif';

if(!is_file($imgroot)) $imgpath = STAPATH.'img/langimg/langdefault.gif';

  echo '网站ID：<span class="cred">'.$lang.'</span>';
  echo ' <img src="'.$imgpath.'" alt="" />';
echo  ' 网站名称：'.$sitename;
  if($lang == $mainlang) echo  ' <br /><strong class="cred">当前为主语言</strong>';

  ?>
 <br />后缀：<span class="cgray"> <?php echo $langpath;?>  </span>
 <br />域名：<span class="cgray"> <?php echo $domain;?>  </span>
 <br />语言文件：<span class="cgray"> <?php echo $langfile;?>  </span>

 <br />  <?php

  $js_back = $jumpv_file.'&tid='.$tid;


 //if($sta_main=='y') echo  '<strong class="cred">当前为主语言</strong>';
 //else  echo  " <a href=javascript:confirmaction('setlangdefault','notdel','$js_back','一个网站只能有一个主语言！确认要设置此语言为主语言？')  ><i class='fa fa-pencil-square-o'></i> 设为主语言</a>";

  ?>
 </td>


 <td align="center"><?php echo $edit_desp.$edit_desp2;?></td>


  <td align="center">


  <?php
  if($lang==LANG) {
		echo ' <div  style="padding:30px 0;background:red;color:#fff"">正在管理此站点</div> ';

     $sql = "SELECT * from ".TABLE_LANG." where pbh='".USERBH."' order by pos desc,id";
    if(getnum($sql)>1) 	echo '<a href="../mod_daodaodao---/mod_delotherlang---.php?lang='.LANG.'" target="_blank">删除其他语言</a>';

	}
  else   echo   '   <a   href="mod_lang.php?lang='.$lang.'">管理网站></a> ';

  ?>
   </td>



  <td align="center"><?php echo $sta_visible;?></td>
  <td align="center"><?php
  //echo $sta_visi_v;
  if($lang==LANG || $lang == $mainlang) {}
  else  {
      if($sta_visi_v=='n') echo $del;

  }
  ?></td>

 </tr>
 <?php
}
}
?>
</table>

<div style="padding-bottom:22px"><input class="mysubmit" type="submit" name="Submit" value="排序" />
<br />
<?php echo $sortid_asc?></div>
</form>
