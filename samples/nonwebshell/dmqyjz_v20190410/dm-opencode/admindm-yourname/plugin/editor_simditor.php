
<textarea id="simditor_id" name="despcontent" style="width:100%;height:450px;">
<?php  
echo $desp;
?>
</textarea>
 
 <?php 
$editpath = STAPATH.'app/editor/simditor/';
 ?>

 <link rel="stylesheet" type="text/css" href="<?php echo $editpath;?>styles/simditor.css" />
<script type="text/javascript" src="<?php echo $editpath;?>scripts/module.js"></script>
<script type="text/javascript" src="<?php echo $editpath;?>scripts/hotkeys.js"></script> 
<script type="text/javascript" src="<?php echo $editpath;?>scripts//simditor.js"></script>
 
<script>
      var editor = new Simditor({
		  textarea: $('#simditor_id')
		  //optional options
		});
</script>
 



<div class="cgray">simditor编辑器：http://simditor.tower.im/ (图片上传已取消，请使用DM系统的上传图片功能。)</div> 

 

