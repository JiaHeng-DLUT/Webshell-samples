<section class="content-header">
 <h1>分类SEO</h1>
</section>
<?php
 $sqlmain = "SELECT * from ".TABLE_CATE." where  pid='0' and modtype='node' $andlangbh order by pos desc,id";
 $rowlistmain = getall($sqlmain);
 if($rowlistmain=='no') {
  echo '<p>&nbsp;&nbsp;还没有分类，请添加...</p>';
  }
  else{

  echo '<ul class="seolist ">';
   foreach($rowlistmain as $vmain){
        $pidnamemain=$vmain['pidname'];
        $namemain='<strong>'.decode($vmain['name']).'</strong>';
         $seo1=spangray(decode($vmain['seo1']));
          $seo2=spangray(decode($vmain['seo2']));
          $seo3=spangray(decode($vmain['seo3']));

          $seoedit = ' &nbsp;&nbsp;<a class="needpopup" href="'.$jumpv_seoedit.'&pidname='.$pidnamemain.'&type=cate">修改SEO</a> | ';
 $alias = alias($pidnamemain,'cate');
  if($alias<>'') $alias =  '( '.spangray($alias).' )';
   else $alias='';
 $aliasedit = ' <a class="needpopup" href="'.$jumpv_aliasedit.'&pidname='.$pidnamemain.'&type=cate">修改别名</a>'.$alias;


 $jumpvnode2= $jumpvnode.'&catpid='.$vmain['pidname'].'&catid='.$vmain['pidname'];

$nodeseo = ' | <a target="_blank" href="'.$jumpvnode2.'">内容seo</a>';

        echo '<li>';
        echo '<h3> '.$namemain.$seoedit.$aliasedit.$nodeseo.' </h3>';
        echo '<div class="tdk">title: '.$seo1.'<br />descriptiton: '.$seo3.'<br />keywords: '.$seo2.'</div>';


        $sqlsub = "SELECT * from ".TABLE_CATE." where  ppid='$pidnamemain' $andlangbh order by pos desc,id";
        $rowlistsub = getall($sqlsub);
        if($rowlistsub=='no') {
          echo '<p>&nbsp;&nbsp;还没有子分类，请添加...</p>';
          }
          else{
            $indexarr = indexingarr($rowlistsub);
            $getnewarr = getnewtreearr($indexarr);
            echo '<ul class="seolist seolistcate">';
           echo   echoarrhtml($getnewarr);
          // pre($getnewarr);
            echo '</ul>';
          }
  echo '</li>';
     }
     echo '</ul>';
    }
 ?>    


 
 <?php
 function echoarrhtml($tree,$multicate='')
 {
 global $jumpv_seoedit;  global  $jumpv_aliasedit;global  $jumpvnode;
 $html = '';
 foreach($tree as $vsub)
 {
   
  $jumpvnode2= $jumpvnode.'&catpid='.$vsub['ppid'].'&catid='.$vsub['pidname'];
  
  $nodeseo = ' | <a target="_blank" href="'.$jumpvnode2.'">内容seo</a>';


  $pidname=$vsub['pidname'];
  $name='<strong>'.decode($vsub['name']).'</strong>';
  $seo1S=spangray(decode($vsub['seo1']));
  $seo2S=spangray(decode($vsub['seo2']));
  $seo3S=spangray(decode($vsub['seo3']));

  $seoedit2 = ' &nbsp;&nbsp;<a class="needpopup" href="'.$jumpv_seoedit.'&pidname='.$pidname.'&type=cate">修改SEO</a> | ';
   $alias2 = alias($pidname,'cate');
   if($alias2<>'') $alias2 =  '( '.spangray($alias2).' )';
   else $alias2='';
   $aliasedit2 = ' <a class="needpopup" href="'.$jumpv_aliasedit.'&pidname='.$pidname.'&type=cate">修改别名</a>'.$alias2;

  
 
   if(@$vsub['son'] == '')
   {
    $html .= '<li><h3> ├ '.$name.$seoedit2.$aliasedit2.$nodeseo.' </h3><div class="tdk">title: '.$seo1S.'<br />descriptiton: '.$seo3S.'<br />keywords: '.$seo2S.'</div></li>';
   }
   else
   {
    $html .= '<li><h3>├  '.$name.$seoedit2.$aliasedit2.$nodeseo.' </h3><div class="tdk">title: '.$seo1S.'<br />descriptiton: '.$seo3S.'<br />keywords: '.$seo2S.'</div><ul class="seolist seolistcate">';	  
     if(MULTICATE=='y' || $multicate=='')  $html .= echoarrhtml($vsub['son'],MULTICATE);
    $html = $html."</ul></li>";
   }
 }
  //return $html ? '<ul class="seolist seolistcate">'.$html.'</ul>' : $html ;
   return $html;
 }
  
 
 ?>