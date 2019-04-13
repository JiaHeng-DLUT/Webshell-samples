<?php
/*
powder by JASON.ZHANG

*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

/*********************************************************/
function p2030_imgyt($addr,$w_h='y',$linkbig='n') { //sure is img,use p2030_imgyt($bgimg,'y','y');,or use check_blockid($bgimg);

  if($addr=='') return '<span class="cgray">暂无图片</span>';
Global $attach_img;

	 $imgtype = gl_imgtype($addr);$imgfirstpart=gl_img_s($addr);
	  $addr_small=UPLOADPATHIMAGE.$imgfirstpart.'_s.'.$imgtype;

	$addr_v = UPLOADROOTIMAGE.$addr;

	$addr_vwww = UPLOADPATHIMAGE.$addr.'?v='.rand(1000,9999);
        //echo $w_h;exit;

if(strpos($addr,'://')>1){
	 return '<div><a target=_blank href='.$addr.' ><img src='.$addr.' alt="查看原图" width="120" height="70" /><br />查看原图</a></div>';
}
else{

   if(is_file($addr_v))//file_exists = is_dir + is_file
        {

           // if($imgtype=='swf') return '<a class="vieflash" target=_blank href='.$addr_vwww.' >查看Flash</a>';
			if(!in_array($imgtype,$attach_img)) return '<a href='.$addr_vwww.' target="_blank">'.$imgtype.'格式[下载]</a>';

      // if($w_h=='y')  return '<div><a class="needpopup" target=_blank href='.$addr_vwww.' ><img src='.$addr_vwww.' alt="显示图片" width="120" height="70" /><br />查看原图</a></div>';
      //       else  {
      //   				if($linkbig=='y') return '<div><a   target=_blank href='.$addr_vwww.' ><img src='.$addr_small.' alt="显示图片" width="120" height="70" /><br />查看大图</a></div>';

      //           return '<img src='.$addr_vwww.' alt="显示图片"/>';

      //   			}
 return '<div class="imgyt"><a   target=_blank href='.$addr_vwww.' ><img src='.$addr_vwww.' alt="显示图片" width="120" height="70" /><br />查看原图</a></div>';

        }
        else return '<strong class="cred">文件不存在，请检查是否填写正确 - '.$addr.'</strong>';
}
}
/*********************************************************/
function p2030_delimg($addr,$delbig,$delsmall){
$imgtype = gl_imgtype($addr);
if($delsmall=='y'){
            $imgfirstpart=gl_img_s($addr);
            $addr2 =UPLOADROOTIMAGE.$imgfirstpart.'_s.'.$imgtype;
         if(is_file($addr2)) unlinkdm($addr2);//when use in test,temp not delete
         }//else only del big img.
if($delbig=='y'){ $addrbig =UPLOADROOTIMAGE.$addr;
            if(is_file($addrbig))  unlinkdm($addrbig);
}
}

/******************************************************************************/

function menu_changesta($v,$jumpv,$tid,$act) {
Global $sta_visible;Global $tr_hide;
    if($v=="n")
            {
             $menusta="<a href='$jumpv&act=$act&v=y&tid=$tid' class='but3'>切换状态</a>";
                $sta_visible="<span class=cred>隐藏</span> $menusta";
             $tr_hide=' class="tr_hide" ';
            }
            else {
                 $menusta="<a href='$jumpv&act=$act&v=n&tid=$tid' class='but3'>切换状态</a>";
                 $sta_visible="显示 $menusta";
            $tr_hide='';
            }
            return ;

}

function menu_changesta22($v,$jumpv,$tid,$act) { //use in sta_big5
    if($v=="n")
            {
             $changev="<a href='$jumpv&act=$act&v=y&tid=$tid' class='but3'>切换状态</a>";
            }
            else {
                 $changev="<a href='$jumpv&act=$act&v=n&tid=$tid' class='but3'>切换状态</a>";

            }
            return $changev;

}

