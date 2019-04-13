<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
//-------------
if($type=='node') echo '<p class="cgray">提示：这里的相册效果模板文件，在内容的主类或分类里设置。</p>';

if($act=="list"){
 $sql="select * from  ".TABLE_ALBUM."  where  pid='$pid' and type='$type' $andlangbh order by pos desc,id desc";
 //echo $sql;
   $rowlist = getall($sql);
 
    ?>

<form method=post action="<?php echo $jumpvpid;?>&act=pos">
     <?php
	   if($rowlist == 'no') {
         //$loactlink= $PHP_SELF."?pid=$pid&act=add";
        //jump($loactlink);//
        echo '<p style="padding:100px">没有相关图片，请添加。</p>';
     }
     
    else{
        //echo  adm_previewlink($ppid); 

        foreach($rowlist as $v){
            $imgsqlname = $v['kvsm'];
			$title = $v['title'];$desp = $v['desp'];
			$tid = $v['id'];
$imgsmall = p2030_imgyt($imgsqlname,'n','y') ;

 menu_changesta($v['sta_visible'],$jumpvpid,$tid,'sta_sub');
          
 
if($title=='') $title='无标题';

$edit_text="<a href=$jumpv&file=edit&tid=$tid&act=edit  class='but1'>修改</a>";
$del_text= "<a href=javascript:delimg('delimg','$tid','$imgsqlname','$jumpvpid')  class='but2'>删除</a>";


?>
<div <?php echo $tr_hide;?>>
 <ul class="albumadm">
      <?php
      echo '<li class="imgsm">'.$imgsmall.'</li>';
      echo '<li class="title">'.$title.'</li>';
      echo '<li class="title desp cgray">'.$desp.'</li>';
      echo '<li >'.$edit_text.'</li>';
      echo '<li >'.$del_text.'</li>';
      echo '<li >'.$sta_visible.'</li>';

     ?>

<li>排序：<input type="text" name="<?php echo $v['id'];?>"  value="<?php echo $v['pos'];?>" size="5" /></li>
</ul>
</div>
    <?php
    }
          ?>
<div class="c20"></div>
<div style="padding-bottom:22px">
<input class="mysubmit" type="submit" name="Submit" value="修改排序" />
<br />
<?php echo $sortid_desc?>
</div>
<?php } 
?>
</form>
<?php } 
?>
<p class="cred">如果修改图片后，图片没有换新，可能是缓存，请刷新下本页面即可。</p>