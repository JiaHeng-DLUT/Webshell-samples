<textarea id="container" name="despcontent" style="font-size:12px">
<?php  
echo $desp;
?>
  </textarea>


  <script type="text/javascript" charset="utf-8" src="<?php echo STAPATH;?>app/editor/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo STAPATH;?>app/editor/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="<?php echo STAPATH;?>app/editor/ueditor/lang/zh-cn/zh-cn.js"></script>

 
 

    <script type="text/javascript">
      var homeurl = '<?php echo STAPATH.'app/editor/ueditor/'?>';   
        var ue = UE.getEditor('container', {
        autoHeight: false, 
        initialFrameWidth:1200,initialFrameHeight:420,
        UEDITOR_HOME_URL:homeurl,
         allowDivTransToP: false
     
    });
     
 

    </script>

   <div class="cgray">百度编辑器： http://ueditor.baidu.com</div> 

 