/************************************/
function f2030_pagelink_from_cat($catname) {//$catname is catid
Global $user2510;
 $sql = "SELECT pagelink from zmoo_menu where pbh='".USERBH."' and  bs_cat='$catname'  order by id desc";
  $row = getrow($sql);
      $pagelink = $row['pagelink'];
  if($pagelink <>'')  return $pagelink;else 'unknown';

}
/********************/
function f2030_menuname_from_cat($catname) {//$catname is catid,then get menuname;menuname is pagelink
Global $user2510;
 $sql = "SELECT name from zmoo_menu where pbh='".USERBH."' and  bs_cat='$catname' and sta_cmp='y' order by id desc";
  $row = getrow($sql);
      $menuname = $row['name'];
  if($menuname <>'')  return $menuname;else 'unknown';

}

/******************************************************************************/

function p20_edit_text($v,$phpself,$tid,$catid,$page) {
  return "<a class='but1' href='$phpself?act=edit&tid=$tid&catid=$catid&page=$page'>$v</a>";
}
function p20_del_text($v,$phpself,$tid,$catid,$page,$pidname) {
  return "<a href=javascript:del5('$phpself','$tid','del','$catid','$page','$pidname')  class=but2>$v</a>";
}

/*********************************************/
function chao_red($table,$ppid,$nums,$jumpv,$jumpif='y') {
     GLOBAL  $user2510; GLOBAL  $chao_rec;
     if($ppid<>'') {$ppid=" and ppid='$ppid' ";
     }
 $sql = "SELECT id from $table where pbh='".USERBH."'  $ppid order by id desc";
        $num_rows = get_numrows($sql);
        if($num_rows>=$nums){
            $chao_rec=$chao_rec.'  - (允许数为:'.$nums.')';
            if($jumpif=='y'){  alert($chao_rec); jump($jumpv);}
            else{
                $chao_rec=$chao_rec.' - 请点击浏览器的后退键返回';
              alert($chao_rec);
            }
            exit;
        }
}
function chao_red_imgsm($table,$rec,$jumpv,$pid,$lx) {
     GLOBAL  $user2510; GLOBAL  $chao_rec;
 $sql = "select id from  $table  where pbh='".USERBH."' and  pid='$pid' and lx='$lx' order by  id desc ";
        $num_rows = get_numrows($sql);
        if($num_rows>$rec){
            alert($chao_rec);
            jump($jumpv.'?pid='.$pid);
        }

}


/***********************************/
function p2030_waterjudge() {
    global $waterv;
  //  Global $imgtype_img;//echo $waterv;
   // $imgtype=gl_imgtype($waterv_addr);
    //if(is_file($waterv) && in_array($imgtype,$imgtype_img)) return 'y';
	if(is_file($waterv)) return 'y';
    else return 'n';

}

/*****************************
function tongbu_pidname($table) {
    Global $user2510;
 $ss = "select id from $table where pbh='".USERBH."' order by id desc  limit 1";
 $row = getrow($ss);$tid=$row['id']; $pidname=date("YmdHis").'_'.rand(1000,9999) ;//char 19
 $ss = "update $table set pidname='$pidname' where id='$tid' and pbh='".USERBH."' limit 1";
iquery($ss);
}
*/

//-------------

 function num_subnode($table,$field,$value){
     //or havesub($table,$field,$v) or havesub2($table,$field,$v,$field2,$v2)
  global $andlangbh;
  $sql = "SELECT id from $table  where  $field= '$value' $andlangbh order by id";
   return getnum($sql);

}

//-----------
function num_imgfj($pidname){
  global $andlangbh;
	$sql = "SELECT id from ".TABLE_IMGFJ."  where  pid='$pidname' $andlangbh order by id";

   return '<span class="cred">'.getnum($sql).'</span>';

}
//-----------
function string_staaccess($v){
   if($v=='y') return '<span class="cred"> (禁止访问)</span>';
  // else return $v;
    else return '';
}
function string_stavisi($v){
   if($v=='n') return ' (隐藏)';//use for select in menu edit can.php
  // else return $v;
    else return '';
}

//--------------

function checkbs_pagecate($pid_inherit){ //use in layout.php
     $firstzm=substr($pid_inherit,0,4);

      if($firstzm=='page'){
        $name = get_field(TABLE_PAGE,'name',$pid_inherit,'pidname');
        if($name=='noid') return '出错，标识不对';
        else  return  '继承单页面： '.$name;
    }
     else  if($firstzm=='cate' || $firstzm=='csub'){
        $name = get_field(TABLE_CATE,'name',$pid_inherit,'pidname');
        if($name=='noid') return '出错，标识不对';
        else return '继承分类： '.$name;

     }
       else {return '出错，标识不对';}


}

