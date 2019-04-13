<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}
?>
<?php
function seo($arr,$type){
  if(is_array($arr)){
  //pre($arr);
   global $websitename;global $alias;
   $seov='';
  //  echo '<pre>aaaa'.count($arr).'aaa'.print_r($arr,1).'</pre>';
    if(count($arr)>0){

       foreach($arr as $i=>$v){
                $v= dmstrip_tags($v);//not use decode in seo,but in select option is ok
          if($i==0)  $seov= $v;
          else  $seov= $seov.' '.$v;

       }
    }



     if($type=='seo1' and $alias<>'index')  {   echo $seov.' - '.$websitename;
    }
     else  echo $seov;
   }
   else  echo 'seo must be array';
}



function fnoid() { //global $var404;
//alert("sorry, id is not exist! 对不起，此ID不存在！");
//jump($var404);
require(BLOCKROOT.'tpl/page/page_404.php');
exit;

}

function fnoaccess() { //global $var404;
// alert("sorry,prohabit access! 对不起，禁止访问！");
// //jump($var404);
// jump('index.html');
require(BLOCKROOT.'tpl/page/page_404.php');
exit;
}




/*-----------about category -------------------------  */

 function get_sqlwhile($curcatepidname,$pid,$cate_level,$cate_last){
 //Global $curcatepidname;  //not use pidname,conflict to sidebar pidname
 //Global $pid;
 // Global $cate_level;
  // Global $cate_last;
 if($pid=='0')  {
 $sqlin=' '; //main cate,then use ppid
 }
 else{
     if($cate_level==2){
    $sqlin=" and pid='$curcatepidname' ";
   }
   else if($cate_level==1){
      if($cate_last=='y')$sqlin=" and pid='$curcatepidname' ";
      else{
       $sqlin=get_sqlwhile2($curcatepidname);
      }
   }

 }
 return $sqlin;
}//end func
 function get_sqlwhile2($curcatepidname){
 Global $andlangbh;
 // Global $curcatepidname;

    $sql_sub = "SELECT  pidname  from ".TABLE_CATE." where  pid='$curcatepidname' and  sta_visible='y' and sta_noaccess='n' $andlangbh order by pos desc,id";
   $nums = getnum($sql_sub);
      if($nums==0)     $sqlin=" and pid='$curcatepidname' ";
    else if($nums==1) {
                             $row_sub = getrow($sql_sub);
                              $vpidname = $row_sub['pidname'];
                             $sqlin=" and pid in('$curcatepidname','$vpidname') ";
                           }
    elseif($nums>1) {
                                $rowall_sub = getall($sql_sub);
                $vpidname2='';
                                 foreach($rowall_sub as $vcat_sub){// in('a','b')
                                    $vpidname = $vcat_sub['pidname'];
                                    $vpidname2=$vpidname2." '$vpidname',";

                                 }//end foreach
                                    $vpidname2=substr($vpidname2,0,-1);
                                    $sqlin=" and pid in ('$curcatepidname',$vpidname2 )";
                           } //end nums;
  return $sqlin;

}//end func

/*-----------end  about category -------------------------  */



