<?php
/*
	power by jason.zhang, cmsmeng.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
function gpc_add($gpc){
 if ( !get_magic_quotes_gpc() )  $gpc =  addslashes($gpc);

 return $gpc;
}
function gpc_strip($gpc){
if ( !get_magic_quotes_gpc() )  $gpc =  stripslashes($gpc);

 return $gpc;

}

function zbdespedit($desp){ //转变函数
    $desp=str_replace("&nbsp;",chr(32),$desp);///speed : str_replace  >  preg_replace > preg_replace(zheng ze biaodasi)
    $desp=str_replace("<br>",chr(13),$desp);
    $desp=str_replace("<br />",chr(13),$desp);
   // $desp=preg_replace("&quot;","'",$desp);
   $desp  = gpc_strip($desp);
    return $desp;
}
function zbdespadd($desp){//no use......
    $desp=htmlspecialchars($desp);
    $desp=str_replace(chr(32),"&nbsp;",$desp);
    $desp=str_replace(chr(13),"<br />",$desp);
   // $desp=preg_replace("'","&quot;",$desp);
    return $desp;
}
function zbdespadd2($desp){
   // $desp=htmlspecialchars($desp);//have use zb_insert,then use zbdespadd2
	 $desp=htmlspecialchars($desp);
    $desp=str_replace(chr(32),"&nbsp;",$desp);
    $desp=str_replace(chr(13),"<br />",$desp);
   // $desp=preg_replace("'","&quot;",$desp);
    return $desp;
}

function zb_insert($array){ //转变函数
     $i=1;
    foreach($array as $k => $v)
    {
	if(is_array($v)) return ;

        $v=trim($v);
         //$v=str_replace("\\","/",$v);
        $v=str_replace("<script>","<-nojsscript->",$v);
        $v=str_replace("</script>","<-/nojsscript->",$v);
        $v  = gpc_add($v);
        $v=str_replace(UPLOADPATH,'imgpath_3qys0o_com',$v);
        $abc='abc'.$i;
        global $$abc;
        $$abc=htmlspecialchars($v);//---for security script zhuru--htmlentitdm will let chinese lunma
       // $$abc=$v;//---for security script zhuru
        //$$abc=trim($v);
        $i++;
       // echo $$abc.' |';htmlspecialchars_decode
    }
}

function zbdesp_onlyinsert($v) {//look zb_insert.
     $v=trim($v);
     $v=str_replace("<script>","<-nojsscript->",$v);
     $v=str_replace("</script>","<-/nojsscript->",$v);
    $v  = gpc_add($v);
     //$v=str_replace("\\","/",$v);

        $v=str_replace(UPLOADPATH,'imgpath_3qys0o_com',$v);
        $v=htmlspecialchars($v);
        return $v;
}


function zb_insertadv($array,$postarrexc){ //zb_insert advance
  //pre($array);
  array_pop($array);
array_pop($array);
     $oristring='';
    foreach($array as $k => $v)
    {
         if(is_array($v)) return ;
         if(in_array($k,$postarrexc))   continue;

        $v=trim($v);
         //$v=str_replace("\\","/",$v);
        $v=str_replace("<script>","<-nojsscript->",$v);
        $v=str_replace("</script>","<-/nojsscript->",$v);
        $v  = gpc_add($v);
        $v=str_replace(UPLOADPATH,'imgpath_3qys0o_com',$v);
        $v= htmlspecialchars($v);

        $abc=$k;
        $oristring .="$k='$v',";
    }
    return $oristring;
}

function setvaluefromarr($arr){ //no work
    foreach($arr as $k => $v)
     {
     //pre($v);

           global $$v;
           $$v=='';

     }

}
/************/
function zbdesp_imgpath($v) {//reverse insert
    $v=str_replace('imgpath_3qys0o_com',UPLOADPATH,$v);
    $v=str_replace("\\","/",$v);
	 $v  = gpc_strip($v);
      return $v;
}
function web_despdecode($v) {//web need decode ,but zbdesp_imgpath no decode
    $v=str_replace('imgpath_3qys0o_com',UPLOADPATH,$v);
    $v=str_replace("\\","/",$v);
	 $v  = gpc_strip($v);
      return htmlspecialchars_decode($v);
}
/******/
function zbdecode($v) {
return htmlspecialchars($v);

}
function decode($v) {
return htmlspecialchars_decode($v);//&lt;转成 <

}
 
