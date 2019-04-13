<?php
/*  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);


ifhave_lang(LANG);//TEST if have lang,if no ,then jump

$title='视频文件';




//-----------

require_once HERE_ROOT.'mod_common/tpl_header_iframe.php';

?>
<div class="musictitle">视频文件列表：</div>
<p>必须用英文字母或拼音，不能用中文</p>
<ul class="musicfile">
<?php

$filedir = STAROOT.'upload/video/';
 
 
        if(is_dir($filedir)){   

            $filearr = getFile($filedir); 
             
            //  pre($filearr);

                foreach ($filearr as $k => $v) {
                	if($v<>'index.php'){
			             ?>
			             <li>
						 <input   onclick="this.select();document.execCommand('Copy');" type="text" value="<?php echo $v?>" class="form-control" />
						 </li>
						    
			             <?php   
			             }                    
                }

        }

?>
</ul>

<style>
.musictitle{font-weight: bold;font-size: 14px}
.musicfile {clear: both;overflow: hidden;}
.musicfile li{ float: left;width: 200px;height: 30px;margin:5px; }
.musicfile input{border: 1px solid #ccc}
</style>


 <?php
require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php';

?>