//------------
function field_value_front($mainpidname,$pidname){
Global $andlangbh;
 $sqlfield = "SELECT * from ".TABLE_FIELD." where  pid='$mainpidname' and sta_visible='y' $andlangbh order by pos desc,id";
 $rowlistfield = getall($sqlfield);
    if($rowlistfield<>'no') {
 echo '<ul class="fieldlist">';
      foreach($rowlistfield as $vfield){
        $pidnamefield=$vfield['pidname'];
        $namefield=$vfield['name'];
         $typefield=$vfield['typeinput'];
         $cssnamefield=$vfield['cssname'];

      $sqlfievalue = "SELECT value from ".TABLE_FIELDVALUE." where  pid='$pidnamefield' and pidnode='$pidname' $andlangbh order by id limit 1";
       $rowfiev = getrow($sqlfievalue);
      // echo $sqlfievalue.'<Br>';
      if($rowfiev<>'no')  {
        $value=$rowfiev['value'];
        if($typefield=='text' or $typefield=='textarea') $value2=$value;
        else {

          $optv_arr = explode('|', $value);
          // ksort($optv_arr);
           // pre($optv_arr);
          $value2 = '';
          $i=0;
          foreach($optv_arr as $optv_arr_v){
                 $optv_arr_v_s = get_field(TABLE_FIELDOPTION,'name',$optv_arr_v,'pidname');
               if($i==0) $value2 =  $optv_arr_v_s;
               else $value2 =  $value2.' , '.$optv_arr_v_s;
               $i++;

                 //get_field($table,$field,$v,$type)
          }
          //$value2 = substr($value2, 0,-2);
        }
       if($value2=='') $value2 = '&nbsp; ';

      }
      else {
        $value2 ='&nbsp; ';

      }
       echo '<li class="'.$cssnamefield.'"><span class="name">'.$namefield.'</span><span class="value">'.web_despdecode($value2).'</span></li>';


       }
       echo '</ul>';
    }


}
//---------------
/*
function breadtitled(){//refer b_bread.php

 global $breadarr;
pre($breadarr);
               $divi = '<span class="breaddivi">></span>';
                //echo '<pre>aaaaaaa'.print_r($arr,1).'</pre>';
                if(count($breadarr)>0){
                   foreach($breadarr as $i=>$v){
                      if($i==0)  $bread_v= $v;
                      else  $bread_v= $bread_v.$divi .$v;

                   }
                }
             //   echo $bread_home.$divi.strip_tags($bread_v);
                 echo  $bread_v;


}*/
//---------------

function publishtext(){

 global $authorcate;global $authorcompanycate;global $authordatecate;global $authorhitcate;
 global $author;global $authorcompany;global $dateedit;global $hit;
     $authorv = $author<>''?$author:$authorcate;
      $authorcompanyv = $authorcompany<>''?$authorcompany:$authorcompanycate;

if($authorcate=='hide' && $authorcompanycate=='hide' && $authordatecate=='hide' && $authorhitcate=='hide') { }
  else {
echo '<div class="publishtext">';
if($authorcate<>'hide')  echo '<span class="author">作者：'.$authorv.'</span>';
if($authorcompanycate<>'hide')  echo '<span class="authorcompany">来源：'.$authorcompanyv.'</span>';
if($authordatecate<>'hide')  echo '<span class="authordate">发布日期：'.substr($dateedit,0,10).'</span>';
if($authorhitcate<>'hide')  echo '<span class="authorhit">阅读数：'.$hit.'</span>';

echo '</div>';
}

//-------------
}

function detail_linkmore($linkmore){
   global $news_moretitle;
 //echo $linkmoretitle.'---'.$linkmore;
 $linkmoretitlev = $news_moretitle==''?'查看全文>':$news_moretitle;

 if($linkmore<>''){
    echo '<div class="newslinkmore ptb10 dmbtn moresm"><a class="more" '.linktarget($linkmore).' href="'.$linkmore.'">'.$linkmoretitlev.'</a></div>';
 }

//-------------
}

function detail_downloadurl($downloadurl){
  global $download_title;
//echo $linkmoretitle.'---'.$linkmore;
$linkmoretitlev = $download_title==''?'资料下载>':$download_title;
 if($downloadurl<>'') echo '<div class="downloadurl ptb10 dmbtn moresm"><a class="more" '.linktarget($downloadurl).' href="'.$downloadurl.'">'.$linkmoretitlev.'</a></div>';

//-------------
}


function detail_fontsize(){
  global $sta_fontsize;
  if($sta_fontsize=='y'){
   echo '<div class="detailfontsize" data-size="14"><a href="javascript:void(0);" >A<sup class="fz-small">-</sup></a><a href="javascript:void(0);">A<sup class="fz-big">+</sup></a></div>';
 }
  //-------------
}

