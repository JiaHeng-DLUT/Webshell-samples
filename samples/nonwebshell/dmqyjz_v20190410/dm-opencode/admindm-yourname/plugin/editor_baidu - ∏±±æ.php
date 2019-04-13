<textarea id="container" name="despcontent" style="font-size:12px">
<?php  
echo $desp;
?>
  </textarea>

  </script>

       <!-- 配置文件 -->
    <script type="text/javascript" src="<?php echo STAPATH;?>app/editor/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="<?php echo STAPATH;?>app/editor/ueditor/ueditor.all.min.js"></script>
    <!-- 实例化编辑器 -->
 
    <script type="text/javascript">
      var homeurl = '<?php echo STAPATH.'app/editor/ueditor/'?>';   
        var ue = UE.getEditor('container', {
		    autoHeight: false, initialFrameWidth:1100,initialFrameHeight:420,UEDITOR_HOME_URL:homeurl,
		     allowDivTransToP: false
		 
		});
		 
 

    </script>
   <div class="cgray">百度编辑器： http://ueditor.baidu.com
<br />
    (如果用百度编辑器上传图片，图片在：根目录的/ueditor/php/upload/image/)</div> 

 