<?php
/*	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
$mod_previ = 'normal';//default is admin,and set in common.inc
require_once '../config_a/common.inc2010.php';
$menu_content = 'y';
require_once HERE_ROOT.'config_a/func.previ.php';//when normal,require is here.
//

if($type=='node') { }
else {  echo 'type is error'; exit;}
if($type2=='nodeprocan' || $type2=='nodeotherinfo') { }
else {  echo 'type2 is error';exit;}


if($pid <> "")  ifhaspidname(TABLE_NODE,$pid);

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
$jumpv='mod_pop_nodetext.php?lang='.LANG.'&pid='.$pid.'&type='.$type.'&type2='.$type2;
 
 $title='管理其他内容';
 
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



/*****
****
***
*********************/


require_once HERE_ROOT.'mod_common/tpl_header_iframe.php';
?>


 <section class="content">
        <?php
      require_once HERE_ROOT.'mod_node/tpl_nodetext_edit.php';

        ?>
 </section>
<?php
require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php';
?>