function detail_sharebtn(){
  global $sta_sharebtn;
     if($sta_sharebtn=='y')
      {echo '<div class="ptb20 detailsharebtn">';
     require(BLOCKROOT.'other/btnshare.php');
     echo '</div>';
   }

  }


//用来在前台编辑后台。
function edit_fenode($fecateid){
  if(dmlogin()){
        $urlhere = BASEURL.ADMINDIR;
        $firststring = substr($fecateid, 0,4);
        if($firststring=='vblo') echo 'error fecateid...';
        $pcate='';
      if($firststring=='csub') {
          $pcate = get_field(TABLE_CATE,'pid',$fecateid,'pidname');

           $secstring = substr($pcate, 0,4);
           if($secstring=='csub')   $pcate = get_field(TABLE_CATE,'pid',$pcate,'pidname');
      }

       $modtype = get_field(TABLE_CATE,'modtype',$fecateid,'pidname');


      if($modtype=='blockdh'){
         //mod_node/mod_blockdh.php?lang=cn&pid=csub20171215_1731334710
        //mod_block/mod_effectnode.php?lang=trade&pid=vblock20170706_1855588249
        $linkv = $urlhere.'/mod_block/mod_effectnode.php?lang='.LANG.'&pid='.$fecateid;
      }
      else{
        ///mod_node/mod_node.php?lang=cn&catpid=cate20150805_1125344029
        //mod_node.php?lang=cn&catpid=cate20150805_1125344029&page=0&catid=csub20150805_1127356368
          if($firststring=='cate')  $linkv = $urlhere.'/mod_node/mod_node.php?lang='.LANG.'&catpid='.$fecateid;
          else  $linkv = $urlhere.'/mod_node/mod_node.php?lang='.LANG.'&catpid='.$pcate.'&page=0&catid='.$fecateid;

      }
 if(!is_int(strpos($fecateid,'|')))  echo  '<div style="position:relative"><a style="display:block" target="_blank" href="'.$linkv.'" class="dmedit dmeditfenode">编辑内容</a></div>';
  }

}

function edit_fenode_blockdh($pidname){
  if(dmlogin()){
        $urlhere = BASEURL.ADMINDIR;
      
         //mod_node/mod_blockdh.php?lang=cn&pid=csub20171215_1731334710   -- old
        //mod_block/mod_effectnode.php?lang=trade&pid=vblock20170706_1855588249
        $linkv = $urlhere.'/mod_block/mod_effectnode.php?lang='.LANG.'&pid='.$pidname;
        echo  '<div style="position:relative"><a style="display:block" target="_blank" href="'.$linkv.'" class="dmedit dmeditfenode">编辑内容</a></div>';
  }

}





//---输出node的一些信息
/*
function get_nodekv($kv){
   if($kv<>'') $imgv = UPLOADPATHIMAGE.$kv;
    else $imgv = DEFAULTIMG;
    return $imgv;
}

function get_nodekvsm($kvsm){
   if($kvsm=='') $imgvsm = DEFAULTIMG;
   else $imgvsm =  get_img($kvsm,'','nodiv');//not use get_thumb
  return $imgvsm;
}
*/
function get_nodedespjj($despjj,$desp,$desptext,$num){ //despjj = 内容简介
	if($despjj==''){
      if($desptext<>'') $despv = $desptext;
      else  $despv = $desp;
	}
	else  $despv = $despjj;

      if($num>0){
		$despv = strip_tags(web_despdecode($despv));
        if(strlen($despv)>$num)   $despv = mb_substr($despv,0,$num,'UTF-8').'...';
		return $despv;
      }
	  else return '';//if 0,then not display
	 // else   return web_despdecode($despv); //为0时，不截取，同时不strip_tags
}

function get_nodedesp($desp,$desptext){
      if($desptext<>'') $despv = $desptext;
      else  $despv = $desp;
      return web_despdecode($despv);
}

