<?php
$title = '公共页面布局';
 
 require_once HERE_ROOT.'mod_common/tpl_header.php'; 
?>
 
 


<?php


$framesrc='../mod_layout/mod_layout.php?pid='.$curstyle.'&lang='.LANG.'&type=common&file=list';
	echo '<Iframe  id="iframepage"  src="'.$framesrc.'" width="100%" height="2000" scrolling="no" frameborder="0" onload="Javascript:SeIframeHeight(this)"></iframe>';


require_once HERE_ROOT.'mod_common/tpl_footer.php'; 
?>