function dmstrip_tags($desp){
	return strip_tags(decode($desp));
}
/*
function seo_decode($desp){ //replace by strip_tags()
    //alert($desp);
    $desp=str_replace('<b>','',$desp); $desp=str_replace('</b>','',$desp);
     $desp=str_replace('<i>','',$desp); $desp=str_replace('</i>','',$desp);
    return $desp;
}*/

/*************************/
function jump($link){
    echo "<script LANGUAGE='javascript'>window.location='$link'</script>";
    exit;
}
function jsconsole($v){
     echo "<script LANGUAGE='javascript'>console.log('$v');</script>";
}


function alert($text){
   echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><script>window.alert("'.$text.'")</script>';
}

function pre($v) {
    echo '<pre>'.print_r($v,1).'</pre>';
}


/*function get_price($old,$now) {
     if(!empty($old) or $old<>0) $old = "市场价：<span class=del>$old</span>";else $old="";
     if(!empty($now) or $now<>0) $now = "本店价：<span class=price>$now</span>";else $now="";
    return "$old $now";
}*/
function gl_price($price) {
    $price = explode("-",$price);$price_old=intval($price[0]); $price_now=intval($price[1]);
    if($price_old<>'' or $price_old<>0) $old = '市场价：<span class="del">'.$price_old.'</span>&nbsp;&nbsp;';
    if($price_now<>'' or $price_now<>0)  $now = '&nbsp;&nbsp;销售价：<span class="price">'.$price_now.'</span>';
    return $old.$now;
}



/***********************get  flash code  ********************** com_flash($v,'980','120','transparent');//opaque
*/
function  get_flash($v,$tm){
	global $stadir;
            $menu_jd=$stadir.$v;//alert($menu_jd);
            $menudata=GetImageSize($menu_jd);
       com_flash($menudata[0],$menudata[1],$v,$tm);//opaque
	   //com_flash($menudata[0],$menudata[1],$menu,'transparent');//opaque
}
function  com_flash($w,$h,$v,$tm){
     Global $stadirwww;
    $v=$stadirwww.$v;
echo '<object height="'.$h.'" width="'.$w.'" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"><param value="'.$v.'" name="movie"><param value="high" name="quality"><param value="'.$tm.'" name="wmode"><embed height="'.$h.'" width="'.$w.'" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" wmode="'.$tm.'" quality="high" src="'.$v.'"></object>';


}
/*************************************/


