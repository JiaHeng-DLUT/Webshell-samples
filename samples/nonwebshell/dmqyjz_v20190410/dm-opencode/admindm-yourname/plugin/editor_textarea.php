<p>
 格式有两种，一种是编辑器格式，一种是纯文本格式。
 编辑器格式适合用户编辑所见即所得，但会过滤一些html，所以如果自己写html源代码的话，请使用纯文本格式。
 </p>	
 <?php 
 if($desptext==''){$curtext='';$curck='cur';$dntext='dn';$dnck='';}
 else {$curtext='cur';$curck='';$dntext='';$dnck='dn';}
 
 ?>
<div class="tab">
	     <span class="<?php echo $curtext?>">纯文本格式</span>
		 <span class="<?php echo $curck?>">编辑器格式</span>
 </div>
<div class="tabarea">
<div class="tab1 <?php echo $dntext?>">
<p>如果纯文本格式里有内容，那么编辑器格式里的内容不会在前台显示。</p>
<textarea class="form-control" rows="35"  name="editor1text">
<?php 
echo $desptext;
?>
</textarea>
</div><!--end tab1-->
 <div class="tab2 <?php echo $dnck?>"> 
	  <?php 
	  if($editor == 'ck') require_once('../plugin/editor_ck.php');
	  else if($editor == 'simditor')	require_once('../plugin/editor_simditor.php');
	  else if($editor == 'baidu')	require_once('../plugin/editor_baidu.php');
	  else if($editor == 'kind') require_once('../plugin/editor_kind.php');
     
 
?>
</div><!--end tab2-->
</div><!--end tabarea-->