//----------------------------------------------------
function check_blockid($biaoshi){
   global $andlangbh; global $attach_img;
   $editlink = '';
  $editlinkerror = '<span class="cred">标识'.$biaoshi.' 不存在，请仔细检查。</span>';

  $firstzm=substr($biaoshi,0,4);
  /*
$isimgfj = is_int(strpos($biaoshi,'/'));
*/
 $imgtype = gl_imgtype($biaoshi);
 $isimgfj = false;
if(in_array($imgtype,$attach_img)) $isimgfj = true;

if($biaoshi<>''){

if($isimgfj || $imgtype=='ico') {

    if(is_int(strpos($biaoshi,'|'))){
        $arrimg = explode('|',$biaoshi); 
        //pre($arrimg);
        echo '<p style="background:#f9f2e7;padding:8px">链接：'.$arrimg[0];
        echo '<br />alt文字：'.$arrimg[1];
        echo '<br />图片： <img   height="50" width="100" src="'.UPLOADPATHIMAGE.$arrimg[2].'" alt="'.$arrimg[1].'" /></p>';         
     }
     else {         
            //echo strpos($biaoshi,'://');
            if(strpos($biaoshi,'://')>1) $addr2 = $biaoshi;
            else $addr2 = UPLOADPATHIMAGE.$biaoshi;
            //echo $addr2;
            $editlink=' <div class="cgray"><a target="_blank"  href="'.$addr2.'"><img src="'.$addr2.'" height="50" width="100" alt="" /><br/ >(查看原图)</a></div>';    
    }
}

 elseif($firstzm=='vblo'){
				$sql = "SELECT pid from ".TABLE_BLOCK." where pidname = '$biaoshi' $andlangbh   order by id limit 1";
				if(getnum($sql)==0) $editlink = $editlinkerror;
				else {
            $row = getrow($sql);
				    $type = $row['pid'];  // get_field($table,$field,$v,$type){

            $linkv = '../mod_block/mod_block.php?lang='.LANG.'&act=edit&type='.$type.'&pidname='.$biaoshi;

         $admpreview=adm_previewlink($biaoshi);

				$editlink='<a target="_blank" href="'.$linkv.'" class="green">修改标识 '.$biaoshi.'</a> '.$admpreview;
				  }
}
   //lang=cn&pidname=&file=edit&act=edit&tid=147

   elseif($firstzm=='regi')
    {
      //mod_region/mod_region.php?lang=cn&pid=region20170823_1713316899
				$sql = "SELECT id from ".TABLE_REGION." where pidname = '$biaoshi' $andlangbh   order by id limit 1";
				if(getnum($sql)==0) $editlink = $editlinkerror;
				else {
      $editlink='<a target="_blank" href="../mod_region/mod_region.php?lang='.LANG.'&pid='.$biaoshi.'" class="green">修改标识 '.$biaoshi.'</a>'.adm_previewlink($biaoshi);
				}
}
elseif($firstzm=='imgt')
{
  //mod_region/mod_region.php?lang=cn&pid=region20170823_1713316899
    $sql = "SELECT id from ".TABLE_IMGTEXT." where pidname = '$biaoshi' $andlangbh   order by id limit 1";
    if(getnum($sql)==0) $editlink = $editlinkerror;
    else {
  $editlink='<a target="_blank" href="../mod_imgtext/mod_imgtext.php?lang='.LANG.'&pid='.$biaoshi.'" class="green">修改标识 '.$biaoshi.'</a>'.adm_previewlink($biaoshi);
    }
}

 

   elseif($firstzm=='grou')
    {
				$sql = "SELECT id from ".TABLE_BLOCKGROUP." where pidname = '$biaoshi' $andlangbh   order by id limit 1";
				if(getnum($sql)==0) $editlink = $editlinkerror;
				else {
    //mod_column/mod_column.php?lang=cn&pid=group20160509_1200413359&type=group
 $editlink='<a target="_blank" href="../mod_column/mod_column.php?lang='.LANG.'&pid='.$biaoshi.'&type=group" class="green">修改标识 '.$biaoshi.'</a> '.adm_previewlink($biaoshi);
				}
}


  elseif($firstzm=='prog') {
    $profile = BLOCKROOT.'prog/'.$biaoshi.'.php';
    checkfile($profile);
    //if(is_file($profile ))
       //$editlink=' <span class="cgray">(自定义文件 prog/'.$biaoshi.'.php)</span>';
     //else  $editlink=' <span class="cred">(自定义文件 prog/'.$biaoshi.'.php 不存在！)</span>';
    }
    elseif($firstzm=='mypr') { //myprog
        $profile = TPLCURROOT.'selfblock/myprog/'.$biaoshi.'.php';
        checkfile($profile);
        }

   elseif($firstzm=='vide') {   //mbst301.php
       ///mod_video/mod_video.php?lang=cn&page=0&pid=0&type=block&tid=188&act=edit
       $arr =  get_fieldarr(TABLE_VIDEO,$biaoshi,'pidname');

               if($arr<>'no'){
                     $tid=$arr['id'];
                     $type=$arr['type'];
                     if($type=='block') {
                     $editlink='<a target="_blank" href="../mod_video/mod_video.php?lang='.LANG.'&tid='.$tid.'&act=edit&page=0&pid=0&type=block" class="green">修改标识 '.$biaoshi.'</a> '.adm_previewlink($biaoshi);
                   }
               }else   $editlink = $editlinkerror;


    }

elseif($firstzm=='albu') {   //mbst301.php
  // mod_album/mod_mainalbum.php?lang=cn&page=0&tid=177&act=edit

            $arr =  get_fieldarr(TABLE_ALBUM,$biaoshi,'pidname');
            if($arr<>'no'){
                $tid=$arr['id'];
            $editlink='<a target="_blank" href="../mod_album/mod_mainalbum.php?lang='.LANG.'&tid='.$tid.'&act=edit&page=0" class="green">修改标识 '.$biaoshi.'</a> '.adm_previewlink($biaoshi);
            }else   $editlink = $editlinkerror;

     }
     elseif($firstzm=='musi') {
        // mod_music/mod_mainmusic.php?lang=cn&page=0&tid=20&act=edit
        $arr =  get_fieldarr(TABLE_MUSIC,$biaoshi,'pidname');
        if($arr<>'no'){
          $tid=$arr['id'];
        $editlink='<a target="_blank" href="../mod_music/mod_mainmusic.php?lang='.LANG.'&tid='.$tid.'&act=edit&page=0" class="green">修改标识 '.$biaoshi.'</a> '.adm_previewlink($biaoshi);
        }else   $editlink = $editlinkerror;
    }
elseif($firstzm=='form') {   
       //mod_form/mod_form.php?lang=cn&pid=block&type=block&file=addedit&act=edit&pidname=form20181219_1421366828
       $linkv = '../mod_form/mod_form.php?lang='.LANG.'&pid=block&type=block&file=addedit&act=edit&pidname='.$biaoshi;
     $editlink='<a target="_blank" href="'.$linkv.'" mod_form="green">修改标识 '.$biaoshi.'</a> '.adm_previewlink($biaoshi);
    }
    elseif($firstzm=='dmre') {   
          if(is_int(strpos($biaoshi,'/'))){
            $regfname = $biaoshi.'.php';  
          }
          else {
            $regfname = $biaoshi.'/'.$biaoshi.'.php';          
          }         
        $regionfile = REGIONROOT.$regfname;
        if(is_file($regionfile)) echo '<p class="cblue"> 调用 DM-region/'.$regfname.'</p>';
        else echo '<p class="cred">  DM-region/'.$regfname.'文件不存在</p>';
        //mod_form/mod_form.php?lang=cn&pid=block&type=block&file=addedit&act=edit&pidname=form20181219_1421366828
        //$linkv = '../mod_form/mod_form.php?lang='.LANG.'&pid=block&type=block&file=addedit&act=edit&pidname='.$biaoshi;
      //$editlink='<a target="_blank" href="'.$linkv.'" mod_form="green">修改标识 '.$biaoshi.'</a> '.adm_previewlink($biaoshi);
     }

elseif($firstzm=='cate' or $firstzm=='csub') {$editlink='';}
elseif($firstzm=='hide') {$editlink='';}
else  $editlink=' <span class="cred">(标识错误'.$biaoshi.')</span>';

//-----------------

return  $editlink;
}
else return '<span class="cgray">无标识</span>';


}



