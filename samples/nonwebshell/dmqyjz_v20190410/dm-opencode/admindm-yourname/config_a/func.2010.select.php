<?php
/************************************/
function f2030_select_cat($menuname,$catname,$catpid,$act,$par_id) {
  Global $user2510;
    if($act=='edit') $appid="id<>'$tid' and ";
  $sql = "select pidname,pid,name,sta_visible from zme_cate where $appid  pid='$catname' and pbh='".USERBH."' order by pos desc,id";
    $rowlist = getall($sql);
    if($catpid=='') $selected = ' selected="selected"'; else $selected = '';
   $menuname=decode($menuname);
    echo "<select name='pcla'><option  $selected value='$catname'>(主类)$menuname</option>";
//
   foreach ($rowlist as $vcla){//by pidname is father.
       $pidname=$vcla['pidname'];
       //alert($pidname); alert($catpid);
       // if($pidname == intval($catpid))
           if($pidname == $catpid) $selected2=' selected="selected"';else $selected2='';
            if($vcla['sta_visible']<>'y') $subname_hide22='(已隐藏)';else $subname_hide22='';
        echo '<option value='.$pidname.$selected2.'>&nbsp;&nbsp;├ '.$vcla['name'].$subname_hide22.'</option>';
        }
    echo "</select>";

}
/********************************/
function select_taxo($brand,$name,$curbrand) {//use in node part
     GLOBAL  $maincate; GLOBAL  $catpid;
     echo '<select name=se'.$brand.'>';
   echo '<option  value="">请选择'.$name.'：</option>';

 $sql = "SELECT pidname,name,sta_visible from ".TABLE_TAXO." where  pid='$brand' $andlangbh order by pos desc,id";
    $rowlist_cat_sub = getall($sql);
    if($rowlist_cat_sub<>'no') {
       foreach($rowlist_cat_sub as $vcat_sub){
         $subname=decode($vcat_sub['name']); $subpidname=$vcat_sub['pidname'];
       if($vcat_sub['sta_visible']<>'y') $subname_hide='(已隐藏)';else $subname_hide='';
        if($subpidname == $curbrand) $selected=' selected="selected"';else $selected='';
     echo '<option value="'.$subpidname.'"'.$selected.'>&nbsp;&nbsp;├'.$subname.$subname_hide.'</option>';
          }
         }
            //end sub--------

    echo '</select>';
}
/********************************/
function select_cate($rowlist_cat,$name,$pid) {//use in node part
     GLOBAL  $maincate; GLOBAL  $catpid; GLOBAL  $andlangbh;
     echo '<select name="pid">';
	 echo '<option  value="">请选择'.$name.'：</option>';
	 if($catpid==$pid) 	 echo '<option selected="selected" value="'.$catpid.'">'.$maincate.'</option>';
	  else echo '<option value="'.$catpid.'">'.$maincate.'</option>';
     if($rowlist_cat=='no'){ //alert('出错，请先在分类管理里添加分类');exit;

     }
            else{

                foreach ($rowlist_cat as $vcat){
                    $pidname=$vcat['pidname'];  $catname=decode($vcat['name']);
                     if($vcat['sta_visible']<>'y') $catname_hide='(已隐藏)';else $catname_hide='';

         if($pidname == $pid) $selected=' selected="selected"';else $selected='';
            echo '<option value="'.$pidname.'"'.$selected.'>&nbsp;&nbsp;├'.$catname.$catname_hide.'</option>';
            //sub-------------
         $sql = "SELECT pidname,name,sta_visible from ".TABLE_CATE." where  pid='$pidname' $andlangbh order by pos desc,id";
                $rowlist_cat_sub = getall($sql);
                if($rowlist_cat_sub<>'no') {
                      foreach($rowlist_cat_sub as $vcat_sub){
                           $subname=$vcat_sub['name']; $subpidname=$vcat_sub['pidname'];
                    if($vcat_sub['sta_visible']<>'y') $subname_hide='(已隐藏)';else $subname_hide='';
                             if($subpidname == $pid) $selected=' selected="selected"';else $selected='';
                     echo '<option value="'.$subpidname.'"'.$selected.'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├'.$subname.$subname_hide.'</option>';
                        }
                }
            //end sub--------
                }
            }
    echo '</select>';
}
/*******************************
function select_cate_menu($menu_degree,$tid,$table) {//need change
 $ss = "select pid from $table where id='$tid' limit 1";
    $row = getrow($ss);$pid=$row['pid'];
    if($pid=='0') $selected_main = " selected=selected";else $selected_main='';

    echo "<select name=pcla id=pcla><option  $selected_main value='0'>主菜单</option>";
   foreach ($menu_degree as $vcla){
            if($vcla['sta_cmp']=='y')   $modv='(模块)'; else $modv='';
          // if($vcla['pidname'] == intval($pid)) $selected2=' selected=selected';else $selected2='';
             if($vcla['pidname'] ==$pid) $selected2=' selected=selected';else $selected2='';
        echo '<option '.$selected2.' value='.$vcla['pidname'].'>&nbsp;&nbsp;├ '.decode($vcla['name']).$modv.'</option>';
        }
    echo "</select>";
}
/***********************/
function  select_cate_self($table,$catid,$catid2,$catname,$tid,$act) {//use in category self part,different to news.just remember.
    Global $user2510;
    if($act=='edit') $appid="id<>'$tid' and ";
     $sql = "select pidname,pid,name,sta_visible from $table where $appid  pid='$catid' and pbh='".USERBH."' order by pos desc,id";
    $rowlist = getall($sql);
    if($catid==$catid2) $selected = ' selected="selected"'; else $selected = '';
    echo "<select name='pcla'><option  $selected value='$catid'>$catname</option>";
//
   foreach ($rowlist as $vcla){//by pidname is father.
       $pidname=$vcla['pidname'];
           if($pidname == intval($catid2)) $selected2=' selected="selected"';else $selected2='';
            if($vcla['sta_visible']<>'y') $subname_hide22='(已隐藏)';else $subname_hide22='';
        echo '<option value='.$pidname.$selected2.'>&nbsp;&nbsp;├ '.$vcla['name'].$subname_hide22.'</option>';
        }
    echo "</select>";

}
/********************************/
function select_procontri($menu_degree,$tid,$table) {//need change
 $ss = "select pid from $table where id='$tid' limit 1";
    $row = getrow($ss);$pid=$row['pid'];
    //if($pid=='0') $selected = " selected=selected";else $selected='';

    echo "<select name=pcla id=pcla>";
/*if pid==0*/
if($pid=='0') {
echo '<option value="0">&nbsp;&nbsp;*主类属性</option>';
}else{
//--------------
 echo '<option  $selected value="">请选择产品属性：</option>';
   foreach ($menu_degree as $vcla){

           if($vcla['pidname'] == intval($pid)) $selected2=' selected=selected';else $selected2='';
        echo '<option value='.$vcla['pidname'].$selected2.'>&nbsp;&nbsp;*'.$vcla['name'].'</option>';
        }
 //------------
}/*end if pid==0*/
echo "</select>";
}
//--------------------------
/*
function  select_catnew($menuname,$catname,$curpidname,$if_lastcat,$act) {
  Global $user2510;
    if($act=='edit' and $if_lastcat<>'y') {
   $appid="pidname<>'$curpidname' and ";

    }
  $sql = "select pidname,pid,name,sta_visible from zme_cate where $appid  pid='$catname' and pbh='".USERBH."' order by pos desc,id";
    $rowlist = getall($sql);

   // if($catpid=='') $selected = ' selected="selected"'; else $selected = '';
   $menuname=decode($menuname);
    echo "<select name='pcla'><option  value='$catname'>(主类)$menuname</option>";
//
   foreach ($rowlist as $vcla){//by pidname is father.
       $pidname=$vcla['pidname'];
       //alert($pidname); alert($catpid);
       // if($pidname == intval($catpid))
           if($pidname == $curpidname) $selected2=' selected="selected"';else $selected2='';
            if($vcla['sta_visible']<>'y') $subname_hide22='(已隐藏)';else $subname_hide22='';
        echo '<option value='.$pidname.$selected2.'>&nbsp;&nbsp;├ '.$vcla['name'].$subname_hide22.'</option>';
        }
    echo "</select>";

}*/

