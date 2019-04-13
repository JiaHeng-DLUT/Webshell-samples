<?php
if($page_total>1){
    $page_canshu='catpid='.$catpid.'&catid='.$catid.'&file='.$file.'&type='.$type.'&key='.$key.'&lang='.LANG;
?>
<div class="pageroll">
<?php

$back=$page-1;
if($back>=1){
  $page_pre = "<a href=$PHP_SELF?page=$back&$page_canshu>上一页</a>&nbsp;";
$page_first = "<a href=$PHP_SELF?page=1&$page_canshu>首页</a>&nbsp;";
}
else {
    $page_pre = '上一页&nbsp;';
$page_first = "首页&nbsp;";
}

$next=$page+1;
if ($next<=$page_total){
    $page_next = "<a href=$PHP_SELF?page=$next&$page_canshu>下一页</a>&nbsp;";
$page_last = "<a href=$PHP_SELF?page=$page_total&$page_canshu>末页</a>";
}
else{
    $page_next ='下一页&nbsp;';
$page_last = "末页";
}

?>

<div class="fl">
共<span class=cred><?php echo $num_rows;?></span>条记录 /
每页<span class=cred><?php echo $maxline;?></span> /
共<span class=cred><?php echo $page_total;?></span>页

<?php
echo $page_first.$page_pre;

    for ($i=$page-$offset;$i<=$page+$offset;$i++)
    {
    if (($i>=1)&&($i<=$page_total)&&($i!=$page))
    echo "<a href=$PHP_SELF?page=$i&$page_canshu>$i</a>&nbsp;";
    if ($i==$page)
    echo "<a href=$PHP_SELF?page=$i&$page_canshu class=cur>$i</a>&nbsp;";
    }
echo $page_next.$page_last;
?>
</div>

<div class="c"></div>
</div>
<?php } ?>
