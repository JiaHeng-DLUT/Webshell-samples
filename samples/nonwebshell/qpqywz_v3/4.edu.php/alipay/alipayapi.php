<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>支付宝即时到账交易接口接口</title>
</head>
<?php
/* *
 * 功能：即时到账交易接口接入页
 * 版本：3.4
 * 修改日期：2016-03*08
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************注意*****************
 
 *如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
 *1、开发文档中心（https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.KvddfJ&treeId=62&articleId=103740&docType=1）
 *2、商户帮助中心（https://cshall.alipay.com/enterprise/help_detail.htm?help_id=473888）
 *3、支持中心（https://support.open.alipay.com/alipay/support/index.htm）

 *如果想使用扩展功能,请按文档要求,自行添加到parameter数组即可。
 **********************************************
 */
require_once("../conn/conn2.php");
require_once("../conn/function.php");
ajax("pay","alipay");
?>
</body>
</html>