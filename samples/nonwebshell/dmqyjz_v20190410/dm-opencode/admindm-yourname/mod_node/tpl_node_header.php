<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
 ?>
  <div class="contenttop" style="min-height:50px;padding:10px 0">
    <div class="fl col-md-4">
      <?php     
        $jumpvnodeadd ='../mod_node/mod_pop_nodeadd.php?lang='.LANG.'&act=add&catpid='.$catpid.'&catid='.$catid;
        echo '<a class="needpopup" href="'.$jumpvnodeadd.'"><i class="fa fa-plus-circle"></i> 添加内容</a>';
    ?>
      </div>

      <div class="fl col-md-4">
        <?php
        $catname  = $title;
          if($catid=='') {
             $pidnamesub = '';   
             $catesubcur = '';          
          }
          else{
               $pidnamesub = $catid;
               $catesubcur = '<span class="cred">(当前子分类：'.get_field(TABLE_CATE,'name',$catid,'pidname').')</span>'; 

          }

          ?>
           <span class="cp treearr_select_go fb cblue">点击选择分类></span> <?php echo $catesubcur;?>

      </div>

      <div class="fl col-md-4">
      <form onsubmit="javascript:return checksearch(this)" id="search_form" action="mod_node.php?lang=<?php echo LANG?>&catpid=<?php echo $catpid?>&catid=<?php echo $catid?>&page=<?php echo $page?>" method="post" accept-charset="UTF-8">
          搜索： <input class="navsearch_input" type="text" name="searchword" value="请输入标题" style="width:250px;padding:5px;" onfocus="javascript:this.value='';" />
            <input type="submit" name="Submit" value="搜索" class="searchgo" style="padding:5px 10px;cursor:pointer" />
            </form>

      </div>

 </div>


<?php

function echoarrhtml($tree,$multicate='')
{
  global $jumpv;    global $pidnamesub;  global $catid; 
$html = '';
foreach($tree as $vsub)
{
  
  $name =  $vsub['name']; 
  $tid=$vsub['id'];  $jsname = jsdelname($vsub['name']);
  $level=$vsub['level'];$last=$vsub['last']; 
  
  $pidname=$vsub['pidname']; 
  $pidhere=$vsub['pid'];  $sta_visiblevv=$vsub['sta_visible']; 
  
  $alias_jump=$vsub['alias_jump'];         
  $aliascc = alias($pidname,'cate');  
  
 $classv = ($pidname == $pidnamesub )?'active':'';
 $classhidev = $sta_visiblevv<>'y'?' hidediv':'';

 $numnode = num_subnode(TABLE_NODE,'pid',$pidname);
$numnodev = ' <span class="cred">('.$numnode.')</span>';

$addnodelink2 = 'mod_pop_nodeadd.php?lang='.LANG.'&act=add&catpid='.$catid.'&catid='.$pidname;
$addnodelink2t =  '&nbsp; | &nbsp; <a class="needpopup" href="'.$addnodelink2.'">添加</a>';

$name = '<a href="'.$jumpv.'&catid='.$pidname.'">'.$name.'</a>';
  $name = $sta_visiblevv<>'y'?$name.' &nbsp; &nbsp;[隐藏]':$name;
  $name = $name.$numnodev;
 
  if(@$vsub['son'] == '')
  {
   $html .= '<li>├ <span  class="'.$classv.$classhidev.'" id="'.$pidname.'">'.$name.'</span>'.$addnodelink2t.'</li>';  //span for js,avoid li
  }
  else
  {
   $html .= '<li>├ <span  class="'.$classv.$classhidev.'" id="'.$pidname.'">'.$name.'</span>'.$addnodelink2t;
   if(MULTICATE=='y' || $multicate=='')  $html .= echoarrhtml($vsub['son'],MULTICATE);
   $html = $html."</li>";
  }
}
 return $html ? '<ul class="tree">'.$html.'</ul>' : $html ;
 // return $html;
}




 echo '<div class="treearr_select" style="display:none">';

  $classv = $catid==''?'active':'';
  echo '<ul class="treearr">';
        $catname = '<a href="'.$jumpv.'">'.$catname.'</a>';
        $addnodelink = 'mod_pop_nodeadd.php?lang='.LANG.'&act=add&catpid='.$catpid.'&catid='.$catpid;
  echo '<li ><span  class="'.$classv.'" id="'.$catpid.'">(主类) '.$catname.'</span> &nbsp; | &nbsp; <a class="needpopup" href="'.$addnodelink.'">添加</a>';
 //---------------------
$sqlsub = "SELECT * from ".TABLE_CATE." where  ppid='$catpid' $andlangbh order by pos desc,id";

 $rowlistsub = getall($sqlsub);
 if($rowlistsub=='no') {
  echo '<p>&nbsp;&nbsp;还没有分类，请添加...</p>';
  }
  else{

    
      $indexarr = indexingarr($rowlistsub);
      $getnewarr = getnewtreearr($indexarr);
      //pre($getnewarr);

        echo   echoarrhtml($getnewarr);
   
}
//-----------------
     echo '</li>';
 echo '</ul>';

echo '</div>';


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










