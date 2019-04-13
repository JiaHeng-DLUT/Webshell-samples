<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}
?>
<?php

  $key = @htmlentitdm($_POST['searchword']);
 if($key == "") $keyV="" ;
     else {
       if($key=='nodenew')  $keyV="and sta_new = 'y' or title like '%$key%'" ;
       elseif($key=='nodetj')  $keyV="and sta_tj = 'y' or title like '%$key%'" ;
       elseif($key=='nodenoaccess')  $keyV="and sta_noaccess = 'y' or title like '%$key%'" ;
       else $keyV="and title like '%$key%'" ;
     }

if($catid=='') $catid=$catpid;
$catid_v = wherecatev($catpid,$catid);

     $sqltextlist = "SELECT * from ".TABLE_NODE." where $catid_v $keyV  $andlangbh order by pos desc,dateedit desc"; //pos desc,id desc
      //echo $sqltextlist;
    /*begin page roll*/
     $num_rows = get_numrows($sqltextlist);
     if($num_rows>0){

        $offset=5;
        $maxline=20;
        $page_total=ceil($num_rows/$maxline); //maxline is in mod_node.php

        if (!isset($page)||($page<=0)) $page=1;
        if($page>$page_total) $page=$page_total;
        $start=($page-1)*$maxline;
        $sqltextlist2="$sqltextlist  limit $start,$maxline";
        $rowlisttext = getall($sqltextlist2);
     }//end $num_rows>0

/*end page roll*/

 ?>

 
  <?php
  if($key<>''){
      echo '<p style="padding:5px;text-align:left">当前关键字：<span style="font-size:20px">'.$key.'</span> &nbsp;&nbsp;&nbsp;&nbsp; 提示：搜索最新内容,推荐内容，禁止访问内容，请分别输入 nodenew ,  nodetj   , nodenoaccess </p>';
      
    }


  if($num_rows==0) {
           if($key<>'') {
            
              echo '<br /><br />没有找到相关内容。</p>';
			} 
		   else echo '<br /><br />暂无内容.请添加';
			
    }
    else {
   
          require_once HERE_ROOT.'mod_node/tpl_node_list_inc.php';
      }

 
     
      ?>



 