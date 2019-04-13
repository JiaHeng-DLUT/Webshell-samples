 
 <?php
/*
  power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}


 if($act=='update'){
  //pre($_POST);

 ifhaspidname(TABLE_CATE,$abc1);

   if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}


 
 $ss = "update ".TABLE_NODE." set  pid='$abc1'  where id='$tid' $andlangbh limit 1";
     // echo $ss;exit;
      iquery($ss);

   jump($jumpv_file);
 
 
 }
 else
 {
  //$desp=zbdesp_imgpath($row['despcan']);
 
  ?>
  <section class="content-header">
   <h1>  修改分类：   </h1>
</section>
 
  <form  action="<?php echo $jumpv_file; ?>&act=update" method="post" enctype="multipart/form-data">

 <table class="formtab" >
   <tr>
      <td class="treearr_select_input_catename">
   
            主类： 
            <?php 
                     echo $maincate .' - '.$catpid;
            ?>
             
      </td>
    
    </tr>
  <tr>
      <td class="treearr_select_input_catename">
   
            父级分类名称：<span>
            <?php 
                     echo $subcate;
            ?>
            </span>
      </td>
    
    </tr>
   <tr>
      <td >
   
            父级分类标识：<input class="treearr_select_input" type="text" name="treearr_select_input"  value="<?php echo $pid;?>" size="35"  /> 
      </td>
    
    </tr>

      <tr>
      <td >
     <span class="cp treearr_select_go fb cblue">点击选择分类></span>  



<?php

function echoarrhtml($tree)
{
  global $jumpv;    global $pidnamesub;  global $pidmulti; 
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
  
 $classv = ($pidname == $pidnamesub )?' active':'';
 $classhidev = $sta_visiblevv<>'y'?' hidediv':'';

  $classbluev = is_int(strpos($pidmulti,$pidname))?' activeblue':'';


  $name = $sta_visiblevv<>'y'?$name.' &nbsp; &nbsp;[隐藏]':$name;
 
  if(@$vsub['son'] == '')
  {
   $html .= '<li>├ <span  class="'.$classv.$classbluev.$classhidev.'" id="'.$pidname.'">'.$name.'</span></li>';  //span for js,avoid li
  }
  else
  {
   $html .= '<li>├ <span  class="'.$classv.$classbluev.$classhidev.'" id="'.$pidname.'">'.$name.'</span>';
   $html .= echoarrhtml($vsub['son']);
   $html = $html."</li>";
  }
}
 return $html ? '<ul class="tree">'.$html.'</ul>' : $html ;
 // return $html;
}


$pidnamesub = $pid;

 echo '<div class="treearr_select jstreearr_select" style="display:block">';
   $classv = $catpid == $pid?'active':'';
    echo '<ul class="treearr">'; 
        echo '<li ><span  class="'.$classv.'" id="'.$catpid.'">(主类) '.$maincate.'</span>';

//----------------
$sqlsub = "SELECT * from ".TABLE_CATE." where  ppid='$catpid' $andlangbh order by pos desc,id";
//echo $sqlsub;
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
//----------------------

 echo '</li>';
echo '</ul>';


echo '</div>';


?>


 
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
  