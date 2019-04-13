
 <script type="text/javascript" src="<?php echo STAPATH;?>app/editor/ckeditor/ckeditor.js?v=accc256f"></script>

<textarea class="ckeditor form-control" id="editor1" name="despcontent" rows="10">
<?php  
echo $desp;
?>
</textarea>
<div class="" style="padding-top:30px"> 
	<span class="cgray">ckeditor编辑: http://ckeditor.com/</span>


	<br />
	说明：在ckeditor编辑器里， div和p和h2里不能有span。但p和h2里可以有strong或a
	<br />

	 
	1.<b class="cred">请不要直接从word或网页</b>里拷贝内容到编辑器内，请点击这个按钮<img src="../cssjs/img/pastetext2.png" alt="paste" />，然后将内容拷贝。2. 在有表格的情况下，光标不容易通过鼠标移到末尾。这时一直按住键盘上的<b class="cred">向下方向键</b>不放，见光标移到末尾后输入文字。
	3.按回车是分段，如果<b class="cred">shift+回车</b>，就是分行。
	4.如果图片要分行,则shift+回车，另外还要修改图片属性为左对齐；如果图片是分段，则直接按回车分段。
</div>


 <script>
 CKEDITOR.env.isCompatible = true;
 CKEDITOR.replace( 'editor1', {
    language: 'zh-cn',
    height:500,
    skin:'moonocolor'
    //uiColor: '#9AB8F3'
});


            </script>