function get_nodelinkurl($linkurl){
          $linkurlarr = array();
         if($linkurl<>'') {
           $linkurlarr[0] = ' <a '.linkhref($linkurl).'>';
          $linkurlarr[1]   = '</a>';
         }
         else{
          $linkurlarr[0] = $linkurlarr[1] = '';
        }
        return $linkurlarr;
  }

 
function cus_columnsfun($cus_columns){ //block判断列数
		$css_gridcol = 'colfull';
		if($cus_columns==2) $css_gridcol = 'colhalf';
		else if($cus_columns==3) $css_gridcol = 'col_1f3';
		else if($cus_columns==4)   $css_gridcol = 'col_1f4';
    else if($cus_columns==5)   $css_gridcol = 'col_1f5';
    else if($cus_columns==6)   $css_gridcol = 'col_1f6';
		return $css_gridcol;

  }

  function cus_columnsfun_bt($cus_columns){ //block判断列数
	$css_gridcol = 'col-md-12 col-sm-12';
	if($cus_columns==2) $css_gridcol = 'col-md-6 col-sm-6  col-xs-6';
      else if($cus_columns==3) $css_gridcol = 'col-md-4 col-sm-4  col-xs-6';
     else if($cus_columns==4)   $css_gridcol = 'col-md-3 col-sm-4 col-xs-6';
     else if($cus_columns==5)   $css_gridcol = 'col-md-d5 col-sm-d5  col-xs-6';
     else if($cus_columns==6)   $css_gridcol = 'col-md-2 col-sm-3  col-xs-6';
     return $css_gridcol;

  }



//---输出css调用----

//----get_css----------
function getcsscommon(){
  //global $bootstrapcss;
  global $compresscss;
  //echo $bootstrapcss;
  //if($bootstrapcss<>'')  echo '<link href="'.$bootstrapcss.'" rel="stylesheet" type="text/css" />';
  //else echo '<link href="'.STAPATH.'assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />';
  echo '<link href="'.STAPATH.'assets/css/DMcompress.css?v='.CSSVERSION.'" rel="stylesheet" type="text/css" />';

  if($compresscss=='y') echo '<link href="'.STAPATH.'assets/css/DMmini.css?v='.CSSVERSION.'" rel="stylesheet" type="text/css" />';
  else {
    echo '<link href="'.STAPATH.'assets/css/DMcommon.css?v='.CSSVERSION.'" rel="stylesheet" type="text/css" />';

    echo '<link href="'.STAPATH.'assets/css/DMblock.css?v='.CSSVERSION.'" rel="stylesheet" type="text/css" />';

  //  echo '<link href="'.STAPATH.'assets/css/DMblockappend.css?v='.CSSVERSION.'" rel="stylesheet" type="text/css" />';
    echo '<link href="'.STAPATH.'assets/css/responsive.css?v='.CSSVERSION.'" rel="stylesheet" type="text/css" />';
  }
}

function getcssarr($arr,$type=''){
  if(is_array($arr)){
         foreach ($arr as $v) {
          getcssarr2(trim($v),$type);
        }
  }
    elseif(is_int(strpos($arr,'|'))){
       $arr = explode('|', $arr);
        foreach ($arr as $v) {
          getcssarr2(trim($v),$type);
        }
   }
   else {
           getcssarr2(trim($arr),$type);
   }

 }
 function getcssarr2($v,$type){
  $vbefore = substr($v,0,5);
      $v2 =  $v.'?v='.CSSVERSION;
          if(is_int(strpos($v,'://'))) $vhere = $v2;
		  else if($vbefore=='asset') $vhere = STAPATH.$v2;
		  else if($vbefore=='dmreg') $vhere = REGIONPATH.$type.'/cssjs/'.$v2;
         // else  if(is_int(strpos($v,'assets/'))) $vhere = STAPATH.$v;
          else $vhere = TPLCURPATH.'cssjs/'.$v2;
		  //echo $vbefore.'-==============-';
      echo '<link href="'.$vhere.'" rel="stylesheet" type="text/css" />';
 }

