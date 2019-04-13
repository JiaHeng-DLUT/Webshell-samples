<?php
/*	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
$mod_previ = 'normal';//default is admin,and set in common.inc
require_once '../config_a/common.inc2010.php';
$menu_content = 'y';
require_once HERE_ROOT.'config_a/func.previ.php';//when normal,require is here.
//
if($catpid <> "")  ifhaspidname(TABLE_CATE,$catpid);
$subcate = '';
if($catid <> "")  {ifhaspidname(TABLE_CATE,$catid);
  $subcate = get_field(TABLE_CATE,'name',$catid,'pidname');
}

//$modtype = get_field(TABLE_CATE,'modtype',$catpid,'pidname');
//if($modtype<>'node') {echo 'modtype must be node';exit;}

ifhave_lang(LANG);//TEST if have lang,if no ,then jump
if($act <> "pos") zb_insert($_POST);

$modtype='node';


//-----------------------------
//
$jumpv='mod_node.php?lang='.LANG.'&catpid='.$catpid.'&page='.$page;
$jumpv_catid='mod_node.php?lang='.LANG.'&catpid='.$catpid.'&catid='.$catid.'&page='.$page;

$jumpv_add=$jumpv_catid.'&file=add&act=add';


/********************************************************/
/*get title***************************/
  $maincate = get_field(TABLE_CATE,'name',$catpid,'pidname');
  $title = $maincate;

$mainarr_can = get_field(TABLE_CATE,'arr_can',$catpid,'pidname');
//get sta_field from cate arr_can
$bscntarr = explode('==#==',$mainarr_can);
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }

//----------------------

if($file=='add') $title='添加';
/****************************/

//--------------------


if($act == "sta_node")
{
     $ss = "update ".TABLE_NODE." set sta_visible='$v' where id='$tid' and ppid='$catpid' $andlangbh limit 1";
    iquery($ss);
    jump($jumpv_catid);
}

if($act == "pos")
{
   foreach ($_POST as $k=>$v){
         $ss = "update ".TABLE_NODE." set  pos='$v' where id='$k' and ppid='$catpid' $andlangbh limit 1";
         iquery($ss);
        }
    jump($jumpv_catid);
}


if($act == "nodetj")
{
  $ss = "update ".TABLE_NODE." set sta_tj='$v' where id='$tid' and ppid='$catpid' $andlangbh limit 1";
  iquery($ss);
  jump($jumpv_catid);
}
if($act == "nodenew")
{
  $ss = "update ".TABLE_NODE." set sta_new='$v' where id='$tid' and ppid='$catpid' $andlangbh limit 1";
  iquery($ss);
  jump($jumpv_catid);
}
if($act == "nodenoaccess")
{
  //$ss = "update ".TABLE_NODE." set sta_noaccess='$v' where id='$tid' and ppid='$catpid' $andlangbh limit 1";
  //iquery($ss);
 // jump($jumpv_catid);
}

if($act == "delnode")
{

$ifdel1 =  ifcandel_field(TABLE_IMGFJ,'pid',$pidname,'equal','出错，编辑器里有图片，请先删除编辑器图片！',$jumpv_catid);
//$ifdel1 = ifcandel(TABLE_IMGFJ,$pidname,'出错，编辑器里有图片，请先删除编辑器图片！',$jumpv_catid);
 $ifdel2 =  ifcandel_field(TABLE_ALBUM,'pid',$pidname,'equal','出错， 请先删除相册 ！',$jumpv_catid);
 $ifdel3 =  ifcandel_field(TABLE_MUSIC,'pid',$pidname,'equal','出错， 请先删除音乐 ！',$jumpv_catid);
 $ifdel4 =  ifcandel_field(TABLE_IMGTEXT,'pid',$pidname,'equal','出错， 请先删除图片文本生成器 ！',$jumpv_catid);
//  $ifdel5 =  ifcandel_field(TABLE_VIDEO,'pid',$pidname,'equal','出错， 请先删除视频 ！',$jumpv_catid);
if($ifdel1 && $ifdel2 && $ifdel3 && $ifdel4)  {

  ifsuredel_fieldmore(TABLE_NODETEXT,'pid',$pidname,'equal','noback');
  ifsuredel_fieldmore(TABLE_VIDEO,'pid',$pidname,'equal','noback');

  $kvarr = get_fieldarr(TABLE_NODE,$pidname,'pidname');
    //pre($kvarr);
  $kv = $kvarr['kv'];$kvsm = $kvarr['kvsm'];$kvsm2 = $kvarr['kvsm2'];

  if($kv<>'')  p2030_delimg($kv,'y','n');//p2030_delimg($addr,$delbig,$delsmall) //delsmall only ablum small img.
  if($kvsm<>'')  p2030_delimg($kvsm,'y','n');
  if($kvsm2<>'')  p2030_delimg($kvsm2,'y','n');
 //ifsuredel_fieldmore(TABLE_FIELDVALUE,'pidnode',$pidname,'equal','noback');
 ifsuredel_fieldmore(TABLE_TAGNODE,'node',$pidname,'equal','noback');
    ifsuredel_field(TABLE_NODE,'pidname',$pidname,'equal',$jumpv_catid);
}

}

/*****
****
***
*********************/


require_once HERE_ROOT.'mod_common/tpl_header.php';
?>

<section class="content-header">


      <h1>
      <?php
     echo '内容管理';

      if($catpid==''){ }
      else {
          echo ' - <a  class="breadtitle" href="'.$jumpv.'">'.$title.'</a>';

          echo ' - <a target="_blank" class=" " href="../mod_category/mod_subcate.php?lang='.LANG.'&catid='.$catpid.'">分类管理</a>';

       //
      //  echo '<a style="font-size:20px;color:red"  href="../mod_node/mod_node.php?lang='.LANG.'&catpid='.$catpid.'&page=0">'.$maincate.'</a> ';
       // if($subcate<>'') echo  ' - '.$subcate;


  }

      ?></h1>
</section>


 <section class="content">
        <?php

       if($catpid<>''){
         require_once HERE_ROOT.'mod_node/tpl_node_header.php';
          require_once HERE_ROOT.'mod_node/tpl_node_'.$file.'.php';
        }
        else{
           require_once HERE_ROOT.'mod_node/tpl_node_header_maincatelist.php';
        }

        ?>
 </section>
<?php
require_once HERE_ROOT.'mod_common/tpl_footer.php';
?>