/*************************/
function  procontri($typefunc,$typefield,$rowlistsub,$typefield_v){ // get product contribute

        if($typefunc=='select'){
            $returnv= '<select name="'.$typefield.'"><option  value="">请选择：</option>';
  foreach( $rowlistsub as $v){
         $name=$v['name'];$pidname=$v['pidname'];
         if($pidname==$typefield_v) $selected=' selected="selected"'; else $selected='';
$returnv_2=$returnv_2. '<option '.$selected.'value="'.$pidname.'">'.$name.'</option>';
}//end foreach
$returnv=$returnv.$returnv_2.'</select>';
        }
 //------------------------------------------
        elseif($typefunc=='text'){  //text has no sub. when front side need dayu or xiaoyu

$returnv='<input type="text" value="'.$typefield_v.'" size="10" name="'.$typefield.'" />';
        }
 //------------------------------------------
 elseif($typefunc=='checkbox'){
       //$typefield_v=unserialize($typefield_v);
       $typefield_v=explode('-',$typefield_v);$id_i=1;
 foreach( $rowlistsub as $v){
   $name=$v['name'];$pidname=$v['pidname'];
if(in_array($pidname,$typefield_v)){    $checked='checked="checked"';$class='class="cur"';}
else{   $checked='';$class='';}
$returnv=$returnv.'<input type="checkbox" '.$checked.' value="'.$pidname.'" size="10" name="'.$typefield.'[]" id="'.$typefield.$id_i.'" /><label for="'.$typefield.$id_i.'" '.$class.'>'.$name.'</label> &nbsp;&nbsp;';
$id_i++;
}//end foreach

}
 //------------------------------------------
 elseif($typefunc=='radio'){
             $id_i=1;
 foreach( $rowlistsub as $v){
   $name=$v['name'];$pidname=$v['pidname'];
if($pidname==$typefield_v){    $checked='checked="checked"';$class='class="cur"';}
else{   $checked='';$class='';}
$returnv=$returnv.'<input type="radio" '.$checked.' value="'.$pidname.'" size="10" name="'.$typefield.'" id="'.$typefield.$id_i.'" /><label for="'.$typefield.$id_i.'" '.$class.'>'.$name.'</label> &nbsp;&nbsp;';
$id_i++;
}//end foreach

}
//-----------------------------
return $returnv;
}

/******admin and web need gl_imgtype  and gl_img_s ******************/
function gl_imgtype($v) {
return  strtolower(substr(strrchr($v,'.'),1));//echo  substr(strrchr($imgname,'.'),1);//strrchr()函数的作用是：查找一个字符串在另一个字符串中末次出现的位置，并返回从字符串中的这个位置起， 一直到字符串结束的所有字符。
}
function gl_img_s($v,$imgtype='') {//p20_uploadimg will give imgtype,other no give.so judge.
    if($imgtype=='')$imgtype = gl_imgtype($v);//imgtype have no,then get it.    //
    $imgtypelen=strlen($imgtype)+1;
     $imgfirstpart=substr($v,0,-$imgtypelen);
    return $imgfirstpart;
}
function get_thumb($addr,$title,$div) {

  if($addr<>''){

     $returnv ='';

     if(strpos($addr,'://')>1) $imgsmall = $addr;
     else{
      $imgtype = gl_imgtype($addr);$imgfirstpart=gl_img_s($addr);
  	  $imgsmall=UPLOADPATHIMAGE.$imgfirstpart.'_s.'.$imgtype;
  	  $imgsmallroot=UPLOADROOTIMAGE.$imgfirstpart.'_s.'.$imgtype;

      if(!is_file($imgsmallroot))  $returnv = '<p class="cred">文件不存在。</p>';

     }

  		if($div=='div') 	  $imgsmall_src='<img src="'.$imgsmall.'" alt="'.strip_tags($title).'" />';
  		else $imgsmall_src= $imgsmall;

      if($returnv<>'') return $returnv;
  		else return $imgsmall_src;

  }

}

function get_img($addr,$title,$div) {
  if($addr=='')  { $imgsmall_src = DEFAULTIMG;}
  else{
      if(strpos($addr,'://')>1) $addr2 = $addr;
       else $addr2 = UPLOADPATHIMAGE.$addr;
         if($div=='div')  $imgsmall_src='<img src="'.$addr2.'" alt="'.strip_tags($title).'" />';
        else $imgsmall_src= $addr2;
  }
       return $imgsmall_src;
}

function get_img_def($v) {  
  if($v=='') $v = DEFAULTIMG;
  else  $v = UPLOADPATHIMAGE.$v;
  return $v;
}


function unlinkdm($v) {
	 if(is_file($v))     unlink($v);
}


/*************************/