function getjscommon(){
   global $jquery;
  //global $bootstrapjs;
   // echo $jquery; echo $bootstrapjs;
 if($jquery=='')   echo '<script src="'.STAPATH.'assets/vendor/jquery.js" type="text/javascript"></script>';
   else  echo '<script src="'.$jquery.'" type="text/javascript"></script>';
//  echo '<script src="'.STAPATH.'assets/vendor/jquery.js" type="text/javascript"></script>';
  // echo "\r\n";
  echo '<script src="'.STAPATH.'assets/js/DMcompress.js?v='.CSSVERSION.'" type="text/javascript"></script>';
  //echo "\r\n";
  echo '<script src="'.STAPATH.'assets/js/DMbase.js?v='.CSSVERSION.'" type="text/javascript"></script>';

   }

function getjsarr($arr,$type=''){
    if(is_array($arr)){
         foreach ($arr as $v) {
          getjsarr2(trim($v),$type);
        }
  }
  elseif(is_int(strpos($arr,'|'))){
     $arr = explode('|', $arr);
      foreach ($arr as $v) {
          getjsarr2(trim($v),$type);
        //  echo "\r\n";
      }
 }
 else {
          getjsarr2(trim($arr),$type);
 }

 }
function getjsarr2($v,$type){
   $vbefore = substr($v,0,5);
  $v2 = $v.'?v='.CSSVERSION;
          if(is_int(strpos($v,'://'))) $vhere = $v2;
		  else if($vbefore=='asset') $vhere = STAPATH.$v2;
		  else if($vbefore=='dmreg') $vhere = REGIONPATH.$type.'/cssjs/'.$v2;
          else $vhere = TPLCURPATH.'cssjs/'.$v2; 
         
    echo '<script src="'.$vhere.'" type="text/javascript"></script>';


}
  function getcsssingle($v){
      echo '<link href="'.$v.'?v='.CSSVERSION.'" rel="stylesheet" type="text/css" />';
  }
function getjssingle($v){
      echo '<script src="'.$v.'?v='.CSSVERSION.'" type="text/javascript"></script>';
   }

//----
function taglink($pidname,$tagtitle){

     // echo $pidname;
       $ss="select tag from  ".TABLE_TAGNODE."  where node='$pidname'  ".ANDLANGBH." order by id desc";
  // echo $ss;exit;
      if(getnum($ss)>0){
          echo '<div class="taglinkindetail"><strong>'.$tagtitle.':</strong>';

        $res = getall($ss);
          foreach ($res as $v) {
              $tag = $v['tag'];
              $ss2="select name,id from  ".TABLE_TAG."  where pidname='$tag'  ".ANDLANGBH." order by pos desc,id desc";
              $row = getrow($ss2);
              $name = $row['name'];
               $id = $row['id'];
               $link = 'tag-'.$id.'-1.html';
               echo '<a href="'.$link.'">'.$name.'</a>';



          }//end foreach
echo '</div>';
      }


   }

function dmblockid($desp){
   //[DMblockid]
  $find1 = '[DMblockid]';  $find2 = '[/DMblockid]'; $num = 12;
  //strpos(string,find,start)   substr(string,start,length)    =str_replace($find1, "", $str1begin_true);
  //mb_substr($despv,0,$num,'UTF-8').'...';
    $str1 = $desp;
    $num1_begin = strpos($str1,$find1);
    $num1_end = strpos($str1,$find2);
if(is_int($num1_begin) && is_int($num1_end) ){

    $str1_begin = substr($str1, 0,$num1_begin);
    $str1_end = substr($str1, $num1_end+$num);

    $blockid1_str = substr($str1, 0,$num1_end);
    $blockid1 =substr($blockid1_str, $num1_begin);
    $blockid1 =str_replace($find1, "", $blockid1);


     echo $str1_begin.'<div class="blockidwrap">';
     block($blockid1);
     echo '</div>';


     if(!is_int(strpos($str1_end,$find2)))  echo  $str1_end;
     else dmblockid($str1_end);

   }
   else {
    echo $desp;
    return;
   }




}



