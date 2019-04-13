
<textarea id="kindeditor_id" name="despcontent" style="width:100%;height:450px;">
<?php  
echo $desp;
?>
</textarea>
 
 	<link rel="stylesheet" href="<?php echo STAPATH;?>app/editor/kindeditor/themes/default/default.css" />
	<link rel="stylesheet" href="<?php echo STAPATH;?>app/editor/kindeditor/plugins/code/prettify.css" />
 

<script charset="utf-8" src="<?php echo STAPATH;?>app/editor/kindeditor/kindeditor-all.js"></script>
<script charset="utf-8" src="<?php echo STAPATH;?>app/editor/kindeditor/lang/zh_CN.js"></script>


	<script charset="utf-8" src="<?php echo STAPATH;?>app/editor/kindeditor/plugins/code/prettify.js"></script>


<script>
        KindEditor.ready(function(K) {
                window.editor = K.create('#kindeditor_id',{
                		// allowFileManager : true


                		cssPath : '<?php echo STAPATH;?>app/editor/kindeditor/plugins/code/prettify.css',
						uploadJson : '<?php echo STAPATH;?>app/editor/kindeditor/php/upload_json.php',
						fileManagerJson : '<?php echo STAPATH;?>app/editor/kindeditor/php/file_manager_json.php',
						allowFileManager : true,
						afterCreate : function() {
							var self = this;
							K.ctrl(document, 13, function() {
								self.sync();
								K('form[name=example]')[0].submit();
							});
							K.ctrl(self.edit.doc, 13, function() {
								self.sync();
								K('form[name=example]')[0].submit();
							});
						}



                });

                prettyPrint();


        });
</script>
 



<div class="cgray">kind编辑器： http://kindeditor.net </div> 

 

