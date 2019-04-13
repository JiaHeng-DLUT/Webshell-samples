<?php //jump from config_a/func.previ.php
$mod_previ = 'other';//default is admin,and set in common.inc
require_once '../config_a/common.inc2010.php';
$title = '后台首页';
//
require_once HERE_ROOT.'mod_common/tpl_header_iframe.php';

?>
<div style="padding:200px;text-align:center;font-size:26px;font-weight:bold;color:red">
	

	对不起，你是普通管理员，没有权限进行此操作！
</div>
<?php

require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php';

 
?> 