//--------------
function spancolor($v){
    $whitecss = '';
	if($v=='white' || $v=='#fff' ||$v=='#ffffff') $whitecss = 'border:1px solid #ccc;';
    echo ' <span style="'.$whitecss.'display:inline-block;width:30px;height:15px;background:'.$v.'"> </span>';

}
//--------------

 function adm_previewlink($pidname){
   global $langpath;
     $previewlink = BASEURL.'adminfrom.php?to=previewofndlist&tov='.$pidname.'='.$langpath;
  return '<a  class="but4"  href="'.$previewlink.'" target="_blank"><span><i class="fa fa-link"></i> 预览</span></a>';
}

function iframepage($framesrc){
 echo '<Iframe  id="iframepage"  src="'.$framesrc.'" width="100%" height="1500" scrolling="no" frameborder="0" onload="Javascript:SeIframeHeight(this)"></iframe>';

}

function iframenormal($framesrc,$hei){
 echo '<Iframe  id="iframepage"  src="'.$framesrc.'" width="100%" height="'.$hei.'" scrolling="" frameborder="0"></iframe>';

}


function jsdelname($v){
  $v=str_replace('"','',$v);
  $v=str_replace("'",'',$v);
  $v=str_replace(" ",'-',$v);//js遇到空格，竟然会加个双引号。

   return mb_substr(strip_tags(trim($v)),0,20,'UTF-8').'...';
}


