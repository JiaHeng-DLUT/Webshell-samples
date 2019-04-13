<?php  
require_once HERE_ROOT.'mod_common/tpl_head.php';
 
if($usertype=='normal') require_once HERE_ROOT.'mod_common/tpl_header_normal.php';
else require_once HERE_ROOT.'mod_common/tpl_header_admin.php';
 
?>