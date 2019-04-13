<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
<div class="sidebarmenu">
<div class="sdheader"><?php echo decode($tag_title)?></div> 
 <?php 
block('prog_tag');
 ?> 
</div>
