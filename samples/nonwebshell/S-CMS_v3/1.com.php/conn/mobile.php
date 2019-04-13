<?php
//短信接口
//如果您有自己的接口可以通过修改此文件来实现
//参数说明 $content：短信内容 $receive：手机号码

function sendmobile($content,$receive){
global $C_userid,$C_codeid,$C_codekey;
getbody("http://dx.10691.net:8888/sms.aspx?action=send&userid=".$C_userid."&account=".$C_codeid."&password=".$C_codekey."&content=".urlencode($content)."&sendTime=&mobile=".$receive."&extno=","");
}
?>