function url($type,$alias,$tid,$jump) {//will replace func url
   if($jump<>''){
     $linkname = $jump;
   }
    elseif($type=='cate'){ //no csub
    if($alias<>'') $linkname=$alias.'.html';
    else $linkname='category-'.$tid.'.html';
   }
    elseif($type=='page'){
    if($alias<>'') $linkname=$alias.'.html';
    else $linkname='page-'.$tid.'.html';
   }
    elseif($type=='node'){
    if($alias<>'') $linkname=$alias.'.html';
    else $linkname='detail-'.$tid.'.html';
   }

   //echo BASEURLPATH;no use here,not good way...
  //  return  $linkname;
   if(strpos($jump,':/'))   return  $linkname;
   else    return BASEURLPATH.$linkname;

}


function l($link,$name,$css,$style) {
if($css<>''){
	if(substr($css,0,5)=='class') $classv= $css;
	else $classv= ' class="'.$css.'" ';
	}
	else $classv='';
   //if($css<>'') $cssv=' class="'.$css.'" ';else $cssv=''; //css is main menu , or sub
   if($style<>'') $stylev=' style="'.$style.'" ';else $stylev='';
   if(ADMIN=='y') $target='_blank';
    else{

		 if(strpos(BASEURL,HOSTNAME)) $target='_self';
		 else $target='_blank';
  }


 return   '<a '.$stylev.$classv.'href="'.$link.'" target="'.$target.'">'.$name.'</a>';
}//end func

function alias($pid,$type) { //type=page,cate,detail...no csub
global $andlangbh;
 $sql = "SELECT name from ".TABLE_ALIAS."  where  pid='$pid' and type='$type' $andlangbh  order by id limit 1";
//	 echo $sql;exit;
	  if(getnum($sql)>0){
	      $row=getrow($sql);
				//echo '===================='.$row['name'];
		  return $row['name'];
	  }
	  else return '';
}//end func

//------------
function getlink($pidname,$type,$admin,$class=''){ global $andlangbh; //use bread in file_category.php or file_page...
  if($type=='page') { $sqllink="select * from ".TABLE_PAGE." where pidname='$pidname'  $andlangbh limit 1";
  $name = 'name';
  $linkpre = 'page-';
  }
  else if($type=='cate') {  $sqllink="select * from ".TABLE_CATE." where pidname='$pidname'  $andlangbh limit 1";
    $name = 'name';
	 $linkpre = 'category-';
    }
  else if($type=='node') {  $sqllink="select * from ".TABLE_NODE." where pidname='$pidname'  $andlangbh limit 1";
    $name = 'title';
	 $linkpre = 'detail-';
    }
$rowlink=getrow($sqllink);
$title=decode($rowlink[$name]);
$tid=$rowlink['id'];
$pidname=$rowlink['pidname'];
 if($type=='page') $alias_jump='';
else $alias_jump=$rowlink['alias_jump'];

$jumpvtext='';
if($alias_jump<>'') $jumpvtext='<span class="cred">(跳转)</span>';

$alias = alias($pidname,$type);
$url = url($type,$alias,$tid,$alias_jump);

 if($alias<>'') $texturl = $alias.'.html';
else $texturl = $linkpre.$tid.'.html';

if($alias=='index') {$texturl = 'Homepage'; $url=BASEURLPATH;}


if($admin=='admin') $link = l(ADMLINKJUMP.$url,$texturl.$jumpvtext,'','');
else $link = l($url,$title,$class,'');

return $link;

}
//--------
function  linktarget($v){
  if(strpos($v,HOSTNAME))  return '';
  else {
       if(strpos($v,':/'))    return  ' target="_blank"';
          else return '';
         }
         // return '';
}

function  linkhref($v){
	$tar =  linktarget($v);
   $vv =  $tar .' href="'.$v.'" ';
   return $vv;
}

