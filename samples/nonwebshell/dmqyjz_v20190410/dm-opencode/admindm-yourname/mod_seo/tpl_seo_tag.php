<section class="content-header">
 <h1>标签SEO</h1>
</section>
<?php
 $sql = "SELECT * from ".TABLE_TAG." where   $noandlangbh  order by pos desc,id";
$rowlist = getall($sql);
 if($rowlist=='no') echo $norr2;
 else{

echo '<ul class="seolist">';
   foreach($rowlist as $v){

  $pidname = $v['pidname'];
  $name = '<strong>'.decode($v['name']).'</strong>';
  $seo1 = spangray($v['seo1']);
  $seo2 = spangray($v['seo2']);
  $seo3 = spangray($v['seo3']);

 $seoedit = ' &nbsp;&nbsp;<a class="needpopup" href="'.$jumpv_seoedit.'&pidname='.$pidname.'&type=page">修改SEO</a> | ';

 $alias = alias($pidname);
   if($alias<>'') $alias =  '( '.spangray($alias).' )';
   else $alias='';

 $aliasedit = ' <a class="needpopup" href="'.$jumpv_aliasedit.'&pidname='.$pidname.'">修改别名</a>'.$alias;
 
   ?>
   <li>
   <h3><?php   echo $name.$seoedit.$aliasedit; ?> </h3>


    <div class="tdk">title: <?php   echo $seo1; ?><br />
    descriptiton: <?php   echo $seo3; ?><br />
    keywords: <?php   echo $seo2; ?><br />
    </div>
</li>
   <?php

  }

echo '</ul>';
}?>
