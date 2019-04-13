<?php
$config['name'] = '支付宝';
$config['type'] = 'alipay';
$config['desc'] = '即时到帐接口，买家交易金额直接转入卖家支付宝账户';
//$config['model']['alipay_name']['name'] = '支付宝账户';
//$config['model']['alipay_name']['type'] = 'text';
$config['model']['alipay_pid']['name'] = '合作者身份Pid';
$config['model']['alipay_pid']['type'] = 'text';
$config['model']['alipay_key']['name'] = '安全校验码Key';
$config['model']['alipay_key']['type'] = 'text';
$config['model']['alipay_appid']['name'] = '支付宝应用APPid';
$config['model']['alipay_appid']['type'] = 'text';
$config['model']['alipay_public_key']['name'] = '支付宝公钥';
$config['model']['alipay_public_key']['type'] = 'textarea';
$config['model']['alipay_my_private_key']['name'] = '开发者私钥';
$config['model']['alipay_my_private_key']['type'] = 'textarea';
return $config;
?>