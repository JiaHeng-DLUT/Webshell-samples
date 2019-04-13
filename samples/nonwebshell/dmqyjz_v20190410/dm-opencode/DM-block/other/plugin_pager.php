<?php
 
$page_canshu=substr($page_canshu,0,-5);;

 if($page_total==0) $page_total=1; //prevent the  loop
 if($page>$page_total) jump("$page_canshu-$page_total.html"); 
 if($page<=0)  jump("$page_canshu-1.html");
//if($page>$page_total) jump($var404); 
//if($page<=0)  jump($var404);
if($page_total>1){  
?>
<div class="c"></div>
<div class="pageroll">
<?php

$back=$page-1;
if($back>=1){
  $page_pre = "<a href=$page_canshu-$back.html>".PAGER_PREV."</a>"; //上一页
$page_first = "<a href=$page_canshu.html>".PAGER_FIRST."</a>"; //首页
}
else {
    $page_pre = "<span>".PAGER_PREV."</span>";
$page_first = "<span>".PAGER_FIRST."</span>";
}

$next=$page+1;
if ($next<=$page_total){
    $page_next = "<a class=next href=$page_canshu-$next.html>".PAGER_NEXT."</a>"; //下一页class=next is for masonry
$page_last = "<a href=$page_canshu-$page_total.html>".PAGER_LAST."</a>";//末页
}
else{
    $page_next ="<span>".PAGER_NEXT."</span>";
$page_last = "<span>".PAGER_LAST."</span>";
}
?>

<?php
echo $page_first.$page_pre.'<div class="pagerinc">';

    for ($i=$page-$offset;$i<=$page+$offset;$i++)
    {
    if (($i>=1)&&($i<=$page_total)&&($i!=$page))
    echo "<a href=$page_canshu-$i.html>$i</a>";
    if ($i==$page)
    echo "<a href=$page_canshu-$i.html class=cur>$i</a>";
    }
echo '</div>'.$page_next.$page_last;
?>

</div>

<?php } ?>