function showblockid(){

return '<a class="needpopup" href="../mod_module/mod_showblockid.php?lang='.LANG.'">查看标识 ></a>';

}


function admblockid($v ){
   return  ' <span class="cgray">[DMblockid]'.$v.'[/DMblockid]</span> ';
}


//获取文件目录列表,该方法返回数组
function getDir($dir) {
    $dirArray[]=NULL;
    if (false != ($handle = opendir ( $dir ))) {
        $i=0;
        while ( false !== ($file = readdir ( $handle )) ) {
            //去掉"“.”、“..”以及带“.xxx”后缀的文件
            if ($file != "." && $file != ".."&&!strpos($file,".")) {
                $dirArray[$i]=$file;
                $i++;
            }
        }
        //关闭句柄
        closedir ( $handle );
    }
    return $dirArray;
}

  //获取文件列表
function getFile($dir) {
    //echo $dir;
    $fileArray[]=NULL;
    if (false != ($handle = opendir ( $dir ))) {
        $i=0;
        while ( false !== ($file = readdir ( $handle )) ) {
             
            //去掉"“.”、“..”以及带“.xxx”后缀的文件
            if ($file != "." && $file != ".."&&strpos($file,".")) {
               // $fileArray[$i]="./imageroot/current/".$file;
              // echo $file.'==<br>';
         if(substr($file,0,3)<>'vv_')  $fileArray[$i]=$file;
                if($i==100){
                    break;
                }
                $i++;
            }
        }
        //关闭句柄
        closedir ( $handle );
    }
   // pre($fileArray);
    return $fileArray;
}

function fronturl($v){
     if(strpos($v,'://')>1)  $url =  BASEURL.'adminfrom.php?to='.$v;
     else $url =  BASEURL.'adminfrom.php?to='.BASEURLPATH.$v;
     return $url;
}


function admlink($arr,$url='',$title=''){
    if($url==''){
              $url = get_url($arr);

        }
        $titlev = $title<>''?$title:$url;
     return '<a href="'.fronturl($url).'" target="_blank">'.$titlev.'<i class="fa fa-external-link-square"></i></a>';

}



function admfont($v,$el='',$cssel=''){  //css:  cgray,  cred, cblue, cyel
    $elv  = $el==''?'span':'p';
    $cssv  = $css==''?'cgray':$css;
    return ' <'.$elv.' class="'.$cssv.'">'.$v.'</'.$elv.'>';
}
function spangray($v){
    return ' <span class="cgray">'.$v.'</span>';
}
 

function spanred($v){
    return ' <span class="cred">'.$v.'</span>';
}
function spanblue($v){
    return ' <span class="cblue">'.$v.'</span>';
}
function spanyellow($v){
    return ' <span class="cyel">'.$v.'</span>';
}
 





?>