//---------------
function select_newcate_osc($pidhere,$i,$pdleft,$curpid,$vis){
	global $user2510;
$i++;
$c='c_'.$i;
$pdleft.='&nbsp;&nbsp;';
 if($vis=='vis_y'){$where_vis=" and sta_visible='y'  ";}

	   $sql = "select pidname,name from zme_cate where pid='$pidhere' and pbh='".USERBH."' $where_vis order by pos desc,id";
  //echo $sql;exit;
	  $rowlist = getall($sql);
	 // echo print_r($$rowlist,1);
       if($rowlist<>'no')  {

       foreach ($rowlist as $v){
		//  echo print_r($$v,1);
		   $pidname=$v['pidname'];
		   $name=decode($v['name']);

			// if((int)$curpid==(int)$pidname)
			 if($curpid==$pidname) $select=' selected '; else $select='';

            echo '<option '.$select.'value="'.$pidname.'">'.$pdleft.'|-'.$name.'</option>' ;

				  select_newcate_osc($pidname,$i,$pdleft,$curpid,$vis);



	   }//end foreach

	   }


}//end func

function select_from_arr($arr,$curpid,$pls){//select_from_arr($arr_yn,0,'',$status);
    if($pls=='pls')  echo '<option  value="">请选择...</option>' ;
	 foreach ($arr as $k=>$v){
		 // if((int)$curpid==(int)$k) $select=' selected '; else $select='';
		    if($curpid==$k) $select=' selected '; else $select='';
 echo '<option '.$select.'value="'.$k.'">'.$v.'</option>' ;
	 }
}//end func