/*
function  testimgfunc($k,$testimgfolder){
    if($testimgfolder<>''){
        $i = $k+1;
        $ext = strtolower(substr($testimgfolder,0,3));
        if($ext=='gif' || $ext=='png')  $ext = '.'.$ext;
        else $ext = '.jpg';
        $imgroot = TPLCURROOT.'media/'.$testimgfolder.'/'.$i.$ext;
         //echo $imgroot;
        if(is_file($imgroot)) {
          $imgv = TPLCURPATH.'media/'.$testimgfolder.'/'.$i.$ext;
          return $imgv;
        } else return 'no';
  } else return 'no';
}
*/

 

function detail_nodetext($type,$type2,$pidname){
     Global $andlangbh;
 $ss = "select desp,desptext from ".TABLE_NODETEXT." where type= '$type' and type2= '$type2' and pid= '$pidname' $andlangbh order by id limit 1";
  //echo $ss;
 if(getnum($ss)>0) {
    $row = getrow($ss);
     $desptext= web_despdecode($row['desptext']);
     $desp= web_despdecode($row['desp']);   
     $despv = $desptext<>''?$desptext:$desp;
    return $despv;

 }
 else  return false; 
}

function detail_album($type,$pidname){
     Global $andlangbh;
 $ss = "select * from ".TABLE_ALBUM." where  pid= '$pidname' $andlangbh order by pos desc,id desc limit 1";
    //echo $ss;
 if(getnum($ss)>0) {
    $row_abm = getrow($ss);
    $albumpidname = $row_abm['pidname'];
  //--------
     $ss = "select * from ".TABLE_ALBUM." where  pid= '$albumpidname' $andlangbh order by pos desc,id desc";
   //  echo $ss;
     if(getnum($ss)>0) {

         $row_abm = getall($ss);
         // pre($row_abm);
          return $row_abm; 
        

     }
     else   return false; 


   
    //------------------
    return $row_abm;
 }
 else  return false; 
}
function detail_music($type,$pidname){
     Global $andlangbh;
 $ss = "select * from ".TABLE_MUSIC." where type= '$type'   and pid= '$pidname' $andlangbh order by pos desc,id desc";
  // echo $ss;
 if(getnum($ss)>0) {
    $row_abm = getall($ss);
    return $row_abm;
 }
 else  return false; 
}
function detail_video($type,$pidname){
     Global $andlangbh;
 $ss = "select pidname from ".TABLE_VIDEO." where type= '$type'   and pid= '$pidname' $andlangbh order by pos desc,id desc limit 1";
  // echo $ss;
 if(getnum($ss)>0) {
    $row_abm = getrow($ss);
    return $row_abm['pidname'];
 }
 else  return false; 
}




 


function getgriddata($pidcate,$maxline,$modtype,$orderby=''){	  //----no use
 Global $andlangbh;Global $page;  
 if($orderby=='') $orderby = 'order by pos desc,id desc';
	$v= array();$page_total2 = 0;   //use page_total2, bec confict to some block,and affect block_view.php
	$sqlwhere = get_node_sqlv($pidcate);
$sqlnode="select * from ".TABLE_NODE." where  sta_visible='y' $andlangbh  $sqlwhere  $orderby";
// echo $sqlnode;exit;
$fenum = getnum($sqlnode);
if($fenum==0) {echo '没有记录。 --'.$pidcate;
$result = array();
}
else {
	 if($modtype=='node'){ 
		$page_total2=ceil($fenum/$maxline);
		if($page>$page_total2) $page=$page_total2;
        $start=($page-1)*$maxline; 
		if($start<0) $start=0;
        $sqllist33="$sqlnode  limit $start,$maxline";
	     //echo $sqllist33;exit;
		
        $result = getall($sqllist33);
		
	 }
	 else{
	 	$sqllist33="$sqlnode  limit 0,$maxline";
		 $result = getall($sqllist33);
		
	 }
} 
 
$v[0] = $result;
$v[1] = $page_total2;
$v[2] = $fenum;
return $v;

	
}