//------------
function get_field($table,$field,$wherev,$wherek){
Global $andlangbh;
$wherev = htmlentitdm($wherev);
if($table=='TABLE_USER' || $table=='TABLE_AUTH')  return 'noid';
$sql = "SELECT $field from $table where  $wherek='$wherev' $andlangbh order by pos desc,id desc limit 1";
  //echo $sql.'<br />';
  $row= getrow($sql);
  if($row=='no') return 'noid';
 else return decode($row[$field]);
}
function get_fieldnolang($table,$field,$wherev,$wherek){
	$wherev = htmlentitdm($wherev);
	if($table=='TABLE_USER' || $table=='TABLE_AUTH')  return 'noid';
$sql = "SELECT $field from $table where  $wherek='$wherev' order by pos desc,id desc limit 1";
 //echo $sql;
  $row= getrow($sql);
  if($row=='no') return 'noid';
 else return decode($row[$field]);
}

function get_fieldarr($table,$wherev,$wherek){
	$wherev = htmlentitdm($wherev);
	if($table=='TABLE_USER' || $table=='TABLE_AUTH')  return 'no';
Global $andlangbh;
$sql = "SELECT * from $table where  $wherek='$wherev' $andlangbh order by pos desc,id desc limit 1";
//echo $sql;
  $row= getrow($sql);
  if($row=='no') return 'no';
 else return $row;
}
function get_fieldarrnolang($table,$wherev,$wherek){
	$wherev = htmlentitdm($wherev);
	if($table=='TABLE_USER' || $table=='TABLE_AUTH')  return 'no';
$sql = "SELECT * from $table where  $wherek='$wherev' order by pos desc,id desc limit 1";
//echo $sql;
  $row= getrow($sql);

  if($row=='no') return 'no';
 else return $row;
}
//--------------
function  getmusic($kvlink,$kv){
   $musicaddr = UPLOADPATH.'music/';
  if(substr($kvlink,0,4)=='http')  $kvlinkv = $kvlink;
  else $kvlinkv = $musicaddr.$kvlink;

   $musicroot = UPLOADROOT.'music/'.$kv;
   if(is_file($musicroot))  $kv_v = $musicaddr.$kv;
  else $kv_v = 'no';

  if($kvlink<>'') return $kvlinkv;
  else  return $kv_v;
 
}
//--------------
 
function  get_dirname($v){ //like in dmregion.php
 //echo realpath('.'); 
//echo getcwd();
//echo dirname(__FILE__); 
//echo $_SERVER['DOCUMENT_ROOT'],' 
//$path_parts = pathinfo(__FILE__);  -- it is $v
//pre($path_parts);
$dirnameroot =  $v['dirname'];
$dirnameroot=str_replace('\\','/',$dirnameroot);
$pos = strrpos($dirnameroot,'/')+1;
$dirname =  substr($dirnameroot,$pos);
 return $dirname; 
}

//--------------
function havesub($table,$field,$v){ //use nd_homenews_tab.if has sub,then use ppid to read node.
	Global $andlangbh;
$sql = "SELECT id from $table where  $field='$v' $andlangbh order by id desc limit 1";
if(getnum($sql)>0) return true;
else return false;

}

function havesub2($table,$field,$v,$field2,$v2){ //use nd_homenews_tab.if has sub,then use ppid to read node.
  Global $andlangbh;
$sql = "SELECT id from $table where  $field='$v' and  $field='$v'  $andlangbh order by id desc limit 1";
if(getnum($sql)>0) return true;
else return false;

}

//------------
function  checkfile($file){ 
   if(!is_file($file))
   {   
    echo '<p style="background:#ccc;color:red">没有此文件: ...'.substr($file,8).' </p>';
    return false;
   }
   else return true;
}
// if(checkfile($reqfile)) require_once($reqfile);

//判断是否ipad
function isdmipad() {  
     if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
    $is_mobile = false;
  } elseif ( strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false ) {
      $is_mobile = true;
  } else {
    $is_mobile = false;
  }
 return $is_mobile;
}
//判断是否属移动端
function isdmmobile() {  
  global $sta_colseresponsive;  global $linkofmobile;

  static $is_mobile;

  if ( isset($is_mobile) )
    return $is_mobile;

  if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
    $is_mobile = false;
  } elseif ( strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
    || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
    || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
    || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
    || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
    || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
    || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false 
     || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false
     ) {
      $is_mobile = true;
  } else {
    $is_mobile = false;
  }

 

  //jump to  mobile site
