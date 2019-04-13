<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}


 if($act=='update'){
// pre($_POST);

  if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}


  if($abc1=='') $abc1 = 'pls input title';
 
   $desp = zbdesp_onlyinsert($_POST['despcontent']); //note: desp and addr not use variable abc1.
    $desptext = zbdesp_onlyinsert($_POST['editor1text']);

		 $ss = "update ".TABLE_PAGE." set name='$abc1',regionid='$abc2',desptext='$desptext',desp='$desp',sta_noaccess='$abc3' where id='$tid' $andlangbh limit 1";
	 // echo $ss;exit;
	 	iquery($ss);
  
	 jump($jumpv_back);


 }
 else
 {

  $desp=zbdesp_imgpath($row['desp']);
   $desptext=zbdesp_imgpath($row['desptext']);
   $pidname =$row['pidname'];
 
  $sta_noaccess =$row['sta_noaccess'];

   


 
 ?>

 <div class="contenttop">

<?php 
  $del_text= "<a href=javascript:del('delpage','$pidname','$jumpv','$jsname')  class='but2 fr' ><i class='fa fa-trash-o'></i> 删除</a>";
  
echo  $del_text;
?>

 
   <a class="needpopup" href="../mod_seo/mod_seo_edit.php?lang=<?php echo LANG;?>&act=edit&pidname=<?php echo $pidname;?>&type=page"><i class="fa fa-pencil-square-o"></i> 修改SEO</a>

&nbsp;&nbsp;&nbsp;&nbsp;
  <a class="needpopup" href="../mod_seo/mod_alias_edit.php?lang=<?php echo LANG;?>&act=edit&pidname=<?php echo $pidname;?>&type=page"><i class="fa fa-pencil-square-o"></i> 修改别名</a> 
  <?php 
  $alias= alias($pidname,'page');
  if($alias<>'') echo '( '.spangray($alias).' )';
  ?> 

 
  
 </div>

 <form  action="<?php echo $jumpv_file; ?>&act=update" method="post" enctype="multipart/form-data">
  
 
  <table class="formtab" >
   <tr>
     
      <td>

 <div style="padding:10px"><strong style="font-size:16px"> 标题：</strong> 
 <input style="padding:3px;border:1px solid #999"  name="title" type="text" value="<?php echo $row['name']?>" class="form-control" />
</div>


 <div style="padding:10px;border-bottom: 1px solid #ccc"><strong style="font-size:16px;"> 内容标识：</strong> 
 <input style="padding:3px;border:1px solid #999"  name="regionid" type="text" value="<?php echo $regionid?>" size="30" />
 <?php  
  echo  check_blockid($regionid);
  ?>
 <br />
 <span class="cgray">如果 内容标识 有值，则会替代编辑器的内容。页面内容由内容标识决定。 </span>
</div>
<div style="padding:10px;border-bottom: 1px solid #ccc">
禁止访问:  <select name="sta_noaccess">
    <?php select_from_arr($arr_yn,$sta_noaccess,'');?>
     </select>
   <?php
   if($sta_noaccess=='y') echo '<span style="color:red">禁止访问</span>';
   ?>
 </div>
 
 <div class="" style="margin:0px;padding:6px;border:0px solid blue">
<?php 
  $jump_imgfj='../mod_imgfj/mod_imgfj.php?pid='.$pidname.'&lang='.LANG;
  
  $numimgtext = num_subnode(TABLE_IMGTEXT,'pid',$pidname);
  $numalbum = num_subnode(TABLE_ALBUM,'pid',$pidname);
  $numvideo = num_subnode(TABLE_VIDEO,'pid',$pidname);
  $nummusic = num_subnode(TABLE_MUSIC,'pid',$pidname);
  ?>
 <a href="<?php echo $jump_imgfj; ?>"  class="needpopup">私有编辑器附件管理(<?php echo num_imgfj($pidname);?>)  </a>
  或  <?php echo $text_imgfjlink_bjq ?>
   | 
   <a target="_blank" href="../mod_imgtext/mod_mainimgtext.php?lang=<?php echo LANG?>&pid=<?php echo $pidname?>">图文编辑器(<span class="cred"><?php echo $numimgtext;?></span>)</a>
  
  |   <a target="_blank" href="../mod_album/mod_mainalbum.php?lang=<?php echo LANG?>&pid=<?php echo $pidname?>">相册(<span class="cred"><?php echo $numalbum;?></span>)</a>
  |   <a target="_blank" href="../mod_video/mod_video.php?lang=<?php echo LANG?>&pid=<?php echo $pidname?>">视频(<span class="cred"><?php echo $numvideo;?></span>)</a>

  | <a target="_blank" href="../mod_music/mod_mainmusic.php?lang=<?php echo LANG?>&pid=<?php echo $pidname?>">音乐(<span class="cred"><?php echo $nummusic;?></span>)</a> 

   <br />

 
 </div>

        </td>
    </tr>
 
   <tr>
  
      <td>
 
      <?php 
      require_once('../plugin/editor_textarea.php');//textarea is in this file
      ?>

        </td>
    </tr>
 


</table>
 
 </div>
 

  


<div class="c tc"> 
 
 <input class="mysubmit mysubmitbig"     type="submit" name="Submit" value="提交" /> 
     
<?php echo $inputmust;?>
 </div>

 </form>

   <?php 
   //require_once('../plugin/editor_imgintroduce.php'); 
   ?>


<?php
  }
  ?>
 


 <script>
 $(function(){

    $('.mysubmitnew').click(function(){


 var titlev =  $("input[name='title']").val().trim();
    if(titlev=='') {
      alert('请输入标题');
      $("input[name='title']").focus();
      return false;

    }

  
  //-------------
}

      );

 });
 
 </script>
 <div class="c tc" style="height:100px"> </div>