function select_from_arr2($arr,$curpid,$pls){//select_from_arr($arr_yn,0,'',$status);
    if($pls=='pls')  echo '<option  value="">请选择...</option>' ; 
	 foreach ($arr as $v){
		    if($curpid==$v) $select=' selected '; else $select='';
 echo '<option '.$select.'value="'.$v.'">'.$v.'</option>' ;
	 }
}//end func

function select_from_filearr($filedir,$curv){

    if(is_dir($filedir)){
        $filearr = getFile($filedir);
            foreach ($filearr as $v) {
                 $selectv ='';
                if($curv==$v) $selectv = ' selected="selected" ';
                echo '<option '.$selectv.' value="'.$v.'">'.$v.'</option>';
            }

        }
        else{
            echo '<option>目录不存在</option>';
        }
 }


 


function select_from_tab($tabpidname,$curV){
  global $andlangbh;
    $sql = "select pidname,name from ".TABLE_TAXO." where sta_visible='y' and pid='$tabpidname' $andlangbh  order by pos desc,id";
// echo $sql;
    $rowlist = getall($sql);
    if($curV=='no') $select2=' selected '; else $select='';
   echo '<option '.$select2.'value="">请选择</option>' ;
       if($rowlist<>'no')  {
           foreach ($rowlist as $v){
              if($curV==$v['pidname']) $select=' selected '; else $select='';
              echo '<option '.$select.'value="'.$v['pidname'].'">'.$v['name'].'</option>' ;
           }
      }

}//end func


function sele_style($cur){
         global $andlangbh;
    $sql = "select pidname,title from ".TABLE_STYLE." where sta_visible='y'  $andlangbh  order by pos desc,id";
  //echo $sql;
    $rowlist = getall($sql);

		$selectv ='';
		foreach ($rowlist as $v) {
		  $title = $v['title'];
		   $pidnamecur = $v['pidname'];
		   if($cur == $pidnamecur) $selectv = ' selected ';
		   else  $selectv ='';
		  echo '<option value="'.$pidnamecur.'" '.$selectv.'>'.$pidnamecur.' ('.$title .')</option>';
		}
}//end func



?>