if($linkofmobile<>'' and $is_mobile) jump($linkofmobile);
 if($sta_colseresponsive=='y') return false;

  return $is_mobile;
}

function getip(){
if(!empty($_SERVER["HTTP_CLIENT_IP"])){
  $cip = $_SERVER["HTTP_CLIENT_IP"];
}
elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
  $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
elseif(!empty($_SERVER["REMOTE_ADDR"])){
  $cip = $_SERVER["REMOTE_ADDR"];
}
else{
  $cip = "无法获取！";
}
return $cip;
}

function select_return_string($arr,$i,$pdleft,$curpid){//select_return_string($arr_yn,0,'',$status);
   $return_string='';
   foreach ($arr as $k=>$v){   // echo $k.'aaaa<Br>';
     // if((int)$curpid==(int)$k) $select=' selected '; else $select='';
        if($curpid==$k) $return_string=$v;

   }
   return $return_string;
}//end func


function htmlentitdm($v){
   return htmlentities(trim($v),ENT_QUOTES,"utf-8");
}//end func






//----------------
function indexingarr( $data=array() ){   
  $newarr = array();                           //$data数据需处理以id为索引  
  foreach( $data as $v){ 
     $newarr[$v['pidname']] = $v;        
   } 
   return $newarr;
}


function getnewtreearr($items){
    $tree = array();
    foreach($items as $item){
      //判断是否有数组的索引==
        if(isset($items[$item['pid']])){     //查找数组里面是否有该分类  如 isset($items[0])  isset($items[1])
            $items[$item['pid']]['son'][] = &$items[$item['pidname']]; //上面的内容变化,$tree里面的值就变化
        }else{
            $tree[] = &$items[$item['pidname']];   //把他的地址给了$tree
        }  
    }
     return $tree; 
}
 
 function wherecatev($catpid,$catid){ 
 $catpid = trim($catpid); $catid = trim($catid); 
      $catefirst = substr($catid,0,4);
	  $returnv ='';
	  if($catefirst=='cate')  $returnv  = " ppid = '$catpid' "; 
	  else{
		     
			if(MULTICATE == 'y') $returnv  = " ppid = '$catpid'  and pidmulti like '%$catid%'" ; //when multi cate...
			else {
				 $cateidv = wherecatesubv($catpid,$catid); //only two level
				 $returnv  = " ppid = '$catpid' $cateidv " ;				
			}		  
	  }	  
	  return $returnv;
}

 function wherecatesubv($catpid,$catid){  
     global $andlangbh;
		$sqlsub = "SELECT * from ".TABLE_CATE." where  ppid='$catpid' $andlangbh order by pos desc,id";
			 $rowlistsub = getall($sqlsub);
			 if($rowlistsub=='no') {
			      return '';
			  }
			  else{
				   $tree = array();
				     foreach($rowlistsub as $v){					  
					  if($v['pid'] == $catid) $tree[]  = $v['pidname'];
					}
					 
				  if(count($tree)==0) return " and pid = '$catid' ";
				  else{
					  $tree[] = $catid;
					 // pre($tree);
					  $treestring = implode("','",$tree);
					  return " and pid in ('$treestring') ";
				  }
			  }
			  
				  
 
 }
 
 
function getwheretreearr_getPIDarr_nousetemp($items,$cur,$tree,$i){  //only use it  when add and edit node cate,add have two,one is cate gl page,one is node gl page.
 		 $i++;
		   foreach($items as $item){
				if($item['pidname']==$cur){ 
				  $pid = $item['pid'];  
				  $tree[] = $pid;
				  break;
					
				 }	 
				 else $pid='';
					 
			 }
			  
		if($i>9) return   'aaaa';//implode("-", $tree);
		else  getwheretreearr($items,$pid,$tree,$i);
}

 


?>
