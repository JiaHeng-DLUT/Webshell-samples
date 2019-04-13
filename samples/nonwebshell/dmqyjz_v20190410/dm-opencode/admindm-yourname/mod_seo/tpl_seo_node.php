<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}
?>
<section class="content-header">
 <h1><?php
 echo decode(get_field(TABLE_CATE,'name',$catid,'pidname'));
 ?></h1>
</section>
 <div style="padding:15px 0">
<form onsubmit="javascript:return checksearch(this)" id="search_form" action="<?php echo $jumpv.'&catpid='.$catpid.'&catid='.$catid;?>" method="post" accept-charset="UTF-8">
 搜索： <input class="navsearch_input" type="text" name="searchword" value="请输入标题" style="width:250px;padding:5px;" onfocus="javascript:this.value='';" />
  <input type="submit" name="Submit" value="搜索" class="searchgo" style="padding:5px 10px;cursor:pointer" />
  </form>
</div>

<?php

  $key = @htmlentitdm($_POST['searchword']);

  if($key == "") $keyV="" ;
  else   $keyV="and title like '%$key%'" ;

 $catid_v = wherecatev($catpid,$catid);


     $sqltextlist = "SELECT title,pidname,seo1,seo2,seo3 from ".TABLE_NODE." where $catid_v  $keyV  $andlangbh order by pos desc,dateedit desc"; //pos desc,id desc
  //echo $sqltextlist;
    /*begin page roll*/
     $num_rows = get_numrows($sqltextlist);
     if($num_rows==0){
      echo '<br /><br /><br />没有找到相关记录...';exit;
     }
     else{

        $offset=5;
        $maxline=20;
        $page_total=ceil($num_rows/$maxline); //maxline is in mod_node.php

        if (!isset($page)||($page<=0)) $page=1;
        if($page>$page_total) $page=$page_total;
        $start=($page-1)*$maxline;
        $sqltextlist2="$sqltextlist  limit $start,$maxline";
        $rowlisttext = getall($sqltextlist2);




/*end page roll*/

 ?>


<?php


 echo '<ul class="seolist">';
   foreach($rowlisttext as $v){

  $pidname = $v['pidname'];
  $name = '<strong>'.decode($v['title']).'</strong>';
  $seo1 = spangray($v['seo1']);
  $seo2 = spangray($v['seo2']);
  $seo3 = spangray($v['seo3']);

 $seoedit = ' &nbsp;&nbsp;<a class="needpopup" href="'.$jumpv_seoedit.'&pidname='.$pidname.'&type=node">修改SEO</a> | ';

 $alias = alias($pidname,'node');
   if($alias<>'') $alias =  '( '.spangray($alias).' )';
   else $alias='';
 $aliasedit = ' <a class="needpopup" href="'.$jumpv_aliasedit.'&pidname='.$pidname.'&type=node">修改别名</a>'.$alias;

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

?>


<?php

require_once HERE_ROOT.'plugin/page_2010.php';

?>


<?php
    }//end $num_rows>0

    ?>


<script>
    function checksearch(thisForm) {
        if (thisForm.searchword.value == "" || thisForm.searchword.value == "请输入标题" )
        {
            alert("请输入标题。");
            thisForm.searchword.focus();
            return (false);
        }
        // return;
    }
</script>
