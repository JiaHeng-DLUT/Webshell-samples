<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

?>

 <table class="formtab formtabhovertr">
<tr>
<td   align="center">标签  <a href="mod_tag.php?lang=<?php echo LANG?>&file=viewnode">(所有)</a></td>

 <td   align="center"> 内容 </td>
 <td   align="center"> 删除 </td>

</tr>
<?php
$wherev ='';
if($pid<>'') $wherev = " and tag='$pid'";

  $ss="select id,tag,node from  ".TABLE_TAGNODE."  where   $noandlangbh $wherev order by id desc";
	// echo $ss;exit;
   $num_rows = getnum($ss);
		  if($num_rows>0){


		  	  $offset=5;
       $maxline = 30;
       $key='';
        $page_total=ceil($num_rows/$maxline);

        if (!isset($page)||($page<=0)) $page=1;
        if($page>$page_total) $page=$page_total;
        $start=($page-1)*$maxline;
        $sqltextlist2="$ss  limit $start,$maxline";
        //echo $sqltextlist2;
        $res = getall($sqltextlist2);



		 foreach ($res as $key => $v) {
		 	 $tid = $v['id'];
             $tag = $v['tag'];
             $node = $v['node'];

             $name =  get_field(TABLE_TAG,'NAME',$tag,'pidname');
             $nodetitle = get_field(TABLE_NODE,'title',$node,'pidname');

             $jsname = jsdelname($name);


             $del_text= " <a href=javascript:delid('del_tagnode','$tid','$jumpv','$jsname')  class=but2><i class='fa fa-trash-o'></i> 删除</a>";


		  			?>
<tr>
<td  align="center">
<?php




  $ssc="select id from  ".TABLE_TAGNODE."  where tag='$tag'   $andlangbh";
  $ssnum = getnum($ssc);

 $view = '<a href="'.$jumpv.'&file=viewnode&pid='.$tag.'">'.$name.'('.$ssnum.')</a>';

echo $view;


 ?>



</td>

<td  align="center">
<?php
echo $nodetitle;
$tid = get_field(TABLE_NODE,'id',$node,'pidname');

 ?>

	 [<a target="_blank" href="../mod_node/mod_node_edit.php?lang=<?php echo LANG?>&tid=<?php echo $tid;?>&act=list&file=edittag">修改</a>]


</td>
 <td   align="center"> <?php echo $del_text;?> </td>

</tr>

		  			<?php
		  			# code...
		  		}


		   }
		   else echo '<tr><td> </td><td  align="center"><strong>暂无内容</strong></td><td> </td></tr>';


?>
</table>


 <div class="c"></div>
<?php
require_once HERE_ROOT.'plugin/page_2010.php';
?>