function regionbg($bgcolor,$bgimg,$bgrepeat,$bgposi,$bgsize,$bgattach){
  $bgcolorv = $bgcolor==''?'':"background-color:$bgcolor;";
  $bgattachv = $bgattach==''?'':"background-attachment:$bgattach;";
  $bgsizev = $bgsize==''?'':"background-size:$bgsize;";
  $bgrepeatv = $bgrepeat==''?'':"background-repeat:no-repeat;";
  $bgposiv = $bgposi==''?'':"background-position:center center;";
  
  $bgimgv=''; 
  if($bgimg<>'') {
    $bgimgroot = UPLOADROOTIMAGE.$bgimg;
    $bgimgpath = UPLOADPATHIMAGE.$bgimg;
    if(is_file($bgimgroot)){    
    $bgimgv  = "background-image: url('$bgimgpath');";
    }
    $v =  $bgcolorv.$bgimgv.$bgrepeatv.$bgposiv.$bgsizev.$bgattachv;
  }
  else $v =  $bgcolorv;
  return $v;
}
//field
function fieldvalue($fiepidname,$type,$value22){// echo $value22;  echo '<br />';
  Global $andlangbh;

  // echo $fiepidname.'----'.$type.'-----'.$value22.'---- <br />';
  $i=1;

  if($type=='text'){
    // $value22=zbdespedit($value22);
  echo '<input type="text" value="" name="'.$fiepidname.'" class="value form-control" />';
  }
  if($type=='textarea'){
    // $value22=zbdespedit($value22);
  echo '<textarea name="'.$fiepidname.'" class="value form-control" rows="8"></textarea>';
  }


  if($type=='radio' or $type=='checkbox' or  $type=='select'){
     $sqlsub = "SELECT id,name,pidname from ".TABLE_FIELDOPTION." where  pid='$fiepidname' and sta_visible='y'  $andlangbh order by pos desc,id";
      //echo $sqlsub;exit;
     $rowlistsub = getall($sqlsub);
     if($rowlistsub=='no') {
      echo '<p>&nbsp;&nbsp;还没有选项，请在后台添加...</p>';
      }
      else{
        if($type=='select') {
          echo '<select class="value" name="'.$fiepidname.'"><option value="">请选择</option>';

        }

        foreach($rowlistsub as $vv){
          $id = $vv['id'];//id is for input name
          $namev = $vv['name'];
          $pidname = $vv['pidname'];

          if($type=='radio'){
            $nameid='rid'.$id.$i;
            //if($pidname==$value22){    $checked='checked="checked"';$class='class="cur"';}
           // else{   $checked='';$class='';}

                 echo '<input type="radio" value="'.$namev.'" name="'.$fiepidname.'" id="'.$nameid.'" size="80" />';
           echo '<label style="padding-right:20px" for="'.$nameid.'">'.$namev.'</label> ';

          }
          if($type=='checkbox'){
            $nameid='cid'.$id.$i;
             $strpos = strpos($value22,$pidname); /*只有checkbox会有连接字符串*/
            //if(in_array($pidname,$value22)){    $checked='checked="checked"';$class='class="cur"';}
             // if(is_int($strpos)){ $checked='checked="checked"';$class='class="cur"';}
          //  else{ $checked='';$class='';}
                 echo '<input type="checkbox"    value="'.$namev.'" name="'.$fiepidname.'[]" id="'.$nameid.'" size="80" />';
           echo '<label style="padding-right:20px" for="'.$nameid.'">'.$namev.'</label> ';
          }
          if($type=='select'){
            // if($pidname==$value22) $selected=' selected="selected"'; else $selected='';
                 echo '<option   value="'.$namev.'">'.$namev.'</option>';
          }

        $i++;
        }//end foreach
      if($type=='select') echo '</select>';
      }//end else




  }//edn $type=='radio' or $type=='checkbox' or  $type=='select'



}//end func
